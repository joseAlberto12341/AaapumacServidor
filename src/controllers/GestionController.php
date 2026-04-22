<?php 
namespace App\Controllers;
use App\Repositories\GestionRepository;

class GestionController
{
    public static function Home()
    {
        \Utils\AuthHelper::requireAuth(11);
        return [
            'view' => 'Gestion/home.php',
            'scripts' => 'Gestion',
            'action' => 'content',
        ];
    }

    public static function Profile()
    {
         \Utils\AuthHelper::requireAuth(11);
        return [
            'view' => 'Gestion/home.php',
            'scripts' => 'Gestion',
            'action' => 'content',
            'data' => [
                'title' => 'Mi Perfil',
                'subtitle' => 'Actualiza tu información personal',
            ],
        ];
    }
    
    public static function addfolios()
    {
         \Utils\AuthHelper::requireAuth(11);
        $addfolios = GestionRepository::addfolios();

        return [
            'view' => 'Gestion/home.php',
            'scripts' => 'Gestion',
            'action' => 'addfolios',
            'data' => [
                'title' => 'Folios dados de alta',
                'subtitle' => 'Gestionar los folios registrados en el sistema',
                'button' => 'Agregar nuevo pedimento',
                'icon' => 'mdi mdi-account-multiple',
                'addfolios' => $addfolios,
            ]
        ];
    }
    
    public static function getFoliosAjax()
    {
         \Utils\AuthHelper::requireAuth(11);
        try {
            if (session_status() === PHP_SESSION_NONE) {
                session_start();
            }
            
            $foliosArray = GestionRepository::getFoliosAjax();
            
            header('Content-Type: application/json');
            
            if (empty($foliosArray)) {
                echo json_encode([
                    'success' => true,
                    'data' => [],
                    'count' => 0,
                    'message' => 'No hay folios pendientes',
                    'timestamp' => date('Y-m-d H:i:s')
                ]);
            } else {
                echo json_encode([
                    'success' => true,
                    'data' => $foliosArray,
                    'count' => count($foliosArray),
                    'timestamp' => date('Y-m-d H:i:s')
                ]);
            }
            exit;
            
        } catch (\Exception $e) {
            error_log("Error en getFoliosAjax Controller: " . $e->getMessage());
            header('Content-Type: application/json');
            http_response_code(500);
            echo json_encode([
                'success' => false, 
                'message' => 'Error interno del servidor',
                'data' => []
            ]);
            exit;
        }
    }
    
    public static function agregaFolio()
    {
         \Utils\AuthHelper::requireAuth(11);
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Método no permitido']);
            exit;
        }
        
        if (!isset($_POST['pedimento_id']) || !isset($_POST['folio_aduana'])) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'Faltan campos requeridos']);
            exit;
        }
        
        $pedimento_id = (int)$_POST['pedimento_id'];
        $folio_aduana = trim($_POST['folio_aduana']);
        
        if (empty($folio_aduana)) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'El folio no puede estar vacío']);
            exit;
        }
        
        if ($pedimento_id <= 0) {
            header('Content-Type: application/json');
            echo json_encode(['success' => false, 'message' => 'ID de pedimento inválido']);
            exit;
        }
        
        error_log("=== AGREGANDO FOLIO ADUANA ===");
        error_log("Pedimento ID: " . $pedimento_id);
        error_log("Folio Aduana: " . $folio_aduana);
        
        $resultado = GestionRepository::insertarFolio($pedimento_id, $folio_aduana);
        
        error_log("Resultado: " . json_encode($resultado));
        
        header('Content-Type: application/json');
        echo json_encode($resultado);
        exit;
    }
    
    public static function rechazarFolio()
    {
         \Utils\AuthHelper::requireAuth(11);
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            if (self::isAjaxRequest()) {
                http_response_code(405);
                echo json_encode(['success' => false, 'message' => 'Método no permitido']);
                exit;
            } else {
                $_SESSION['error_message'] = 'Método no permitido';
                header('Location: /Aaapumac/Gestion/addfolios');
                exit;
            }
        }
        
        if (!isset($_POST['pedimento_id']) || !isset($_POST['motivo_rechazo'])) {
            if (self::isAjaxRequest()) {
                echo json_encode(['success' => false, 'message' => 'Faltan campos requeridos']);
                exit;
            } else {
                $_SESSION['error_message'] = 'Faltan campos requeridos';
                header('Location: /Aaapumac/Gestion/addfolios');
                exit;
            }
        }
        
        $pedimento_id = (int)$_POST['pedimento_id'];
        $motivo_rechazo = trim($_POST['motivo_rechazo']);
        
        if (empty($motivo_rechazo)) {
            if (self::isAjaxRequest()) {
                echo json_encode(['success' => false, 'message' => 'El motivo no puede estar vacío']);
                exit;
            } else {
                $_SESSION['error_message'] = 'El motivo no puede estar vacío';
                header('Location: /Aaapumac/Gestion/addfolios');
                exit;
            }
        }
        
        try {
            $resultado = GestionRepository::rechazarFolio($pedimento_id, $motivo_rechazo);
            
            if (self::isAjaxRequest()) {
                header('Content-Type: application/json');
                echo json_encode($resultado);
                exit;
            } else {
                if ($resultado['success']) {
                    $_SESSION['success_message'] = $resultado['message'];
                } else {
                    $_SESSION['error_message'] = $resultado['message'];
                }
                header('Location: /Aaapumac/Gestion/addfolios');
                exit;
            }
            
        } catch (\Exception $e) {
            error_log("Error en rechazarFolio: " . $e->getMessage());
            
            if (self::isAjaxRequest()) {
                echo json_encode(['success' => false, 'message' => 'Error del servidor']);
                exit;
            } else {
                $_SESSION['error_message'] = 'Error del servidor';
                header('Location: /Aaapumac/Gestion/addfolios');
                exit;
            }
        }
    }
    
    public static function Folioaduana()
    {
         \Utils\AuthHelper::requireAuth(11);
        $Folioaduana = GestionRepository::Folioaduana();

        return [
            'view' => 'Gestion/home.php',
            'scripts' => 'Gestion',
            'action' => 'Folioaduana',
            'data' => [
                'title' => 'Folios de aduana',
                'subtitle' => 'Folios que ya tienen asignación en aduana',
                'Folioaduana' => $Folioaduana,
            ]
        ];
    }
    
    private static function isAjaxRequest()
    {
         \Utils\AuthHelper::requireAuth(11);
        return isset($_SERVER['HTTP_X_REQUESTED_WITH']) && 
               strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) === 'xmlhttprequest';
    }

    public static function serviAran(){
         \Utils\AuthHelper::requireAuth(11);
        return [
            'view' => 'Gestion/home.php',
            'scripts' => 'Gestion',
            'action' => 'serviAran',
            'data' => [
                'title' => 'Servicios Arancelarios',
                'subtitle' => 'Consulta nuestros servicios arancelarios disponibles',
                'icon' => 'mdi mdi-scale-balance',
            ]
        ];
    }

    public static function serviJuri(){
         \Utils\AuthHelper::requireAuth(11);
        return [
            'view' => 'Gestion/home.php',
            'scripts' => 'Gestion',
            'action' => 'serviJuri',
            'data' => [
                'title' => 'Servicios Jurídicos',
                'subtitle' => 'Consulta nuestros servicios legales y asesoría especializada',
                'icon' => 'mdi mdi-gavel',
            ]
        ];
    }
//agregar observaciones al folio de aduana

public static function observacionesFolio(){
    \Utils\AuthHelper::requireAuth(11);
    
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    // Verificar si se recibió el ID del folio
    if (!isset($_GET['id']) || empty($_GET['id'])) {
        $_SESSION['error_message'] = 'No se especificó el folio a consultar';
        header('Location: /Aaapumac/Gestion/Folioaduana');
        exit;
    }
    
    $folio_id = (int)$_GET['id'];
    
    // Obtener los datos del folio
    $folio = GestionRepository::getFolioById($folio_id);
    
    if (!$folio) {
        $_SESSION['error_message'] = 'Folio no encontrado';
        header('Location: /Aaapumac/Gestion/Folioaduana');
        exit;
    }
    
    // Decodificar el JSON de pedimentos
    $pedimentos_json = json_decode($folio->pedimentos_json, true) ?? [];
    $total_pedimentos = $folio->total_pedimentos ?? 0;
    
    // Preparar array de pedimentos para la vista
    $pedimentos_vista = [];
    
    if (!empty($pedimentos_json) && is_array($pedimentos_json)) {
        foreach ($pedimentos_json as $index => $pedimento_data) {
            $pedimentos_vista[] = (object)[
                'id' => $folio_id . '_' . ($index + 1),
                'index' => $index,
                'pedimento' => $pedimento_data['pedimento'] ?? 'N/A',
                'tipo_operacion' => $pedimento_data['tipo_operacion'] ?? 'N/A',
                'clave_pedimento' => $pedimento_data['clave_pedimento'] ?? 'N/A',
                'CR' => $pedimento_data['CR'] ?? 'N/A',
                'observaciones' => $pedimento_data['observaciones'] ?? '',
                'observacion_updated_at' => $pedimento_data['observacion_updated_at'] ?? null,
                'patente' => $folio->patente ?? '',
                'folio' => $folio->folio ?? '',
                'token' => $folio->Token ?? '',
                'nombre_completo' => $folio->nombre_completo ?? ''
            ];
        }
    }
    
    // DEBUG: Verificar qué datos estamos enviando
    error_log("=== DEBUG observacionesFolio ===");
    error_log("Folio ID: " . $folio_id);
    error_log("Folio encontrado: " . ($folio ? 'Sí' : 'No'));
    error_log("Folio folio: " . ($folio->folio ?? 'N/A'));
    error_log("Total pedimentos: " . $total_pedimentos);
    error_log("Pedimentos vista count: " . count($pedimentos_vista));
    error_log("=== FIN DEBUG ===");
    
    $dataArray = [
        'title' => 'Agregar Observaciones',
        'subtitle' => 'Folio: ' . ($folio->folio ?? 'N/A'),
        'folio_id' => $folio_id,
        'folio_aduana' => $folio->folio ?? 'N/A',
        'folio_data' => $folio,
        'pedimentos' => $pedimentos_vista,
        'total_pedimentos' => $total_pedimentos,
        'icon' => 'mdi mdi-note-plus',
    ];
    
    error_log("Data array keys: " . implode(', ', array_keys($dataArray)));
    
    return [
        'view' => 'Gestion/home.php',
        'scripts' => 'Gestion',
        'action' => 'observacionesFolio',
        'data' => $dataArray
    ];
}
public static function guardarObservaciones(){
    \Utils\AuthHelper::requireAuth(11);
    
    if (session_status() === PHP_SESSION_NONE) {
        session_start();
    }
    
    if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
        $_SESSION['error_message'] = 'Método no permitido';
        header('Location: /Aaapumac/Gestion/Folioaduana');
        exit;
    }
    
    // Validar campos requeridos
    if (!isset($_POST['folio_id']) || !isset($_POST['pedimento_index']) || !isset($_POST['observaciones'])) {
        $_SESSION['error_message'] = 'Faltan campos requeridos';
        $folio_id = $_POST['folio_id'] ?? '';
        header('Location: /Aaapumac/Gestion/observacionesFolio?id=' . $folio_id);
        exit;
    }
    
    $folio_id = (int)$_POST['folio_id'];
    $pedimento_indices = $_POST['pedimento_index'];
    $observaciones = $_POST['observaciones'];
    
    // Validar que los arrays tengan la misma longitud
    if (!is_array($pedimento_indices) || !is_array($observaciones) || count($pedimento_indices) !== count($observaciones)) {
        $_SESSION['error_message'] = 'Error en los datos enviados';
        header('Location: /Aaapumac/Gestion/observacionesFolio?id=' . $folio_id);
        exit;
    }
    
    try {
        // Guardar las observaciones en la base de datos
        $resultado = GestionRepository::guardarObservacionesPedimentosJson($folio_id, $pedimento_indices, $observaciones);
        
        if ($resultado['success']) {
            $_SESSION['success_message'] = $resultado['message'];
        } else {
            $_SESSION['error_message'] = $resultado['message'];
        }
        
    } catch (\Exception $e) {
        error_log("Error al guardar observaciones: " . $e->getMessage());
        $_SESSION['error_message'] = 'Error interno al guardar observaciones: ' . $e->getMessage();
    }
    
    header('Location: /Aaapumac/Gestion/observacionesFolio?id=' . $folio_id);
    exit;
}

}