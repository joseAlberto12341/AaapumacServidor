<?php
namespace App\Repositories;

use App\Models\asociadoModel;
use App\Models\InformacionGeneralModel;
use App\Models\FolioPedimentoModel;
use PDO;

class AsociadoRepository
{
    private static function connect()
    {
        $server = 'mysql:host=' . DB_HOST . ';dbname=' . DB_NAME . ';charset=' . DB_CHAR;
        $pdo = new PDO($server, DB_USER, DB_PASS);
        $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        return $pdo;
    }

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
                $personal = new asociadoModel();
                $personal->loadFromArray((array) $result);
                return $personal;
            }

            return null;

        } catch (\Exception $e) {
            error_log("Error en getPersonalById: " . $e->getMessage());
            return null;
        }
    }

    public static function obtenerInformacionGeneral($user_id)
    {
        try {
            $pdo = self::connect();
            $sql = "SELECT * FROM informacion_general WHERE user_id = :user_id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':user_id' => $user_id]);

            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            if ($result) {
                $model = new InformacionGeneralModel();
                $model->loadFromArray($result);
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

    public static function listPedimentos($page = 1, $perPage = 25, $filters = [])
    {
        try {
            $pdo = self::connect();
            $offset = ($page - 1) * $perPage;

            $whereConditions = ["total_pedimentos > 0"];
            $whereParams = [];

            if (!empty($filters['search'])) {
                $whereConditions[] = "(folio LIKE :search OR nombre_completo LIKE :search OR patente LIKE :search)";
                $whereParams[':search'] = '%' . $filters['search'] . '%';
            }

            if (!empty($filters['estatus'])) {
                $whereConditions[] = "Estatus = :estatus";
                $whereParams[':estatus'] = $filters['estatus'];
            }

            if (!empty($filters['fecha_desde'])) {
                $whereConditions[] = "fecha >= :fecha_desde";
                $whereParams[':fecha_desde'] = $filters['fecha_desde'];
            }

            if (!empty($filters['fecha_hasta'])) {
                $whereConditions[] = "fecha <= :fecha_hasta";
                $whereParams[':fecha_hasta'] = $filters['fecha_hasta'];
            }

            $whereClause = implode(' AND ', $whereConditions);

            $sql = "SELECT id, folio, Token, patente, nombre_completo, Estatus, fecha, Hora, 
                           total_pedimentos, pdf_generado, pdf_filename 
                    FROM folio_pedimento 
                    WHERE {$whereClause}
                    ORDER BY fecha DESC, id DESC
                    LIMIT :limit OFFSET :offset";

            $stmt = $pdo->prepare($sql);

            foreach ($whereParams as $key => $value) {
                $stmt->bindValue($key, $value);
            }

            $stmt->bindValue(':limit', (int) $perPage, PDO::PARAM_INT);
            $stmt->bindValue(':offset', (int) $offset, PDO::PARAM_INT);
            $stmt->execute();

            $data = $stmt->fetchAll(PDO::FETCH_OBJ);

            $countSql = "SELECT COUNT(*) as total FROM folio_pedimento WHERE {$whereClause}";
            $countStmt = $pdo->prepare($countSql);

            foreach ($whereParams as $key => $value) {
                $countStmt->bindValue($key, $value);
            }

            $countStmt->execute();
            $totalResult = $countStmt->fetch(PDO::FETCH_OBJ);
            $totalRows = $totalResult ? $totalResult->total : 0;

            return [
                'data' => $data,
                'total' => $totalRows,
                'page' => $page,
                'per_page' => $perPage,
                'total_pages' => ceil($totalRows / $perPage)
            ];

        } catch (\Exception $e) {
            error_log("Error en listPedimentos: " . $e->getMessage());
            return [
                'data' => [],
                'total' => 0,
                'page' => $page,
                'per_page' => $perPage,
                'total_pages' => 0
            ];
        }
    }

    public static function getAllPedimentos()
    {
        $result = self::listPedimentos(1, 1000);
        return $result['data'];
    }

    public static function guardarPedimentos($user_id, $pedimentosData)
    {
        try {
            $pdo = self::connect();

            if (empty($pedimentosData) || !is_array($pedimentosData)) {
                throw new \Exception("No hay datos de pedimentos válidos para guardar");
            }

            $infoGeneral = self::obtenerInformacionGeneral($user_id);

            if (!$infoGeneral) {
                error_log("ERROR: No se encontró información general para el usuario ID: " . $user_id);
                throw new \Exception("No se encontró tu información de contacto. Completa tu perfil primero.");
            }

            $pedimentos_json = json_encode($pedimentosData);
            $total_pedimentos = count($pedimentosData);

            $fecha = $pedimentosData[0]['fecha'] ?? date('Y-m-d');
            $hora = $pedimentosData[0]['Hora'] ?? date('H:i:s');

            $folio = 'ENTREGA-' . date('Ymd-His') . '-' . substr(md5($user_id . time()), 0, 6);
            $token = self::generarToken5Caracteres();

            $sql = "INSERT INTO folio_pedimento (
                user_id, 
                fecha, 
                Hora, 
                total_pedimentos, 
                pedimentos_json,
                patente, 
                agente_aduanal, 
                razon_social, 
                telefono, 
                nombre_completo, 
                correo_electronico, 
                agencia_aduanal, 
                folio, 
                Token,
                Estatus, 
                created_at
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, NOW())";

            $stmt = $pdo->prepare($sql);

            $success = $stmt->execute([
                $user_id,
                $fecha,
                $hora,
                $total_pedimentos,
                $pedimentos_json,
                $infoGeneral->getPatente() ?? '',
                $infoGeneral->getAgenteAduanal() ?? '',
                $infoGeneral->getRazonSocial() ?? '',
                $infoGeneral->getTelefono() ?? '',
                $infoGeneral->getNombreCompleto() ?? '',
                $infoGeneral->getCorreoElectronico() ?? '',
                $infoGeneral->getAgenciaAduanal() ?? '',
                $folio,
                $token,
                '1'
            ]);

            if (!$success) {
                $errorInfo = $stmt->errorInfo();
                error_log("ERROR SQL al insertar pedimento: " . print_r($errorInfo, true));
                throw new \Exception("Error en la base de datos al guardar el pedimento");
            }

            $lastId = $pdo->lastInsertId();

            error_log("PEDIMENTO GUARDADO - ID: $lastId, Folio: $folio, Token: $token, Fecha: $fecha, Hora: $hora");

            return $lastId;

        } catch (\Exception $e) {
            error_log("ERROR CRÍTICO en guardarPedimentos: " . $e->getMessage());
            error_log("Stack trace: " . $e->getTraceAsString());
            throw new \Exception("Error al guardar los pedimentos: " . $e->getMessage());
        }
    }

    private static function generarToken5Caracteres()
    {
        $caracteres = 'ABCDEFGHJKLMNPQRSTUVWXYZ23456789';
        $token = '';

        for ($i = 0; $i < 5; $i++) {
            $token .= $caracteres[rand(0, strlen($caracteres) - 1)];
        }

        return self::verificarTokenUnico($token);
    }

    private static function verificarTokenUnico($token)
    {
        try {
            $pdo = self::connect();
            $sql = "SELECT COUNT(*) as total FROM folio_pedimento WHERE Token = :token";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':token' => $token]);

            $result = $stmt->fetch(PDO::FETCH_OBJ);

            if ($result && $result->total > 0) {
                error_log("Token duplicado: $token, generando nuevo...");
                return self::generarToken5Caracteres();
            }

            return $token;

        } catch (\Exception $e) {
            error_log("Error al verificar token único: " . $e->getMessage());
            return $token;
        }
    }

    public static function obtenerDatosUsuarioCompletos($user_id)
    {
        try {
            $pdo = self::connect();

            $sqlUser = "SELECT username, email FROM aaausers WHERE id = :user_id";
            $stmtUser = $pdo->prepare($sqlUser);
            $stmtUser->execute([':user_id' => $user_id]);
            $usuario = $stmtUser->fetch(PDO::FETCH_ASSOC);

            $sqlInfo = "SELECT * FROM informacion_general WHERE user_id = :user_id";
            $stmtInfo = $pdo->prepare($sqlInfo);
            $stmtInfo->execute([':user_id' => $user_id]);
            $infoGeneral = $stmtInfo->fetch(PDO::FETCH_ASSOC);

            return [
                'usuario' => $usuario,
                'informacion_general' => $infoGeneral
            ];

        } catch (\Exception $e) {
            error_log("Error en obtenerDatosUsuarioCompletos: " . $e->getMessage());
            return null;
        }
    }

    public static function getPedimentoById($id)
    {
        try {
            $pdo = self::connect();
            $sql = "SELECT *, Token as token FROM folio_pedimento WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':id' => $id]);

            $result = $stmt->fetch(PDO::FETCH_OBJ);
            return $result;

        } catch (\Exception $e) {
            error_log("Error en getPedimentoById: " . $e->getMessage());
            return null;
        }
    }

    public static function marcarPDFGenerado($id, $filename)
    {
        try {
            $pdo = self::connect();
            $sql = "UPDATE folio_pedimento SET pdf_generado = 1, pdf_filename = :filename WHERE id = :id";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([
                ':filename' => $filename,
                ':id' => $id
            ]);

            return true;

        } catch (\Exception $e) {
            error_log("Error en marcarPDFGenerado: " . $e->getMessage());
            return false;
        }
    }

    public static function getLastInsertedId($user_id)
    {
        try {
            $pdo = self::connect();
            $sql = "SELECT id FROM folio_pedimento 
                    WHERE user_id = :user_id 
                    ORDER BY created_at DESC, id DESC 
                    LIMIT 1";
            $stmt = $pdo->prepare($sql);
            $stmt->execute([':user_id' => $user_id]);

            $result = $stmt->fetch(PDO::FETCH_OBJ);
            return $result ? $result->id : null;

        } catch (\Exception $e) {
            error_log("Error en getLastInsertedId: " . $e->getMessage());
            return null;
        }
    }
}