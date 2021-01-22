<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class AproposController extends AbstractController
{
    /**
     * @Route("/apropos", name="apropos")
     */
    public function index()
    {
        return $this->render('apropos/index.html.twig', [
            'controller_name' => 'AproposController',
        ]);
    }
}
