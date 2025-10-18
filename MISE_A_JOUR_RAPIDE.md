# 🚀 MISE À JOUR RAPIDE DU PROJET SUR LWS

## ⚡ Méthode 1 : SSH + Git (Recommandé - 2 minutes)

### Sur Laragon (votre PC)

```bash
# 1. Commit et push
git add .
git commit -m "Update: ZB Investments branding + dynamic towns + email BCC"
git push origin main
```

### Sur LWS (serveur)

```bash
# 2. Connexion SSH
ssh zbinv2677815@ssh.horizonimmo.com

# 3. Mise à jour du code
cd /home/zbinv2677815/laravel-app
git pull origin main

# 4. Vider les caches
php artisan config:clear && php artisan cache:clear && php artisan view:clear && php artisan route:clear

# 5. Reconstruire les caches (optionnel mais recommandé)
php artisan config:cache && php artisan route:cache && php artisan view:cache
```

### ✅ Terminé ! Votre site est à jour.

---

## 📁 Méthode 2 : FTP via FileZilla (Alternative - 10 minutes)

### Étape 1 : Connexion FTP

1. Ouvrir **FileZilla**
2. **Hôte** : `ftp.horizonimmo.com` ou `ftp.zbinvestments-ci.com`
3. **Utilisateur** : `zbinv2677815`
4. **Mot de passe** : Votre mot de passe FTP
5. **Port** : `21`
6. Cliquer sur **Connexion rapide**

### Étape 2 : Upload des fichiers modifiés

Uploader ces fichiers depuis votre PC vers LWS :

#### 📂 Notifications (4 fichiers)
```
Local  : C:\laragon\www\HorizonImmo\app\Notifications\
LWS    : /home/zbinv2677815/laravel-app/app/Notifications/

✅ AdminResponseNotification.php
✅ NewContactMessage.php
✅ NewPropertyMessage.php
✅ NewAccompanimentRequestNotification.php (NOUVEAU)
```

#### 📂 Livewire (1 fichier)
```
Local  : C:\laragon\www\HorizonImmo\app\Livewire\
LWS    : /home/zbinv2677815/laravel-app/app/Livewire/

✅ AccompanimentForm.php
```

#### 📂 Templates Email (tout le dossier)
```
Local  : C:\laragon\www\HorizonImmo\resources\views\vendor\mail\
LWS    : /home/zbinv2677815/laravel-app/resources/views/vendor/mail/

✅ html/message.blade.php
✅ text/message.blade.php
✅ (uploader tout le dossier si inexistant sur LWS)
```

#### 📂 Vue Livewire (1 fichier)
```
Local  : C:\laragon\www\HorizonImmo\resources\views\livewire\
LWS    : /home/zbinv2677815/laravel-app/resources/views/livewire/

✅ accompaniment-form.blade.php
```

### Étape 3 : Vider les caches

#### Option A : Via SSH (recommandé)
```bash
ssh zbinv2677815@ssh.horizonimmo.com
cd /home/zbinv2677815/laravel-app
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

#### Option B : Via script PHP (si pas de SSH)

1. Uploader `clear-cache-lws.php` dans `/htdocs/`
2. Accéder à : `https://votre-domaine.com/clear-cache-lws.php`
3. **⚠️ SUPPRIMER** le fichier après utilisation !

---

## 📋 Résumé des modifications

### ✅ Ce qui a changé :

1. **Branding ZB Investments**
   - Tous les emails utilisent "ZB Investments" au lieu de "Horizon Immo"
   - Footer des emails avec les numéros de téléphone :
     - Côte d'Ivoire: +225 07 07 69 69 14 | +225 05 45 01 01 99
     - Afrique du Sud: +27 65 86 87 861

2. **Villes dynamiques**
   - Le formulaire d'accompagnement charge les villes depuis la base de données
   - Plus besoin de modifier le code pour ajouter une ville

3. **Copie BCC des emails**
   - Tous les emails sont copiés vers `info@zbinvestments-ci.com`
   - Vous recevez maintenant toutes les communications client

---

## 🧪 Tests après mise à jour

### 1. Tester le formulaire d'accompagnement
- Aller sur : `/accompagnement`
- Vérifier que les villes s'affichent dans le select "Ville souhaitée"

### 2. Tester l'envoi d'email
- Créer un message de contact test
- Vérifier votre boîte `info@zbinvestments-ci.com`
- Vérifier que le footer affiche "ZB Investments" et les téléphones

### 3. Vérifier les caches
Si les changements ne s'affichent pas, vider les caches à nouveau :
```bash
php artisan optimize:clear
```

---

## ❓ FAQ - Problèmes courants

### Les changements ne s'affichent pas
**Solution** : Vider les caches Laravel
```bash
php artisan config:clear
php artisan cache:clear
php artisan view:clear
```

### Erreur 500 après upload
**Solution** : Vérifier les permissions
```bash
chmod -R 775 /home/zbinv2677815/laravel-app/storage
chmod -R 775 /home/zbinv2677815/laravel-app/bootstrap/cache
```

### Les villes ne s'affichent pas dans le formulaire
**Cause** : La table `towns` est vide
**Solution** : Exécuter le seeder
```bash
php artisan db:seed --class=TownSeeder
```

### Je ne reçois pas les emails
**Vérifier** :
1. Configuration `.env` : `MAIL_FROM_ADDRESS=info@zbinvestments-ci.com`
2. Les logs : `/home/zbinv2677815/laravel-app/storage/logs/laravel.log`
3. Vider le cache : `php artisan config:clear`

---

## 📞 Support

**En cas de problème** :
1. Consulter les logs : `/home/zbinv2677815/laravel-app/storage/logs/laravel.log`
2. Vérifier les guides de déploiement : `GUIDE_SSH_GIT_LWS.md`
3. Contacter le support LWS

---

**Date de mise à jour** : 17 octobre 2025
**Version** : 1.0.0 - ZB Investments Rebranding
