<?php
namespace App\Models;

use App\Models\EntityModel;

class InformacionGeneralModel extends EntityModel
{
    protected $table = "informacion_general";
    protected $alias = "ig";
    
    private ?int $id = null;
    private ?int $user_id = null;
    private string $patente = "";
    private string $agente_aduanal = "";
    private string $razon_social = "";
    private string $telefono = "";
    private string $nombre_completo = "";
    private string $correo_electronico = "";
    private string $agencia_aduanal = "";
    private string $fecha = "";
    private ?int $created_by = null;
    private string $created_at = "";
    private string $updated_at = "";
 
    // Getters
    public function getId(): ?int { return $this->id; }
    public function getUserId(): ?int { return $this->user_id; }
    public function getPatente(): string { return $this->patente; }
    public function getAgenteAduanal(): string { return $this->agente_aduanal; }
    public function getRazonSocial(): string { return $this->razon_social; }
    public function getTelefono(): string { return $this->telefono; }
    public function getNombreCompleto(): string { return $this->nombre_completo; }
    public function getCorreoElectronico(): string { return $this->correo_electronico; }
    public function getAgenciaAduanal(): string { return $this->agencia_aduanal; }
    public function getFecha(): string { return $this->fecha; }
    public function getCreatedBy(): ?int { return $this->created_by; }
    public function getCreatedAt(): string { return $this->created_at; }
    public function getUpdatedAt(): string { return $this->updated_at; }

    // Setters
    public function setId(?int $id): void { $this->id = $id; }
    public function setUserId(?int $user_id): void { $this->user_id = $user_id; }
    public function setPatente(string $patente): void { $this->patente = $patente; }
    public function setAgenteAduanal(string $agente_aduanal): void { $this->agente_aduanal = $agente_aduanal; }
    public function setRazonSocial(string $razon_social): void { $this->razon_social = $razon_social; }
    public function setTelefono(string $telefono): void { $this->telefono = $telefono; }
    public function setNombreCompleto(string $nombre_completo): void { $this->nombre_completo = $nombre_completo; }
    public function setCorreoElectronico(string $correo_electronico): void { $this->correo_electronico = $correo_electronico; }
    public function setAgenciaAduanal(string $agencia_aduanal): void { $this->agencia_aduanal = $agencia_aduanal; }
    public function setFecha(string $fecha): void { $this->fecha = $fecha; }
    public function setCreatedBy(?int $created_by): void { $this->created_by = $created_by; }
    public function setCreatedAt(string $created_at): void { $this->created_at = $created_at; }
    public function setUpdatedAt(string $updated_at): void { $this->updated_at = $updated_at; }

    /**
     * CARGAR DATOS DESDE ARRAY
     */
    public function loadFromArray(array $data): void
    {
        if (isset($data['id'])) $this->id = (int)$data['id'];
        if (isset($data['user_id'])) $this->user_id = (int)$data['user_id'];
        if (isset($data['patente'])) $this->patente = $data['patente'];
        if (isset($data['agente_aduanal'])) $this->agente_aduanal = $data['agente_aduanal'];
        if (isset($data['razon_social'])) $this->razon_social = $data['razon_social'];
        if (isset($data['telefono'])) $this->telefono = $data['telefono'];
        if (isset($data['nombre_completo'])) $this->nombre_completo = $data['nombre_completo'];
        if (isset($data['correo_electronico'])) $this->correo_electronico = $data['correo_electronico'];
        if (isset($data['agencia_aduanal'])) $this->agencia_aduanal = $data['agencia_aduanal'];
        if (isset($data['fecha'])) $this->fecha = $data['fecha'];
        if (isset($data['created_by'])) $this->created_by = (int)$data['created_by'];
        if (isset($data['created_at'])) $this->created_at = $data['created_at'];
        if (isset($data['updated_at'])) $this->updated_at = $data['updated_at'];
    }

    public function exists(): bool
    {
        return $this->id !== null && $this->id > 0;
    }
}