<?php

namespace App\Controllers;

use App\Repositories\ClientRepository;

class ClientController
{
    public static function Home()
    {
        return [
            'view' => 'client/home.php',
            'scripts' => 'admin',
            'action' => 'content',
        ];
    }
    public static function opspedis()
    {
        return [
            'view' => 'client/home.php',
            'scripts' => 'admin',
            'action' => 'opspedis',
            'data' => [
                'title' => 'pedimentos',
                'subtitle' => 'Favor de llenar todos los campos',
            ],
        ];
    }

    public static function opsfollow()
    {
        return [
            'view' => 'client/home.php',
            'scripts' => 'admin',
            'action' => 'opsfollow',
        ];
    }
    public static function Modals()
    {
        return [
            'view' => 'client/home.php',
            'scripts' => 'client',
            'action' => 'modals',
            'data' => [
                'title' => 'Avisos',
                'subtitle' => 'Tienes  avisos registrados',
                'button' => 'Agregar nuevo aviso',
                'icon' => 'mdi mdi-bell-ring-outline',
            ],
            'modal' => $modal = ClientRepository::getModalList(),
        ];
    }

    public static function Profile()
    {
        return [
            'view' => 'client/home.php',
            'scripts' => 'admin',
            'action' => 'profile',
            'data' => [
                'title' => 'Perfil',
                'subtitle' => 'Información de tu perfil',
                'button' => 'Actualizar perfil',
                'icon' => 'mdi mdi-account-outline',
            ],
            'nav' => [

            ]
            // 'profile' => $profile = ClientRepository::getProfile(),
        ];
    }
    public static function serviOpe()
    {
        return [
            'view' => 'client/home.php',
            'scripts' => 'admin',
            'action' => 'serviope',
        ];
    }
    public static function serviJuri()
    {
        return [
            'view' => 'client/home.php',
            'scripts' => 'admin',
            'action' => 'servijuri',
        ];
    }
    public static function serviAran()
    {
        return [
            'view' => 'client/home.php',
            'scripts' => 'admin',
            'action' => 'serviaran',
        ];
    }
    public static function serviCall()
    {
        return [
            'view' => 'client/home.php',
            'scripts' => 'admin',
            'action' => 'servicall',
        ];
    }
    public static function serviNavi()
    {
        return [
            'view' => 'client/home.php',
            'scripts' => 'admin',
            'action' => 'servinavi',
        ];
    }
}