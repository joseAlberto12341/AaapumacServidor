<?php

namespace App\Middleware;

class AuthMiddleware
{
    public static function handle()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['logged']) || $_SESSION['logged'] !== true) {
            $_SESSION['message'] = 'Debes iniciar sesión para acceder';
            header('Location: /Aaapumac/login');
            exit();
        }
    }

    public static function checkRole($requiredRole)
    {
        self::handle(); // Primero verifica autenticación

        if (!isset($_SESSION['id_role']) || $_SESSION['id_role'] != $requiredRole) {
            $_SESSION['message'] = 'No tienes permisos para esta sección';
            header('Location: /Aaapumac/');
            exit();
        }
    }

    public static function checkAnyRole($allowedRoles)
    {
        self::handle(); // Primero verifica autenticación

        if (!isset($_SESSION['id_role']) || !in_array($_SESSION['id_role'], $allowedRoles)) {
            $_SESSION['message'] = 'No tienes permisos para esta sección';
            header('Location: /Aaapumac/');
            exit();
        }
    }
}