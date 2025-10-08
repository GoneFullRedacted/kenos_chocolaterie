<?php

namespace App\Controller\Admin;

use App\Entity\User;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bridge\Twig\Mime\TemplatedEmail;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Mailer\MailerInterface;
use Symfony\Component\Mime\Address;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/admin/users')]
#[IsGranted('ROLE_ADMIN')]
class UserManagementController extends AbstractController
{
    public function __construct(
        private EntityManagerInterface $entityManager,
        private MailerInterface $mailer
    ) {
    }

    #[Route('/pending', name: 'admin_pending_users')]
    public function pendingUsers(UserRepository $userRepository): Response
    {
        // Récupérer tous les utilisateurs avec email vérifié mais non approuvés
        $pendingUsers = $userRepository->createQueryBuilder('u')
            ->where('u.isVerified = :verified')
            ->andWhere('u.isApprovedByAdmin = :approved')
            ->setParameter('verified', true)
            ->setParameter('approved', false)
            ->orderBy('u.id', 'DESC')
            ->getQuery()
            ->getResult();

        return $this->render('admin/users/pending.html.twig', [
            'pending_users' => $pendingUsers,
        ]);
    }

    #[Route('/approve/{id}', name: 'admin_approve_user', methods: ['POST'])]
    public function approveUser(User $user): Response
    {
        if ($user->isApprovedByAdmin()) {
            $this->addFlash('warning', 'Cet utilisateur est déjà approuvé.');
            return $this->redirectToRoute('admin_pending_users');
        }

        if (!$user->isVerified()) {
            $this->addFlash('error', 'L\'utilisateur doit d\'abord vérifier son email.');
            return $this->redirectToRoute('admin_pending_users');
        }

        // Approuver l'utilisateur
        $user->setIsApprovedByAdmin(true);
        $this->entityManager->flush();

        // Envoyer un email de notification
        $email = (new TemplatedEmail())
            ->from(new Address('exemple@domaine.com', 'Chocolateries KENOS'))
            ->to((string) $user->getEmail())
            ->subject('Votre compte a été approuvé !')
            ->htmlTemplate('registration/account_approved.html.twig')
            ->context([
                'user' => $user,
            ]);

        try {
            $this->mailer->send($email);
        } catch (\Exception $e) {
            // Log l'erreur mais ne bloque pas l'approbation
        }

        $this->addFlash('success', sprintf(
            'L\'utilisateur %s %s a été approuvé et peut maintenant se connecter.',
            $user->getFirstname(),
            $user->getLastname()
        ));

        return $this->redirectToRoute('admin_pending_users');
    }

    #[Route('/reject/{id}', name: 'admin_reject_user', methods: ['POST'])]
    public function rejectUser(User $user): Response
    {
        if ($user->isApprovedByAdmin()) {
            $this->addFlash('warning', 'Impossible de rejeter un utilisateur déjà approuvé.');
            return $this->redirectToRoute('admin_pending_users');
        }

        // Supprimer l'utilisateur
        $this->entityManager->remove($user);
        $this->entityManager->flush();

        $this->addFlash('success', 'L\'utilisateur a été rejeté et supprimé.');

        return $this->redirectToRoute('admin_pending_users');
    }
}