# Documentation Technique - Esportify 3.0

## Architecture générale

Esportify 3.0 est une application web développée avec Symfony.

L'application repose sur une architecture conteneurisée Docker permettant de séparer les différents services.

## Services Docker

### PHP

Responsable de l'exécution de l'application Symfony.

### Nginx

Serveur web.

### MySQL

Base de données relationnelle utilisée pour :

- utilisateurs
- rôles
- équipes
- tournois
- inscriptions

### MongoDB

Base NoSQL utilisée pour :

- conversations
- messages du chat
- historique des échanges

## Gestion des utilisateurs

Trois rôles principaux :

### Administrateur

- gestion complète
- modération
- gestion utilisateurs

### Organisateur

- création tournois
- gestion inscriptions

### Joueur

- participation aux compétitions
- gestion profil

## Authentification

L'authentification repose sur Symfony Security.

Composants utilisés :

- User
- LoginFormAuthenticator
- SecurityController
- Route /login
- Route /logout

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
