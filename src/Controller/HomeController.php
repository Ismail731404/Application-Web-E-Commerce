<?php

namespace App\Controller;

use App\Data\SearchData;
use App\Entity\Dechet;
use App\Form\SearchForm;
use App\Repository\CategorieRepository;
use App\Repository\DechetRepository;
use App\Repository\PubliciteRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;

class HomeController extends AbstractController
{
   
    private $dechetRepos;
    private $categorie;
    private $em;
    private $publiciteRepos;

  public function __construct(DechetRepository $dechet,CategorieRepository $categorie, EntityManagerInterface $manager,PubliciteRepository $publicite )
  {
      $this->dechetRepos=$dechet;
      $this->categorie=$categorie;
      $this->em=$manager;
      $this->publiciteRepos=$publicite;
  }
  /**
   * @Route("/", name="home")
   */
 public function home(Request  $request)
  {
      $data =new SearchData();
      $data->page = $request->get('page',1);
      $form = $this->createForm(SearchForm::class,$data);
      $form->handleRequest($request);
      [$min,$max] =$this->dechetRepos->findMinMax($data);
      
      $dechets= $this->dechetRepos->findSearch($data);  
      $publicites = $this->publiciteRepos->findAll();
       if($request->get('ajax'))
       {  
           return new JsonResponse([
               'content' => $this->renderView('home/_dechet.html.twig',['dechets' => $dechets]),
               'sorting' => $this->renderView('home/_sorting.html.twig',['dechets' => $dechets]),
               'pagination' => $this->renderView('home/_pagination.html.twig',['dechets' => $dechets]),
               'pages'  => ceil($dechets->getTotalItemCount()/$dechets->getItemNumberPerPage()),
               'min' => $min,
               'max' => $max

               ]);
       }
      return $this->render('home/home.html.twig', [
          'controller_name' => 'DechetController',
          'dechets' => $dechets,
          'form' =>$form->createView(),
          'min' => $min,
          'max' => $max,
          'publicites' =>$publicites
          
      ]);
  }




    /**
     * @Route("/dechet{slug}-{id}", name="dechet.show",requirements={"slug":"[a-z0-9\-]*"})
     */

    public function show( Dechet $dechet,$slug,Request $request)
    {
      
        
      
        if($dechet->getSlug() !== $slug)
        {
            return (
               $this->redirectToRoute('dechet.show',[
                   'id' => $dechet->getId(),
                   'slug' =>$dechet->getSlug()
               ],301)
            );
        }
            

       

         $dechetSimulaire=$this->dechetRepos->findDechetSimulaire($dechet);
        
        return $this->render('home/show.html.twig', [
            'controller_name' => 'DechetController',
            'dechet'  => $dechet,
            'dechetSimulaires' => $dechetSimulaire
        ]);  
    }
}
