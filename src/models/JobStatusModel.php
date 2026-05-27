<?php 

namespace App\Models;

use App\Models\EntityModel;

class JobStatusModel extends EntityModel
{
    protected $table = "jobstatus";
    protected $alias = "js";
    private ?int $id = null;
    private string $name = "";
    private string $created_at = "";
    private string $updated_at = "";

    public function getId()
    {
        return $this->id;
    }
    public function getName()
    {
        return $this->name;
    }
    public function setName(string $name)
    {
        $this->name = $name;
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
}