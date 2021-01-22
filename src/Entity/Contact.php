<?php
namespace App\Entity;
use Symfony\Component\Validator\Constraints as Assert;

class Contact{
    
    /**
     * Undocumented variable
     *@Assert\NotBlank
     *@Assert\Length(min=2,max=50)
     * @var string|null
     */
    private $firstname;

    /**
     * Undocumented variable
     *@Assert\NotBlank
     *@Assert\Length(min=2,max=50)
     * @var string|null
     */
    private $lastname;
     /**
     * Undocumented variable
     *@Assert\NotBlank
     *@Assert\Regex(
     *  pattern="/[0-9]{8}/"
     * )
     * @var string|null
     */
    private $phone;

      /**
     * Undocumented variable
     *@Assert\NotBlank
     *@Assert\Email()
     * @var string|null
     */
    private $email;
      /**
     * Undocumented variable
     * @Assert\Length(min=10)
     * @var string|null
     */
    private $message;

    


    /**
     * Get undocumented variable
     *
     * @return  string|null
     */ 
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * Set undocumented variable
     *
     * @param  string|null  $message  Undocumented variable
     *
     * @return  self
     */ 
    public function setMessage($message)
    {
        $this->message = $message;

        return $this;
    }

    /**
     * Get *@Assert\Length(min=2,max=50)
     *
     * @return  string|null
     */ 
    public function getFirstname()
    {
        return $this->firstname;
    }

    /**
     * @param  string|null  
     * @return  self
     */ 
    public function setFirstname($firstname)
    {
        $this->firstname = $firstname;

        return $this;
    }

    /**
     * Get *@Assert\Length(min=2,max=50)
     *
     * @return  string|null
     */ 
    public function getLastname()
    {
        return $this->lastname;
    }

    /**
     * @param  string|null  
     *
     * @return  self
     */ 
    public function setLastname($lastname)
    {
        $this->lastname = $lastname;

        return $this;
    }

    /**
     * Get )
     *
     * @return  string|null
     */ 
    public function getPhone()
    {
        return $this->phone;
    }

    /**
     * Set )
     *
     * @param  string|null  $phone  )
     *
     * @return  self
     */ 
    public function setPhone($phone)
    {
        $this->phone = $phone;

        return $this;
    }

    /**
     * Get *@Assert\Email()
     *
     * @return  string|null
     */ 
    public function getEmail()
    {
        return $this->email;
    }

    /**
     * @param  string|null  
     *
     * @return  self
     */ 
    public function setEmail($email)
    {
        $this->email = $email;

        return $this;
    }

 

    
}

?>