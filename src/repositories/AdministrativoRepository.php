<?php
namespace App\Repositories;
use App\Models\ModalModel;
use App\Models\JobInfoModel;           

class AdministrativoRepository
{
public static function listJobs()
{
    $jobs = new JobInfoModel();
    return $jobs->select(
        'j.id, j.title, j.description, j.image, j.vacancy, j.responsabilities, 
         j.education, j.experience, j.additional, j.workexperience, j.salary, 
         j.contract_type, j.benefits,j.ContactoEmpresa, j.location, j.id_status, j.deadline, 
         j.created_at, j.updated_at',
        [],  // Cambia null por array vacío
        false  // Asegúrate de que no sea single
    );  
}
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
        if (isset($data['ContactoEmpresa'])) {
            $job->setContactoEmpresa($data['ContactoEmpresa']);
        }
        if (isset($data['deadline'])) {
            $job->setDeadline($data['deadline']);
        }
        if (isset($data['id_status'])) {
            $job->setIdStatus($data['id_status']);
        }

        $job->insert();
    }
        public static function newJob()
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
        if (isset($data['ContactoEmpresa'])) {
            $job->setContactoEmpresa($data['ContactoEmpresa']);
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
            'ContactoEmpresa' => $job->getContactoEmpresa(),
            'updated_at' => date('Y-m-d H:i:s')
        ], [
            'where' => 'id = :id',
            'replaces' => [':id' => $job->getId()]
        ]);
    }
}
