<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Entity\User;
use App\Repository\EvenementRepository;
use App\Repository\JeuRepository;
use App\Repository\NewsletterRepository;
use App\Repository\ParticipationRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(
        UserRepository $userRepository,
        EvenementRepository $evenementRepository,
        JeuRepository $jeuRepository,
        ParticipationRepository $participationRepository,
        NewsletterRepository $newsletterRepository
    ): Response
    {
        return $this->render('admin/index.html.twig', [
            'nbUsers' => $userRepository->count([]),
            'nbEvenements' => $evenementRepository->count([]),
            'nbJeux' => $jeuRepository->count([]),
            'nbParticipations' => $participationRepository->count([]),
            'nbNewsletters' => $newsletterRepository->count([]),
            'newsletters' => $newsletterRepository->findBy([], [
            'createdAt' => 'DESC',
            ]),
            'evenementsEnAttente' => $evenementRepository->findBy([
                'status' => 'en_attente',
            ]),
            'users' => $userRepository->findAll(),

        ]);
    }

    #[Route('/admin/evenement/{id}/valider', name: 'app_admin_evenement_valider')]
    public function valider(
        Evenement $evenement,
        EntityManagerInterface $entityManager
    ): Response
    {
        $evenement->setStatus('valide');

        $entityManager->flush();

        return $this->redirectToRoute('app_admin');
    }

    #[Route('/admin/evenement/{id}/refuser', name: 'app_admin_evenement_refuser')]
    public function refuser(
        Evenement $evenement,
        EntityManagerInterface $entityManager
    ): Response
    {
        $evenement->setStatus('refuse');

        $entityManager->flush();

        return $this->redirectToRoute('app_admin');
    }

    #[Route('/admin/user/{id}/promote-organisateur', name: 'app_admin_user_promote_organisateur')]
    public function promoteOrganisateur(
        User $user,
        EntityManagerInterface $entityManager
    ): Response {
        $roles = $user->getRoles();

        if (!in_array('ROLE_ORGANISATEUR', $roles, true)) {
            $roles[] = 'ROLE_ORGANISATEUR';
        }

        $user->setRoles($roles);

        $entityManager->flush();

        return $this->redirectToRoute('app_admin');
    }

    #[Route('/admin/user/{id}/remove-organisateur', name: 'app_admin_user_remove_organisateur')]
    public function removeOrganisateur(
        User $user,
        EntityManagerInterface $entityManager
    ): Response {
        $roles = array_filter(
            $user->getRoles(),
            fn ($role) => $role !== 'ROLE_ORGANISATEUR'
        );

        $user->setRoles(array_values($roles));

        $entityManager->flush();

        return $this->redirectToRoute('app_admin');
    }
}
