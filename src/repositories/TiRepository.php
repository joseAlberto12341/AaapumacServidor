<?php
namespace App\Repositories;

use App\Models\TiModel;

class TiRepository
{
    private $model;

    public function __construct()
    {
        $this->model = new TiModel();
    }

    public function getAllUsuarios()
    {
        $this->model->connect();
        
        $sql = "SELECT u.*, r.name as rol_nombre 
                FROM " . $this->model->getTable() . " u 
                LEFT JOIN aaaroles r ON u.id_role = r.id 
                ORDER BY u.id DESC";
        
        $stmt = $this->model->getPdo()->prepare($sql);
        $stmt->execute();
        
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }
    
    public function getUsuarioById($id)
    {
        $this->model->connect();
        
        $sql = "SELECT u.*, r.name as rol_nombre, s.name as status_nombre
                FROM " . $this->model->getTable() . " u 
                LEFT JOIN aaaroles r ON u.id_role = r.id 
                LEFT JOIN aaastatus s ON u.id_status = s.id 
                WHERE u.id = :id";
        
        $stmt = $this->model->getPdo()->prepare($sql);
        $stmt->execute([':id' => $id]);
        
        return $stmt->fetch(\PDO::FETCH_OBJ);
    }
    
    public function getEstados()
    {
        $this->model->connect();
        
        $sql = "SELECT * FROM aaastatus ORDER BY id";
        $stmt = $this->model->getPdo()->prepare($sql);
        $stmt->execute();
        
        return $stmt->fetchAll(\PDO::FETCH_OBJ);
    }
}
?>