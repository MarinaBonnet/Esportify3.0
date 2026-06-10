<?php

namespace App\Controller;

use App\Repository\EvenementRepository;
use App\Repository\FavoriRepository;
use App\Repository\ParticipationRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(EvenementRepository $evenementRepository,
    ParticipationRepository $participationRepository,
    FavoriRepository $favoriRepository,
    ): Response {
    
         $evenements = $evenementRepository->findBy(
        ['status' => 'valide'],
        ['dateStart' => 'ASC']
    );
    $participationUtilisateur = [];

    if ($this ->getUser()) {
        $participations = $participationRepository->findBy([
            'user' => $this-> getUser(),
        ]);
        foreach ($participations as $participation) {
            $participationUtilisateur[$participation->getEvenement()->getId()] = $participation;
        }
    }
    $favorisUtilisateur = [];

    if ($this->getUser()) {
        $favoris = $favoriRepository->findBy([
            'user' => $this->getUser(),
        ]);

        foreach ($favoris as $favori) {
            $favorisUtilisateur[$favori->getEvenement()->getId()] = $favori;
        }
    }
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'evenements' => $evenements,
            'participationsUtilisateur' => $participationUtilisateur,
            'favorisUtilisateur' => $favorisUtilisateur
        ]);
    }
}
