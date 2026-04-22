<?php

namespace App\Repositories;

use App\Models\ModalModel;
use PDO;

class callacenterRepository
{
    public static function getModalList($page = 1, $perPage = 10, $search = '')
    {
        $modal = new ModalModel();

        $page = max(1, (int) $page);
        $perPage = max(1, min(100, (int) $perPage));
        $offset = ($page - 1) * $perPage;

        $filters = [
            'order' => 'created_at DESC',
            'limit' => $offset . ', ' . $perPage,
        ];

        if ($search !== '') {
            $filters['where'] = '(title LIKE :search OR description LIKE :search)';
            $filters['replaces'] = [':search' => '%' . $search . '%'];
        }

        return $modal->select(
            'id, title, description, image, archivo, created_at, visible',
            $filters,
            false
        );
    }
    //Listado de avisos de los 50 ultimos para el asociado comun
    public static function getModalListAsociado()
    {
        $modal = new ModalModel();

        return $modal->select(
            'id, title, description, image, archivo, created_at, visible',
            [
                'order' => 'created_at DESC',
                'limit' => '0, 50'  
            ],
            false
        );  
    }

    public static function countActiveAvisos()
    {
        $modal = new ModalModel();
        $result = $modal->select(
            'COUNT(*) as total',
            [
                'where' => 'visible = 1',
            ],
            true
        );
        return $result ? $result->getTotal() : 0;
    }

    public static function countAvisos($search = '')
    {
        $modal = new ModalModel();

        $filters = [];
        if ($search !== '') {
            $filters['where'] = '(title LIKE :search OR description LIKE :search)';
            $filters['replaces'] = [':search' => '%' . $search . '%'];
        }

        $result = $modal->select(
            'COUNT(*) as total',
            $filters,
            true
        );
        return $result ? $result->getTotal() : 0;
    }


    public static function findAviso($id)
    {
        $aviso = new ModalModel();
        return $aviso->select('*', [
            'where' => 'id = :id',
            'replaces' => [':id' => $id],
        ], true);
    }

    public static function addAviso()
    {
        return new ModalModel();
    }

    public static function setAviso(ModalModel $aviso, array $data)
    {
        if (isset($data['title'])) {
            $aviso->setTitle($data['title']);
        }
        if (isset($data['description'])) {
            $aviso->setDescription($data['description']);
        }
        if (isset($data['image'])) {
            $aviso->setImage($data['image']);
        }
        if (isset($data['archivo'])) { // Cambiado de file a archivo
            $aviso->setArchivo($data['archivo']);
        }
        if (isset($data['visible'])) {
            $aviso->setVisible($data['visible']);
        }
        if (isset($data['created_at'])) {
            $aviso->setCreatedAt($data['created_at']);
        }
        if (isset($data['updated_at'])) {
            $aviso->setUpdatedAt($data['updated_at']);
        }
        $aviso->insert();
    }

    public static function updateAviso($id, array $data)
    {
        $aviso = new ModalModel();

        // Buscar el aviso existente
        $existingAviso = $aviso->select('*', [
            'where' => 'id = :id',
            'replaces' => [':id' => $id],
        ], true);

        if (!$existingAviso) {
            return false;
        }

        // Preparar datos para actualización
        $updateData = [];

        if (isset($data['title'])) {
            $existingAviso->setTitle($data['title']);
            $updateData['title'] = $existingAviso->getTitle();
        }
        if (isset($data['description'])) {
            $existingAviso->setDescription($data['description']);
            $updateData['description'] = $existingAviso->getDescription();
        }
        if (isset($data['image'])) {
            $existingAviso->setImage($data['image']);
            $updateData['image'] = $existingAviso->getImage();
        }
        if (isset($data['archivo'])) { // Cambiado de file a archivo
            $existingAviso->setArchivo($data['archivo']);
            $updateData['archivo'] = $existingAviso->getArchivo();
        }

        if (isset($data['visible'])) {
            $existingAviso->setVisible($data['visible']);
            $updateData['visible'] = $existingAviso->getVisible();

            // Si está activando (0 → 1), reiniciar created_at
            if ($existingAviso->getVisible() == 1) {
                $updateData['created_at'] = date('Y-m-d H:i:s');
            }
        }

        // Siempre actualizar updated_at
        $updateData['updated_at'] = date('Y-m-d H:i:s');

        return $existingAviso->update($id, $updateData, [
            'where' => 'id = :id',
            'replaces' => [':id' => $id]
        ]);
    }

    public static function changeAvisoStatus($id, $visible)
    {
        $aviso = new ModalModel();

        $existingAviso = $aviso->select('*', [
            'where' => 'id = :id',
            'replaces' => [':id' => $id],
        ], true);

        if (!$existingAviso) {
            return false;
        }

        $currentTime = date('Y-m-d H:i:s');
        $updateData = [
            'visible' => $visible,
            'updated_at' => $currentTime
        ];

        if ($existingAviso->getVisible() == 0 && $visible == 1) {
            $updateData['created_at'] = $currentTime;
        }

        return $aviso->update($id, $updateData, [
            'where' => 'id = :id',
            'replaces' => [':id' => $id]
        ]);
    }

    public static function updateDates($id, array $dateData)
    {
        $aviso = new ModalModel();

        $whereClause = 'id = :id';
        $replaces = [':id' => $id];

        $updateData = [];
        if (isset($dateData['created_at'])) {
            $updateData['created_at'] = $dateData['created_at'];
        }
        if (isset($dateData['updated_at'])) {
            $updateData['updated_at'] = $dateData['updated_at'];
        }

        if (empty($updateData)) {
            return false;
        }

        return $aviso->update($id, $updateData, [
            'where' => $whereClause,
            'replaces' => $replaces
        ]);
    }
}
