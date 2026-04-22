<?php 

namespace App\Controllers;

use App\Repositories\AdminRepository;

class UsersController
{
    public static function Home()
    {
        return [
            'view' => 'admin/home.php',
            'scripts' => 'admin',
            'action' => 'content',
        ];
    }
    public static function Modal()
    {
        return [
            'view' => 'admin/home.php',
            'scripts' => 'admin',
            'action' => 'modal',
            'modal' => $modal = AdminRepository::getModalList(),
        ];
    }

    public static function User()
    {
        return [
            'view' => 'admin/home.php',
            'scripts' => 'admin',
            'action' => 'user',
            'user' => $user = AdminRepository::getUserList(),
        ];
    }
}