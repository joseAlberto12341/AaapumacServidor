<?php

namespace App\Models;

use App\Models\EntityModel;

class JobInfoModel extends EntityModel
{
    protected $table = "jobinfo";
    protected $alias = "j";
    private ?int $id = null;
    private string $title = "";
    private string $description = "";
    private string $image = "";
    private ?int $vacancy = null;
    private string $responsabilities = "";
    private string $education = "";
    private string $experience = "";
    private string $additional = "";
    private ?int $workexperience = null; // CAMBIADO A INT
    private string $salary = "";
    private string $contract_type = "";
    private string $benefits = "";
    private string $location = "";
    private ?string $ContactoEmpresa = null;    
    private ?int $id_status = null;
    private string $deadline = "";
    private string $created_at = "";
    private string $updated_at = "";
    private string $status = "";

    public function getId()
    {
        return $this->id;
    }

    public function getTitle()
    {
        return $this->title;
    }

    public function setTitle(string $title)
    {
        $this->title = ucwords($title);
    }

    public function getDescription()
    {
        return $this->description;
    }

    public function setDescription(string $description)
    {
        $this->description = $description;
    }

    public function getImage()
    {
        return $this->image;
    }

    public function setImage(string $image)
    {
        $this->image = $image;
    }

    public function getVacancy()
    {
        return $this->vacancy;
    }

    public function setVacancy(int $vacancy)
    {
        $this->vacancy = $vacancy;
    }

    public function getResponsabilities()
    {
        return $this->responsabilities;
    }

    public function setResponsabilities(string $responsabilities): void
    {
        $this->responsabilities = $responsabilities;
    }

    public function getEducation()
    {
        return $this->education;
    }

    public function setEducation(string $education)
    {
        $this->education = $education;
    }

    public function getExperience()
    {
        return $this->experience;
    }

    public function setExperience(string $experience)
    {
        $this->experience = $experience;
    }

    public function getAdditional()
    {
        return $this->additional;
    }

    public function setAdditional(string $additional)
    {
        $this->additional = $additional;
    }

    public function getWorkexperience() // CAMBIADO EL NOMBRE DEL MÉTODO
    {
        return $this->workexperience;
    }

    public function setWorkexperience(int $workexperience) // CAMBIADO A INT
    {
        $this->workexperience = $workexperience;
    }

    public function getSalary()
    {
        return $this->salary;
    }

    public function setSalary(string $salary)
    {
        $this->salary = $salary;
    }

    public function getContractType()
    {
        return $this->contract_type;
    }

    public function setContractType(string $contract_type)
    {
        $this->contract_type = $contract_type;
    }

    public function getBenefits()
    {
        return $this->benefits;
    }

    public function setBenefits(string $benefits)
    {
        $this->benefits = $benefits;
    }

    public function getLocation()
    {
        return $this->location;
    }

    public function setLocation(string $location)
    {
        $this->location = $location;
    }

    public function getIdStatus() // CAMBIADO EL NOMBRE (más consistente)
    {
        return $this->id_status;
    }

    public function setIdStatus(int $id_status)
    {
        $this->id_status = $id_status;
    }

    public function getDeadline()
    {
        return $this->deadline;
    }

    public function setDeadline(string $deadline)
    {
        $this->deadline = $deadline;
    }

    public function getCreatedAt()
    {
        return $this->created_at;
    }

    public function setCreatedAt(string $created_at)
    {
        $this->created_at = $created_at;
    }

    public function getUpdatedAt()
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(string $updated_at)
    {
        $this->updated_at = $updated_at;
    }

    public function getStatus()
    {
        return $this->status;
    }

    public function setStatus(string $status)
    {
        $this->status = $status;
    }
    public function getContactoEmpresa()
    {
        return $this->ContactoEmpresa;
    }
    public function setContactoEmpresa(?string $ContactoEmpresa)
    {
        $this->ContactoEmpresa = $ContactoEmpresa;
    }

public function insert()
{
    $this->connect();

    $sql = "INSERT INTO " . $this->table . " 
            (title, description, image, vacancy, responsabilities, education, 
             experience, additional, workexperience, salary, contract_type, 
             benefits, location, id_status, deadline, ContactoEmpresa) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $this->pdo->prepare($sql);

    $result = $stmt->execute([
        $this->getTitle(),           // 1. title
        $this->getDescription(),     // 2. description
        $this->getImage(),           // 3. image
        (int)$this->getVacancy(),    // 4. vacancy
        $this->getResponsabilities(),// 5. responsabilities
        $this->getEducation(),       // 6. education
        $this->getExperience(),      // 7. experience
        $this->getAdditional(),      // 8. additional
        (int)$this->getWorkexperience(), // 9. workexperience
        $this->getSalary(),          // 10. salary
        $this->getContractType(),    // 11. contract_type
        $this->getBenefits(),        // 12. benefits
        $this->getLocation(),        // 13. location
        (int)$this->getIdStatus(),   // 14. id_status (ENTERO)
        $this->getDeadline(),        // 15. deadline
        $this->getContactoEmpresa()  // 16. ContactoEmpresa
    ]);

    return $result;
}
   
}