<?php
namespace App\Repositories;

use PDO;

class NotificationRepository
{
    private static function connect()
    {
        $server = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHAR;
        $pdo = new PDO($server, DB_USER, DB_PASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    }

    /**
     * Contar notificaciones no leídas de un usuario
     */
    public static function contarNoLeidas($user_id)
    {
        try {
            $pdo = self::connect();
            
            // CORRECTO: usar id_user (según tus logs)
            $sql = "SELECT COUNT(*) as total FROM aaanotifications 
                    WHERE id_user = :user_id AND is_read = 0";
            
            error_log("=== contarNoLeidas: Usuario {$user_id} ===");
            
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':user_id' => $user_id]);
            
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            $total = $result['total'] ?? 0;
            
            error_log("=== contarNoLeidas resultado: {$total} ===");
            
            return $total;
            
        } catch (\Exception $e) {
            error_log(" Error en contarNoLeidas: " . $e->getMessage());
            return 0;
        }
    }

    /**
     * Obtener notificaciones del usuario
     */
    public static function getNotificacionesUsuario($user_id, $limit = 20)
    {
        try {
            $pdo = self::connect();
            
            // CORRECTO: usar id_user (según tus logs)
            $sql = "SELECT * FROM aaanotifications 
                    WHERE id_user = :user_id 
                    ORDER BY created_at DESC 
                    LIMIT :limit";
            
            error_log("=== getNotificacionesUsuario: Usuario {$user_id} ===");
            
            $stmt = $pdo->prepare($sql);
            $stmt->bindValue(':user_id', $user_id, PDO::PARAM_INT);
            $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
            $stmt->execute();
            
            $resultados = $stmt->fetchAll(PDO::FETCH_OBJ);
            
            error_log("=== getNotificacionesUsuario resultados: " . count($resultados) . " ===");
            
            return $resultados;
            
        } catch (\Exception $e) {
            error_log(" Error en getNotificacionesUsuario: " . $e->getMessage());
            return [];
        }
    }

    /**
     * Marcar notificación como leída
     */
    public static function marcarComoLeida($notificacion_id)
    {
        try {
            $pdo = self::connect();
            
            $sql = "UPDATE aaanotifications SET is_read = 1 WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            return $stmt->execute([':id' => $notificacion_id]);
            
        } catch (\Exception $e) {
            error_log("Error en marcarComoLeida: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Marcar todas como leídas
     */
    public static function marcarTodasLeidas($user_id)
    {
        try {
            $pdo = self::connect();
            
            // CORRECTO: usar id_user (según tus logs)
            $sql = "UPDATE aaanotifications SET is_read = 1 WHERE id_user = :user_id";
            $stmt = $pdo->prepare($sql);
            return $stmt->execute([':user_id' => $user_id]);
            
        } catch (\Exception $e) {
            error_log("Error en marcarTodasLeidas: " . $e->getMessage());
            return false;
        }
    }

    /**
     * Crear una nueva notificación
     */
    public static function crearNotificacion($user_id, $titulo, $mensaje, $tipo = null, $id_related_record = null)
    {
        try {
            $pdo = self::connect();
            
            error_log("=== crearNotificacion - Usuario: {$user_id}, Título: {$titulo} ===");
            
            // Verificar si tiene columna 'tipo'
            $sql_check = "SHOW COLUMNS FROM aaanotifications LIKE 'tipo'";
            $stmt_check = $pdo->query($sql_check);
            $tiene_tipo = $stmt_check->fetch();
            
            if ($tiene_tipo && $tipo !== null) {
                // Si tiene columna tipo y se proporciona tipo
                $sql = "INSERT INTO aaanotifications 
                        (id_user, title, message, tipo, id_related_record, is_read, created_at) 
                        VALUES (:id_user, :title, :message, :tipo, :id_related_record, 0, NOW())";
                
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    ':id_user' => $user_id,
                    ':title' => $titulo,
                    ':message' => $mensaje,
                    ':tipo' => $tipo,
                    ':id_related_record' => $id_related_record
                ]);
            } else {
                // Si NO tiene columna tipo o no se proporciona tipo
                $sql = "INSERT INTO aaanotifications 
                        (id_user, title, message, id_related_record, is_read, created_at) 
                        VALUES (:id_user, :title, :message, :id_related_record, 0, NOW())";
                
                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    ':id_user' => $user_id,
                    ':title' => $titulo,
                    ':message' => $mensaje,
                    ':id_related_record' => $id_related_record
                ]);
            }
            
            $id = $pdo->lastInsertId();
            error_log(" Notificación creada. ID: {$id}");
            
            return $id;
            
        } catch (\Exception $e) {
            error_log(" Error en crearNotificacion: " . $e->getMessage());
            return false;
        }
    }
}