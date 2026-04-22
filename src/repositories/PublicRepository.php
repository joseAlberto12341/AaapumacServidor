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

    public static function getJobsPaginated(int $limit, int $offset)
    {
        $job = new JobInfoModel();
        
        // Obtener todos los jobs activos primero para contar
        $allJobs = $job->select(
            'j.*',
            [
                'where' => 'j.id_status = 1'
            ],
            false
        );
        
        $totalRecords = is_array($allJobs) ? count($allJobs) : 0;
        $totalPages = $totalRecords > 0 ? ceil($totalRecords / $limit) : 1;
        
        // Obtener jobs paginados
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
        
        return [
            'jobs' => $jobs ?: [],
            'total_pages' => $totalPages,
            'total_records' => $totalRecords,
            'current_page' => floor($offset / $limit) + 1,
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

    public static function getJobsByPage(int $page = 1, int $limit = 6)
    {
        $offset = ($page - 1) * $limit;
        return self::getJobsPaginated($limit, $offset);
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