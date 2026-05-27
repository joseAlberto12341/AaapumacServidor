<?php

namespace App\Models;

use App\Models\EntityModel;

class CategoryModel extends EntityModel
{
    protected $table = "aaacategory";
    protected $alias = "c";
    private ?int $id = null;
    private string $name = "";
    private string $created_at = "";

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
        $this->name = ucwords($name);
    }
    public function getCreatedAt()
    {
        return $this->created_at;
    }
    public function setCreatedAt(string $created_at)
    {
        $this->created_at = $created_at;
    }
}
