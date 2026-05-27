<?php 

namespace App\Models;

use App\Models\EntityModel;

class UserModel extends EntityModel
{
    protected $table = "aaausers";
    protected $alias = "u";
    private ?int $id = null;
    private string $username = "";
    private string $email = "";
    private string $password = "";
    private ?int $role = null;
    private string $created_at = "";
    private string $updated_at = "";

    /** 
     * @OneToOne(targetEntity="RolesModel")
     * @JoinColumn(name="role", referencedColumnName="id")
     */
    private ?RolesModel $name = null;

    public function getId()
    {
        return $this->id;
    }
    public function getUsername()
    {
        return $this->username;
    }
    public function setUsername(string $username)
    {
        $this->username = ucwords($username);
    }
    public function getEmail()
    {
        return $this->email;
    }
    public function setEmail(string $email)
    {
        $this->email = strtolower($email);
    }
    public function getPassword()
    {
        return $this->password;
    }
    public function setPassword(string $password)
    {
        $this->password = $password;
    }
    public function getRole()
    {
        return $this->role;
    }
    public function setRole(int $role)
    {
        $this->role = $role;
    }
    public function getName()
    {
        return $this->name;
    }
    public function setName(?RolesModel $name)
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
