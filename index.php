<?php
session_start();

// ===== CONVERSOR DE RUTAS AMIGABLES =====
$requestUri = $_SERVER['REQUEST_URI'];
$basePath = '/Aaapumac';

if (strpos($requestUri, $basePath . '/') === 0 && !isset($_GET['e'])) {
    $cleanUri = str_replace($basePath, '', $requestUri);
    $cleanUri = explode('?', $cleanUri)[0];
    
    $uriParts = explode('/', trim($cleanUri, '/'));
    $uriParts = array_filter($uriParts);
    $uriParts = array_values($uriParts);
    
    if (count($uriParts) >= 2) {
        $_GET['e'] = $uriParts[0];
        $_GET['a'] = $uriParts[1];
        
        if (isset($uriParts[2])) {
            $_GET['id'] = $uriParts[2];
        }
    } elseif (count($uriParts) === 1) {
        $_GET['e'] = $uriParts[0];
        $_GET['a'] = 'index';
    }
}

// ===== INCLUIR AUTOLOAD DE COMPOSER PRIMERO =====
require_once('vendor/autoload.php');

// ===== CONFIGURACIÓN Y AUTOLOAD LEGACY =====
require_once('src/utils/config.php');
if (!defined('AUTOLOAD_EXECUTED_V3')) {
    require_once('src/utils/autoload.php');
}

ini_set('display_errors', 1);
error_reporting(E_ALL);

$entity = $_GET['e'] ?? 'public';
$action = $_GET['a'] ?? 'index';
$id = $_GET['id'] ?? 'no-id';

$entity = ucfirst(strtolower($entity));
$entityLower = strtolower($entity);

// ===== SISTEMA DE MIDDLEWARE POR RUTA =====
// Definir qué rutas requieren qué permisos (versión simple)
$protectedRoutes = [
    // Admin (rol 1)
    'admin' => 1,
    
    // Administrativo (rol 2)
    'administrativo' => 2,
    
    // Operativo (rol 4)
    'operativo' => 4,
    
    // TI (rol 3)
    'ti' => 3,
    
    // Callcenter (rol 5)
    'callcenter' => 5,
    
    // Navieras (rol 6)
    'navieras_resintos' => 6,
    
    // Jurídico (rol 7)
    'juridico' => 7,
    
    // Calidad (rol 8)
    'calidad' => 8,
    
    // Asociado (rol 9)
    'asociado' => 9,
    
    // Asociado Coordinador (rol 10)
    'asociadocoordinador' => 10,
    
    // Gestión (rol 11)
    'gestion' => 11,
        // Gestión (rol 12)
    'asociado_comun' => 12,
    
    // Rutas públicas (no requieren autenticación)
    'public' => null,
    'login' => null,
];

// Aplicar middleware si la ruta está protegida
if (isset($protectedRoutes[$entityLower])) {
    $requiredRole = $protectedRoutes[$entityLower];
    
    if ($requiredRole !== null) {
        // Iniciar sesión si no está iniciada
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Verificar autenticación
        if (!isset($_SESSION['logged']) || $_SESSION['logged'] !== true) {
            $_SESSION['message'] = 'Debes iniciar sesión para acceder a esta sección';
            header('Location: /Aaapumac/login');
            exit();
        }
        
        // Verificar rol
        if ($_SESSION['id_role'] != $requiredRole) {
            $_SESSION['message'] = 'No tienes permisos para acceder a esta sección';
            header('Location: /Aaapumac/');
            exit();
        }
    }
}

// ===== CONTINUAR CON EL FLUJO NORMAL =====
$class = 'App\\Controllers\\' . $entity . 'Controller';

if (!class_exists($class)) {
    // Intentar con namespace alternativo
    $altClass = 'Controllers\\' . $entity . 'Controller';
    if (class_exists($altClass)) {
        $class = $altClass;
    } else {
        die("La clase {$class} no existe. Verifica el namespace y el nombre del archivo.");
    }
}

if (!method_exists($class, $action)) {
    die("La acción {$action} no existe en la clase {$class}");
}

$answer = $class::$action();

if (!is_array($answer) || !isset($answer['view'])) {
    die("Error: El controlador no retornó un array válido con la clave 'view'");
}

include VIEWS . '/public/inc/header.php';
include VIEWS . '/' . $answer['view'];

if (isset($answer['scripts']) && $answer['scripts'] == 'prime') {
    include (VIEWS . '/public/inc/footer.php');
}
include VIEWS . '/public/inc/scripts.php';