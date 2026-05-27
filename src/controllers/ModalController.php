<?php

namespace App\Controllers;

class ModalController
{
    public static function create()
    {
        echo "ModalController/create";
    }
    public static function read()
    {
        echo "ModalController/index";
        return [
            'view' => 'admin/home.php',
            'scripts' => 'admin',
            'action' => 'modal',
        ];
    }
    public static function update()
    {
        echo "ModalController/update";
    }
    public static function delete()
    {
        echo "ModalController/delete";
    }
}
