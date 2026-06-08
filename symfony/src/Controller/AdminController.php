<?php

namespace App\Controller;

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

        ]);
    }
}
