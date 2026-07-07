# Déploiement Esportify 3.0

## Préparation

- [ ] Vérifier que tous les tests sont validés
- [ ] Commit final sur la branche `dev`
- [ ] Merge vers `main`
- [ ] Push GitHub
- [ ] Générer le fichier SQL
- [ ] Vérifier le README

---

## Configuration de production

- [ ] APP_ENV=prod
- [ ] APP_DEBUG=false
- [ ] Configurer DATABASE_URL
- [ ] Configurer MongoDB (si disponible)
- [ ] Vérifier MAILER_DSN

---

## Déploiement

- [ ] Créer la base de données MySQL
- [ ] Importer le fichier SQL
- [ ] Déployer les fichiers
- [ ] Installer les dépendances Composer
- [ ] Vider le cache Symfony
- [ ] Vérifier les permissions

---

## Vérifications

- [ ] Accueil
- [ ] Connexion
- [ ] Inscription
- [ ] Dashboards
- [ ] Création d'événement
- [ ] Upload d'images
- [ ] Chat
- [ ] Emails
- [ ] SSL
- [ ] Logs
- [ ] Responsive

---

## Commandes utiles

bash
git diff

git status

git add .

git commit -m "Déploiement Esportify"

git push origin dev
