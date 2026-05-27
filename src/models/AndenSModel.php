<?php

namespace App\Models;

use App\Models\EntityModel;

class AndenSModel extends EntityModel
{
    protected $table = "tbestatusandenessanpedrito";
    protected $alias = "s";

    // Propiedades privadas
    private ?int $id = null;
    private string $patente = "";
    private string $cd_dependiente = "";
    private string $nomdependiente = "";
    private string $horallegada = "";
    private string $nomverificador = "";
    private string $pedimento1 = "";
    private ?string $pedimento2 = null;
    private ?string $pedimento3 = null;
    private ?string $pedimento4 = null;
    private string $contenedor1 = "";
    private ?string $contenedor2 = null;
    private ?string $contenedor3 = null;
    private ?string $contenedor4 = null;
    private string $observaciones = "";
    private string $estatus = "";
    private string $estatusfecha = "";
    private ?string $created_at = "";
    private ?string $updated_at = "";
    private string $cd_verificador = "";

    // Métodos getter y setter
    public function getId()
    {
        return $this->id;
    }

    public function setId(?int $id)
    {
        $this->id = $id;
    }

    public function getPatente()
    {
        return $this->patente;
    }

    public function setPatente(string $patente)
    {
        $this->patente = $patente;
    }

    public function getCdDependiente()
    {
        return $this->cd_dependiente;
    }

    public function setCdDependiente(string $cd_dependiente)
    {
        $this->cd_dependiente = $cd_dependiente;
    }

    public function getNomDependiente()
    {
        return $this->nomdependiente;
    }

    public function setNomDependiente(string $nomdependiente)
    {
        $this->nomdependiente = $nomdependiente;
    }

    public function getHoraLlegada()
    {
        return $this->horallegada;
    }

    public function setHoraLlegada(string $horallegada)
    {
        $this->horallegada = $horallegada;
    }

    public function getNomVerificador()
    {
        return $this->nomverificador;
    }

    public function setNomVerificador(string $nomverificador)
    {
        $this->nomverificador = $nomverificador;
    }

    public function getPedimento1()
    {
        return $this->pedimento1;
    }

    public function setPedimento1(string $pedimento1)
    {
        $this->pedimento1 = $pedimento1;
    }

    public function getPedimento2()
    {
        return $this->pedimento2;
    }

    public function setPedimento2(string $pedimento2)
    {
        $this->pedimento2 = $pedimento2;
    }

    public function getPedimento3()
    {
        return $this->pedimento3;
    }

    public function setPedimento3(string $pedimento3)
    {
        $this->pedimento3 = $pedimento3;
    }
    public function getPedimento4()
    {
        return $this->pedimento3;
    }

    public function setPedimento4(string $pedimento3)
    {
        $this->pedimento3 = $pedimento3;
    }

    public function getContenedor1()
    {
        return $this->contenedor1;
    }

    public function setContenedor1(string $contenedor1)
    {
        $this->contenedor1 = $contenedor1;
    }

    public function getContenedor2()
    {
        return $this->contenedor2;
    }

    public function setContenedor2(string $contenedor2)
    {
        $this->contenedor2 = $contenedor2;
    }

    public function getContenedor3()
    {
        return $this->contenedor3;
    }

    public function setContenedor3(string $contenedor3)
    {
        $this->contenedor3 = $contenedor3;
    }
    public function getContenedor4()
    {
        return $this->contenedor3;
    }

    public function setContenedor4(string $contenedor3)
    {
        $this->contenedor3 = $contenedor3;
    }

    public function getObservaciones()
    {
        return $this->observaciones;
    }

    public function setObservaciones(string $observaciones)
    {
        $this->observaciones = $observaciones;
    }

    public function getEstatus()
    {
        return $this->estatus;
    }

    public function setEstatus(string $estatus)
    {
        $this->estatus = $estatus;
    }

    public function getEstatusFecha()
    {
        return $this->estatusfecha;
    }

    public function setEstatusFecha(string $estatusfecha)
    {
        $this->estatusfecha = $estatusfecha;
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

    public function getCdVerificador()
    {
        return $this->cd_verificador;
    }

    public function setCdVerificador(string $cd_verificador)
    {
        $this->cd_verificador = $cd_verificador;
    }

    public function insert()
    {
        $this->connect();

        $sql = "INSERT INTO " . $this->table . " (
            patente, 
            cd_dependiente, 
            nomdependiente, 
            horallegada, 
            nomverificador, 
            pedimento1, 
            pedimento2, 
            pedimento3,
            pedimento4,  
            contenedor1, 
            contenedor2, 
            contenedor3,  
            contenedor4,
            observaciones, 
            estatus, 
            estatusfecha, 
            cd_verificador
        ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

        $stmt = $this->pdo->prepare($sql);

        $stmt->execute([
            $this->getPatente(),
            $this->getCdDependiente(),
            $this->getNomDependiente(),
            $this->getHoraLlegada(),
            $this->getNomVerificador(),
            $this->getPedimento1(),
            $this->getPedimento2(),
            $this->getPedimento3(),
            $this->getContenedor1(),
            $this->getContenedor2(),
            $this->getContenedor3(),
            $this->getObservaciones(),
            $this->getEstatus(),
            $this->getEstatusFecha(),
            $this->getCdVerificador(),
        ]);
    }
}
