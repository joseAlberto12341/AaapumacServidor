<?php

namespace App\Models;

use PDO;
use ReflectionClass;
use Exception;

class EntityModel
{
    protected $pdo;
    protected $table = "tbl";
    protected $alias = "t";
    private $sql;
    private $replaces;


    /*
    Cardinalidades:
        ManyToMany <-- Return array of objects
        OneToMany <-- Return array of objects
        ManyToOne <-- Return an object
        OneToOne <-- Return an object
    */
    public function connect()
    {
        $server = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHAR;
        $this->pdo = new PDO($server, DB_USER, DB_PASS);
        $this->pdo->setAttribute(PDO::ATTR_CASE, PDO::CASE_LOWER);
    }

    public function select($columns = '*', $filters = [], $onlyOne = false, $depth = NULL)
    {
        $this->sql = "SELECT $columns FROM $this->table AS $this->alias";
        $this->replaces = [];
        //permite agregar uno o varios JOINs dinámicamente a la consulta SQL que hacemos en el foreach
        if (isset($filters['join'])) {
            foreach ($filters['join'] as $join) {
                $this->sql .= " " . ($join['type'] ?? '') . "JOIN $join[table] ON $join[on]";
            }
        }
        if (isset($filters['where']))
            $this->sql .= " WHERE " . $filters['where'];
        if (isset($filters['group']))
            $this->sql .= " GROUP BY " . $filters['group'];
        if (isset($filters['having']))
            $this->sql .= " HAVING " . $filters['having'];
        if (isset($filters['order']))
            $this->sql .= " ORDER BY " . $filters['order'];
        if (isset($filters['limit']))
            $this->sql .= " LIMIT " . $filters['limit'];
        if (isset($filters['sql']))
            echo $this->sql . '<br>';

        $this->replaces = $filters['replaces'] ?? null;
        // echo $this->sql;        echo "<br>";        var_dump($filters['replaces']);die();
        return $this->execute(true, $onlyOne, $depth);
    }

    public function insert()
    {
        $columns = $this->getAttributes();
        $this->sql = "INSERT INTO $this->table SET $columns";
        $this->execute();
        $this->setRelations();
    }

    public function update($id, $setClause, $options) {
        // Si $setClause es un array, convertirlo a string SQL
        if (is_array($setClause)) {
            $setArray = [];
            $this->replaces = []; // Reiniciar replaces
            
            foreach ($setClause as $key => $value) {
                $token = ":$key";
                $setArray[] = "$key = $token";
                $this->replaces[$token] = $value;
            }
            $setClause = implode(', ', $setArray);
        }
        
        $this->sql = "UPDATE $this->table SET $setClause WHERE {$options['where']}";
        
        // Combinar los replaces del SET con los del WHERE
        if (isset($options['replaces']) && is_array($options['replaces'])) {
            $this->replaces = array_merge($this->replaces ?? [], $options['replaces']);
        }
        
        $this->replaces[":id"] = $id;
        $this->execute();
        $this->setRelations();
        
        return true;
    }

    public function delete()
    {
        $this->sql = "DELETE FROM $this->table WHERE id = :id";
        $this->replaces = [':id' => $this->getId()];
        $this->execute();
    }

    public function call($procedure, $replaces)
    {
        $this->sql = "CALL $procedure";
        $this->replaces = $replaces;
        $this->execute();
    }

    private function raw($sql, $replaces = null)
    {
        $this->connect();
        $stmt = $this->pdo->prepare($sql);
        $stmt->execute($replaces);
    }

    private function execute($fetch = false, $onlyOne = false, $depth = NULL)
    {
        $this->connect();
        $stmt = $this->pdo->prepare($this->sql);
        
        // Asegurarse de que replaces es un array antes de ejecutar
        $replaces = is_array($this->replaces) ? $this->replaces : [];
        $stmt->execute($replaces);

        if ($fetch) {
            // Usar FETCH_ASSOC y mapear manualmente para evitar propiedades dinámicas
            if ($onlyOne) {
                $data = $stmt->fetch(PDO::FETCH_ASSOC);
                if ($data) {
                    $item = $this->createInstanceWithData($data);
                    if ($item && method_exists($item, 'mapFiles')) {
                        $item->mapFiles($item);
                    }
                    // Verificar que $depth no sea null antes de decrementar
                    $newDepth = ($depth !== null) ? $depth - 1 : null;
                    return $this->mapRelations($item, $newDepth);
                }
                return null;
            } else {
                $collection = $stmt->fetchAll(PDO::FETCH_ASSOC);
                $result = [];
                foreach ($collection as $data) {
                    $item = $this->createInstanceWithData($data);
                    if ($item && method_exists($item, 'mapFiles')) {
                        $item->mapFiles($item);
                    }
                    // Verificar que $depth no sea null antes de decrementar
                    $newDepth = ($depth !== null) ? $depth - 1 : null;
                    $result[] = $this->mapRelations($item, $newDepth);
                }
                return $result;
            }
        }

        $generated_id = $this->pdo->lastInsertId();
        if ($generated_id) {
            $this->setId($generated_id);
        }
    }

    // Nuevo método para crear instancias con datos sin usar propiedades dinámicas
private function createInstanceWithData(array $data)
{
    $className = get_class($this);
    $object = new $className();
    
    foreach ($data as $key => $value) {
        // Intentar métodos setters primero (más confiable)
        $setterMethod = 'set' . $this->snakeToCamel($key, true); // true = capitalize first
        
        if (method_exists($object, $setterMethod)) {
            $object->$setterMethod($value);
            continue;
        }
        
        // Si no hay setter, intentar asignar propiedad directamente
        try {
            $reflection = new ReflectionClass($object);
            
            // Intentar con nombre original (snake_case)
            if ($reflection->hasProperty($key)) {
                $prop = $reflection->getProperty($key);
                if ($prop->isPublic() || $prop->isProtected()) {
                    $prop->setAccessible(true);
                    $prop->setValue($object, $value);
                    $prop->setAccessible(false);
                    continue;
                }
            }
            
            // Intentar con nombre camelCase
            $camelKey = $this->snakeToCamel($key);
            if ($reflection->hasProperty($camelKey)) {
                $prop = $reflection->getProperty($camelKey);
                if ($prop->isPublic() || $prop->isProtected()) {
                    $prop->setAccessible(true);
                    $prop->setValue($object, $value);
                    $prop->setAccessible(false);
                    continue;
                }
            }
            
        } catch (\Exception $e) {
            // Ignorar errores de asignación
            continue;
        }
    }
    
    return $object;
}

// Método auxiliar para convertir snake_case a camelCase
private function snakeToCamel($string, $capitalizeFirstCharacter = false)
{
    $str = str_replace('_', '', ucwords($string, '_'));
    
    if (!$capitalizeFirstCharacter) {
        $str = lcfirst($str);
    }
    
    return $str;
}
    // Método auxiliar para convertir snake_case a camelCase
    private function normalizePropertyName($name)
    {
        // Convertir snake_case a camelCase
        return lcfirst(str_replace('_', '', ucwords($name, '_')));
    }

    private function setId($id)
    {
        $reflection = new ReflectionClass($this);
        $attrId = $reflection->getProperty('id');
        $attrId->setAccessible(true);
        $attrId->setValue($this, $id);
        $attrId->setAccessible(false);
    }

    private function getAttributes()
    {
        $reflection = new ReflectionClass($this);
        $attributes = $reflection->getProperties();

        // Asegurarnos de que $this->replaces es un array
        if (!is_array($this->replaces)) {
            $this->replaces = [];
        }

        $attrs = array_filter($attributes, function ($attribute) {
            $name = $attribute->getName();
            $verify_method = 'set' . ucfirst($name);

            $annotations = $attribute->getDocComment();
            if (
                $annotations &&
                preg_match("/@(ManyToMany|OneToMany|ManyToOne|OneToOne|File)\((.+)\)/", $annotations, $matches)
            )
                return false;

            $source_class = $attribute->getDeclaringClass()->getName();
            $actual_class = get_class($this);

            $protected = $attribute->isProtected();

            return $source_class == $actual_class ||
                !$protected &&
                method_exists($this, $verify_method);

        });

        $query_array = [];
        foreach ($attrs as $attribute) {
            $name = $attribute->getName();
            $method = 'get' . ucfirst($name);
            
            // Verificar que el método existe y es callable
            if (!method_exists($this, $method)) {
                continue;
            }
            
            $token = ":$name";
            $this->replaces[$token] = $this->$method();
            $query_array[] = "$name = $token";
        }

        return implode(', ', $query_array);
    }

    private function setRelations()
    {
        $id = $this->getId();
        $reflection = new ReflectionClass($this);
        $attributes = $reflection->getProperties();

        foreach ($attributes as $attr) {
            $name = $attr->getName();
            $annotations = $attr->getDocComment();
            if (
                $annotations &&
                preg_match("/@(ManyToMany|OneToMany|ManyToOne|OneToOne)\((.+)\)/", $annotations, $matches)
            ) {
                $relationType = $matches[1];
                $relationAttr = $matches[2];

                $relationMethod = "insert" . $relationType . "Rows";
                $getter = 'get' . ucfirst($name);

                $this->$relationMethod($id, $relationAttr, $getter);
            }

            if (
                $annotations &&
                preg_match("/@File\((.+)\)/", $annotations, $matches)
            ) {
                $relationAttr = $matches[1];

                $relationMethod = "insert" . $relationType . "Rows";
                $setter = 'set' . ucfirst($name);

                $this->saveObjectFile($name, $id, $relationAttr, $setter);
            }
        }
    }

    private function saveObjectFile($name, $id, $relationAttrs, $setter)
    {
        $fileObject = $_FILES[$name] ?? null;
        $targetTable = $this->table;
        $joinColumn = $this->getRelationAttrsValue($relationAttrs, 'joinColumns', $name);
        $deleteList = $_POST['delete'] ?? [];
        $hasDelete = isset($deleteList[$name]);

        if ($hasDelete) {
            $this->sql = "UPDATE $targetTable SET $name = NULL WHERE id = :id";
            $this->replaces = [':id' => $id];
            $this->raw($this->sql, $this->replaces);
            return null;
        }

        if (is_null($fileObject))
            return null;

        $type = $this->getRelationAttrsValue($relationAttrs, 'type', 'file');
        $path = $this->getRelationAttrsValue($relationAttrs, 'path', '');
        $saveas = $this->getRelationAttrsValue($relationAttrs, 'saveas', DEFAULT_IMAGE_TYPE);
        $resize = $this->getRelationAttrsValue($relationAttrs, 'resize');
        $upload = UPLOADS . "/$path";

        if (!is_dir($upload))
            mkdir($upload, 0777, true);

        $newName = time() . '.' . $saveas;
        switch (true):
            case $type == 'image':
                $ans = $this->createImageFromGD(
                    $fileObject['tmp_name'],
                    $upload . '/' . $newName,
                    $saveas,
                    $resize
                );
                break;
            default:
                move_uploaded_file(
                    $fileObject['tmp_name'],
                    "$upload/$newName"
                );
                break;
        endswitch;

        if ($ans) {
            $this->sql = "UPDATE $targetTable SET $joinColumn = :fileName WHERE id = :id";
            $this->replaces = [
                ':fileName' => $newName,
                ':id' => $id
            ];
            $this->raw($this->sql, $this->replaces);
        }
    }

    private function createImageFromGD($source, $destination, $type, $resize)
    {
        $info = exif_imagetype($source);
        $image = null;
        $quality = 100;

        switch ($info):
            case IMAGETYPE_JPEG:
                $image = imagecreatefromjpeg($source);
                break;
            case IMAGETYPE_PNG:
                $image = imagecreatefrompng($source);
                break;
            case IMAGETYPE_GIF:
                $image = imagecreatefromgif($source);
                break;
            case IMAGETYPE_WEBP:
                $image = imagecreatefromwebp($source);
                break;
        endswitch;

        if ((int) phpversion() >= 8 && IMAGETYPE_AVIF == $info) {
            $image = imagecreatefromavif($source);
        }
        if (is_null($image))
            return null;

        $width = imagesx($image);
        $height = imagesy($image);
        $newWidth = (int) ($resize ?? imagesx($image));
        $newHeight = ($height / $width) * $newWidth;
        $copyImage = imagescale($image, $newWidth, $newHeight);
        imagesavealpha($copyImage, true);
        imagealphablending($copyImage, false);

        $saveFunction = null;

        switch ($type):
            case 'jpeg':
            case 'jpg':
                $saveFunction = 'imagejpeg';
                break;
            case 'png':
                $saveFunction = 'imagepng';
                $quality = 9;
                break;
            case 'gif':
                $saveFunction = 'imagegif';
                break;
            case 'webp':
                $saveFunction = 'imagewebp';
        endswitch;
        if ((int) phpversion() >= 8 && $type == $info)
            $saveFunction = 'imageavif';
        if (is_null($saveFunction))
            return null;

        $saveFunction($copyImage, $destination, $quality);
        imagedestroy($image);
        imagedestroy($copyImage);

        return true;
    }

    private function insertOnetoOneRows($id, $relationAttrs, $getter)
    {
        if (is_null($this->$getter()))
            return null;
        $targetEntity = $this->getRelationAttrsValue($relationAttrs, 'targetEntity');
        $targerNs = "\\App\\Models\\$targetEntity";
        $targetObject = new $targerNs();
        $targetTable = $targetObject->table;
        $targetAlias = $targetObject->alias;

        $thisTable = $this->table;
        $joinTable = $this->getRelationAttrsValue($relationAttrs, 'joinTable');

        $joinColumn = $this->getRelationAttrsValue($relationAttrs, 'joinColumns');
        $id_fk = $this->$getter()->getId();
        $id_where = $id;

        if (is_null($joinColumn)) {
            $joinColumn = $this->getRelationAttrsValue($relationAttrs, 'inversedJoinColumns');
            $id_fk = $id;
            $id_where = $this->$getter()->getId();
        }

        $primaryKey = $this->getRelationAttrsValue($relationAttrs, 'primaryKey');

        $this->sql = "UPDATE $targetTable SET $joinColumn = :id_fk WHERE id = :id_where";
        $this->replaces = [
            ':id_fk' => $id_fk,
            ':id_where' => $id_where
        ];
        $this->raw($this->sql, $this->replaces);
    }

    private function insertOnetoManyRows($id, $relationAttrs, $getter)
    {
        $ids = array_map(function ($item) {
            return $item->getId();
        }, $this->$getter());
        $tokens = array_map(function ($id) {
            return ":id_$id";
        }, $ids);
        $list_ids = implode(",", $tokens);
        $list_replaces = array_combine($tokens, $ids);
        $list_replaces[':id'] = $id;

        $targetEntity = $this->getRelationAttrsValue($relationAttrs, 'targetEntity');
        $targerNs = "\\App\\Models\\$targetEntity";
        $targetObject = new $targerNs();
        $targetTable = $targetObject->table;
        $targetAlias = $targetObject->alias;

        $thisTable = $this->table;
        $joinTable = $this->getRelationAttrsValue($relationAttrs, 'joinTable');
        $joinColumn = $this->getRelationAttrsValue($relationAttrs, 'joinColumns');
        $inversedJoinColumn = $this->getRelationAttrsValue($relationAttrs, 'inversedJoinColumns');
        $primaryKey = $this->getRelationAttrsValue($relationAttrs, 'primaryKey');

        $this->sql = "UPDATE $targetTable SET $joinColumn = NULL WHERE $joinColumn = :id";
        $this->raw($this->sql, [':id' => $id]);

        $this->sql = "UPDATE $targetTable SET $joinColumn = :id WHERE id IN ($list_ids)";
        $this->raw($this->sql, $list_replaces);
    }

    private function insertManytoOneRows($id, $relationAttrs, $getter)
    {
        $targetEntity = $this->getRelationAttrsValue($relationAttrs, 'targetEntity');
        $targerNs = "\\App\\Models\\$targetEntity";
        $targetObject = new $targerNs();
        $targetTable = $targetObject->table;
        $targetAlias = $targetObject->alias;

        $thisTable = $this->table;
        $joinTable = $this->getRelationAttrsValue($relationAttrs, 'joinTable');
        $joinColumn = $this->getRelationAttrsValue($relationAttrs, 'joinColumns');
        $inversedJoinColumn = $this->getRelationAttrsValue($relationAttrs, 'inversedJoinColumns');
        $primaryKey = $this->getRelationAttrsValue($relationAttrs, 'primaryKey');

        $targetId = $this->$getter()->getId();
        $this->sql = "UPDATE $thisTable SET $inversedJoinColumn = :targetId WHERE id = :id";
        $this->replaces = [':targetId' => $targetId, ':id' => $id];
        $this->execute();
    }

    private function insertManytoManyRows($id, $relationAttrs, $getter)
    {
        $targetEntity = $this->getRelationAttrsValue($relationAttrs, 'targetEntity');
        $targerNs = "\\App\\Models\\$targetEntity";
        $targetObject = new $targerNs();
        $targetTable = $targetObject->table;
        $targetAlias = $targetObject->alias;

        $joinTable = $this->getRelationAttrsValue($relationAttrs, 'joinTable');
        $joinColumn = $this->getRelationAttrsValue($relationAttrs, 'joinColumns');
        $inversedJoinColumn = $this->getRelationAttrsValue($relationAttrs, 'inversedJoinColumns');
        $primaryKey = $this->getRelationAttrsValue($relationAttrs, 'primaryKey');

        $items = $this->$getter();

        $this->sql = "DELETE FROM $joinTable WHERE $joinColumn = :id";
        $this->replaces = [':id' => $id];
        $this->raw($this->sql, $this->replaces);

        foreach ($items as $item):
            $targetId = $item->getId();
            $this->sql = "INSERT INTO $joinTable SET $joinColumn = :id, $inversedJoinColumn = :targetId";
            $this->replaces = [':id' => $id, ':targetId' => $targetId];
            $this->raw($this->sql, $this->replaces);
            $this->execute();
        endforeach;
    }

    private function mapFiles($item)
    {
        if (!$item)
            return null;
        $reflection = new ReflectionClass($item);
        $attributes = $reflection->getProperties();

        foreach ($attributes as $attr) {
            $name = $attr->getName();
            $annotations = $attr->getDocComment();
            if (
                $annotations &&
                preg_match("/@File\((.+)\)/", $annotations, $matches)
            ) {
                $relationAttr = $matches[1];
                $column = $this->getRelationAttrsValue($relationAttr, 'columns');
                $method = "set" . ucfirst($name);

                if ($column != $name) {
                    $item->$method($item->$column);
                }
            }
        }

        return $item;
    }

    private function mapRelations($item, $depth = 0)
    {
        if (!$item)
            return null;
        $id = $item->getId();
        $reflection = new ReflectionClass($item);
        $attributes = $reflection->getProperties();
        $rootEntity = is_null($depth);

        foreach ($attributes as $attr) {
            $name = $attr->getName();
            $annotations = $attr->getDocComment();
            if (
                $annotations &&
                preg_match("/@(ManyToMany|OneToMany|ManyToOne|OneToOne)\((.+)\)/", $annotations, $matches)
            ) {
                $relationType = $matches[1];
                $relationAttr = $matches[2];

                if ($rootEntity) {
                    preg_match("/@Depth\((\d+)\)/", $annotations, $matchesDepth);
                    $depth = $matchesDepth[1] ?? 1;
                }

                $relationMethod = 'get' . $relationType . 'Rows';

                $setter = 'set' . ucfirst($name);

                // var_dump($relationType, $relationAttr, $name, $depth, $annotations, $reflection, $relationMethod, $setter);die();

                if ($depth > 0) {
                    $item->$setter($this->$relationMethod($relationAttr, $id));
                }

                $this->$relationMethod($relationAttr, $id, $depth);
            }
        }

        return $item;
    }

    private function getManyToManyRows($relationAttrs, $id, $depth = 0)
    {
        $targetEntity = $this->getRelationAttrsValue($relationAttrs, 'targetEntity');
        $targerNs = "\\App\\Models\\$targetEntity";
        $targetObject = new $targerNs();
        $targetTable = $targetObject->table;
        $targetAlias = $targetObject->alias;

        $joinTable = $this->getRelationAttrsValue($relationAttrs, 'joinTable');
        $joinColumn = $this->getRelationAttrsValue($relationAttrs, 'joinColumns');
        $inversedJoinColumn = $this->getRelationAttrsValue($relationAttrs, 'inversedJoinColumns');
        $primaryKey = $this->getRelationAttrsValue($relationAttrs, 'primaryKey');

        $filters = [
            'join' => [
                [
                    'table' => "$joinTable as __joinTable",
                    'on' => "__joinTable.$joinColumn = $targetAlias.id"
                ]
            ],
            'where' => "__joinTable.$inversedJoinColumn = :id",
            'replaces' => [':id' => $id],
            'sql' => true,
        ];
        return $targetObject->select("$targetAlias.*", $filters, false, $depth);
    }

    private function getManyToOneRows($relationAttrs, $id, $depth = 0)
    {
        $targetEntity = $this->getRelationAttrsValue($relationAttrs, 'targetEntity');
        $targerNs = "\\App\\Models\\$targetEntity";
        $targetObject = new $targerNs();
        $targetTable = $targetObject->table;
        $targetAlias = $targetObject->alias;

        $thisTable = $this->table;
        $joinTable = $this->getRelationAttrsValue($relationAttrs, 'joinTable');
        $joinColumn = $this->getRelationAttrsValue($relationAttrs, 'joinColumns');
        $inversedJoinColumn = $this->getRelationAttrsValue($relationAttrs, 'inversedJoinColumns');
        $primaryKey = $this->getRelationAttrsValue($relationAttrs, 'primaryKey');

        $filters = [
            'join' => [
                [
                    'table' => "$thisTable as __joinTable",
                    'on' => "__joinTable.$inversedJoinColumn = $targetAlias.id"
                ]
            ],
            'where' => "__joinTable.id = :id",
            'sql' => true,
        ];
        return $targetObject->select("$targetAlias.*", $filters, true, $depth);
    }

    private function getOneToManyRows($relationAttrs, $id, $depth = 0)
    {
        $targetEntity = $this->getRelationAttrsValue($relationAttrs, 'targetEntity');
        $targerNs = "\\App\\Models\\$targetEntity";
        $targetObject = new $targerNs();
        $targetTable = $targetObject->table;
        $targetAlias = $targetObject->alias;

        $thisTable = $this->table;
        $joinTable = $this->getRelationAttrsValue($relationAttrs, 'joinTable');
        $joinColumn = $this->getRelationAttrsValue($relationAttrs, 'joinColumns');
        $inversedJoinColumn = $this->getRelationAttrsValue($relationAttrs, 'inversedJoinColumns');
        $primaryKey = $this->getRelationAttrsValue($relationAttrs, 'primaryKey');

        $filters = [
            'where' => "$targetAlias.$joinColumn = :id",
            'replaces' => [':id' => $id],
            'sql' => true,
        ];
        return $targetObject->select("$targetAlias.*", $filters, false, $depth);
    }

    private function getOneToOneRows($relationAttrs, $id, $depth = 0)
    {
        $targetEntity = $this->getRelationAttrsValue($relationAttrs, 'targetEntity');
        $targetNs = "\\App\\Models\\$targetEntity";
        $targetObject = new $targetNs();
        $targetTable = $targetObject->table;
        $targetAlias = $targetObject->alias;

        $thisTable = $this->table;
        $joinTable = $this->getRelationAttrsValue($relationAttrs, 'joinTable', $thisTable);
        $joinColumn = $this->getRelationAttrsValue($relationAttrs, 'joinColumns', 'id');
        $inversedJoinColumn = $this->getRelationAttrsValue($relationAttrs, 'inversedJoinColumns', 'id');
        $primaryKey = $this->getRelationAttrsValue($relationAttrs, 'primaryKey', 'id');

        /* if (!$targetEntity || !$joinColumn || !$inversedJoinColumn || !$primaryKey) {
            throw new Exception("joinTable, joinColumns, inversedJoinColumns o primaryKey no encontrados en los atributos de relación.");
        } */

        $filters = [
            'join' => [
                [
                    'table' => "$joinTable as __joinTable",
                    'on' => "__joinTable.$inversedJoinColumn = $targetAlias.$joinColumn"
                ]
            ],
            'where' => "__joinTable.$primaryKey = $id",
            'sql' => true,
        ];

        return $targetObject->select("$targetAlias.*", $filters, true, $depth);
    }

    private function getRelationAttrsValue($attrs, $attr, $default = null)
    {
        preg_match("/$attr=\"([^\"]+)\"/", $attrs, $matches);
        return $matches[1] ?? $default;
    }
}