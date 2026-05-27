<?php

namespace App\Models;

use PDO;
use App\Models\EntityModel;

class PublicModel extends EntityModel
{
    protected $pdo;
    public function home()
    {
        echo "public/home.php";
    }
    
}
