<?php

namespace App\EventListener;


use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Http\Event\InteractiveLoginEvent;

/**
 * Permet d'ecouter l'authentification 
 * Enregistre la dernier heure de connexion
 */
class LoginListener
{

    /**
     * @var \Symfony\Component\Routing\UrlGeneratorInterface
     */
    private $router;
    /**
     * Undocumented variable
     *
     * @var \Doctrine\ORM\EntityManagerInterface;
     */
    private $em;


    public function __construct(EntityManagerInterface $em, UrlGeneratorInterface $router)
    {
        $this->em = $em;
        $this->router = $router;
    }
    /**
     * Undocumented function
     *
     * @param InteractiveLoginEvent $event
     * @return Response
     */
    public function onSecurityInteractiveLogin(InteractiveLoginEvent $event)
    {
        // Get the User entity.
        $user = $event->getAuthenticationToken()->getUser();
        // Update your field here.
        $user->setlastLogin(new \DateTime('now'));
        // Persist the data to database.
        $this->em->persist($user);
        $this->em->flush();
    }
}