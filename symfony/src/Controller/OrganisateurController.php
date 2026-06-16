<?php

namespace App\Controller;

use App\Entity\Participation;
use App\Repository\EvenementRepository;
use App\Repository\ParticipationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class OrganisateurController extends AbstractController
{
    #[Route('/organisateur', name: 'app_organisateur')]
    public function index(
        EvenementRepository $evenementRepository,
        ParticipationRepository $participationRepository
    ): Response {
        if ($this->isGranted('ROLE_ADMIN')) {
            $evenements = $evenementRepository->findAll();

            $participationsEnAttente = $participationRepository->findBy([
                'status' => 'en_attente',
            ]);
        } else {
            $evenements = $evenementRepository->findBy([
                'organisateur' => $this->getUser(),
            ]);

            $participationsEnAttente = $participationRepository
                ->createQueryBuilder('p')
                ->join('p.evenement', 'e')
                ->where('e.organisateur = :organisateur')
                ->andWhere('p.status = :status')
                ->setParameter('organisateur', $this->getUser())
                ->setParameter('status', 'en_attente')
                ->getQuery()
                ->getResult();
        }

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
        if (
            !$this->isGranted('ROLE_ADMIN')
            && $participation->getEvenement()->getOrganisateur() !== $this->getUser()
        ) {
            throw $this->createAccessDeniedException(
                'Vous ne pouvez gérer que les participations de vos événements.'
            );
        }
        $participation->setStatus('accepte');

        $entityManager->flush();

        return $this->redirectToRoute('app_organisateur');
    }

    #[Route('/organisateur/participation/{id}/refuser', name: 'app_organisateur_participation_refuser')]
    public function refuserParticipation(
        Participation $participation,
        EntityManagerInterface $entityManager
    ): Response {
        if (
            !$this->isGranted('ROLE_ADMIN')
            && $participation->getEvenement()->getOrganisateur() !== $this->getUser()
        ) {
            throw $this->createAccessDeniedException(
                'Vous ne pouvez gérer que les participations de vos événements.'
            );
        }
        $participation->setStatus('refuse');

        $entityManager->flush();

        return $this->redirectToRoute('app_organisateur');
    }
}