<?php

namespace App\Repositories;

use App\Models\AdminModel;
use App\Models\AndenNModel;
use App\Models\InventarioModel;
use App\Models\ModalModel;
use App\Models\UserModel;
use App\Models\JobInfoModel;
use App\Models\UsersModel;
use App\Models\UsuarioModel;
use App\Models\ContactosModel;
use App\Models\AndenSModel;


class AdminRepository extends BaseRepository
{
    protected static $model = JobInfoModel::class;
    protected static $usuario = UsuarioModel::class;

    public static function getAdminList()
    {
        $admin = new AdminModel();
        return $admin->select(
            '*',
            null,
            false
        );
    }

    /* usuarios */

    public static function setUsers(UsersModel $users, array $data)
    {
        if (isset($data['username'])) {
            $users->setUsername($data['username']);
        }
        if (isset($data['email'])) {
            $users->setEmail($data['email']);
        }
        if (isset($data['role'])) {
            $users->setRole($data['role']);
        }
        $users->insert();
    }
    public static function setUsuario(UsersModel $regis, array $data)
    {
        if (isset($data['usuario'])) {
            $regis->setUsername($data['usuario']); // setUsername en lugar de setUsuario
        }
        if (isset($data['email'])) {
            $regis->setEmail($data['email']);
        }
        if (isset($data['contraseña'])) {
            $regis->setPassword($data['contraseña']); // setPassword en lugar de setContraseña
        }
        if (isset($data['codigo_qr'])) {
            // Si necesitas guardar código QR, agrega esta propiedad a UsersModel
            // $regis->setCodigoQR($data['codigo_qr']);
        }
        if (isset($data['status'])) {
            $regis->setRole($data['status']); // Usa setRole para el status o crea un setStatus
        }
        $regis->insert();
    }
    public static function getUserList()
    {
        $users = new UsersModel();
        return $users->select(
            '*',
            null,
            false
        );
    }
    public static function newUsers()
    {
        return new UsersModel();
    }
    public static function registrarU()
    {
        return new UsuarioModel();
    }
    /* termina usuarios */

    /* Empieza avisos */
    public static function setAviso(ModalModel $aviso, array $data)
    {
        if (isset($data['title'])) {
            $aviso->setTitle($data['title']);
        }
        if (isset($data['description'])) {
            $aviso->setDescription($data['description']);
        }
        if (isset($data['image'])) {
            $aviso->setImage($data['image']);
        }
        if (isset($data['visible'])) {
            $aviso->setVisible($data['visible']);
        }
        if (isset($data['id_category'])) {
            $aviso->setIdCategory($data['id_category']);
        }
        $aviso->insert();
    }
    public static function addAviso()
    {
        return new ModalModel();
    }
    public static function getModalList()
    {
        $modal = new ModalModel();
        return $modal->select(
            '*',
            null,
            false
        );
    }
    public static function updateAviso($id, array $data)
    {
        $aviso = new ModalModel();

        // Buscar el aviso existente
        $existingAviso = $aviso->select('*', [
            'where' => 'id = :id',
            'replaces' => [':id' => $id],
        ], true);

        if (!$existingAviso) {
            return false;
        }

        // Actualizar campos
        if (isset($data['title'])) {
            $existingAviso->setTitle($data['title']);
        }
        if (isset($data['description'])) {
            $existingAviso->setDescription($data['description']);
        }
        if (isset($data['image'])) {
            $existingAviso->setImage($data['image']);
        }
        if (isset($data['visible'])) {
            $existingAviso->setVisible($data['visible']);
        }
        if (isset($data['id_category'])) {
            $existingAviso->setIdCategory($data['id_category']);
        }

        // Actualizar en la base de datos - CORREGIDO
        return $existingAviso->update($id, [
            'title' => $existingAviso->getTitle(),
            'description' => $existingAviso->getDescription(),
            'image' => $existingAviso->getImage(),
            'visible' => $existingAviso->getVisible(),
            'id_category' => $existingAviso->getIdCategory(),
            'updated_at' => date('Y-m-d H:i:s')
        ], [
            'where' => 'id = :id',
            'replaces' => [':id' => $id]
        ]);
    }
    /* termina avisos */
    /* andenes */
    public static function getAndenList()
    {
        $andenN = new AndenNModel();
        $filters = [
            'where' => 'patente = ? AND cd_dependiente = ?',
            'replaces' => [$_SESSION['patente'] ?? '', $_SESSION['cd_dependiente'] ?? '']
        ];
        return $andenN->select('*', $filters, false);
    }

    public static function getValidar($patente, $cd_dependiente)
    {
        $andenN = new AndenNModel();
        $filters = [
            'where' => 'patente = ? AND cd_dependiente = ?',
            'replaces' => [$patente, $cd_dependiente]
        ];

        $result = $andenN->select('*', $filters, false);
        return !empty($result);
    }
    /* andenes sanpedrito*/
    public static function getAndensList()
    {
        $andenS = new AndenSModel();
        $filters = [
            'where' => 'patente = ? AND cd_dependiente = ?',
            'replaces' => [$_SESSION['patente'] ?? '', $_SESSION['cd_dependiente'] ?? '']
        ];
        return $andenS->select('*', $filters, false);
    }

    public static function getValidars($patente, $cd_dependiente)
    {
        $andenS = new AndenNModel();
        $filters = [
            'where' => 'patente = ? AND cd_dependiente = ?',
            'replaces' => [$patente, $cd_dependiente]
        ];

        $result = $andenS->select('*', $filters, false);
        return !empty($result);
    }
    /* termina andenes */

    /* Empieza jobs */
    public static function setJob(JobInfoModel $job, array $data)
    {
        // Campos obligatorios
        if (isset($data['title'])) {
            $job->setTitle($data['title']);
        }
        if (isset($data['description'])) {
            $job->setDescription($data['description']);
        }
        if (isset($data['image'])) {
            $job->setImage($data['image']);
        }
        if (isset($data['vacancy'])) {
            $job->setVacancy($data['vacancy']);
        }

        if (isset($data['responsibilities'])) {
            $job->setResponsabilities($data['responsibilities']);
        }
        if (isset($data['education'])) {
            $job->setEducation($data['education']);
        }
        if (isset($data['experience'])) {
            $job->setExperience($data['experience']);
        }
        if (isset($data['additional'])) {
            $job->setAdditional($data['additional']);
        }
        if (isset($data['workexperience'])) {
            $job->setWorkexperience($data['workexperience']);
        }
        if (isset($data['salary'])) {
            $job->setSalary($data['salary']);
        }
        if (isset($data['contract_type'])) {
            $job->setContractType($data['contract_type']);
        }
        if (isset($data['benefits'])) {
            $job->setBenefits($data['benefits']);
        }
        if (isset($data['location'])) {
            $job->setLocation($data['location']);
        }
        if (isset($data['deadline'])) {
            $job->setDeadline($data['deadline']);
        }
        if (isset($data['id_status'])) {
            $job->setIdStatus($data['id_status']);
        }

        $job->insert();
    }
    public static function updateJob(JobInfoModel $job, array $data)
    {
        if (isset($data['title'])) {
            $job->setTitle($data['title']);
        }
        if (isset($data['description'])) {
            $job->setDescription($data['description']);
        }
        if (isset($data['image'])) {
            $job->setImage($data['image']);
        }
        if (isset($data['vacancy'])) {
            $job->setVacancy($data['vacancy']);
        }
        if (isset($data['responsibilities'])) {
            $job->setResponsabilities($data['responsibilities']);
        }
        if (isset($data['education'])) {
            $job->setEducation($data['education']);
        }
        if (isset($data['experience'])) {
            $job->setExperience($data['experience']);
        }
        if (isset($data['additional'])) {
            $job->setAdditional($data['additional']);
        }
        if (isset($data['workexperience'])) {
            $job->setWorkexperience($data['workexperience']);
        }
        if (isset($data['salary'])) {
            $job->setSalary($data['salary']);
        }
        if (isset($data['contract_type'])) {
            $job->setContractType($data['contract_type']);
        }
        if (isset($data['benefits'])) {
            $job->setBenefits($data['benefits']);
        }
        if (isset($data['location'])) {
            $job->setLocation($data['location']);
        }
        if (isset($data['deadline'])) {
            $job->setDeadline($data['deadline']);
        }
        if (isset($data['id_status'])) {
            $job->setIdStatus($data['id_status']);
        }

        // Actualizar en lugar de insertar
        return $job->update($job->getId(), [
            'title' => $job->getTitle(),
            'description' => $job->getDescription(),
            'image' => $job->getImage(),
            'vacancy' => $job->getVacancy(),
            'responsabilities' => $job->getResponsabilities(),
            'education' => $job->getEducation(),
            'experience' => $job->getExperience(),
            'additional' => $job->getAdditional(),
            'workexperience' => $job->getWorkexperience(),
            'salary' => $job->getSalary(),
            'contract_type' => $job->getContractType(),
            'benefits' => $job->getBenefits(),
            'location' => $job->getLocation(),
            'deadline' => $job->getDeadline(),
            'id_status' => $job->getIdStatus(),
            'updated_at' => date('Y-m-d H:i:s')
        ], [
            'where' => 'id = :id',
            'replaces' => [':id' => $job->getId()]
        ]);
    }
    public static function listJobs()
    {
        $jobs = new JobInfoModel();
        return $jobs->select(
            'j.id, j.title, j.description, j.image, j.vacancy, j.responsabilities, j.education, j.experience, j.additional, j.workexperience, j.salary, j.contract_type, j.benefits, j.location, j.id_status, j.deadline, j.created_at, j.updated_at',
            null,
        );
    }
    public static function findAviso($id)
    {
        $aviso = new ModalModel(); // O el modelo que uses para avisos
        return $aviso->select('*', [
            'where' => 'id = :id',
            'replaces' => [':id' => $id],
        ], true);
    }
    public static function newProduc()
    {
        return new InventarioModel();
    }
    public static function setProduc(InventarioModel $invent, array $data)
    {
        if (isset($data['nombre'])) {
            $invent->setNombre($data['nombre']);
        }
        if (isset($data['cantidad'])) {
            $invent->setCantidad($data['cantidad']);
        }
        if (isset($data['descripcion'])) {
            $invent->setDescripcion($data['descripcion']);
        }
        if (isset($data['fecha_ingreso'])) {
            $invent->setFechaIngreso($data['fecha_ingreso']);
        }
        $invent->insert();
    }
    public static function newJob()
    {
        return new JobInfoModel();
    }
    public static function editJob()
    {
        return new JobInfoModel();
    }
    public static function findJob($id)
    {
        $job = new JobInfoModel();
        return $job->select(
            '*',
            [
                'where' => 'id = :id',
                'replaces' => [':id' => $id]
            ],
            true
        );
    }
    public static function delJob($job)
    {
        $job->delete();
    }
    /* termina jobs */

    /* Empieza contactos */
    public static function setContac(ContactosModel $contacto, array $data)
    {
        if (isset($data['nombre'])) {
            $contacto->setNombre($data['nombre']);
        }
        if (isset($data['email'])) {
            $contacto->setEmail($data['email']);
        }
        if (isset($data['foto'])) {
            $contacto->setFoto($data['foto']);
        }
        if (isset($data['telefono'])) {
            $contacto->setTelefono($data['telefono']);
        }
        if (isset($data['patente'])) {
            $contacto->setPatente($data['patente']);
        }
        if (isset($data['r_social'])) {
            $contacto->setRsocial($data['r_social']);
        }

        $contacto->insert();
    }
    public static function addContact()
    {
        return new ContactosModel();
    }
    public static function ContactosList()
    {
        $contacts = new ContactosModel();
        return $contacts->select('*', null, );
    }
    public static function validarPatente()
    {
        $model = new ContactosModel();

        // Verificar si se está enviando la patente desde el formulario
        if (isset($_POST['patente']) && !empty($_POST['patente'])) {
            $patente = $_POST['patente'];

            // Realizar la consulta para buscar la patente en la base de datos
            $resultado = $model->select('*', ['patente' => $patente]);

            // Si el resultado contiene datos, devolverlo, de lo contrario, devolver null
            return !empty($resultado) ? $resultado : null;
        }

        return null;
    }
    /* termina contactos */
    public static function getUsuarioList()
    {
        $usuario = new UsuarioModel();
        return $usuario->select(
            '*',
            null,
            false
        );
    }
    public static function findUser($id)
    {
        $user = new UserModel();
        return $user->select(
            '*',
            "id = $id",
            true
        );
    }

}