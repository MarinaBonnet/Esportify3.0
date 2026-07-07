<?php

namespace App\Controller;

use App\Document\Message;
use App\Entity\Evenement;
use App\Repository\ParticipationRepository;
use App\Repository\UserRepository;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

final class RoomController extends AbstractController
{
    #[IsGranted('ROLE_JOUEUR')]
    #[Route('/evenement/{id}/room', name: 'app_evenement_room')]
    public function index(
        Evenement $evenement,
        Request $request,
        ParticipationRepository $participationRepository,
        UserRepository $userRepository,
        DocumentManager $dm
    ): Response {
        $user = $this->getUser();

        if (!$user instanceof \App\Entity\User) {
            throw $this->createAccessDeniedException();
        }
        $isAdmin = $this->isGranted('ROLE_ADMIN');

        $isOrganisateur = $this->isGranted('ROLE_ORGANISATEUR');
        $isCreateur = $evenement->getOrganisateur() === $user;

        $participation = $participationRepository->findOneBy([
            'user' => $user,
            'evenement' => $evenement,
            'status' => 'accepte',
        ]);

        if ( !$isAdmin && !$isOrganisateur &&!$isCreateur && !$participation) {
            throw $this->createAccessDeniedException(
                'Vous devez être accepté à cet événement pour rejoindre la room.'
            );
        }

        $now = new \DateTimeImmutable();

        if ($evenement->getStartedAt() === null) {
            throw $this->createAccessDeniedException(
                'L’événement n’a pas encore été démarré par l’organisateur.'
            );
        }

        if ($evenement->getDateStart() > $now) {
            throw $this->createAccessDeniedException(
                'L’événement n’a pas encore commencé.'
            );
        }

        if ($evenement->getDateEnd() <= $now) {
            throw $this->createAccessDeniedException(
                'Le chat est fermé car l’événement est terminé.'
            );
        }

        if ($request->isMethod('POST')) {
            $contenu = trim($request->request->get('contenu', ''));

            if ($contenu === '') {
                $this->addFlash('error', 'Le message ne peut pas être vide.');

                return $this->redirectToRoute('app_evenement_room', [
                    'id' => $evenement->getId(),
                ]);
            }
            if (mb_strlen($contenu) > 500) {
                $this->addFlash('error', 'Le message ne peut pas dépasser 500 caractères.');

                return $this->redirectToRoute('app_evenement_room', [
                    'id' => $evenement->getId(),
                ]);
            }

                $message = new Message();
                $message->setEvenementId($evenement->getId());
                $message->setUserId($user->getId());
                $message->setContenu($contenu);

                $dm->persist($message);
                $dm->flush();
            

            return $this->redirectToRoute('app_evenement_room', [
                'id' => $evenement->getId(),
            ]);
        }

        $messages = $dm
            ->getRepository(Message::class)
            ->findBy(
                ['evenementId' => $evenement->getId()],
                ['createdAt' => 'ASC']
            );

        $pseudos = [];
        $avatars = [];

        foreach ($messages as $message) {
            $messageUser = $userRepository->find($message->getUserId());

            if ($messageUser) {
                $pseudos[$message->getId()] = $messageUser->getPseudo();
                $avatars[$message->getId()] = $messageUser->getAvatar();
            }
        }

        return $this->render('room/index.html.twig', [
            'evenement' => $evenement,
            'messages' => $messages,
            'pseudos' => $pseudos,
            'avatars' => $avatars,
            'isAdmin' => $isAdmin,
            'isOrganisateur' => $isOrganisateur || $isCreateur,
        ]);
    }
    
    #[Route('/evenement/{id}/room/message/{messageId}/delete', name: 'app_room_delete_message')]
    public function deleteMessage(
        Evenement $evenement,
        string $messageId,
        DocumentManager $dm
    ): Response {
        $user = $this->getUser();

        if (!$user instanceof \App\Entity\User) {
            throw $this->createAccessDeniedException();
        }

        $isAdmin = $this->isGranted('ROLE_ADMIN');
        $isOrganisateur = $this->isGranted('ROLE_ORGANISATEUR');
        $isCreateur = $evenement->getOrganisateur() === $user;

    
        $message = $dm
            ->getRepository(Message::class)
            ->find($messageId);

        if (!$message) {
            throw $this->createNotFoundException('Message introuvable.');
        }

        if ($message->getEvenementId() !== $evenement->getId()) {
            throw $this->createAccessDeniedException(
                'Ce message ne correspond pas à cet événement.'
            );
        }

        $canDeleteMessage =
            $isAdmin
            || $isOrganisateur
            || $isCreateur
            || $message->getUserId() === $user->getId();

        if (!$canDeleteMessage) {
            throw $this->createAccessDeniedException(
                'Vous ne pouvez pas supprimer ce message.'
            );
        }

        $message->setDeleted(true);
        $message->setDeletedBy($user->getId());
        $message->setDeletedAt(new \DateTimeImmutable());

        $dm->flush();

        return $this->redirectToRoute('app_evenement_room', [
            'id' => $evenement->getId(),
        ]);
    }
}