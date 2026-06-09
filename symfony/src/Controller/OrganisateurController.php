<?php

namespace App\Controller;

use App\Repository\EvenementRepository;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;


final class OrganisateurController extends AbstractController
{
    #[Route('/organisateur', name: 'app_organisateur')]
    public function index(EvenementRepository $evenementRepository): Response
    {
           $evenements = $evenementRepository->findBy([
            'organisateur' => $this->getUser(),
        ]);

        return $this->render('organisateur/index.html.twig', [
            'controller_name' => 'OrganisateurController',
            'evenements' => $evenements,
        ]);

     
        
    }
}
