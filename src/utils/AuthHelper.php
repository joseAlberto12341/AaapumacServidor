<?php

namespace Utils;

class AuthHelper
{
    /**
     * Verificar autenticación y rol
     */
    public static function requireAuth($requiredRole = null)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Verificar si está logueado
        if (!isset($_SESSION['logged']) || $_SESSION['logged'] !== true) {
            $_SESSION['message'] = 'Debes iniciar sesión para acceder';
            header('Location: /Aaapumac/login');
            exit();
        }

        // Si se especifica un rol, verificarlo
        if ($requiredRole !== null) {
            if (!isset($_SESSION['id_role']) || $_SESSION['id_role'] != $requiredRole) {
                $_SESSION['message'] = 'No tienes permisos para esta sección';
                header('Location: /Aaapumac/');
                exit();
            }
        }
    }

    /**
     * Verificar múltiples roles
     */
    public static function requireAnyRole($allowedRoles)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        // Verificar si está logueado
        if (!isset($_SESSION['logged']) || $_SESSION['logged'] !== true) {
            $_SESSION['message'] = 'Debes iniciar sesión para acceder';
            header('Location: /Aaapumac/login');
            exit();
        }

        // Verificar rol
        if (!isset($_SESSION['id_role']) || !in_array($_SESSION['id_role'], $allowedRoles)) {
            $_SESSION['message'] = 'No tienes permisos para esta sección';
            header('Location: /Aaapumac/');
            exit();
        }
    }

    /**
     * Verificar si es administrador
     */
    public static function isAdmin()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        return isset($_SESSION['id_role']) && $_SESSION['id_role'] == 1;
    }

    /**
     * Obtener datos del usuario actual
     */
    public static function user()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        if (!isset($_SESSION['logged']) || $_SESSION['logged'] !== true) {
            return null;
        }
        
        return [
            'id' => $_SESSION['id_user'] ?? null,
            'username' => $_SESSION['username'] ?? null,
            'email' => $_SESSION['email'] ?? null,
            'role_id' => $_SESSION['id_role'] ?? null,
            'role_name' => $_SESSION['role_name'] ?? null
        ];
    }

    /**
     * Verificar si tiene un rol específico
     */
    public static function hasRole($roleId)
    {
        $user = self::user();
        return $user && $user['role_id'] == $roleId;
    }
}