<?php

namespace App\Controllers;

use App\Repositories\AdminRepository;
use App\Repositories\LoginRepository;

class LoginController
{
    public static function index()
    {
        // Iniciar sesión si no está iniciada
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        return [
            'view' => 'public/login.php',
            'form' => [
                'title' => 'Login',
                'action' => '/Aaapumac/login/check',
                'button' => 'Iniciar Sesión',
                'message' => $_SESSION['message'] ?? '',
                'email' => $_SESSION['email'] ?? '',
                'password' => $_SESSION['password'] ?? '',
                'role' => $_SESSION['role'] ?? ''
            ],
            'scripts' => 'admin'
        ];
    }

    public static function check()
    {
        // Asegurar que la sesión esté iniciada
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            if (isset($_POST['email']) && isset($_POST['password'])) {
                $email = trim($_POST['email']);
                $password = $_POST['password'];

                // Validaciones básicas
                if (empty($email) || empty($password)) {
                    $_SESSION['message'] = 'Email y contraseña son requeridos';
                    header('Location: /Aaapumac/login');
                    exit();
                }

                // DEBUG
                error_log("=== LOGIN ATTEMPT ===");
                error_log("Email: " . $email);
                error_log("Password length: " . strlen($password));

                // Usar el nuevo método que verifica contraseñas hasheadas
                $user = LoginRepository::verifyCredentials($email, $password);

                if ($user == null || !$user) {
                    $_SESSION['message'] = 'Usuario y/o Contraseña no encontrados';
                    $_SESSION['email'] = $email; // Mantener el email en el formulario
                    header('Location: /Aaapumac/login');
                    exit();
                }

                // DEBUG: Verificar qué datos tenemos
                error_log("=== LOGIN EXITOSO ===");
                error_log("Usuario: " . $user->getUsername());
                error_log("ID Role: " . $user->getIdRole());
                error_log("Role Name: " . $user->getRoleName());

                // Login exitoso - guardar datos de sesión
                $_SESSION['id_user'] = $user->getId();
                $_SESSION['username'] = $user->getUsername();
                $_SESSION['email'] = $user->getEmail();
                $_SESSION['logged'] = true;
                $_SESSION['id_role'] = $user->getIdRole();
                $_SESSION['role_name'] = $user->getRoleName();
                
                // Limpiar mensajes de error previos
                unset($_SESSION['message']);
                
                // Redirigir según el tipo de usuario
                self::redirectByUserRole($user->getIdRole(), $user->getRoleName());
                exit();
            }
        }
        
        // Si no es POST, redirigir al login
        $_SESSION['message'] = 'Método no permitido';
        header('Location: /Aaapumac/login');
        exit();
    }

    /**
     * Redirige al usuario según su rol
     */
    private static function redirectByUserRole($roleId, $roleName)
    {
        // Limpiar el buffer de salida antes de redirigir
        if (ob_get_length()) {
            ob_end_clean();
        }
        
        switch ($roleId) {
            case 1: // admin
                header('Location: /Aaapumac/admin/profile');
                break;
            case 2: // user
                header('Location: /Aaapumac/administrativo/profile');
                break;
            case 3: // ti
                header('Location: /Aaapumac/ti/profile');
                break;
            case 4: // operativo
                header('Location: /Aaapumac/operativo/profile');
                break;
            case 5: // callcenter
                header('Location: /Aaapumac/callcenter/profile');
                break;
            case 6://navieras_resintos
                header('Location: /Aaapumac/navieras_resintos/profile');
                break;
            case 7://juridico
                header('Location: /Aaapumac/juridico/profile');
                break;
            case 8://calidad
                header('Location: /Aaapumac/calidad/profile');
                break;
            case 9://asociado
                header('Location: /Aaapumac/asociado/profile');
                break;
            case 10://asociadoCoordinador
                header('Location: /Aaapumac/asociadoCoordinador/profile');
                break;
            case 11://Gestion
                header('Location: /Aaapumac/Gestion/profile');
                break;   
            case 12://asociado común
                header('Location: /Aaapumac/asociadoComun/profile');
                break;         
            default:
                header('Location: /Aaapumac/');
                break;
        }
        exit();
    }

    public static function logout()
    {
        // Asegurar que la sesión esté iniciada
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        // Limpiar buffer antes de redirigir
        if (ob_get_length()) {
            ob_end_clean();
        }
        
        session_unset();
        session_destroy();
        header('Location: /Aaapumac/');
        exit();
    }

    /**
     * Middleware para verificar permisos por ID de rol
     */
    public static function checkPermission($requiredRoleId)
    {
        // Asegurar que la sesión esté iniciada
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['logged']) || $_SESSION['logged'] !== true) {
            // Limpiar buffer antes de redirigir
            if (ob_get_length()) {
                ob_end_clean();
            }
            header('Location: /Aaapumac/login');
            exit();
        }

        if ($_SESSION['id_role'] !== $requiredRoleId) {
            $_SESSION['message'] = 'No tienes permisos para acceder a esta sección';
            // Limpiar buffer antes de redirigir
            if (ob_get_length()) {
                ob_end_clean();
            }
            header('Location: /Aaapumac/');
            exit();
        }
    }

    /**
     * Verificar si el usuario tiene al menos uno de los roles requeridos
     */
    public static function checkMultiplePermissions($allowedRoleIds)
    {
        // Asegurar que la sesión esté iniciada
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['logged']) || $_SESSION['logged'] !== true) {
            // Limpiar buffer antes de redirigir
            if (ob_get_length()) {
                ob_end_clean();
            }
            header('Location: /Aaapumac/login');
            exit();
        }

        if (!in_array($_SESSION['id_role'], $allowedRoleIds)) {
            $_SESSION['message'] = 'No tienes permisos para acceder a esta sección';
            // Limpiar buffer antes de redirigir
            if (ob_get_length()) {
                ob_end_clean();
            }
            header('Location: /Aaapumac/');
            exit();
        }
    }

    /**
     * Verificar si el usuario está logueado (sin redirección)
     */
    public static function isLogged()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        return isset($_SESSION['logged']) && $_SESSION['logged'] === true;
    }

    /**
     * Obtener el ID del usuario actual
     */
    public static function getCurrentUserId()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        return $_SESSION['id_user'] ?? null;
    }

    /**
     * Obtener el rol del usuario actual
     */
    public static function getCurrentUserRole()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        return $_SESSION['id_role'] ?? null;
    }

    /**
     * Obtener el nombre del usuario actual
     */
    public static function getCurrentUsername()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        return $_SESSION['username'] ?? null;
    }

    /**
     * Verificar si el usuario actual tiene un rol específico
     */
    public static function hasRole($roleId)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        return ($_SESSION['id_role'] ?? null) === $roleId;
    }

    /**
     * Verificar si el usuario actual tiene alguno de los roles especificados
     */
    public static function hasAnyRole($roleIds)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        
        return in_array($_SESSION['id_role'] ?? null, $roleIds);
    }

    /**
     * Método para cambiar contraseña (si lo necesitas)
     */
    public static function changePassword($currentPassword, $newPassword)
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['id_user'])) {
            return false;
        }

        // Obtener usuario actual
        $user = LoginRepository::getUserByEmail($_SESSION['email']);
        
        if (!$user) {
            return false;
        }

        // Verificar contraseña actual
        if (!password_verify($currentPassword, $user->getPassword())) {
            return false;
        }

        // Hashear nueva contraseña
        $hashedNewPassword = password_hash($newPassword, PASSWORD_DEFAULT);

        // Actualizar en base de datos (necesitarías un método en el Repository)
        // $result = LoginRepository::updatePassword($_SESSION['id_user'], $hashedNewPassword);
        
        return true; // o return $result; dependiendo de tu implementación
    }
}