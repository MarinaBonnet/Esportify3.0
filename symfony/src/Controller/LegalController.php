<?php

namespace App\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;

final class LegalController extends AbstractController
{
    #[Route('/mentions-legales', name: 'mentions_legales')]
    public function mentionsLegales(): Response
    {
        return $this->render('legal/mentions_legales.html.twig');
    }

    #[Route('/politique-confidentialite', name: 'confidentialite')]
    public function confidentialite(): Response
    {
        return $this->render('legal/confidentialite.html.twig');
    }

    #[Route('/conditions-utilisation', name: 'conditions')]
    public function conditions(): Response
    {
        return $this->render('legal/conditions.html.twig');
    }
}
