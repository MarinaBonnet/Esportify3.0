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
        $participation = $participationRepository->findOneBy([
            'user' => $this->getUser(),
            'evenement' => $evenement,
            'status' => 'accepte',
        ]);

        if (!$participation) {
            throw $this->createAccessDeniedException(
                'Vous devez être accepté à cet événement pour rejoindre la room.'
            );
        }

        if ($evenement->getStartedAt() === null) {
            throw $this->createAccessDeniedException(
                'L’événement n’a pas encore été démarré par l’organisateur.'
            );
        }

        if ($evenement->getDateStart() > new \DateTimeImmutable()) {
            throw $this->createAccessDeniedException(
                'L’événement n’a pas encore commencé.'
            );
        }

        if ($request->isMethod('POST')) {
            $contenu = trim($request->request->get('contenu', ''));

            if ($contenu !== '') {
                $message = new Message();
                $message->setEvenementId($evenement->getId());
                $message->setUserId($this->getUser()->getId());
                $message->setContenu($contenu);

                $dm->persist($message);
                $dm->flush();
            }

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

        foreach ($messages as $message) {
            $user = $userRepository->find($message->getUserId());

            if ($user) {
                $pseudos[$message->getId()] = $user->getPseudo();
            }
        }

        return $this->render('room/index.html.twig', [
            'evenement' => $evenement,
            'messages' => $messages,
            'pseudos' => $pseudos,
        ]);
    }
}