<?php

namespace App\Security;

use Symfony\Component\EventDispatcher\EventSubscriberInterface;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\Security\Http\Event\LoginSuccessEvent;
use Symfony\Component\Routing\Generator\UrlGeneratorInterface;
use Symfony\Bundle\SecurityBundle\Security;

class LoginRedirectSubscriber implements EventSubscriberInterface
{
    private UrlGeneratorInterface $urlGenerator;
    private Security $security;

    public function __construct(UrlGeneratorInterface $urlGenerator, Security $security)
    {
        $this->urlGenerator = $urlGenerator;
        $this->security = $security;
    }

    public static function getSubscribedEvents(): array
    {
        return [
            LoginSuccessEvent::class => 'onLoginSuccess',
        ];
    }

    public function onLoginSuccess(LoginSuccessEvent $event): void
    {
        $route = 'app_user_dashboard'; 

        // Check for the highest role first: ROLE_SUPER_ADMIN
        if ($this->security->isGranted('ROLE_SUPER_ADMIN')) {
            $route = 'app_admin_dashboard';

        // Check for the intermediate role: ROLE_ADMIN
        } elseif ($this->security->isGranted('ROLE_ADMIN')) {
            $route = 'admin_dashboard';
        } 

        // Generate the URL and create the RedirectResponse
        $response = new RedirectResponse($this->urlGenerator->generate($route));

        // Set the response to redirect the user
        $event->setResponse($response);
    }
}