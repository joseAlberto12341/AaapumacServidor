<?php
namespace App\Models;

class NotificationModel
{
    private $id;
    private $id_user;
    private $title;
    private $message;
    private $is_read;
    private $id_related_record;
    private $created_at;

    public function __construct($data = [])
    {
        if (!empty($data)) {
            $this->loadFromArray($data);
        }
    }

    public function loadFromArray(array $data): void
    {
        $this->id = $data['id'] ?? null;
        $this->id_user = $data['id_user'] ?? null;
        $this->title = $data['title'] ?? '';
        $this->message = $data['message'] ?? '';
        $this->is_read = $data['is_read'] ?? false;
        $this->id_related_record = $data['id_related_record'] ?? null;
        $this->created_at = $data['created_at'] ?? '';
    }

    // Getters
    public function getId() { return $this->id; }
    public function getIdUser() { return $this->id_user; }
    public function getTitle() { return $this->title; }
    public function getMessage() { return $this->message; }
    public function getIsRead() { return $this->is_read; }
    public function getIdRelatedRecord() { return $this->id_related_record; }
    public function getCreatedAt() { return $this->created_at; }

    // Formatear fecha
    public function getFormattedDate()
    {
        if (empty($this->created_at)) return '';
        $date = new \DateTime($this->created_at);
        return $date->format('d/m/Y H:i');
    }
}