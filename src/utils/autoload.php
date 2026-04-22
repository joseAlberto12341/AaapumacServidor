<?php
// autoload.php - SIN DEFINICIONES DE CONSTANTES

if (defined('AUTOLOAD_EXECUTED_V3')) {
    return;
}
define('AUTOLOAD_EXECUTED_V3', true);

// Solo errores para desarrollo
if (!isset($_SERVER['SERVER_NAME']) || $_SERVER['SERVER_NAME'] === 'localhost') {
    error_reporting(E_ALL);
    ini_set('display_errors', 1);
}

class Autoloader {
    private static $loadedFiles = [];
    
    public static function load($filePath) {
        $realPath = realpath($filePath);
        if (!$realPath || isset(self::$loadedFiles[$realPath])) {
            return true;
        }
        
        if (file_exists($filePath)) {
            require_once $filePath;
            self::$loadedFiles[$realPath] = true;
            return true;
        }
        
        return false;
    }
}

// === NUEVO: Sistema de autoload con namespaces (PSR-4 compatible) ===
spl_autoload_register(function ($className) {
    // Mapear namespaces a directorios
    $namespaceMap = [
        'Utils\\' => UTILS . '/',
        'Controllers\\' => CONTROLLERS . '/',
        'Models\\' => MODELS . '/',
        'Repositories\\' => REPOSITORIES . '/',
        'App\\Controllers\\' => CONTROLLERS . '/',
        'App\\Models\\' => MODELS . '/',
        'App\\Repositories\\' => REPOSITORIES . '/',
        'App\\Middleware\\' => __DIR__ . '/../../app/Middleware/', // NUEVO
    ];
    
    foreach ($namespaceMap as $prefix => $baseDir) {
        $len = strlen($prefix);
        if (strncmp($prefix, $className, $len) === 0) {
            $relativeClass = substr($className, $len);
            $file = $baseDir . str_replace('\\', '/', $relativeClass) . '.php';
            
            if (file_exists($file)) {
                require $file;
                return;
            }
        }
    }
    
    // DEBUG: Si no encuentra la clase
    if (!isset($_SERVER['SERVER_NAME']) || $_SERVER['SERVER_NAME'] === 'localhost') {
        error_log("Autoload no pudo cargar: " . $className);
        
        // Mostrar el mapa para debug
        foreach ($namespaceMap as $prefix => $baseDir) {
            error_log("  - $prefix => $baseDir");
        }
    }
});

// Carga crítica (para archivos que no usan namespaces)
$criticalFiles = [
    MODELS . '/EntityModel.php',
    REPOSITORIES . '/BaseRepository.php',
];

foreach ($criticalFiles as $file) {
    Autoloader::load($file);
}

// Carga del resto (backward compatibility)
$directories = [MODELS, REPOSITORIES, CONTROLLERS, UTILS];
foreach ($directories as $dir) {
    if (is_dir($dir)) {
        $files = glob($dir . '/*.php');
        foreach ($files as $file) {
            $skip = ['EntityModel.php', 'BaseRepository.php'];
            if (!in_array(basename($file), $skip)) {
                Autoloader::load($file);
            }
        }
    }
}