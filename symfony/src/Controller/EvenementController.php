<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Entity\Favori;
use App\Entity\Participation;
use App\Form\EvenementType;
use App\Repository\EvenementRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/evenement')]

final class EvenementController extends AbstractController
{
    
    #[Route(name: 'app_evenement_index', methods: ['GET'])]
    public function index(EvenementRepository $evenementRepository): Response
    {
        return $this->render('evenement/index.html.twig', [
            'evenements' => $evenementRepository->findAll(),
        ]);
    }

    #[IsGranted('ROLE_ORGANISATEUR')]
    #[Route('/new', name: 'app_evenement_new', methods: ['GET', 'POST'])]
    public function new(Request $request, EntityManagerInterface $entityManager): Response
    {
        $evenement = new Evenement();
        $form = $this->createForm(EvenementType::class, $evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $evenement->setOrganisateur($this->getUser());
            $evenement->setStatus('en_attente');
            $evenement->setCreatedAt(new \DateTimeImmutable());

            $entityManager->persist($evenement);
            $entityManager->flush();

            return $this->redirectToRoute('app_evenement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('evenement/new.html.twig', [
            'evenement' => $evenement,
            'form' => $form,
        ]);
    }

    #[Route('/{id}', name: 'app_evenement_show', methods: ['GET'])]
    public function show(Evenement $evenement): Response
    {
        return $this->render('evenement/show.html.twig', [
            'evenement' => $evenement,
        ]);
    }

    #[IsGranted('ROLE_ORGANISATEUR')]
    #[Route('/{id}/edit', name: 'app_evenement_edit', methods: ['GET', 'POST'])]
    public function edit(Request $request, Evenement $evenement, EntityManagerInterface $entityManager): Response
    {
        $form = $this->createForm(EvenementType::class, $evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $entityManager->flush();

            return $this->redirectToRoute('app_evenement_index', [], Response::HTTP_SEE_OTHER);
        }

        return $this->render('evenement/edit.html.twig', [
            'evenement' => $evenement,
            'form' => $form,
        ]);
    }

    #[IsGranted('ROLE_ORGANISATEUR')]
    #[Route('/{id}', name: 'app_evenement_delete', methods: ['POST'])]
    public function delete(Request $request, Evenement $evenement, EntityManagerInterface $entityManager): Response
    {
        if ($this->isCsrfTokenValid('delete'.$evenement->getId(), $request->getPayload()->getString('_token'))) {
            $entityManager->remove($evenement);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_evenement_index', [], Response::HTTP_SEE_OTHER);
    }

    #[IsGranted('ROLE_JOUEUR')]
    #[Route('/{id}/participer', name: 'app_evenement_participer', methods: ['GET'])]
    public function participer(Evenement $evenement, EntityManagerInterface $entityManager): Response
    {
        $participationExistante = $entityManager
            ->getRepository(Participation::class)
            ->findOneBy([
                'user' => $this->getUser(),
                'evenement' => $evenement,
            ]);

        if ($participationExistante) {
            return $this->redirectToRoute('app_home');
        }
        $participation = new Participation();
        $participation->setUser($this->getUser());
        $participation->setEvenement($evenement);
        $participation->setStatus('en_attente');

        $entityManager->persist($participation);
        $entityManager->flush();

        return $this->redirectToRoute('app_home');
    }

    #[IsGranted('ROLE_JOUEUR')]
    #[Route('/{id}/favori', name: 'app_evenement_favori', methods: ['GET'])]
    public function ajouterFavori(
        Evenement $evenement,
        EntityManagerInterface $entityManager
    ): Response {
        $favoriExistant = $entityManager
            ->getRepository(Favori::class)
            ->findOneBy([
                'user' => $this->getUser(),
                'evenement' => $evenement,
            ]);

        if ($favoriExistant) {
            return $this->redirectToRoute('app_home');
        }

        $favori = new Favori();
        $favori->setUser($this->getUser());
        $favori->setEvenement($evenement);

        $entityManager->persist($favori);
        $entityManager->flush();

        return $this->redirectToRoute('app_home');
    }
    
    #[IsGranted('ROLE_JOUEUR')]
    #[Route('/{id}/retirer-favori', name: 'app_evenement_retirer_favori')]
    public function retirerFavori(
        Evenement $evenement,
        EntityManagerInterface $entityManager
    ): Response {
        $favori = $entityManager
            ->getRepository(Favori::class)
            ->findOneBy([
                'user' => $this->getUser(),
                'evenement' => $evenement,
            ]);

        if ($favori) {
            $entityManager->remove($favori);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_home');
    }
}
