<?php

namespace App\Controller;

use App\Repository\CommandeRepository;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
/**
 * @IsGranted("ROLE_VEND ")
 */
class ServiceVendeController extends AbstractController
{
    /**
     * @Route("/service/vende", name="service_vende")
     */
    public function index(CommandeRepository $commandeRepository)
    {
        $commande=$commandeRepository->findAll();

        return $this->render('service_vende/index.html.twig', [
            'commandes' => $commande,
        ]);
    }
}
