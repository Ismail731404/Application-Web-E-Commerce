<?php

namespace App\Controller;

use App\Entity\Adresse;
use App\Entity\Commande;
use App\Entity\Reglement;
use App\Form\AdresseType;
use App\Form\ChangeMDPType;
use App\Form\ReglementType;
use App\Repository\ClientRepository;
use App\Repository\DechetRepository;
use App\Repository\CommandeRepository;
use App\Repository\ReglementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Http\Util\TargetPathTrait;
use Symfony\Component\HttpFoundation\Session\SessionInterface;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bridge\PhpUnit\TextUI\Command;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Session\Session;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;

/**
 * Undocumented class
 *@ISGranted("IS_AUTHENTICATED_REMEMBERED")
 */
class ClientController extends AbstractController
{
    use TargetPathTrait;

    private $manager;
    private $repository;
    private $router;
    public function __construct(ClientRepository $client, EntityManagerInterface $manager,UrlGeneratorInterface $router)
    {
        $this->repository = $client;
        $this->manager = $manager;
        $this->router=$router;
    }
    /**
     * Permet d'afficher les information d'un client
     *@Route("/accountinfo", name="app_account_info")
     * @return Reponse
     */
    public function AccountInfo(Request $request): Response
    {
        //Constraint de role utilisateur 
        $this->denyAccessUnlessGranted("ROLE_USER");
        return $this->render("/client/index.html.twig");
    }

    /**
     * Permet de change le MDP
     *@Route("/changeMDPOK",name="changeMDPOK")
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return Response
     */
    public function ChangeMDP(Request $request, UserPasswordEncoderInterface $passwordEncoder, \Swift_Mailer $mailer, TokenGeneratorInterface $tokenGenerator): Response
    {

        $user = $this->getUser();
        $form = $this->createForm(ChangeMDPType::class);
        // On traite le formulaire
        $form->handleRequest($request);
        //Validation de l'ancien MDP

        $pass =  $form["foo"]["password"]->getData();
        $com = $form["foo"]["confirmepassword"]->getData();

        if ($form->isSubmitted() && $form->isValid() && $pass == $com) {
            $old = $form->get("oldMDP")->getData();
            $oldMDPvalid = $passwordEncoder->isPasswordValid($user, $old);

            if ($oldMDPvalid) {

                // On chiffre le mot de passe
                $user->setPassword(
                    $passwordEncoder->encodePassword(
                        $user,
                        $form["foo"]["password"]->getData()
                    )
                );
                // On génère un token
                $token = $tokenGenerator->generateToken();

                //On averti l'utilisateur
                $message = (new \Swift_Message('Changement d\'e-mail'))
                    // On attribue l'expéditeur
                    ->setFrom('ovd.officiel190@gmail.com')
                    // On attribue le destinataire
                    ->setTo($user->getEmail())
                    // On crée le texte avec la vue cad ce le fichier activation qui va contenir le corps de l'email envoie a l'
                    ->setBody(
                        $this->renderView(
                            'emails/resetpasscomfirme.html.twig',
                            ['token' =>  $token]
                        ),
                        'text/html'
                    );
                //sending the message
                $mailer->send($message);
                // On stocke
                try {
                    // On stock le token
                    $user->setResetToken($token);
                    $this->manager->persist($user);
                    $this->manager->flush();
                } catch (\Exception $e) {
                    $this->addFlash('warning', $e->getMessage());
                    return $this->redirectToRoute('app_login');
                }
                return $this->redirectToRoute("app_user_parametresecurite");
            } else {
                $this->addFlash('message', 'Ancien MDP INCCORECT');
            }
        } else {
            if (!is_null($pass) && !is_null($com)) {
                $this->addFlash('message', 'MDP DIFFERENT');
            }
        }

        return $this->render("/client/changeMDP.html.twig", [
            "form" => $form->createView(),
            "user" => $user
        ]);
    }
    /**
     * Permet d'ajouter une adresse
     *@Route("/adresse", name="app_adresse_new")
     * @param Request $request
     * @return Response
     */
    public function AddresseInfo(Request $request,Session $session): Response
    {
        //Constraint de role utilisateur 
        $this->denyAccessUnlessGranted("ROLE_USER");
        //Recupere le client connecte
        $client = $this->getUser();
        
        if (is_null($client->getAdresse())) {
            $adress = new Adresse();
            $form = $this->createForm(AdresseType::class, $adress);
        } else {
            $adress = $client->getAdresse();
            $form = $this->createForm(AdresseType::class, $adress);
        }
       
        $form->handleRequest($request);
        if ($form->isSubmitted() && $form->isValid()) {
            $client->setAdresse($adress);
            $this->manager->persist($adress);
            $this->manager->persist($client);
            $this->manager->flush();
            
            if ($session->get('avantadress')) {
                return new RedirectResponse($session->get('avantadress'));
            }
        }

        return $this->render("/client/adresse.html.twig", [
            'client' => $client,
            'form' => $form->createView()
        ]);
    }
    /**
     * Undocumented function
     *@Route("/app/commander", name="commnder")
     * @param Request $request
     * @return Reponse
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function CommandeInfo(Request $request, SessionInterface $session): Response
    {
        $this->denyAccessUnlessGranted("ROLE_USER");
        $user = $this->getUser();

        $panier = $session->get('panier', []);
        

        $qttenvoi =  $request->request->get('qttu', 0);
        $idenvoi =  $request->request->get('dechetid', 0);
        // supprimer les ancien valeur de la session
        $coupidqtt = $session->set('coupidqtt', []);

        $coupidqtt = $session->get('coupidqtt', []);

        $coupidqtt[$idenvoi] = $qttenvoi;

        $session->set('coupidqtt', $coupidqtt);


        //Sdd(!$panier && !$qtt && !$coupidqtt);

        if (($panier == [] || $panier == [0=>0] ) && ($coupidqtt == [0=>0] || $coupidqtt == [])) {
            return $this->redirectToRoute('home');
        }

        if (is_null($user->getAdresse())) {
            $coupidqtt = $session->set('avantadress',$request->headers->get('referer')); 
            return $this->redirectToRoute("app_adresse_new");
        }



        
        if ($this->isCsrfTokenValid('user' . $user->getId(), $request->get('_token')) && $request->get('_method') === 'Pays') {
            $user->getAdresse()->setPays($request->get('Pays'));
            $this->manager->persist($user);
            $this->manager->flush();
            return $this->redirectToRoute('commnder');
        }

        if ($this->isCsrfTokenValid('user' . $user->getId(), $request->get('_token')) && $request->get('_method') === 'Ville') {
            $user->getAdresse()->setVille($request->get('Ville'));
            $this->manager->persist($user);
            $this->manager->flush();
            return $this->redirectToRoute('commnder');
        }

        if ($this->isCsrfTokenValid('user' . $user->getId(), $request->get('_token')) && $request->get('_method') === 'Region') {
            $user->getAdresse()->setRegion($request->get('Region'));
            $this->manager->persist($user);
            $this->manager->flush();
            return $this->redirectToRoute('commnder');
        }

        if ($this->isCsrfTokenValid('user' . $user->getId(), $request->get('_token')) && $request->get('_method') === 'CodePostal') {
            $user->getAdresse()->setCodepostal($request->get('CodePostal'));
            $this->manager->persist($user);
            $this->manager->flush();
            return $this->redirectToRoute('commnder');
        }


        if ($this->isCsrfTokenValid('user' . $user->getId(), $request->get('_token')) && $request->get('_method') === 'Boite_Postal') {
            $user->getAdresse()->setBoitepostal($request->get('Boite_Postal'));
            $this->manager->persist($user);
            $this->manager->flush();
            return $this->redirectToRoute('commnder');
        }

        if ($this->isCsrfTokenValid('user' . $user->getId(), $request->get('_token')) && $request->get('_method') === 'phone') {
            $user->setPhone($request->get('phone'));
            $this->manager->persist($user);
            $this->manager->flush();
            return $this->redirectToRoute('commnder');
        }


        if ($this->isCsrfTokenValid('user' . $user->getId(), $request->get('_token')) && $request->get('_method') === 'Rue') {
            $user->getAdresse()->setRue($request->get('Rue'));
            $this->manager->persist($user);
            $this->manager->flush();
            return $this->redirectToRoute('commnder');
        }


        return $this->render(
            "/client/comfirmeadresse.html.twig",
            ['address' => $user->getAdresse()]
        );
    }
    /**
     * Undocumented function
     *@Route("/connexionsecuriteparemater", name="app_user_parametresecurite")
     * @param Request $request
     * @return Reponse
     */
    public function SecuriteEtconnection(Request $request, \Swift_Mailer $mailer): Response
    {
        //Constraint de role utilisateur 
        $this->denyAccessUnlessGranted("IS_AUTHENTICATED_FULLY");
        $user = $this->getUser();

        if ($this->isCsrfTokenValid('user' . $user->getId(), $request->get('_token')) && $request->get('_method') === 'lastname') {
            $user->setLastname($request->get('lastname'));
            $this->manager->persist($user);
            $this->manager->flush();
            return $this->redirectToRoute('app_user_parametresecurite');
        }

        if ($this->isCsrfTokenValid('user' . $user->getId(), $request->get('_token')) && $request->get('_method') === 'Fisrtname') {
            $user->setFisrtname($request->get('fisrtname'));
            $this->manager->persist($user);
            $this->manager->flush();
            return $this->redirectToRoute('app_user_parametresecurite');
        }

        if ($this->isCsrfTokenValid('user' . $user->getId(), $request->get('_token')) && $request->get('_method') === 'email') {
            $newmail = $request->get('email');
            if ($newmail === $user->getEmail()) {
                $user->setEmail($newmail);
                // On génère un token et on l'enregistre
                $user->setActivationToken(md5(uniqid()));
                // do anything else you need here, like send an email
                // On crée le message
                $message = (new \Swift_Message('Changement d\'e-mail'))
                    // On attribue l'expéditeur
                    ->setFrom('ovd.officiel190@gmail.com')
                    // On attribue le destinataire
                    ->setTo($newmail)
                    // On crée le texte avec la vue cad ce le fichier activation qui va contenir le corps de l'email envoie a l'
                    ->setBody(
                        $this->renderView(
                            'emails/activation.html.twig',
                            ['token' => $user->getActivationToken()]
                        ),
                        'text/html'
                    );
                //sending the message
                $mailer->send($message);
                $user->setRoles(["ROLE_UNACTIVATED"]);
                $this->manager->persist($user);
                $this->manager->flush();
            }

            return $this->redirectToRoute('app_user_parametresecurite');
        }

        return $this->render("/client/securiteconnexion.html.twig");
    }

     /**
     * Permet de verifie la presence d'un reglement si oui vers reca sinon new regle
     *@Route("/commander/reglement", name="commander_reglement")
     * @param Request $request
     * @return Reponse
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function ReglementInfoC( Request $request,  ReglementRepository $reglementRepository,Session $session): Response
    {
        $this->denyAccessUnlessGranted("ROLE_USER");
        $user = $this->getUser();

        $panier = $session->get('panier', []);
        

        $qttenvoi =  $request->request->get('qttu', 0);
        $idenvoi =  $request->request->get('dechetid', 0);
        // supprimer les ancien valeur de la session
        $coupidqtt = $session->set('coupidqtt', []);

        $coupidqtt = $session->get('coupidqtt', []);

        $coupidqtt[$idenvoi] = $qttenvoi;

        $session->set('coupidqtt', $coupidqtt);

        if (($panier == [] || $panier == [0=>0] ) && ($coupidqtt == [0=>0] || $coupidqtt == [])) {
            return $this->redirectToRoute('home');
        }
       
        if (is_null($user->getReglements()[0])) {
            $session->set('avantreg',$request->headers->get('referer'));
            return $this->redirectToRoute("app_user_reglement");
        }
       
            return $this->redirectToRoute("commandersucess");
        
       

    }
    

    /**
     * Permet de verifie la presence d'un reglement si oui vers reca sinon new regle
     *@Route("/app/user/reglement", name="app_user_reglement")
     * @param Request $request
     * @return Reponse
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function ReglementInfo( Request $request,  ReglementRepository $reglementRepository,Session $session): Response
    {
        //Constraint de role utilisateur 
        $this->denyAccessUnlessGranted("ROLE_USER");
        
        //recuperation du formulaire
        $reglement = new Reglement();
        $form = $this->createForm(ReglementType::class,$reglement);
        
        // On traite le formulaire
        $form->handleRequest($request);
        $user = $this->getUser();
        
        if ($form->isSubmitted() && $form->isValid()) {
            $reg = $reglementRepository->findOneBy([
                'numerocarte' => $form->get('numerocarte')->getData(),
                'pin' => $form->get('pin')->getData(),
                'DateExpiration' => $form->get('DateExpiration')->getData(),
                'type' => $form->get('type')->getData()
            ]);
            
            if (!$reg) {
                $this->addFlash('warning', 'verifie les information');
            }else{
                $reglement->setMontant($reg->getMontant
            ());
                $reglement->setClient($user);
                $user->addReglement($reglement);
                $user->getReglementParDefault($reglement);
                $this->manager->persist($user);
                $this->manager->persist($reglement);
                $this->manager->flush();
                $this->DefaultePaiment($reglement);
            }
             if ($session->get('avantreg')) {
                return new RedirectResponse($session->get('avantreg'));
                }
        
        }
        return $this->render(
            "/client/reglement.html.twig",
            ['form' => $form->createView()]
        );
    
    }



    /**
     * Undocumented function
     *@Route("/commander/recapilatif", name="commandersucess")
     * @param Request $request
     * @return Response
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function recapilatif(DechetRepository  $DechetRepository, SessionInterface $session, Request $request): Response
    {

        //Constraint de role utilisateur 
        
        $this->denyAccessUnlessGranted("ROLE_USER");
        $user = $this->getUser();
        
        $panier = $session->get('panier', []);
        $facture = $session->get('fature', 0);
        $coupidqtt = $session->get('coupidqtt', []);
        
        if (($panier == [] || $panier == [0=>0] ) && ($coupidqtt == [0=>0] || $coupidqtt == [])) {

           return $this->redirectToRoute('home');
        
        }
        
        if($coupidqtt == [0=>0] || $coupidqtt == []){
            
            foreach ($panier as $id => $quantite) {
                
                $donnePanier[] = [
                    'dechet' => $DechetRepository->find($id),
                    'quantite' => $quantite
                ];
            }
        }else{
            
            foreach ($coupidqtt as $id => $quantite) {
                $donnePanier[] = [
                    'dechet' => $DechetRepository->find($id),
                    'quantite' => $quantite
                ];
            }

            foreach ($donnePanier as $i) {
                $total = $i['dechet']->getPrix() * $i['quantite'];
            break; 
            }
            $facture = $session->set('fature', $total);
        }
       
        return $this->render(
            "/client/recapilatif.html.twig",
            ['twigcomamnde' => $donnePanier]
        );
    }

     /**
     * Undocumented function
     *@Route("/app/commander/messageserreur", name="messageserreur")
     * @param Request $request
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function messageserreur()
    {
        return $this->render('/client/commander/messageserreur.html.twig');
    }

    /**
     * Undocumented function
     *@Route("/app/commander/messagesuccess", name="messagesuccess")
     * 
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function messagesuccess()
    {
        return $this->render('/client/commander/messagessucces.html.twig');
    }


    /**
     * Undocumented function
     *@Route("/commander/payant", name="payant")
     * @param Request $request
     * @return Response
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function ReglementMontant(DechetRepository  $DechetRepository, SessionInterface $session)
    {
        //Recuperation de l'utilsateur 
        $user = $this->getUser();
        //recupere les inforation sur la session 
        $panier = $session->get('panier', []);
        $facture = $session->get('fature', 0);
        $acheterbtn = $session->get('coupidqtt', []);
        
        //Constraint de choix de dechet
        if ($panier === [] && ($acheterbtn == [0=>0] || $acheterbtn == [] )) {
            return $this->redirectToRoute('home');
        } else {
            $reg = $user->getReglementParDefault(); 
            $mnt = $reg->getMontant();
            if ($facture !== 0 && $mnt >= $facture) {
                $m = $mnt - $facture;
                $commande = new Commande();
                $reg->setMontant($m);
                $commande->setClient($user);
                $commande->setListedechets($panier);
                $commande->setEtat('en cours');
                foreach ($panier as $id => $quantite) {
                    $dech = $DechetRepository->find($id);
                    $qtsk = $dech->getQuantiteStock();
                    $res = $qtsk - $quantite;
                    $dech->setQuantiteStock($res);
                    $this->manager->persist($dech);
                }
                $this->manager->persist($reg);
                $this->manager->persist($commande);
                $this->manager->flush();
                $session->set('panier', []);
                $session->set('qtt', 0);
                $session->set('fature', 0);
                return $this->redirectToRoute('messagesuccess');
            } else if($acheterbtn !== [0=>0]){
                $commande = new Commande();
                $commande->setClient($user);
                $commande->setListedechets($acheterbtn);
                $commande->setEtat('en cours');
                foreach ($acheterbtn as $id => $quantite) {
                    $dech = $DechetRepository->find($id);
                    $qtsk = $dech->getQuantiteStock();
                    $res = $qtsk - $quantite;
                    $dech->setQuantiteStock($res);
                    $this->manager->persist($dech);
                    $f=$quantite*$dech->getPrix();
                    $m = $mnt -  $f;
                    $reg->setMontant($m);
                }
                $this->manager->persist($reg);
                $this->manager->persist($commande);
                $this->manager->flush();

                $session->set('coupidqtt', []);
                $session->set('fature', 0);
            }else{
                return $this->redirectToRoute('messageserreur');
            }
        }
       

    }

 /**
     * Undocumented function
     *@Route("/app/commander/annulerlacommander", name="annulerlacommander")
     * @param Request $request
    
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function annuler(SessionInterface $session)
    {
        $coupidqtt=$session->get('coupidqtt', []);  
    if (($coupidqtt == [0=>0] || $coupidqtt == [])){
        $session->set('panier', []);
        $session->set('qtt', 0);
        $session->set('fature', 0);
    }else{
        $session->set('coupidqtt', []);
    }
       
        return $this->redirectToRoute('home');
    }

    /**
     * Undocumented function
     *@Route("/app/commander/defaulter_paiment/{id}", name="default_paiment")
     * @param Request $request
    
     * @IsGranted("IS_AUTHENTICATED_FULLY")
     */
    public function DefaultePaiment(Reglement $reglement)
    {
        $user = $this->getUser();
        foreach ($user->getReglements() as $regl) {
            if ($regl->getDefaultepaiement()) {
                $regl->setDefaultepaiement(false);
                $this->manager->persist($regl);
            break;
            }

        }
        $reglement->setDefaultepaiement(true);
        $this->manager->persist($reglement);
        $this->manager->flush();

        return $this->json([
            'code' => 200,
            'message' => 'ok',

        ], 200);
    }


    /**
     * Permet de liste les commande effectuer par un utilisateur
     *@Route("/app/commander/voscommander",name="app_commander_mescommander")
     * @param CommandeRepository $commande
     * @return void
     */
    public function voscommande(CommandeRepository $commande){
        $client= $this->getUser();
       $command= $commande->findByCliente($client);

        return $this->render('/client/commander/voscommande.html.twig',[
            'commandes'=>$command
        ]);
    }


      /**
     * Permet de liste les commande effectuer par un utilisateur
     *@Route("/app/commander/annulercommander/{id}",name="app_commander_annulercommander")
     * @param CommandeRepository $commande
     * @return void
     */
    public function annulercommandeve(Commande $commande){
            $client= $this->getUser();
            $client->removeCommande($commande);
            $this->manager->persist($client);
            $this->manager->remove($commande);
            $this->manager->flush();
            $this->addFlash('success', 'suppression effectuer ');
        return $this->redirectToRoute('app_commander_mescommander');
    }
}
