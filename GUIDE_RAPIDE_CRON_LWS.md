# 🚀 Guide Rapide - Configuration CRON Queue sur LWS

## 📋 En 5 étapes simples

### Étape 1️⃣ : Se connecter au Panel LWS

1. Allez sur : **https://panel.lws.fr**
2. Connectez-vous avec vos identifiants

### Étape 2️⃣ : Accéder aux tâches CRON

1. Dans le menu de gauche, cherchez : **"Tâches planifiées"** ou **"CRON Jobs"**
2. Cliquez sur **"Ajouter une nouvelle tâche"** ou **"Nouvelle tâche CRON"**

### Étape 3️⃣ : Configurer la tâche

Remplissez le formulaire comme suit :

#### Champs de fréquence :
```
Minute          : *
Heure           : *
Jour du mois    : *
Mois            : *
Jour de semaine : *
```

**Signification** : La tâche s'exécutera **toutes les minutes**

#### Champ commande :

**✅ COMMANDE VÉRIFIÉE SUR VOTRE SERVEUR** :

```bash
/usr/base/opt/php8.3/bin/php /home/laravel-app/artisan queue:work --stop-when-empty --max-time=230 --tries=3 2>&1
```

**ℹ️ Explication** :
- `/usr/base/opt/php8.3/bin/php` = Chemin vers PHP 8.3.25 sur votre serveur LWS ✅
- `/home/laravel-app/artisan` = Chemin vers votre application Laravel ✅
- `queue:work` = Commande Laravel pour traiter la queue
- `--stop-when-empty` = ⚠️ **CRUCIAL** - S'arrête quand il n'y a plus de jobs
- `--max-time=230` = Timeout de 230 secondes (3 min 50s, sous la limite de 4 min LWS)
- `--tries=3` = Réessaye 3 fois en cas d'échec
- `2>&1` = Capture les erreurs pour debug

#### Options supplémentaires :
- **Email notification** : ❌ **Décochez** (sinon vous recevrez un email à chaque minute)

### Étape 4️⃣ : Enregistrer

1. Cliquez sur **"Enregistrer"** ou **"Créer"**
2. Vérifiez que la tâche apparaît dans la liste avec le statut **"Actif"**

### Étape 5️⃣ : Vérifier le fonctionnement

#### Option A : Via le Panel LWS
1. Attendez 2-3 minutes
2. Allez dans **"Historique des tâches CRON"** ou **"Logs CRON"**
3. Vérifiez qu'il n'y a pas d'erreurs

#### Option B : Via SSH
```bash
# Se connecter en SSH
ssh zbinv2677815@webdb29.lws-hosting.com

# Aller dans le dossier Laravel
cd laravel-app

# Vérifier les jobs en attente
php artisan tinker --execute="echo 'Jobs: ' . DB::table('jobs')->count();"

# Consulter les logs
tail -n 50 storage/logs/laravel.log
```

---

## ✅ Comment vérifier que ça fonctionne ?

### Test complet :

1. **Envoyez un message via le formulaire de contact** sur votre site
2. Vérifiez dans la base de données (table `jobs`) :
   ```sql
   SELECT COUNT(*) FROM jobs;
   ```
3. Attendez **1 minute maximum**
4. Re-vérifiez la table `jobs` (devrait être vide ou avoir moins de jobs)
5. Vérifiez votre boîte email admin : vous devriez avoir reçu la notification

### Commandes de vérification rapides :

```bash
# Voir combien de jobs sont en attente
php artisan tinker --execute="echo DB::table('jobs')->count();"

# Voir les jobs échoués
php artisan queue:failed

# Tester manuellement (si vous voulez forcer le traitement)
php artisan queue:work --stop-when-empty
```

---

## 📋 Informations vérifiées sur votre serveur

D'après l'exécution du script `test-queue-lws.php` :

| Paramètre | Valeur vérifiée |
|-----------|-----------------|
| **Chemin PHP** | `/usr/base/opt/php8.3/bin/php` ✅ |
| **Version PHP** | `8.3.25` ✅ |
| **Chemin Laravel** | `/home/laravel-app` ✅ |
| **Configuration queue** | `database` ✅ |
| **Base de données** | `zbinv2677815` ✅ |
| **Table jobs** | Existe ✅ |
| **Permissions storage** | `755` ✅ |
| **Permissions bootstrap/cache** | `755` ✅ |
| **SMTP LWS** | `mail.zbinvestments-ci.com` ✅ |

---

## 🎯 Commandes CRON alternatives

### Si vous avez beaucoup d'emails (configuration agressive) :

**Toutes les 30 secondes** (nécessite 2 tâches CRON) :

Tâche 1 :
```
Minute: */1
Commande: /usr/base/opt/php8.3/bin/php /home/laravel-app/artisan queue:work --stop-when-empty --max-time=25 --tries=3 2>&1
```

Tâche 2 (décalée de 30 secondes) :
```
Minute: */1
Commande: sleep 30 && /usr/base/opt/php8.3/bin/php /home/laravel-app/artisan queue:work --stop-when-empty --max-time=25 --tries=3 2>&1
```

### Si vous avez peu d'emails (configuration économique) :

**Toutes les 5 minutes** :
```
Minute: */5
Commande: /usr/base/opt/php8.3/bin/php /home/laravel-app/artisan queue:work --stop-when-empty --max-time=280 --tries=3 2>&1
```

---

## ❌ Erreurs courantes

### Erreur 1 : "php: command not found"

**Cause** : Mauvais chemin PHP
**Solution** : Utiliser le chemin complet trouvé avec `which php`

### Erreur 2 : "artisan: No such file or directory"

**Cause** : Mauvais chemin Laravel
**Solution** : Vérifier avec `ls /home/laravel-app/artisan`

### Erreur 3 : La tâche s'exécute mais les jobs ne sont pas traités

**Causes possibles** :
- Queue connection incorrecte dans `.env` (doit être `database`)
- Table `jobs` manquante (exécuter `php artisan migrate`)
- Permissions insuffisantes sur `storage/`

**Solution** : Uploader et exécuter le script `test-queue-lws.php`

```bash
php test-queue-lws.php
```

### Erreur 4 : "Too many connections"

**Cause** : Plusieurs instances de queue:work qui tournent en même temps
**Solution** : Utiliser `--stop-when-empty` (déjà dans la commande recommandée)

---

## 📊 Tableau récapitulatif

| Fréquence | Cas d'usage | Commande Minute | Max Time |
|-----------|-------------|-----------------|----------|
| **Toutes les minutes** | ✅ Recommandé | `*` | `230` |
| Toutes les 2 minutes | Trafic moyen | `*/2` | `230` |
| Toutes les 5 minutes | Faible trafic | `*/5` | `230` |
| Toutes les 15 minutes | Très faible trafic | `*/15` | `230` |

**Note** : Le `max-time` est fixé à 230 secondes (3 min 50s) pour rester sous la limite LWS de 4 minutes.

---

## 📞 Aide supplémentaire

### Documentation LWS :
- Panel CRON : https://panel.lws.fr
- Support : https://aide.lws.fr/a/892

### Documentation Laravel :
- Queue : https://laravel.com/docs/queues

### Fichiers utiles dans votre projet :
- Guide complet : `CONFIGURATION_QUEUE_LWS.md`
- Script de test : `test-queue-lws.php`
- Instructions email : `INSTRUCTIONS_MAIL_LWS.md`

---

## ✅ Validation finale

Après avoir configuré la tâche CRON, cochez ces vérifications :

- [ ] La tâche CRON est créée dans le Panel LWS
- [ ] La tâche est active (pas en pause)
- [ ] La commande contient bien `--stop-when-empty`
- [ ] Les notifications email du CRON sont désactivées
- [ ] Vous avez attendu 2-3 minutes
- [ ] Vous avez envoyé un message test
- [ ] Le message test a été reçu par email
- [ ] Il n'y a pas d'erreurs dans les logs

**Si toutes les cases sont cochées : 🎉 C'EST BON !**

---

*Configuration pour ZB Investments - Octobre 2025*
*Support : info@zbinvestments-ci.com*
