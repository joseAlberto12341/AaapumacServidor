<?php
namespace App\Repositories;

use App\Models\asociadoCoordinadorModel;
use App\Models\InformacionGeneralModel;
use PDO;

class AsociadoCoordinadorRepository
{
    private static function connect()
    {
        $server = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHAR;
        $pdo = new PDO($server, DB_USER, DB_PASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    }

    public static function listempleados()
    {
        try {
            $pdo = self::connect();
            $sql = "SELECT id, username, email, id_role, id_status, created_at 
                    FROM aaausers 
                    WHERE id_role = :role";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':role' => 9]);
            
            return $stmt->fetchAll(PDO::FETCH_OBJ);
            
        } catch (\Exception $e) {
            error_log("Error en listempleados: " . $e->getMessage());
            return [];
        }
    }

    public static function nuevoPersonal()
    {
        return new asociadoCoordinadorModel();
    }

    /**
     * OBTIENE UN USUARIO POR SU ID
     */
    public static function getPersonalById($user_id)
    {
        try {
            $pdo = self::connect();
            $sql = "SELECT id, username, email, id_role, id_status, created_at 
                    FROM aaausers 
                    WHERE id = :id AND id_role = :role";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':id' => $user_id, ':role' => 9]);
            
            $result = $stmt->fetch(PDO::FETCH_OBJ);
            
            if ($result) {
                $personal = new asociadoCoordinadorModel();
                $personal->loadFromArray((array)$result);
                return $personal;
            }
            
            return null;
            
        } catch (\Exception $e) {
            error_log("Error en getPersonalById: " . $e->getMessage());
            return null;
        }
    }

    /**
     * CREAR NUEVO USUARIO
     */
    public static function setPersonal($personal, array $data)
    {
        try {
            $pdo = self::connect();
            
            $sql = "INSERT INTO aaausers (username, password, email, id_role, id_status) 
                    VALUES (:username, :password, :email, 9, :id_status)";
            
            $stmt = $pdo->prepare($sql);
            $result = $stmt->execute([
                ':username' => $data['username'],
                ':password' => $data['password'],
                ':email' => $data['email'],
                ':id_status' => $data['id_status']
            ]);
            
            if ($result) {
                return true;
            }
            
            return false;
            
        } catch (\Exception $e) {
            error_log("Error en setPersonal: " . $e->getMessage());
            return false;
        }
    }

    /**
     * ACTUALIZAR USUARIO
     */
    public static function updatePersonal($user_id, array $data)
    {
        try {
            $pdo = self::connect();
            
            $sql = "UPDATE aaausers SET ";
            $params = [];
            
            if (isset($data['username'])) {
                $sql .= "username = :username, ";
                $params[':username'] = $data['username'];
            }
            if (isset($data['email'])) {
                $sql .= "email = :email, ";
                $params[':email'] = $data['email'];
            }
            if (isset($data['password'])) {
                $sql .= "password = :password, ";
                $params[':password'] = $data['password'];
            }
            if (isset($data['id_status'])) {
                $sql .= "id_status = :id_status, ";
                $params[':id_status'] = $data['id_status'];
            }
            
            $sql .= "id_role = 9 WHERE id = :id";
            $params[':id'] = $user_id;
            
            $sql = str_replace(", WHERE", " WHERE", $sql);
            
            $stmt = $pdo->prepare($sql);
            return $stmt->execute($params);
            
        } catch (\Exception $e) {
            error_log("Error en updatePersonal: " . $e->getMessage());
            return false;
        }
    }

    /**
     * GUARDAR INFORMACIÓN GENERAL
     */
    public static function guardarInformacionGeneral(array $data)
    {
        try {
            // Verificar que el usuario existe
            $usuarioExiste = self::verificarUsuarioExiste($data['user_id']);
            if (!$usuarioExiste) {
                return false;
            }
            
            $pdo = self::connect();
            $created_by = $_SESSION['id_user'] ?? 1;
            
            // Verificar si ya existe información
            $existente = self::obtenerInformacionGeneral($data['user_id']);
            
            if ($existente) {
                $sql = "UPDATE informacion_general SET 
                        patente = :patente, 
                        agente_aduanal = :agente_aduanal, 
                        razon_social = :razon_social, 
                        telefono = :telefono, 
                        nombre_completo = :nombre_completo, 
                        correo_electronico = :correo_electronico, 
                        agencia_aduanal = :agencia_aduanal, 
                        fecha = :fecha 
                        WHERE user_id = :user_id";
                
                $params = [
                    ':patente' => $data['patente'],
                    ':agente_aduanal' => $data['agente_aduanal'],
                    ':razon_social' => $data['razon_social'],
                    ':telefono' => $data['telefono'],
                    ':nombre_completo' => $data['nombre_completo'],
                    ':correo_electronico' => $data['correo_electronico'],
                    ':agencia_aduanal' => $data['agencia_aduanal'],
                    ':fecha' => $data['fecha'],
                    ':user_id' => $data['user_id']
                ];
                
                $stmt = $pdo->prepare($sql);
                return $stmt->execute($params);
                
            } else {
                $sql = "INSERT INTO informacion_general 
                        (user_id, patente, agente_aduanal, razon_social, telefono, nombre_completo, correo_electronico, agencia_aduanal, fecha, created_by) 
                        VALUES 
                        (:user_id, :patente, :agente_aduanal, :razon_social, :telefono, :nombre_completo, :correo_electronico, :agencia_aduanal, :fecha, :created_by)";
                
                $params = [
                    ':user_id' => $data['user_id'],
                    ':patente' => $data['patente'],
                    ':agente_aduanal' => $data['agente_aduanal'],
                    ':razon_social' => $data['razon_social'],
                    ':telefono' => $data['telefono'],
                    ':nombre_completo' => $data['nombre_completo'],
                    ':correo_electronico' => $data['correo_electronico'],
                    ':agencia_aduanal' => $data['agencia_aduanal'],
                    ':fecha' => $data['fecha'],
                    ':created_by' => $created_by
                ];
                
                $stmt = $pdo->prepare($sql);
                return $stmt->execute($params);
            }
            
        } catch (\Exception $e) {
            error_log("Error en guardarInformacionGeneral: " . $e->getMessage());
            return false;
        }
    }

    /**
     * VERIFICAR QUE USUARIO EXISTE
     */
    private static function verificarUsuarioExiste($user_id)
    {
        try {
            $pdo = self::connect();
            $sql = "SELECT COUNT(*) as total FROM aaausers WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':id' => $user_id]);
            
            $result = $stmt->fetch(PDO::FETCH_OBJ);
            return $result && $result->total > 0;
            
        } catch (\Exception $e) {
            error_log("Error en verificarUsuarioExiste: " . $e->getMessage());
            return false;
        }
    }

    /**
     * OBTENER INFORMACIÓN GENERAL
     */
    public static function obtenerInformacionGeneral($user_id)
    {
        try {
            $pdo = self::connect();
            $sql = "SELECT * FROM informacion_general WHERE user_id = :user_id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':user_id' => $user_id]);
            
            $result = $stmt->fetch(PDO::FETCH_OBJ);
            
            if ($result) {
                $model = new InformacionGeneralModel();
                $model->loadFromArray((array)$result);
                return $model;
            }
            
            return null;
            
        } catch (\Exception $e) {
            error_log("Error en obtenerInformacionGeneral: " . $e->getMessage());
            return null;
        }
    }

    public static function existeInformacionGeneral($user_id)
    {
        try {
            $pdo = self::connect();
            $sql = "SELECT COUNT(*) as total FROM informacion_general WHERE user_id = :user_id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':user_id' => $user_id]);
            
            $result = $stmt->fetch(PDO::FETCH_OBJ);
            return $result && $result->total > 0;
            
        } catch (\Exception $e) {
            error_log("Error en existeInformacionGeneral: " . $e->getMessage());
            return false;
        }
    }

    /**
     * VERIFICA SI EL EMAIL YA EXISTE
     */
    public static function emailExiste($email, $excludeUserId = null)
    {
        try {
            $pdo = self::connect();
            $sql = "SELECT COUNT(*) as total FROM aaausers WHERE email = :email";
            $params = [':email' => $email];
            
            if ($excludeUserId) {
                $sql .= " AND id != :exclude_id";
                $params[':exclude_id'] = $excludeUserId;
            }
            
            $stmt = $pdo->prepare($sql);
            $stmt->execute($params);
            
            $result = $stmt->fetch(PDO::FETCH_OBJ);
            return $result && $result->total > 0;
            
        } catch (\Exception $e) {
            error_log("Error en emailExiste: " . $e->getMessage());
            return false;
        }
    }
}