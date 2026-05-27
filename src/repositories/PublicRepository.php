<?php

namespace App\Repositories;

use App\Models\ModalModel;
use App\Models\JobInfoModel;
use App\Models\UserModel;

class PublicRepository
{

    public static function listModal()
    {
        $modal = new ModalModel();
        return $modal->select(
            'm.id, m.title, m.description, m.image, m.visible, m.created_at, m.updated_at',
            [
                'where' => 'm.visible = :visible',
                'replaces' => [':visible' => 1]
            ],
        );
    }

    // NUEVO MÉTODO: Paginación manual con array_slice (funciona seguro)
    public static function getJobsByPage(int $page = 1, int $limit = 6)
    {
        $job = new JobInfoModel();
        
        // Obtener TODOS los jobs activos
        $allJobs = $job->select(
            'j.*',
            [
                'where' => 'j.id_status = 1',
                'order_by' => 'j.created_at DESC'
            ],
            false
        );
        
        // Asegurar que es un array
        if (!is_array($allJobs)) {
            $allJobs = [];
        }
        
        $totalRecords = count($allJobs);
        $totalPages = $totalRecords > 0 ? ceil($totalRecords / $limit) : 1;
        
        // Calcular offset
        $offset = ($page - 1) * $limit;
        
        // Paginación manual con array_slice
        $jobs = array_slice($allJobs, $offset, $limit);
        
        return [
            'jobs' => $jobs,
            'total_pages' => $totalPages,
            'total_records' => $totalRecords,
            'current_page' => $page,
            'limit' => $limit
        ];
    }

    // Método original (lo dejamos pero no lo usamos por ahora)
    public static function getJobsPaginated(int $limit, int $offset)
    {
        $job = new JobInfoModel();
        
        $allJobs = $job->select(
            'j.*',
            [
                'where' => 'j.id_status = 1'
            ],
            false
        );
        
        $totalRecords = is_array($allJobs) ? count($allJobs) : 0;
        $totalPages = $totalRecords > 0 ? ceil($totalRecords / $limit) : 1;
        
        $jobs = $job->select(
            'j.*',
            [
                'where' => 'j.id_status = 1',
                'order_by' => 'j.created_at DESC',
                'limit' => $limit,
                'offset' => $offset
            ],
            false
        );
        
        $currentPage = ($offset / $limit) + 1;
        
        return [
            'jobs' => $jobs ?: [],
            'total_pages' => $totalPages,
            'total_records' => $totalRecords,
            'current_page' => $currentPage,
            'limit' => $limit
        ];
    }

    public static function countActiveJobs()
    {
        $job = new JobInfoModel();
        
        $jobs = $job->select(
            'j.*',
            [
                'where' => 'j.id_status = 1'
            ],
            false
        );
        
        return is_array($jobs) ? count($jobs) : 0;
    }

    public static function getJobs()
    {
        $job = new JobInfoModel();
        return $job->select(
            'j.*',
            [
                'where' => 'j.id_status = 1',
                'order_by' => 'j.created_at DESC'
            ],
            false
        );
    }

    public static function getJob(int $id)
    {
        $job = new JobInfoModel();
        return $job->select(
            'j.*',
            [
                'where' => 'j.id = :id',
                'replaces' => [':id' => $id]
            ],
            true
        );
    }

    public static function getUsers()
    {
        $user = new UserModel();
        return $user->select(
            'u.id_user, u.username, u.email, u.password, u.id_role, u.created_at, u.updated_at',
            null,
            false
        );
    }
    
}   