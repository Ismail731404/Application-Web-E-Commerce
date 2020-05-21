<?php
namespace App\Data;

use Symfony\Component\Validator\Constraints as Assert;

class SearchData
{
     

   /**
    * Undocumented variable
    *
    * @var integer
    */
    public $page = 1;

    /**
     * 
     *
     * @var String
     */

     public $q;
    /**
     * @var int|null
     * @Assert\Range(min=10,max=100000000000000)
     */
    public $max;

    /**
     * 
     *
     * @var int|null
     */
    public $min;
    
   
    /**
     * Undocumented variable
     *
     * @var  Category|null
     */
    public $categories;
     
    /**
     * @var integer|null
     */
    public $origine;

    /**
     * 
     *
     * @var boolean
     */
    public $promo= false;


  
}