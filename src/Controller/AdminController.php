<?php
namespace App\Controller;

use App\Entity\Employer;
use App\Form\EmployerType;
use App\Repository\UserRepository;
use App\Repository\ClientRepository;
use App\Repository\EmployerRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Annotation\Route;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\IsGranted;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Security\Core\Encoder\UserPasswordEncoderInterface;

/**
* @IsGranted("ROLE_ADMIN_ADMIN")
 */

class AdminController extends AbstractController {


    
    private $clientRepo;
    private $employerRepo;
    private $em;

    public function __construct(ClientRepository $clientRepo, EntityManagerInterface $em, EmployerRepository $employerRepo)
    {

        $this->clientRepo = $clientRepo;
        $this->em = $em;
        $this->employerRepo = $employerRepo;
    }





     /**
     * Permet de listes les utilisateurs
     *@Route("/app/admin/index",name="adminindex", schemes={"https"})
     * @param UserRepository $userRepo
     * @return Response
     */
    public function index(Request $requete, UserPasswordEncoderInterface $passwordEncoder, \Swift_Mailer $mailer)
    {
        $employer = new Employer();
        $form = $this->createForm(EmployerType::class, $employer);
        $form->handleRequest($requete);

        if ($form->isSubmitted() && $form->isValid()) {
            // encode the plain password   

            $employer->setPassword(
                $passwordEncoder->encodePassword(
                    $employer,
                    $form["foo"]["password"]->getData()
                )
            );
            //Concatene l'indice telephonique avec le numero 
            $phone = (string) ($form["foo"]["indicateur"]->getData() . $form["foo"]["phone"]->getData());
            // On génère un token et on l'enregistre
            $employer->setActivationToken(md5(uniqid()));
            //modifie le numero
            $employer->setPhone($phone);
            //save the  in the database
            $this->em->persist($employer);
            $this->em->flush();

            // do anything else you need here, like send an email
            // On crée le message
            $message = (new \Swift_Message('Nouveau compte'))
                // On attribue l'expéditeur
                ->setFrom('ovd.officiel190@gmail.com')
                // On attribue le destinataire
                ->setTo($employer->getEmail())
                // On crée le texte avec la vue cad ce le fichier activation qui va contenir le corps de l'email envoie a l'
                ->setBody(
                    $this->renderView(
                        'emails/activation.html.twig',
                        ['token' => $employer->getActivationToken()]
                    ),
                    'text/html'
                );
            //sending the message
            $mailer->send($message);

            // On génère un message pour affciher dans le login
            $this->addFlash('message', 'Un code d\'activation vous etez envoie');

            //rediriger vers le login
            return $this->redirectToRoute('app_login');
        }

        $employerr= $this->employerRepo->findAll();


        return $this->render('/admin/index.html.twig', [
            'registrationForm' => $form->createView(),
            'users' => $employerr
            
        ]);

        
    }

    /**
     * @Route("/app/admin/index/editer{id}", name="adminindex_editer",methods="post|get")
     */
    public function editea(Employer $employer, Request $requete, UserPasswordEncoderInterface $passwordEncoder)
    {
        
        $form = $this->createForm(EmployerType::class, $employer);
        $form->handleRequest($requete);

        if ($form->isSubmitted() && $form->isValid()) {
           
            $employer->setPassword(
                $passwordEncoder->encodePassword(
                    $employer,
                    $form["foo"]["password"]->getData()
                )
            );
            //Concatene l'indice telephonique avec le numero 
            $phone = (string) ($form["foo"]["indicateur"]->getData() . $form["foo"]["phone"]->getData());
            // On génère un token et on l'enregistre
            $employer->setActivationToken(md5(uniqid()));
            //modifie le numero
            $employer->setPhone($phone);
            //save the  in the database
            $this->em->persist($employer);
            $this->em->flush();

            $this->addFlash('success', 'Modification  effectuer');
            return $this->redirectToRoute('adminindex');
        }

        return $this->render('admin/EditerEmployer.html.twig', [
            'form' => $form->createView(),
            'dechet' => $employer,

        ]);
    }

    /**
     * @Route("/app/admin/index/delete{id}", name="adminindex_delete",methods="delete")
     */

    public function delete(Employer $employer, Request $request)
    {

        if ($this->isCsrfTokenValid('delete' . $employer->getId(), $request->get('_token'))) {

            $this->em->remove($employer);
            $this->em->flush();
            $this->addFlash('success', 'suppression effectuer ');
        }


        return $this->redirectToRoute('adminindex');
    }

    /**
     * @Route("/app/admin/index/bloquer{id}", name="adminindex_bloquer",methods="bloquer")
     */

    public function bloquer(Employer $employer, Request $request)
    {
        if($employer->getLockaccount())
        {

            if ($this->isCsrfTokenValid('bloquer' . $employer->getId(), $request->get('_token'))) {
                if($employer->getDepartement() == 'Stock' && is_null($employer->getActivationToken()))
                {
                    $employer->setRoles(['ROLE_STOCK']);
                }elseif ($employer->getDepartement() == 'Vend' && is_null($employer->getActivationToken())) {
                    $employer->setRoles(['ROLE_VEND']);
                }else {
                    $employer->setRoles(['ROLE_UNACTIVATED']);
                }
                $employer->setLockaccount(false);
                $this->em->flush();
                $this->addFlash('success', 'deblocage effectuer ');
            }

        }else 
        {

                if ($this->isCsrfTokenValid('bloquer' . $employer->getId(), $request->get('_token'))) {
                    $employer->setRoles(['ROLE_BLOQUE']);
                    $employer->setLockaccount(true);
                    $this->em->flush();
                    $this->addFlash('success', 'blocage effectuer ');
                }
        }


        


        return $this->redirectToRoute('adminindex');
    }

    /**
     * Permet de listes les utilisateurs
     *@Route("/app/admin/GestionDeClient",name="adminclient")
     * @param UserRepository $userRepo
     * @return Response
     */
    public function client(ClientRepository $userRepo):Response
    {

        $this->denyAccessUnlessGranted('ROLE_ADMIN_ADMIN');
        $user = $userRepo->findAll();
        return $this->render("/admin/client.html.twig", [
            "users" => $user
        ]);
    } 

}