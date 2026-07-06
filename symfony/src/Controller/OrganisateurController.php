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

        
        $now = new \DateTimeImmutable();

        $evenements = $evenementRepository->createQueryBuilder('e')
        ->andWhere('e.status = :status')
        ->andWhere('e.dateEnd > :now')
        ->setParameter('status', 'valide')
        ->setParameter('now', $now)
        ->orderBy('e.dateStart', 'ASC')
        ->getQuery()
        ->getResult();

        $participationsAcceptees = $participationRepository->findAcceptedForActiveValidatedEvents($now);

        $nbEvenements = count($evenements);
        $nbParticipantsInscrits = count($participationsAcceptees);

        $nbParticipants = 0;
        $nbValidation = 0;
        $nbEnCours = 0;
        $nbAVenir = 0;
        $nbTermines = 0;
        $nbPlaces = 0;

        foreach ($evenements as $evenement) {
            $nbPlaces += $evenement->getNbPlaces();

            foreach ($evenement->getParticipations() as $participation) {
                if ($participation->getStatus() === 'accepte') {
                    $nbParticipants++;
                }
            }

            if ($evenement->getStatus() === 'en_attente') {
                $nbValidation++;
            }

            if ($evenement->getDateEnd() <= $now) {
                $nbTermines++;
            } elseif ($evenement->getStartedAt() !== null) {
                $nbEnCours++;
            } else {
                $nbAVenir++;
            }
        }

        $tauxRemplissage = $nbPlaces > 0
            ? round(($nbParticipants / $nbPlaces) * 100)
            : 0;


        return $this->render('organisateur/index.html.twig', [
            'controller_name' => 'OrganisateurController',
            'evenements' => $evenements,
            'participationsAcceptees' => $participationsAcceptees,
            'nbEvenements' => $nbEvenements,
            'nbParticipants' => $nbParticipants,
            'nbParticipantsInscrits' => $nbParticipantsInscrits,
            'nbValidation' => $nbValidation,
            'nbEnCours' => $nbEnCours,
            'nbAVenir' => $nbAVenir,
            'nbTermines' => $nbTermines,
            'tauxRemplissage' => $tauxRemplissage
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