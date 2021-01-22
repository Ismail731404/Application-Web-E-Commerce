<?php

namespace App\Entity;

use DateTime;
use DateInterval;
use DateTimeZone;
use App\Entity\Commande;
use App\Entity\Reglement;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\Common\Collections\Collection;
use Symfony\Component\HttpFoundation\File\File;
use Doctrine\Common\Collections\ArrayCollection;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\HttpFoundation\File\UploadedFile;

/**
 * @Entity
 * @ORM\Entity(repositoryClass="App\Repository\ClientRepository")
 * @Vich\Uploadable()
 */
class Client extends User
{

    public function __construct()
    {
        parent::__construct();
        $this->commandes = new ArrayCollection();
        $this->reglements = new ArrayCollection();
    }
    /**
     * @ORM\Column(type="string", length=255)
     */
    private $filename;
    /**
     * @var null|File  $file
     * @Vich\UploadableField(mapping="user_file",fileNameProperty="filename")
     * @Assert\File
     * (
     *     maxSize = "2M",
     *     mimeTypes = {"application/pdf", "application/x-pdf"},
     *     mimeTypesMessage = "Please upload a valid {{ types }}",
     *     maxSizeMessage = " he file is too large ( {{ size }} {{ suffix }} ). Allowed maximum size is {{ limit }} {{ suffix }}."
     * )
     */
    private $file;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Adresse", inversedBy="client")
     */
    private $adresse;

    /**
     * @ORM\Column(type="boolean")
     */
    private $terms;

    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Commande", mappedBy="client", orphanRemoval=true)
     */
    private $commandes;
    /**
     * @ORM\OneToMany(targetEntity="App\Entity\Reglement", mappedBy="client", orphanRemoval=true)
     */
    private $reglements;
    public function getId(): ?int
    {
        return $this->id;
    }

    public function getFilename(): ?string
    {
        return $this->filename;
    }

    public function setFilename(string $filename): self
    {
        $this->filename = $filename;
        $this->setUpdateAt(new DateTime('now'));
        return $this;
    }



    /**
     * Get the value of file
     * @return null|File
     */
    public function getFile(): ?File
    {
        return $this->file;
    }

    /**
     * Set the value of file
     *
     * @return  self
     *
     */
    public function setFile(?File $file = null): ?self
    {
        $this->file = $file;
        // Modifiez uniquement l'af mis à jour si le fichier est réellement téléchargé pour éviter les mises à jour de la base de données. 
        // Ceci est nécessaire lorsque le fichier doit être défini lors du chargement de l'entité. 

        if ($this->getfile() instanceof UploadedFile) {
            $this->update_at = new DateTime('now');
        }
        return $this;
    }

    public function getAdresse(): ?Adresse
    {
        return $this->adresse;
    }

    public function setAdresse(?Adresse $adresse): self
    {
        $this->adresse = $adresse;
        $this->setUpdateAt(new DateTime('now'));
        return $this;
    }

    public function getTerms(): ?bool
    {
        return $this->terms;
    }

    public function setTerms(bool $terms): self
    {
        $this->terms = $terms;
        $this->setUpdateAt(new DateTime('now'));
        return $this;
    }

    /**
     * @return Collection|Commande[]
     */
    public function getCommandes(): Collection
    {
        return $this->commandes;
    }

    public function addCommande(Commande $commande): self
    {
        if (!$this->commandes->contains($commande)) {
            $this->commandes[] = $commande;
            $commande->setClient($this);
        }

        return $this;
    }


    public function removeCommande(Commande $commande): self
    {
        if ($this->commandes->contains($commande)) {
            $this->commandes->removeElement($commande);
            // set the owning side to null (unless already changed)
            if ($commande->getClient() === $this) {
                $commande->setClient(null);
            }
        }

        return $this;
    }

    /**
     * @return Collection|Reglement[]
     */
    public function getReglements(): Collection
    {
        return $this->reglements;
    }
    /**
     * @return null|Reglement
     */
    public function getReglementParDefault()
    {
        foreach ($this->reglements as  $reg) {
            if ($reg->getDefaultepaiement()) {
                return $reg;
                break;
            }
        }
        return null;
    }

    public function addReglement(Reglement $reglement): self
    {
        if (!$this->reglements->contains($reglement)) {
            $this->reglements[] = $reglement;
            $reglement->setClient($this);
        }

        return $this;
    }


    public function removeReglement(Reglement $reglement): self
    {
        if ($this->reglements->contains($reglement)) {
            $this->reglements->removeElement($reglement);
            // set the owning side to null (unless already changed)
            if ($reglement->getClient() === $this) {
                $reglement->setClient(null);
            }
        }

        return $this;
    }
  
}
