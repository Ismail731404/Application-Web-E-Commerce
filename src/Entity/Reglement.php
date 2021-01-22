<?php

namespace App\Entity;

use App\Entity\Client;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ReglementRepository")
 */
class Reglement
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;


    public function __construct()
    {
        $this->defaultepaiement = false;
        
    }

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $type;


    /**
     * @ORM\Column(type="integer")
     */
    private $pin;

    /**
     * @ORM\Column(type="integer")
     */
    private $numerocarte;

    /**
     * @ORM\Column(type="boolean")
     */
    private $defaultepaiement;
    /**
     * @ORM\Column(type="date", nullable=false)
     */
    private $DateExpiration;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Client", inversedBy="reglements")
     * @ORM\JoinColumn(nullable=false)
     */
    private $client;
    /**
     * @ORM\Column(type="decimal")
     */
    private $montant;

    
    public function getId(): ?int
    {
        return $this->id;
    }

    /**
     * Get the value of type
     */
    public function getType()
    {
        return $this->type;
    }

    /**
     * Set the value of type
     *
     * @return  self
     */
    public function setType($type)
    {
        $this->type = $type;

        return $this;
    }

    /**
     * Get the value of pin
     */
    public function getPin()
    {
        return $this->pin;
    }

    /**
     * Set the value of pin
     *
     * @return  self
     */
    public function setPin($pin)
    {
        $this->pin = $pin;

        return $this;
    }

    /**
     * Get the value of numerocarte
     */
    public function getNumerocarte()
    {
        return $this->numerocarte;
    }

    /**
     * Set the value of numerocarte
     *
     * @return  self
     */
    public function setNumerocarte($numerocarte)
    {
        $this->numerocarte = $numerocarte;

        return $this;
    }

    /**
     * Get the value of DateExpiration
     */
    public function getDateExpiration()
    {
        return $this->DateExpiration;
    }

    /**
     * Set the value of DateExpiration
     *
     * @return  self
     */
    public function setDateExpiration($DateExpiration)
    {
        $this->DateExpiration = $DateExpiration;

        return $this;
    }

    public function getClient(): ?Client
    {
        return $this->client;
    }

    public function setClient(?Client $Client): self
    {
        $this->client = $Client;

        return $this;
    }
    /**
     * Get the value of montant
     */
    public function getMontant()
    {
        return $this->montant;
    }

    /**
     * Set the value of montant
     *
     * @return  self
     */
    public function setMontant($montant)
    {
        $this->montant = $montant;

        return $this;
    }

    /**
     * Get the value of montant
     */
    public function getDefaultepaiement(): bool
    {
        return $this->defaultepaiement;
    }

    /**
     * Set the value of montant
     *
     * @return  self
     */
    public function setDefaultepaiement(bool $defaultepaiement)
    {
        $this->defaultepaiement = $defaultepaiement;

        return $this;
    }

  
}
