<?php

namespace App\Controller;

use App\Repository\ParticipationRepository;
use App\Repository\FavoriRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class JoueurController extends AbstractController
{
    #[Route('/joueur', name: 'app_joueur')]
    public function index(
        FavoriRepository $favoriRepository ,
        ParticipationRepository $participationRepository,
    ): Response {
    
        $favoris = $favoriRepository->findBy([
            'user' => $this->getUser(),
        ]);

        $participations = $participationRepository->findBy([
            'user' => $this->getUser(),
        ]);

        return $this->render('joueur/index.html.twig', [
            'controller_name' => 'JoueurController',
            'favoris' => $favoris,
            'participations' => $participations,
        ]);
    }
}
