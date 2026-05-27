<?php
namespace App\Models;

use App\Models\EntityModel;

class FolioPedimentoModel extends EntityModel
{
    protected $table = "folio_pedimento";
    protected $alias = "f";
    
    private ?int $id = null;
    private ?int $user_id = null;
    private string $pedimento = "";
    private string $tipo_operacion = "";
    private string $clave_pedimento = "";
    private string $CR = "";
    private string $fecha = "";
    private string $Hora = "";
    private string $patente = "";
    private string $agente_aduanal = "";
    private string $razon_social = "";
    private string $telefono = "";
    private string $nombre_completo = "";
    private string $correo_electronico = "";
    private string $agencia_aduanal = "";
    private string $created_at = "";
    private string $folio = "";
    private string $Estatus = "";
    private string $Token = "";
    private string $folios_aduana = ""; // CORREGIDO: Nombre correcto
    private string $pedimentos_json = "";
    private ?int $total_pedimentos = 0;
    private bool $pdf_generado = false;
    private ?string $pdf_filename = null;
    private string $updated_at = "";

    // Getters
    public function getId(): ?int { return $this->id; }
    public function getUserId(): ?int { return $this->user_id; }
    public function getPedimento(): string { return $this->pedimento; }
    public function getTipoOperacion(): string { return $this->tipo_operacion; }
    public function getClavePedimento(): string { return $this->clave_pedimento; }
    public function getCR(): string { return $this->CR; }
    public function getFecha(): string { return $this->fecha; }
    public function getHora(): string { return $this->Hora; }
    public function getPatente(): string { return $this->patente; }
    public function getAgenteAduanal(): string { return $this->agente_aduanal; }
    public function getRazonSocial(): string { return $this->razon_social; }
    public function getTelefono(): string { return $this->telefono; }
    public function getNombreCompleto(): string { return $this->nombre_completo; }
    public function getCorreoElectronico(): string { return $this->correo_electronico; }
    public function getAgenciaAduanal(): string { return $this->agencia_aduanal; }
    public function getCreatedAt(): string { return $this->created_at; }
    public function getFolio(): string { return $this->folio; }
    public function getEstatus(): string { return $this->Estatus; }
    public function getToken(): string { return $this->Token; }
    public function getFoliosAduana(): string { return $this->folios_aduana; } // CORREGIDO
    public function getPedimentosJson(): string { return $this->pedimentos_json; }
    public function getTotalPedimentos(): ?int { return $this->total_pedimentos; }
    public function getPdfGenerado(): bool { return $this->pdf_generado; }
    public function getPdfFilename(): ?string { return $this->pdf_filename; }
    public function getUpdatedAt(): string { return $this->updated_at; }
    
    // Setters
    public function setId(?int $id): void { $this->id = $id; }
    public function setUserId(?int $user_id): void { $this->user_id = $user_id; }
    public function setPedimento(string $pedimento): void { $this->pedimento = $pedimento; }
    public function setTipoOperacion(string $tipo_operacion): void { $this->tipo_operacion = $tipo_operacion; }
    public function setClavePedimento(string $clave_pedimento): void { $this->clave_pedimento = $clave_pedimento; }
    public function setCR(string $CR): void { $this->CR = $CR; }
    public function setFecha(string $fecha): void { $this->fecha = $fecha; }
    public function setHora(string $Hora): void { $this->Hora = $Hora; }
    public function setPatente(string $patente): void { $this->patente = $patente; }
    public function setAgenteAduanal(string $agente_aduanal): void { $this->agente_aduanal = $agente_aduanal; }
    public function setRazonSocial(string $razon_social): void { $this->razon_social = $razon_social; }
    public function setTelefono(string $telefono): void { $this->telefono = $telefono; }
    public function setNombreCompleto(string $nombre_completo): void { $this->nombre_completo = $nombre_completo; }
    public function setCorreoElectronico(string $correo_electronico): void { $this->correo_electronico = $correo_electronico; }
    public function setAgenciaAduanal(string $agencia_aduanal): void { $this->agencia_aduanal = $agencia_aduanal; }
    public function setCreatedAt(string $created_at): void { $this->created_at = $created_at; }
    public function setFolio(string $folio): void { $this->folio = $folio; }
    public function setEstatus(string $Estatus): void { $this->Estatus = $Estatus; }
    public function setToken(string $Token): void { $this->Token = $Token; }
    public function setFoliosAduana(string $folios_aduana): void { $this->folios_aduana = $folios_aduana; } // CORREGIDO
    public function setPedimentosJson(string $pedimentos_json): void { $this->pedimentos_json = $pedimentos_json; }
    public function setTotalPedimentos(?int $total_pedimentos): void { $this->total_pedimentos = $total_pedimentos; }
    public function setPdfGenerado(bool $pdf_generado): void { $this->pdf_generado = $pdf_generado; }
    public function setPdfFilename(?string $pdf_filename): void { $this->pdf_filename = $pdf_filename; }
    public function setUpdatedAt(string $updated_at): void { $this->updated_at = $updated_at; }
    
    /**
     * Cargar datos desde un array
     */
    public function loadFromArray(array $data): void
    {
        if (isset($data['id'])) $this->id = (int)$data['id'];
        if (isset($data['user_id'])) $this->user_id = (int)$data['user_id'];
        if (isset($data['pedimento'])) $this->pedimento = $data['pedimento'];
        if (isset($data['tipo_operacion'])) $this->tipo_operacion = $data['tipo_operacion'];
        if (isset($data['clave_pedimento'])) $this->clave_pedimento = $data['clave_pedimento'];
        if (isset($data['CR'])) $this->CR = $data['CR'];
        if (isset($data['fecha'])) $this->fecha = $data['fecha'];
        if (isset($data['Hora'])) $this->Hora = $data['Hora'];
        if (isset($data['patente'])) $this->patente = $data['patente'];
        if (isset($data['agente_aduanal'])) $this->agente_aduanal = $data['agente_aduanal'];
        if (isset($data['razon_social'])) $this->razon_social = $data['razon_social'];
        if (isset($data['telefono'])) $this->telefono = $data['telefono'];
        if (isset($data['nombre_completo'])) $this->nombre_completo = $data['nombre_completo'];
        if (isset($data['correo_electronico'])) $this->correo_electronico = $data['correo_electronico'];
        if (isset($data['agencia_aduanal'])) $this->agencia_aduanal = $data['agencia_aduanal'];
        if (isset($data['created_at'])) $this->created_at = $data['created_at'];
        if (isset($data['folio'])) $this->folio = $data['folio'];
        if (isset($data['Estatus'])) $this->Estatus = $data['Estatus'];
        if (isset($data['Token'])) $this->Token = $data['Token'];
        if (isset($data['folios_aduana'])) $this->folios_aduana = $data['folios_aduana']; // CORREGIDO
        if (isset($data['pedimentos_json'])) $this->pedimentos_json = $data['pedimentos_json'];
        if (isset($data['total_pedimentos'])) $this->total_pedimentos = (int)$data['total_pedimentos'];
        if (isset($data['pdf_generado'])) $this->pdf_generado = (bool)$data['pdf_generado'];
        if (isset($data['pdf_filename'])) $this->pdf_filename = $data['pdf_filename'];
        if (isset($data['updated_at'])) $this->updated_at = $data['updated_at'];
    }

    public function exists(): bool
    {
        return $this->id !== null && $this->id > 0;
    }
}