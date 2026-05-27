<?php

require_once __DIR__ . '/../../../vendor/autoload.php';

use BotMan\BotMan\BotMan;
use BotMan\BotMan\BotManFactory;

// Crear un nuevo bot
$config = [
    // Configuración específica del driver, como tokens, etc.
];

$botman = BotManFactory::create($config);

// Procesa el mensaje del usuario
$message = strtolower($_GET['message'] ?? ''); // Convertir el mensaje a minúsculas

if (!empty($message)) {
    // Escuchar el mensaje del usuario y responder de manera estática
    switch ($message) {
        case 'hola':
            $botResponse = '¡Hola! ¿Cómo puedo ayudarte?';
            break;
        case 'adios':
            $botResponse = '¡Hasta luego! Espero verte pronto.';
            break;
        case 'tengo un problema':
            $botResponse = 'Porfavor, mencioname cual es el problema';
            break;
        case 'gracias':
            $botResponse = '¡Es un placer ayudarte!';
            break;
        case 'ticket':
            $botResponse = 'Porfavor, proporciona el numero de ticket para conocer su estado';
            break;
        //Agregar mas informacion en este apartado para el chat
        default://si no conoce nada de lo anterior respondera por default
            $botResponse = 'No entiendo tu mensaje.';
            break;
    }
    // Imprimir la respuesta del bot
    echo $botResponse;
} else {
    echo 'No se proporcionó ningún mensaje.';
}

?>