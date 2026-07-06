<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Entity\User;
use App\Repository\ContactRepository;
use App\Repository\EvenementRepository;
use App\Repository\JeuRepository;
use App\Repository\NewsletterRepository;
use App\Repository\ParticipationRepository;
use App\Repository\UserRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ADMIN')]
final class AdminController extends AbstractController
{
    #[Route('/admin', name: 'app_admin')]
    public function index(
        UserRepository $userRepository,
        EvenementRepository $evenementRepository,
        JeuRepository $jeuRepository,
        ParticipationRepository $participationRepository,
        NewsletterRepository $newsletterRepository,
        ContactRepository $contactRepository
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
            'evenementsTraites' => $evenementRepository
                ->createQueryBuilder('e')
                ->where('e.status != :status')
                ->setParameter('status', 'en_attente')
                ->orderBy('e.createdAt', 'DESC')
                ->getQuery()
                ->getResult(),
            'users' => $userRepository->findAll(),
            'contacts' => $contactRepository->findBy(
                [],
                ['createdAt' => 'DESC']
            ),
            'evenementsValides' => $evenementRepository->findBy(
                ['status' => 'valide'],
                ['dateStart' => 'DESC']
            ),

            'evenementsRefuses' => $evenementRepository->findBy(
                ['status' => 'refuse'],
                ['dateStart' => 'DESC']
            ),
        ]);
    }

    #[Route('/admin/evenement/{id}/valider', name: 'app_admin_evenement_valider')]
    public function valider(
        Evenement $evenement,
        EntityManagerInterface $entityManager
    ): Response
    {
        $evenement->setStatus('valide');
        $evenement->setMotifRefus(null);

        $entityManager->flush();

        return $this->redirectToRoute('app_admin');
    }

    #[Route('/admin/evenement/{id}/refuser', name: 'app_admin_evenement_refuser', methods:['POST'])]
    public function refuser(
        Request $request,
        Evenement $evenement,
        EntityManagerInterface $entityManager
    ): Response
    {
         $motifRefus = trim($request->request->get('motifRefus', ''));

        $evenement->setStatus('refuse');
        $evenement->setMotifRefus($motifRefus ?: null);

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
        if (in_array('ROLE_ADMIN', $user->getRoles(), true)) {
            $this->addFlash(
                'error',
                'Impossible de retirer le rôle organisateur à un administrateur.'
            );

            return $this->redirectToRoute('app_admin');
        }
        
        $roles = array_filter(
            $user->getRoles(),
            fn ($role) => $role !== 'ROLE_ORGANISATEUR'
        );

        $user->setRoles(array_values($roles));

        $entityManager->flush();

        return $this->redirectToRoute('app_admin');
    }
}
