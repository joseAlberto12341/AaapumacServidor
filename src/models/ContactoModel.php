<?php
namespace Models;

use Utils\Database;
use PDO;

class ContactoModel {
    private $db;
    
    public function __construct() {
        $this->db = Database::getInstance();
    }
    
    public function guardarContacto($data) {
        try {
            // Buscar ID de estado 'contacto_nuevo'
            $stmt = $this->db->prepare("SELECT id FROM aaastatus WHERE name = 'contacto_nuevo' LIMIT 1");
            $stmt->execute();
            $status = $stmt->fetch(PDO::FETCH_ASSOC);
            $id_estatus = $status ? $status['id'] : 1;
            
            $query = "INSERT INTO contactos_formulario 
                     (nombre, email, asunto, mensaje, ip_address, user_agent, id_estatus) 
                     VALUES 
                     (:nombre, :email, :asunto, :mensaje, :ip_address, :user_agent, :id_estatus)";
            
            $stmt = $this->db->prepare($query);
            
            $stmt->bindParam(":nombre", $data['nombre']);
            $stmt->bindParam(":email", $data['email']);
            $stmt->bindParam(":asunto", $data['asunto']);
            $stmt->bindParam(":mensaje", $data['mensaje']);
            $stmt->bindParam(":ip_address", $data['ip_address']);
            $stmt->bindParam(":user_agent", $data['user_agent']);
            $stmt->bindParam(":id_estatus", $id_estatus);
            
            if ($stmt->execute()) {
                return $this->db->lastInsertId();
            }
            return false;
        } catch(\PDOException $e) {
            error_log("Error ContactoModel: " . $e->getMessage());
            return false;
        }
    }
    
    public function registrarLogSistema($id_user, $actionName, $statusName, $description, $ip_address, $user_agent) {
        try {
            // Obtener IDs
            $id_action = $this->getActionId($actionName);
            $id_status = $this->getStatusId($statusName);
            
            $query = "INSERT INTO aaalog 
                     (id_user, id_action, id_status, description, ip_address, user_agent) 
                     VALUES 
                     (:id_user, :id_action, :id_status, :description, :ip_address, :user_agent)";
            
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(":id_user", $id_user);
            $stmt->bindParam(":id_action", $id_action);
            $stmt->bindParam(":id_status", $id_status);
            $stmt->bindParam(":description", $description);
            $stmt->bindParam(":ip_address", $ip_address);
            $stmt->bindParam(":user_agent", $user_agent);
            
            return $stmt->execute();
        } catch(\PDOException $e) {
            error_log("Error LogSistema: " . $e->getMessage());
            return false;
        }
    }
    
    public function registrarLogCorreo($contacto_id, $tipo, $destinatario, $asunto, $estado, $error = null) {
        try {
            $query = "INSERT INTO correos_log 
                     (contacto_id, tipo, destinatario, asunto, estado, error_message) 
                     VALUES 
                     (:contacto_id, :tipo, :destinatario, :asunto, :estado, :error_message)";
            
            $stmt = $this->db->prepare($query);
            $stmt->bindParam(":contacto_id", $contacto_id);
            $stmt->bindParam(":tipo", $tipo);
            $stmt->bindParam(":destinatario", $destinatario);
            $stmt->bindParam(":asunto", $asunto);
            $stmt->bindParam(":estado", $estado);
            $stmt->bindParam(":error_message", $error);
            
            return $stmt->execute();
        } catch(\PDOException $e) {
            error_log("Error LogCorreo: " . $e->getMessage());
            return false;
        }
    }
    
    private function getActionId($actionName) {
        try {
            $stmt = $this->db->prepare("SELECT id FROM aaaactions WHERE name = :name");
            $stmt->bindParam(":name", $actionName);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ? $result['id'] : 1;
        } catch(\PDOException $e) {
            return 1;
        }
    }
    
    private function getStatusId($statusName) {
        try {
            $stmt = $this->db->prepare("SELECT id FROM aaastatus WHERE name = :name");
            $stmt->bindParam(":name", $statusName);
            $stmt->execute();
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            return $result ? $result['id'] : 1;
        } catch(\PDOException $e) {
            return 1;
        }
    }
}
?>