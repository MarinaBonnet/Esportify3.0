# Journal de développement Esportify 3.0

## 01/06/2026

### Mise en place du projet

- Création du dépôt GitHub
- Mise en place Git Flow
- Création des branches main et dev
- Initialisation Symfony
- Mise en place Docker

---

## 02/06/2026

### Mise en place de Docker

- Création du docker-compose.yml
- Configuration PHP 8.3
- Configuration MySQL 8
- Configuration MongoDB
- Configuration Nginx

---

## 03/06/2026

### Base de données

- Installation Doctrine ORM
- Création de l'entité User
- Création des migrations
- Création de la base MySQL

---

## 06/06/2026

### Authentification

- Installation Security Bundle
- Génération LoginFormAuthenticator
- Mise en place page de connexion
- Tests d'authentification

### Fixtures

- Création Admin
- Création Organisateur
- Création Joueur

---

## 07/06/2026

### Corrections

- Correction LoginFormAuthenticator
- Vérification des rôles

---

## 08/06/2026

### Vérification du TODO

✓ Docker
✓ Symfony
✓ Doctrine
✓ Security
✓ Fixtures

À faire :

- Dashboard Organisateur
- Dashboard Joueur
- Entité Tournament
- Entité Team
- Chat MongoDB

AUTHENTIFICATION

- Création HomeController
- Création route app_home
- Correction LoginFormAuthenticator
- Mise en place redirection après connexion
- Configuration logout dans security.yaml
- Vérification sessions Symfony

TESTS

✓ Connexion Admin
✓ Connexion Organisateur
✓ Connexion Joueur
✓ Déconnexion

Résultat :
Système d'authentification entièrement fonctionnel.

---

## 09/06/2026

### Gestion des rôles

- Vérification des rôles utilisateurs
- Configuration des accès dans security.yaml
- Mise en place de la hiérarchie des droits
- Tests des autorisations

Rôles configurés :

- ROLE_ADMIN
- ROLE_ORGANISATEUR
- ROLE_JOUEUR

### Dashboards

Création des espaces utilisateurs :

- Dashboard Administrateur
- Dashboard Organisateur
- Dashboard Joueur

Tests réalisés :

✓ Accès Admin → Dashboard Administrateur

✓ Accès Organisateur → Dashboard Organisateur

✓ Accès Organisateur → Dashboard Joueur

✓ Accès Joueur → Dashboard Joueur

✓ Accès refusé selon les permissions

Résultat :

Le système de gestion des rôles et des autorisations est opérationnel.

### Analyse métier des événements

Étude du cahier des charges afin de définir les règles métier liées aux événements.

Règles identifiées :

- Un joueur peut proposer un événement.
- Un événement est créé avec le statut « en attente ».
- Un administrateur valide ou refuse l'événement.
- Un organisateur gère ses propres événements.
- Un administrateur possède l'ensemble des droits de la plateforme.

### Dashboard Organisateur

Connexion du dashboard à la base de données.

Utilisation de :

- EvenementRepository
- Doctrine ORM
- Injection de dépendance
- getUser()

Objectif :

Afficher uniquement les événements de l'utilisateur connecté.

Résultat :

Le dashboard organisateur est prêt à afficher les événements associés à son propriétaire.

### Gestion des événements

- Génération du CRUD Evenement avec Symfony Maker Bundle.
- Création automatique du contrôleur EvenementController.
- Création du formulaire EvenementType.
- Génération des vues Twig (liste, création, modification, détail et suppression).

Adaptation du formulaire métier :

- Suppression des champs status, createdAt et organisateur du formulaire utilisateur.
- Association automatique de l'organisateur connecté lors de la création.
- Attribution automatique du statut "en_attente".
- Enregistrement automatique de la date de création.

Création des données de référence :

- Création de plusieurs jeux via les fixtures (Valorant, League of Legends, Rocket League, Counter-Strike 2, Fortnite).
- Liaison entre les événements et les jeux.

Modération des événements :

- Création de la liste des événements en attente dans le dashboard administrateur.
- Affichage des événements à modérer.
- Mise en place des actions de validation et de refus.
- Modification du statut des événements par l'administrateur.

Page d'accueil :

- Connexion du HomeController à la base de données.
- Affichage uniquement des événements validés.
- Tri des événements par date de début.
- Affichage des informations principales des événements.

Tests réalisés :

- Création d'un premier événement.
- Vérification de l'enregistrement en base de données.
- Vérification de l'affichage dans le dashboard organisateur.
- Vérification de la liaison avec l'entité Jeu.
- Vérification du workflow de validation administrateur.
- Vérification de l'affichage des événements validés sur la page d'accueil.

Résultat :

Le cycle complet de création, validation et publication des événements est opérationnel et conforme aux règles métier du projet Esportify.

### Gestion des participations

- Mise en place de l'inscription d'un joueur à un événement.
- Création automatique d'une participation avec le statut "en_attente".
- Liaison entre l'utilisateur connecté et l'événement sélectionné.
- Protection de la route par le rôle ROLE_JOUEUR.
- Création d'une participation lors de l'inscription d'un joueur.
- Statut initial : en_attente.
- Empêchement des doublons d'inscription.
- Affichage des demandes dans le dashboard organisateur.
- Ajout des actions Accepter / Refuser.
- Validation de l'inscription par l'organisateur.

Tests réalisés :

- Vérification de la création d'une participation.
- Vérification de l'enregistrement en base de données.
- Mise en place d'un contrôle empêchant les inscriptions multiples à un même événement.

Résultat :

Le système d'inscription des joueurs aux événements est opérationnel et fonctionnel

---

## 10/06/2026

### Gestion des participations

- Affichage des demandes de participation dans le dashboard organisateur.
- Mise en place des actions Accepter / Refuser.
- Changement automatique du statut de la participation.
- Vérification en base de données.

### Gestion des favoris

Ajout de l'entité Favori dans le workflow utilisateur.
Création de la fonctionnalité "Ajouter aux favoris".
Mise en place d'un contrôle anti-doublon empêchant l'ajout multiple d'un même événement.
Création de la fonctionnalité "Retirer des favoris".
Mise à jour dynamique de l'interface utilisateur.

Tests réalisés :

Ajout d'un événement aux favoris.
Vérification de l'enregistrement en base de données.
Suppression d'un favori.
Vérification de la suppression en base de données.

Résultat :

Le système de favoris est entièrement fonctionnel.

Amélioration de l'accueil
Affichage dynamique du statut de participation d'un joueur.
Affichage du bouton "Participer" uniquement lorsqu'aucune participation n'existe.
Affichage des statuts :
en_attente
accepte
refuse

Résultat :

L'utilisateur visualise immédiatement son état d'inscription à un événement.

Dashboard Joueur
Affichage des événements ajoutés aux favoris.
Affichage des participations du joueur.
Affichage du statut des participations.
Exploitation des relations Doctrine entre User, Favori, Participation et Evenement.

Tests réalisés :

Vérification de l'affichage des favoris.
Vérification de l'affichage des participations.
Vérification des statuts associés.

Résultat :

L'espace joueur devient un véritable tableau de bord personnel regroupant les informations essentielles de l'utilisateur.

V1 Esportify :

- le score est prévu dans la base
- l’historique des scores est affichable
- la saisie automatique n’est pas encore connectée à une API de jeu

Score automatique idéal :
jeu / API / système externe
↓
récupération du résultat
↓
enregistrement en base
↓
affichage dans l’espace joueur

### Gestion des images d'événements

- Ajout d'un champ d'upload dans le formulaire de création d'événement.
- Mise en place du traitement des fichiers dans le contrôleur.
- Génération automatique d'un nom unique pour les images.
- Enregistrement des fichiers dans le dossier public/uploads/evenements.
- Création de l'entité Image liée à un événement.
- Stockage du chemin de l'image en base de données.
- Affichage des images sur la page d'accueil.

Tests réalisés :

- Upload d'une image depuis le poste de l'organisateur.
- Vérification de la création du fichier sur le serveur.
- Vérification de l'enregistrement en base de données.
- Vérification de l'affichage sur l'accueil après validation de l'événement.

Résultat :

Le système d'images pour les événements est entièrement fonctionnel.

## 11/06/2026

### Gestion de la newsletter

Objectif :

Permettre aux visiteurs de s'inscrire à la newsletter Esportify afin de recevoir les actualités de la plateforme et les informations sur les événements.

Travaux réalisés :

- Création de l'entité Newsletter.
- Mise en place des champs :
  - email
  - token
  - createdAt

- Création du formulaire NewsletterType.
- Intégration du formulaire sur la page d'accueil.
- Traitement du formulaire dans le HomeController.
- Génération automatique d'un token unique lors de l'inscription.
- Enregistrement automatique de la date d'inscription.
- Mise en place d'un système anti-doublon pour empêcher plusieurs inscriptions avec la même adresse email.

Tests réalisés :

- Inscription d'un utilisateur à la newsletter.
- Vérification de l'enregistrement en base de données.
- Vérification de la génération automatique du token.
- Vérification de l'enregistrement de la date de création.
- Vérification du fonctionnement de l'anti-doublon.

Résultat :

Le système d'inscription à la newsletter est opérationnel. Les abonnés sont enregistrés en base de données avec un identifiant unique permettant de préparer ultérieurement des fonctionnalités de confirmation ou de désinscription.

Évolutions prévues :

□ Interface d'administration des abonnés
□ Export de la liste des abonnés
□ Envoi de campagnes email
□ Désinscription via token unique
□ Confirmation d'inscription par email

### Système de chat MongoDB

Objectif :

Mettre en place un système de discussion lié aux événements e-sport.

Principe :

- Chaque événement possède son propre espace de discussion.
- Les joueurs peuvent échanger des messages avant, pendant et après l'événement.
- Les messages sont stockés dans MongoDB.
- Les données métier principales restent stockées dans MySQL.

Motivation technique :

Le chat génère un grand nombre de messages indépendants. MongoDB est particulièrement adapté à ce type de données documentaires et permet de démontrer l'utilisation d'une base NoSQL dans le projet Esportify.

### Mise en place de MongoDB pour le système de chat

Objectif :

Mettre en place une base de données NoSQL afin de gérer les messages du système de discussion des événements e-sport.

Travaux réalisés :

- Installation du bundle Doctrine MongoDB ODM.
- Configuration de la connexion MongoDB dans Symfony.
- Création du document Message.
- Mise en place du DocumentManager.
- Création d'un premier document de test.
- Validation du fonctionnement de l'insertion dans MongoDB.

Structure du document :

- evenementId
- userId
- contenu
- createdAt

Justification technique :

Les messages du chat sont des données indépendantes et fortement volumétriques. MongoDB est particulièrement adapté à ce type de stockage documentaire.

Résultat :

Le projet Esportify utilise désormais deux systèmes de stockage :

- MySQL pour les données métier relationnelles.
- MongoDB pour les messages du système de chat.

### Avancement MongoDB

Durant le développement local sous Docker, des permissions étendues ont été utilisées sur certains répertoires de cache Symfony afin de faciliter le travail avec Doctrine MongoDB ODM.

En environnement de production, ces permissions devront être restreintes et attribuées uniquement à l'utilisateur du serveur web afin de respecter les bonnes pratiques de sécurité.

- Installation et configuration de Doctrine MongoDB ODM.
- Création du document Message.
- Création d'un repository MongoDB.
- Mise en place du DocumentManager.
- Premier document enregistré dans MongoDB.
- Lecture des documents MongoDB avec findAll().
- Validation du fonctionnement complet du cycle :
  création → stockage → lecture.

Résultat :

Le projet Esportify dispose désormais d'un système NoSQL opérationnel destiné au futur chat des événements.

Le projet Esportify utilise deux systèmes de stockage complémentaires.

Les données métier fortement relationnelles (utilisateurs, événements, participations, favoris, scores) sont stockées dans une base MySQL via Doctrine ORM.

Le système de discussion des événements est stocké dans MongoDB via Doctrine ODM. Avant d'autoriser l'accès au chat, l'application vérifie dans MySQL qu'une participation acceptée existe entre le joueur et l'événement. Les messages sont ensuite récupérés depuis MongoDB.

Cette architecture permet d'utiliser chaque technologie selon ses points forts.

## 12/06/2026

## Room événementielle et intégration MongoDB

Finaliser la première version du système de room événementielle.

### MongoDB

- Installation et configuration de MongoDB avec Doctrine ODM.
- Création du document `Message`.
- Mise en place de l'enregistrement des messages dans MongoDB.
- Affichage des messages associés à un événement.
- Liaison entre MongoDB et MySQL via l'identifiant utilisateur (`userId`).
- Affichage du pseudo des joueurs à partir des données SQL.

### Gestion des événements

- Ajout du champ `startedAt` dans l'entité `Evenement`.
- Mise en place du démarrage manuel d'un événement par l'organisateur.
- Contrôle d'accès à la room selon les règles métier :
  - participation acceptée ;
  - événement démarré ;
  - date de début atteinte.

### Room événementielle

Création d'une page dédiée accessible aux joueurs autorisés :

- informations de l'événement ;
- organisateur ;
- date de début ;
- statut de l'événement ;
- nombre de participants ;
- nombre de places restantes ;
- liste des participants acceptés ;
- chat événementiel ;
- formulaire d'envoi de messages.

### Nettoyage technique

- Suppression des contrôleurs de test MongoDB.
- Centralisation de la logique dans `RoomController`.
- Simplification de l'architecture du chat.

### Compétences travaillées

- Symfony 7
- Doctrine ORM
- Doctrine MongoDB ODM
- Docker
- Gestion des rôles et autorisations
- Contrôle d'accès
- Architecture SQL + NoSQL
- Développement d'une fonctionnalité métier complète

### Prochaine étape

- Amélioration des dashboards Joueur, Organisateur et Administrateur.
- Gestion des scores et des résultats des tournois.
- Refonte graphique des interfaces.

## 14/06/2026

### Dashboard Organisateur

Amélioration du tableau de bord organisateur :

- Affichage du nombre de participants acceptés par événement.
- Calcul des places restantes.
- Affichage du statut de l'événement :
  - À venir
  - En cours
  - Terminé

- Ajout du bouton de démarrage de l'événement selon les règles métier.
- Ajout d'un accès direct à la room lorsque l'événement est démarré.

### Dashboard Joueur

Amélioration du tableau de bord joueur :

- Affichage détaillé des participations :
  - nom de l'événement ;
  - jeu concerné ;
  - statut de participation ;
  - date de début.

- Affichage conditionnel du bouton « Rejoindre la room ».
- Affichage des favoris et des scores enregistrés.

### Dashboard Administrateur

Réorganisation du tableau de bord administrateur :

- Mise en avant des statistiques globales :
  - utilisateurs ;
  - événements ;
  - jeux ;
  - participations ;
  - abonnés newsletter.

- Gestion des événements en attente de validation.
- Affichage des abonnés à la newsletter.
- Préparation des futures sections d'administration.

### Architecture métier

Finalisation du workflow principal des événements :

Organisateur :

- crée un événement ;
- valide les participations ;
- démarre l'événement.

Joueur :

- demande à participer ;
- est accepté ou refusé ;
- rejoint la room lorsque l'événement est démarré.

Room :

- affiche les informations de l'événement ;
- affiche les participants ;
- permet les échanges via le chat MongoDB.

### Bilan de la journée

Fonctionnalités finalisées :

- Intégration MongoDB.
- Chat événementiel.
- Room événementielle.
- Gestion du démarrage d'événement.
- Contrôle d'accès basé sur les rôles et les participations.
- Amélioration des dashboards Administrateur, Organisateur et Joueur.

### Prochaines étapes

- Gestion des scores.
- Résultats des tournois.
- Insciption / profil
- Intégration d'une API externe.
- Refonte graphique des dashboards avec Sass.
- Ajout d'améliorations UX (compte à rebours, statistiques avancées, etc.).

Scores
STATUS : V1 DEMO

- Entity Score créée
- Relations User / Evenement OK
- Classement prévu
- API jeux prévue dans une version future

### 15/06/2026

## Gestion du profil utilisateur

### Profil utilisateur

- Création du ProfileController.
- Création du formulaire de modification du profil.
- Mise à jour des informations utilisateur.
- Génération automatique d'un avatar via l'API DiceBear à partir du pseudo.
- Sauvegarde de l'avatar en base de données.
- Affichage de l'avatar dans le dashboard joueur.

### Changement de mot de passe

- Création du formulaire ChangePasswordType.
- Mise en place de la route de modification du mot de passe.
- Vérification de l'ancien mot de passe.
- Encodage sécurisé du nouveau mot de passe.
- Redirection vers le profil après modification.

---

### Intégration de l'API externe DiceBear.

Les avatars des utilisateurs sont générés dynamiquement à partir de leur pseudo.
L'application construit une URL vers l'API DiceBear et affiche l'image retournée dans la page profil.

Compétences mobilisées :

- Consommation d'une API externe
- Paramétrage dynamique d'une requête
- Utilisation de Twig
- Intégration de ressources externes

## Gestion des rôles

### Administration des utilisateurs

- Affichage de la liste des utilisateurs dans le dashboard administrateur.
- Promotion d'un utilisateur au rôle Organisateur.
- Retrait du rôle Organisateur.
- Vérification du bon fonctionnement des permissions.
- Mise à jour dynamique de l'affichage des actions administrateur.

---

## Dashboard Joueur

### Historique utilisateur

- Affichage des événements favoris.
- Affichage des participations.
- Affichage des scores.
- Affichage des événements proposés par l'utilisateur avec leur statut.

### Rejoindre un événement

- Affichage du bouton "Rejoindre la room" uniquement :
  - si la participation est acceptée ;
  - si l'événement a été démarré ;
  - si la date de début est atteinte.

### Désinscription

- Mise en place de la désinscription aux événements.
- Vérification des statuts de participation.

---

## Gestion des événements

### Événements organisateur

- Vérification du statut lors de la modification d'un événement.
- Retour automatique en "en_attente" après modification.
- Vérification de la conformité avec le cahier des charges.

### Images des événements

- Gestion de l'upload des images.
- Association des images aux événements.
- Affichage des images sur la page d'accueil et dans les listes d'événements.

---

## Refonte de l'accueil

### Organisation des templates

Création de la structure :

- home/header.html.twig
- home/presentation.html.twig
- home/challenges.html.twig
- home/stats.html.twig
- home/games_carousel.html.twig
- home/events.html.twig
- home/partners_newsletter.html.twig
- home/about.html.twig
- home/gallery.html.twig

### Accueil

- Réintégration du contenu de l'ancien projet.
- Réorganisation de la page selon la maquette Figma.
- Affichage des événements validés sur la page d'accueil.

---

## Vue globale des événements

### Liste publique

- Remplacement du CRUD Symfony généré automatiquement.
- Création d'une page publique d'affichage des événements.
- Affichage :
  - image ;
  - titre ;
  - nombre de joueurs ;
  - dates ;
  - organisateur.

### Filtrage des événements

#### Repository

- Création de la méthode findFiltered() dans EvenementRepository.

#### API JSON

- Création de la route :
  /evenement/filter

- Retour des données JSON :
  - id ;
  - titre ;
  - date ;
  - nombre de places ;
  - organisateur ;
  - image.

#### JavaScript

- Création du fichier :
  public/js/events-filter.js

- Utilisation de Fetch API.

- Mise à jour dynamique de la liste sans rechargement de page.

- Utilisation de createElement() et textContent() pour éviter l'utilisation de innerHTML.

- Respect des bonnes pratiques de sécurité (prévention XSS).

### Résultat

- Filtre asynchrone fonctionnel.
- Tri par date.
- Tri par nombre de joueurs.
- Tri par organisateur.

---

## État actuel du projet

### Fonctionnalités terminées

- Authentification
- Gestion des rôles
- Profil utilisateur
- Avatar DiceBear
- Changement de mot de passe
- Favoris
- Participations
- Scores
- Historique des événements
- Création d'événements
- Validation administrateur
- Gestion organisateur
- Démarrage des événements
- Chat MongoDB
- Room événement
- Page d'accueil
- Liste publique des événements
- API JSON
- Filtre AJAX obligatoire du cahier des charges

### Prochaine étape

- Audit final du cahier des charges.
- Vérification des derniers points manquants.
- Mise en place du Sass.
- Responsive.
- Finalisation de l'interface utilisateur.

## 18 et 19 /06/2026

### Audit

- Audit complet des rôles Joueur, Organisateur et Admin
- Correction des accès aux événements
- Vérification des modifications d'événements
- Mise en place de la validation des événements proposés
- Correction de l'accès aux rooms
- Sécurisation des participations et désinscriptions
- Amélioration du dashboard administrateur
- Tests du cycle complet :
  Création → Validation → Participation →
  Acceptation → Démarrage → Room → Classement

  Prochaine étape :

- Amélioration UX/UI des dashboards
- Réorganisation des sections Twig
- Refonte visuelle Sass
- Préparation des captures du dossier projet

## 22/06/2026

### UX/UI

- Mise en place du système Sass mobile-first
- Création de la navbar responsive
- Création du Hero Esportify
- Début de la refonte de la page d'accueil
- Création de la section Présentation
- Début de la section Événements à venir
- Mise en place des breakpoints Sass (tablet, desktop, large)

### Correctifs

- Correction du problème de viewport responsive
- Vérification du comportement mobile sur iPhone SE
- Réorganisation de la navigation avec "Mon espace"

### Prochaine étape

- Finaliser la page d'accueil
- Créer la section "Pourquoi Esportify ?"
- Ajouter les statistiques
- Limiter les événements affichés sur l'accueil

## 23/06/2026

### Home Page

- Création de la section "L'esprit compétition"
- Refonte du contenu marketing de la page d'accueil
- Ajout des statistiques de plateforme
- Création du carrousel des jeux disponibles
- Liaison des jeux de la base de données à la Home
- Ajout des logos de jeux dans la base

### Front-End

- Mise en place du composant Carousel en JavaScript ES6
- Utilisation d'une classe Carousel avec constructeur
- Gestion du scroll horizontal par boutons
- Débogage et correction de l'initialisation du composant

### Responsive

- Validation du comportement mobile-first
- Vérification du fonctionnement du carousel sur mobile

### Prochaine étape

- Section Événements
- Newsletter
- À propos
- Galerie
- Footer

## 24/06/2026

- Finalisation complète de la page d'accueil
- Refonte responsive mobile-first
- Création du carousel jeux en JavaScript ES6
- Ajout des sections About et Gallery
- Création du footer
- Création des pages légales
- Corrections desktop et responsive

## 29/06/2026

### Module Événements

- Refactoring de la page événements
- Séparation des événements en trois sections : à venir, en cours et terminés
- Création d’un composant Twig `_card.html.twig`
- Mise en place du tri AJAX des événements à venir
- Création d’une popup de détails en JavaScript orienté objet
- Ajout de la route JSON `/evenement/{id}/details`
- Ajout du bouton Participer
- Ajout du système de favoris en AJAX
- Création d’un `FavoriteManager`
- Mise en place d’un `main.js` pour centraliser les imports JavaScript

### Front-End

- Amélioration du Sass de la page événements
- Création du Sass de la modal
- Utilisation du BEM pour les classes de la popup
- Correction du responsive mobile-first des boutons de la modal

### Correctifs

- Correction d’une erreur de portée JavaScript avec `response`
- Correction des imports JavaScript en mode module
- Correction des problèmes de cache et permissions Doctrine ODM MongoDB
- Correction d’une erreur de nommage sur les actions de la modal

### Prochaine étape

- Créer le dashboard joueur
- Afficher les événements favoris
- Afficher les participations du joueur
- Préparer les statistiques utilisateur

# 30/06/2026

## Objectif de la journée

Poursuivre le développement d'Esportify en finalisant les tableaux de bord et en améliorant l'architecture du projet.

### Dashboard Organisateur

- Refonte complète de l'interface.
- Ajout d'un tableau de bord moderne.
- Affichage des statistiques :

- nombre d'événements ;
- participants inscrits ;
- taux de remplissage.
- Gestion des événements de l'organisateur.
- Liste des participants inscrits.
- Ajout des actions rapides.
- Vérification des accès et des droits.

### Dashboard Joueur

- Refactorisation du Twig.
- Adoption de la nouvelle structure commune des dashboards.
- Préparation à une architecture réutilisable.

### Dashboard Administrateur

- Refonte de l'interface avec la même architecture que les autres dashboards.
- Ajout des cartes de statistiques.
- Réorganisation des sections (événements, utilisateurs, contacts, newsletters).
- Uniformisation de l'expérience utilisateur.

### Refactorisation Front-End

- Création d'un composant Sass commun `_dashboard.scss`.
- Mutualisation des styles entre les dashboards Joueur, Organisateur et Administrateur.
- Réduction de la duplication du code.
- Préparation d'une architecture de composants réutilisables.

### Sécurité et gestion des rôles

- Vérification de la hiérarchie des rôles.
- Contrôle d'accès aux rooms :

- un joueur doit être accepté ;
- un organisateur accède uniquement aux rooms de ses propres événements ;
- un administrateur accède à toutes les rooms.

### Chat MongoDB

- Début de la mise en place de la modération.
- Ajout des champs permettant le "soft delete" des messages.
- Conception de la future route de suppression des messages.
- Choix de conserver les messages en base afin d'assurer une meilleure traçabilité.

## Architecture

Nouvelle méthode de travail adoptée :

1. Analyse du besoin.
2. Schéma de fonctionnement.
3. Développement.
4. Tests et validation.

Cette approche sera utilisée pour les prochaines fonctionnalités afin de mieux comprendre la logique métier et gagner en autonomie.

## Prochaine étape

- Finaliser la modération du chat MongoDB.
- Effectuer une recette complète de l'application (Joueur, Organisateur, Administrateur, Room, Favoris, Classements, Profil).
- Corriger les derniers bugs avant l'envoi du projet au formateur.

J'ai choisi MongoDB pour le chat, car les messages sont des données non relationnelles qui peuvent être très nombreuses. Une base documentaire est adaptée à ce type de contenu et évite de surcharger la base SQL qui gère les utilisateurs, les événements et les participations

# 02/07/2026

Objectif :
Améliorer l'interface utilisateur et harmoniser les formulaires Symfony.

Travaux réalisés :

- Refonte de la page de connexion.
- Refonte de la page d'inscription.
- Création d'un composant de formulaire réutilisable.
- Refonte des formulaires des événements.
- Refonte du formulaire de profil.
- Refonte du formulaire de changement de mot de passe.
- Refonte des pages de création, modification et détail d'un événement.
- Amélioration du formulaire de suppression.
- Création du style de la page profil.
- Début du style de la page détail d'un événement.
- Réorganisation de l'architecture SCSS (components/pages).
- Mise à jour des notes du dossier projet.
- Réflexion sur la réutilisation des modales et décision de conserver EventModal telle quelle pour l'ECF afin de privilégier la stabilité.

Compétences travaillées :

- Symfony Forms
- Twig
- Sass (SCSS)
- Architecture de composants
- UX / UI
- Organisation d'un projet Symfony

Prochaine étape :

- Vérifier le rendu de tous les formulaires.
- Finaliser le style de la page détail des événements.
- Poursuivre l'harmonisation graphique de l'application.

# 03/07/2026

## Validation de l'application

Avant la livraison de l'application, une phase de recette fonctionnelle a été réalisée.

Points vérifiés :

- Tests des différents rôles (visiteur, joueur, organisateur, administrateur)
- Vérification des liens de navigation
- Vérification des droits d'accès
- Vérification des formulaires et des validations
- Vérification du responsive (mobile, tablette, desktop)

Les anomalies détectées sont corrigées au fur et à mesure afin de garantir une application stable et cohérente.

# Check-up final Esportify

## 1. Tests par rôle

### Visiteur non connecté

- [ok] Accueil visible
- [ok] Liste des événements visibles
- [ok] Détail d’un événement visible si événement validé
- [ok] Connexion accessible
- [ok] Inscription accessible
- [ok] Contact accessible
- [ok] Impossible de participer
- [ok] Impossible d’accéder aux dashboards

### Joueur

- [ok] Connexion OK
- [ok] Dashboard joueur accessible
- [ok] Profil accessible
- [ok] Modification profil ok
- [ ] Changement mot de passe OK
- [ok] Voir événements
- [ ] Participer à un événement à venir
- [ ] Impossible de participer à un événement terminé
- [ ] Ajouter / retirer favori
- [ ] Accès au chat d’un événement où il participe
- [ok] Déconnexion OK

### Organisateur

- [ ] Connexion OK
- [ ] Dashboard organisateur accessible
- [ ] Proposer un événement
- [ ] Modifier ses propres événements
- [ ] Impossible de modifier un événement d’un autre organisateur
- [ ] Voir participants
- [ ] Démarrer un événement si les conditions sont remplies
- [ ] Accès au chat de ses événements
- [ ] Déconnexion OK

### Admin

- [ ] Connexion OK
- [ ] Dashboard admin accessible
- [ ] Voir tous les utilisateurs
- [ ] Voir tous les événements
- [ ] Valider / refuser un événement
- [ ] Modifier un événement
- [ ] Supprimer un événement
- [ ] Accès aux profils/pages admin
- [ ] Déconnexion OK

---

## 2. Liens à vérifier

- [ ] Logo → accueil
- [ ] Accueil
- [ ] Événements
- [ ] Contact
- [ ] Connexion
- [ ] Inscription
- [ ] Profil
- [ ] Changer mot de passe
- [ ] Dashboard joueur
- [ ] Dashboard organisateur
- [ ] Dashboard admin
- [ ] Retour liste événements
- [ ] Classement événement
- [ ] Participer
- [ ] Favori
- [ ] Modifier événement
- [ ] Supprimer événement
- [ ] Déconnexion

---

## 3. Droits d’accès

- [ ] Visiteur bloqué sur `/joueur`
- [ ] Visiteur bloqué sur `/organisateur`
- [ ] Visiteur bloqué sur `/admin`
- [ ] Joueur bloqué sur `/admin`
- [ ] Joueur bloqué sur les pages organisateur non autorisées
- [ ] Organisateur bloqué sur `/admin`
- [ ] Un organisateur ne peut pas modifier l’événement d’un autre
- [ ] Un événement non validé n’est pas visible publiquement
- [ ] Un événement terminé ne permet plus la participation
- [ ] Un événement commencé ne peut plus être modifié sauf admin

---

## 4. Formulaires

### Auth

- [ ] Connexion avec bons identifiants
- [ ] Connexion avec mauvais identifiants
- [ ] Inscription valide
- [ ] Inscription avec email déjà utilisé
- [ ] Champs obligatoires
- [ ] Messages d’erreur visibles

### Profil

- [ ] Modifier pseudo
- [ ] Modifier email
- [ ] Modifier avatar
- [ ] Changer mot de passe
- [ ] Message succès affiché

### Événements

- [ ] Créer événement complet
- [ ] Créer événement sans image
- [ ] Créer événement avec image
- [ ] Modifier événement
- [ ] Supprimer événement
- [ ] Dates invalides si test prévu
- [ ] Upload image mauvais format refusé

### Contact

- [ ] Envoi formulaire valide
- [ ] Champs obligatoires
- [ ] Message succès

---

## 5. Responsive

Tester en mode navigateur responsive :

### Mobile 375px

- [ ] Accueil
- [ ] Menu navigation
- [ ] Liste événements
- [ ] Cards
- [ ] Modale événement
- [ ] Login
- [ ] Register
- [ ] Contact
- [ ] Profil
- [ ] Dashboard

### Tablette 768px

- [ ] Grilles correctes
- [ ] Formulaires lisibles
- [ ] Boutons bien placés

### Desktop 1024px+

- [ ] Mise en page équilibrée
- [ ] Espacements cohérents
- [ ] Pas de bouton perdu
- [ ] Pas de texte qui déborde

A Faire:

Restreindre le chat aux participants acceptés
Bloquer les messages vides
Limiter la longueur des messages
Fermer le chat après dateEnd
Bloquer le chat avant startedAt
Dossier Projet
Dossier Professionnel
