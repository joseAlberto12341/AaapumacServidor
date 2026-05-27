<?php 

namespace App\Models;

use App\Models\EntityModel;

class UserRolesModel extends EntityModel
{
    protected $table = "aaarole_user";
    protected $alias = "ur";
    private ?int $id = null;
    private int $id_user;
    private int $id_role;
    private string $created_at;
    private string $updated_at;

    public function getId()
    {
        return $this->id;
    }
    public function getIdUser()
    {
        return $this->id_user;
    }
    public function setIdUser(int $id_user)
    {
        $this->id_user = $id_user;
    }
    public function getIdRole()
    {
        return $this->id_role;
    }
    public function setIdRole(int $id_role)
    {
        $this->id_role = $id_role;
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