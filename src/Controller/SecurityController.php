<?php

namespace App\Controller;

use DateTime;
use DateInterval;
use DateTimeZone;
use App\Entity\User;
use App\Entity\Client;
use App\Form\UserType;
use App\Entity\Employer;
use App\Form\ClientType;
use App\Form\EmployerType;
use App\Form\ResetPassType;
use App\Form\ResetPassAfterType;
use App\Repository\UserRepository;
use App\Security\AppCustomAuthenticator;
use Doctrine\ORM\EntityManagerInterface;
use Egulias\EmailValidator\EmailValidator;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Egulias\EmailValidator\Validation\RFCValidation;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Guard\GuardAuthenticatorHandler;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Http\Authentication\AuthenticationUtils;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;
use Symfony\Component\Security\Csrf\TokenGenerator\TokenGeneratorInterface;


class SecurityController extends AbstractController
{
   
    private $manager;
    private $repository;
    public function __construct(UserRepository $dechet, EntityManagerInterface $manager)
    {
        $this->repository = $dechet;
        $this->manager = $manager;
    }


    /**
     * @Route("/ovd/acceuiller/login", name="app_login", schemes={"https"})
     */
    public function login(AuthenticationUtils $authenticationUtils): Response
    {
        //if was a user redirect at home 
        if ($this->isGranted("ROLE_ADMIN_ADMIN") && $this->getUser()) {
            return $this->redirectToRoute('adminindex');
        }   

        if ($this->isGranted("ROLE_STOCK")) {
            return $this->redirectToRoute('administration_categories');
        }



        // get the login error if there is one
        $error = $authenticationUtils->getLastAuthenticationError();
        // last username entered by the user
        $lastUsername = $authenticationUtils->getLastUsername();
        return $this->render('security/login.html.twig', ['last_username' => $lastUsername, 'error' => $error]);
    }

    /**
     * @Route("/ovd/acceuiller/logout", name="app_logout" , schemes={"https"})
     */
    public function logout()
    {

        throw new \LogicException('This method can be blank - it will be intercepted by the logout key on your firewall.');
    }

    /**
     * @Route("/app/register", name="register" , schemes={"https"})
     */
    public function register(Request $request, UserPasswordEncoderInterface $passwordEncoder, AppCustomAuthenticator $authenticator, \Swift_Mailer $mailer, GuardAuthenticatorHandler $guardHandler): Response
    {

        $client = new Client();
        $form = $this->createForm(ClientType::class, $client);
        $form->handleRequest($request);


        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password   

            $client->setPassword(
                $passwordEncoder->encodePassword(
                    $client,
                    $form["foo"]["password"]->getData()
                )
            );
            //Concatene l'indice telephonique avec le numero 
            $phone = (string) ($form["foo"]["indicateur"]->getData() . $form["foo"]["phone"]->getData());
            // On génère un token et on l'enregistre
            $client->setActivationToken(md5(uniqid()));
            //modifie le numero
            $client->setPhone($phone);
            //save the  in the database
            $this->manager->persist($client);
            $this->manager->flush();

            // do anything else you need here, like send an email
            // On crée le message
            $message = (new \Swift_Message('Nouveau compte'))
                // On attribue l'expéditeur
                ->setFrom('ovd.officiel190@gmail.com')
                // On attribue le destinataire
                ->setTo($client->getEmail())
                // On crée le texte avec la vue cad ce le fichier activation qui va contenir le corps de l'email envoie a l'
                ->setBody(
                    $this->renderView(
                        'emails/activation.html.twig',
                        ['token' => $client->getActivationToken()]
                    ),
                    'text/html'
                );
            //sending the message
            $mailer->send($message);


            // authentifie manuellement l'utilisateur 

            return $guardHandler->authenticateUserAndHandleSuccess(
                $client,          // the User object you just created
                $request,
                $authenticator, // authenticator whose onAuthenticationSuccess you want to use
                'main'          // the name of your firewall in security.yaml
            );
        }
        //le formulaire a remplir
        return $this->render('registration/register.html.twig', [
            'registrationForm' => $form->createView(),
        ]);
    }
    /**
     * le token est celui gere dans la fonction register et sera envoie comme lien
     * @Route("/app/activation/{token}", name="activation")
     */
    public function activation($token, AppCustomAuthenticator $authenticator, GuardAuthenticatorHandler $guardHandler, Request $request)
    {
        // On recherche si un utilisateur avec ce token existe dans la base de données
        $user = $this->repository->findOneBy(['activation_token' => $token]);

        // Si aucun utilisateur n'est associé à ce token
        if (!$user) {
            // On renvoie une erreur 404
            throw $this->createNotFoundException('Cet utilisateur n\'existe pas');
        }
        //sinon on verifie la contraint de l'heure 

        $time = $user->getCreatedAt();

        $datetime2 = new DateTime('now');
        $interval = $time->diff($datetime2);

        $in = $interval->format('%R%a%H%M%S');
        if ($in == '-1000000' || substr($in, 0, 2) == '-0') {
            // On supprime le token
            $user->setActivationToken(null);
            //on attrabut un role d'activation a l'user
            if ($user instanceof Client) {
                $user->setRoles(['ROLE_USER']);
            } else {
                if ($user instanceof Employer) {

                    switch ($user->getDepartement()) {
                        case 'Stock':
                            $user->setRoles(['ROLE_STOCK']);
                            break;
                        case 'Vend':
                            $user->setRoles(['ROLE_VEND ']);
                            break;
                        default:
                            # code...
                            break;
                    }
                }
            }
            //enregistre le changement dans la base
            $this->manager->persist($user);
            $this->manager->flush();
            $this->addFlash('message', 'Compte Active');
            return $this->redirectToRoute('app_login');
        }

        $this->addFlash('danger', 'Token expire');
        if (!$this->getUser()) {
            return $this->redirectToRoute('app_login');
        } else {
            return $this->redirectToRoute('activationForce');
        }
    }

    /**
     * On recupere le compte avec l'email
     * @Route("/oubli-pass", name="app_forgotten_password")
     */
    public function oubliPass(
        Request $request,
        \Swift_Mailer $mailer,
        TokenGeneratorInterface $tokenGenerator
    ): Response {

        // On initialise le formulaire
        $form = $this->createForm(ResetPassType::class);

        // On traite le formulaire
        $form->handleRequest($request);

        // Si le formulaire est valide
        if ($form->isSubmitted() && $form->isValid()) {
            // On récupère les données
            $donnees = $form->getData();

            // On cherche un utilisateur ayant cet e-mail
            $user = $this->repository->findOneByEmail($donnees['email']);

            // Si l'utilisateur n'existe pas
            if ($user === null) {
                // On envoie une alerte disant que l'adresse e-mail est inconnue
                $this->addFlash('danger', 'Cette adresse e-mail est inconnue');

                // Reste sur la page pour entre un nouveau mail
                return $this->redirectToRoute('app_forgotten_password', [], 301);
            }

            // On génère un token
            $token = $tokenGenerator->generateToken();

            // On essaie d'écrire le token en base de données
            try {
                $user->setResetToken($token);
                $this->manager->persist($user);
                $this->manager->flush();
            } catch (\Exception $e) {
                $this->addFlash('warning', $e->getMessage());
                return $this->redirectToRoute('app_login');
            }
            // On génère l'e-mail
            $message = (new \Swift_Message('Mot de passe oublié'))
                ->setFrom('ovd.officiel190@gmail.com')
                ->setTo($user->getEmail())
                ->setBody(
                    $this->renderView(
                        'emails/resetpass.html.twig',
                        ['token' => $user->getResetToken()]
                    ),
                    'text/html'
                );

            // On envoie l'e-mail
            $mailer->send($message);

            // On crée le message flash de confirmation
            $this->addFlash('message', 'E-mail de réinitialisation du mot de passe envoyé !');

            // On redirige vers la page de login
            return $this->redirectToRoute('app_login');
        } //fermetur de la condition de validation form

        // On envoie le formulaire à la vue
        return $this->render('security/forgotten_password.html.twig', ['emailForm' => $form->createView()]);
    }

    /**
     * @Route("/reset_pass/{token}", name="app_reset_password")
     */
    public function resetPassword(Request $request, string $token, UserPasswordEncoderInterface $passwordEncoder): Response
    {
        // On cherche un utilisateur avec le token donné
        $user = $this->repository->findOneBy(['reset_token' => $token]);

        // Si l'utilisateur n'existe pas
        if ($user === null) {
            // On affiche une erreur
            $this->addFlash('danger', 'Token Inconnu');
            return $this->redirectToRoute('app_login');
        }

        // Si le formulaire est envoyé en méthode post
        //On genere le formulaire
        $form = $this->createForm(ResetPassAfterType::class);

        // On traite le formulaire
        $form->handleRequest($request);
        //Recuperation de donnee (saisi)
        $pass = $form->get('password')->getData();
        $com = $form->get('confirmepassword')->getData();
        //sinon on verifie la contraint de l'heure 

        $time = $user->getUpdateAt();



        $datetime2 = new DateTime('now');
        $interval = $time->diff($datetime2);

        $in = $interval->format('%R%a%H%M%S');

        if ($in == '-1000000' || substr($in, 0, 2) == '-0') {
            // Si le formulaire est valide
            if ($form->isSubmitted() && $form->isValid() && $pass == $com) {
                // On supprime le token
                $user->setResetToken(null);
                // On chiffre le mot de passe
                $user->setPassword(
                    $passwordEncoder->encodePassword(
                        $user,
                        $form->get('password')->getData()
                    )
                );
                // On stocke
                $this->manager->persist($user);
                $this->manager->flush();

                // On crée le message flash
                $this->addFlash('message', 'Mot de passe mis à jour');
                //disconnected the user
                $this->get('security.token_storage')->getToken()->setAuthenticated(false);
                // On redirige vers la page de connexion
                return $this->redirectToRoute('app_login');
            } else {
                if (!is_null($pass) && !is_null($com)) {
                    // On crée le message flash affiche dans la le form
                    $this->addFlash('errer', 'Mot de passe different');
                }
                // Si on n'a pas reçu les données, on affiche le formulaire
                return $this->render('security/reset_password.html.twig', ['form' => $form->createView()]);
            }
        }
        $this->addFlash('danger', 'Token expire');
        return $this->redirectToRoute('app_login');
    }



    /**
     * le token est celui gere dans la fonction register et sera envoie comme lien
     * @Route("/app/activationforce", name="activationforce")
     */
    public function activationForce(AppCustomAuthenticator $authenticator, GuardAuthenticatorHandler $guardHandler, Request $request)
    {
        $this->denyAccessUnlessGranted("ROLE_UNACTIVATED");
        return $this->render('registration/ActivationForce.html.twig');
    }

     /**
     * le token est celui gere dans la fonction register et sera envoie comme lien
     * @Route("/app/bloquerforce", name="bloquerforce")
     */
    public function bloquerForce(AppCustomAuthenticator $authenticator, GuardAuthenticatorHandler $guardHandler, Request $request)
    {
        $this->denyAccessUnlessGranted("ROLE_BLOQUE");
        return $this->render('admin/Bloquer.html.twig');
    }
}
