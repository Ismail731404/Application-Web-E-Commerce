<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @ORM\Entity(repositoryClass="App\Repository\CategorieRepository")
 * @UniqueEntity ("Nom_categorie",message="La categorie existe deja")
 */
class Categorie
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255,unique=true)
     */
    private $Nom_categorie;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Dechet", mappedBy="categorie", orphanRemoval=true)
     */
    private $dechets;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;

   
    public function __construct()
    {
        $this->dechets = new ArrayCollection();
        $this->created_at=new \DateTime('now');
    }

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getNomCategorie(): ?string
    {
        return $this->Nom_categorie;
    }

    public function setNomCategorie(string $Nom_categorie): self
    {
        $this->Nom_categorie = $Nom_categorie;

        return $this;
    }

    /**
     * @return Collection|Dechet[]
     */
    public function getDechets(): Collection
    {
        return $this->dechets;
    }

    public function addDechet(Dechet $dechet): self
    {
        if (!$this->dechets->contains($dechet)) {
            $this->dechets[] = $dechet;
            $dechet->setCategorie($this);
        }

        return $this;
    }

    public function removeDechet(Dechet $dechet): self
    {
        if ($this->dechets->contains($dechet)) {
            $this->dechets->removeElement($dechet);
            // set the owning side to null (unless already changed)
            if ($dechet->getCategorie() === $this) {
                $dechet->setCategorie(null);
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


    public function __toString()
    {
      return $this->Nom_categorie;  
    }
   
}
