<?php 

namespace App\Repositories;

use App\Models\ModalModel;

class ClientRepository
{
    public static function getModalList()
    {
        $modal = new ModalModel();
        return $modal->select(
            '*',
            null,
            false
        );

    }
}