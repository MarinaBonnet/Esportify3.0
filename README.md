# Esportify 3.0

## Présentation

Esportify 3.0 est une plateforme web dédiée à l'organisation de compétitions e-sport.

L'application permet aux joueurs de participer à des événements, aux organisateurs de créer et gérer leurs compétitions et aux administrateurs de modérer l'ensemble de la plateforme.

---

# Fonctionnalités

- Authentification sécurisée
- Gestion des rôles (Joueur, Organisateur, Administrateur)
- Gestion des profils utilisateurs
- Création et gestion d'événements e-sport
- Validation des événements par un administrateur
- Gestion des participants
- Ajout et suppression des favoris
- Chat en temps réel par événement (MongoDB)
- Classement des joueurs
- Tableau de bord personnalisé selon le rôle
- Upload d'images
- Interface responsive

---

# Technologies utilisées

## Backend

- PHP 8.3
- Symfony 7
- Doctrine ORM

## Base de données

- MySQL 8
- MongoDB

## Frontend

- Twig
- Sass (SCSS)
- JavaScript

## Infrastructure

- Docker
- Nginx
- Git
- GitHub

---

# Prérequis

- Docker Desktop
- Docker Compose
- Git

---

# Installation

## Cloner le projet

bash
git clone URL_DU_DEPOT
cd Esportify

## Lancer les conteneurs

bash
docker compose up -d

## Installer les dépendances

bash
docker compose exec php composer install

## Créer la base de données

bash
docker compose exec php php bin/console doctrine:database:create

## Exécuter les migrations

bash
docker compose exec php php bin/console doctrine:migrations:migrate

## Charger les données de démonstration

bash
docker compose exec php php bin/console doctrine:fixtures:load

---

# Accès à l'application

Une fois les conteneurs démarrés :

http://localhost

---

# Comptes de démonstration

## Administrateur

Email : admin@esportify.fr

Mot de passe : Admin123!

---

## Organisateur

Email : orga@esportify.fr

Mot de passe : Orga123!

---

## Joueur

Email : joueur33@esportify.fr

Mot de passe : Joueur1234!

---

# Arborescence du projet

- Symfony 7
- MySQL
- MongoDB
- Docker
- Nginx
- Twig
- Sass
- JavaScript

---

# Auteur

Marina Bonnet

Projet réalisé dans le cadre du Titre Professionnel **Développeur Web et Web Mobile (DWWM)**.

Projet développé dans le respect des bonnes pratiques Git (branches `main`, `dev` et branches de fonctionnalités).
