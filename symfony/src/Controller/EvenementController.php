<?php

namespace App\Controller;

use App\Entity\Evenement;
use App\Entity\Favori;
use App\Entity\Image;
use App\Entity\Participation;
use App\Form\EvenementType;
use App\Repository\EvenementRepository;
use App\Repository\ScoreRepository;
use Doctrine\ORM\EntityManagerInterface;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\HttpFoundation\JsonResponse;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpFoundation\File\Exception\FileException;
use Symfony\Component\Routing\Attribute\Route;
use Symfony\Component\Security\Http\Attribute\IsGranted;

#[Route('/evenement')]

final class EvenementController extends AbstractController
{

    #[Route(name: 'app_evenement_index', methods: ['GET'])]
    public function index(
        EvenementRepository $evenementRepository,
        ScoreRepository $scoreRepository
    ): Response {
        $evenements = $evenementRepository->findBy(
            ['status' => 'valide'],
            ['dateStart' => 'ASC']
        );

        $now = new \DateTimeImmutable();

        $aVenir = [];
        $enCours = [];
        $termines = [];

        foreach ($evenements as $evenement) {
            if ($evenement->getDateStart() > $now) {
                $aVenir[] = $evenement;
            } elseif (
                $evenement->getDateStart() <= $now &&
                $evenement->getDateEnd() >= $now
            ) {
                $enCours[] = $evenement;
            } else {
                $termines[] = $evenement;
            }
        }
        return $this->render('evenement/index.html.twig', [
            'aVenir' => $aVenir,
            'enCours' => $enCours,
            'termines' => $termines,

            'topScores' => $scoreRepository->findBy(
                [],
                ['value' => 'DESC'],
                5
            ),
        ]);
    }

    #[IsGranted('ROLE_JOUEUR')]
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

            $imageFile = $form->get('imageFile')->getData();

            if ($imageFile) {
                $newFilename = uniqid() . '.' . $imageFile->guessExtension();

                try {
                    $imageFile->move(
                        $this->getParameter('kernel.project_dir') . '/public/uploads/evenements',
                        $newFilename
                    );
                } catch (FileException $e) {
                    // Plus tard : message d'erreur utilisateur
                }

                $image = new Image();
                $image->setUrl('uploads/evenements/' . $newFilename);
                $image->setAlt($evenement->getTitre());
                $image->setEvenement($evenement);

                $entityManager->persist($image);
            }

            $entityManager->flush();

            if ($this->isGranted('ROLE_ADMIN')) {
                return $this->redirectToRoute('app_admin');
            }

            if ($this->isGranted('ROLE_ORGANISATEUR')) {
                return $this->redirectToRoute('app_organisateur');
            }

            return $this->redirectToRoute('app_joueur');
        }

        return $this->render('evenement/new.html.twig', [
            'evenement' => $evenement,
            'form' => $form,
        ]);
    }

    #[Route('/filter', name: 'app_evenement_filter', methods: ['GET'])]
    public function filter(
        Request $request,
        EvenementRepository $evenementRepository
    ): JsonResponse {

        $sort = $request->query->get('sort');

        $evenements = $evenementRepository->findFiltered($sort);

        $data = [];

        foreach ($evenements as $evenement) {

            $data[] = [
                'id' => $evenement->getId(),
                'titre' => $evenement->getTitre(),
                'dateStart' => $evenement->getDateStart()?->format('d/m/Y H:i'),
                'dateEnd' => $evenement->getDateEnd()?->format('d/m/Y H:i'),
                'nbPlaces' => $evenement->getNbPlaces(),
                'organisateur' => $evenement->getOrganisateur()?->getPseudo(),
                
            ];
        }

        return $this->json($data);
    }

    #[Route('/{id}/details', name: 'app_evenement_details', methods: ['GET'])]
    public function details(Evenement $evenement): JsonResponse
    {
        $image = $evenement->getImages()->first();

        return $this->json([
            'id' => $evenement->getId(),
            'titre' => $evenement->getTitre(),
            'description' => $evenement->getDescription(),
            'nbPlaces' => $evenement->getNbPlaces(),
            'dateStart' => $evenement->getDateStart()?->format('d/m/Y H:i'),
            'dateEnd' => $evenement->getDateEnd()?->format('d/m/Y H:i'),
            'dateEndRaw' => $evenement->getDateEnd()?->format('Y-m-d H:i:s'),
            'organisateur' => $evenement->getOrganisateur()?->getPseudo(),
            'image' => $image ? $image->getUrl() : null,
            'isAuthenticated' => $this->getUser() !== null,
            'participateUrl' => $this->generateUrl('app_evenement_participer', [
                'id' => $evenement->getId(),
            ]),
        ]);
    }

    #[Route('/{id}', name: 'app_evenement_show', methods: ['GET'])]
    public function show(Evenement $evenement): Response
    {

    if (
        $evenement->getStatus() !== 'valide'
        && !$this->isGranted('ROLE_ADMIN')
        && $evenement->getOrganisateur() !== $this->getUser()
    ) {
        throw $this->createAccessDeniedException(
            'Cet événement n’est pas visible publiquement.'
        );
    }
        return $this->render('evenement/show.html.twig', [
            'evenement' => $evenement,
        ]);
    }

    #[IsGranted('ROLE_JOUEUR')]
    #[Route('/{id}/edit', name: 'app_evenement_edit', methods: ['GET', 'POST'])]
    public function edit(
        Request $request,
        Evenement $evenement,
        EntityManagerInterface $entityManager,
    ): Response {
        $user = $this->getUser();

        if (
            !$this->isGranted('ROLE_ADMIN')
            && $evenement->getOrganisateur() !== $user
        ) {
            throw $this->createAccessDeniedException(
                'Vous ne pouvez modifier que vos propres événements.'
            );
        }

        if (
            !$this->isGranted('ROLE_ADMIN')
            && $evenement->getDateStart() <= new \DateTimeImmutable()
        ) {
            throw $this->createAccessDeniedException(
                'Cet événement ne peut plus être modifié car il a commencé.'
            );
        }

        if (
            !$this->isGranted('ROLE_ADMIN')
            && $evenement->getStartedAt() !== null
        ) {
            throw $this->createAccessDeniedException(
                'Cet événement ne peut plus être modifié car il est démarré.'
            );
        }

        $form = $this->createForm(EvenementType::class, $evenement);
        $form->handleRequest($request);

        if ($form->isSubmitted() && $form->isValid()) {
            $evenement->setStatus('en_attente');
            $evenement->setMotifRefus(null);
            $entityManager->flush();

        if ($this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('app_admin');
        }

        if ($this->isGranted('ROLE_ORGANISATEUR')) {
            return $this->redirectToRoute('app_organisateur');
        }

        return $this->redirectToRoute('app_joueur');
        }

        return $this->render('evenement/edit.html.twig', [
            'evenement' => $evenement,
            'form' => $form,
        ]);
    }

    #[IsGranted('ROLE_JOUEUR')]
    #[Route('/{id}', name: 'app_evenement_delete', methods: ['POST'])]
    public function delete(Request $request, Evenement $evenement, EntityManagerInterface $entityManager): Response
    {
        if (
            !$this->isGranted('ROLE_ADMIN')
            && $evenement->getOrganisateur() !== $this->getUser()
        ) {
            throw $this->createAccessDeniedException(
                'Vous ne pouvez gérer que vos propres événements.'
            );
        }
    
        if ($this->isCsrfTokenValid('delete' . $evenement->getId(), $request->getPayload()->getString('_token'))) {

            foreach ($evenement->getImages() as $image) {
                $entityManager->remove($image);
            }
            foreach ($evenement->getParticipations() as $participation) {
                $entityManager->remove($participation);
            }

            foreach ($evenement->getFavoris() as $favori) {
                $entityManager->remove($favori);
            }

            foreach ($evenement->getScores() as $score) {
                $entityManager->remove($score);
            }
            
            $entityManager->remove($evenement);
            $entityManager->flush();
        }
        
        if ($this->isGranted('ROLE_ADMIN')) {
            return $this->redirectToRoute('app_admin');
        }

        if ($this->isGranted('ROLE_ORGANISATEUR')) {
            return $this->redirectToRoute('app_organisateur');
        }

        return $this->redirectToRoute('app_joueur');

    }

    #[IsGranted('ROLE_JOUEUR')]
    #[Route('/{id}/participer', name: 'app_evenement_participer', methods: ['GET'])]
    public function participer(
        Evenement $evenement,
        EntityManagerInterface $entityManager
    ): Response {

        if ($evenement->getDateEnd() <= new \DateTimeImmutable()) {
            throw $this->createAccessDeniedException(
                'Cet événement est terminé.'
            );
        }

        if ($evenement->getStatus() !== 'valide') {
            throw $this->createAccessDeniedException(
                'Vous ne pouvez participer qu’à un événement validé.'
            );
        }

        $participantsAcceptes = $evenement->getParticipations()
            ->filter(fn ($participation) => $participation->getStatus() === 'accepte')
            ->count();

        if ($participantsAcceptes >= $evenement->getNbPlaces()) {
            throw $this->createAccessDeniedException(
                'Cet événement est complet.'
            );
        }

        $participationExistante = $entityManager
            ->getRepository(Participation::class)
            ->findOneBy([
                'user' => $this->getUser(),
                'evenement' => $evenement,
            ]);

        if ($participationExistante) {
            return $this->redirectToRoute('app_joueur');
        }

        $participation = new Participation();
        $participation->setUser($this->getUser());
        $participation->setEvenement($evenement);
        $participation->setStatus('accepte');

        $entityManager->persist($participation);
        $entityManager->flush();

        return $this->redirectToRoute('app_joueur');
    }


    #[IsGranted('ROLE_JOUEUR')]
    #[Route('/{id}/desinscrire', name: 'app_evenement_desinscrire', methods: ['GET'])]
    public function desinscrire(
        Evenement $evenement,
        EntityManagerInterface $entityManager
    ): Response {
        if ($evenement->getDateStart() <= new \DateTimeImmutable()) {
            throw $this->createAccessDeniedException(
                'Vous ne pouvez plus vous désinscrire après le début de l’événement.'
            );
        }

        $participation = $entityManager
            ->getRepository(Participation::class)
            ->findOneBy([
                'user' => $this->getUser(),
                'evenement' => $evenement,
            ]);

        if ($participation && $participation->getStatus() !== 'refuse') {
            $entityManager->remove($participation);
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_joueur');
    }

    
    #[Route('/{id}/favori', name: 'app_evenement_favori', methods: ['POST'])]
    public function toggleFavori(
        Evenement $evenement,
        EntityManagerInterface $entityManager
    ): JsonResponse {

        if (!$this->isGranted('ROLE_JOUEUR')) {
            return $this->json([
                'success' => false,
                'message' => 'Vous devez être connecté pour ajouter un événement aux favoris.',
            ], 401);
        }
        
        if ($evenement->getDateEnd() <= new \DateTimeImmutable()) {
            return $this->json([
                'success' => false,
                'message' => 'Vous ne pouvez pas ajouter un événement terminé aux favoris.',
            ], 403);
        }

        $favoriRepository = $entityManager->getRepository(Favori::class);

        $favoriExistant = $favoriRepository->findOneBy([
            'user' => $this->getUser(),
            'evenement' => $evenement,
        ]);

        if ($favoriExistant) {
            $entityManager->remove($favoriExistant);
            $entityManager->flush();

            return $this->json([
                'success' => true,
                'favorite' => false,
                'message' => 'Événement retiré des favoris.',
            ]);
        }

        $favori = new Favori();
        $favori->setUser($this->getUser());
        $favori->setEvenement($evenement);
        $favori->setCreatedAt(new \DateTimeImmutable());

        $entityManager->persist($favori);
        $entityManager->flush();

        return $this->json([
            'success' => true,
            'favorite' => true,
            'message' => 'Événement ajouté aux favoris.',
        ]);
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

        return $this->redirectToRoute('app_joueur');
    }
    
    #[IsGranted('ROLE_ORGANISATEUR')]
    #[Route('/{id}/start', name: 'app_evenement_start')]
    public function start(
        Evenement $evenement,
        EntityManagerInterface $entityManager
    ): Response {

        if ($evenement->getStatus() !== 'valide')
        {
            throw $this->createAccessDeniedException(
                'Seul un événement valider peut etre démarré.'
            );
        }
        if ($evenement->getDateEnd()<= new \DateTimeImmutable()) {
            throw $this->createAccessDeniedException(
                'Cet événement est términé.'
            );
        }

        $startLimit = $evenement->getDateStart()->modify('-30 minutes');

        if (new \DateTimeImmutable() < $startLimit) {
            throw $this->createAccessDeniedException(
                'L’événement ne peut être démarré que 30 minutes avant son début.'
            );
        }
        if ($evenement->getStartedAt() === null) {
            $evenement->setStartedAt(new \DateTimeImmutable());
            $entityManager->flush();
        }

        return $this->redirectToRoute('app_organisateur');
    }

    #[Route('/{id}/classement', name: 'app_evenement_classement', methods: ['GET'])]
    public function classement(
        Evenement $evenement,
        ScoreRepository $scoreRepository
    ): Response {
        $scores = $scoreRepository->findBy(
            ['evenement' => $evenement],
            ['value' => 'DESC']
        );

        return $this->render('evenement/classement.html.twig', [
            'evenement' => $evenement,
            'scores' => $scores,
        ]);
    }

}
