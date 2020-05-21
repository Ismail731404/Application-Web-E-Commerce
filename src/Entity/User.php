<?php

namespace App\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use Doctrine\ORM\Mapping\Entity;
use Doctrine\ORM\Mapping\InheritanceType;
use Doctrine\ORM\Mapping\DiscriminatorMap;
use Doctrine\ORM\Mapping\DiscriminatorColumn;
use Symfony\Component\Validator\Constraints as Assert;
use Symfony\Component\Security\Core\User\UserInterface;
use Symfony\Bridge\Doctrine\Validator\Constraints\UniqueEntity;

/**
 * @Entity
 * @InheritanceType("JOINED")
 * @DiscriminatorColumn(name="discr", type="string")
 * @DiscriminatorMap({"client" = "Client", "user" = "User", "employer" = "Employer"})
 * @UniqueEntity("email",message="Le compte {{ value }} existe deja ")
 */


class User implements UserInterface, \Serializable
{


    public function __construct()
    {
        $this->created_at = new DateTime('now');
        $this->update_at = new DateTime('now');
    }

    /**
     * @ORM\Id()
     * @ORM\GeneratedValue()
     * @ORM\Column(type="integer")
     */
    protected $id;

    /**
     * @ORM\Column(type="string", length=180, unique=true)
     * @Assert\Email(message = "Ce email '{{ value }}' n'est pas un email valide.")
     */
    protected $email;

    /**
     * @ORM\Column(type="json")
     */
    protected $roles = ["ROLE_UNACTIVATED"];

    /**
     * @var string The hashed password
     * @ORM\Column(type="string")
     * @Assert\EqualTo(propertyPath="confirmepassword",message="Mot de passe Different")
     * @Assert\Length(min = 8, minMessage ="Votre mots doivent au moins avoir 8 caracter")
     * @Assert\Regex(
     * pattern = "/^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).{8,}$/",
     * htmlPattern = "^(?=.*[a-z])(?=.*[A-Z])(?=.*[0-9]).{8,}$",
     * match=true,
     * message="Votre mot de passe doit comporter au moins 8 caractères, contenir au moins un chiffres, une lettre en masjucule et minuscule, et peux contenir des symboles"
     * )
     */
    protected $password;

    /**
     *@Assert\EqualTo(propertyPath="password",message="Mot de passe Different")
     *@Assert\NotBlank
     */
    protected $confirmepassword;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\NotBlank
     * @Assert\Regex(
     * pattern="/\d/",
     * match=false,
     * message="Votre nom ne peut pas contenir un nembre"
     * )
     */
    protected $FisrtName;

    /**
     * @ORM\Column(type="string", length=255)
     * @Assert\Regex(
     * pattern="/\d/",
     * match=false,
     * message="Your name cannot contain a number"
     * )
     * @Assert\NotBlank
     */
    protected $LastName;

    /**
     * @ORM\Column(type="string", length=255, nullable=false)
     */
    protected $phone;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $created_at;

    /**
     * @ORM\Column(type="datetime")
     */
    protected $update_at;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $activation_token;

    /**
     * @ORM\Column(type="string", length=255, nullable=true)
     */
    protected $reset_token;

    /**
     * @ORM\Column(type="string", length=255)
     */
    protected $indicateur;

    /**
     * @ORM\Column(type="datetime", nullable=true)
     */
    private $lastLogin;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getEmail(): ?string
    {
        return $this->email;
    }

    public function setEmail(string $email): self
    {
        $this->email = $email;
        $this->setUpdateAt(new DateTime('now'));
        return $this;
    }

    /**
     * A visual identifier that represents this user.
     *
     * @see UserInterface
     */
    public function getUsername(): string
    {
        return (string) $this->email;
    }

    /**
     * @see UserInterface
     */
    public function getRoles(): array
    {

        $roles = $this->roles;


        return array_unique($roles);
    }

    public function setRoles(array $roles): self
    {
        $this->roles = $roles;

        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getPassword(): string
    {
        return (string) $this->password;
    }

    public function setPassword(string $password): self
    {
        $this->password = $password;
        $this->setUpdateAt(new DateTime('now'));
        return $this;
    }

    /**
     * @see UserInterface
     */
    public function getSalt()
    {
        // not needed when using the "bcrypt" algorithm in security.yaml
    }

    /**
     * @see UserInterface
     */
    public function eraseCredentials()
    {
        // If you store any temporary, sensitive data on the user, clear it here
        $this->plainPassword = null;
    }

    public function getFisrtName(): ?string
    {
        return $this->FisrtName;
    }

    public function setFisrtName(string $FisrtName): self
    {
        $this->FisrtName = $FisrtName;
        $this->setUpdateAt(new DateTime('now'));
        return $this;
    }

    public function getLastName(): ?string
    {
        return $this->LastName;
    }

    public function setLastName(string $LastName): self
    {
        $this->LastName = $LastName;
        $this->setUpdateAt(new DateTime('now'));
        return $this;
    }

    public function getPhone(): ?string
    {

        return $this->phone;
    }

    public function setPhone(string $phone): self
    {

        $this->phone = $phone;
        $this->setUpdateAt(new DateTime('now'));
        return $this;
    }

    public function getCreatedAt(): ?\DateTime
    {
        return $this->created_at;
    }

    public function setCreatedAt(DateTime $created_at): self
    {
        $this->created_at = $created_at;

        return $this;
    }

    public function getUpdateAt(): ?\DateTime
    {
        return $this->update_at;
    }

    public function setUpdateAt(\DateTime $update_at): self
    {
        $this->update_at = $update_at;

        return $this;
    }

    /**
     *
     * @return string
     */
    public function getConfirmepassword(): string
    {
        return (string) $this->confirmepassword;
    }

    /**
     *
     * @return self
     */
    public function setConfirmepassword(string $confirmepassword)
    {
        $this->confirmepassword = $confirmepassword;

        return $this;
    }

    public function getActivationToken(): ?string
    {
        return $this->activation_token;
    }

    public function setActivationToken(?string $activation_token): self
    {
        $this->activation_token = $activation_token;
        $this->setUpdateAt(new DateTime('now'));
        return $this;
    }

    public function getResetToken(): ?string
    {
        return $this->reset_token;
    }

    public function setResetToken(?string $reset_token): self
    {
        $this->reset_token = $reset_token;
        $this->setUpdateAt(new DateTime('now'));
        return $this;
    }
    /** @see \Serializable::serialize() */
    public function serialize()
    {
        return serialize(array(
            $this->id,
            $this->email,
            $this->password,
            // see section on salt below
            // $this->salt,
        ));
    }

    /** @see \Serializable::unserialize() */
    public function unserialize($serialized)
    {

        list(
            $this->id,
            $this->email,
            $this->password,
            // see section on salt below
            // $this->salt
        ) = unserialize($serialized);
    }

    public function getIndicateur(): ?string
    {
        return $this->indicateur;
    }

    public function setIndicateur(string $indicateur): self
    {
        $this->indicateur = $indicateur;
        $this->setUpdateAt(new DateTime('now'));
        return $this;
    }

    public function getlastLogin(): ?\DateTimeInterface
    {
        return $this->lastLogin;
    }

    public function setlastLogin(?\DateTimeInterface $lastLogin): self
    {
        $this->lastLogin = $lastLogin;

        return $this;
    }
}