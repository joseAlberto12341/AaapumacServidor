<?php
namespace App\Repositories;

use PDO;

class GestionRepository
{
    private static function connect()
    {
        $server = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHAR;
        $pdo = new PDO($server, DB_USER, DB_PASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    }

    public static function getFoliosAjax()
    {
        try {
            $pdo = self::connect();

            $sql = "SELECT 
                        id, 
                        user_id, 
                        folio, 
                        Token, 
                        patente, 
                        nombre_completo, 
                        Estatus, 
                        fecha, 
                        Hora, 
                        total_pedimentos, 
                        pdf_generado, 
                        pdf_filename, 
                        folios_aduana,
                        agente_aduanal, 
                        razon_social, 
                        telefono, 
                        correo_electronico,
                        agencia_aduanal, 
                        created_at, 
                        updated_at 
                    FROM folio_pedimento 
                    WHERE total_pedimentos > 0 
                    AND Estatus = '1'
                    AND (folios_aduana IS NULL OR folios_aduana = '')
                    ORDER BY created_at DESC
                    LIMIT 100";

            $stmt = $pdo->prepare($sql);
            $stmt->execute();

            $result = $stmt->fetchAll(PDO::FETCH_OBJ);

            $foliosArray = [];
            foreach ($result as $pedimento) {
                $foliosArray[] = [
                    'id' => (int) $pedimento->id,
                    'user_id' => (int) $pedimento->user_id,
                    'Token' => $pedimento->Token ?? '',
                    'patente' => $pedimento->patente ?? '',
                    'nombre_completo' => $pedimento->nombre_completo ?? '',
                    'Estatus' => $pedimento->Estatus ?? '1',
                    'fecha' => $pedimento->fecha ?? '',
                    'Hora' => $pedimento->Hora ?? '',
                    'folio' => $pedimento->folio ?? '',
                    'folios_aduana' => $pedimento->folios_aduana ?? '',
                    'agente_aduanal' => $pedimento->agente_aduanal ?? '',
                    'razon_social' => $pedimento->razon_social ?? '',
                    'telefono' => $pedimento->telefono ?? '',
                    'correo_electronico' => $pedimento->correo_electronico ?? '',
                    'agencia_aduanal' => $pedimento->agencia_aduanal ?? '',
                    'created_at' => $pedimento->created_at ?? '',
                    'updated_at' => $pedimento->updated_at ?? '',
                    'total_pedimentos' => $pedimento->total_pedimentos ?? 0,
                    'pdf_generado' => $pedimento->pdf_generado ?? false,
                    'pdf_filename' => $pedimento->pdf_filename ?? ''
                ];
            }

            return $foliosArray;

        } catch (\Exception $e) {
            error_log("ERROR en getFoliosAjax Repository: " . $e->getMessage());
            return [];
        }
    }

    public static function addfolios()
    {
        try {
            $pdo = self::connect();
            $sql = "SELECT id, user_id, folio, Token, patente, nombre_completo, Estatus, fecha, Hora, 
                           total_pedimentos, pdf_generado, pdf_filename, folios_aduana,
                           agente_aduanal, razon_social, telefono, correo_electronico,
                           agencia_aduanal, created_at, updated_at 
                    FROM folio_pedimento 
                    WHERE total_pedimentos > 0 
                    AND (folios_aduana IS NULL OR folios_aduana = '')
                    ORDER BY created_at DESC";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_OBJ);

        } catch (\Exception $e) {
            error_log("Error en addfolios: " . $e->getMessage());
            return [];
        }
    }

    public static function insertarFolio($pedimento_id, $folio_aduana)
    {
        try {
            $pdo = self::connect();

            $sql_check = "SELECT id, user_id, folio, Token, folios_aduana, Estatus FROM folio_pedimento WHERE id = :pedimento_id";
            $stmt_check = $pdo->prepare($sql_check);
            $stmt_check->bindParam(':pedimento_id', $pedimento_id, PDO::PARAM_INT);
            $stmt_check->execute();
            $pedimento = $stmt_check->fetch(PDO::FETCH_OBJ);

            if (!$pedimento) {
                return [
                    'success' => false,
                    'message' => 'El pedimento no existe'
                ];
            }

            $folio_anterior = $pedimento->folios_aduana ?? '';
            $accion = (!empty($folio_anterior)) ? 'actualizado' : 'asignado';

            $sql_update = "UPDATE folio_pedimento 
                           SET folios_aduana = :folio_aduana,
                               Estatus = '2',
                               updated_at = NOW() 
                           WHERE id = :pedimento_id";
            $stmt = $pdo->prepare($sql_update);
            $stmt->bindParam(':folio_aduana', $folio_aduana, PDO::PARAM_STR);
            $stmt->bindParam(':pedimento_id', $pedimento_id, PDO::PARAM_INT);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                $notificacion_id = self::crearNotificacionFolioAduana($pedimento, $folio_aduana, $accion);

                self::registrarLog(
                    $pedimento->user_id,
                    "Folio aduana {$folio_aduana} {$accion} para folio {$pedimento->folio}. " .
                    "Folio anterior: " . ($folio_anterior ?: 'Ninguno')
                );

                return [
                    'success' => true,
                    'message' => 'Folio ' . $accion . ' correctamente y estatus cambiado a Aduana',
                    'action' => $accion,
                    'user_id_asociado' => $pedimento->user_id,
                    'folio_anterior' => $folio_anterior,
                    'folio_nuevo' => $folio_aduana,
                    'notificacion_creada' => $notificacion_id
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'No se pudo actualizar el folio'
                ];
            }

        } catch (\Exception $e) {
            error_log("Error en insertarFolio: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Error al insertar folio: ' . $e->getMessage()
            ];
        }
    }

    private static function crearNotificacionFolioAduana($pedimento, $folio_aduana, $accion)
    {
        try {
            $pdo = self::connect();

            $titulo = ($accion == 'asignado') ? 'Folio Aduana Asignado' : 'Folio Aduana Actualizado';

            $mensaje = "Se ha {$accion} el folio aduana: <strong>{$folio_aduana}</strong> " .
                "a tu folio: <strong>{$pedimento->folio}</strong>";

            if (!empty($pedimento->Token)) {
                $mensaje .= " (Token: {$pedimento->Token})";
            }

            $sql = "INSERT INTO aaanotifications 
                    (id_user, title, message, tipo, id_related_record, is_read, created_at) 
                    VALUES (:id_user, :title, :message, :tipo, :related_id, 0, NOW())";

            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':id_user' => $pedimento->user_id,
                ':title' => $titulo,
                ':message' => $mensaje,
                ':tipo' => 'folio_aduana',
                ':related_id' => $pedimento->id
            ]);

            $notificacion_id = $pdo->lastInsertId();

            error_log(" Notificación creada exitosamente. ID: {$notificacion_id}, Usuario: {$pedimento->user_id}, is_read: 0");

            return $notificacion_id;

        } catch (\Exception $e) {
            error_log(" Error al crear notificación: " . $e->getMessage());
            return false;
        }
    }

    private static function registrarLog($user_id, $descripcion)
    {
        try {
            $pdo = self::connect();

            $sql_check = "SELECT id FROM aaaactions WHERE name = 'gestion_folio' LIMIT 1";
            $stmt_check = $pdo->prepare($sql_check);
            $stmt_check->execute();
            $accion = $stmt_check->fetch(PDO::FETCH_OBJ);

            if (!$accion) {
                error_log(" No se encontró la acción 'gestion_folio'");

                $sql = "INSERT INTO aaalog 
                        (id_user, description, ip_address, user_agent, created_at) 
                        VALUES (:user_id, :description, :ip_address, :user_agent, NOW())";

                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    ':user_id' => $user_id,
                    ':description' => $descripcion,
                    ':ip_address' => $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1',
                    ':user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'CLI'
                ]);
            } else {
                $sql = "INSERT INTO aaalog 
                        (id_user, id_action, id_status, description, ip_address, user_agent, created_at) 
                        VALUES (:user_id, 
                               :id_action,
                               1, 
                               :description, 
                               :ip_address, 
                               :user_agent,
                               NOW())";

                $stmt = $pdo->prepare($sql);
                $stmt->execute([
                    ':user_id' => $user_id,
                    ':id_action' => $accion->id,
                    ':description' => $descripcion,
                    ':ip_address' => $_SERVER['REMOTE_ADDR'] ?? '127.0.0.1',
                    ':user_agent' => $_SERVER['HTTP_USER_AGENT'] ?? 'CLI'
                ]);
            }

            return $pdo->lastInsertId();

        } catch (\Exception $e) {
            error_log("Error en registrarLog: " . $e->getMessage());
            return false;
        }
    }

    public static function Folioaduana()
    {
        try {
            $pdo = self::connect();
            $sql = "SELECT id, folio, Token, patente, nombre_completo, Estatus, fecha, Hora, 
                       total_pedimentos, pdf_generado, pdf_filename, folios_aduana,
                       agente_aduanal, razon_social, telefono, correo_electronico,
                       agencia_aduanal, created_at, updated_at 
                FROM folio_pedimento 
                WHERE total_pedimentos > 0 
                AND folios_aduana IS NOT NULL
                AND folios_aduana != ''
                ORDER BY created_at DESC";
            $stmt = $pdo->prepare($sql);
            $stmt->execute();

            return $stmt->fetchAll(PDO::FETCH_OBJ);

        } catch (\Exception $e) {
            error_log("Error en Folioaduana: " . $e->getMessage());
            return [];
        }
    }

    public static function rechazarFolio($pedimento_id, $motivo_rechazo)
    {
        try {
            $pdo = self::connect();

            $sql_check = "SELECT id, user_id, folio, Token, folios_aduana, Estatus FROM folio_pedimento WHERE id = :pedimento_id";
            $stmt_check = $pdo->prepare($sql_check);
            $stmt_check->bindParam(':pedimento_id', $pedimento_id, PDO::PARAM_INT);
            $stmt_check->execute();
            $pedimento = $stmt_check->fetch(PDO::FETCH_OBJ);

            if (!$pedimento) {
                return [
                    'success' => false,
                    'message' => 'El pedimento no existe'
                ];
            }

            $folio_anterior = $pedimento->folios_aduana ?? '';

            $sql_update = "UPDATE folio_pedimento 
                           SET folios_aduana = NULL,
                               Estatus = '3',
                               updated_at = NOW() 
                           WHERE id = :pedimento_id";
            $stmt = $pdo->prepare($sql_update);
            $stmt->bindParam(':pedimento_id', $pedimento_id, PDO::PARAM_INT);
            $stmt->execute();

            if ($stmt->rowCount() > 0) {
                \App\Repositories\NotificationRepository::crearNotificacion(
                    $pedimento->user_id,
                    'Folio Aduana Rechazado',
                    "El folio aduana <strong>{$folio_anterior}</strong> ha sido rechazado para tu folio: <strong>{$pedimento->folio}</strong><br>" .
                    "<strong>Motivo:</strong> {$motivo_rechazo}",
                    'folio_rechazado',
                    $pedimento->id
                );

                return [
                    'success' => true,
                    'message' => 'Folio rechazado correctamente',
                    'folio_rechazado' => $folio_anterior,
                    'user_id_asociado' => $pedimento->user_id
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'No se pudo rechazar el folio'
                ];
            }

        } catch (\Exception $e) {
            error_log("Error en rechazarFolio: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Error al rechazar folio: ' . $e->getMessage()
            ];
        }
    }
    public static function getFolioById($folio_id)
    {
        try {
            $stmt = self::connect()->prepare("
            SELECT * 
            FROM folio_pedimento 
            WHERE id = :folio_id
        ");
            $stmt->bindParam(':folio_id', $folio_id, \PDO::PARAM_INT);
            $stmt->execute();
            $folio = $stmt->fetch(\PDO::FETCH_OBJ);

            if (!$folio) {
                error_log("Folio no encontrado con ID: " . $folio_id);
                return false;
            }

            error_log("Folio encontrado: " . print_r($folio, true));
            return $folio;

        } catch (\PDOException $e) {
            error_log("Error en getFolioById: " . $e->getMessage());
            return false;
        }
    }

    public static function guardarObservacionesPedimentosJson($folio_id, $pedimento_indices, $observaciones)
    {
        try {
            $pdo = self::connect();

            // Obtener el registro actual
            $stmt = $pdo->prepare("SELECT pedimentos_json FROM folio_pedimento WHERE id = :folio_id");
            $stmt->bindParam(':folio_id', $folio_id, \PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);

            if (!$result) {
                return [
                    'success' => false,
                    'message' => 'Folio no encontrado'
                ];
            }

            // Decodificar el JSON actual
            $pedimentos_json = json_decode($result['pedimentos_json'], true) ?? [];
            $updated_count = 0;

            // Actualizar observaciones para cada pedimento
            foreach ($pedimento_indices as $index => $pedimento_index) {
                $pedimento_index = (int) $pedimento_index;
                $observacion = trim($observaciones[$index]);

                // Verificar si el índice existe
                if (isset($pedimentos_json[$pedimento_index])) {
                    // Actualizar observación
                    $pedimentos_json[$pedimento_index]['observaciones'] = $observacion;
                    $pedimentos_json[$pedimento_index]['observacion_updated_at'] = date('Y-m-d H:i:s');
                    $updated_count++;
                }
            }

            // Convertir de nuevo a JSON
            $nuevo_json = json_encode($pedimentos_json, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

            // Actualizar en la base de datos
            $stmt = $pdo->prepare("
            UPDATE folio_pedimento 
            SET pedimentos_json = :pedimentos_json,
                updated_at = NOW()
            WHERE id = :folio_id
        ");

            $stmt->bindParam(':pedimentos_json', $nuevo_json, \PDO::PARAM_STR);
            $stmt->bindParam(':folio_id', $folio_id, \PDO::PARAM_INT);

            if ($stmt->execute()) {
                return [
                    'success' => true,
                    'message' => "Observaciones guardadas correctamente para $updated_count pedimento(s)",
                    'updated_count' => $updated_count
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Error al actualizar la base de datos'
                ];
            }

        } catch (\PDOException $e) {
            error_log("Error en guardarObservacionesPedimentosJson: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Error al guardar observaciones: ' . $e->getMessage()
            ];
        }
    }

    public static function guardarObservacionIndividualJson($folio_id, $pedimento_index, $observacion)
    {
        try {
            $pdo = self::connect();

            // Obtener el registro actual
            $stmt = $pdo->prepare("SELECT pedimentos_json FROM folio_pedimento WHERE id = :folio_id");
            $stmt->bindParam(':folio_id', $folio_id, \PDO::PARAM_INT);
            $stmt->execute();
            $result = $stmt->fetch(\PDO::FETCH_ASSOC);

            if (!$result) {
                return [
                    'success' => false,
                    'message' => 'Folio no encontrado'
                ];
            }

            // Decodificar el JSON actual
            $pedimentos_json = json_decode($result['pedimentos_json'], true) ?? [];

            // Verificar si el índice existe
            if (!isset($pedimentos_json[$pedimento_index])) {
                return [
                    'success' => false,
                    'message' => 'Pedimento no encontrado en el índice especificado'
                ];
            }

            // Actualizar la observación
            $pedimentos_json[$pedimento_index]['observaciones'] = $observacion;
            $pedimentos_json[$pedimento_index]['observacion_updated_at'] = date('Y-m-d H:i:s');

            // Convertir de nuevo a JSON
            $nuevo_json = json_encode($pedimentos_json, JSON_UNESCAPED_UNICODE | JSON_PRETTY_PRINT);

            // Actualizar en la base de datos
            $stmt = $pdo->prepare("
            UPDATE folio_pedimento 
            SET pedimentos_json = :pedimentos_json,
                updated_at = NOW()
            WHERE id = :folio_id
        ");

            $stmt->bindParam(':pedimentos_json', $nuevo_json, \PDO::PARAM_STR);
            $stmt->bindParam(':folio_id', $folio_id, \PDO::PARAM_INT);

            if ($stmt->execute()) {
                return [
                    'success' => true,
                    'message' => 'Observación guardada correctamente',
                    'folio_id' => $folio_id,
                    'pedimento_index' => $pedimento_index,
                    'timestamp' => date('Y-m-d H:i:s')
                ];
            } else {
                return [
                    'success' => false,
                    'message' => 'Error al actualizar la base de datos'
                ];
            }

        } catch (\PDOException $e) {
            error_log("Error en guardarObservacionIndividualJson: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Error al guardar observación: ' . $e->getMessage()
            ];
        }
    }
    // En GestionRepository.php
    public static function buscarPorFolioOToken($folio, $token)
    {
        try {
            $pdo = self::connect();

            // Construir la consulta según lo que se proporcione
            $sql = "SELECT 
                    id, 
                    user_id, 
                    folio, 
                    Token, 
                    folios_aduana,
                    patente, 
                    nombre_completo, 
                    Estatus, 
                    fecha, 
                    Hora, 
                    total_pedimentos, 
                    pedimentos_json,
                    agente_aduanal, 
                    razon_social, 
                    telefono, 
                    correo_electronico,
                    agencia_aduanal, 
                    created_at, 
                    updated_at 
                FROM folio_pedimento 
                WHERE total_pedimentos > 0 
                AND (folios_aduana IS NOT NULL AND folios_aduana != '')
                AND (:folio != '' AND folio = :folio OR :token != '' AND Token = :token)
                ORDER BY created_at DESC
                LIMIT 1";

            $stmt = $pdo->prepare($sql);
            $stmt->bindParam(':folio', $folio, \PDO::PARAM_STR);
            $stmt->bindParam(':token', $token, \PDO::PARAM_STR);
            $stmt->execute();

            $resultado = $stmt->fetch(\PDO::FETCH_OBJ);

            if ($resultado) {
                // Decodificar el JSON de pedimentos para procesarlo
                $pedimentos = json_decode($resultado->pedimentos_json ?? '[]', true) ?? [];

                // Estructurar los datos para la vista
                return [
                    'success' => true,
                    'folio' => $resultado,
                    'pedimentos' => $pedimentos
                ];
            }

            return [
                'success' => false,
                'message' => 'No se encontró ningún registro con los datos proporcionados'
            ];

        } catch (\Exception $e) {
            error_log("ERROR en buscarPorFolioOToken: " . $e->getMessage());
            return [
                'success' => false,
                'message' => 'Error en la consulta: ' . $e->getMessage()
            ];
        }
    }
}