# 🏢 HorizonImmo - Plateforme Immobilière

Application Laravel 10 moderne pour la gestion immobilière, développée pour ZB Investments.

![Laravel](https://img.shields.io/badge/Laravel-10.x-red.svg)
![PHP](https://img.shields.io/badge/PHP-8.2+-blue.svg)
![License](https://img.shields.io/badge/license-MIT-green.svg)

---

## 📋 Table des matières

- [À propos](#à-propos)
- [Fonctionnalités](#fonctionnalités)
- [Technologies utilisées](#technologies-utilisées)
- [Installation locale](#installation-locale)
- [Déploiement](#déploiement)
- [Documentation](#documentation)
- [Support](#support)

---

## 🎯 À propos

**HorizonImmo** est une plateforme immobilière complète permettant de :
- Présenter un catalogue de biens immobiliers
- Gérer les demandes d'accompagnement avec simulation financière
- Administrer le contenu du site (biens, catégories, messages)
- Offrir une expérience utilisateur moderne avec sliders d'images et modales vidéo

**Client** : ZB Investments
**Développement** : Octobre 2025

---

## ✨ Fonctionnalités

### 🌐 Partie publique (Front-office)

- **Page d'accueil dynamique**
  - Section héro avec vidéo modale YouTube
  - Section offre exclusive avec image de fond
  - Sliders d'images pour les biens
  - Tarifs en FCFA avec formatage automatique

- **Catalogue de biens**
  - Filtrage par catégorie
  - Recherche par mots-clés
  - Détails complets avec galerie d'images

- **Formulaire d'accompagnement**
  - Simulation financière en temps réel
  - Calcul automatique de l'apport initial et des mensualités
  - Envoi d'email de notification

- **Pages informatives**
  - À propos
  - Contact avec formulaire

### 🔐 Partie administration (Back-office)

- **Dashboard**
  - Statistiques en temps réel
  - Graphiques de suivi

- **Gestion des biens immobiliers**
  - CRUD complet (Create, Read, Update, Delete)
  - Upload d'images multiples
  - Gestion des catégories

- **Gestion des demandes**
  - Messages de contact
  - Demandes d'accompagnement avec détails financiers

- **Configuration du site**
  - Paramètres d'affichage
  - Contenu personnalisable

### 👥 Gestion des utilisateurs

- **Rôles et permissions** (Spatie Laravel Permission)
  - Admin : accès complet
  - Client : espace client personnel

- **Authentification sécurisée**
  - Redirection automatique selon le rôle
  - Protection CSRF

---

## 🛠️ Technologies utilisées

### Backend
- **Laravel 10.x** - Framework PHP
- **MySQL** - Base de données
- **Spatie Laravel Permission** - Gestion des rôles et permissions

### Frontend
- **Livewire** - Composants réactifs
- **Alpine.js** - Interactivité JavaScript
- **Tailwind CSS** - Framework CSS
- **Vite** - Build tool moderne

### Outils de développement
- **Laragon** - Environnement de développement local (Windows)
- **Composer** - Gestionnaire de dépendances PHP
- **npm** - Gestionnaire de dépendances JavaScript
- **Git** - Versioning

---

## 💻 Installation locale

### Prérequis

- PHP 8.2 ou supérieur
- Composer
- Node.js et npm
- MySQL
- Laragon (recommandé pour Windows)

### Étapes d'installation

```bash
# 1. Clone le dépôt
git clone https://github.com/simonet85/horizon-immo.git
cd horizon-immo

# 2. Installe les dépendances PHP
composer install

# 3. Installe les dépendances JavaScript
npm install

# 4. Copie le fichier .env
cp .env.example .env

# 5. Génère la clé d'application
php artisan key:generate

# 6. Configure la base de données dans .env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=horizon_immo
DB_USERNAME=root
DB_PASSWORD=

# 7. Exécute les migrations et seeders
php artisan migrate --seed

# 8. Crée le lien symbolique storage
php artisan storage:link

# 9. Compile les assets
npm run dev

# 10. Lance le serveur de développement
php artisan serve
```

**Accès** : [http://localhost:8000](http://localhost:8000)

**Comptes de test** :
- **Admin** : admin@horizonimmo.com / password123
- **Client** : client@horizonimmo.com / password123

---

## 🚀 Déploiement

### Déploiement sur LWS

Le projet est configuré pour un déploiement automatisé sur l'hébergement LWS.

#### 📚 Guides de déploiement disponibles

1. **[🔐 Guide SSH et Git](GUIDE_SSH_GIT_LWS.md)** - Configuration SSH et déploiement Git (Recommandé)
2. **[📋 Comparaison des méthodes](DEPLOYMENT_METHODS.md)** - SSH, FTP, File Manager, GitHub Actions
3. **[📁 Guide FTP](GUIDE_MISE_A_JOUR_LWS.md)** - Déploiement via FileZilla
4. **[✅ Checklist rapide](UPDATE_CHECKLIST.md)** - Liste de vérification rapide
5. **[📘 Guide LWS complet](CLAUDE.md)** - Documentation complète de déploiement sur LWS

#### Workflow de déploiement

```
Laragon (Local) → Git Push → GitHub → Git Pull (SSH) → LWS (Production)
```

### 🔐 Connexion SSH à LWS

#### Configuration initiale SSH

```bash
# 1. Générer une clé SSH (si pas déjà fait)
ssh-keygen -t ed25519 -C "votre.email@example.com"

# 2. Copier la clé publique
cat ~/.ssh/id_ed25519.pub

# 3. Ajouter la clé sur LWS (Panel → SSH → Clés SSH)
```

#### Connexion au serveur

```bash
# Connexion SSH au serveur LWS
ssh zbinv2677815@ssh.cluster0XX.lws.fr

# Ou avec le domaine
ssh zbinv2677815@ssh.horizonimmo.com
```

### ⚡ Déploiement rapide (3 étapes)

```bash
# 1. Sur Laragon : Commit et push
git add .
git commit -m "Update: nouvelle fonctionnalité"
git push origin main

# 2. Sur LWS : Connecte-toi en SSH
ssh zbinv2677815@ssh.horizonimmo.com

# 3. Exécute le script de déploiement
cd /home/zbinv2677815/laravel-app
./deploy.sh
```

### 🔄 Déploiement manuel avec Git

Si le script de déploiement n'est pas disponible :

```bash
# Se connecter en SSH
ssh zbinv2677815@ssh.horizonimmo.com

# Aller dans le dossier du projet
cd /home/zbinv2677815/laravel-app

# Récupérer les dernières modifications
git pull origin main

# Installer les dépendances
composer install --no-dev --optimize-autoloader

# Exécuter les migrations
php artisan migrate --force

# Vider les caches
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

# Reconstruire les caches
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

### 🤖 Déploiement automatique (GitHub Actions)

**Déploiement automatique** : GitHub Actions configuré (optionnel)

Le projet inclut un workflow GitHub Actions qui déploie automatiquement sur LWS à chaque push sur la branche `main`.

Fichier : [`.github/workflows/deploy-to-lws.yml`](.github/workflows/deploy-to-lws.yml)

#### Configuration des secrets GitHub

1. Allez dans **Settings → Secrets and variables → Actions**
2. Ajoutez les secrets suivants :
   - `SSH_HOST` : `ssh.horizonimmo.com`
   - `SSH_USERNAME` : `zbinv2677815`
   - `SSH_PASSWORD` : Votre mot de passe SSH (ou clé privée)

Une fois configuré, chaque push déclenchera automatiquement le déploiement.

---

## 📖 Documentation

### Guides utilisateurs

- **[Guide utilisateur client](GUIDE_UTILISATEUR_CLIENT.md)** - Pour les visiteurs et clients
- **[Guide administrateur](GUIDE_ADMINISTRATEUR.md)** - Pour les administrateurs du site

### Guides techniques

- **[Configuration LWS](CLAUDE.md)** - Hébergement et configuration serveur
- **[Déploiement Git](DEPLOIEMENT_GIT.md)** - Workflow de déploiement automatisé
- **[Démarrage rapide](QUICK_START_DEPLOY.md)** - Guide condensé de déploiement

### Documentation Laravel

- [Laravel 10.x Documentation](https://laravel.com/docs/10.x)
- [Livewire Documentation](https://laravel-livewire.com/docs)
- [Tailwind CSS Documentation](https://tailwindcss.com/docs)

---

## 🔧 Configuration

### Variables d'environnement (.env)

```env
# Application
APP_NAME="HorizonImmo"
APP_ENV=local
APP_DEBUG=true
APP_URL=http://horizonimmo.test

# Base de données
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=horizon_immo
DB_USERNAME=root
DB_PASSWORD=

# Mail (production)
MAIL_MAILER=smtp
MAIL_HOST=mail.ton-domaine.com
MAIL_PORT=587
MAIL_USERNAME=contact@ton-domaine.com
MAIL_PASSWORD=ton_password
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=contact@ton-domaine.com
MAIL_FROM_NAME="${APP_NAME}"
```

---

## 🗂️ Structure du projet

```
HorizonImmo/
├── app/
│   ├── Http/
│   │   ├── Controllers/
│   │   │   ├── Admin/          # Contrôleurs admin
│   │   │   └── Client/         # Contrôleurs client
│   │   └── Middleware/
│   └── Models/
├── config/
├── database/
│   ├── migrations/
│   └── seeders/
├── public/
│   └── build/                  # Assets compilés
├── resources/
│   ├── css/
│   ├── js/
│   └── views/
│       ├── admin/              # Vues administration
│       ├── client/             # Vues espace client
│       ├── livewire/           # Composants Livewire
│       └── layouts/            # Templates de base
├── routes/
│   └── web.php                 # Routes de l'application
├── storage/
│   ├── app/
│   ├── framework/
│   └── logs/
├── .github/
│   └── workflows/
│       └── deploy-to-lws.yml   # GitHub Actions
├── deploy-lws.sh               # Script de déploiement
├── CLAUDE.md                   # Guide LWS
├── DEPLOIEMENT_GIT.md          # Guide Git
├── QUICK_START_DEPLOY.md       # Guide rapide
└── README.md                   # Ce fichier
```

---

## 🧪 Tests

```bash
# Exécute les tests
php artisan test

# Avec couverture de code
php artisan test --coverage
```

---

## 🔒 Sécurité

- ✅ Protection CSRF activée sur tous les formulaires
- ✅ Authentification sécurisée avec Laravel Breeze
- ✅ Validation des données côté serveur
- ✅ Rôles et permissions avec Spatie Laravel Permission
- ✅ Fichiers sensibles (.env) exclus du dépôt Git

**Reporter une vulnérabilité** : Contactez [contact@zbinvestments.com](mailto:contact@zbinvestments.com)

---

## 🤝 Contribution

Ce projet est propriétaire et développé pour ZB Investments.

---

## 📧 Support

Pour toute question ou assistance :

- **Email** : [contact@zbinvestments.com](mailto:contact@zbinvestments.com)
- **GitHub** : [github.com/simonet85/horizon-immo](https://github.com/simonet85/horizon-immo)
- **Documentation** : Voir les guides dans le dossier du projet

---

## 📝 Changelog

### Version 1.0.0 (Octobre 2025)

- ✅ Mise en place de l'architecture Laravel 10
- ✅ Système d'authentification multi-rôles
- ✅ Gestion complète des biens immobiliers
- ✅ Formulaire d'accompagnement avec simulation
- ✅ Administration complète
- ✅ Sliders d'images et modales vidéo
- ✅ Formatage des prix en FCFA
- ✅ Templates email personnalisés
- ✅ Guides utilisateur et administrateur
- ✅ Workflow de déploiement automatisé
- ✅ Configuration LWS complète

---

## 📄 License

Ce projet est sous licence propriétaire. © 2025 ZB Investments. Tous droits réservés.

---

## 🙏 Remerciements

- **Laravel** - Le framework PHP élégant
- **Livewire** - Pour l'interactivité sans JavaScript
- **Tailwind CSS** - Pour le design moderne
- **LWS** - Hébergeur français de confiance

---

## 🚀 Développé avec ❤️ par l'équipe ZB Investments

**Site web** : [www.zbinvestments.com](https://www.zbinvestments.com)
**Date** : Octobre 2025
