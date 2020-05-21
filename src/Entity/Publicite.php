<?php

namespace App\Entity;


use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;


/**
 * @ORM\Entity(repositoryClass="App\Repository\PubliciteRepository")
 * @Vich\Uploadable
 */
class Publicite
{
    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="text" ,length=255, nullable=true)
     * @Assert\Length(min=10,minMessage="La taille minimale de description est 10 caracteres")
     */
    private $description;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    private $url;

       /**
     * Undocumented variable
     *
     * @var string|null
     * @ORM\Column(type="string", length=255)
     */
    private $filename;
    /**
     * @var File|null
     * @Vich\UploadableField(mapping="dechet_image", fileNameProperty="filename")
     * @Assert\Image(
     *     mimeTypes = {"image/jpeg","image/jpg","image/jfif"},
     *     mimeTypesMessage = "Just les extension .jpeg .png  et .jpg  sont valide "
     * )
     */
    private $imageFile;

     /**
     * @ORM\Column(type="datetime")
     */
    private $updated_at;

    /**
     * @ORM\Column(type="string", length=20)
     */
    private $nompublicite;


    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(?string $description): self
    {
        $this->description = $description;

        return $this;
    }

    public function getUrl(): ?string
    {
        return $this->url;
    }

    public function setUrl(?string $url): self
    {
        $this->url = $url;

        return $this;
    }


    public function setImageFile(?File $imageFile ): Publicite
    {
        $this->imageFile =$imageFile;
        
        if($this->imageFile instanceof UploadedFile)
        $this->updated_at=new \DateTime('now');
        return $this;
       
        
    }
    /**
     * @return File|null
     */
    public function getImageFile(): ?File
    {
      return $this->imageFile;
    }
    /**
     * @param string|null $filename
     * @return Publicite
     */
    public function setFilename(?string $filename ): Publicite
    {
        $this->filename =$filename;
        return $this;
    }
    /**
     * @return string|null
     */
    public function getFilename(): ?string
    {
      return $this->filename;
    }

    public function getUpdatedAt(): ?\DateTimeInterface
    {
        return $this->updated_at;
    }

    public function setUpdatedAt(\DateTimeInterface $updated_at): self
    {
        $this->updated_at = $updated_at;

        return $this;
    }

    public function getNompublicite(): ?string
    {
        return $this->nompublicite;
    }

    public function setNompublicite(string $nompublicite): self
    {
        $this->nompublicite = $nompublicite;

        return $this;
    }
}
