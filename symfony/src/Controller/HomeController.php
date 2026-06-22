<?php

namespace App\Controller;

use App\Entity\Newsletter;
use App\Form\NewsletterType;
use App\Repository\NewsletterRepository;
use App\Repository\EvenementRepository;
use App\Repository\FavoriRepository;
use App\Repository\ParticipationRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class HomeController extends AbstractController
{
    #[Route('/', name: 'app_home')]
    public function index(
        Request $request,
        EvenementRepository $evenementRepository,
        ParticipationRepository $participationRepository,
        FavoriRepository $favoriRepository,
        NewsletterRepository $newsletterRepository,
        EntityManagerInterface $entityManager,
    ): Response {
    
         $evenements = $evenementRepository->findBy(
        ['status' => 'valide'],
        ['dateStart' => 'ASC'],
        3
    );
    $participationUtilisateur = [];

    if ($this->getUser()) {
        $participations = $participationRepository->findBy([
            'user' => $this->getUser(),
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
    $newsletter = new Newsletter();
    $newsletterForm = $this->createForm(NewsletterType::class, $newsletter);
    $newsletterForm->handleRequest($request);

    if ($newsletterForm->isSubmitted() && $newsletterForm->isValid()) {
        $existingNewsletter = $newsletterRepository->findOneBy([
            'email' => $newsletter->getEmail(),
        ]);

        if (!$existingNewsletter) {
            $newsletter->setToken(bin2hex(random_bytes(32)));
            $newsletter->setCreatedAt(new \DateTimeImmutable());

            $entityManager->persist($newsletter);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_home');
}
        return $this->render('home/index.html.twig', [
            'controller_name' => 'HomeController',
            'evenements' => $evenements,
            'participationsUtilisateur' => $participationUtilisateur,
            'favorisUtilisateur' => $favorisUtilisateur,
            'newsletterForm' => $newsletterForm->createView(),
        ]);
    }
}
