<?php 
namespace App\Controllers;

use App\Repositories\AdminRepository;

class UserController
{
    public static function home()
    {
        return [
            'view' => 'user/dashboard.php', // Nueva vista específica
            'scripts' => 'user',
            'data' => [
                'title' => 'Dashboard Usuario',
                'subtitle' => 'Bienvenido ' . ($_SESSION['username'] ?? 'Usuario')
            ]
        ];
    }
    
    public static function modal()
    {   
        return [
            'view' => 'user/home.php', // Puedes crear esta también o usar admin/home.php
            'scripts' => 'user',
            'action' => 'modal',
            'modal' => AdminRepository::getModalList(),
        ];
    }

    public static function profile()
    {
        return [
            'view' => 'user/home.php', // Puedes crear esta también o usar admin/home.php  
            'scripts' => 'user',
            'action' => 'profile',
            'user' => AdminRepository::getUserList(),
        ];
    }
}