<?php
namespace App\Controllers;
use App\Repositories\AsociadoCoordinadorRepository;

class AsociadoCoordinadorController
{
    public static function Home()
    {
        \Utils\AuthHelper::requireAuth(10);
        return [
            'view' => 'asociadoCoordinador/home.php',
            'scripts' => 'asociadoCoordinador',
            'action' => 'content',
        ];
    }

    public static function Profile()
    {
        \Utils\AuthHelper::requireAuth(10);
        return [
            'view' => 'asociadoCoordinador/home.php',
            'scripts' => 'asociadoCoordinador',
            'action' => 'content',
            'data' => [
                'title' => 'Mi Perfil',
                'subtitle' => 'Actualiza tu información personal',
            ],
        ];
    }

    public static function listadoPersonal()
    {
        \Utils\AuthHelper::requireAuth(10);
        $listadoPersonal = AsociadoCoordinadorRepository::listempleados();

        return [
            'view' => 'asociadoCoordinador/home.php',
            'scripts' => 'asociadoCoordinador',
            'action' => 'listadoPersonal',
            'data' => [
                'title' => 'Gestor de Asociados',
                'subtitle' => 'Asociados registrados',
                'button' => 'Agregar nuevo asociado',
                'icon' => 'mdi mdi-account-multiple',
            ],
            'listadoPersonal' => $listadoPersonal,
        ];
    }
    public static function serviAran()
    {
        \Utils\AuthHelper::requireAuth(10);
        return [
            'view' => 'asociadoCoordinador/home.php',
            'scripts' => 'asociadoCoordinador',
            'action' => 'serviAran',
        ];
    }
        public static function serviJuri()
    {
        return [
            'view' => 'asociadoCoordinador/home.php',
            'scripts' => 'asociadoCoordinador',
            'action' => 'serviJuri',
        ];
    }
    public static function AltaPersonal()
    {
        \Utils\AuthHelper::requireAuth(10);
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {


            // Validar y limpiar datos
            $username = trim($_POST['username'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $id_status = $_POST['id_status'] ?? 1;

            // FORZAR id_role = 9 (Asociado) - por si acaso
            $id_role = 9;

            // Validaciones básicas
            if (empty($username) || empty($email) || empty($password)) {
                $_SESSION['error_message'] = "Todos los campos son obligatorios";
                header('Location: /Aaapumac/asociadoCoordinador/AltaPersonal');
                exit();
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['error_message'] = "El formato del email no es válido";
                header('Location: /Aaapumac/asociadoCoordinador/AltaPersonal');
                exit();
            }

            // Hashear la contraseña
            $hashedPassword = password_hash($password, PASSWORD_DEFAULT);

            // Preparar datos - FORZAR explícitamente el rol 9
            $userData = [
                'username' => $username,
                'email' => $email,
                'password' => $hashedPassword,
                'id_role' => $id_role, // Forzado a 9
                'id_status' => $id_status
            ];

            // Después de guardar el usuario
            $user = AsociadoCoordinadorRepository::nuevoPersonal();
            $result = AsociadoCoordinadorRepository::setPersonal($user, $userData);

            if ($result) {
                $_SESSION['success_message'] = "¡Asociado agregado correctamente!";
            } else {
                $_SESSION['error_message'] = "Error al agregar el asociado";
            }


        }

        return [
            'view' => 'asociadoCoordinador/home.php',
            'scripts' => 'asociadoCoordinador',
            'action' => 'AltaPersonal',
            'data' => [
                'title' => 'Nuevo Asociado',
                'subtitle' => 'Agrega un nuevo asociado',
                'button' => 'Guardar',
                'icon' => 'mdi mdi-account-plus',
            ],
        ];
    }
    public static function editarPersonal()
    {
        \Utils\AuthHelper::requireAuth(10);
        // Obtener user_id de GET
        $user_id = $_GET['id'] ?? ($_POST['user_id'] ?? null);

        if (!$user_id) {
            $_SESSION['error_message'] = "ID de asociado no especificado";
            header('Location: /Aaapumac/asociadoCoordinador/listadoPersonal');
            exit();
        }

        // Obtener el objeto directamente
        $personalObj = AsociadoCoordinadorRepository::getPersonalById($user_id);

        if (!$personalObj || !$personalObj->exists()) {
            $_SESSION['error_message'] = "Asociado no encontrado";
            header('Location: /Aaapumac/asociadoCoordinador/listadoPersonal');
            exit();
        }

        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Procesar actualización
            $username = trim($_POST['username'] ?? '');
            $email = trim($_POST['email'] ?? '');
            $password = $_POST['password'] ?? '';
            $id_status = $_POST['id_status'] ?? 1;

            if (empty($username) || empty($email)) {
                $_SESSION['error_message'] = "Username y Email son obligatorios";
                header("Location: /Aaapumac/asociadoCoordinador/editarPersonal?id={$user_id}");
                exit();
            }

            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['error_message'] = "El formato del email no es válido";
                header("Location: /Aaapumac/asociadoCoordinador/editarPersonal?id={$user_id}");
                exit();
            }

            $userData = [
                'user_id' => $user_id,
                'username' => $username,
                'email' => $email,
                'id_status' => $id_status,
                'id_role' => 9
            ];

            if (!empty($password)) {
                $userData['password'] = password_hash($password, PASSWORD_DEFAULT);
            }

            // Usar updatePersonal
            $result = AsociadoCoordinadorRepository::updatePersonal($user_id, $userData);

            if ($result) {
                $_SESSION['success_message'] = "¡Asociado actualizado correctamente!";
            } else {
                $_SESSION['error_message'] = "Error al actualizar el asociado";
            }

            header('Location: /Aaapumac/asociadoCoordinador/listadoPersonal');
            exit();
        }

        return [
            'view' => 'asociadoCoordinador/home.php',
            'scripts' => 'asociadoCoordinador',
            'action' => 'EditarPersonal',
            'data' => [
                'title' => 'Editar Asociado',
                'subtitle' => 'Actualiza la información del asociado',
                'button' => 'Actualizar',
                'icon' => 'mdi mdi-account-edit',
                'personal' => $personalObj, // Ya es un objeto listo para usar
            ],
        ];
    }

    public static function informacionGeneral()
    {
        \Utils\AuthHelper::requireAuth(10);

        // Obtener el ID del asociado desde GET o POST
        $user_id = $_GET['id'] ?? ($_POST['user_id'] ?? null);

        if (!$user_id) {
            $_SESSION['error_message'] = "ID de asociado no especificado";
            header('Location: /Aaapumac/asociadoCoordinador/listadoPersonal');
            exit();
        }
        if ($_SERVER['REQUEST_METHOD'] == 'POST') {
            // Validar y limpiar datos
            $patente = trim($_POST['patente'] ?? '');
            $agente_aduanal = trim($_POST['agente_aduanal'] ?? '');
            $razon_social = trim($_POST['razon_social'] ?? '');
            $telefono = trim($_POST['telefono'] ?? '');
            $nombre_completo = trim($_POST['nombre_completo'] ?? '');
            $correo_electronico = trim($_POST['correo_electronico'] ?? '');
            $agencia_aduanal = trim($_POST['agencia_aduanal'] ?? '');
            $fecha = trim($_POST['fecha'] ?? '');

            // Validaciones
            $camposObligatorios = [
                'Patente' => $patente,
                'Agente aduanal' => $agente_aduanal,
                'Razón social' => $razon_social,
                'Teléfono' => $telefono,
                'Nombre completo' => $nombre_completo,
                'Correo electrónico' => $correo_electronico,
                'Agencia aduanal' => $agencia_aduanal,
                'Fecha' => $fecha
            ];

            $camposVacios = array_filter($camposObligatorios, function ($valor) {
                return empty($valor);
            });

            if (!empty($camposVacios)) {
                $campos = implode(', ', array_keys($camposVacios));
                $_SESSION['error_message'] = "Los siguientes campos son obligatorios: " . $campos;
                header("Location: /Aaapumac/asociadoCoordinador/informacionGeneral?id={$user_id}");
                exit();
            }

            if (!filter_var($correo_electronico, FILTER_VALIDATE_EMAIL)) {
                $_SESSION['error_message'] = "El formato del email no es válido";
                header("Location: /Aaapumac/asociadoCoordinador/informacionGeneral?id={$user_id}");
                exit();
            }

            // Validar formato de fecha
            if (!strtotime($fecha)) {
                $_SESSION['error_message'] = "El formato de fecha no es válido";
                header("Location: /Aaapumac/asociadoCoordinador/informacionGeneral?id={$user_id}");
                exit();
            }

            // Preparar datos para guardar
            $infoData = [
                'user_id' => $user_id,
                'patente' => $patente,
                'agente_aduanal' => $agente_aduanal,
                'razon_social' => $razon_social,
                'telefono' => $telefono,
                'nombre_completo' => $nombre_completo,
                'correo_electronico' => $correo_electronico,
                'agencia_aduanal' => $agencia_aduanal,
                'fecha' => $fecha
            ];

            // Guardar en la base de datos
            $resultado = AsociadoCoordinadorRepository::guardarInformacionGeneral($infoData);

            if ($resultado) {
                $_SESSION['success_message'] = "¡Información general guardada correctamente!";
            } else {
                $_SESSION['error_message'] = "Error al guardar la información general";
            }

            header("Location: /Aaapumac/asociadoCoordinador/listadoPersonal");
            exit();
        }

        // Para GET - Cargar información existente
        $informacionExistente = AsociadoCoordinadorRepository::obtenerInformacionGeneral($user_id);

        // Obtener información básica del usuario para mostrar
        $usuarioInfo = AsociadoCoordinadorRepository::getPersonalById($user_id);

        return [
            'view' => 'asociadoCoordinador/home.php',
            'scripts' => 'asociadoCoordinador',
            'action' => 'informacionGeneral',
            'data' => [
                'title' => 'Información General del Asociado',
                'subtitle' => $usuarioInfo ? 'Para: ' . $usuarioInfo->getUsername() : 'Añadir información general',
                'button' => $informacionExistente ? 'Actualizar Información' : 'Guardar Información',
                'icon' => 'mdi mdi-account-card-details',
            ],
            'user_id' => $user_id,
            'informacionExistente' => $informacionExistente,
            'usuarioInfo' => $usuarioInfo
        ];
    }
public static function verPersonal()
{
    \Utils\AuthHelper::requireAuth(10);
    $user_id = $_GET['id'] ?? null;

    if (!$user_id) {
        $_SESSION['error_message'] = "ID de asociado no especificado";
        header('Location: /Aaapumac/asociadoCoordinador/listadoPersonal');
        exit();
    }

    // Obtener información
    $informacionExistente = AsociadoCoordinadorRepository::obtenerInformacionGeneral($user_id);
    $usuarioInfo = AsociadoCoordinadorRepository::getPersonalById($user_id);

    // ESTRUCTURA CORREGIDA - TODO dentro de 'data'
    return [
        'view' => 'asociadoCoordinador/home.php',
        'scripts' => 'asociadoCoordinador',
        'action' => 'verPersonal',
        'data' => [
            'title' => 'Información General - Solo Lectura',
            'subtitle' => $usuarioInfo ? 'Asociado: ' . $usuarioInfo->getUsername() : 'Información del asociado',
            'icon' => 'mdi mdi-account-eye',
            // VARIABLES CLAVE - ahora dentro de data
            'user_id' => $user_id,
            'informacionExistente' => $informacionExistente,
            'usuarioInfo' => $usuarioInfo
        ]
    ];
}
public static function aso()
{
    \Utils\AuthHelper::requireAuth(10);
    // Obtener el ID del usuario LOGUEADO, no de GET
    $user_id = $_SESSION['id_user'] ?? null;

    if (!$user_id) {
        $_SESSION['error_message'] = "No hay una sesión activa";
        header('Location: /Aaapumac/asociadoCoordinador/listadoPersonal');
        exit();
    }

    // Obtener información
    $informacionExistente = AsociadoCoordinadorRepository::obtenerInformacionGeneral($user_id);
    $usuarioInfo = AsociadoCoordinadorRepository::getPersonalById($user_id);

    return [
        'view' => 'asociadoCoordinador/home.php',
        'scripts' => 'asociadoCoordinador',
        'action' => 'aso',
        'data' => [
            'title' => 'Mi Perfil',
            'subtitle' => $usuarioInfo ? 'Bienvenido: ' . $usuarioInfo->getUsername() : 'Mi información personal',
            'icon' => 'mdi mdi-account',
            // VARIABLES CLAVE
            'user_id' => $user_id,
            'informacionExistente' => $informacionExistente,
            'usuarioInfo' => $usuarioInfo
        ]
    ];
}
}