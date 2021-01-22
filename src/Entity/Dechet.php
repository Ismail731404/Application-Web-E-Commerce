<?php

namespace App\Entity;

use Cocur\Slugify\Slugify;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpFoundation\File\UploadedFile;
use Symfony\Component\Validator\Constraints as Assert;
use Vich\UploaderBundle\Mapping\Annotation as Vich;

/**
 * @ORM\Entity(repositoryClass="App\Repository\DechetRepository")
 *  @UniqueEntity ("designation",message="Le nom du dechet existe deja")
 *  @Vich\Uploadable
 */
class Dechet
{
    const NATURE = [
        0 => 'Dangereux',
        1 => 'Non Dangereux',
        2 => 'Inerte',
        3 => 'Ultime',
        4 => 'Biodechet'
    ];

    const ORIGINE = [
        0 => 'Menagers',
        1 => 'Activite economiques'
    ];

    public function __construct()
    {
        $this->created_at = new \DateTime('now');
    }
    /**
     * Undocumented variable
     *
     * @var string|null
     * @ORM\Column(type="string", length=255,nullable=true)
     */
    private $filename;
    /**
     * @var File|null
     * @Vich\UploadableField(mapping="dechet_image", fileNameProperty="filename")
     * @Assert\Image(
     *     mimeTypes = {"image/jpeg","image/jpg","image/jfif","image/gif"},
     *     mimeTypesMessage = "Just les extension .jpeg .png  et .jpg  sont valide "
     * )
     */
    private $imageFile;

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string", length=255,unique=true)
     */
    private $designation;

    /**
     * @ORM\Column(type="text")
     * @Assert\Length(min=10,minMessage="La taille minimale de description est 10 caracteres")
     */
    private $description;
    /**
     * @ORM\Column(type="integer")
     */
    private $quantiteStock;

    /**
     * @ORM\ManyToOne(targetEntity="App\Entity\Categorie", inversedBy="dechets")
     * @ORM\JoinColumn(nullable=false)
     */
    private $categorie;

    /**
     * @ORM\Column(type="datetime")
     */
    private $created_at;


    /**
     * @ORM\Column(type="string", length=255)
     */
    private $ville;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $adresse;

    /**
     * @ORM\Column(type="string", length=255)
     * 
     */
    private $code_postal;

    /**
     * @ORM\Column(type="integer")
     */
    private $origine;

    /**
     * @ORM\Column(type="integer")
     */
    private $nature;

    /**
     * @ORM\Column(type="decimal")
     */
    private $prix;

    /**
     * @ORM\Column(type="datetime")
     */
    private $updated_at;

    /**
     * @ORM\Column(type="boolean")
     */
    private $promo = false;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getDesignation(): ?string
    {
        return $this->designation;
    }

    public function setDesignation(string $designation): self
    {
        $this->designation = $designation;

        return $this;
    }

    public function getDescription(): ?string
    {
        return $this->description;
    }

    public function setDescription(string $description): self
    {
        $this->description = $description;

        return $this;
    }





    public function getQuantiteStock(): ?int
    {
        return $this->quantiteStock;
    }

    public function setQuantiteStock(int $quantiteStock): self
    {
        $this->quantiteStock = $quantiteStock;

        return $this;
    }

    public function getCategorie(): ?Categorie
    {
        return $this->categorie;
    }

    public function setCategorie(?Categorie $categorie): self
    {
        $this->categorie = $categorie;

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





    public function getVille(): ?string
    {
        return $this->ville;
    }

    public function setVille(string $ville): self
    {
        $this->ville = $ville;

        return $this;
    }

    public function getAdresse(): ?string
    {
        return $this->adresse;
    }

    public function setAdresse(string $adresse): self
    {
        $this->adresse = $adresse;

        return $this;
    }

    public function getCodePostal(): ?string
    {
        return $this->code_postal;
    }

    public function setCodePostal(string $code_postal): self
    {
        $this->code_postal = $code_postal;

        return $this;
    }

    public function getOrigine(): ?int
    {
        return $this->origine;
    }

    public function setOrigine(int $origine): self
    {
        $this->origine = $origine;

        return $this;
    }

    public function getNature(): ?int
    {
        return $this->nature;
    }

    public function setNature(int $nature): self
    {
        $this->nature = $nature;

        return $this;
    }

    public function getPrix(): ?string
    {
        return $this->prix;
    }

    public function setPrix(string $prix): self
    {
        $this->prix = $prix;

        return $this;
    }
    public function getFormatPrix(): ?string
    {
        return \number_format($this->getPrix(), 0, '', ' ');
    }
    public function getSlug(): string
    {
        return ((new Slugify())->slugify($this->designation));
    }


    public function setImageFile(?File $imageFile): Dechet
    {
        $this->imageFile = $imageFile;

        if ($this->imageFile instanceof UploadedFile)
            $this->updated_at = new \DateTime('now');
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
     * @return Dechet
     */
    public function setFilename(?string $filename): Dechet
    {
        $this->filename = $filename;
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

    public function getPromo(): ?bool
    {
        return $this->promo;
    }

    public function setPromo(bool $promo): self
    {
        $this->promo = $promo;

        return $this;
    }
}