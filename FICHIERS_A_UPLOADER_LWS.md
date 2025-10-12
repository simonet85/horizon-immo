# 📤 Fichiers à uploader sur le serveur LWS

## 🎯 Objectif

Liste complète des fichiers de configuration et de test à transférer sur votre serveur LWS pour finaliser le déploiement.

---

## 📋 Liste des fichiers

### 1️⃣ Fichier de test de la queue (OBLIGATOIRE)

**Fichier** : `test-queue-lws.php`
**Destination sur LWS** : `/home/zbinv2677815/laravel-app/test-queue-lws.php`
**Usage** : Vérifier que la configuration de la queue fonctionne correctement

**Comment uploader** :
```bash
# Via FTP/SFTP avec FileZilla
# Ou via SSH :
scp test-queue-lws.php zbinv2677815@webdb29.lws-hosting.com:/home/zbinv2677815/laravel-app/

# Puis exécuter :
ssh zbinv2677815@webdb29.lws-hosting.com
cd laravel-app
php test-queue-lws.php
```

### 2️⃣ Documentation (RECOMMANDÉ)

Ces fichiers sont pour votre référence et celle de votre équipe :

| Fichier | Description | À garder localement | À uploader sur LWS |
|---------|-------------|---------------------|---------------------|
| `CLAUDE.md` | Guide complet hébergement LWS | ✅ Oui | ⚠️ Optionnel |
| `INSTRUCTIONS_MAIL_LWS.md` | Instructions config email | ✅ Oui | ⚠️ Optionnel |
| `RECAPITULATIF_SMTP_LWS.md` | Récap config SMTP | ✅ Oui | ❌ Non (sensible) |
| `CONFIGURATION_QUEUE_LWS.md` | Guide config queue complète | ✅ Oui | ⚠️ Optionnel |
| `GUIDE_RAPIDE_CRON_LWS.md` | Guide rapide CRON | ✅ Oui | ⚠️ Optionnel |
| `FICHIERS_A_UPLOADER_LWS.md` | Ce fichier | ✅ Oui | ❌ Non |

**💡 Recommandation** : Gardez ces fichiers **uniquement en local** ou dans un dossier privé non accessible via web (pas dans `/htdocs/`).

### 3️⃣ Scripts de configuration (SENSIBLES - NE PAS UPLOADER)

| Fichier | Usage | À uploader ? |
|---------|-------|--------------|
| `set-mail-env.bat` | Configuration env Windows | ❌ **NON** (local uniquement) |
| `test-mail-config.php` | Test config mail local | ❌ **NON** (sensible) |
| `test-email-send.php` | Test envoi email local | ❌ **NON** (sensible) |
| `cleanup-test-files.bat` | Nettoyage fichiers test | ❌ **NON** (Windows uniquement) |

**⚠️ IMPORTANT** : Ces fichiers contiennent des informations sensibles (mots de passe). Ne les uploadez JAMAIS sur le serveur de production.

---

## 🚀 Procédure d'upload complète

### Étape 1 : Préparer les fichiers

1. **Fichier obligatoire à uploader** :
   - ✅ `test-queue-lws.php`

2. **Fichiers optionnels** (documentation) :
   - `CONFIGURATION_QUEUE_LWS.md`
   - `GUIDE_RAPIDE_CRON_LWS.md`

### Étape 2 : Upload via FTP/SFTP

#### Avec FileZilla :

1. **Connexion** :
   - Hôte : `ftp.zbinvestments-ci.com` ou `webdb29.lws-hosting.com`
   - Utilisateur : `zbinv2677815`
   - Mot de passe : Votre mot de passe LWS
   - Port : `21` (FTP) ou `22` (SFTP)

2. **Navigation** :
   - Allez dans : `/home/zbinv2677815/laravel-app/`

3. **Upload** :
   - Glissez-déposez `test-queue-lws.php`

#### Avec WinSCP :

Même configuration que FileZilla.

### Étape 3 : Upload via SSH (Alternative)

```bash
# Depuis votre machine Windows
scp c:\laragon\www\HorizonImmo\test-queue-lws.php zbinv2677815@webdb29.lws-hosting.com:/home/zbinv2677815/laravel-app/
```

### Étape 4 : Définir les permissions

```bash
# Se connecter en SSH
ssh zbinv2677815@webdb29.lws-hosting.com

# Aller dans le dossier Laravel
cd laravel-app

# Rendre le script exécutable
chmod +x test-queue-lws.php

# Exécuter le script de test
php test-queue-lws.php
```

---

## 🔍 Vérification post-upload

### Test 1 : Vérifier que le fichier est bien présent

```bash
ssh zbinv2677815@webdb29.lws-hosting.com
ls -lh /home/zbinv2677815/laravel-app/test-queue-lws.php
```

**Résultat attendu** :
```
-rwxr-xr-x 1 zbinv2677815 zbinv2677815 5.2K Oct 11 21:45 test-queue-lws.php
```

### Test 2 : Exécuter le script de test

```bash
cd /home/zbinv2677815/laravel-app
php test-queue-lws.php
```

**Résultat attendu** :
```
=======================================================
TEST DE CONFIGURATION QUEUE - ZB INVESTMENTS
=======================================================

1. Configuration de la queue
   QUEUE_CONNECTION: database
   Driver utilisé: database

2. Connexion base de données
   ✅ Connexion DB réussie
   Base: zbinv2677815

3. Table jobs
   ✅ Table 'jobs' existe
   Jobs en attente: 0

[...]

🎉 Tout est prêt ! La queue peut être configurée dans LWS Panel.
```

Si vous voyez des ❌, corrigez les problèmes avant de continuer.

---

## 📊 Checklist complète de déploiement

### Avant l'upload :

- [ ] ✅ Fichier `test-queue-lws.php` préparé
- [ ] ✅ Connexion FTP/SSH testée
- [ ] ✅ Backup de la base de données fait
- [ ] ⚠️ Vérifier que `.env` sur LWS contient les bonnes valeurs SMTP

### Après l'upload :

- [ ] ✅ `test-queue-lws.php` uploadé dans `/home/zbinv2677815/laravel-app/`
- [ ] ✅ Script exécuté : `php test-queue-lws.php`
- [ ] ✅ Tous les tests passent (✅ verts)
- [ ] ✅ Tâche CRON créée dans le Panel LWS
- [ ] ✅ Tâche CRON active
- [ ] ✅ Test d'envoi de message effectué
- [ ] ✅ Email reçu avec succès

### Nettoyage final :

- [ ] Supprimer `test-queue-lws.php` du serveur après validation (optionnel mais recommandé)
- [ ] Conserver une copie locale de tous les fichiers de documentation
- [ ] Sauvegarder les credentials LWS dans un endroit sûr

---

## 🗂️ Structure finale sur LWS

Après le déploiement complet, votre arborescence devrait ressembler à :

```
/home/zbinv2677815/
│
├── laravel-app/                    # Application Laravel complète
│   ├── app/
│   ├── bootstrap/
│   │   └── cache/                  # Permissions 775
│   ├── config/
│   ├── database/
│   ├── resources/
│   ├── routes/
│   ├── storage/                    # Permissions 775
│   │   ├── app/
│   │   ├── framework/
│   │   └── logs/
│   ├── vendor/
│   ├── .env                        # ✅ Config production avec LWS SMTP
│   ├── artisan
│   ├── composer.json
│   └── test-queue-lws.php          # ✅ Script de test (à supprimer après)
│
└── htdocs/                         # Dossier public web
    ├── build/                      # Assets compilés
    ├── .htaccess                   # Config Apache
    ├── index.php                   # ✅ Modifié pour pointer vers laravel-app
    ├── favicon.ico
    └── robots.txt
```

---

## ⚠️ Fichiers à NE JAMAIS uploader

Ces fichiers doivent rester **UNIQUEMENT sur votre machine locale** :

1. ❌ `.env.local` ou `.env.backup` (contiennent vos credentials locaux)
2. ❌ `set-mail-env.bat` (contient mot de passe email)
3. ❌ `test-mail-config.php` (expose la config email)
4. ❌ `test-email-send.php` (peut être utilisé pour spam)
5. ❌ `database_backup.sql` (données sensibles)
6. ❌ `RECAPITULATIF_SMTP_LWS.md` (contient credentials)
7. ❌ Tous les fichiers `.bat` (Windows uniquement)

**Règle d'or** : Si un fichier contient des mots de passe ou credentials, ne l'uploadez PAS sur le serveur de production.

---

## 🔐 Sécurité

### Fichiers sensibles sur LWS :

1. **`.env`** :
   - ✅ Doit être présent dans `/home/zbinv2677815/laravel-app/.env`
   - ✅ Permissions : `644` (lecture seule pour les autres)
   - ❌ Ne JAMAIS le placer dans `/htdocs/` (accessible via web)

2. **`storage/`** :
   - ✅ Doit rester dans `/home/zbinv2677815/laravel-app/storage/`
   - ❌ Ne JAMAIS exposer via web

3. **Logs** :
   - ✅ Consultables via SSH : `tail -f storage/logs/laravel.log`
   - ❌ Ne JAMAIS les rendre publics

### Commandes de sécurité :

```bash
# Vérifier que .env n'est pas accessible via web
curl https://zbinvestments-ci.com/.env
# Devrait retourner 404 ou 403

# Vérifier les permissions
ls -lh /home/zbinv2677815/laravel-app/.env
# Devrait afficher : -rw-r--r--

# Protéger .env si nécessaire
chmod 644 /home/zbinv2677815/laravel-app/.env
```

---

## 📞 Support et aide

### Si vous rencontrez des problèmes lors de l'upload :

1. **Problème de connexion FTP/SSH** :
   - Vérifier les credentials dans le Panel LWS
   - Essayer SFTP (port 22) au lieu de FTP (port 21)

2. **Permissions refusées** :
   - Utiliser SSH pour modifier les permissions : `chmod 755 fichier`
   - Contacter le support LWS si problème persiste

3. **Script de test échoue** :
   - Consulter les logs : `tail -f storage/logs/laravel.log`
   - Vérifier que toutes les migrations sont exécutées : `php artisan migrate:status`

### Contacts :

- **Support LWS** : https://panel.lws.fr (ouvrir un ticket)
- **Documentation LWS** : https://aide.lws.fr
- **Documentation Laravel** : https://laravel.com/docs

---

## ✅ Validation finale

Avant de passer à la configuration CRON :

- [ ] ✅ `test-queue-lws.php` uploadé et exécuté avec succès
- [ ] ✅ Tous les tests du script sont au vert (✅)
- [ ] ✅ Configuration SMTP LWS vérifiée (mail.zbinvestments-ci.com)
- [ ] ✅ Table `jobs` existe et est accessible
- [ ] ✅ Permissions correctes sur `storage/` (775)
- [ ] ✅ Connexion base de données fonctionne
- [ ] ✅ `.env` sur LWS contient les bonnes valeurs

**Si tout est ✅ : Vous pouvez passer à la configuration de la tâche CRON !**

Consultez le fichier `GUIDE_RAPIDE_CRON_LWS.md` pour les instructions.

---

*Documentation pour ZB Investments - Octobre 2025*
*Déploiement sur LWS Panel*
