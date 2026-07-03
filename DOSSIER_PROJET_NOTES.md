# Notes pour le Dossier Projet

## Présentation du projet

Esportify 3.0 est une plateforme web de gestion de compétitions e-sport développée dans le cadre de ma préparation au Titre Professionnel Développeur Web et Web Mobile.

L'application permet à des joueurs, des organisateurs et des administrateurs d'interagir autour d'événements e-sport grâce à un système d'authentification, de gestion des compétitions, d'inscriptions, de tableaux de bord personnalisés et d'un système de messagerie utilisant MongoDB.

## Pourquoi ce projet ?

Objectifs :

- Mettre en pratique Symfony.
- Utiliser Docker pour disposer d'un environnement de développement reproductible.
- Combiner une base de données relationnelle (MySQL) et une base NoSQL (MongoDB).
- Concevoir une architecture professionnelle basée sur le modèle MVC.
- Développer une application proche d'un cas réel pouvant évoluer dans le temps.

## Public visé

La plateforme est destinée :

- aux joueurs souhaitant participer à des compétitions ;
- aux organisateurs créant des événements ;
- aux administrateurs assurant la gestion globale de la plateforme.

## Architecture générale

L'application est construite selon l'architecture MVC de Symfony.

- Controllers : gestion des requêtes HTTP
- Entities : données relationnelles (MySQL)
- Documents MongoDB : stockage des messages du tchat grace a doctrine ODM
- Repositories : accès aux données
- Twig : affichage
- Services Symfony : centralisation de certaines règles métier afin de conserver des contrôleurs légers.

## Fonctionnalités

### Profils utilisateurs

- Profil joueur
- Profil organisateur
- Profil administrateur

### Authentification

- Inscription
- Connexion
- Déconnexion
- Gestion des rôles

### Gestion des événements

- Création
- Modification
- Suppression
- Consultation

### Participations

- Inscription
- Désinscription

### Chat

- Room privée
- Messages MongoDB

### Jeux

- Consultation des jeux
- Association d'un jeu à un événement

### Médias

- Upload d'images
- Gestion des illustrations des événements

### Dashboard

- Joueur
- Organisateur
- Administrateur

### Avatar

- Génération automatique DiceBear

### Administration

- Gestion des utilisateurs
- Gestion des événements

## Choix techniques

### Pourquoi Symfony ?

- Framework MVC moderne
- Sécurité intégrée
- Doctrine ORM
- Architecture maintenable

### Pourquoi Docker ?

- Reproductibilité de l'environnement
- Isolation des services
- Facilite le déploiement

### Pourquoi MySQL ?

- Gestion des données relationnelles
- Intégrité référentielle

### Pourquoi MongoDB ?

Le chat génère de nombreux messages indépendants des données relationnelles. MongoDB est particulièrement adapté à ce type de stockage documentaire, offrant une grande souplesse et de bonnes performances.

- Gestion performante des messages
- Données souples
- Cas d'usage adapté au chat

## Difficultés rencontrées

### Authentification Symfony

### Doctrine ORM

Problème :

Le LoginFormAuthenticator ne redirigeait pas correctement.

Solution :

Analyse des routes Symfony et correction de la configuration Security.

---

Problème :

Erreur Doctrine lors des migrations.

Solution :

Vérification des relations entre entités puis régénération de la migration.

## Captures à prévoir

- Accueil
- Connexion
- Profil joueur
- Profil organisateur
- Profil administrateur
- Salle de discussion
- Dashboard administrateur
- Gestion utilisateurs
- Gestion tournois
- Chat MongoDB
- Docker Desktop
- GitHub
- Base MySQL
- Collections MongoDB

## Compétences DWWM couvertes

### Architecture

- MVC
- Doctrine ORM
- Doctrine ODM

### Sécurité

- Authentification Symfony
- Gestion des rôles
- Contrôle d'accès

### Front-end

- HTML
- CSS
- Sass
- JavaScript
- Twig

### Back-end

- PHP
- Symfony
- Doctrine

### Bases de données

- MySQL
- MongoDB

### Outils

- Git
- GitHub
- Docker
- Nginx

## Evolutions possibles

✓ Gestion des équipes e-sport
✓ Notifications utilisateurs
✓ Classements avancés
✓ Statistiques détaillées
✓ Chat temps réel WebSocket
✓ Application mobile
✓ Système de récompenses et badges

Bien que la première version d'Esportify réponde aux besoins du cahier des charges, plusieurs évolutions pourraient être envisagées afin d'améliorer l'expérience utilisateur et de professionnaliser davantage la plateforme.

### Gestion des équipes e-sport

Actuellement, les inscriptions aux événements sont réalisées individuellement par les joueurs.

Une évolution possible serait la mise en place d'un système d'équipes permettant :

- la création d'équipes par les utilisateurs ;
- la gestion d'un capitaine d'équipe ;
- l'invitation et la validation des membres ;
- l'inscription d'équipes complètes à un événement ;
- l'affichage des compositions d'équipe lors des compétitions.

Cette fonctionnalité serait particulièrement adaptée aux jeux compétitifs en équipe tels que :

- Valorant ;
- League of Legends ;
- Counter-Strike 2 ;
- Rocket League.

### Améliorations complémentaires

- Mise en place d'un système de notifications.
- Gestion avancée des tournois et des classements.
- Statistiques détaillées des joueurs.
- Système de badges et de récompenses.
- Application mobile dédiée.
- Intégration d'un chat temps réel via WebSocket.
- Intégration d’API externes pour récupérer automatiquement les scores des joueurs selon les jeux.

Equipe

- id
- nom
- logo
- capitaine

User

- appartient à une équipe

Evenement

- peut accueillir des équipes

Créer équipe
Inviter joueurs
Accepter invitation
Inscrire équipe
Afficher roster
Gérer capitaine

## Ce que ce projet m'a appris

Le développement d'Esportify m'a permis d'acquérir et de consolider de nombreuses compétences techniques :

- développement avec Symfony ;
- architecture MVC ;
- gestion des bases de données relationnelles avec MySQL ;
- utilisation de MongoDB via Doctrine ODM ;
- mise en œuvre de Docker ;
- utilisation de Git et GitHub ;
- sécurisation d'une application Symfony ;
- organisation d'un projet web professionnel.
