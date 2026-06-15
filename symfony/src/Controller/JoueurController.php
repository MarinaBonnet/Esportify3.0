<?php

namespace App\Controller;

use App\Repository\EvenementRepository;
use App\Repository\FavoriRepository;
use App\Repository\ParticipationRepository;
use App\Repository\ScoreRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class JoueurController extends AbstractController
{
    #[Route('/joueur', name: 'app_joueur')]
    public function index(
        FavoriRepository $favoriRepository ,
        ParticipationRepository $participationRepository,
        ScoreRepository $scoreRepository,
        EvenementRepository $evenementRepository
    ): Response {
    
        $favoris = $favoriRepository->findBy([
            'user' => $this->getUser(),
        ]);

        $participations = $participationRepository->findBy([
            'user' => $this->getUser(),
        ]);

        $scores = $scoreRepository->findBy([
            'user' => $this->getUser(),
        ]);

         

        return $this->render('joueur/index.html.twig', [
            'controller_name' => 'JoueurController',
            'favoris' => $favoris,
            'participations' => $participations,
            'scores' => $scores,
           'evenementsProposes' => $evenementRepository->findBy([
                'organisateur' => $this->getUser(),
            ]),
        ]);
    }
}
