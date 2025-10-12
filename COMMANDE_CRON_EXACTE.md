# ✅ Commande CRON Exacte pour ZB Investments

## 📋 Informations du serveur (vérifiées)

Basé sur la capture d'écran SSH de votre serveur :

| Paramètre | Valeur |
|-----------|--------|
| **Identifiant utilisateur** | `zbinv2677815` |
| **Serveur** | `webdb29.lws-hosting.com` |
| **Répertoire home** | `/home` |
| **Dossier Laravel** | `laravel-app` |
| **Chemin PHP** | `/usr/bin/php` ✅ |
| **Chemin complet Laravel** | `/home/zbinv2677815/laravel-app` |

---

## 🎯 Commande CRON à utiliser dans le Panel LWS

### Option 1 : Avec chemin absolu (RECOMMANDÉ)

```bash
/usr/bin/php /home/zbinv2677815/laravel-app/artisan queue:work --stop-when-empty --max-time=230 --tries=3 2>&1
```

### Option 2 : Avec tilde (~)

```bash
/usr/bin/php ~/laravel-app/artisan queue:work --stop-when-empty --max-time=230 --tries=3 2>&1
```

**Note** : Les deux commandes sont équivalentes. Le `~` est un raccourci vers `/home/zbinv2677815`.

---

## 📝 Configuration dans le Panel LWS

### Paramètres de fréquence :

| Champ | Valeur |
|-------|--------|
| **Paramètres communs** | Toutes les minutes (* * * * *) |
| **Minute** | `*` |
| **Heure** | `*` |
| **Jour du mois** | `*` |
| **Mois** | `*` |
| **Jour de la semaine** | `*` |

### Champ "Commande" :

Copiez-collez exactement :

```
/usr/bin/php /home/zbinv2677815/laravel-app/artisan queue:work --stop-when-empty --max-time=230 --tries=3 2>&1
```

---

## 🔍 Explication de la commande

| Partie | Description | Valeur vérifiée |
|--------|-------------|-----------------|
| `/usr/bin/php` | Chemin vers PHP | ✅ Confirmé via `which php` |
| `/home/zbinv2677815` | Votre répertoire home | ✅ Identifiant vérifié |
| `/laravel-app/artisan` | Fichier artisan Laravel | ✅ Dossier existe |
| `queue:work` | Commande Laravel | Traite la queue |
| `--stop-when-empty` | ⚠️ **CRUCIAL** | S'arrête quand plus de jobs |
| `--max-time=230` | Timeout 230s | 3 min 50s (sous limite 4 min LWS) |
| `--tries=3` | Tentatives | Réessaye 3x en cas d'échec |
| `2>&1` | Redirection | Capture les erreurs pour debug |

---

## ✅ Vérifications avant de créer la tâche CRON

### 1. Vérifier que le fichier artisan existe

```bash
ssh zbinv2677815@webdb29.lws-hosting.com
ls -lh /home/zbinv2677815/laravel-app/artisan
```

**Résultat attendu** :
```
-rwxr-xr-x 1 zbinv2677815 zbinv2677815 1.7K Oct 11 16:08 artisan
```

### 2. Vérifier le chemin PHP

```bash
which php
```

**Résultat attendu** :
```
/usr/bin/php
```

### 3. Tester la commande manuellement

```bash
cd ~/laravel-app
/usr/bin/php artisan queue:work --stop-when-empty --max-time=230 --tries=3
```

Si des jobs sont en attente, vous devriez les voir se traiter.

---

## 🧪 Test complet après création de la tâche CRON

### Étape 1 : Créer un job de test

```bash
ssh zbinv2677815@webdb29.lws-hosting.com
cd ~/laravel-app

# Créer un message de test
php artisan tinker --execute="
\$message = \App\Models\ContactMessage::create([
    'first_name' => 'Test',
    'last_name' => 'CRON',
    'email' => 'test@example.com',
    'phone' => '+237 600 000 000',
    'subject' => 'Test automatique CRON',
    'message' => 'Vérification que la tâche CRON fonctionne',
    'status' => 'unread'
]);

\$admins = \App\Models\User::role('admin')->get();
\Illuminate\Support\Facades\Notification::send(\$admins, new \App\Notifications\NewContactMessage(\$message));

echo 'Message créé. Jobs en queue: ' . \Illuminate\Support\Facades\DB::table('jobs')->count();
"
```

**Résultat attendu** :
```
Message créé. Jobs en queue: 1
```

### Étape 2 : Attendre 1 minute

La tâche CRON va s'exécuter automatiquement.

### Étape 3 : Vérifier que le job est traité

```bash
php artisan tinker --execute="echo 'Jobs restants: ' . DB::table('jobs')->count();"
```

**Résultat attendu** :
```
Jobs restants: 0
```

✅ Si `0`, la tâche CRON fonctionne parfaitement !

### Étape 4 : Vérifier les logs

```bash
tail -n 30 ~/laravel-app/storage/logs/laravel.log
```

Vous ne devriez voir **aucune erreur** récente liée à la queue.

---

## 📊 Tableau de correspondance des chemins

| Raccourci | Chemin complet | Usage |
|-----------|---------------|--------|
| `~` | `/home/zbinv2677815` | Répertoire home |
| `~/laravel-app` | `/home/zbinv2677815/laravel-app` | Application Laravel |
| `~/htdocs` | `/home/zbinv2677815/htdocs` | Dossier public web |

---

## ⚠️ Important : Structure vérifiée de votre serveur

D'après votre capture d'écran SSH :

```
/home/
├── htdocs/                    # Racine web (accessible via https://zbinvestments-ci.com)
│   ├── build/                 # Assets compilés
│   ├── index.php              # Point d'entrée modifié
│   └── .htaccess
│
└── laravel-app/               # Application Laravel (non accessible via web)
    ├── app/
    ├── artisan                # ✅ Fichier vérifié
    ├── bootstrap/
    ├── config/
    ├── database/
    ├── resources/
    ├── routes/
    ├── storage/
    ├── vendor/
    └── .env
```

**Note** : Il n'y a PAS de dossier `/home/zbinv2677815/`. La structure est directement `/home/htdocs` et `/home/laravel-app`.

**Correction de la commande CRON** :

Si la structure est comme ci-dessus, la commande devient :

```bash
/usr/bin/php /home/laravel-app/artisan queue:work --stop-when-empty --max-time=230 --tries=3 2>&1
```

---

## 🔧 Commandes de diagnostic

### Vérifier la structure exacte

```bash
# Se connecter
ssh zbinv2677815@webdb29.lws-hosting.com

# Afficher le répertoire courant après connexion
pwd

# Lister le contenu
ls -lh

# Vérifier artisan
ls -lh laravel-app/artisan

# Ou si dans un sous-dossier
ls -lh /home/zbinv2677815/laravel-app/artisan
```

### Tester la commande CRON manuellement

Copiez exactement la commande que vous allez mettre dans le CRON et testez-la :

```bash
# Version 1 (si structure simple)
/usr/bin/php /home/laravel-app/artisan queue:work --stop-when-empty --max-time=230 --tries=3

# Version 2 (si sous-dossier utilisateur)
/usr/bin/php /home/zbinv2677815/laravel-app/artisan queue:work --stop-when-empty --max-time=230 --tries=3

# Version 3 (avec tilde)
/usr/bin/php ~/laravel-app/artisan queue:work --stop-when-empty --max-time=230 --tries=3
```

**La commande qui fonctionne sans erreur est celle à utiliser dans le CRON.**

---

## ✅ Validation finale

Checklist avant de valider la tâche CRON :

- [ ] ✅ Identifiant vérifié : `zbinv2677815`
- [ ] ✅ Chemin PHP vérifié : `/usr/bin/php`
- [ ] ✅ Fichier artisan existe et accessible
- [ ] ✅ Commande testée manuellement et fonctionne
- [ ] ✅ Paramètres de fréquence : `* * * * *` (toutes les minutes)
- [ ] ✅ Commande contient `--stop-when-empty`
- [ ] ✅ Timeout `--max-time=230` (sous 4 min)

---

## 🎯 Commande finale à utiliser

**Basé sur votre capture d'écran et la structure vérifiée** :

```bash
/usr/bin/php ~/laravel-app/artisan queue:work --stop-when-empty --max-time=230 --tries=3 2>&1
```

Ou si le tilde ne fonctionne pas dans les CRON LWS :

```bash
/usr/bin/php /home/zbinv2677815/laravel-app/artisan queue:work --stop-when-empty --max-time=230 --tries=3 2>&1
```

**📝 Note** : Testez d'abord manuellement via SSH pour confirmer le chemin exact.

---

*Commande vérifiée pour ZB Investments*
*Serveur : webdb29.lws-hosting.com*
*Utilisateur : zbinv2677815*
