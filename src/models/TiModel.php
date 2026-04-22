<?php

namespace App\Models;

use App\Models\EntityModel;

class TiModel extends EntityModel
{
    protected $table = "aaausers";
    protected $alias = "u";
    private ?int $id = null;
    private string $username = "";
    private string $password = "";
    private string $email = "";
    private ?int $id_role = null;
    private int $id_status = 1; // Cambiado a int con valor por defecto
    private string $created_at = "";
    private string $updated_at  = "";

    public function getId()
    {
        return $this->id;
    }
    public function setId(int $id)
    {
        $this->id = $id;
    }

    public function getUsername()
    {
        return $this->username;
    }

    public function setUsername(string $username)
    {
        $this->username = $username;
    }

    public function getPassword()
    {
        return $this->password;
    }

    public function setPassword(string $password)
    {
        $this->password = $password;
    }

    public function getEmail()
    {
        return $this->email;
    }

    public function setEmail(string $email)
    {
        $this->email = $email;
    }

    public function getId_role()
    {
        return $this->id_role;
    }

    public function setId_role(int $id_role)
    {
        $this->id_role = $id_role;
    }

    public function getIdStatus()
    {
        return $this->id_status;
    }

    public function setIdStatus(int $id_status)
    {
        $this->id_status = $id_status;
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public function setCreatedAt(string $created_at)
    {
        $this->created_at = $created_at;
    }

    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(string $updated_at)
    {
        $this->updated_at = $updated_at;
    }

    public function getTable()
    {
        return $this->table;
    }

    public function getPdo()
    {
        return $this->pdo;
    }

    public function insert()
    {
        $this->connect();

        $sql = "INSERT INTO " . $this->table . " 
                (username, password, email, id_role, id_status, created_at, updated_at)
                VALUES (:username, :password, :email, :id_role, :id_status, :created_at, :updated_at)";

        $stmt = $this->pdo->prepare($sql);

        // Usar bindParam para mayor seguridad
        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':password', $this->password);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':id_role', $this->id_role);
        $stmt->bindParam(':id_status', $this->id_status);
        $stmt->bindParam(':created_at', $this->created_at);
        $stmt->bindParam(':updated_at', $this->updated_at);

        return $stmt->execute();
    }

    // En TiModel.php - Nuevo método específico
    public function updateBasicInfo()
    {
        $this->connect();

        // Solo actualizamos username, email, id_status y updated_at
        $sql = "UPDATE " . $this->table . " 
            SET username = :username, 
                email = :email, 
                id_status = :id_status, 
                updated_at = :updated_at 
            WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);

        // Usar bindParam para mayor seguridad
        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':username', $this->username);
        $stmt->bindParam(':email', $this->email);
        $stmt->bindParam(':id_status', $this->id_status);
        $stmt->bindParam(':updated_at', $this->updated_at);

        return $stmt->execute();
    }
    public function updatePassword()
    {
        $this->connect();

        // Solo actualizamos password y updated_at
        $sql = "UPDATE " . $this->table . " 
            SET password = :password, 
                updated_at = :updated_at 
            WHERE id = :id";

        $stmt = $this->pdo->prepare($sql);

        $stmt->bindParam(':id', $this->id);
        $stmt->bindParam(':password', $this->password);
        $stmt->bindParam(':updated_at', $this->updated_at);

        return $stmt->execute();
    }
}
