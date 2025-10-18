# GUIDE DE DÉPLOIEMENT - Mise à Jour HorizonImmo sur LWS

**Date** : 18 Octobre 2025
**Version** : 1.5.0 → 1.6.0
**Modifications** : Système images optimisé + Corrections bugs + Tests

---

## 🎯 OBJECTIF

Déployer sur le serveur LWS toutes les modifications effectuées aujourd'hui :
- ✅ Nouveau système upload images (5 images max)
- ✅ Intégration Spatie Media Library
- ✅ Conversions WebP automatiques
- ✅ Corrections bugs affichage images
- ✅ Mise à jour emails (branding ZB Investments)
- ✅ Tests PHPUnit complets

---

## ⚠️ IMPORTANT - AVANT DE COMMENCER

### Prérequis
- [x] Accès FTP/SFTP LWS
- [x] Accès phpMyAdmin LWS
- [x] Backup local du projet
- [ ] **CRÉER UN BACKUP COMPLET DU SITE EN PRODUCTION** ⚠️

### Durée Estimée
- Backup : 10 minutes
- Upload fichiers : 15-30 minutes
- Configuration : 10 minutes
- Tests : 15 minutes
- **Total : 50-65 minutes**

---

## 📋 ÉTAPE 1 : BACKUP PRODUCTION (OBLIGATOIRE)

### 1.1 Backup Base de Données

**Via phpMyAdmin LWS** :

1. Se connecter à [phpMyAdmin LWS](https://panel.lws.fr)
2. Sélectionner la base `zbinv2677815` (ou votre nom de BDD)
3. Cliquer sur **"Exporter"**
4. Choisir :
   - Méthode : **Rapide**
   - Format : **SQL**
   - ✅ Cocher "Ajouter CREATE DATABASE"
5. Cliquer **"Exécuter"**
6. Sauvegarder le fichier : `horizonimmo_backup_18oct2025.sql`

**Commande alternative (si SSH disponible)** :
```bash
mysqldump -h 91.216.107.186 -u zbinv2677815 -p zbinv2677815 > backup_18oct2025.sql
```

### 1.2 Backup Fichiers

**Via FTP (FileZilla)** :

1. Se connecter au serveur LWS
2. Télécharger les dossiers suivants :
   ```
   /home/laravel-app/
   ├── .env                    ⚠️ TRÈS IMPORTANT
   ├── storage/                (logs, uploads)
   └── public/storage/         (liens vers storage)
   ```
3. Sauvegarder localement : `C:\Backups\horizonimmo_18oct2025\`

**Astuce** : Compresser en ZIP après téléchargement

### 1.3 Checklist Backup

- [ ] Base de données exportée (SQL)
- [ ] Fichier .env sauvegardé
- [ ] Dossier storage/ sauvegardé
- [ ] Dossier public/storage/ sauvegardé
- [ ] Fichiers compressés et datés
- [ ] Backup testé (ouverture fichiers OK)

---

## 📦 ÉTAPE 2 : PRÉPARATION FICHIERS LOCAUX

### 2.1 Vérifier les Modifications Git

```bash
cd C:\laragon\www\HorizonImmo

# Vérifier qu'on est à jour
git status

# Vérifier les derniers commits
git log --oneline -5
```

**Résultat attendu** :
```
10065c2 Add webmaster contract and task tracking documentation
f61302b Fix duplicate footer content in email templates
3b5a40d Fix image upload system and display issues with comprehensive testing
```

### 2.2 Nettoyer les Fichiers de Développement

**Fichiers à NE PAS uploader** :

```bash
# Ces fichiers/dossiers ne doivent PAS être envoyés sur LWS
node_modules/           # Très volumineux
.git/                   # Historique Git (optionnel)
tests/                  # Tests PHPUnit
.env.example            # Exemple seulement
.claude/                # Outils de développement
.vscode/                # Configuration IDE
storage/framework/cache/
storage/logs/*.log      # Vieux logs
```

### 2.3 Générer les Assets de Production

```bash
# Installation des dépendances (production uniquement)
composer install --optimize-autoloader --no-dev

# Build des assets frontend
npm install
npm run build
```

**Résultat** : Dossier `public/build/` créé avec assets optimisés

---

## 🚀 ÉTAPE 3 : UPLOAD DES FICHIERS

### Option A : Via FTP/SFTP (Recommandé pour mise à jour)

**Connexion FileZilla** :
- **Hôte** : `ftp.horizonimmo.zbinvestments-ci.com` ou `ftp.cluster0XX.lws.fr`
- **Utilisateur** : Votre login LWS
- **Mot de passe** : Votre mot de passe FTP
- **Port** : 21 (FTP) ou 22 (SFTP)

#### 3.1 Upload Code Laravel (SAUF /public)

**Uploader vers** `/home/laravel-app/` :

```
📁 Fichiers à uploader :
├── app/                        ✅ TOUT le dossier
│   ├── Http/Controllers/       (modifications PropertyController)
│   ├── Livewire/               (modifications PropertyDetail)
│   ├── Models/                 (modifications Property.php)
│   ├── Jobs/                   ⭐ NOUVEAU (ProcessPropertyImages)
│   └── Notifications/          (modifications emails)
│
├── config/
│   └── media-library.php       ⭐ NOUVEAU
│
├── database/
│   └── factories/
│       └── TownFactory.php     ⭐ NOUVEAU
│
├── resources/views/
│   ├── admin/properties/       (modifications show.blade.php)
│   ├── livewire/               (modifications property-detail, contact-page)
│   └── vendor/mail/            (modifications emails)
│
├── storage/                    ⚠️ NE PAS ÉCRASER
│   └── app/public/             (vérifier permissions après)
│
├── vendor/                     ✅ TOUT le dossier
│
├── .env                        ⚠️ À CONFIGURER (voir étape 4)
├── composer.json               ✅
├── composer.lock               ✅
├── package.json                ✅
└── package-lock.json           ✅
```

**⚠️ ATTENTION** :
- **NE PAS** écraser `/home/laravel-app/.env` (conserver celui de production)
- **NE PAS** supprimer `/home/laravel-app/storage/` (contient les uploads)

#### 3.2 Upload Dossier Public

**Uploader vers** `/htdocs/` :

```
📁 Contenu de /public :
├── build/                      ⭐ Assets Vite compilés
│   ├── assets/
│   └── manifest.json
│
├── images/                     ✅ Si modifications
├── .htaccess                   ✅
├── favicon.ico                 ✅
├── robots.txt                  ✅
└── index.php                   ⚠️ Vérifier (ne doit pas changer)
```

**Vérifier index.php** : Ne doit PAS être modifié (déjà configuré pour LWS)

#### 3.3 Permissions Après Upload

**Via File Manager LWS ou SSH** :

```bash
# Permissions storage
chmod -R 775 /home/laravel-app/storage
chmod -R 775 /home/laravel-app/bootstrap/cache

# Propriétaire (si SSH disponible)
chown -R www-data:www-data /home/laravel-app/storage
chown -R www-data:www-data /home/laravel-app/bootstrap/cache
```

**Via File Manager LWS** :
1. Clic droit sur `storage` → **Permissions**
2. Cocher : Lecture, Écriture, Exécution pour Propriétaire et Groupe (775)
3. ✅ Cocher **"Appliquer récursivement"**
4. Répéter pour `bootstrap/cache`

---

### Option B : Via Git (Si SSH configuré sur LWS)

**Si vous avez configuré Git sur le serveur** :

```bash
# Se connecter en SSH
ssh votre-user@serveur-lws.fr

# Aller dans le dossier du projet
cd /home/laravel-app

# Mettre à jour depuis GitHub
git pull origin main

# Installer les dépendances
composer install --optimize-autoloader --no-dev

# Vider les caches
php artisan optimize:clear

# Mettre en cache
php artisan config:cache
php artisan route:cache
php artisan view:cache
```

---

## ⚙️ ÉTAPE 4 : CONFIGURATION PRODUCTION

### 4.1 Vérifier/Mettre à Jour .env

**Via File Manager LWS**, éditer `/home/laravel-app/.env` :

```env
# ========================================
# VÉRIFIER CES LIGNES
# ========================================

APP_ENV=production
APP_DEBUG=false                    # ⚠️ DOIT être false
APP_URL=https://horizonimmo.zbinvestments-ci.com

# Base de données (ne pas modifier si déjà correct)
DB_CONNECTION=mysql
DB_HOST=91.216.107.186
DB_PORT=3306
DB_DATABASE=zbinv2677815
DB_USERNAME=zbinv2677815
DB_PASSWORD=qN4!W94eTyVfpB1      # Votre mot de passe BDD

# ========================================
# NOUVELLE CONFIGURATION MEDIA LIBRARY
# ========================================
MEDIA_DISK=public
QUEUE_CONNECTION=database          # ⚠️ Pour traiter les conversions images

# ========================================
# QUEUE (pour conversions images asynchrones)
# ========================================
QUEUE_CONVERSIONS_BY_DEFAULT=true
```

**Important** : Ne changez QUE ce qui est nécessaire, gardez les autres valeurs existantes !

### 4.2 Créer les Tables Queue (si pas déjà fait)

**Via SSH ou phpMyAdmin** :

```bash
# Si SSH disponible
cd /home/laravel-app
php artisan queue:table
php artisan migrate --force
```

**Via phpMyAdmin** :
1. Ouvrir l'onglet SQL
2. Copier le contenu de `database/migrations/*_create_jobs_table.php`
3. Exécuter la requête

### 4.3 Vérifier Lien Symbolique Storage

```bash
# Via SSH
cd /home/laravel-app
php artisan storage:link
```

**Vérification** : `/htdocs/storage` doit pointer vers `/home/laravel-app/storage/app/public`

**Si pas d'accès SSH**, créer manuellement via File Manager :
- Créer un lien symbolique `storage` dans `/htdocs/`
- Pointant vers `/home/laravel-app/storage/app/public/`

---

## 🗄️ ÉTAPE 5 : MIGRATION BASE DE DONNÉES

### 5.1 Vérifier Nouvelles Migrations

**Migrations ajoutées** (si pas déjà faites) :
- ✅ `create_media_table.php` (Spatie Media Library)
- ✅ `create_jobs_table.php` (Queue pour conversions)

### 5.2 Exécuter les Migrations

**Via SSH** :
```bash
cd /home/laravel-app
php artisan migrate --force
```

**Via phpMyAdmin** (si pas de SSH) :

1. Vérifier si table `media` existe :
   ```sql
   SHOW TABLES LIKE 'media';
   ```

2. Si n'existe pas, créer manuellement :
   ```sql
   -- Copier le SQL depuis database/migrations/*_create_media_table.php
   -- et l'exécuter dans phpMyAdmin
   ```

### 5.3 Régénérer les Conversions d'Images

**Important** : Régénérer toutes les conversions pour les propriétés existantes

**Via SSH** :
```bash
cd /home/laravel-app
php artisan media-library:regenerate --force
```

**Résultat attendu** : Création automatique des conversions WebP (thumb, preview, optimized)

---

## 🔧 ÉTAPE 6 : OPTIMISATION POST-DÉPLOIEMENT

### 6.1 Vider les Caches

**Via SSH** :
```bash
cd /home/laravel-app

# Vider TOUS les caches
php artisan optimize:clear

# Reconstruire les caches de production
php artisan config:cache
php artisan route:cache
php artisan view:cache
php artisan event:cache
```

**Via File Manager** (si pas SSH) :

Supprimer manuellement :
- `/home/laravel-app/bootstrap/cache/config.php`
- `/home/laravel-app/bootstrap/cache/routes-v7.php`
- `/home/laravel-app/storage/framework/cache/*`
- `/home/laravel-app/storage/framework/views/*`

### 6.2 Optimiser Composer

```bash
cd /home/laravel-app
composer dump-autoload --optimize
```

### 6.3 Configurer Queue Worker (Important pour images)

**Option 1 : CRON Job (Recommandé)**

Via Panel LWS → Tâches CRON, ajouter :

```bash
* * * * * /usr/bin/php /home/laravel-app/artisan schedule:run >> /dev/null 2>&1
```

**Option 2 : Queue Worker Permanent**

Si LWS le permet (supervisor), créer :

```bash
php artisan queue:work --daemon --tries=3
```

**Option 3 : Mode Sync (Plus simple mais pas optimal)**

Dans `.env` :
```env
QUEUE_CONNECTION=sync
```

---

## ✅ ÉTAPE 7 : VÉRIFICATIONS & TESTS

### 7.1 Tests Fonctionnels

**Tester dans cet ordre** :

- [ ] **Page d'accueil**
  - URL : https://horizonimmo.zbinvestments-ci.com
  - Vérifier : Chargement complet, aucune erreur

- [ ] **Liste propriétés**
  - URL : /proprietes
  - Vérifier : Images s'affichent (preview WebP)

- [ ] **Détail propriété**
  - URL : /propriete/8 (ID existant)
  - Vérifier : Slider images fonctionne
  - Vérifier : Toutes images s'affichent
  - Vérifier : Pas d'erreur count()

- [ ] **Admin - Liste propriétés**
  - URL : /admin/properties
  - Vérifier : Images miniatures s'affichent

- [ ] **Admin - Détail propriété**
  - URL : /admin/properties/8
  - Vérifier : Image principale + grille miniatures

- [ ] **Upload nouvelle propriété**
  - URL : /admin/properties/create
  - Tester : Upload 5 images JPG
  - Vérifier : Message succès
  - Vérifier : Conversions créées (après traitement queue)

- [ ] **Emails**
  - Envoyer message test depuis /contact
  - Vérifier : Email reçu avec branding ZB Investments
  - Vérifier : Footer correct (pas dupliqué)

### 7.2 Vérifications Techniques

**Console navigateur (F12)** :
- [ ] Aucune erreur JavaScript
- [ ] Toutes images chargées (pas de 404)
- [ ] CSS chargé correctement

**Logs Laravel** :
```bash
# Via SSH
tail -f /home/laravel-app/storage/logs/laravel.log

# Ou via File Manager
# Télécharger et consulter storage/logs/laravel.log
```

- [ ] Aucune erreur PHP
- [ ] Aucune exception non gérée

**Performance** :
- [ ] Temps chargement < 3s
- [ ] Images WebP chargées (vérifier dans Network)

### 7.3 Test Upload Images Complet

1. **Créer une nouvelle propriété**
   - Aller sur `/admin/properties/create`
   - Remplir tous les champs
   - Uploader 5 images de test

2. **Vérifier conversions** (après quelques minutes)
   - Via File Manager : `/home/laravel-app/storage/app/public/XX/conversions/`
   - Vérifier présence de 15 fichiers WebP (5 images × 3 conversions)
   - Tailles attendues :
     - thumb : ~15-30 KB
     - preview : ~80-120 KB
     - optimized : ~150-250 KB

3. **Vérifier affichage**
   - Page liste : Image thumb
   - Page détail : Slider avec preview
   - Zoom modal : Image optimized

---

## 🐛 ÉTAPE 8 : RÉSOLUTION PROBLÈMES COURANTS

### Problème 1 : Erreur 500 après déploiement

**Causes possibles** :
- Cache corrompu
- Permissions incorrectes
- .env mal configuré

**Solutions** :
```bash
# Vider les caches
php artisan optimize:clear

# Vérifier permissions
chmod -R 775 storage bootstrap/cache

# Vérifier .env
php artisan config:show
```

### Problème 2 : Images ne s'affichent pas

**Vérifications** :
1. Lien symbolique storage existe ?
   - `/htdocs/storage` → `/home/laravel-app/storage/app/public`

2. Permissions correctes ?
   - `chmod 775 storage/app/public -R`

3. Conversions générées ?
   - `php artisan media-library:regenerate`

4. URLs correctes ?
   - Vérifier APP_URL dans .env

### Problème 3 : Upload images échoue

**Vérifications** :
1. Permissions storage ?
   - `chmod 775 storage/app/temp -R`

2. Créer dossier temp manuellement :
   ```bash
   mkdir -p /home/laravel-app/storage/app/temp
   chmod 775 /home/laravel-app/storage/app/temp
   ```

3. Taille limite PHP ?
   - Vérifier `upload_max_filesize = 10M` dans php.ini
   - Vérifier `post_max_size = 12M`

4. Queue fonctionne ?
   - Tester : `php artisan queue:work --once`

### Problème 4 : Conversions images non créées

**Solutions** :
1. Vérifier queue :
   ```bash
   php artisan queue:work --stop-when-empty
   ```

2. Mode sync temporaire :
   ```env
   QUEUE_CONNECTION=sync
   ```

3. Régénérer manuellement :
   ```bash
   php artisan media-library:regenerate --force
   ```

### Problème 5 : Emails non envoyés

**Vérifications** :
1. Configuration SMTP dans .env ?
2. Tester envoi :
   ```bash
   php artisan tinker
   >>> Mail::raw('Test', fn($m) => $m->to('test@example.com')->subject('Test'));
   ```

---

## 📝 ÉTAPE 9 : POST-DÉPLOIEMENT

### 9.1 Activer Mode Maintenance (Optionnel)

**Avant gros déploiements** :
```bash
php artisan down --message="Mise à jour en cours. Retour dans 30 minutes."
```

**Désactiver après** :
```bash
php artisan up
```

### 9.2 Monitoring Post-Déploiement

**Surveiller pendant 24-48h** :
- [ ] Logs erreurs (storage/logs/)
- [ ] Uptime serveur
- [ ] Temps réponse pages
- [ ] Messages contact (fonctionnent ?)
- [ ] Conversions images (se créent ?)

### 9.3 Documentation

**Créer note de version** :

```
Version 1.6.0 - 18 Octobre 2025

Nouveautés :
✅ Système upload 5 images optimisé
✅ Conversions WebP automatiques (3 tailles)
✅ Correction affichage images détails
✅ Emails avec branding ZB Investments
✅ Tests automatisés (8 tests PHPUnit)

Corrections :
✅ Erreur count() TypeError
✅ Images cassées liste/détails
✅ Footer emails dupliqué
✅ Upload fichiers sans extension

Améliorations :
✅ Performance images (WebP -85% poids)
✅ Traitement asynchrone conversions
✅ Documentation complète
```

---

## ⏱️ CHECKLIST FINALE

### Avant Déploiement
- [ ] Backup BDD créé et testé
- [ ] Backup fichiers créé
- [ ] Code local testé et fonctionnel
- [ ] Assets compilés (npm run build)
- [ ] Dépendances à jour

### Pendant Déploiement
- [ ] Fichiers uploadés (app, config, resources, vendor)
- [ ] Public uploadé (build, assets)
- [ ] .env vérifié et configuré
- [ ] Permissions storage/bootstrap (775)
- [ ] Migrations exécutées
- [ ] Lien symbolique storage créé

### Après Déploiement
- [ ] Caches vidés et reconstruits
- [ ] Conversions images régénérées
- [ ] Queue worker configuré
- [ ] Tests fonctionnels passés
- [ ] Logs vérifiés (aucune erreur)
- [ ] Performance vérifiée
- [ ] Documentation mise à jour

### Monitoring 24h
- [ ] Aucune erreur 500
- [ ] Images s'affichent partout
- [ ] Upload fonctionne
- [ ] Emails envoyés
- [ ] Conversions créées
- [ ] Pas de dégradation performance

---

## 🆘 ROLLBACK (En cas de problème)

### Si problème critique rencontré

1. **Restaurer BDD** :
   ```bash
   mysql -h 91.216.107.186 -u zbinv2677815 -p zbinv2677815 < backup_18oct2025.sql
   ```

2. **Restaurer fichiers** :
   - Via FTP, restaurer depuis `C:\Backups\horizonimmo_18oct2025\`

3. **Vider caches** :
   ```bash
   php artisan optimize:clear
   ```

4. **Investiguer** :
   - Consulter logs
   - Identifier cause
   - Corriger en local
   - Re-déployer

---

## 📞 SUPPORT

En cas de problème :
- **Email** : webmaster@zbinvestments-ci.com
- **Téléphone** : +225 07 07 69 69 14
- **Documentation** : Consulter fichiers CORRECTIF_*.md

---

*Guide créé le 18 octobre 2025*
*Pour HorizonImmo / ZB Investments*
*Version site : 1.5.0 → 1.6.0*
