<?php

namespace App\Controller;
use App\Entity\Contact;
use App\Form\ContactType;
use App\Notification\ContactNotification;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class ContactController extends AbstractController
{
    /**
     * @Route("/contact", name="contact")
     */
    public function index(Request $request,ContactNotification $contactNotification)
    {


        $contact= new Contact();
        $form=$this->createForm(ContactType::class,$contact);
        $form->handleRequest($request);

    if($form->isSubmitted() && $form->isValid()){
        $contactNotification->notify($contact);
        $this->addFlash('success','votre email a bien ete envoye ');
        
        return (
            $this->redirectToRoute('contact'));
        
    }
        return $this->render('contact/index.html.twig', [
            'controller_name' => 'ContactController',
            'form' =>$form->createView()
        ]);
    }
}
