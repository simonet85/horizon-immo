# 🔧 Installation et Configuration - HorizonImmo

## 📋 Prérequis Système

### 💻 Environnement de Développement

#### **Logiciels Requis**

-   **PHP** : 8.1.10 ou supérieur
-   **Composer** : 2.x (gestionnaire de dépendances PHP)
-   **Node.js** : 18.x ou supérieur + npm
-   **MySQL** : 8.0 ou supérieur
-   **Git** : Pour le contrôle de version

#### **Extensions PHP Requises**

```bash
# Extensions obligatoires
php-mysql
php-xml
php-mbstring
php-curl
php-zip
php-gd
php-fileinfo
php-tokenizer
```

#### **Outils Recommandés**

-   **IDE** : VS Code, PHPStorm, ou Sublime Text
-   **Terminal** : Git Bash, PowerShell, ou Terminal Linux
-   **Base de données GUI** : phpMyAdmin, MySQL Workbench, ou TablePlus
-   **API Testing** : Postman ou Insomnia

---

## 🚀 Installation Rapide

### 1️⃣ Clonage du Projet

```bash
# Cloner le repository
git clone https://github.com/votre-organisation/HorizonImmo.git
cd HorizonImmo

# Ou télécharger et extraire l'archive ZIP
```

### 2️⃣ Installation des Dépendances

```bash
# Dépendances PHP avec Composer
composer install

# Dépendances JavaScript avec npm
npm install
```

### 3️⃣ Configuration Environnement

```bash
# Copier le fichier d'environnement
cp .env.example .env

# Générer la clé d'application
php artisan key:generate
```

### 4️⃣ Configuration Base de Données

#### **Créer la base de données**

```sql
-- Se connecter à MySQL
mysql -u root -p

-- Créer la base de données
CREATE DATABASE horizonimmo CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;

-- Créer un utilisateur dédié (optionnel mais recommandé)
CREATE USER 'horizonimmo'@'localhost' IDENTIFIED BY 'mot_de_passe_securise';
GRANT ALL PRIVILEGES ON horizonimmo.* TO 'horizonimmo'@'localhost';
FLUSH PRIVILEGES;
```

#### **Configurer .env**

```env
# Configuration base de données
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=horizonimmo
DB_USERNAME=horizonimmo
DB_PASSWORD=mot_de_passe_securise
```

### 5️⃣ Migration et Données

```bash
# Exécuter les migrations
php artisan migrate

# Installer les données de base (rôles, permissions)
php artisan db:seed --class=RoleAndPermissionSeeder

# Optionnel : Données de démonstration
php artisan db:seed
```

### 6️⃣ Configuration Storage

```bash
# Créer le lien symbolique pour le storage public
php artisan storage:link

# Créer les dossiers nécessaires
mkdir -p storage/app/public/avatars
mkdir -p storage/app/public/properties
```

### 7️⃣ Build des Assets

```bash
# Développement avec hot reload
npm run dev

# Ou build pour production
npm run build
```

### 8️⃣ Lancement du Serveur

```bash
# Serveur de développement Laravel
php artisan serve

# L'application sera accessible sur http://localhost:8000
```

---

## 🔧 Configuration Détaillée

### ⚙️ Fichier .env Complet

```env
# Application
APP_NAME="HorizonImmo"
APP_ENV=local
APP_KEY=base64:VOTRE_CLE_GENEREE
APP_DEBUG=true
APP_URL=http://localhost:8000

# Base de données
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=horizonimmo
DB_USERNAME=horizonimmo
DB_PASSWORD=mot_de_passe_securise

# Cache et Sessions
CACHE_DRIVER=file
FILESYSTEM_DISK=local
QUEUE_CONNECTION=sync
SESSION_DRIVER=file
SESSION_LIFETIME=120

# Mail (configuration selon votre fournisseur)
MAIL_MAILER=smtp
MAIL_HOST=mailpit
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
MAIL_FROM_ADDRESS="hello@horizonimmo.local"
MAIL_FROM_NAME="${APP_NAME}"

# Vite (développement front-end)
VITE_PUSHER_APP_KEY="${PUSHER_APP_KEY}"
VITE_PUSHER_HOST="${PUSHER_HOST}"
VITE_PUSHER_PORT="${PUSHER_PORT}"
VITE_PUSHER_SCHEME="${PUSHER_SCHEME}"
VITE_PUSHER_APP_CLUSTER="${PUSHER_APP_CLUSTER}"

# Upload de fichiers
UPLOAD_MAX_SIZE=2048
AVATAR_MAX_SIZE=2048
PROPERTY_IMAGES_MAX=10
```

### 🗄️ Configuration Base de Données Avancée

#### **Configuration Spécifique MySQL**

```env
# Optimisations MySQL
DB_CHARSET=utf8mb4
DB_COLLATION=utf8mb4_unicode_ci
DB_STRICT_MODE=true
DB_ENGINE=InnoDB
```

#### **Base de Données de Test**

```env
# .env.testing
DB_CONNECTION=mysql
DB_DATABASE=horizon_immo_test
DB_USERNAME=horizonimmo
DB_PASSWORD=mot_de_passe_securise
```

```bash
# Créer la base de test
mysql -u root -p -e "CREATE DATABASE horizon_immo_test CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;"
```

### 📧 Configuration Email

#### **Mailpit (Développement)**

```env
MAIL_MAILER=smtp
MAIL_HOST=127.0.0.1
MAIL_PORT=1025
MAIL_USERNAME=null
MAIL_PASSWORD=null
MAIL_ENCRYPTION=null
```

#### **Gmail SMTP (Production)**

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.gmail.com
MAIL_PORT=587
MAIL_USERNAME=votre-email@gmail.com
MAIL_PASSWORD=votre-app-password
MAIL_ENCRYPTION=tls
```

#### **SendGrid (Production Recommandée)**

```env
MAIL_MAILER=smtp
MAIL_HOST=smtp.sendgrid.net
MAIL_PORT=587
MAIL_USERNAME=apikey
MAIL_PASSWORD=votre-api-key-sendgrid
MAIL_ENCRYPTION=tls
```

---

## 🐳 Installation avec Docker (Laravel Sail)

### 🚢 Prérequis Docker

```bash
# Installer Docker Desktop (Windows/Mac)
# Ou Docker Engine (Linux)

# Vérifier l'installation
docker --version
docker-compose --version
```

### 📦 Installation Sail

```bash
# Installer via Composer
composer require laravel/sail --dev

# Publier la configuration Sail
php artisan sail:install

# Choisir les services (MySQL, Redis, Mailpit recommandés)
```

### 🔧 Configuration Docker

```bash
# Configurer l'alias Sail (optionnel mais recommandé)
alias sail='[ -f sail ] && bash sail || bash vendor/bin/sail'

# Ou sur Windows (PowerShell)
Set-Alias -Name sail -Value "vendor/bin/sail"
```

### 🚀 Lancement avec Sail

```bash
# Démarrer tous les services
sail up -d

# L'application sera accessible sur http://localhost

# Commandes utiles
sail artisan migrate      # Migrations
sail artisan db:seed      # Seeders
sail npm install          # Dépendances JS
sail npm run dev          # Build développement
```

### 🗄️ Services Docker Inclus

-   **Laravel App** : Application principale (port 80)
-   **MySQL** : Base de données (port 3306)
-   **Redis** : Cache et queues (port 6379)
-   **Mailpit** : Serveur mail de test (port 1025, interface 8025)
-   **Vite** : Serveur de développement (port 5173)

---

## 🔐 Configuration Sécurité

### 🛡️ Permissions Fichiers

```bash
# Linux/Mac
sudo chown -R www-data:www-data storage
sudo chown -R www-data:www-data bootstrap/cache
chmod -R 775 storage
chmod -R 775 bootstrap/cache

# Windows (pas de changement de propriétaire nécessaire)
# Assurer que les dossiers sont accessibles en écriture
```

### 🔑 Configuration HTTPS (Production)

#### **Certificat SSL**

```nginx
# Configuration Nginx avec SSL
server {
    listen 443 ssl http2;
    server_name horizonimmo.fr www.horizonimmo.fr;

    ssl_certificate /path/to/certificate.crt;
    ssl_certificate_key /path/to/private.key;

    root /var/www/horizonimmo/public;
    index index.php;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }
}
```

#### **Redirection HTTP vers HTTPS**

```nginx
server {
    listen 80;
    server_name horizonimmo.fr www.horizonimmo.fr;
    return 301 https://$server_name$request_uri;
}
```

### 🔒 Variables d'Environnement Sensibles

```env
# Générer des clés sécurisées
APP_KEY=base64:XXXXX...  # php artisan key:generate

# JWT Secret (si utilisé)
JWT_SECRET=your-256-bit-secret

# Clés API externes
GOOGLE_MAPS_API_KEY=your-google-maps-key
STRIPE_KEY=pk_live_xxxx
STRIPE_SECRET=sk_live_xxxx
```

---

## 🧪 Configuration Tests

### 📋 Environnement de Test

```bash
# Configurer la base de test
cp .env .env.testing

# Modifier .env.testing
DB_DATABASE=horizon_immo_test
MAIL_MAILER=array
CACHE_DRIVER=array
SESSION_DRIVER=array
QUEUE_CONNECTION=sync
```

### 🏃‍♂️ Exécution des Tests

```bash
# Tous les tests
php artisan test

# Tests spécifiques
php artisan test --filter=PropertyTest

# Tests avec coverage
php artisan test --coverage

# Tests en parallèle (plus rapide)
php artisan test --parallel
```

### 📊 Configuration Coverage

```xml
<!-- phpunit.xml -->
<coverage>
    <include>
        <directory suffix=".php">./app</directory>
    </include>
    <exclude>
        <directory>./app/Console</directory>
        <file>./app/Providers/RouteServiceProvider.php</file>
    </exclude>
</coverage>
```

---

## 🚀 Déploiement Production

### 🏗️ Préparation Production

```bash
# 1. Optimisations Laravel
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache

# 2. Autoloader optimisé
composer install --optimize-autoloader --no-dev

# 3. Build assets optimisés
npm run build

# 4. Vérification configuration
php artisan config:show
```

### 🔧 Configuration Serveur Web

#### **Apache Virtual Host**

```apache
<VirtualHost *:80>
    ServerName horizonimmo.fr
    DocumentRoot /var/www/horizonimmo/public

    <Directory /var/www/horizonimmo/public>
        AllowOverride All
        Require all granted
    </Directory>

    ErrorLog ${APACHE_LOG_DIR}/horizonimmo_error.log
    CustomLog ${APACHE_LOG_DIR}/horizonimmo_access.log combined
</VirtualHost>
```

#### **Nginx Configuration**

```nginx
server {
    listen 80;
    server_name horizonimmo.fr www.horizonimmo.fr;
    root /var/www/horizonimmo/public;

    add_header X-Frame-Options "SAMEORIGIN";
    add_header X-Content-Type-Options "nosniff";

    index index.php;

    charset utf-8;

    location / {
        try_files $uri $uri/ /index.php?$query_string;
    }

    location = /favicon.ico { access_log off; log_not_found off; }
    location = /robots.txt  { access_log off; log_not_found off; }

    error_page 404 /index.php;

    location ~ \.php$ {
        fastcgi_pass unix:/var/run/php/php8.1-fpm.sock;
        fastcgi_param SCRIPT_FILENAME $realpath_root$fastcgi_script_name;
        include fastcgi_params;
    }

    location ~ /\.(?!well-known).* {
        deny all;
    }
}
```

### 📦 Script de Déploiement

```bash
#!/bin/bash
# deploy.sh

set -e

echo "🚀 Déploiement HorizonImmo"

# Variables
PROJECT_PATH="/var/www/horizonimmo"
BACKUP_PATH="/var/backups/horizonimmo"

# Backup base de données
echo "📦 Sauvegarde base de données..."
mysqldump -u root -p horizonimmo > $BACKUP_PATH/db_$(date +%Y%m%d_%H%M%S).sql

# Mise à jour code
echo "📥 Mise à jour du code..."
cd $PROJECT_PATH
git pull origin main

# Maintenance mode
echo "🔧 Mode maintenance activé..."
php artisan down

# Installation dépendances
echo "📦 Installation dépendances..."
composer install --no-dev --optimize-autoloader

# Migrations
echo "🗄️ Mise à jour base de données..."
php artisan migrate --force

# Cache
echo "⚡ Mise à jour cache..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Assets
echo "🎨 Build assets..."
npm ci --only=production
npm run build

# Permissions
echo "🔐 Mise à jour permissions..."
chown -R www-data:www-data storage bootstrap/cache
chmod -R 775 storage bootstrap/cache

# Fin maintenance
echo "✅ Désactivation mode maintenance..."
php artisan up

echo "🎉 Déploiement terminé avec succès!"
```

---

## 🔍 Dépannage

### 🚨 Problèmes Courants

#### **Erreur : "Class not found"**

```bash
# Solution
composer dump-autoload
php artisan clear-compiled
```

#### **Erreur : "Permission denied" (Storage)**

```bash
# Linux/Mac
sudo chown -R $USER:www-data storage
sudo chmod -R 775 storage

# Windows : Vérifier les permissions dans l'explorateur
```

#### **Erreur : "Key not found"**

```bash
# Générer une nouvelle clé
php artisan key:generate
```

#### **Erreur de Migration**

```bash
# Reset complet (ATTENTION : supprime toutes les données)
php artisan migrate:fresh --seed

# Ou rollback spécifique
php artisan migrate:rollback --step=1
```

#### **Problème CSS/JS non chargés**

```bash
# Reconstruire les assets
npm run build

# Vérifier le lien symbolique storage
php artisan storage:link
```

### 🔧 Outils de Debug

#### **Laravel Telescope (Développement)**

```bash
# Installation
composer require laravel/telescope --dev
php artisan telescope:install
php artisan migrate

# Accès : http://localhost:8000/telescope
```

#### **Logs Laravel**

```bash
# Voir les logs en temps réel
tail -f storage/logs/laravel.log

# Nettoyer les logs
php artisan log:clear
```

#### **Debug Queries**

```php
// Dans un contrôleur ou middleware
DB::enableQueryLog();

// Votre code ici

dd(DB::getQueryLog());
```

### 📞 Support

Si vous rencontrez des difficultés :

1. **Vérifiez les logs** : `storage/logs/laravel.log`
2. **Consultez la documentation** : [Laravel Docs](https://laravel.com/docs)
3. **Communauté** : Forums Laravel, Stack Overflow
4. **Support interne** : technique@horizonimmo.fr

---

## 📋 Checklist Post-Installation

### ✅ Vérifications Obligatoires

-   [ ] Application accessible via navigateur
-   [ ] Base de données connectée et migrée
-   [ ] Upload d'images fonctionnel
-   [ ] Envoi d'emails configuré
-   [ ] Authentification fonctionnelle
-   [ ] Tests passent avec succès
-   [ ] Assets CSS/JS chargés correctement
-   [ ] Permissions fichiers correctes
-   [ ] HTTPS configuré (production)
-   [ ] Sauvegardes automatiques (production)

### 🔧 Optimisations Recommandées

-   [ ] Cache Redis configuré
-   [ ] Queue worker actif
-   [ ] Monitoring erreurs (Sentry)
-   [ ] CDN pour assets statiques
-   [ ] Backup automatisé
-   [ ] Monitoring uptime
-   [ ] Performance monitoring (New Relic)

---

_Guide maintenu par l'équipe technique_  
_Dernière mise à jour : Septembre 2025_  
_Version : 1.0_
