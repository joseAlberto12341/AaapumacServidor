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
            'where' => '(u.email = :email_param OR u.username = :username_param) AND u.id_status = 1',
            'join' => [
                [
                    'table' => 'aaaroles r',
                    'on' => 'u.id_role = r.id'
                ]
            ],
            'replaces' => [
                ':email_param' => $email,
                ':username_param' => $email  // Mismo valor, pero diferentes parámetros
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
            return null;
        }

        // Verificar la contraseña
        $passwordHash = $user->getPassword();
        
        // Si el password tiene menos de 60 caracteres, probablemente no está hasheado
        if (strlen($passwordHash) < 60) {
            if ($password === $passwordHash) {
                return $user;
            } else {
                return null;
            }
        } else {
            // Password está hasheado
            if (password_verify($password, $passwordHash)) {
                return $user;
            } else {
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
            $userId,
            ['password' => $newHashedPassword],
            ['where' => 'id = :id']
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