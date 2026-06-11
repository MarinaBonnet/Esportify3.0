<?php

namespace App\Controller;

use Doctrine\ORM\EntityManagerInterface;
use App\Entity\Evenement;
use App\Repository\EvenementRepository;
use App\Repository\JeuRepository;
use App\Repository\NewsletterRepository;
use App\Repository\ParticipationRepository;
use App\Repository\UserRepository;
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
}
