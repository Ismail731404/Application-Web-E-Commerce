<?php

namespace App\Entity;

use DateTime;
use App\Entity\User;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Entity;

/**
 * @Entity
 * @ORM\Entity(repositoryClass="App\Repository\EmployerRepository")
 */

class Employer extends User
{

    public function __construct()
    {
        parent::__construct();   
    }
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Departement;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Bureau;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $NumeroBureau;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Fonction;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDepartement(): ?string
    {
        return $this->Departement;
    }

    public function setDepartement(string $Departement): self
    {
        $this->Departement = $Departement;

        return $this;
    }

    public function getBureau(): ?string
    {
        return $this->Bureau;
    }

    public function setBureau(string $Bureau): self
    {
        $this->Bureau = $Bureau;

        return $this;
    }

    public function getNumeroBureau(): ?string
    {
        return $this->NumeroBureau;
    }

    public function setNumeroBureau(string $NumeroBureau): self
    {
        $this->NumeroBureau = $NumeroBureau;

        return $this;
    }

    public function getFonction(): ?string
    {
        return $this->Fonction;
    }

    public function setFonction(string $Fonction): self
    {
        $this->Fonction = $Fonction;

        return $this;
    }
}