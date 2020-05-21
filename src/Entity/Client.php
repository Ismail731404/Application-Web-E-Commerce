<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Entity;
use Symfony\Component\HttpFoundation\File\File;
use Vich\UploaderBundle\Mapping\Annotation as Vich;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @Entity
 * @ORM\Entity(repositoryClass="App\Repository\ClientRepository")
 * @Vich\Uploadable()
 */
class Client extends User
{

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
}