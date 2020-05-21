<?php

namespace App\EventListener;

use App\Entity\Client;
use App\Entity\Employer;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Component\HttpKernel\Event\RequestEvent;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Component\Security\Core\Authentication\Token\Storage\TokenStorageInterface;

class RequestListener
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

    private $authorizationChecker;

    /**
     * @InjectParams({
     *     "authorizationChecker" = @Inject ("security.token_storage")
     * })
     */
    public function __construct(EntityManagerInterface $em, UrlGeneratorInterface $router, TokenStorageInterface $authorizationChecker)
    {
        $this->em = $em;
        $this->router = $router;
        $this->authorizationChecker = $authorizationChecker;
    }
    /**
     * Permet de garde l'utilisateur non active sur la page activeforce
     *
     * @param RequestEvent $event
     * @return void
     */
    public function onKernelRequest(RequestEvent $event)
    {
        //Recupere la router courant
        $currentRoute = $event->getRequest()->attributes->get('_route');
        $token = $this->authorizationChecker->getToken();
        $user = $token ? $token->getUser() : null;

        if ($user instanceof Employer || $user instanceof Client) {
            $role = in_array('ROLE_UNACTIVATED', $user->getRoles());
            // $role = $this->authorizationChecker->isGranted('ROLE_UNACTIVATED');
            if ($role && !$this->isAuthenticatedUser($currentRoute)) {
                $event->setResponse(new RedirectResponse($this->router->generate('activationforce')));
            }
            //Rediger vers le home si deja active
            if (!$role && $this->isConnectUser($currentRoute)) {
                $event->setResponse(new RedirectResponse($this->router->generate('home')));
            }
        }
    }

    private function isAuthenticatedUser($currentRoute)
    {
        return in_array(
            $currentRoute,
            ['app_logout', 'activationforce', 'activation']
        );
    }

    private function isConnectUser($currentRoute)
    {
        return in_array(
            $currentRoute,
            ['app_forgotten_password', 'register', 'activationforce']
        );
    }
}