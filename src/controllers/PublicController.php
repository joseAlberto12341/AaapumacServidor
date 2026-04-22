<?php

namespace App\Controllers;

use App\Repositories\PublicRepository;

class PublicController
{
    public static function index()
    {
        $modal = PublicRepository::listModal();
        return [
            'view' => 'public/home.php',
            'modal' => $modal,
            'scripts' => 'prime'
        ];
    }

    public static function email()
    {
        return[
            'view'=> 'modules/email_as.php',
        ];
    }

public static function jobs()
{
    $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
    $limit = 6;
    
    $jobsData = PublicRepository::getJobsByPage($page, $limit);    
    return [
        'view' => 'public/jobs.php',
        'scripts' => 'prime',
        'data' => [
            'title' => 'Bolsa de Trabajo',
            'breadcrumb' => 'Bolsa'
        ],
        'jobs' => $jobsData['jobs'],
        'pagination' => $jobsData
    ];
}
    public static function conocenos()
    {
        return [
            'view' => 'public/conocenos.php',
            'scripts' => 'prime',
            'title' => '¿Quienes Somos?',
        ];
    }

    public static function politica()
    {
        return [
            'view' => 'public/politica.php',
            'scripts' => 'prime',
            'title' => 'Nuestra Política',
        ];
    }

    public static function capacitacion()
    {
        return [
            'view' => 'public/capacitacio.php',
            'scripts' => 'prime',
            'title' => 'Desarrollo de Talentos',
        ];
    }

    public static function contact()
    {
        return [
            'view' => 'public/contact.php',
            'scripts' => 'prime',
            'title' => 'Contacto',
        ];
    }

    public static function report()
    {
        return [
            'view' => 'public/report.php',
            'scripts' => 'prime',
            'title' => 'Reporte',
        ];
    }

    public static function terminos()
    {
        return [
            'view' => 'modules/terminos.php',
            'scripts' => 'prime',
        ];
    }

    public static function aviso()
    {
        return [
            'view' => 'modules/aviso.php',
            'scripts' => 'prime',
        ];
    }

    public static function depar()
    {
        return [
            'view' => 'public/depar.php',
            'scripts' => 'prime',
            'action' => 'depar'
        ];
    }

    public static function datoaAd()
    {
        return [
            'view' => 'public/datoaAd.php',
            'scripts' => 'prime',
            'action' => 'datoaAd'
        ];
    }

    public static function job()
    {
        $id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
        
        $job = PublicRepository::getJob($id);
        
        return [
            'view' => 'public/job.php',
            'scripts' => 'prime',
            'data' => [
                'title' => 'Bolsa de Trabajo',
                'breadcrumb' => 'Bolsa'
            ],
            'job' => $job
        ];
    }
}