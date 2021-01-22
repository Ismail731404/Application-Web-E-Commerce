<?php

namespace App\Entity;

use DateTime;
use DateInterval;
use DateTimeZone;
use App\Entity\Client;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CommandeRepository")
 */
class Commande
{
    public function __construct()
    {
        $this->created_at = $this->getTime();
    }

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="json")
     */
    private $listedechets;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $created_at;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Client", inversedBy="commandes")
     * @ORM\JoinColumn(nullable=false)
     */
    private $client;

    /**
     * @ORM\Column(type="string")
     */
    protected $etat;

    /**
     * @ORM\Column(type="boolean", nullable=true)
     */
    private $inStock;

    public function getId(): ?int
    {
        return $this->id;
    }
    /**
     * Undocumented function
     *
     * @return DateTime
     */
    private function getTime(): DateTime
    {
        $date = new DateTime("now", new DateTimeZone('UTC'));
        return   $date->add(new DateInterval('PT3H'));
    }

    /**
     * Get the value of listedechets
     */
    public function getListedechets(): array
    {
        return $this->listedechets;
    }

    /**
     * Set the value of listedechets
     *
     * @return  self
     */
    public function setListedechets(array $listedechets)
    {
        $this->listedechets = $listedechets;

        return $this;
    }

    /**
     * Get the value of created_at
     */
    public function getCreated_at(): DateTime
    {
        return $this->created_at;
    }

    /**
     * Set the value of created_at
     *
     * @return  self
     */
    public function setCreated_at(DateTime $created_at)
    {
        $this->created_at = $created_at;

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
     * Get the value of etat
     */
    public function getEtat()
    {
        return $this->etat;
    }

    /**
     * Set the value of etat
     *
     * @return  self
     */
    public function setEtat($etat)
    {
        $this->etat = $etat;

        return $this;
    }

    public function getInStock(): ?bool
    {
        return $this->inStock;
    }

    public function setInStock(?bool $inStock): self
    {
        $this->inStock = $inStock;

        return $this;
    }
}
