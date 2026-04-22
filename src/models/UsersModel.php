<?php

namespace App\Models;

class UsersModel extends EntityModel
{
    protected $table = 'aaausers';
    protected $alias = 'u';
    protected $primaryKey = 'id';
    
    // Definir todas las propiedades que esperas usar
    protected $id;
    protected $username;
    protected $email;
    protected $password;
    protected $id_role;
    protected $role_name; // Para el JOIN
    
    public function getId()
    {
        return $this->id;
    }
    
    public function getUsername()
    {
        return $this->username;
    }
    
    public function getEmail()
    {
        return $this->email;
    }
    
    public function getPassword()
    {
        return $this->password;
    }
    
    public function getIdRole()
    {
        return $this->id_role;
    }
    
    public function getRoleName()
    {
        return $this->role_name;
    }
    
    // Método para verificar si la contraseña coincide
    public function verifyPassword($password)
    {
        return $this->password === $password; // o usar password_verify() si usas hash
    }
}