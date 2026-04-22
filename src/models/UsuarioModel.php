<?php

namespace App\Models;

use App\Models\EntityModel;

class UsuarioModel extends EntityModel
{

    protected $table = "aaausers";
    protected $alias = "f";
    private ?int $id = null;
    private string $usuario = "";
    private string $username = "";
    private string $email = "";
    private string $contraseña = "";
    private string $password = "";
    private string $codigo_qr = "";
    private string $status = "";
    private int $id_role = 0;           // ← AGREGA ESTA
    private string $created_at = "";     // ← AGREGA ESTA
    private string $updated_at = "";     // ← AGREGA ESTA


    public function getId()
    {
        return $this->id;
    }
    public function getUsuario()
    {
        return $this->usuario;
    }
    public function setUsuario(string $usuario)
    {
        $this->usuario = $usuario;
    }
    public function getEmail()
    {
        return $this->email;
    }
    public function setEmail(string $email)
    {
        $this->email = $email;
    }
    public function getContraseña()
    {
        return $this->contraseña;
    }
    public function setContraseña(string $contraseña)
    {
        $this->contraseña = $contraseña;
    }
    public function getCodigo()
    {
        return $this->codigo_qr;
    }
    public function setCodigo(string $codigo_qr)
    {
        $this->codigo_qr = $codigo_qr;
    }
    public function getStatus()
    {
        return $this->status;
    }
    public function setStatus(int $status)
    {
        $this->status = $status;
    }

    public function getRole(): int
    {
        return $this->id_role;
    }

    public function setRole(int $id_role): void
    {
        $this->id_role = $id_role;
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

    public function insert()
    {
        $this->connect();
    
        $sql = "INSERT INTO " . $this->table . " (usuario, email, contraseña, codigo_qr, status) VALUES (?, ?, ?, ?,?)";
        $stmt = $this->pdo->prepare($sql);
        
        $stmt->execute([
            $this->getUsuario(),
            $this->getEmail(),
            $this->getContraseña(),
            $this->getCodigo(),
            $this->getStatus(),
        ]);
    }
}