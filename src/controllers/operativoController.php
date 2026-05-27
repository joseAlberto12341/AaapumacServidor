<?php
namespace App\Controllers;
use App\Models\OperativoModel;
use App\Repositories\operativoRepository;

class OperativoController
{
public static function Home()
    {
        return [
            'view' => 'operativo/home.php',
            'scripts' => 'operativo',
            'action' => 'content',
        ];
    }

    public static function Profile()
    {
        return [
            'view' => 'operativo/home.php',
            'scripts' => 'operativo',
            'action' => 'content',
            'data' => [ 
                'title' => 'Mi Perfil',
                'subtitle' => 'Actualiza tu información personal',
            ],
        ];
    }
}