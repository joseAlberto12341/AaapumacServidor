<?php
define('APP', dirname(__DIR__));
define('CONTROLLERS', APP . '/controllers');
define('REPOSITORIES', APP . '/repositories');
define('MODELS', APP . '/models');
define('VIEWS', APP . '/views');
define('UPLOADS', APP . '/uploads');

// === NUEVO: Definir UTILS ===
define('UTILS', APP . '/utils');

define('DEFAULT_IMAGE_TYPE', 'image/jpeg');

/* Database */
define('DB_HOST', 'develop.aaamzo.org.mx');
define('DB_NAME', 'aaapumac_pruebas');
define('DB_USER', 'admin_prog');
define('DB_PASS', 'AaaMzo2021$');
define('DB_CHAR', 'utf8mb4');

try {
    $pdo = new PDO("mysql:host=".DB_HOST.";dbname=".DB_NAME.";charset=".DB_CHAR, DB_USER, DB_PASS);
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch(PDOException $e) {
    die("Error de conexión a la base de datos: " . $e->getMessage());
}

/* Password */
// define('PASSWORD_DEFAULT', 'Aaamzo20Xx?');
//xtyAjFo2gio8Qe6l <--contraseña