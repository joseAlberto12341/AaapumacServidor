<?php

namespace App\Models;

use App\Models\EntityModel;

class ContactosModel extends EntityModel{
    protected $table = "contactos";
    protected $alias = "s";
    private ?int $id = null;
    private string $nombre = "";
    private string $email = "";
    private string $foto = "";
    private string $telefono = "";
    private string $patente = "";
    private string $r_social = "";

    public function getId()
    {
        return $this->id;
    }
    public function getNombre()
    {
        return $this->nombre;
    }
    public function setNombre(string $nombre)
    {
        $this->nombre = ucwords($nombre);
    }
    public function getEmail()
    {
        return $this->email;
    }
    public function setEmail(string $email)
    {
        $this->email = strtolower($email);
    }
    public function getFoto()
    {
        return $this->foto;
    }
    public function setFoto(string $foto)
    {
        $this->foto = $foto;
    }
    public function getTelefono()
    {
        return $this->telefono;
    }
    public function setTelefono(int $telefono)
    {
        $this->telefono = $telefono;
    }
    public function getPatente()
    {
        return $this->patente;
    }
    public function setPatente(string $patente)
    {
        $this->patente= $patente;
    }
    public function getRsocial()
    {
        return $this->r_social;
    }
    public function setRsocial(string $r_social)
    {
        $this->r_social= $r_social;
    }
    public function insert()
{
    $this->connect();

    $sql = "INSERT INTO " . $this->table . " (nombre, email, telefono,foto,patente, r_social) VALUES (?, ?, ?, ?,?,?)";
    $stmt = $this->pdo->prepare($sql);
    
    $stmt->execute([
        $this->getNombre(),
        $this->getEmail(),
        $this->getTelefono(),
        $this->getFoto(),
        $this->getPatente(),
        $this->getRsocial(),
    ]);
}
}