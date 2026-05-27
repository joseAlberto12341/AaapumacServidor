<?php
// find_duplicates.php - Buscar clases duplicadas
error_reporting(E_ALL);
ini_set('display_errors', 1);

echo "<h1>Buscando clases duplicadas</h1>";
echo "<pre>";

// Buscar todos los archivos PHP
$files = [];
$directories = ['src/models', 'src/controllers', 'src/repositories'];

foreach ($directories as $dir) {
    if (is_dir($dir)) {
        $dirFiles = glob($dir . '/*.php');
        foreach ($dirFiles as $file) {
            $files[] = $file;
        }
    }
}

echo "=== ARCHIVOS ENCONTRADOS ===\n";
$classNames = [];

foreach ($files as $file) {
    $content = file_get_contents($file);
    
    // Buscar declaraciones de clase
    if (preg_match('/class\s+(\w+)/', $content, $matches)) {
        $className = $matches[1];
        echo "$className en: $file\n";
        
        if (in_array($className, $classNames)) {
            echo "❌ DUPLICADO: $className\n";
        } else {
            $classNames[] = $className;
        }
    }
}

// Buscar específicamente UsersModel
echo "\n=== BUSCANDO UsersModel ESPECÍFICAMENTE ===\n";
$usersModelFiles = [];
foreach ($files as $file) {
    $content = file_get_contents($file);
    if (strpos($content, 'class UsersModel') !== false) {
        $usersModelFiles[] = $file;
        echo "UsersModel encontrado en: $file\n";
    }
}

if (count($usersModelFiles) > 1) {
    echo "❌ UsersModel está DUPLICADO en " . count($usersModelFiles) . " archivos\n";
}

echo "</pre>";