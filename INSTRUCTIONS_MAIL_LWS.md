# Instructions pour finaliser la configuration email LWS

## ✅ Ce qui a été fait

Les variables d'environnement système Windows ont été configurées avec les paramètres SMTP de LWS :

```
MAIL_HOST=mail.zbinvestments-ci.com
MAIL_PORT=587
MAIL_USERNAME=info@zbinvestments-ci.com
MAIL_PASSWORD=qH4-G3bJrZKhwkK
MAIL_ENCRYPTION=tls
MAIL_FROM_ADDRESS=info@zbinvestments-ci.com
MAIL_FROM_NAME=ZB Investments
```

## 🔄 Prochaines étapes (OBLIGATOIRES)

### 1. Redémarrer Laragon

**IMPORTANT** : Les variables d'environnement ne seront actives qu'après le redémarrage !

1. Ouvrir Laragon
2. Cliquer sur **"Tout arrêter"** ou **"Stop All"**
3. Attendre quelques secondes
4. Cliquer sur **"Tout démarrer"** ou **"Start All"**

### 2. Vérifier la configuration

Après le redémarrage de Laragon, ouvrir un nouveau terminal et exécuter :

```bash
cd c:\laragon\www\HorizonImmo
php test-mail-config.php
```

**Résultat attendu** : Vous devriez maintenant voir `mail.zbinvestments-ci.com` au lieu de `sandbox.smtp.mailtrap.io`

### 3. Vider les caches Laravel

```bash
php artisan config:clear
php artisan cache:clear
php artisan config:cache
```

### 4. Tester l'envoi d'email

```bash
php test-email-send.php
```

Ce script va :
- Afficher la configuration email actuelle
- Envoyer un email de test
- Confirmer si l'envoi a réussi

### 5. Traiter les messages en queue

Si des messages sont en attente d'envoi dans la queue :

```bash
php artisan queue:work --tries=3 --timeout=90
```

Ou pour traiter tous les jobs en attente puis arrêter :

```bash
php artisan queue:work --stop-when-empty
```

### 6. Vérifier les logs

```bash
tail -n 100 storage/logs/laravel.log
```

Vous devriez voir des connexions à `mail.zbinvestments-ci.com:587` au lieu de Mailtrap.

## 🔍 Diagnostic des problèmes

### Si la configuration affiche toujours Mailtrap après le redémarrage

1. Vérifier que les variables système sont bien créées :
```bash
powershell -Command "[System.Environment]::GetEnvironmentVariable('MAIL_HOST', 'User')"
```
Devrait afficher : `mail.zbinvestments-ci.com`

2. Si les variables sont absentes, ré-exécuter le script (en tant qu'administrateur si nécessaire) :
```bash
set-mail-env.bat
```

3. Redémarrer à nouveau Laragon

### Si les emails ne sont pas envoyés

1. Vérifier les credentials dans le panneau LWS
2. Tester la connexion SMTP avec un client mail (Thunderbird, Outlook)
3. Vérifier que le port 587 n'est pas bloqué par un firewall
4. Consulter les logs Laravel pour les erreurs SMTP détaillées

## 📋 Fichiers créés

- `set-mail-env.bat` - Script pour définir les variables d'environnement
- `test-mail-config.php` - Script pour vérifier la configuration
- `test-email-send.php` - Script pour tester l'envoi d'email
- `INSTRUCTIONS_MAIL_LWS.md` - Ce fichier d'instructions

## 🎯 Objectif final

Les emails de contact et notifications de propriété doivent être envoyés via le serveur SMTP de LWS (`mail.zbinvestments-ci.com`) avec l'adresse expéditeur `info@zbinvestments-ci.com`.

---

**Note** : Le redémarrage de Laragon est obligatoire car Windows ne charge les nouvelles variables d'environnement système que lors du démarrage d'un nouveau processus.
