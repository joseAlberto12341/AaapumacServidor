<?php

namespace App\Controllers;

use App\Models\JobInfoModel;
use App\Models\UserModel;
use App\Repositories\AdminRepository;
use App\Models\InventarioModel;
use App\Models\ContactosModel;
use App\Models\AndenNModel;
// Cargar AuthHelper directamente SIEMPRE
require_once __DIR__ . '/../utils/AuthHelper.php';


class AdminController
{
    public static function Home()
    {
        \Utils\AuthHelper::requireAuth(1);
        return [
            'view' => 'admin/home.php',
            'scripts' => 'admin',
            'action' => 'content',
        ];
    }
   public static function Profile()
    {
        \Utils\AuthHelper::requireAuth(1);
        return [
            'view' => 'admin/home.php',
            'scripts' => 'admin',
            'action' => 'content',
            'data' => [
                'title' => 'Usuarios',
                'subtitle' => 'Información de tu perfil',
                'button' => 'Agregar Nuevo Usuario',
                'icon' => 'mdi mdi-account-outline',
            ],
            'usuario' => AdminRepository::getUsuarioList(), // Corregido
        ];
    }
    /* Comienza administracion */
    public static function serviAdmi()
    {
        \Utils\AuthHelper::requireAuth(1);
        return [
            'view' => 'admin/home.php',
            'scripts' => 'admin',
            'action' => 'serviAdmi'
        ];
    }
    public static function convenio()
    {
        \Utils\AuthHelper::requireAuth(1);
        return [
            'view' => 'admin/home.php',
            'scripts' => 'admin',
            'action' => 'convenio',
            'data' => [
                'title' => 'Convenios',
                'subtitle' => 'Convenios disponibles',
            ],
        ];
    }
    public static function inventario()
    {
        \Utils\AuthHelper::requireAuth(1);
        $inventario = new InventarioModel();
        $productos = $inventario->obtenerProductos();

        return [
            'view' => 'admin/home.php',
            'scripts' => 'admin',
            'action' => 'inventario',
            'data' => [
                'title' => 'Inventario',
                'subtitle' => 'Control de inventario',
                'button' => 'Agregar Nuevo Producto',
                'icon' => 'mdi mdi-cart-arrow-right',
                'productos' => $productos,
            ],
        ];
    }
    public static function producMas()
    {
        \Utils\AuthHelper::requireAuth(1);
        if (isset($_POST['id_producto'])) {
            $id_producto = $_POST['id_producto'];

            // Crear instancia del modelo
            $inventario = new InventarioModel();

            // Llamar al método de aumento
            if ($inventario->aumentarCantidad($id_producto, 1)) {
                // Redirige o muestra un mensaje de éxito
                header("Location: /Aaapumac/admin/inventario");
                exit;
            } else {
                // Muestra un mensaje de error
                echo "Error al aumentar la cantidad.";
            }
        }
    }
    public static function producMenos()
    {
        \Utils\AuthHelper::requireAuth(1);
        if (isset($_POST['id_producto'])) {
            $id_producto = $_POST['id_producto'];

            $inventario = new InventarioModel();

            if ($inventario->disminuirCantidad($id_producto, 1)) {
                // Redirige o muestra un mensaje de éxito
                header("Location: /Aaapumac/admin/inventario");
                exit;
            } else {
                // Muestra un mensaje de error
                echo "Error al disminuir la cantidad.";
            }
        }
    }
    public static function NewProduc()
    {
        \Utils\AuthHelper::requireAuth(1);
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $invent = AdminRepository::newProduc();

            AdminRepository::setProduc($invent, $_POST);
            header('Location: /Aaapumac/admin/inventario');
            exit();
        }
    }
    public static function Jobs()
    {
        \Utils\AuthHelper::requireAuth(1);
        $jobs = AdminRepository::listJobs();

        return [
            'view' => 'admin/home.php',
            'scripts' => 'admin',
            'action' => 'jobs',
            'data' => [
                'title' => 'Bolsa de Trabajo',
                'subtitle' => 'Empleos registrados',
                'button' => 'Agregar nuevo empleo',
                'icon' => 'mdi mdi-briefcase',
            ],
            'jobs' => $jobs,
        ];
    }
    public static function Lock()//sirve para desbloquear un trabajo
    {
        \Utils\AuthHelper::requireAuth(1);
        $id = $_GET['id'];
        $job = new JobInfoModel();
        $job->update($id, 'id_status = 0', [//se trae el metodo update de entitymodel
            'where' => 'id = :id',
            'replaces' => [':id' => $id],
        ]);
        header('Location: /Aaapumac/admin/jobs');
    }

    public static function Unlock()//sirve para desbloquear un trabajo
    {
        \Utils\AuthHelper::requireAuth(1);
        $id = $_GET['id'];
        $job = new JobInfoModel();
        $job->update($id, 'id_status = 1', [
            'where' => 'id = :id',
            'replaces' => [':id' => $id],
        ]);
        header('Location: /Aaapumac/admin/jobs');
    }
    /* termina administracion */

    /* comienza arancelario */
    public static function serviAran()
    {
        \Utils\AuthHelper::requireAuth(1);
        return [
            'view' => 'admin/home.php',
            'scripts' => 'admin',
            'action' => 'serviAran'
        ];
    }
    /* termina arancelario */

    /* Comienta sistemas */
    public static function serviTi()
    {
        \Utils\AuthHelper::requireAuth(1);
        return [
            'view' => 'admin/home.php',
            'scripts' => 'admin',

            'action' => 'serviTi'
        ];
    }
    /* termina sistemas */

    /* Comienza operativo */
    public static function serviOpe()
    {
        \Utils\AuthHelper::requireAuth(1);
        return [
            'view' => 'admin/home.php',
            'scripts' => 'admin',
            'action' => 'serviOpe'
        ];
    }
    /* termina operativo */

    /* Comienza callcenter */
    public static function serviCall()
    {
        \Utils\AuthHelper::requireAuth(1);
        return [
            'view' => 'admin/home.php',
            'scripts' => 'admin',
            'action' => 'serviCall'
        ];
    }
    /* termina callcenter */

    /* comienza navieras */
    public static function serviNavi()
    {
        \Utils\AuthHelper::requireAuth(1);
        return [
            'view' => 'admin/home.php',
            'scripts' => 'admin',
            'action' => 'serviNavi'
        ];
    }
    /* termina navieras */

    /* Comienza juridico */
    public static function serviJuri()
    {
        \Utils\AuthHelper::requireAuth(1);
        return [
            'view' => 'admin/home.php',
            'scripts' => 'admin',
            'action' => 'serviJuri'
        ];
    }
    /* termina juridico */

    /* comienza calidad */
    public static function serviCali()
    {
        \Utils\AuthHelper::requireAuth(1);
        return [
            'view' => 'admin/home.php',
            'scripts' => 'admin',
            'action' => 'serviCali'
        ];
    }

    /* termina calidad */
    public static function Modals()
    {
        \Utils\AuthHelper::requireAuth(1);
        return [
            'view' => 'admin/home.php',
            'scripts' => 'admin',
            'action' => 'modals',
            'data' => [
                'title' => 'Avisos',
                'subtitle' => 'Tienes  avisos registrados',
                'button' => 'Agregar nuevo aviso',
                'icon' => 'mdi mdi-bell-ring-outline',
            ],
            'modal' => $modal = AdminRepository::getModalList(),
        ];
    }
    public static function Modal()
    {
        \Utils\AuthHelper::requireAuth(1);
        return [
            'view' => 'admin/home.php',
            'scripts' => 'admin',
            'action' => 'modal',
            'data' => [
                'title' => 'Editar aviso',
                'subtitle' => 'Nuevos avisos',
                'button' => 'Agregar nuevo aviso',
                'icon' => 'mdi mdi-bell-ring-outline',
            ],
            'modal' => $modal = AdminRepository::getModalList(),
        ];
    }
    public static function EditarAviso()
    {
        \Utils\AuthHelper::requireAuth(1);
        $id = $_GET['id'];
        return [
            'view' => 'admin/home.php',
            'scripts' => 'admin',
            'action' => 'editarAviso',
            'data' => [
                'title' => 'Editar Aviso',
                'subtitle' => 'Modifica el aviso seleccionado',
                'button' => 'Actualizar aviso',
                'icon' => 'mdi mdi-bell-ring-outline',
            ],
            'aviso' => AdminRepository::findAviso($id),
        ];
    }
    public static function andenes()
    {
        \Utils\AuthHelper::requireAuth(1);
        return [
            'view' => 'admin/home.php',
            'scripts' => 'admin',
            'action' => 'andenes',
            'andenN' => $andenN = AdminRepository::getAndenList(),
            'andenS' => $andenNS = AdminRepository::getAndensList(),
        ];
    }

    /*  public static function validar()
     {
         return [
             'view'=> 'admin/home.php',
             'scripts'=> 'admin',
             'action'=> 'validar',
         ];
     } */
    public static function validarAnden()
    {
        \Utils\AuthHelper::requireAuth(1);
        // Obtener los valores del formulario POST
        $patente = $_POST['patente'] ?? '';
        $cd_Dependiente = $_POST['cd_dependiente'] ?? '';

        // Asegúrate de que los valores no estén vacíos
        if (empty($patente) || empty($cd_Dependiente)) {
            $_SESSION['message'] = 'Patente y/o CD Dependiente no proporcionados';
            header('Location: /Aaapumac/admin/profile');
            die();
        }
        // Llamar a la función del repositorio para validar
        $validar = AdminRepository::getValidar($patente, $cd_Dependiente);

        // Verificar si la validación es exitosa
        if ($validar) {
            // Guardar la patente y cd_dependiente en la sesión
            $_SESSION['patente'] = $patente;
            $_SESSION['cd_dependiente'] = $cd_Dependiente;

            // Redirigir a la página de andenes con la información
            header('Location: /admin/andenes');
            exit;
        } else {
            $_SESSION['message'] = 'Patente y/o CD Dependiente incorrectos';
            // No redirigir, solo enviar el control de vuelta a la página con el modal
            header('Location: /admin/serviOpe');
            die();
        }
    }

    public static function User()
    {
        \Utils\AuthHelper::requireAuth(1);
        $id = $_GET['id'];
        return [
            'view' => 'admin/home.php',
            'scripts' => 'admin',
            'action' => 'user',
            'data' => [
                'title' => 'Editar Usuario',
                'subtitle' => 'Edita un usuario',
                'button' => 'Actualizar',
                'icon' => 'mdi mdi-account-outline',
            ],
            'user' => $user = AdminRepository::findUser($id),
        ];
    }
    public static function validar()
    {
        \Utils\AuthHelper::requireAuth(1);
        // Obtener el listado de contactos desde el repositorio
        $contactos = AdminRepository::validarPatente();
        // Configurar los datos para la vista
        return [
            'view' => 'admin/home.php', // Ruta de la vista
            'scripts' => 'admin',
            'action' => 'trazabilidad',
            'data' => [
                'title' => 'Validación de Agente Aduanal',  // Título de la vista
                'subtitle' => 'Verifica si la patente está registrada',  // Subtítulo
            ],
            'contactos' => $contactos, // Asegúrate de que esta es la clave correcta
        ];
    }
    public static function Trazabilidad()
    {
        \Utils\AuthHelper::requireAuth(1);
        $contactos = AdminRepository::validarPatente();
        return [
            'view' => 'admin/home.php',
            'scripts' => 'admin',
            'action' => 'trazabilidad',
            'data' => [
                'title' => 'Validación de Agente Aduanal',  // Título de la vista
                'subtitle' => 'Verifica si la patente está registrada',  // Subtítulo
            ],
            'contactos' => $contactos,
        ];
    }

    public static function NewUser()
    {
        \Utils\AuthHelper::requireAuth(1);
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $users = AdminRepository::newUsers();

            AdminRepository::setUsers($users, $_POST);
            header('Location: /admin/users');
            exit();
        }
        \Utils\AuthHelper::requireAuth(1);
        return [
            'view' => 'admin/home.php',
            'scripts' => 'admin',
            'action' => 'user',
            'data' => [
                'title' => 'Nuevos Usuarios',
                'subtitle' => 'Agrega un nuevo Usuario',
                'button' => 'Guardar',
                'icon' => 'mdi mdi-briefcase',
                'action' => 'newuser',
            ],
        ];
    }
    public static function Registrar()
    {
        \Utils\AuthHelper::requireAuth(1);
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Registrar el usuario en la base de datos
            $regis = AdminRepository::registrarU();

            // Generar el código QR
            include_once __DIR__ . '/../views/admin/inc/userqr.php';
            $usuario = $_POST['usuario'];
            $contraseña = $_POST['contraseña'];
            $email = $_POST['email'];
            $ruta_qr = generarCodigoQR($usuario, $contraseña, $email);

            // Guardar la ruta del código QR en la base de datos
            AdminRepository::setUsuario($regis, array_merge($_POST, ['codigo_qr' => $ruta_qr]));

            // Redirigir a la página de perfil
            header('Location: /Aaapumac/admin/profile');
            exit();
        }
    }
    public static function Qr()
    {
        \Utils\AuthHelper::requireAuth(1);
        return [
            'view' => 'admin/home.php',
            'scripts' => 'admin',
            'action' => 'usersqr',
            'data' => [
                'title' => 'Usuarios',
                'subtitle' => 'Información de tu perfil',
                'button' => 'Agregar Nuevo Usuario',
                'icon' => 'mdi mdi-account-outline',
            ],
            'usuario' => $usuario = AdminRepository::getUsuarioList(),
        ];
    }
    public static function NewJob()
    {
        \Utils\AuthHelper::requireAuth(1);
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

            $job = AdminRepository::newJob();
            AdminRepository::setJob($job, $_POST);


            $_SESSION['success_message'] = "¡Empleo guardado correctamente!";

            header('Location: /Aaapumac/admin/jobs');
            exit();
        }

        return [
            'view' => 'admin/home.php',
            'scripts' => 'admin',
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
    \Utils\AuthHelper::requireAuth(1);
    // Si es POST (a
    // ctualizar)
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
        $job = AdminRepository::findJob($jobId);
        
        if ($job) {
            AdminRepository::updateJob($job, $_POST);
            $_SESSION['success_message'] = "¡Empleo actualizado correctamente!";
        }

        header('Location: /Aaapumac/admin/jobs');
        exit();
    }
    
    // Si es GET (mostrar formulario)
    $id = $_GET['id'] ?? null;
    
    if (!$id) {
        header('Location: /Aaapumac/admin/jobs');
        exit();
    }
    
    $job = AdminRepository::findJob($id);
    
    if (!$job) {
        header('Location: /Aaapumac/admin/jobs?error=empleo_no_encontrado');
        exit();
    }

    return [
        'view' => 'admin/home.php',
        'scripts' => 'admin',
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

    public static function Users()
    {
        \Utils\AuthHelper::requireAuth(1);
        $users = AdminRepository::getUserList();

        return [
            'view' => 'admin/home.php',
            'scripts' => 'admin',
            'action' => 'users',
            'data' => [
                'title' => 'Usuarios',
                'subtitle' => 'Tienes  usuarios registrados',
                'button' => 'Agregar nuevo usuario',
                'icon' => 'mdi mdi-account-plus',

            ],
            'users' => $users,
        ];
    }

    public static function addContact()
    {
        \Utils\AuthHelper::requireAuth(1);
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Crea una nueva instancia del modelo
            $contacto = AdminRepository::addContact();

            // Llena el modelo con los datos del formulario
            AdminRepository::setContac($contacto, $_POST);

            // Redirige a la página de operaciones
            header('Location: /admin/ops');
            exit(); // Asegúrate de detener la ejecución del script después de redirigir
        }

        return [
            'view' => 'admin/home.php',
            'scripts' => 'admin',
            'action' => 'ops',
        ];
    }


    public static function ActualizarAviso()
    {
        \Utils\AuthHelper::requireAuth(1);
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            $id = $_POST['id'];

            // Obtener el aviso actual
            $avisoActual = AdminRepository::findAviso($id);

            // Procesar la nueva imagen si se subió
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/Aaapumac/src/views/assets/img/modal/';

                // Crear directorio si no existe
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }

                // Mantener nombre original con identificador único
                $originalName = $_FILES['image']['name'];
                $fileExtension = pathinfo($originalName, PATHINFO_EXTENSION);
                $baseName = pathinfo($originalName, PATHINFO_FILENAME);
                $imageName = $baseName . '_' . uniqid() . '.' . $fileExtension;

                $uploadFile = $uploadDir . $imageName;

                // Verificar si el archivo ya existe
                if (file_exists($uploadFile)) {
                    $imageName = $baseName . '_' . uniqid() . '.' . $fileExtension;
                    $uploadFile = $uploadDir . $imageName;
                }

                // Mover el archivo subido
                if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                    // Eliminar la imagen anterior si existe
                    if ($avisoActual && $avisoActual->getImage()) {
                        $oldImagePath = $_SERVER['DOCUMENT_ROOT'] . $avisoActual->getImage();
                        if (file_exists($oldImagePath)) {
                            unlink($oldImagePath);
                        }
                    }
                    // GUARDAR LA RUTA COMPLETA
                    $imagePath = '/Aaapumac/src/views/assets/img/modal/' . $imageName;
                    $_POST['image'] = $imagePath;
                }
            } else {
                // Mantener la imagen actual si no se subió nueva
                $_POST['image'] = $avisoActual ? $avisoActual->getImage() : '';
            }

            // Actualizar el aviso
            $aviso = AdminRepository::updateAviso($id, $_POST);

            $_SESSION['success'] = "Aviso actualizado exitosamente";
            header('Location: /Aaapumac/admin/modals');
            exit();
        }
    }
    public static function NewAviso()
    {
        \Utils\AuthHelper::requireAuth(1);
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Procesar la imagen
            $imagePath = '';
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                // Ruta corregida
                $uploadDir = $_SERVER['DOCUMENT_ROOT'] . '/Aaapumac/src/views/assets/img/modal/';

                // Crear directorio si no existe
                if (!is_dir($uploadDir)) {
                    mkdir($uploadDir, 0755, true);
                }

                // Validar que sea una imagen
                $allowedTypes = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
                $fileType = $_FILES['image']['type'];

                if (!in_array($fileType, $allowedTypes)) {
                    $_SESSION['error'] = "Solo se permiten archivos de imagen (JPEG, PNG, GIF, WEBP)";
                    header('Location: /Aaapumac/admin/modals');
                    exit();
                }

                // Mantener el nombre original del archivo
                $originalName = $_FILES['image']['name'];
                $fileExtension = pathinfo($originalName, PATHINFO_EXTENSION);
                $baseName = pathinfo($originalName, PATHINFO_FILENAME);

                // Si quieres evitar duplicados, agregar un identificador único
                $imageName = $baseName . '_' . uniqid() . '.' . $fileExtension;

                $uploadFile = $uploadDir . $imageName;
                // Verificar si el archivo ya existe
                if (file_exists($uploadFile)) {
                    // Si existe, agregar un sufijo único
                    $imageName = $baseName . '_' . uniqid() . '.' . $fileExtension;
                    $uploadFile = $uploadDir . $imageName;
                }

                // Mover el archivo subido
                if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadFile)) {
                    // GUARDAR LA RUTA COMPLETA en la base de datos
                    $imagePath = '/Aaapumac/src/views/assets/img/modal/' . $imageName;
                    $_POST['image'] = $imagePath;
                } else {
                    $_SESSION['error'] = "Error al subir la imagen. Verifique los permisos del servidor.";
                    header('Location: /Aaapumac/admin/modals');
                    exit();
                }
            } else {
                $_SESSION['error'] = "Debe seleccionar una imagen válida";
                header('Location: /Aaapumac/admin/modals');
                exit();
            }

            $aviso = AdminRepository::addAviso();
            AdminRepository::setAviso($aviso, $_POST);

            $_SESSION['success'] = "Aviso creado exitosamente";
            header('Location: /Aaapumac/admin/modals');
            exit();
        }
    }
    public static function Job()
    {
        \Utils\AuthHelper::requireAuth(1);
        // Si hay id, es EDITAR. Si no hay id, es CREAR
        $id = $_GET['id'] ?? null;

        if ($id) {
            // MODO EDICIÓN - Buscar el empleo existente
            $job = AdminRepository::findJob($id);

            if (!$job) {
                header('Location: /Aaapumac/admin/jobs?error=job_not_found');
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
            'view' => 'admin/home.php',
            'scripts' => 'admin',
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

    public static function UpdateJob()
    {
        \Utils\AuthHelper::requireAuth(1);
        $id = $_GET['id'];
        $job = AdminRepository::findJob($id);

        if (!$job) {
            header('Location: /Aaapumac/admin/jobs?error=404');
            die();
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            AdminRepository::setJob($job, $_POST);

            header('Location: /Aaapumac/admin/jobs');
            die();
        }

        return [
            'view' => 'admin/home.php',
            'scripts' => 'admin',
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

    public static function DeleteJob()
    {
        \Utils\AuthHelper::requireAuth(1);
        $id = $_GET['id'];
        $job = AdminRepository::findJob($id);

        if (!$job) {
            header('Location: /Aaapumac/admin/jobs?error=404');
            die();
        }

        AdminRepository::delJob($job);
        header('Location: /Aaapumac/admin/jobs');
    }
}

