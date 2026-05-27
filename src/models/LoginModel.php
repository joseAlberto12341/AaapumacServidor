<?php

namespace App\Models;

use App\Models\EntityModel;

class LoginModel extends EntityModel
{
    protected $table = "aaausers";
    protected $alias = "u";
    
    private ?int $id = null;
    private string $username = "";
    private string $email = "";
    private string $password = "";
    private int $id_role = 0;
    private string $created_at = "";
    private string $updated_at = "";

    // Para el campo del JOIN
    private string $role_name = "";

    public function getId(): ?int
    {
        return $this->id;
    }
    
    public function getUsername(): string
    {
        return $this->username;
    }
    
    public function setUsername(string $username): void
    {
        $this->username = $username;
    }
    
    public function getEmail(): string
    {
        return $this->email;
    }
    
    public function setEmail(string $email): void
    {
        $this->email = $email;
    }
    
    public function getPassword(): string
    {
        return $this->password;
    }
    
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }
    
    // NUEVO: Métodos para id_role
    public function getIdRole(): int
    {
        return $this->id_role;
    }
    
    public function setIdRole(int $id_role): void
    {
        $this->id_role = $id_role;
    }
    
    // NUEVO: Métodos para role_name (del JOIN)
    public function getRoleName(): string
    {
        return $this->role_name;
    }
    
    public function setRoleName(string $role_name): void
    {
        $this->role_name = $role_name;
    }
    
    public function getCreatedAt(): string
    {
        return $this->created_at;
    }
    
    public function setCreatedAt(string $created_at): void
    {
        $this->created_at = $created_at;
    }
    
    public function getUpdatedAt(): string
    {
        return $this->updated_at;
    }
    
    public function setUpdatedAt(string $updated_at): void
    {
        $this->updated_at = $updated_at;
    }
}