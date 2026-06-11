<?php

namespace App\Controller;

use App\Document\Message;
use App\Entity\Evenement;
use Doctrine\ODM\MongoDB\DocumentManager;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\Security\Http\Attribute\IsGranted;
use App\Repository\ParticipationRepository;
use App\Repository\UserRepository;



final class ChatController extends AbstractController
{
    #[Route('evenement/{id}/chat', name: 'app_chat', methods:['GET','POST'])]
    public function index(
        Evenement $evenement,
        Request $request,
        DocumentManager $dm,
        ParticipationRepository $participationRepository,
        UserRepository $userRepository
    ): Response{
        $participation = $participationRepository->findOneBy([
            'user' => $this->getUser(),
            'evenement' => $evenement,
            'status' => 'accepte',
        ]);
        if (!$participation){
            throw $this->createAccessDeniedException(
                'Vous devez etre accepté à cet événement pour acceder au chat.'
            );

        }

        if ($request-> isMethod('POST')) {
            $contenu = $request->request->get('contenu');

            if ($contenu) {
                $message = new Message();
                $message->setEvenementId($evenement->getId());
                $message->setUserId($this->getUser()->getId());
                $message->setContenu($contenu);

                $dm->persist($message);
                $dm->flush();
            }

            return $this->redirectToRoute('app_chat', [
                'id'=> $evenement->getId(),
            ]);
        }

        $messages = $dm
            ->getRepository(Message::class)
            ->findBy(
                ['evenementId' => $evenement->getId()],
                ['createdAt'=> 'ASC']
                );


        $pseudos = [];

        foreach ($messages as $message) {

            $user = $userRepository->find(
                $message->getUserId()
            );

            if ($user) {
                $pseudos[$message->getId()] = $user->getPseudo();
            }
        }
                return $this->render('chat/index.html.twig', [
            'controller_name' => 'ChatController',
            'evenement' => $evenement,
            'messages' => $messages,
            'pseudos' => $pseudos
        ]);
    }
}
