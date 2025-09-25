<?php

namespace App\EventListener;

use App\Service\FlashMessageHelperInterface;
use Symfony\Component\EventDispatcher\Attribute\AsEventListener;
 use Symfony\Component\Security\Http\Event\LoginFailureEvent;
 use Symfony\Component\Security\Http\Event\LoginSuccessEvent;
 use Symfony\Component\Security\Http\Event\LogoutEvent;

class AuthentificationEventListener {
    public function __construct(
        private readonly FlashMessageHelperInterface $flashMessageHelper,
    ){}

    #[AsEventListener]
    public function onLoginSuccessEvent(LoginSuccessEvent $event) {
        //Méthode déclenchée quand un evenement de type `MonEvent` est déclenché
        $this->flashMessageHelper->addFlash("success", "Connexion réussie !");
    }

    #[AsEventListener]
    public function onLoginFailureEvent(LoginFailureEvent $event) {
        //Méthode déclenchée quand un evenement de type `MonEvent` est déclenché
        $this->flashMessageHelper->addFlash("error", "Login et/ou mot de passe incorrect !");
    }

    #[AsEventListener]
    public function onLogoutEvent(LogoutEvent $event) {
        //Méthode déclenchée quand un evenement de type `MonEvent` est déclenché
        $this->flashMessageHelper->addFlash("success", "Déconnexion réussie !");
    }
}