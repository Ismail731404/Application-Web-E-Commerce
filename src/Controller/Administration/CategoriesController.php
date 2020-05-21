<?php

namespace App\Controller\Administration;

use App\Entity\Dechet;
use App\Form\DechetType;
use App\Entity\Categorie;
use App\Entity\Publicite;
use App\Form\CategorieType;
use App\Form\PubliciteFormType;
use App\Repository\DechetRepository;
use App\Repository\CategorieRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

// /**
// //  * @IsGranted("ROLE_STOCK")
//  */
class CategoriesController extends AbstractController
{



    private $categorie;
    private $em;

    public function __construct(CategorieRepository $categorie, EntityManagerInterface $manager)
    {

        $this->categorie = $categorie;
        $this->em = $manager;
    }
    /**
     * @Route("/administration/categories", name="administration_categories")
     */
    public function index(Request $requete, ?Categorie  $categorie2)
    {
        $categorie = new Categorie();
        $form = $this->createForm(CategorieType::class, $categorie);
        $form->handleRequest($requete);

        if ($form->isSubmitted() && $form->isValid()) {

            $this->em->persist($categorie);
            $this->em->flush();
            $this->addFlash('success', 'Creation Categorie effectuer');
            return $this->redirectToRoute('administration_categories');
        }

        $dechet = new Dechet();
        $form1 = $this->createForm(DechetType::class, $dechet);

        $form1->handleRequest($requete);

        if ($form1->isSubmitted() && $form1->isValid()) {

            $this->em->persist($dechet);
            $this->em->flush();
            $this->addFlash('success', 'Creation dechets effectuer');
            return $this->redirectToRoute('administration_categories');
        }


        $form2 = $this->createForm(CategorieType::class, $categorie2);
        $form2->handleRequest($requete);

        if ($form2->isSubmitted() && $form2->isValid()) {
            $this->em->flush();
            $this->addFlash('success', 'Modification Effectue');
            return $this->redirectToRoute('administration_categories');
        }



        $Publicite = new Publicite();
        $form3 = $this->createForm(PubliciteFormType::class, $Publicite);

        $form3->handleRequest($requete);

        if ($form3->isSubmitted() && $form3->isValid()) {

            $this->em->persist($Publicite);
            $this->em->flush();
            $this->addFlash('success', 'Ajoute un Publicite effectuer');
            return $this->redirectToRoute('administration_categories');
        }





        $categories = $this->categorie->findAll();
        return $this->render('administration/categories/GestionCategorie.html.twig', [
            'form' => $form->createView(),
            'categorie' => $categorie,
            'categories' => $categories,
            'form1' => $form1->createView(),
            'form2' => $form2->createView(),
            'form3' => $form3->createView(),
            'dechet' => $dechet
        ]);
    }

    /**
     * @Route("/administration/categories/editer{id}", name="administration_categories_editer")
     */
    public function edite(Categorie $categorie, Request $request)
    {


        if ($this->isCsrfTokenValid('edite' . $categorie->getId(), $request->get('_token'))) {
            $categorie->setNomCategorie($request->get('fisrtname'));
            $this->em->persist($categorie);
            $this->em->flush();
            $this->addFlash('success', 'modification effectuer ');
        }

        return $this->redirectToRoute('administration_categories');
    }

    /**
     * @Route("/administration/categories/editer{id}", name="administration_categories_delete",methods="delete")
     */

    public function delete(Categorie $categorie, Request $request)
    {

        if ($this->isCsrfTokenValid('delete' . $categorie->getId(), $request->get('_token'))) {

            $this->em->remove($categorie);
            $this->em->flush();
            $this->addFlash('success', 'suppression effectuer ');
        }


        return $this->redirectToRoute('administration_categories');
    }
}