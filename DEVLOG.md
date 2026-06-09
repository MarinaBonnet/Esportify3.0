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

Tests réalisés :

- Vérification de la création d'une participation.
- Vérification de l'enregistrement en base de données.
- Mise en place d'un contrôle empêchant les inscriptions multiples à un même événement.

Résultat :

Le système d'inscription des joueurs aux événements est opérationnel.

À faire :

□ Repasser automatiquement un événement à "en_attente" lors d'une modification.

□ Empêcher la modification d'un événement déjà commencé.

□ Vérifier que dateFin > dateDébut.

□ Ajouter la gestion des images des événements.

□ Permettre l'inscription des joueurs aux événements (Participation).

□ Empêcher un joueur refusé de se réinscrire au même événement.

□ Empêcher un joueur refusé de se réinscrire.

□ Vérifier que l'événement n'est pas complet.

□ Vérifier que l'événement est validé.
