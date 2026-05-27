<?php

namespace App\Controllers;

use App\Repositories\TiRepository;
use App\Models\TiModel;

// Iniciar sesión si no está activa
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

class TiController
{
    public static function Home()
    {
        \Utils\AuthHelper::requireAuth(3);
        return [
            'view' => 'ti/home.php',
            'scripts' => 'ti',
            'action' => 'content',
        ];
    }

    public static function Profile()
    {
        \Utils\AuthHelper::requireAuth(3);
        return [
            'view' => 'ti/home.php',
            'scripts' => 'ti',
            'action' => 'content',
            'data' => [
                'title' => 'Mi Perfil',
                'subtitle' => 'Actualiza tu información personal',
            ],
        ];
    }

    public static function listaUsuarios()
    {
        \Utils\AuthHelper::requireAuth(3);
        $repository = new TiRepository();
        $usuarios = $repository->getAllUsuarios();

        return [
            'view' => 'ti/home.php',
            'scripts' => 'ti',
            'action' => 'listaUsuarios',
            'data' => [
                'title' => 'Gestión de Usuarios',
                'subtitle' => 'Administra los usuarios del sistema',
                'listaUsuarios' => $usuarios,
            ],
        ];
    }

    public static function nuevoUsuario()
    {
        \Utils\AuthHelper::requireAuth(3);

        // Procesar el formulario cuando se envía por POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            return self::guardarUsuario();
        }

        // Mostrar el formulario para GET
        return [
            'view' => 'ti/home.php',
            'scripts' => 'ti',
            'action' => 'nuevoUsuario',
            'data' => [
                'title' => 'Nuevo Usuario',
                'subtitle' => 'Crea un nuevo usuario para el sistema',
            ],
        ];
    }

    private static function guardarUsuario()
    {
        \Utils\AuthHelper::requireAuth(3);
        try {
            // Validar que todos los campos requeridos estén presentes
            if (
                empty($_POST['username']) || empty($_POST['password']) ||
                empty($_POST['email']) || empty($_POST['id_rol']) || empty($_POST['id_status'])
            ) {
                throw new \Exception('Todos los campos son requeridos');
            }

            // Crear instancia del modelo
            $model = new TiModel();

            // Hash de la contraseña para seguridad
            $hashedPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);

            // Asignar valores al modelo
            $model->setUsername(trim($_POST['username']));
            $model->setPassword($hashedPassword);
            $model->setEmail(trim($_POST['email']));
            $model->setId_role((int)$_POST['id_rol']);
            $model->setIdStatus((int)$_POST['id_status']);

            // Las fechas se asignan automáticamente por la base de datos
            // pero podemos asignarlas manualmente también
            $model->setCreatedAt(date('Y-m-d H:i:s'));
            $model->setUpdatedAt(date('Y-m-d H:i:s'));

            // Insertar en la base de datos
            $resultado = $model->insert();

            if ($resultado) {
                // Redireccionar a la lista de usuarios con mensaje de éxito
                header('Location: /Aaapumac/ti/listaUsuarios?success=1');
                exit;
            } else {
                throw new \Exception('Error al guardar el usuario');
            }
        } catch (\Exception $e) {
            // Redireccionar de vuelta al formulario con mensaje de error
            header('Location: /Aaapumac/ti/nuevoUsuario?error=' . urlencode($e->getMessage()));
            exit;
        }
    }

    public static function editarUsuario()
    {
        \Utils\AuthHelper::requireAuth(3);

        // Obtener el ID del usuario a editar
        $id = $_GET['id'] ?? null;

        if (!$id) {
            header('Location: /Aaapumac/ti/listaUsuarios?error=' . urlencode('ID de usuario no especificado'));
            exit;
        }

        // Procesar el formulario cuando se envía por POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            return self::actualizarUsuario($id);
        }

        // Obtener datos del usuario para mostrar en el formulario
        $repository = new TiRepository();
        $usuario = $repository->getUsuarioById($id);

        if (!$usuario) {
            header('Location: /Aaapumac/ti/listaUsuarios?error=' . urlencode('Usuario no encontrado'));
            exit;
        }

        // Obtener lista de estados disponibles
        $estados = $repository->getEstados();

        return [
            'view' => 'ti/home.php',
            'scripts' => 'ti',
            'action' => 'editarUsuario',
            'data' => [
                'title' => 'Editar Usuario',
                'subtitle' => 'Modifica la información del usuario',
                'usuario' => $usuario,
                'estados' => $estados,
                'id_usuario' => $id
            ],
        ];
    }

    private static function actualizarUsuario($id)
    {
        \Utils\AuthHelper::requireAuth(3);
        try {
            // Validar campos requeridos (solo username, email, id_status)
            if (empty($_POST['username']) || empty($_POST['email']) || empty($_POST['id_status'])) {
                throw new \Exception('Username, email y estado son campos requeridos');
            }

            // Validar formato de email
            if (!filter_var($_POST['email'], FILTER_VALIDATE_EMAIL)) {
                throw new \Exception('El formato del email no es válido');
            }

            // Crear instancia del modelo
            $model = new TiModel();

            // Asignar valores al modelo
            $model->setId($id);
            $model->setUsername(trim($_POST['username']));
            $model->setEmail(trim($_POST['email']));
            $model->setIdStatus((int)$_POST['id_status']);
            $model->setUpdatedAt(date('Y-m-d H:i:s'));

            // Actualizar en la base de datos
            $resultado = $model->updateBasicInfo();

            if ($resultado) {
                $_SESSION['success_message'] = 'Usuario editado exitosamente';
                header('Location: /Aaapumac/ti/listaUsuarios');
                exit;
            } else {
                throw new \Exception('Error al actualizar el usuario');
            }
        } catch (\Exception $e) {
            $_SESSION['error_message'] = $e->getMessage();
            header('Location: /Aaapumac/ti/editarUsuario?id=' . $id);
            exit;
        }
    }
    public static function CambiarPassword()
    {
        
        \Utils\AuthHelper::requireAuth(3);

        // Obtener el ID del usuario (puede ser el propio o uno específico)
        $id = $_GET['id'] ?? $_SESSION['user_id'] ?? null;

        if (!$id) {
            header('Location: /Aaapumac/ti/listaUsuarios?error=' . urlencode('ID de usuario no especificado'));
            exit;
        }

        // Procesar el formulario cuando se envía por POST
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            return self::actualizarPassword($id);
        }

        // Obtener datos del usuario para mostrar información
        $repository = new TiRepository();
        $usuario = $repository->getUsuarioById($id);

        if (!$usuario) {
            header('Location: /Aaapumac/ti/listaUsuarios?error=' . urlencode('Usuario no encontrado'));
            exit;
        }

        return [
            'view' => 'ti/home.php',
            'scripts' => 'ti',
            'action' => 'cambiarPassword',
            'data' => [
                'title' => 'Cambiar Contraseña',
                'subtitle' => 'Actualiza tu contraseña de acceso',
                'usuario' => $usuario,
                'id_usuario' => $id
            ],
        ];
    }

    private static function actualizarPassword($id)
    {
        \Utils\AuthHelper::requireAuth(3);
        try {
            // Validar que los campos no estén vacíos
            if (empty($_POST['password']) || empty($_POST['confirm_password'])) {
                throw new \Exception('Todos los campos son requeridos');
            }

            $password = $_POST['password'];
            $confirmPassword = $_POST['confirm_password'];

            // Validar que las contraseñas coincidan
            if ($password !== $confirmPassword) {
                throw new \Exception('Las contraseñas no coinciden');
            }

            // Validar longitud mínima de contraseña
            if (strlen($password) < 6) {
                throw new \Exception('La contraseña debe tener al menos 6 caracteres');
            }

            // Validar que la contraseña no sea solo espacios
            if (trim($password) === '') {
                throw new \Exception('La contraseña no puede estar vacía o contener solo espacios');
            }

            // Crear instancia del modelo
            $model = new TiModel();

            // Hashear la nueva contraseña
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Asignar valores al modelo
            $model->setId($id);
            $model->setPassword($hashedPassword);
            $model->setUpdatedAt(date('Y-m-d H:i:s'));

            // Actualizar solo la contraseña en la base de datos
            $resultado = $model->updatePassword();

            if ($resultado) {
                $_SESSION['success_message'] = 'Contraseña cambiada exitosamente';
                header('Location: /Aaapumac/ti/listaUsuarios');
                exit;
            } else {
                throw new \Exception('Error al actualizar la contraseña');
            }
        } catch (\Exception $e) {
            $_SESSION['error_message'] = $e->getMessage();
            header('Location: /Aaapumac/ti/CambiarPassword?id=' . $id);
            exit;
        }
    }
    public static function convenio()
    {
        \Utils\AuthHelper::requireAuth(3);
        return [
            'view' => 'ti/home.php',
            'scripts' => 'ti',
            'action' => 'convenio',
            'data' => [
                'title' => 'Convenios',
                'subtitle' => 'Consulta nuestros convenios y beneficios exclusivos para asociados',
                'button' => 'Ver convenios disponibles',
                'icon' => 'mdi mdi-handshake-outline',
            ],
        ];
    }
}
