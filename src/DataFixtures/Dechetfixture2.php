<?php

namespace App\DataFixtures;

use App\Entity\Categorie;
use App\Entity\Dechet;
use Doctrine\Bundle\FixturesBundle\Fixture;
use Doctrine\Common\Persistence\ObjectManager;
use Faker\Factory;

class Dechetfixture2 extends Fixture
{
    public function load(ObjectManager $manager)
    {
        $faker =  Factory::create('fr_FR');
        $categorie=new Categorie();
        $categorie
        ->setNomCategorie('les dechets en plastique')
             ->setCreatedAt(new \DateTime('now'));
             $manager->persist($categorie);
        
        for($i=0; $i<100; $i++)
        {
            $dechet=new Dechet();
            $categorie1 =  $categorie;
            $dechet
             ->setDescription($faker->sentences(3,true))
             ->setQuantiteStock($faker->numberBetween(100,1000))
             ->setDesignation($faker->words(3,true))
             ->setPrix($faker->numberBetween(100,500000))
             ->setVille($faker->city)
             ->setAdresse($faker->address)
             ->setCodePostal($faker->postcode)
             ->setOrigine($faker->numberBetween(0,count(Dechet::ORIGINE)-1))
             ->setNature($faker->numberBetween(0,count(Dechet::NATURE)-1))
             ->setCategorie($categorie1)
             ->setCreatedAt(new \DateTime('now'))
             ;
             $manager->persist($dechet);
        }
        //$ $product = new Product();
        // $manager->persist($product);

        $manager->flush();
    }
}
