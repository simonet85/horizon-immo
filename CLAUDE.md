# 🚀 GUIDE COMPLET D'HÉBERGEMENT D'UNE APPLICATION LARAVEL SUR LWS

## 📋 Table des matières
1. [Préparation de l'environnement local](#1-préparation-de-lenvironnement-local)
2. [Configuration du fichier `.env` pour la production](#2-configuration-du-fichier-env-pour-la-production)
3. [Comprendre la structure LWS](#3-comprendre-la-structure-lws)
4. [Accès et sécurité du compte LWS](#4-accès-et-sécurité-du-compte-lws)
5. [Envoi du projet sur LWS](#5-envoi-du-projet-sur-lws)
6. [Modification du fichier `index.php`](#6-modification-du-fichier-indexphp)
7. [Configuration des permissions](#7-configuration-des-permissions)
8. [Configuration de la base de données](#8-configuration-de-la-base-de-données)
9. [Configuration du domaine et SSL](#9-configuration-du-domaine-et-ssl)
10. [Tests et débogage](#10-tests-et-débogage)
11. [Tâches CRON (optionnel)](#11-tâches-cron-optionnel)
12. [Maintenance et mise à jour](#12-maintenance-et-mise-à-jour)

---

## 📦 1. Préparation de l'environnement local

### Étapes de préparation avant mise en ligne

#### 1.1 Optimisation du projet Laravel

Ouvre ton terminal dans le dossier du projet et exécute :

```bash
# Installation des dépendances optimisées pour la production (sans dev dependencies)
composer install --optimize-autoloader --no-dev

# Build des assets frontend avec Vite ou Mix
npm install
npm run build

# Mise en cache des configurations pour optimiser les performances
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

#### 1.2 Export de la base de données

```bash
# Exécute les seeders si nécessaire
php artisan db:seed

# Via phpMyAdmin ou ligne de commande MySQL
# Export de la base de données en .sql
mysqldump -u root -p nom_de_base > database_backup.sql
```

#### 1.3 Nettoyage du projet

Supprime les fichiers de développement inutiles avant l'upload :
- `node_modules/` (très volumineux, non nécessaire en production)
- `tests/` (si tu ne fais pas de tests en production)
- `.git/` (optionnel : si tu ne veux pas le versioning sur le serveur)
- `.env.example`
- Fichiers de cache locaux

#### 1.4 Sauvegarde importante

⚠️ **Avant toute modification** :
- Sauvegarde ton fichier `.env` actuel
- Crée une copie complète du projet local
- Note tous tes identifiants et configurations

---

## 🔐 2. Configuration du fichier `.env` pour la production

### Sécurité importante

🛡️ **Règles de sécurité** :
- Ne **JAMAIS** committer le fichier `.env` sur GitHub
- Toujours ajouter `.env` dans ton `.gitignore`
- Ne jamais exposer tes credentials publiquement

### Configuration complète pour LWS

Crée un fichier `.env` adapté à l'environnement de production :

```env
# ========================================
# CONFIGURATION GÉNÉRALE APPLICATION
# ========================================
APP_NAME="HorizonImmo"
APP_ENV=production
APP_KEY=base64:xxxxxxxxxxxxxxxxxxxxxxxxxxxx
APP_DEBUG=false
APP_URL=https://ton-domaine.com

# ========================================
# LOGGING
# ========================================
LOG_CHANNEL=stack
LOG_DEPRECATIONS_CHANNEL=null
LOG_LEVEL=error

# ========================================
# CONFIGURATION BASE DE DONNÉES LWS
# ========================================
DB_CONNECTION=mysql
DB_HOST=91.216.107.186
DB_PORT=3306
DB_DATABASE=ton_database
DB_USERNAME=ton_user
DB_PASSWORD=ton_password

# ========================================
# CACHE ET SESSIONS
# ========================================
CACHE_DRIVER=file
SESSION_DRIVER=file
SESSION_LIFETIME=120
QUEUE_CONNECTION=sync

# ========================================
# CONFIGURATION MAIL LWS
# ========================================
MAIL_MAILER=smtp
MAIL_HOST=mail.ton-domaine.com
MAIL_PORT=587
MAIL_USERNAME=contact@ton-domaine.com
MAIL_PASSWORD=ton_mot_de_passe_mail
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=contact@ton-domaine.com
MAIL_FROM_NAME="${APP_NAME}"

# ========================================
# BROADCAST (désactivé si non utilisé)
# ========================================
BROADCAST_DRIVER=log

# ========================================
# FILESYSTEM
# ========================================
FILESYSTEM_DISK=local

# ========================================
# AUTRES CONFIGURATIONS
# ========================================
AWS_ACCESS_KEY_ID=
AWS_SECRET_ACCESS_KEY=
AWS_DEFAULT_REGION=us-east-1
AWS_BUCKET=
```

### 🔑 Générer la clé d'application

Si tu n'as pas encore de `APP_KEY`, génère-la localement :

```bash
php artisan key:generate --show
```

Copie la clé générée dans ton fichier `.env` de production.

---

## 📁 3. Comprendre la structure LWS

### Structure typique d'un hébergement LWS

Contrairement à d'autres hébergeurs, LWS utilise une structure spécifique :

```
ton-domaine.com/
│
├── home/                           # 🔒 Dossier privé (non accessible via le web)
│   ├── .composer/                  # Dossier Composer global
│   └── laravel-app/                # 📦 Tout le code Laravel (sauf /public)
│       ├── .claude/
│       ├── .git/
│       ├── .github/
│       ├── .vscode/
│       ├── app/                    # Code application
│       ├── bootstrap/              # Fichiers de démarrage Laravel
│       │   └── cache/              # Cache de démarrage (permissions 775)
│       ├── config/                 # Fichiers de configuration
│       ├── database/               # Migrations, seeders, factories
│       ├── doc/
│       ├── lang/                   # Fichiers de traduction
│       ├── node_modules/           # (optionnel en production)
│       ├── public/                 # ⚠️ Ne pas utiliser ce dossier (tout va dans htdocs/)
│       ├── resources/              # Vues, assets sources
│       ├── routes/                 # Fichiers de routes
│       ├── storage/                # 📝 Logs, cache, uploads (permissions 775)
│       │   ├── app/
│       │   ├── framework/
│       │   └── logs/
│       ├── tests/
│       ├── vendor/                 # Dépendances Composer
│       ├── .env                    # 🔐 Configuration production
│       ├── .env.example
│       ├── .editorconfig
│       ├── .gitignore
│       ├── artisan                 # CLI Laravel
│       ├── composer.json
│       ├── composer.lock
│       ├── package.json
│       ├── package-lock.json
│       ├── phpunit.xml
│       ├── postcss.config.js
│       ├── tailwind.config.js
│       └── vite.config.js
│
├── htdocs/                         # 🌐 Dossier public (racine web accessible)
│   ├── build/                      # 🎨 Assets compilés par Vite
│   │   ├── assets/
│   │   │   ├── app-xxxxx.css
│   │   │   └── app-xxxxx.js
│   │   └── manifest.json
│   ├── storage/                    # Lien symbolique vers /home/laravel-app/storage/app/public
│   │   └── logs/                   # (optionnel : peut pointer vers storage Laravel)
│   ├── .htaccess                   # ⚙️ Configuration Apache (rewriting)
│   ├── index.php                   # 🚪 Point d'entrée Laravel (MODIFIÉ)
│   ├── favicon.ico
│   ├── robots.txt
│   └── default_index.html          # (à supprimer)
│
└── tmp/                            # 🗑️ Fichiers temporaires
    └── sessions/
```

### Points clés à retenir

| Dossier | Accessible Web | Usage | Permissions |
|---------|---------------|-------|-------------|
| `/home/laravel-app/` | ❌ Non | Code source Laravel sécurisé | 755 |
| `/home/laravel-app/storage/` | ❌ Non | Logs, cache, uploads | 775 (récursif) |
| `/home/laravel-app/bootstrap/cache/` | ❌ Non | Cache de bootstrap | 775 (récursif) |
| `/htdocs/` | ✅ Oui | Point d'entrée public | 755 |
| `/htdocs/build/` | ✅ Oui | Assets (CSS, JS, images) | 755 |
| `/tmp/` | ❌ Non | Fichiers temporaires | 777 |

**Principe fondamental** :
- `htdocs/` = équivalent du dossier `public/` de Laravel
- `home/` = dossier sécurisé pour tout le reste du code
- Ne **JAMAIS** exposer le code Laravel directement dans `htdocs/`

---

## 🔐 4. Accès et sécurité du compte LWS

### Se connecter à l'espace client LWS

#### URL de connexion
👉 [https://panel.lws.fr](https://panel.lws.fr)

#### Éviter les codes de confirmation répétés

Si LWS te demande un code de confirmation à chaque connexion, voici comment ajouter ton IP à la liste de confiance :

##### 4.1 Accéder aux paramètres de sécurité

1. Connecte-toi à ton espace client LWS
2. Va dans : **Mon compte → Sécurité du compte**
   ou **Paramètres de sécurité** / **Connexion sécurisée**

##### 4.2 Ajouter une adresse IP de confiance

1. Cherche la section : **"Appareils ou adresses IP de confiance"** ou **"Autoriser une adresse IP"**
2. Clique sur : **"Ajouter une adresse IP de confiance"**
3. Entre ton adresse IP actuelle

**Comment connaître ton IP publique ?**
- 👉 [https://www.monip.org/](https://www.monip.org/)
- 👉 [https://whatismyipaddress.com/](https://whatismyipaddress.com/)

##### 4.3 Valider et enregistrer

Ton IP sera listée comme "adresse reconnue" et tu n'auras plus de code de confirmation.

⚠️ **Attention** : Si ton FAI (Fournisseur d'Accès Internet) te donne une **IP dynamique** (qui change régulièrement), cette méthode ne sera efficace que temporairement.

**Alternatives** :
- Activer la **double authentification via application mobile** (Google Authenticator, Authy)
- Demander une **IP fixe (statique)** à ton fournisseur Internet si possible
- Cocher l'option **"Faire confiance à ce navigateur"** lors de la connexion

---

## 📤 5. Envoi du projet sur LWS

### Connexion FTP/SFTP

#### Option 1 : Gestionnaire de fichiers LWS (File Manager)

1. Connecte-toi à ton [Espace Client LWS](https://panel.lws.fr)
2. Va dans : **Hébergement web → Gestion des fichiers → File Manager**
3. Le gestionnaire s'ouvre dans ton navigateur

**Avantages** : Pas de logiciel tiers à installer
**Inconvénients** : Plus lent pour les gros fichiers, interface web

#### Option 2 : FileZilla (recommandé)

Paramètres de connexion FTP :
- **Hôte** : `ftp.ton-domaine.com` ou `ftp.cluster0XX.lws.fr`
- **Utilisateur** : Ton identifiant LWS (ex: `zbinv2677815`)
- **Mot de passe** : Ton mot de passe FTP
- **Port** : `21` (FTP standard) ou `22` (SFTP si disponible)
- **Type de connexion** : FTP ou SFTP (préférable pour la sécurité)

#### Option 3 : WinSCP (Windows uniquement)

Même configuration que FileZilla, interface différente.

### Upload des fichiers

#### Étape 1 : Supprimer la page par défaut LWS

Supprime le fichier :
```
/htdocs/default_index.html
```

#### Étape 2 : Structure d'upload

##### 📦 Upload du code Laravel principal

**Envoie tout le projet Laravel (SAUF le dossier `/public`)** dans :
```
/home/laravel-app/
```

**Ce qui doit être uploadé** :
```
home/laravel-app/
├── .claude/
├── .git/                    (optionnel)
├── .github/
├── .vscode/
├── app/
├── bootstrap/
├── config/
├── database/
├── doc/
├── lang/
├── resources/
├── routes/
├── storage/
├── tests/                   (optionnel)
├── vendor/
├── .env                     (configuration production)
├── .env.example
├── .editorconfig
├── .gitattributes
├── .gitignore
├── artisan
├── composer.json
├── composer.lock
├── package.json
├── package-lock.json
├── phpunit.xml
├── postcss.config.js
├── README.md
├── tailwind.config.js
└── vite.config.js
```

##### 🌐 Upload du dossier public

**Envoie UNIQUEMENT le contenu du dossier `/public`** dans :
```
/htdocs/
```

**Ce qui doit être uploadé** :
```
htdocs/
├── build/                   (assets Vite/Mix compilés)
│   ├── assets/
│   │   ├── app-xxxxx.css
│   │   └── app-xxxxx.js
│   └── manifest.json
├── .htaccess               (configuration Apache)
├── index.php               (à modifier après upload)
├── favicon.ico
└── robots.txt
```

**Important** : Ne copie PAS le dossier `public/` lui-même, mais son **contenu** !

#### Étape 3 : Vérification de l'upload

Après l'upload, vérifie la structure :

**Racine du serveur** :
- ✅ `/home/laravel-app/` contient tous les fichiers Laravel
- ✅ `/home/laravel-app/.env` existe et est configuré
- ✅ `/home/laravel-app/vendor/` contient les dépendances Composer
- ✅ `/htdocs/index.php` existe
- ✅ `/htdocs/.htaccess` existe
- ✅ `/htdocs/build/` contient les assets compilés

---

## ⚙️ 6. Modification du fichier `index.php`

### Adapter les chemins pour LWS

Le fichier `/htdocs/index.php` doit être modifié pour pointer vers le code Laravel dans `/home/laravel-app/`.

#### Via le File Manager LWS

1. Navigue vers `/htdocs/`
2. Clic droit sur `index.php` → **Modifier** ou **Éditer**
3. Remplace tout le contenu par le code ci-dessous

#### Code complet pour `/htdocs/index.php`

```php
<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;

define('LARAVEL_START', microtime(true));

/*
|--------------------------------------------------------------------------
| Check If The Application Is Under Maintenance
|--------------------------------------------------------------------------
|
| If the application is in maintenance / demo mode via the "down" command
| we will load this file so that any pre-rendered content can be shown
| instead of starting the framework, which could cause an exception.
|
*/

if (file_exists($maintenance = __DIR__.'/../home/laravel-app/storage/framework/maintenance.php')) {
    require $maintenance;
}

/*
|--------------------------------------------------------------------------
| Register The Auto Loader
|--------------------------------------------------------------------------
|
| Composer provides a convenient, automatically generated class loader for
| this application. We just need to utilize it! We'll simply require it
| into the script here so we don't need to manually load our classes.
|
*/

require __DIR__.'/../home/laravel-app/vendor/autoload.php';

/*
|--------------------------------------------------------------------------
| Run The Application
|--------------------------------------------------------------------------
|
| Once we have the application, we can handle the incoming request using
| the application's HTTP kernel. Then, we will send the response back
| to this client's browser, allowing them to enjoy our application.
|
*/

$app = require_once __DIR__.'/../home/laravel-app/bootstrap/app.php';

$kernel = $app->make(Kernel::class);

$response = $kernel->handle(
    $request = Request::capture()
)->send();

$kernel->terminate($request, $response);
```

#### Points clés modifiés

| Ligne originale | Ligne modifiée | Raison |
|----------------|----------------|--------|
| `__DIR__.'/../storage/framework/maintenance.php'` | `__DIR__.'/../home/laravel-app/storage/framework/maintenance.php'` | Nouveau chemin vers storage |
| `__DIR__.'/../vendor/autoload.php'` | `__DIR__.'/../home/laravel-app/vendor/autoload.php'` | Nouveau chemin vers vendor |
| `__DIR__.'/../bootstrap/app.php'` | `__DIR__.'/../home/laravel-app/bootstrap/app.php'` | Nouveau chemin vers bootstrap |

### Vérifier le fichier `.htaccess`

Assure-toi que `/htdocs/.htaccess` contient bien la configuration suivante :

```apache
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On

    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # Redirect Trailing Slashes If Not A Folder...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Send Requests To Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
```

**Ce que fait ce `.htaccess`** :
- Active le module de réécriture d'URL Apache
- Gère l'en-tête d'autorisation (important pour les APIs)
- Redirige les URLs avec trailing slash
- Route toutes les requêtes vers `index.php` (sauf fichiers/dossiers existants)

---

## 🔧 7. Configuration des permissions

### Permissions des dossiers Laravel

Via le **File Manager LWS**, modifie les permissions des dossiers suivants :

#### Dossiers nécessitant des permissions d'écriture

1. **`/home/laravel-app/storage/`** → Permissions **775** (récursif)
2. **`/home/laravel-app/bootstrap/cache/`** → Permissions **775** (récursif)

**Pourquoi ces permissions ?**

Laravel doit pouvoir écrire dans ces dossiers pour :
- Générer les logs d'application (`storage/logs/`)
- Stocker les fichiers uploadés (`storage/app/`)
- Mettre en cache les vues compilées (`storage/framework/views/`)
- Mettre en cache les sessions (`storage/framework/sessions/`)
- Mettre en cache la configuration (`bootstrap/cache/`)

### Comment modifier les permissions sur LWS File Manager ?

#### Méthode 1 : Clic droit

1. Sélectionne le dossier (ex: `storage`)
2. Clic droit → **Permissions** ou **CHMOD**
3. Coche les cases suivantes :
   - **Propriétaire** : Lecture, Écriture, Exécution (7)
   - **Groupe** : Lecture, Écriture, Exécution (7)
   - **Public** : Lecture, Exécution (5)
4. **Important** : Coche **"Appliquer récursivement"**
5. Valide

#### Méthode 2 : Saisie manuelle

1. Sélectionne le dossier
2. Entre `775` dans le champ CHMOD
3. Applique récursivement

#### Méthode 3 : Via SSH (si disponible)

Si tu as un accès SSH :

```bash
# Se placer dans le bon dossier
cd /home/laravel-app

# Définir les permissions sur storage
chmod -R 775 storage

# Définir les permissions sur bootstrap/cache
chmod -R 775 bootstrap/cache

# S'assurer que les propriétaires sont corrects
chown -R www-data:www-data storage bootstrap/cache
```

### Tableau récapitulatif des permissions

| Dossier | Permissions | Récursif | Raison |
|---------|-------------|----------|--------|
| `/home/laravel-app/` | 755 | Non | Code source protégé |
| `/home/laravel-app/storage/` | 775 | ✅ Oui | Laravel écrit logs/cache/uploads |
| `/home/laravel-app/bootstrap/cache/` | 775 | ✅ Oui | Laravel écrit cache config/routes |
| `/htdocs/` | 755 | Non | Fichiers publics |
| `/htdocs/build/` | 755 | Non | Assets statiques (lecture seule) |

---

## 🗄️ 8. Configuration de la base de données

### Créer/Vérifier la base de données MySQL

#### 8.1 Accès au panneau de bases de données

1. Depuis le **panneau LWS** → **Bases de données MySQL**
2. Vérifie qu'une base de données existe ou crée-en une nouvelle

#### 8.2 Informations de connexion

Note bien les informations suivantes :

| Paramètre | Exemple | Où trouver |
|-----------|---------|------------|
| Nom de la base | `zbinv2677815` | Panneau LWS → Bases de données |
| Utilisateur | `zbinv2677815` | Panneau LWS → Bases de données |
| Mot de passe | `qN4!W94eTyVfpB1` | Email de création ou réinitialisation |
| Hôte (IP) | `91.216.107.186` | Panneau LWS → Bases de données |
| Port | `3306` | Port MySQL standard |

#### 8.3 Mettre à jour le fichier `.env`

Édite `/home/laravel-app/.env` et vérifie ces lignes :

```env
DB_CONNECTION=mysql
DB_HOST=91.216.107.186
DB_PORT=3306
DB_DATABASE=zbinv2677815
DB_USERNAME=zbinv2677815
DB_PASSWORD=qN4!W94eTyVfpB1
```

### Importer la base de données

#### Méthode 1 : Via phpMyAdmin (recommandé)

1. Accède à **phpMyAdmin** depuis ton panneau LWS
2. Sélectionne ta base de données (ex: `zbinv2677815`)
3. Clique sur l'onglet **Importer**
4. Choisis ton fichier `.sql` exporté depuis ton environnement local
5. **Important** : Vérifie le **jeu de caractères** (généralement `utf8mb4_unicode_ci`)
6. Clique sur **Exécuter**

#### Méthode 2 : Via ligne de commande SSH (si disponible)

```bash
# Import d'une base de données
mysql -h 91.216.107.186 -u zbinv2677815 -p zbinv2677815 < database_backup.sql

# Avec affichage des erreurs
mysql -h 91.216.107.186 -u zbinv2677815 -p zbinv2677815 --verbose < database_backup.sql
```

#### Problèmes courants lors de l'import

| Erreur | Cause | Solution |
|--------|-------|----------|
| Fichier trop volumineux | Limite `upload_max_filesize` | Compresse en `.sql.gz` ou augmente la limite PHP |
| Timeout lors de l'import | Script trop long | Divise le fichier SQL en plusieurs parties |
| Erreur de syntaxe SQL | Version MySQL différente | Vérifie la compatibilité des versions |
| Erreur de charset | Encodage différent | Utilise `utf8mb4_unicode_ci` |

**Astuce** : Si ton fichier SQL est très volumineux, compresse-le :

```bash
# Compression
gzip database_backup.sql
# Résultat : database_backup.sql.gz (phpMyAdmin accepte ce format)
```

### Exécuter les migrations Laravel (alternative)

Si tu préfères utiliser les migrations Laravel au lieu d'importer :

```bash
# Via SSH ou terminal LWS
cd /home/laravel-app

# Exécuter les migrations
php artisan migrate --force

# Exécuter les seeders
php artisan db:seed --force

# Ou tout en une fois
php artisan migrate:fresh --seed --force
```

⚠️ **Note** : Le flag `--force` est **requis** en environnement de production (car `APP_ENV=production`).

### Tester la connexion à la base de données

#### Via Laravel Tinker (SSH)

```bash
cd /home/laravel-app
php artisan tinker

# Teste la connexion
>>> DB::connection()->getPdo();
# Si ça retourne un objet PDO, c'est bon !

# Teste une requête simple
>>> DB::table('users')->count();
```

#### Via un fichier de test temporaire

Crée un fichier `test_db.php` dans `/htdocs/` :

```php
<?php
require __DIR__.'/../home/laravel-app/vendor/autoload.php';

$app = require_once __DIR__.'/../home/laravel-app/bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

try {
    DB::connection()->getPdo();
    echo "✅ Connexion à la base de données réussie !";
    echo "<br>Base: " . DB::connection()->getDatabaseName();
} catch (\Exception $e) {
    echo "❌ Erreur de connexion : " . $e->getMessage();
}
```

Accède à : `https://ton-domaine.com/test_db.php`

**N'oublie pas de supprimer ce fichier après le test !**

---

## 🌐 9. Configuration du domaine et SSL

### Pointer le domaine

#### 9.1 Vérifier la configuration du domaine

1. Dans ton espace LWS → **Gestion du domaine**
2. Vérifie que `ton-domaine.com` pointe vers ton hébergement
3. Vérifie les DNS :
   - **Enregistrement A** : pointe vers l'IP du serveur LWS
   - **Enregistrement CNAME** (pour www) : pointe vers `ton-domaine.com`

#### 9.2 Propagation DNS

⏳ La propagation DNS peut prendre **de quelques minutes à 24-48 heures**.

**Vérifier la propagation** :
- 👉 [https://www.whatsmydns.net/](https://www.whatsmydns.net/)
- 👉 [https://dnschecker.org/](https://dnschecker.org/)

### Activer le SSL (HTTPS)

#### 9.1 Activation du certificat Let's Encrypt (gratuit)

1. Dans ton panneau LWS → **SSL/TLS** ou **Certificats SSL**
2. Sélectionne ton domaine
3. Active le certificat SSL gratuit **Let's Encrypt**
4. Attends quelques minutes pour l'activation automatique

#### 9.2 Vérifier l'activation SSL

Une fois activé, vérifie que le site est accessible en HTTPS :
- ✅ `https://ton-domaine.com`
- ✅ Le cadenas apparaît dans le navigateur

### Redirection HTTP vers HTTPS

Pour forcer tous les visiteurs à utiliser HTTPS, modifie `/htdocs/.htaccess` :

#### Configuration complète `.htaccess` avec HTTPS

```apache
<IfModule mod_rewrite.c>
    <IfModule mod_negotiation.c>
        Options -MultiViews -Indexes
    </IfModule>

    RewriteEngine On

    # ========================================
    # FORCER HTTPS
    # ========================================
    RewriteCond %{HTTPS} off
    RewriteRule ^(.*)$ https://%{HTTP_HOST}%{REQUEST_URI} [L,R=301]

    # ========================================
    # REDIRIGER www VERS non-www (ou inversement)
    # ========================================
    # Décommenter pour rediriger www → non-www
    RewriteCond %{HTTP_HOST} ^www\.ton-domaine\.com$ [NC]
    RewriteRule ^(.*)$ https://ton-domaine.com/$1 [L,R=301]

    # OU inversement : non-www → www (commenter le bloc ci-dessus)
    # RewriteCond %{HTTP_HOST} ^ton-domaine\.com$ [NC]
    # RewriteRule ^(.*)$ https://www.ton-domaine.com/$1 [L,R=301]

    # ========================================
    # LARAVEL ROUTING
    # ========================================

    # Handle Authorization Header
    RewriteCond %{HTTP:Authorization} .
    RewriteRule .* - [E=HTTP_AUTHORIZATION:%{HTTP:Authorization}]

    # Redirect Trailing Slashes If Not A Folder...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_URI} (.+)/$
    RewriteRule ^ %1 [L,R=301]

    # Send Requests To Front Controller...
    RewriteCond %{REQUEST_FILENAME} !-d
    RewriteCond %{REQUEST_FILENAME} !-f
    RewriteRule ^ index.php [L]
</IfModule>
```

### Mettre à jour l'URL dans Laravel

N'oublie pas de mettre à jour le fichier `.env` :

```env
APP_URL=https://ton-domaine.com
```

Puis vide les caches :

```bash
cd /home/laravel-app
php artisan config:clear
php artisan cache:clear
php artisan config:cache
```

---

## 🧪 10. Tests et débogage

### Tester l'application

#### 10.1 Tests de base

Accède à : **https://ton-domaine.com**

Vérifie que :
- ✅ La page d'accueil s'affiche correctement
- ✅ Les assets (CSS, JS, images) se chargent
- ✅ Les routes fonctionnent (teste plusieurs pages)
- ✅ La connexion à la base de données fonctionne
- ✅ Les formulaires fonctionnent
- ✅ L'upload de fichiers fonctionne (si applicable)
- ✅ L'envoi d'emails fonctionne (si applicable)

### En cas d'erreur 500

#### 1. Activer temporairement le mode debug

⚠️ **Attention** : Ne fais ceci que **temporairement** pour diagnostiquer !

Édite `/home/laravel-app/.env` :

```env
APP_DEBUG=true
APP_ENV=local
```

Vide le cache :

```bash
php artisan config:clear
php artisan cache:clear
```

Recharge la page pour voir l'erreur détaillée.

**N'oublie pas de remettre à `false` après le débogage !**

```env
APP_DEBUG=false
APP_ENV=production
```

#### 2. Consulter les logs Laravel

Les logs Laravel se trouvent dans :
```
/home/laravel-app/storage/logs/laravel.log
```

**Via File Manager LWS** :
1. Navigue vers `/home/laravel-app/storage/logs/`
2. Télécharge `laravel.log`
3. Ouvre-le avec un éditeur de texte
4. Consulte les dernières lignes (les plus récentes sont en bas)

**Via SSH** :

```bash
# Afficher les 50 dernières lignes du log
tail -n 50 /home/laravel-app/storage/logs/laravel.log

# Suivre les logs en temps réel
tail -f /home/laravel-app/storage/logs/laravel.log
```

#### 3. Vider les caches Laravel

Si tu as modifié des configurations :

```bash
cd /home/laravel-app

# Vider TOUS les caches
php artisan optimize:clear

# Ou individuellement
php artisan config:clear
php artisan cache:clear
php artisan route:clear
php artisan view:clear

# Puis remettre en cache (optimisation)
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

#### 4. Problèmes courants et solutions

| Erreur | Cause probable | Solution |
|--------|---------------|----------|
| **"No application encryption key"** | `APP_KEY` manquant dans `.env` | `php artisan key:generate` |
| **"Permission denied" sur storage/** | Permissions incorrectes | CHMOD 775 sur `storage/` et `bootstrap/cache/` |
| **Assets 404 (CSS/JS introuvables)** | Mauvais chemin ou `APP_URL` incorrect | Vérifie `APP_URL` dans `.env` et `npm run build` |
| **"Base de données inaccessible"** | Credentials incorrects | Vérifie `DB_*` dans `.env` |
| **"Class not found"** | Autoload Composer corrompu | `composer dump-autoload` |
| **Page blanche sans erreur** | Erreur fatale PHP masquée | Active `APP_DEBUG=true` temporairement |
| **"Too many redirects"** | Boucle de redirection `.htaccess` | Vérifie les règles de redirection HTTPS |
| **"419 Page Expired" (CSRF)** | Session expirée ou mal configurée | Vérifie `SESSION_DRIVER` et `SESSION_DOMAIN` |
| **Emails non envoyés** | Configuration MAIL incorrecte | Vérifie `MAIL_*` dans `.env` |

### Commandes utiles via SSH

Si LWS te donne un accès SSH :

```bash
# Se placer dans le projet
cd /home/laravel-app

# Vérifier la version de PHP
php -v

# Vérifier les extensions PHP installées
php -m

# Vider tous les caches
php artisan optimize:clear

# Reconstruire tous les caches
php artisan optimize

# Vérifier les routes disponibles
php artisan route:list

# Tester la connexion à la base de données
php artisan tinker
>>> DB::connection()->getPdo();
>>> exit

# Afficher la configuration actuelle
php artisan config:show

# Vérifier les variables d'environnement
php artisan env

# Lancer un serveur de test (seulement en dev)
# NE PAS FAIRE EN PRODUCTION
# php artisan serve

# Vérifier l'état des migrations
php artisan migrate:status

# Créer un lien symbolique storage
php artisan storage:link
```

### Tester les performances

#### Test de vitesse

- 👉 [https://gtmetrix.com/](https://gtmetrix.com/)
- 👉 [https://www.webpagetest.org/](https://www.webpagetest.org/)
- 👉 [https://developers.google.com/speed/pagespeed/insights/](https://developers.google.com/speed/pagespeed/insights/)

#### Optimisations recommandées

```bash
# Optimiser les images (avant upload)
# Utilise TinyPNG, ImageOptim, etc.

# Activer la compression Gzip (dans .htaccess)
# Déjà activé par défaut sur LWS

# Mettre en cache les assets (dans .htaccess)
# Ajouter des headers de cache pour les fichiers statiques
```

---

## ⏰ 11. Tâches CRON (optionnel)

### Configurer le scheduler Laravel

Si ton application utilise des tâches planifiées (emails automatiques, nettoyage de base de données, rapports, etc.), tu dois configurer une tâche CRON.

#### 11.1 Accès aux tâches CRON sur LWS

1. Dans ton panneau LWS → **Tâches planifiées (CRON)** ou **CRON Jobs**
2. Clique sur **Ajouter une nouvelle tâche CRON**

#### 11.2 Configuration de la tâche CRON

**Fréquence** : Toutes les minutes (obligatoire pour Laravel)

**Commande à exécuter** :

```bash
/usr/bin/php /home/laravel-app/artisan schedule:run >> /dev/null 2>&1
```

**Explication détaillée** :
- `* * * * *` = Toutes les minutes
- `/usr/bin/php` = Chemin vers l'exécutable PHP (peut varier selon l'hébergeur)
- `/home/laravel-app/artisan schedule:run` = Commande Laravel à exécuter
- `>> /dev/null 2>&1` = Redirige les sorties vers null (évite les emails de cron)

#### 11.3 Trouver le bon chemin PHP

Si tu ne connais pas le chemin exact de PHP sur ton serveur, exécute via SSH :

```bash
which php
# Exemple de résultat : /usr/bin/php

# Ou
whereis php
# Exemple de résultat : php: /usr/bin/php /usr/local/bin/php

# Vérifier la version PHP utilisée
/usr/bin/php -v
```

**Chemins PHP courants sur LWS** :
- `/usr/bin/php` (PHP 7.x par défaut)
- `/usr/local/bin/php` (PHP 8.x)
- `/opt/php8.2/bin/php` (PHP 8.2 spécifique)

#### 11.4 Configuration CRON complète (interface LWS)

| Paramètre | Valeur |
|-----------|--------|
| **Minute** | `*` (chaque minute) |
| **Heure** | `*` (chaque heure) |
| **Jour du mois** | `*` (chaque jour) |
| **Mois** | `*` (chaque mois) |
| **Jour de la semaine** | `*` (chaque jour) |
| **Commande** | `/usr/bin/php /home/laravel-app/artisan schedule:run >> /dev/null 2>&1` |

### Définir les tâches planifiées dans Laravel

Dans ton fichier `app/Console/Kernel.php` :

```php
<?php

namespace App\Console;

use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * Define the application's command schedule.
     */
    protected function schedule(Schedule $schedule): void
    {
        // Exemple : Envoyer un rapport quotidien à 8h
        $schedule->command('reports:daily')
                 ->dailyAt('08:00');

        // Exemple : Nettoyer les logs chaque semaine
        $schedule->command('logs:clean')
                 ->weekly()
                 ->sundays()
                 ->at('02:00');

        // Exemple : Backup de la base de données tous les jours à 2h
        $schedule->command('backup:run')
                 ->daily()
                 ->at('02:00');

        // Exemple : Vérifier les tâches toutes les 5 minutes
        $schedule->command('queue:work --stop-when-empty')
                 ->everyFiveMinutes()
                 ->withoutOverlapping();
    }

    /**
     * Register the commands for the application.
     */
    protected function commands(): void
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
```

### Tester les tâches planifiées

#### Test manuel via SSH

```bash
cd /home/laravel-app

# Exécuter manuellement le scheduler
php artisan schedule:run

# Afficher toutes les tâches planifiées
php artisan schedule:list

# Tester une commande spécifique
php artisan reports:daily
```

#### Vérifier l'exécution des CRON

**Via les logs LWS** :
1. Panneau LWS → **Tâches CRON**
2. Consulte l'historique des exécutions

**Via les logs Laravel** :

Ajoute des logs dans tes commandes :

```php
use Illuminate\Support\Facades\Log;

Log::info('Daily report executed successfully');
```

Puis consulte :
```
/home/laravel-app/storage/logs/laravel.log
```

---

## 🔄 12. Maintenance et mise à jour

### Mettre l'application en mode maintenance

#### Activer le mode maintenance

```bash
cd /home/laravel-app
php artisan down
```

**Message personnalisé** :

```bash
php artisan down --message="Maintenance en cours. Retour dans 30 minutes."
```

**Avec redirection** :

```bash
php artisan down --redirect=/maintenance
```

**Autoriser certaines IPs** :

```bash
php artisan down --allow=123.45.67.89 --allow=98.76.54.32
```

#### Désactiver le mode maintenance

```bash
php artisan up
```

### Mettre à jour l'application

#### 12.1 Préparation

1. **Toujours faire un backup** avant toute mise à jour :
   - Backup de la base de données (export SQL)
   - Backup des fichiers (télécharge `/home/laravel-app/`)

#### 12.2 Mise à jour des fichiers

```bash
# Via FTP ou File Manager
# 1. Upload les nouveaux fichiers modifiés
# 2. Remplace les fichiers existants

# Via Git (si configuré)
cd /home/laravel-app
git pull origin main
```

#### 12.3 Mise à jour des dépendances

```bash
cd /home/laravel-app

# Mettre à jour les dépendances Composer
composer install --optimize-autoloader --no-dev

# Mettre à jour les dépendances npm (si nécessaire)
npm install
npm run build
```

#### 12.4 Mise à jour de la base de données

```bash
# Exécuter les nouvelles migrations
php artisan migrate --force

# Si seeders nécessaires
php artisan db:seed --force
```

#### 12.5 Vider les caches

```bash
# Vider tous les caches
php artisan optimize:clear

# Reconstruire les caches
php artisan optimize
```

#### 12.6 Vérifications post-mise à jour

```bash
# Vérifier l'état des migrations
php artisan migrate:status

# Vérifier les routes
php artisan route:list

# Tester la connexion DB
php artisan tinker
>>> DB::connection()->getPdo();
>>> exit
```

### Automatiser les mises à jour (optionnel)

Crée un script de déploiement `deploy.sh` :

```bash
#!/bin/bash

echo "🚀 Démarrage du déploiement..."

# Passer en mode maintenance
php artisan down

# Récupérer les dernières modifications
git pull origin main

# Mettre à jour les dépendances
composer install --optimize-autoloader --no-dev

# Build des assets
npm install
npm run build

# Exécuter les migrations
php artisan migrate --force

# Vider les caches
php artisan optimize:clear

# Reconstruire les caches
php artisan optimize

# Créer le lien symbolique storage (si nécessaire)
php artisan storage:link

# Sortir du mode maintenance
php artisan up

echo "✅ Déploiement terminé avec succès !"
```

Exécution :

```bash
chmod +x deploy.sh
./deploy.sh
```

---

## 📊 Résultat final

### Structure finale sur LWS

```
ton-domaine.com/
│
├── home/
│   ├── .composer/
│   └── laravel-app/                    # ✅ Code Laravel complet
│       ├── app/
│       ├── bootstrap/
│       │   └── cache/                  # ✅ Permissions 775
│       ├── config/
│       ├── database/
│       ├── public/                     # ⚠️ Vide (tout est dans htdocs/)
│       ├── resources/
│       ├── routes/
│       ├── storage/                    # ✅ Permissions 775
│       ├── vendor/
│       ├── .env                        # ✅ Configuré pour production
│       └── artisan
│
├── htdocs/                             # ✅ Racine web publique
│   ├── build/                          # ✅ Assets compilés (CSS/JS)
│   ├── storage/                        # ✅ Lien symbolique (optionnel)
│   ├── .htaccess                       # ✅ Avec redirection HTTPS
│   ├── index.php                       # ✅ Modifié pour pointer vers laravel-app
│   ├── favicon.ico
│   └── robots.txt
│
└── tmp/                                # Fichiers temporaires
```

### Ton application est maintenant accessible sur :

🌐 **[https://ton-domaine.com](https://ton-domaine.com)**

---

## ✅ Checklist finale de déploiement

### Avant le déploiement

- [ ] Projet Laravel testé en local
- [ ] Base de données exportée (.sql)
- [ ] Fichier `.env` de production préparé
- [ ] Assets compilés (`npm run build`)
- [ ] Dépendances Composer installées (`--no-dev`)
- [ ] Backup complet du projet local

### Upload et configuration

- [ ] Code Laravel uploadé dans `/home/laravel-app/`
- [ ] Contenu de `/public` uploadé dans `/htdocs/`
- [ ] Fichier `/htdocs/index.php` modifié avec les bons chemins
- [ ] Fichier `/htdocs/.htaccess` présent et correct
- [ ] Fichier `.env` configuré pour la production
- [ ] Clé `APP_KEY` générée et présente

### Permissions et sécurité

- [ ] Permissions 775 sur `/home/laravel-app/storage/` (récursif)
- [ ] Permissions 775 sur `/home/laravel-app/bootstrap/cache/` (récursif)
- [ ] Fichier `.env` non accessible via le web
- [ ] `APP_DEBUG=false` en production
- [ ] `APP_ENV=production`

### Base de données

- [ ] Base de données créée sur LWS
- [ ] Credentials de BDD notés et configurés dans `.env`
- [ ] Base de données importée ou migrations exécutées
- [ ] Connexion à la BDD testée et fonctionnelle

### Domaine et SSL

- [ ] Domaine pointé vers l'hébergement LWS
- [ ] DNS propagés (vérifier sur whatsmydns.net)
- [ ] SSL activé (Let's Encrypt)
- [ ] Redirection HTTP → HTTPS configurée
- [ ] `APP_URL` correctement défini dans `.env`

### Tests et optimisation

- [ ] Site accessible et fonctionnel (https://ton-domaine.com)
- [ ] Page d'accueil s'affiche correctement
- [ ] Assets (CSS, JS, images) se chargent
- [ ] Routes testées et fonctionnelles
- [ ] Formulaires testés (CSRF token)
- [ ] Upload de fichiers testé (si applicable)
- [ ] Envoi d'emails testé (si applicable)
- [ ] Logs vérifiés (pas d'erreurs)
- [ ] Caches optimisés (`config:cache`, `route:cache`, `view:cache`)

### Optionnel

- [ ] Tâches CRON configurées (si nécessaire)
- [ ] Lien symbolique storage créé (`php artisan storage:link`)
- [ ] IP de confiance ajoutée dans le panneau LWS
- [ ] Backup automatisé configuré
- [ ] Monitoring configuré

---

## 🆘 Besoin d'aide ?

### Support LWS

- **Documentation officielle** : [https://aide.lws.fr](https://aide.lws.fr)
- **Centre d'aide** : [https://www.lws.fr/centre-aide](https://www.lws.fr/centre-aide)
- **Ticket support** : Via ton espace client LWS
- **Téléphone** : Numéro disponible sur [https://www.lws.fr/contact](https://www.lws.fr/contact)
- **Chat en ligne** : Disponible sur le site LWS

### Documentation Laravel

- **Site officiel** : [https://laravel.com/docs](https://laravel.com/docs)
- **Deployment** : [https://laravel.com/docs/11.x/deployment](https://laravel.com/docs/11.x/deployment)
- **Optimization** : [https://laravel.com/docs/11.x/deployment#optimization](https://laravel.com/docs/11.x/deployment#optimization)
- **Forum Laravel** : [https://laracasts.com/discuss](https://laracasts.com/discuss)
- **Discord Laravel France** : Communauté francophone

### Ressources utiles

- **Tester la propagation DNS** : [https://www.whatsmydns.net/](https://www.whatsmydns.net/)
- **Vérifier ton IP** : [https://www.monip.org/](https://www.monip.org/)
- **Test de performance** : [https://gtmetrix.com/](https://gtmetrix.com/)
- **Validation SSL** : [https://www.ssllabs.com/ssltest/](https://www.ssllabs.com/ssltest/)

---

## 🎉 Félicitations !

Ton application Laravel est maintenant déployée en production sur LWS !

**Prochaines étapes recommandées** :
1. Configurer un système de backup automatique
2. Mettre en place un monitoring (uptime, erreurs)
3. Configurer Google Analytics ou Matomo
4. Optimiser les performances (cache, CDN)
5. Documenter ton processus de déploiement

**Bonne mise en production ! 🚀**

---

*Guide créé pour le projet HorizonImmo - Dernière mise à jour : Octobre 2025*
