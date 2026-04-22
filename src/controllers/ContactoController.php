<?php
namespace Controllers;

use Models\ContactoModel;
use Utils\MailConfig;
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class ContactoController {
    public  function enviarCorreo(){
        $nombre = $_POST['nombre'];
        var_dump($nombre);
    }
}
?>