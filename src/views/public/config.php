<?php
define('USER', 'admin_prog');
define('PASSWORD', 'AaaMzo2021$');
define('HOST', 'develop.aaamzo.org.mx');
define('DATABASE', 'aaapumac_prueba');
try {
    $connection = new PDO("mysql:host=" . HOST . ";dbname=" . DATABASE, USER, PASSWORD);
    $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
} catch (PDOException $e) {
    exit("Error: " . $e->getMessage());
}
?>