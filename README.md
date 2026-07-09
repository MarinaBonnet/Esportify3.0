# Esportify 3.0

Plateforme web de gestion de compétitions e-sport développée avec **Symfony 7** dans le cadre du **Titre Professionnel Développeur Web et Web Mobile (DWWM)**.

---

# Présentation

Esportify 3.0 est une application web permettant d'organiser et de gérer des compétitions e-sport.

L'application propose plusieurs profils utilisateurs :

- **Visiteur** : consultation des événements et création d'un compte.
- **Joueur** : participation aux événements, gestion des favoris, accès au système de discussion et gestion de son profil.
- **Organisateur** : création et gestion de ses événements.
- **Administrateur** : gestion complète de la plateforme, validation des événements et administration des utilisateurs.

---

# Fonctionnalités

- Authentification sécurisée
- Gestion des rôles (Joueur, Organisateur, Administrateur)
- Gestion des profils utilisateurs
- Création, modification et suppression d'événements
- Validation des événements par un administrateur
- Gestion des participations
- Gestion des favoris
- Système de discussion par événement (MongoDB)
- Tableau de bord personnalisé selon le rôle
- Upload d'images
- Interface responsive

---

# Technologies utilisées

## Backend

- PHP 8.3
- Symfony 7
- Doctrine ORM
- Doctrine ODM

## Bases de données

- MySQL 8
- MongoDB

## Front-end

- Twig
- Sass (SCSS)
- JavaScript

## Environnement

- Docker
- Nginx
- Composer
- Git
- GitHub

---

# Prérequis

Avant de commencer, assurez-vous d'avoir installé :

- Docker Desktop
- Docker Compose
- Git

---

# Installation

## 1. Cloner le dépôt

```bash
git clone https://github.com/MarinaBonnet/Esportify3.0.git
cd Esportify3.0
```

---

## 2. Lancer les conteneurs Docker

```bash
docker compose up -d --build
```

---

## 3. Installer les dépendances

```bash
docker compose exec php composer install
```

---

## 4. Configurer l'environnement

Créer un fichier `.env.local` si nécessaire et renseigner les paramètres de connexion à MySQL et MongoDB.

---

## 5. Créer la base de données

```bash
docker compose exec php php bin/console doctrine:database:create
```

---

## 6. Exécuter les migrations

```bash
docker compose exec php php bin/console doctrine:migrations:migrate
```

---

## 7. Créer les collections MongoDB

```bash
docker compose exec php php bin/console doctrine:mongodb:schema:create
```

---

## 8. Importer les données de démonstration

Le projet est fourni avec un fichier SQL situé à la racine du dépot

```text
esportify.sql
```

Ce fichier contient :

- la structure de la base de données ;
- les données de démonstration nécessaires au fonctionnement de l'application.

Importer ce fichier dans la base MySQL après sa création.

Exemple avec Docker :

```bash
docker compose exec -T mysql mysql -u root -pVotreMotDePasse NomDeLaBase < esportify.sql
```

Vous pouvez également utiliser PhpMyAdmin ou un autre outil de gestion de bases de données.

---

## 9. Vider le cache

```bash
docker compose exec php php bin/console cache:clear
```

---

# Accès à l'application

Une fois les conteneurs démarrés :

```
http://localhost
```

ou

```
http://localhost:8000
```

(selon votre configuration Docker)

---

# Comptes de démonstration

## Administrateur

**Email**

```
admin@esportify.fr
```

**Mot de passe**

```
Admin123!
```

---

## Organisateur

**Email**

```
orga@esportify.fr
```

**Mot de passe**

```
Orga123!
```

---

## Joueur

**Email**

```
joueur33@esportify.fr
```

**Mot de passe**

```
Joueur1234!
```

---

# Structure du projet

```
src/
├── Controller/
├── Document/
├── Entity/
├── Form/
├── Repository/
├── Security/
├── Service/

assets/
config/
public/
templates/
```

---

# Déploiement

L'application est également disponible en ligne :

**https://esportify.codecraft-web.fr**

---

# Auteur

**Marina Bonnet**

Projet réalisé dans le cadre du **Titre Professionnel Développeur Web et Web Mobile (DWWM)**.

Le développement a été réalisé en suivant les bonnes pratiques Git avec une branche principale (`main`), une branche de développement (`dev`) ainsi que des branches dédiées aux différentes fonctionnalités avant leur fusion.
