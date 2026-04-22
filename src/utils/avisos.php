<?php
// config/anuncios_handler.php

class AnunciosHandler {
    private $pdo;
    private $host = 'develop.aaamzo.org.mx';
    private $dbname = 'aaapumac_pruebas';
    private $username = 'admin_prog';
    private $password = 'AaaMzo2021$';
    
    public $anuncios = [];
    public $total_anuncios = 0;
    public $expirados = ['expirados' => 0];
    public $col_class = 'col-12 col-md-6 col-lg-4';
    public $error = null;
    
    public function __construct() {
        $this->conectar();
        if (!$this->error) {
            $this->obtenerAnuncios();
        }
    }
    
    private function conectar() {
        try {
            $this->pdo = new PDO("mysql:host={$this->host};dbname={$this->dbname};charset=utf8", 
                                $this->username, $this->password);
            $this->pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
        }
    }
    
    private function obtenerAnuncios() {
        try {
            $query = "SELECT *, 
                     TIMESTAMPDIFF(HOUR, created_at, NOW()) as horas_pasadas,
                     GREATEST(0, 24 - TIMESTAMPDIFF(HOUR, created_at, NOW())) as horas_restantes
                     FROM aaamodal 
                     WHERE visible = 1 
                     AND created_at >= NOW() - INTERVAL 24 HOUR
                     ORDER BY created_at DESC ";
            
            $stmt = $this->pdo->query($query);
            $this->anuncios = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $this->total_anuncios = count($this->anuncios);
            
            // Determinar clase de columna según cantidad
            $this->determinarClaseColumna();
            
            // Obtener anuncios expirados
            $this->obtenerAnunciosExpirados();
            
        } catch (PDOException $e) {
            $this->error = $e->getMessage();
        }
    }
    
    private function determinarClaseColumna() {
        if ($this->total_anuncios == 1) {
            $this->col_class = 'col-12 col-md-10 col-lg-8';
        } elseif ($this->total_anuncios == 2) {
            $this->col_class = 'col-12 col-md-6 col-lg-6';
        } elseif ($this->total_anuncios == 3 || $this->total_anuncios == 4) {
            $this->col_class = 'col-12 col-md-6 col-lg-4';
        } elseif ($this->total_anuncios == 5 || $this->total_anuncios == 6) {
            $this->col_class = 'col-12 col-md-6 col-lg-4';
        }
    }
    
    private function obtenerAnunciosExpirados() {
        try {
            $query_expirados = "SELECT COUNT(*) as expirados FROM aaamodal 
                              WHERE visible = 1 
                              AND created_at < NOW() - INTERVAL 24 HOUR";
            $result = $this->pdo->query($query_expirados);
            $this->expirados = $result->fetch(PDO::FETCH_ASSOC);
        } catch (PDOException $e) {
            $this->expirados = ['expirados' => 0];
        }
    }
    
    // Métodos de utilidad para la vista
    public function getEstiloTiempo($horas_restantes) {
        if ($horas_restantes <= 4 && $horas_restantes > 0) {
            return 'color: #ffc107; font-weight: bold;';
        } elseif ($horas_restantes > 4) {
            return 'color: #28a745;';
        }
        return '';
    }
    
    public function getIconoTiempo($horas_restantes) {
        if ($horas_restantes <= 4 && $horas_restantes > 0) {
            return ' ';
        } elseif ($horas_restantes > 4) {
            return ' ';
        }
        return '';
    }
    
    public function getMinutosPasados($horas_pasadas) {
        return floor(($horas_pasadas - floor($horas_pasadas)) * 60);
    }
    
    public function getTiempoTranscurrido($horas_pasadas, $minutos_pasados) {
        if ($horas_pasadas < 1) {
            return $minutos_pasados . ' minutos';
        } elseif ($horas_pasadas < 24) {
            $texto = floor($horas_pasadas) . ' horas';
            if ($minutos_pasados > 0) {
                $texto .= ' ' . $minutos_pasados . ' minutos';
            }
            return $texto;
        } else {
            return floor($horas_pasadas / 24) . ' días';
        }
    }
    
    public function getTiempoRestante($horas_restantes) {
        if ($horas_restantes > 0) {
            $texto = "Activo por: " . floor($horas_restantes) . " horas más";
            if (($horas_restantes - floor($horas_restantes)) > 0) {
                $texto .= " " . round(($horas_restantes - floor($horas_restantes)) * 60) . " minutos";
            }
            return $texto;
        } else {
            return "Expira pronto";
        }
    }
    
    public function getProgresoWidth($horas_pasadas) {
        return min(100, ($horas_pasadas / 24) * 100);
    }
    
    public function getProgresoColor($horas_restantes) {
        return ($horas_restantes <= 4) ? '#ffc107' : '#28a745';
    }
}
?>