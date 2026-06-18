<?php

namespace App\Controller;

use App\Entity\Participation;
use App\Repository\EvenementRepository;
use App\Repository\ParticipationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[IsGranted('ROLE_ORGANISATEUR')]
final class OrganisateurController extends AbstractController
{
    #[Route('/organisateur', name: 'app_organisateur')]
    public function index(
        EvenementRepository $evenementRepository,
        ParticipationRepository $participationRepository
    ): Response {
        if ($this->isGranted('ROLE_ADMIN')) {
            $evenements = $evenementRepository->findAll();
        } else {
            $evenements = $evenementRepository->findBy(
                ['status' => 'valide'],
                ['dateStart' => 'ASC']
            );
        }

        $participationsEnAttente = $participationRepository->findBy([
            'status' => 'en_attente',
        ]);

        return $this->render('organisateur/index.html.twig', [
            'controller_name' => 'OrganisateurController',
            'evenements' => $evenements,
            'participationsEnAttente' => $participationsEnAttente,
        ]);
    }

    #[Route('/organisateur/participation/{id}/accepter', name: 'app_organisateur_participation_accepter')]
    public function accepterParticipation(
        Participation $participation,
        EntityManagerInterface $entityManager
    ): Response {
        $participation->setStatus('accepte');

        $entityManager->flush();

        return $this->redirectToRoute('app_organisateur');
    }

    #[Route('/organisateur/participation/{id}/refuser', name: 'app_organisateur_participation_refuser')]
    public function refuserParticipation(
        Participation $participation,
        EntityManagerInterface $entityManager
    ): Response {
        $participation->setStatus('refuse');

        $entityManager->flush();

        return $this->redirectToRoute('app_organisateur');
    }
}