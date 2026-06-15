<?php

namespace App\Controller;

use App\Form\ProfileType;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class ProfileController extends AbstractController
{
    #[IsGranted('ROLE_JOUEUR')]
    #[Route('/profile', name: 'app_profile')]
    public function index(
        Request $request,
        EntityManagerInterface $entityManager
    ): Response {

    $user = $this->getUser();
    if (!$user instanceof \App\Entity\User) {
    throw $this->createAccessDeniedException();
}

    $form = $this->createForm(
        ProfileType::class,
        $user
    );

    $form->handleRequest($request);
    if (
        $form->isSubmitted()
        && $form->isValid()
    ) {
        $user->setAvatar(
            'https://api.dicebear.com/9.x/adventurer/svg?seed='
            . urlencode($user->getPseudo())
        );
        $entityManager->flush();
        $this->addFlash(
            'success',
            'profil mis a jour.'
        );
        return $this->redirectToRoute(
            'app_profile'
        );
    }
        return $this->render('profile/index.html.twig', [
            'controller_name' => 'ProfileController',
            'form' => $form,
        ]);
    }
}
