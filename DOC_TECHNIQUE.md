# Documentation Technique - Esportify 3.0

## Architecture générale

Esportify 3.0 est une application web développée avec Symfony 7 selon le modèle d'architecture MVC (Model - View - Controller).

L'application est exécutée dans un environnement Docker composé de plusieurs conteneurs permettant de séparer les différents services (PHP, Nginx, MySQL et MongoDB).

Les données relationnelles sont gérées avec Doctrine ORM et MySQL, tandis que les messages du chat sont stockés dans MongoDB grâce à Doctrine ODM.

## Services Docker

### PHP

- Exécution de Symfony
- Doctrine ORM
- Doctrine ODM
- Composer

### Nginx

- Serveur HTTP
- Distribution des fichiers publics
- Communication avec PHP-FPM

### MySQL

Stockage des données relationnelles :

- utilisateurs
- événements
- jeux
- participations
- images
- rôles

### MongoDB

Stockage documentaire :

- salons de discussion
- messages

## Gestion des utilisateurs

Trois rôles principaux :

### Administrateur

- gestion des utilisateurs
- gestion des événements
- accès au tableau de bord
- modération

### Organisateur

- création d'événements
- modification de ses événements
- gestion des participants

### Joueur

- inscription aux événements
- participation au chat
- gestion de son profil

## Authentification

Elle utilise :

- User
- UserRepository
- LoginFormAuthenticator
- SecurityController
- PasswordHasher
- Sessions Symfony

## Bases de données

### MySQL

Doctrine ORM est utilisé pour gérer les entités relationnelles :

- User
- Role
- Evenement
- Jeu
- Participation
- Image

### MongoDB

Doctrine ODM est utilisé pour gérer les documents :

- Message

src/

Controller/

Entity/

Document/

Repository/

Form/

Security/

Service/

assets/

templates/

## Sécurité

- Authentification Symfony
- Hashage des mots de passe
- Gestion des rôles
- Contrôle d'accès avec #[IsGranted]
- Protection CSRF

## Outils

- Symfony
- PHP
- Docker
- Git
- GitHub
- MySQL
- MongoDB
- Nginx
- Composer
- Twig

## Déploiement

Le projet est développé dans un environnement Docker.

Les commandes principales sont :

- docker compose up -d
- composer install
- doctrine:migrations:migrate
- doctrine:mongodb:schema:create

## Gestion de versions

Git Flow :

- main : production
- dev : développement

## Objectifs pédagogiques DWWM

Compétences démontrées :

- Développer une application web
- Concevoir une base relationnelle
- Utiliser une base NoSQL
- Sécuriser une application
- Utiliser Docker
- Utiliser Git
- Déployer une application
