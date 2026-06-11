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

À faire :
□ Restreindre l’accès au chat aux participants acceptés

□ Bloquer l’accès au chat avant le démarrage de l’événement

□ Ajouter un statut "started" ou "isStarted" à l’événement

□ Afficher le bouton Rejoindre uniquement lorsque l’événement est accessible

□ Repasser automatiquement un événement à "en_attente" lors d'une modification.

□ Empêcher la modification d'un événement déjà commencé.

□ Vérifier que dateFin > dateDébut.

□ Ajouter la gestion des images des événements.

□ Permettre l'inscription des joueurs aux événements (Participation).

□ Vérifier que l'événement n'est pas complet.

□ Vérifier que l'événement est validé.
