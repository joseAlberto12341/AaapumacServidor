<?php

namespace App\Repositories;

use App\Models\UsersModel;

class LoginRepository extends BaseRepository
{
    protected static $model = UsersModel::class;

    /**
     * Obtener usuario por email (sin verificar contraseña)
     */
    public static function getUserByEmail($email)
    {
        $user = new static::$model();
        
        $result = $user->select(
            'u.id, u.username, u.email, u.password, u.id_role, r.name as role_name',
            [
                'where' => '(u.email = :email OR u.username = :email) AND u.id_status = 1',
                'join' => [
                    [
                        'table' => 'aaaroles r',
                        'on' => 'u.id_role = r.id'
                    ]
                ],
                'replaces' => [
                    ':email' => $email
                ]
            ],
            true
        );

        return $result;
    }

    /**
     * Verificar credenciales con password hasheado
     */
    public static function verifyCredentials($email, $password)
    {
        // Primero obtener el usuario por email
        $user = self::getUserByEmail($email);
        
        if (!$user) {
            error_log("Usuario no encontrado para email: " . $email);
            return null;
        }

        // DEBUG: Verificar qué tenemos
        error_log("Usuario encontrado: " . $user->getUsername());
        error_log("Password en BD: " . $user->getPassword());
        error_log("Password length: " . strlen($user->getPassword()));

        // Verificar la contraseña
        $passwordHash = $user->getPassword();
        
        // Si el password tiene menos de 60 caracteres, probablemente no está hasheado
        if (strlen($passwordHash) < 60) {
            error_log("Password parece estar en texto plano, comparando directamente");
            if ($password === $passwordHash) {
                error_log("Contraseña correcta (texto plano)");
                return $user;
            } else {
                error_log("Contraseña incorrecta (texto plano)");
                return null;
            }
        } else {
            // Password está hasheado
            if (password_verify($password, $passwordHash)) {
                error_log("Contraseña VERIFICADA correctamente (hash)");
                return $user;
            } else {
                error_log("Contraseña INCORRECTA (hash)");
                return null;
            }
        }
    }

    /**
     * Método legacy - mantener por compatibilidad
     * @deprecated Usar verifyCredentials en su lugar
     */
    public static function getUser($email, $password)
    {
        return self::verifyCredentials($email, $password);
    }

    /**
     * Actualizar contraseña de usuario
     */
    public static function updatePassword($userId, $newHashedPassword)
    {
        $user = new static::$model();
        
        $result = $user->update(
            ['password' => $newHashedPassword],
            ['id' => $userId]
        );

        return $result;
    }

    /**
     * Crear nuevo usuario con contraseña hasheada
     */
    public static function createUser($userData)
    {
        $user = new static::$model();
        
        // Asegurar que la contraseña esté hasheada
        if (isset($userData['password']) && strlen($userData['password']) < 60) {
            $userData['password'] = password_hash($userData['password'], PASSWORD_DEFAULT);
        }
        
        $result = $user->insert($userData);
        
        return $result;
    }
}