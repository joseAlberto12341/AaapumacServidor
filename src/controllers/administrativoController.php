<?php
namespace App\Controllers;
use App\Repositories\AdministrativoRepository;
use App\Models\JobInfoModel;
use App\Models\InventarioModel;


class AdministrativoController
{
    
    public static function Home()
    {
        \Utils\AuthHelper::requireAuth(2);
        return [
            'view' => 'administrativo/home.php',
            'scripts' => 'administrativo',
            'action' => 'content',
        ];
    }

    public static function Profile()
    {
        \Utils\AuthHelper::requireAuth(2);
        return [
            'view' => 'administrativo/home.php',
            'scripts' => 'administrativo',
            'action' => 'content',
            'data' => [ 
                'title' => 'Mi Perfil',
                'subtitle' => 'Actualiza tu información personal',
            ],
        ];
    }
        public static function convenio()
    {
        \Utils\AuthHelper::requireAuth(2);
        return [
            'view' => 'administrativo/home.php',
            'scripts' => 'administrativo',
            'action' => 'convenio',
            'data' => [
                'title' => 'Convenios',
                'subtitle' => 'Convenios disponibles',
            ],
        ];
    }
    public static function serviAdmi()
    {
        \Utils\AuthHelper::requireAuth(2);
        return [
            'view' => 'administrativo/home.php',
            'scripts' => 'administrativo',
            'action' => 'serviAdmi'
        ];
    }
    //comienza la bolsa de trabajo
public static function Jobs()
{
    \Utils\AuthHelper::requireAuth(2);
    $jobs = AdministrativoRepository::listJobs();

    return [
        'view' => 'administrativo/home.php',
        'scripts' => 'administrativo',
        'action' => 'jobs',
        'data' => [
            'title' => 'Bolsa de Trabajo',
            'subtitle' => 'Empleos registrados',
            'button' => 'Agregar nuevo empleo',
            'icon' => 'mdi mdi-briefcase',
        ],
        'jobs' => $jobs,  // Para vistas que usan $jobs
        'answer' => [     // Para vistas que usan $answer
            'data' => [
                'title' => 'Bolsa de Trabajo',
                'subtitle' => 'Empleos registrados',
                'button' => 'Agregar nuevo empleo',
                'icon' => 'mdi mdi-briefcase',
            ],
            'jobs' => $jobs
        ]
    ];
}
    public static function serviAdministrativo()
    {
        \Utils\AuthHelper::requireAuth(2);
        return [
            'view' => 'administrativo/home.php',
            'scripts' => 'administrativo',
            'action' => 'serviAdministrativo'
        ];
    }
  public static function NewJob()
    {
        \Utils\AuthHelper::requireAuth(2);
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Limpiar HTML de los campos de texto
            if (isset($_POST['description'])) {
                $_POST['description'] = strip_tags($_POST['description']);
            }

            if (isset($_POST['responsibilities'])) {
                $_POST['responsibilities'] = strip_tags($_POST['responsibilities']);
            }

            // Procesar imagen si se subió
            $imagePath = '';
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/Aaapumac/src/views/assets/img/jobs/';

                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }

                $originalName = $_FILES['image']['name'];
                $fileExtension = pathinfo($originalName, PATHINFO_EXTENSION);
                $baseName = pathinfo($originalName, PATHINFO_FILENAME);
                $imageName = $baseName . '_' . uniqid() . '.' . $fileExtension;
                $uploadFile = $uploadDir . $imageName;

                if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                    $imagePath = '/Aaapumac/src/views/assets/img/jobs/' . $imageName;
                }
            }

            $_POST['image'] = $imagePath;

            $job = AdministrativoRepository::newJob();
            AdministrativoRepository::setJob($job, $_POST);


            $_SESSION['success_message'] = "¡Empleo guardado correctamente!";

            header('Location: /Aaapumac/administrativo/jobs');
            exit();
        }

        return [
            'view' => 'administrativo/home.php',
            'scripts' => 'administrativo',
            'action' => 'job',
            'data' => [
                'title' => 'Nuevo Empleo',
                'subtitle' => 'Agrega un nuevo empleo',
                'button' => 'Guardar',
                'icon' => 'mdi mdi-briefcase',
            ],
        ];
    } 
public static function editJob()
{
    \Utils\AuthHelper::requireAuth(2);
    // Si es POST (actualizar)
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        // Limpiar HTML de los campos de texto
        if (isset($_POST['description'])) {
            $_POST['description'] = strip_tags($_POST['description']);
        }

        if (isset($_POST['responsibilities'])) {
            $_POST['responsibilities'] = strip_tags($_POST['responsibilities']);
        }

        // Procesar nueva imagen si se subió
        $imagePath = '';
        if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
            $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/Aaapumac/src/views/assets/img/jobs/';

            if (!is_dir($uploadDir)) {
                mkdir($uploadDir, 0755, true);
            }

            $originalName = $_FILES['image']['name'];
            $fileExtension = pathinfo($originalName, PATHINFO_EXTENSION);
            $baseName = pathinfo($originalName, PATHINFO_FILENAME);
            $imageName = $baseName . '_' . uniqid() . '.' . $fileExtension;
            $uploadFile = $uploadDir . $imageName;

            if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                $imagePath = '/Aaapumac/src/views/assets/img/jobs/' . $imageName;
                $_POST['image'] = $imagePath;
            }
        } else {
            // Mantener la imagen actual si no se subió nueva
            $_POST['image'] = $_POST['current_image'] ?? '';
        }

        $jobId = $_POST['id'];
        $job = AdministrativoRepository::findJob($jobId);
        
        if ($job) {
            AdministrativoRepository::updateJob($job, $_POST);
            $_SESSION['success_message'] = "¡Empleo actualizado correctamente!";
        }

        header('Location: /Aaapumac/administrativo/jobs');
        exit();
    }

    // Si es GET (mostrar formulario)
    $id = $_GET['id'] ?? null;
    
    if (!$id) {
        header('Location: /Aaapumac/administrativo/jobs');
        exit();
    }
    
    $job = AdministrativoRepository::findJob($id);
    
    if (!$job) {
        header('Location: /Aaapumac/administrativo/jobs?error=empleo_no_encontrado');
        exit();
    }
    return [
        'view' => 'administrativo/home.php',
        'scripts' => 'administrativo',
        'action' => 'jobEdit',
        'data' => [
            'title' => 'Editar Empleo',
            'subtitle' => 'Edita el empleo existente',
            'button' => 'Actualizar',
            'icon' => 'mdi mdi-briefcase',
            'job' => $job,
        ],
    ];
}
    public static function Job()
    {
        \Utils\AuthHelper::requireAuth(2);
        // Si hay id, es EDITAR. Si no hay id, es CREAR
        $id = $_GET['id'] ?? null;

        if ($id) {
            // MODO EDICIÓN - Buscar el empleo existente
            $job = AdministrativoRepository::findJob($id);

            if (!$job) {
                header('Location: /Aaapumac/administrativo/jobs?error=job_not_found');
                exit;
            }

            $title = 'Editar Empleo';
            $subtitle = 'Edita un empleo';
            $button = 'Actualizar';
        } else {
           
            $job = null; // o un objeto vacío si tu sistema lo requiere
            $title = 'Nuevo Empleo';
            $subtitle = 'Crea un nuevo empleo';
            $button = 'Guardar';
        }

        return [
            'view' => 'administrativo/home.php',
            'scripts' => 'administrativo',
            'action' => 'job',
            'data' => [
                'title' => $title,
                'subtitle' => $subtitle,
                'button' => $button,
                'icon' => 'mdi mdi-briefcase',
            ],
            'job' => $job,
        ];
    }
        public static function Lock()//sirve para desbloquear un trabajo
    {
        \Utils\AuthHelper::requireAuth(2);
        $id = $_GET['id'];
        $job = new JobInfoModel();
        $job->update($id, 'id_status = 0', [//se trae el metodo update de entitymodel
            'where' => 'id = :id',
            'replaces' => [':id' => $id],
        ]);
        header('Location: /Aaapumac/administrativo/jobs');
    }
        
    public static function Unlock() //sirve para desbloquear un trabajo
    {
        \Utils\AuthHelper::requireAuth(2);
        $id = $_GET['id'];
        $job = new JobInfoModel();
        $job->update($id, 'id_status = 1', [
            'where' => 'id = :id',
            'replaces' => [':id' => $id],
        ]);
        header('Location: /Aaapumac/administrativo/jobs');
    }
    public static function UpdateJob()
    {
        \Utils\AuthHelper::requireAuth(2);
        $id = $_GET['id'];
        $job = AdministrativoRepository::findJob($id);

        if (!$job) {
            header('Location: /Aaapumac/administrativo/jobs?error=404');
            die();
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            AdministrativoRepository::setJob($job, $_POST);

            header('Location: /Aaapumac/administrativo/jobs');
            die();
        }

        return [
            'view' => 'administrativo/home.php',
            'scripts' => 'administrativo',
            'action' => 'job',
            'data' => [
                'title' => 'Editar Empleo',
                'subtitle' => 'Edita un empleo',
                'button' => 'Actualizar',
                'icon' => 'mdi mdi-briefcase',
                'job' => $job,
            ],
        ];
    }
    
    //me siento mal por las vacunassssssssssssss
    // public static function DeleteJob()
    // {
    //     $id = $_GET['id'];
    //     $job = AdministrativoRepository::findJob($id);

    //     if (!$job) {
    //         header('Location: /Aaapumac/administrativo/jobs?error=404');
    //         die();
    //     }

    //     AdministrativoRepository::delJob($job);
    //     header('Location: /Aaapumac/administrativo/jobs');
    // }


//termina bolsa de trabajo

    //comienza inventario

}