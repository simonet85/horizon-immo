# 🚀 GUIDE DE DÉPLOIEMENT AUTOMATIQUE GIT : LARAGON → GITHUB → LWS

## 📋 Vue d'ensemble du workflow

```
┌─────────────┐         ┌─────────────┐         ┌─────────────┐
│   LARAGON   │  push   │   GITHUB    │  pull   │     LWS     │
│   (LOCAL)   │ ──────> │  (REMOTE)   │ ──────> │ (PRODUCTION)│
│  Windows    │         │   Cloud     │         │   Serveur   │
└─────────────┘         └─────────────┘         └─────────────┘
      DEV                    VERSIONING               PROD
```

### Principe de fonctionnement

1. **Développement local (Laragon)** : Tu codes sur Windows avec Laragon
2. **Versioning (GitHub)** : Tu push tes modifications sur GitHub
3. **Déploiement (LWS)** : Tu pull les modifications sur le serveur LWS

---

## 📦 1. Configuration de l'environnement local (Laragon)

### 1.1 Vérifier Git sur Laragon

```bash
# Ouvre le terminal Laragon (Laragon → Menu → Terminal)
git --version
```

Si Git n'est pas installé :
- Télécharge [Git for Windows](https://git-scm.com/download/win)
- Installe-le et redémarre Laragon

### 1.2 Configuration Git globale

```bash
# Configure ton identité Git (utilisée pour tous tes commits)
git config --global user.name "Ton Nom"
git config --global user.email "ton-email@example.com"

# Vérifie la configuration
git config --list
```

### 1.3 Vérifier le dépôt Git actuel

```bash
# Dans le terminal Laragon, va dans ton projet
cd C:\laragon\www\HorizonImmo

# Vérifie le statut Git
git status

# Vérifie les remotes configurés
git remote -v
```

**Résultat attendu** :
```
origin  https://github.com/simonet85/horizon-immo.git (fetch)
origin  https://github.com/simonet85/horizon-immo.git (push)
```

### 1.4 Configuration du fichier `.gitignore`

Assure-toi que ton `.gitignore` contient bien :

```gitignore
# Laravel
/node_modules
/public/hot
/public/storage
/storage/*.key
/vendor
.env
.env.backup
.env.production
.phpunit.result.cache
Homestead.json
Homestead.yaml
auth.json
npm-debug.log
yarn-error.log
/.fleet
/.idea
/.vscode

# Fichiers système
.DS_Store
Thumbs.db

# Fichiers temporaires
*.log
*.tmp
*.bak
*.swp
*~

# Build
/public/build
/bootstrap/cache/*

# Tests
/coverage
/.phpunit.cache
```

⚠️ **Important** : Le fichier `.env` **NE DOIT JAMAIS** être commité !

---

## 🔐 2. Configuration de GitHub

### 2.1 Créer un Personal Access Token (PAT)

GitHub n'accepte plus les mots de passe depuis août 2021. Tu dois créer un token :

1. Va sur [github.com/settings/tokens](https://github.com/settings/tokens)
2. Clique sur **"Generate new token"** → **"Generate new token (classic)"**
3. Donne un nom au token : `HorizonImmo-Laragon-LWS`
4. Coche les permissions suivantes :
   - ✅ `repo` (accès complet au dépôt)
   - ✅ `workflow` (si tu utilises GitHub Actions)
5. Clique sur **"Generate token"**
6. **⚠️ COPIE LE TOKEN IMMÉDIATEMENT** (il ne sera plus visible après)

**Exemple de token** : `ghp_xxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxxx`

### 2.2 Configurer l'authentification HTTPS

```bash
# Méthode 1 : Stockage du token dans Git Credential Manager
git config --global credential.helper wincred

# Méthode 2 : Ajouter le token dans l'URL remote (moins sécurisé)
git remote set-url origin https://ghp_TON_TOKEN@github.com/simonet85/horizon-immo.git
```

⚠️ **Méthode recommandée** : Utilise Git Credential Manager (Méthode 1). La première fois que tu push, Windows te demandera tes identifiants :
- **Username** : Ton nom d'utilisateur GitHub
- **Password** : Colle ton Personal Access Token

### 2.3 Créer une branche de production (optionnel mais recommandé)

```bash
# Crée une branche spécifique pour la production
git checkout -b production

# Push la branche production sur GitHub
git push origin production

# Retourne sur la branche main pour le développement
git checkout main
```

**Avantage** : Tu peux tester sur `main` et ne déployer que ce qui est stable sur `production`.

---

## 🌐 3. Configuration du serveur LWS

### 3.1 Vérifier l'accès SSH sur LWS

LWS propose un accès SSH sur certains hébergements. Vérifie dans ton panneau LWS :

1. Connecte-toi à [panel.lws.fr](https://panel.lws.fr)
2. Va dans **Hébergement web → SSH/Shell Access**
3. Si disponible, active l'accès SSH

**Identifiants SSH** :
- **Hôte** : `ssh.cluster0XX.lws.fr` (ou ton domaine)
- **Port** : `22`
- **Utilisateur** : Ton identifiant LWS (ex: `zbinv2677815`)
- **Mot de passe** : Ton mot de passe LWS (ou clé SSH)

### 3.2 Configurer SSH depuis Windows

#### Option A : Utiliser PuTTY (Windows)

1. Télécharge [PuTTY](https://www.putty.org/)
2. Lance PuTTY
3. Entre les paramètres :
   - **Host Name** : `ssh.cluster0XX.lws.fr`
   - **Port** : `22`
   - **Connection Type** : SSH
4. Clique sur **Open** et entre tes identifiants

#### Option B : Utiliser WSL/Git Bash

```bash
# Via Git Bash (livré avec Git for Windows)
ssh zbinv2677815@ssh.cluster0XX.lws.fr
```

### 3.3 Installer/Vérifier Git sur LWS

Une fois connecté en SSH :

```bash
# Vérifie que Git est installé
git --version
```

Si Git n'est pas installé (rare), demande au support LWS de l'installer.

### 3.4 Configurer Git sur LWS

```bash
# Configure ton identité Git sur le serveur
git config --global user.name "Ton Nom"
git config --global user.email "ton-email@example.com"

# Configure le stockage des credentials
git config --global credential.helper store
```

### 3.5 Cloner le dépôt GitHub sur LWS

```bash
# Va dans le dossier parent de laravel-app
cd /home

# Clone le dépôt (remplace par ton URL GitHub)
git clone https://github.com/simonet85/horizon-immo.git laravel-app

# Entre tes identifiants GitHub quand demandé :
# Username: ton-username-github
# Password: ton-personal-access-token
```

**⚠️ Si le dossier `/home/laravel-app/` existe déjà** :

```bash
# Sauvegarde l'ancien dossier
mv /home/laravel-app /home/laravel-app-backup-$(date +%Y%m%d)

# Clone ensuite
git clone https://github.com/simonet85/horizon-immo.git laravel-app
```

### 3.6 Configurer le fichier `.env` de production

```bash
cd /home/laravel-app

# Crée le fichier .env
nano .env
# ou
vi .env
```

Colle la configuration de production (voir [CLAUDE.md section 2](#2-configuration-du-fichier-env-pour-la-production))

```env
APP_NAME="HorizonImmo"
APP_ENV=production
APP_KEY=base64:xxxxxxxxxxxxxxxxxxxxxxxxxxxx
APP_DEBUG=false
APP_URL=https://ton-domaine.com

DB_CONNECTION=mysql
DB_HOST=91.216.107.186
DB_PORT=3306
DB_DATABASE=zbinv2677815
DB_USERNAME=zbinv2677815
DB_PASSWORD=ton_password

# ... (voir CLAUDE.md pour le reste)
```

**Sauvegarder dans nano** : `Ctrl + X`, puis `Y`, puis `Enter`
**Sauvegarder dans vi** : Appuie sur `Esc`, tape `:wq`, puis `Enter`

### 3.7 Installer les dépendances sur LWS

```bash
cd /home/laravel-app

# Installer les dépendances Composer (production uniquement)
composer install --optimize-autoloader --no-dev

# Générer la clé d'application si nécessaire
php artisan key:generate

# Installer les dépendances npm
npm install

# Build des assets
npm run build

# Exécuter les migrations
php artisan migrate --force

# Configurer les permissions
chmod -R 775 storage bootstrap/cache

# Créer le lien symbolique storage
php artisan storage:link

# Optimiser Laravel
php artisan optimize
```

### 3.8 Configurer le dossier public (`/htdocs/`)

```bash
# Copie le contenu de /home/laravel-app/public vers /htdocs/
cp -r /home/laravel-app/public/* /htdocs/

# Supprime l'ancien index.php dans htdocs
rm /htdocs/index.php

# Crée le nouveau index.php modifié
nano /htdocs/index.php
```

Colle le contenu modifié (voir [CLAUDE.md section 6](#6-modification-du-fichier-indexphp)) :

```php
<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

if (file_exists($maintenance = __DIR__.'/../home/laravel-app/storage/framework/maintenance.php')) {
    require $maintenance;
}

require __DIR__.'/../home/laravel-app/vendor/autoload.php';

$app = require_once __DIR__.'/../home/laravel-app/bootstrap/app.php';

$kernel = $app->make(Kernel::class);

$response = $kernel->handle(
    $request = Request::capture()
)->send();

$kernel->terminate($request, $response);
```

---

## 🔄 4. Workflow de déploiement quotidien

### 4.1 Développement local (Laragon)

```bash
# 1. Ouvre le terminal Laragon
cd C:\laragon\www\HorizonImmo

# 2. Crée une nouvelle branche pour ta fonctionnalité (optionnel)
git checkout -b feature/nouvelle-fonctionnalite

# 3. Code ta fonctionnalité...
# 4. Teste localement

# 5. Vérifie les fichiers modifiés
git status

# 6. Ajoute les fichiers modifiés au staging
git add .
# ou ajoute des fichiers spécifiques
git add resources/views/home.blade.php app/Http/Controllers/HomeController.php

# 7. Commit les modifications
git commit -m "Add: nouvelle fonctionnalité pour la page d'accueil"

# 8. Push vers GitHub
git push origin feature/nouvelle-fonctionnalite
# ou si tu es sur main
git push origin main
```

### 4.2 Merge sur la branche principale (si tu utilises des branches)

```bash
# 1. Retourne sur main
git checkout main

# 2. Merge ta branche feature
git merge feature/nouvelle-fonctionnalite

# 3. Push sur GitHub
git push origin main

# 4. (Optionnel) Supprime la branche feature
git branch -d feature/nouvelle-fonctionnalite
git push origin --delete feature/nouvelle-fonctionnalite
```

### 4.3 Déploiement sur LWS

#### Méthode manuelle (SSH)

```bash
# 1. Connecte-toi en SSH au serveur LWS
ssh zbinv2677815@ssh.cluster0XX.lws.fr

# 2. Va dans le dossier du projet
cd /home/laravel-app

# 3. Passe en mode maintenance
php artisan down

# 4. Pull les dernières modifications depuis GitHub
git pull origin main

# 5. Installe les dépendances (si composer.json a changé)
composer install --optimize-autoloader --no-dev

# 6. Build les assets (si package.json a changé)
npm install
npm run build

# 7. Copie les nouveaux assets dans htdocs
cp -r public/build /htdocs/

# 8. Exécute les migrations (si nouvelles migrations)
php artisan migrate --force

# 9. Vide les caches
php artisan optimize:clear

# 10. Reconstruit les caches
php artisan optimize

# 11. Quitte le mode maintenance
php artisan up

# 12. Déconnexion SSH
exit
```

#### Méthode automatisée (script de déploiement)

Crée un script `deploy.sh` sur le serveur LWS :

```bash
# Connecte-toi en SSH
ssh zbinv2677815@ssh.cluster0XX.lws.fr

# Crée le script de déploiement
nano /home/laravel-app/deploy.sh
```

Colle le contenu suivant :

```bash
#!/bin/bash

echo "======================================"
echo "🚀 DÉPLOIEMENT HORIZONIMMO - $(date)"
echo "======================================"

# Variables
PROJECT_PATH="/home/laravel-app"
PUBLIC_PATH="/htdocs"

# Aller dans le dossier du projet
cd $PROJECT_PATH

# 1. Mode maintenance
echo "📦 Activation du mode maintenance..."
php artisan down

# 2. Pull depuis GitHub
echo "🔄 Récupération des modifications depuis GitHub..."
git pull origin main

if [ $? -ne 0 ]; then
    echo "❌ Erreur lors du git pull. Déploiement annulé."
    php artisan up
    exit 1
fi

# 3. Installer les dépendances Composer
echo "📚 Installation des dépendances Composer..."
composer install --optimize-autoloader --no-dev --no-interaction

# 4. Installer les dépendances npm
echo "📦 Installation des dépendances npm..."
npm install --production

# 5. Build des assets
echo "🎨 Compilation des assets..."
npm run build

# 6. Copier les assets dans htdocs
echo "📂 Copie des assets dans htdocs..."
cp -r public/build $PUBLIC_PATH/

# 7. Exécuter les migrations
echo "🗄️  Exécution des migrations..."
php artisan migrate --force

# 8. Vider les caches
echo "🧹 Nettoyage des caches..."
php artisan optimize:clear

# 9. Optimiser Laravel
echo "⚡ Optimisation de Laravel..."
php artisan optimize

# 10. Créer/mettre à jour le lien symbolique storage
echo "🔗 Mise à jour du lien symbolique storage..."
php artisan storage:link

# 11. Vérifier les permissions
echo "🔐 Vérification des permissions..."
chmod -R 775 storage bootstrap/cache

# 12. Quitter le mode maintenance
echo "✅ Désactivation du mode maintenance..."
php artisan up

echo "======================================"
echo "✅ DÉPLOIEMENT TERMINÉ AVEC SUCCÈS"
echo "======================================"
```

Rend le script exécutable :

```bash
chmod +x /home/laravel-app/deploy.sh
```

**Utilisation** :

```bash
# Connecte-toi en SSH
ssh zbinv2677815@ssh.cluster0XX.lws.fr

# Exécute le script
/home/laravel-app/deploy.sh

# ou
cd /home/laravel-app && ./deploy.sh
```

---

## 🔧 5. Automatisation avancée avec GitHub Actions

### 5.1 Créer un workflow GitHub Actions

Crée un fichier `.github/workflows/deploy-to-lws.yml` dans ton projet local :

```yaml
name: Deploy to LWS

on:
  push:
    branches:
      - main  # Déploie automatiquement lors d'un push sur main
  workflow_dispatch:  # Permet le déploiement manuel depuis GitHub

jobs:
  deploy:
    name: Deploy to LWS Production
    runs-on: ubuntu-latest

    steps:
      - name: Checkout code
        uses: actions/checkout@v3

      - name: Deploy to LWS via SSH
        uses: appleboy/ssh-action@v1.0.0
        with:
          host: ${{ secrets.LWS_SSH_HOST }}
          username: ${{ secrets.LWS_SSH_USER }}
          password: ${{ secrets.LWS_SSH_PASSWORD }}
          port: 22
          script: |
            cd /home/laravel-app
            ./deploy.sh
```

### 5.2 Configurer les secrets GitHub

1. Va sur ton dépôt GitHub : [github.com/simonet85/horizon-immo](https://github.com/simonet85/horizon-immo)
2. Va dans **Settings → Secrets and variables → Actions**
3. Clique sur **New repository secret**
4. Ajoute les secrets suivants :

| Nom | Valeur | Description |
|-----|--------|-------------|
| `LWS_SSH_HOST` | `ssh.cluster0XX.lws.fr` | Hôte SSH LWS |
| `LWS_SSH_USER` | `zbinv2677815` | Nom d'utilisateur SSH |
| `LWS_SSH_PASSWORD` | `ton_mot_de_passe` | Mot de passe SSH |

### 5.3 Tester le workflow

```bash
# Depuis Laragon
cd C:\laragon\www\HorizonImmo

# Commit et push une modification
git add .
git commit -m "Test: déploiement automatique via GitHub Actions"
git push origin main
```

Va sur GitHub → **Actions** et vérifie que le workflow s'exécute correctement.

---

## 📊 6. Tableau récapitulatif des commandes

### Sur Laragon (développement local)

| Commande | Usage |
|----------|-------|
| `git status` | Voir les fichiers modifiés |
| `git add .` | Ajouter tous les fichiers modifiés au staging |
| `git commit -m "message"` | Créer un commit |
| `git push origin main` | Push vers GitHub |
| `git pull origin main` | Pull depuis GitHub |
| `php artisan serve` | Lancer le serveur de dev |
| `npm run dev` | Compiler les assets en mode dev |
| `npm run build` | Compiler les assets pour production |

### Sur LWS (production)

| Commande | Usage |
|----------|-------|
| `ssh user@host` | Se connecter en SSH |
| `cd /home/laravel-app` | Aller dans le projet |
| `git pull origin main` | Pull depuis GitHub |
| `./deploy.sh` | Exécuter le script de déploiement |
| `php artisan down` | Activer le mode maintenance |
| `php artisan up` | Désactiver le mode maintenance |
| `php artisan optimize:clear` | Vider les caches |
| `php artisan optimize` | Optimiser Laravel |
| `php artisan migrate --force` | Exécuter les migrations |
| `tail -f storage/logs/laravel.log` | Suivre les logs en temps réel |

---

## ⚠️ 7. Bonnes pratiques et sécurité

### 7.1 Ne jamais committer ces fichiers

- ❌ `.env` (contient les credentials)
- ❌ `vendor/` (trop volumineux, regénéré par composer)
- ❌ `node_modules/` (trop volumineux, regénéré par npm)
- ❌ `/storage/*.key` (clés privées)
- ❌ Fichiers de backup (`.sql`, `.zip`)

### 7.2 Toujours tester localement avant de déployer

```bash
# Sur Laragon
php artisan config:clear
php artisan cache:clear
php artisan test  # Si tu as des tests
npm run build
php artisan serve
```

### 7.3 Faire des commits atomiques

✅ **Bon** :
```bash
git commit -m "Fix: correction du bug de connexion admin"
git commit -m "Add: nouvelle page de contact"
```

❌ **Mauvais** :
```bash
git commit -m "Modifications diverses"
git commit -m "WIP"
```

### 7.4 Utiliser des branches pour les fonctionnalités

```bash
# Crée une branche pour chaque nouvelle fonctionnalité
git checkout -b feature/nouvelle-page
# ... travaille sur la fonctionnalité
git push origin feature/nouvelle-page

# Quand c'est prêt, merge sur main
git checkout main
git merge feature/nouvelle-page
git push origin main
```

### 7.5 Backup avant déploiement

Avant chaque déploiement sur LWS, fais un backup :

```bash
# Backup base de données
mysqldump -h 91.216.107.186 -u zbinv2677815 -p zbinv2677815 > backup-$(date +%Y%m%d).sql

# Backup des fichiers (optionnel)
tar -czf backup-files-$(date +%Y%m%d).tar.gz /home/laravel-app
```

---

## 🔍 8. Dépannage (Troubleshooting)

### Problème 1 : Git pull échoue sur LWS

**Erreur** : `error: Your local changes to the following files would be overwritten by merge`

**Solution** :

```bash
# Option 1 : Stash les modifications locales
git stash
git pull origin main
git stash pop

# Option 2 : Reset (⚠️ PERTE DES MODIFICATIONS LOCALES)
git reset --hard HEAD
git pull origin main
```

### Problème 2 : Permissions refusées (Permission denied)

**Erreur** : `Permission denied (publickey,password)`

**Solution** :

```bash
# Vérifie que tu as les bons identifiants SSH
ssh zbinv2677815@ssh.cluster0XX.lws.fr

# Si ça échoue, contacte le support LWS
```

### Problème 3 : Erreur 500 après déploiement

**Solution** :

```bash
# 1. Vérifie les permissions
chmod -R 775 /home/laravel-app/storage
chmod -R 775 /home/laravel-app/bootstrap/cache

# 2. Vérifie le fichier .env
cat /home/laravel-app/.env | grep APP_KEY
# Si APP_KEY est vide, génère-le
php artisan key:generate

# 3. Vide les caches
php artisan optimize:clear

# 4. Consulte les logs
tail -f /home/laravel-app/storage/logs/laravel.log
```

### Problème 4 : Assets 404 (CSS/JS introuvables)

**Solution** :

```bash
# Recompile les assets
npm run build

# Copie les assets dans htdocs
cp -r /home/laravel-app/public/build /htdocs/

# Vérifie l'APP_URL dans .env
grep APP_URL /home/laravel-app/.env
```

### Problème 5 : Composer ou npm non trouvé sur LWS

**Solution** :

```bash
# Vérifie les versions disponibles
which composer
which npm

# Si non trouvé, demande au support LWS de les installer
# Ou utilise les versions locales si disponibles
/usr/local/bin/composer --version
/usr/local/bin/npm --version
```

---

## ✅ Checklist de déploiement

### Avant chaque déploiement

- [ ] Code testé localement sur Laragon
- [ ] Assets compilés (`npm run build`)
- [ ] Aucune erreur dans les logs Laravel
- [ ] Fichier `.env` à jour (si nouvelles variables)
- [ ] Migrations testées localement
- [ ] Commit et push sur GitHub effectués
- [ ] Backup de la base de données production

### Pendant le déploiement

- [ ] Connexion SSH établie
- [ ] Mode maintenance activé
- [ ] Git pull réussi
- [ ] Dépendances installées (composer, npm)
- [ ] Assets copiés dans `/htdocs/`
- [ ] Migrations exécutées
- [ ] Caches vidés et reconstruits
- [ ] Mode maintenance désactivé

### Après le déploiement

- [ ] Site accessible (https://ton-domaine.com)
- [ ] Page d'accueil s'affiche correctement
- [ ] Assets (CSS, JS) chargent correctement
- [ ] Fonctionnalités testées (login, formulaires, etc.)
- [ ] Aucune erreur dans les logs Laravel
- [ ] Aucune erreur 500 ou 404

---

## 🎯 Résumé du workflow complet

### 1️⃣ Développement (Laragon)

```bash
cd C:\laragon\www\HorizonImmo
git checkout -b feature/nouvelle-fonctionnalite
# ... Code ...
php artisan test
npm run build
git add .
git commit -m "Add: nouvelle fonctionnalité"
git push origin feature/nouvelle-fonctionnalite
```

### 2️⃣ Merge et préparation (GitHub)

```bash
git checkout main
git merge feature/nouvelle-fonctionnalite
git push origin main
```

### 3️⃣ Déploiement (LWS)

```bash
ssh zbinv2677815@ssh.cluster0XX.lws.fr
cd /home/laravel-app
./deploy.sh
exit
```

### 4️⃣ Vérification

1. Accède à https://ton-domaine.com
2. Teste les fonctionnalités modifiées
3. Vérifie les logs : `tail -f /home/laravel-app/storage/logs/laravel.log`

---

## 🔗 Liens utiles

- **GitHub** : [github.com/simonet85/horizon-immo](https://github.com/simonet85/horizon-immo)
- **LWS Panel** : [panel.lws.fr](https://panel.lws.fr)
- **Documentation Git** : [git-scm.com/doc](https://git-scm.com/doc)
- **GitHub Actions** : [docs.github.com/actions](https://docs.github.com/actions)
- **Laravel Deployment** : [laravel.com/docs/deployment](https://laravel.com/docs/deployment)

---

**📝 Note** : Ce guide est spécifique au projet HorizonImmo et à l'hébergement LWS. Adapte les chemins et les identifiants selon ton environnement.

**🚀 Bon déploiement !**
