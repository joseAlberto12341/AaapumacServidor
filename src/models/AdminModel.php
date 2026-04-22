<?php

namespace App\Models;

use PDO;
use App\Models\EntityModel;

class AdminModel extends EntityModel
{
    protected $pdo;
    public function home()
    {
        echo "admin/home.php";
    }
}
