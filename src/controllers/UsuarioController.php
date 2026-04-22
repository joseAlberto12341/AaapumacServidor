<?php

namespace App\Controllers;

class UsuarioController{

    public static function read()
    {
        echo "UsuarioController/index";
        return [
            'view' => 'admin/home.php',
            'scripts' => 'admin',
            'action' => 'usuario',
        ];
    }

}
