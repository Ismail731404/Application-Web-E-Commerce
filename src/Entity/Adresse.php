<?php

namespace App\Entity;

use DateTime;
use Webmozart\Assert\Assert;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\Common\Collections\Collection;
use Doctrine\Common\Collections\ArrayCollection;

/**
 * @ORM\Entity(repositoryClass="App\Repository\AdresseRepository")
 */
class Adresse
{

    public function __construct()
    {
        $this->update_at = new DateTime('now');
        $this->created_at = new DateTime('now');
        $this->client = new ArrayCollection();
    }

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255)
     * 
     */
    private $Pays;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Ville;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Region;

    /**
     * @ORM\Column(type="integer")
     */
    private $Code_Postal;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Boite_Postal;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $Rue;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Client", mappedBy="adresse")
     */
    private $client;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

    /**
     * @ORM\Column(type="datetime")
     */
    private $update_at;






    public function getId(): ?int
    {
        return $this->id;
    }

    public function getPays(): ?string
    {
        return $this->Pays;
    }

    public function setPays(string $Pays): self
    {
        $this->Pays = $Pays;

        return $this;
    }

    public function getVille(): ?string
    {
        return $this->Ville;
    }

    public function setVille(string $Ville): self
    {
        $this->Ville = $Ville;

        return $this;
    }

    public function getRegion(): ?string
    {
        return $this->Region;
    }

    public function setRegion(string $Region): self
    {
        $this->Region = $Region;

        return $this;
    }

    public function getCodePostal(): ?string
    {
        return $this->Code_Postal;
    }

    public function setCodePostal(string $Code_Postal): self
    {
        $this->Code_Postal = $Code_Postal;

        return $this;
    }


    public function getBoitePostal(): ?string
    {
        return $this->Boite_Postal;
    }

    public function setBoitePostal(string $Boite_Postal): self
    {
        $this->Boite_Postal = $Boite_Postal;

        return $this;
    }

    public function getRue(): ?string
    {
        return $this->Rue;
    }

    public function setRue(string $Rue): self
    {
        $this->Rue = $Rue;

        return $this;
    }

    /**
     * @return Collection|Client[]
     */
    public function getClient(): Collection
    {
        return $this->client;
    }

    public function addClient(Client $client): self
    {
        if (!$this->client->contains($client)) {
            $this->client[] = $client;
            $client->setAdresse($this);
        }

        return $this;
    }

    public function removeClient(Client $client): self
    {
        if ($this->client->contains($client)) {
            $this->client->removeElement($client);
            // set the owning side to null (unless already changed)
            if ($client->getAdresse() === $this) {
                $client->setAdresse(null);
            }
        }

        return $this;
    }

    public function getCreatedAt(): ?\DateTimeInterface
    {
        return $this->created_at;
    }

    public function setCreatedAt(\DateTimeInterface $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdateAt(): ?\DateTimeInterface
    {
        return $this->update_at;
    }

    public function setUpdateAt(\DateTimeInterface $update_at): self
    {
        $this->update_at = $update_at;

        return $this;
    }
}