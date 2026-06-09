# Notes pour le Dossier Projet

## Présentation du projet

Esportify 3.0 est une plateforme de gestion de compétitions e-sport permettant à des joueurs et organisateurs d'interagir autour de tournois en ligne.

## Pourquoi ce projet ?

Objectifs :

- Mettre en pratique Symfony
- Utiliser Docker
- Travailler avec SQL et NoSQL
- Mettre en place une architecture professionnelle

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

- Gestion performante des messages
- Données souples
- Cas d'usage adapté au chat

## Difficultés rencontrées

### Exemple

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
- Dashboard administrateur
- Gestion utilisateurs
- Gestion tournois
- Chat MongoDB
- Docker Desktop
- GitHub
- Base MySQL
- Collections MongoDB

## Compétences DWWM couvertes

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

## Perspectives d'évolution

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
