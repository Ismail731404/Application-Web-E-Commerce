<?php

namespace App\Controller;

use App\Entity\Client;
use App\Entity\Adresse;
use App\Form\ClientType;
use App\Form\AdresseType;
use App\Form\ChangeMDPType;

use App\Repository\ClientRepository;
use App\Security\AppCustomAuthenticator;
use Doctrine\ORM\EntityManagerInterface;

use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
 * Undocumented class
 *@ISGranted("IS_AUTHENTICATED_REMEMBERED")
 *
 */
class ClientController extends AbstractController
{


    private $manager;
    private $repository;
    public function __construct(ClientRepository $client, EntityManagerInterface $manager)
    {
        $this->repository = $client;
        $this->manager = $manager;
    }
    /**
     * Permet d'afficher les information d'un client
     *@Route("/accountinfo", name="app_account_info")
     * @return Reponse
     */
    public function AccountInfo(Request $request): Response
    {
        //Constraint de role utilisateur 
        //$this->denyAccessUnlessGranted("ROLE_USER",null, 'Vous avez pas le droit d accete cette page desole');
        $this->denyAccessUnlessGranted("ROLE_STOCK",null, 'Vous avez pas le droit d accete cette page desole');
        return $this->render("/client/index.html.twig");
    }

    /**
     * Permet de change le MDP
     *@Route("/changeMDPOK",name="changeMDPOK")
     * @param Request $request
     * @param UserPasswordEncoderInterface $passwordEncoder
     * @return Response
     */
    public function ChangeMDP(Request $request, UserPasswordEncoderInterface $passwordEncoder): Response
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
                // On stocke
                $this->manager->persist($user);
                $this->manager->flush();
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
    public function AddresseInfo(Request $request): Response
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
            return $this->redirectToRoute("app_account_info");
        }

        return $this->render("/client/adresse.html.twig", [
            'client' => $client,
            'form' => $form->createView()
        ]);
    }
    /**
     * Undocumented function
     *@Route("/Input", name="Input")
     * @param Request $request
     * @return Reponse
     */
    public function CommandeInfo(Request $request): Response
    {

        var_dump($request->getQueryString());

        $response = new Response();

        $response->setContent('<html><body><h1>Hello world!</h1></body></html>');
        $response->setStatusCode(Response::HTTP_OK);

        // sets a HTTP response header
        $response->headers->set('Content-Type', 'text/html');

        // prints the HTTP headers followed by the content
        return $response;
    }
    /**
     * Undocumented function
     *@Route("/connexionsecuriteparemater", name="app_user_parametresecurite")
     * @param Request $request
     * @return Reponse
     */
     
    public function SecuriteEtconnection(Request $request,\Swift_Mailer $mailer): Response
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

        if ($this->isCsrfTokenValid('user' . $user->getId(), $request->get('_token')) && $request->get('_method') === 'phone') {
            $user->setPhone($request->get('phone'));
            $this->manager->persist($user);
            $this->manager->flush();
            return $this->redirectToRoute('app_user_parametresecurite');
        }

        if ($this->isCsrfTokenValid('user' . $user->getId(), $request->get('_token')) && $request->get('_method') === 'email') {
            $newmail= $request->get('email');
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
}