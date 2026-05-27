<?php

namespace App\Controllers;

use App\Repositories\PublicRepository;

class PublicController
{
    // Constantes de configuración
    private const JOBS_PER_PAGE = 6;
    
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
        try {
            // OPCIÓN 2: Validación de página - Asegurar que sea un número positivo
            $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
            
            // Validar que la página sea un número positivo
            if ($page < 1 || !is_numeric($_GET['page'] ?? 1)) {
                $page = 1;
            }
            
            $limit = self::JOBS_PER_PAGE;
            
            // Obtener datos de jobs
            $jobsData = PublicRepository::getJobsByPage($page, $limit);
            
            // OPCIÓN 3: Validación de página máxima (SIN redirección)
            // Simplemente ajustamos a la última página si la solicitada excede
            if ($jobsData['total_pages'] > 0 && $page > $jobsData['total_pages']) {
                // En lugar de redirigir, obtenemos los datos de la última página
                $jobsData = PublicRepository::getJobsByPage($jobsData['total_pages'], $limit);
            }
            
            // Validación adicional: Si no hay registros, asegurar página 1
            if ($jobsData['total_records'] === 0) {
                $jobsData['current_page'] = 1;
                $jobsData['total_pages'] = 1;
            }
            
            return [
                'view' => 'public/jobs.php',
                'scripts' => 'prime',
                'data' => [
                    'title' => 'Bolsa de Trabajo',
                    'breadcrumb' => 'Bolsa'
                ],
                'jobs' => $jobsData['jobs'],
                'pagination' => [
                    'current_page' => $jobsData['current_page'],
                    'total_pages' => $jobsData['total_pages'],
                    'total_records' => $jobsData['total_records'],
                    'limit' => $jobsData['limit']
                ]
            ];
            
        } catch (\Exception $e) {
            // Manejo de errores - registrar error pero no mostrar al usuario
            error_log("Error en jobs controller: " . $e->getMessage());
            
            // Retornar datos vacíos pero con estructura válida
            return [
                'view' => 'public/jobs.php',
                'scripts' => 'prime',
                'data' => [
                    'title' => 'Bolsa de Trabajo',
                    'breadcrumb' => 'Bolsa'
                ],
                'jobs' => [],
                'pagination' => [
                    'current_page' => 1,
                    'total_pages' => 1,
                    'total_records' => 0,
                    'limit' => self::JOBS_PER_PAGE
                ]
            ];
        }
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