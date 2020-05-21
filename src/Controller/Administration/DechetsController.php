<?php

namespace App\Controller\Administration;

use App\Entity\Dechet;
use App\Form\DechetType;
use App\Entity\Categorie;
use Doctrine\ORM\Mapping\Entity;
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
class DechetsController extends AbstractController
{


    private $dechetRepos;
    private $categorie;
    private $em;

    public function __construct(DechetRepository $dechet, CategorieRepository $categorie, EntityManagerInterface $manager)
    {
        $this->dechetRepos = $dechet;
        $this->categorie = $categorie;
        $this->em = $manager;
    }

    /**
     * @Route("/administration/Categorie/Dechets{id}", name="administration_categorie_dechets")
     */
    public function index(Categorie $categorie, Request $requete)
    {
        $dechets = $categorie->getDechets();
        $dechet = new Dechet();
        $form = $this->createForm(DechetType::class, $dechet);

        $form->handleRequest($requete);

        if ($form->isSubmitted() && $form->isValid()) {
            $dechet->setCategorie($categorie);
            $this->em->persist($dechet);
            $this->em->flush();
            $this->addFlash('success', 'Creation dechets effectuer');
            return $this->redirectToRoute('administration_categorie_dechets', ['id' => $categorie->getId()], 302);
        }

        return $this->render('administration/dechets/GestionDechets.html.twig', [
            'dechets' => $dechets,
            'categorie' => $categorie,
            'form'    => $form->createView(),
            'dechet'   => $dechet
        ]);
    }

    /**
     * @Route("administration/Categorie/Dechet/Nouveau{id}", name="administration_categorie_dechet_new")
     */
    public function new(Request $requete, Categorie $categorie)
    {
        $dechet = new Dechet();
        $form = $this->createForm(DechetType::class, $dechet);

        $form->handleRequest($requete);

        if ($form->isSubmitted() && $form->isValid()) {
            $dechet->setCategorie($categorie);
            $this->em->persist($dechet);
            $this->em->flush();
            $this->addFlash('success', 'Creation dechets effectuer');
            return $this->redirectToRoute('administration_categorie_dechets', ['id' => $categorie->getId()], 302);
        }

        return $this->render('administration/dechets/NouveauDechet.html.twig', [
            'form' => $form->createView(),
            'dechet' => $dechet
        ]);
    }
    /**
     * @Route("administration/Categorie/Dechet/editer{id}", name="administration_categorie_dechet_edite")
     * 
     */
    public function edite(Dechet $dechet, Request $requete)
    {
        $cat = $dechet->getCategorie()->getId();
        if ($this->isCsrfTokenValid('edite' . $dechet->getId(), $requete->get('_token'))) {
            $dechet->setDesignation($requete->get('fisrtname'));
            $this->em->persist($dechet);
            $this->em->flush();
            $this->addFlash('success', 'modification effectuer ');
        }

        return $this->redirectToRoute('administration_categorie_dechets', ['id' => $cat]);
    }

    /**
     * @Route("administration/Categorie/Dechet/editer/Avance{id}", name="administration_categorie_dechet_editea",methods="post|get")
     * 
     */
    public function editea(Dechet $dechet, Request $requete)
    {
        $cat = $dechet->getCategorie()->getId();
        $form = $this->createForm(DechetType::class, $dechet);
        $form->handleRequest($requete);

        if ($form->isSubmitted() && $form->isValid()) {
            $this->em->flush();

            $this->addFlash('success', 'Modification dechet Effectue');
            return $this->redirectToRoute('administration_categorie_dechets', ['id' => $cat]);
        }

        return $this->render('administration/dechets/EditerDechet.html.twig', [
            'form' => $form->createView(),
            'dechet' => $dechet,

        ]);
    }











    /**
     * @Route("administration/Categorie/Dechet/editer{id}", name="administration_categorie_dechet_delete",methods="delete")
     * 
     */

    public function delete(Dechet $dechet, Request $request)
    {
        $cat = $dechet->getCategorie()->getId();
        if ($this->isCsrfTokenValid('delete' . $dechet->getId(), $request->get('_token'))) {

            $this->em->remove($dechet);
            $this->em->flush();
            $this->addFlash('success', 'suppression effectuer ');
        }


        return $this->redirectToRoute('administration_categorie_dechets', ['id' => $cat]);
    }
}