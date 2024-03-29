<?php

namespace App\Controller;


use App\Repository\DechetRepository;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class PanierController extends AbstractController
{
    /**
     * @Route("/panier", name="panier_index")
     */


    public function index(SessionInterface $session, DechetRepository  $DechetRepository)
    {
        $session->get('fature', 0);
        $panier = $session->get('panier', []);
        $qtt = 0;
        $donnePanier = [];

        foreach ($panier as $id => $quantite) {
            $donnePanier[] = [
                'dechet' => $DechetRepository->find($id),
                'quantite' => $quantite
            ];
            $qtt += $quantite;
        }

        $totals =  0;
        foreach ($donnePanier as $i) {
            $total = $i['dechet']->getPrix() * $i['quantite'];
            $totals += $total;
        }
        $session->set('fature', $totals);
        $session->set('qtt', $qtt);
        return $this->render('client/panier/index.html.twig', [
            'lists' => $donnePanier,
            'totals' => $totals,
            'qtt' => $qtt
        ]);
    }
    /**
     * @Route("/panier/ajouter/{id}", name="panier_ajouter",methods="post")
     *
     */
    public function ajouter($id, SessionInterface $session, Request $request)
    {

        $panier = $session->get('panier', []);
        $qtt = $session->get('qtt');

        //if ($this->isCsrfTokenValid('dechet' . $id, $request->get('_token'))) {
        $qttenvoi =  $request->request->get('qttu', 0);

        if (!empty($panier[$id])) {
            $panier[$id] += $qttenvoi;
        } else {
            $panier[$id] = $qttenvoi;
        }
        //}
        $qtt += $qttenvoi;
        $session->set('qtt', $qtt);

        $session->set('panier', $panier);

        return $this->json([
            'code' => 200,
            'message' => 'ok',
            'qttes' => $qtt,
            'TEST' => $qttenvoi
        ], 200);
    }

    /**
     * @Route("/panier/supp/{id}", name="panier_supp")
     */
    public function supp($id, SessionInterface $session)
    {


        $panier = $session->get('panier', []);

        if (!empty($panier[$id])) {
            unset($panier[$id]);
        }


        $session->set('panier', $panier);
        return $this->redirectToRoute('panier_index', []);
    }
}
