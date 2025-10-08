<?php

namespace App\Security;

use App\Entity\User;
use Symfony\Component\Security\Core\Exception\CustomUserMessageAccountStatusException;
use Symfony\Component\Security\Core\User\UserCheckerInterface;
use Symfony\Component\Security\Core\User\UserInterface;

class UserChecker implements UserCheckerInterface
{
    public function checkPreAuth(UserInterface $user): void
    {
        if (!$user instanceof User) {
            return;
        }

        // Vérifier d'abord si l'email est vérifié
        if (!$user->isVerified()) {
            throw new CustomUserMessageAccountStatusException(
                'Veuillez vérifier votre adresse email en cliquant sur le lien que nous vous avons envoyé.'
            );
        }

        // Ensuite vérifier l'approbation admin
        if (!$user->isApprovedByAdmin()) {
            throw new CustomUserMessageAccountStatusException(
                'Votre compte a été vérifié mais est en attente de validation par un administrateur. Vous recevrez une notification une fois votre compte approuvé.'
            );
        }
    }

    public function checkPostAuth(UserInterface $user): void
    {
        // Rien à faire ici
    }
}