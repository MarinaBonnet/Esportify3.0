# Esportify 3.0

## Présentation

Esportify 3.0 est une plateforme web dédiée à l'organisation de compétitions e-sport.

L'application permet :

- Gestion des utilisateurs
- Gestion des rôles
- Création de tournois
- Gestion des participants
- Tableau de bord administrateur
- Chat en temps réel
- Authentification sécurisée

## Technologies utilisées

### Backend

- PHP 8.3
- Symfony 7
- Doctrine ORM

### Base de données

- MySQL 8
- MongoDB

### Frontend

- Twig
- Sass
- JavaScript

### Infrastructure

- Docker
- Nginx
- Git / GitHub

---

## Installation

### Cloner le projet

git clone URL_DU_REPO

### Lancer Docker

docker compose up -d

### Installer les dépendances

docker compose exec php composer install

### Créer la base

docker compose exec php php bin/console doctrine:database:create

### Exécuter les migrations

docker compose exec php php bin/console doctrine:migrations:migrate

### Charger les fixtures

docker compose exec php php bin/console doctrine:fixtures:load

---

## Comptes de test

### Administrateur

Email : [admin@esportify.fr](mailto:admin@esportify.fr)

### Organisateur

Email : [organisateur@esportify.fr](mailto:organisateur@esportify.fr)

### Joueur

Email : [joueur@esportify.fr](mailto:joueur@esportify.fr)

---

## Auteur

Marina Bonnet
Développeuse Web Full Stack
