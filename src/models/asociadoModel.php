<?php
namespace App\Models;

use App\Models\EntityModel;

class asociadoModel extends EntityModel
{
    protected $table = "aaausers";
    protected $alias = "l";
    
    private ?int $id = null;
    private string $username = "";
    private string $password = "";
    private string $email = "";
    private ?int $id_role = 9; // VALOR POR DEFECTO 9
    private ?int $id_status = 1;
    private string $created_at = "";
    private string $updated_at = "";

    // GETTERS
    public function getId(): ?int { return $this->id; }
    public function getUsername(): string { return $this->username; }
    public function getPassword(): string { return $this->password; }
    public function getEmail(): string { return $this->email; }
    public function getIdRole(): ?int { return $this->id_role; }
    public function getIdStatus(): ?int { return $this->id_status; }
    public function getCreatedAt(): string { return $this->created_at; }
    public function getUpdatedAt(): string { return $this->updated_at; }

    // SETTERS
    public function setId(int $id): void { $this->id = $id; }
    public function setUsername(string $username): void { $this->username = ucwords(trim($username)); }
    public function setPassword(string $password): void { $this->password = $password; }
    public function setEmail(string $email): void { $this->email = trim($email); }
    public function setIdRole(int $id_role): void { 
        // SIEMPRE forzar a 9
        $this->id_role = 9; 
    }
    public function setIdStatus(int $id_status): void { $this->id_status = $id_status; }
    public function setCreatedAt(string $created_at): void { $this->created_at = $created_at; }
    public function setUpdatedAt(string $updated_at): void { $this->updated_at = $updated_at; }

    /**
     * CARGAR DATOS DESDE UN ARRAY - CORREGIDO
     */
    public function loadFromArray(array $data): void
    {
        if (isset($data['id'])) $this->id = (int)$data['id'];
        if (isset($data['username'])) $this->username = $data['username'];
        if (isset($data['password'])) $this->password = $data['password'];
        if (isset($data['email'])) $this->email = $data['email'];
        // IGNORAR id_role del array - siempre será 9
        $this->id_role = 9;
        if (isset($data['id_status'])) $this->id_status = (int)$data['id_status'];
        if (isset($data['created_at'])) $this->created_at = $data['created_at'];
        if (isset($data['updated_at'])) $this->updated_at = $data['updated_at'];
    }

    public function exists(): bool
    {
        return $this->id !== null && $this->id > 0;
    }
}