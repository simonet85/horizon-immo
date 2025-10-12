# 🎯 Configuration CRON dans le Panel LWS - Guide Visuel

## 📸 Basé sur l'interface réelle du Panel LWS

Ce guide utilise l'interface exacte que vous voyez dans votre Panel LWS pour configurer la tâche CRON de traitement de la queue Laravel.

---

## ⚠️ Informations importantes

### Limite de timeout LWS
> **Le timeout maximum sera de 4 minutes.**

Cela signifie que votre tâche CRON ne peut pas s'exécuter plus de 4 minutes (240 secondes).

### Quota CRON
- **Tâches utilisées** : 0/10
- **Tâches maximum** : 10

Vous avez donc 10 emplacements disponibles pour créer des tâches CRON.

---

## 📋 Configuration étape par étape

### Étape 1 : Accéder à la page de création

1. Connectez-vous au **Panel LWS** : https://panel.lws.fr
2. Allez dans **Tâches CRON** (menu de gauche)
3. Vous verrez la page **"Création d'une tâche Cron"**

### Étape 2 : Choisir les paramètres communs

Dans le premier menu déroulant **"Paramètres communs"**, vous avez plusieurs options pré-configurées :

| Option | Configuration CRON | Utilisation |
|--------|-------------------|-------------|
| **Toutes les minutes** | `* * * * *` | ✅ **RECOMMANDÉ pour ZB Investments** |
| Toutes les 5 minutes | `*/5 * * * *` | Pour faible trafic |
| Deux fois par heure | `0,30 * * * *` | Pour très faible trafic |
| Toutes les heures | `0 * * * *` | Non recommandé (trop lent) |
| Deux fois par jour | `0 0,12 * * *` | Non recommandé |
| Une fois par jour | `0 0 * * *` | Non recommandé |
| Une fois par semaine | `0 0 * * 0` | Non recommandé |
| Le 1er et le 15 du mois | `0 0 1,15 * *` | Non recommandé |
| Une fois par mois | `0 0 1 * *` | Non recommandé |
| Une fois par an | `0 0 1 1 *` | Non recommandé |

### Étape 3 : Configuration recommandée pour la queue Laravel

#### Option A : Toutes les minutes (⭐ RECOMMANDÉ)

**Sélectionnez** : **"Toutes les minutes (* * * * *)"** dans le menu déroulant "Paramètres communs"

Cela remplira automatiquement tous les champs :
- **Minute** : `*`
- **Heure** : `*`
- **Jour du mois** : `*`
- **Mois** : `*`
- **Jour de la semaine** : `*`

✅ **Avantages** :
- Les emails sont envoyés dans la minute suivant leur création
- Réactivité maximale pour vos clients
- Les jobs ne s'accumulent pas

#### Option B : Toutes les 5 minutes (si faible trafic)

**Sélectionnez** : **"Toutes les 5 minutes (*/5 * * * *)"**

✅ **Avantages** :
- Moins de charge serveur
- Suffisant si vous recevez peu de messages (<10 par heure)

---

## 🖥️ Champ "Commande"

C'est le champ le plus important ! Voici la commande exacte à entrer :

### Commande complète :

```bash
/usr/bin/php /home/lws-302769/laravel-app/artisan queue:work --stop-when-empty --max-time=230 --tries=3 2>&1
```

### ⚠️ IMPORTANT : Adapter le chemin utilisateur

Dans la commande ci-dessus, remplacez **`lws-302769`** par votre **identifiant LWS**.

**Votre identifiant** : Visible en haut à droite du Panel LWS (exemple : `lws-302769`)

### Explication de la commande :

| Partie | Description |
|--------|-------------|
| `/usr/bin/php` | Chemin vers l'exécutable PHP sur le serveur LWS |
| `/home/lws-302769/laravel-app/artisan` | Chemin vers votre application Laravel |
| `queue:work` | Commande Laravel pour traiter la queue |
| `--stop-when-empty` | ⚠️ **CRUCIAL** : Arrête le worker quand il n'y a plus de jobs (évite que le processus tourne en continu) |
| `--max-time=230` | Timeout de 230 secondes (3 min 50s, juste sous la limite de 4 min de LWS) |
| `--tries=3` | Réessaye 3 fois en cas d'échec |
| `2>&1` | Redirige les erreurs vers la sortie standard pour le debug |

---

## 📝 Formulaire complet à remplir

Voici comment remplir le formulaire exactement :

```
┌─────────────────────────────────────────────────────────────────┐
│ Création d'une tâche Cron                                       │
├─────────────────────────────────────────────────────────────────┤
│                                                                 │
│ Paramètres communs                                              │
│ ┌─────────────────────────────────────────────────────────────┐ │
│ │ Toutes les minutes (* * * * *)                              │ │
│ └─────────────────────────────────────────────────────────────┘ │
│                                                                 │
│ Minute                                                          │
│ ┌──────────────────┐  ┌────────────────────────────────────┐   │
│ │ *                │  │ -- Paramètres communs --           │   │
│ └──────────────────┘  └────────────────────────────────────┘   │
│                                                                 │
│ Heure                                                           │
│ ┌──────────────────┐  ┌────────────────────────────────────┐   │
│ │ *                │  │ -- Paramètres communs --           │   │
│ └──────────────────┘  └────────────────────────────────────┘   │
│                                                                 │
│ Jour du mois                                                    │
│ ┌──────────────────┐  ┌────────────────────────────────────┐   │
│ │ *                │  │ -- Paramètres communs --           │   │
│ └──────────────────┘  └────────────────────────────────────┘   │
│                                                                 │
│ Mois                                                            │
│ ┌──────────────────┐  ┌────────────────────────────────────┐   │
│ │ *                │  │ -- Paramètres communs --           │   │
│ └──────────────────┘  └────────────────────────────────────┘   │
│                                                                 │
│ Jour de la semaine                                              │
│ ┌──────────────────┐  ┌────────────────────────────────────┐   │
│ │ *                │  │ -- Paramètres communs --           │   │
│ └──────────────────┘  └────────────────────────────────────┘   │
│                                                                 │
│ Commande                                                        │
│ ┌─────────────────────────────────────────────────────────────┐ │
│ │ /usr/bin/php /home/lws-302769/laravel-app/artisan         │ │
│ │ queue:work --stop-when-empty --max-time=230 --tries=3 2>&1 │ │
│ └─────────────────────────────────────────────────────────────┘ │
│                                                                 │
│                  [ Ajouter une nouvelle tâche Cron ]            │
└─────────────────────────────────────────────────────────────────┘
```

---

## 🔍 Trouver votre identifiant utilisateur LWS

### Méthode 1 : Via le Panel

L'identifiant est visible en haut à droite du Panel LWS, à côté de votre nom.

**Exemples d'identifiants** :
- `lws-302769`
- `zbinv2677815`
- Format : `lws-XXXXXX` ou `zbinvXXXXXXX`

### Méthode 2 : Via SSH

```bash
# Se connecter en SSH
ssh votre-identifiant@webdb29.lws-hosting.com

# Afficher le répertoire home
pwd
# Résultat : /home/lws-302769 (votre identifiant est "lws-302769")

# Ou
echo $USER
# Résultat : lws-302769
```

---

## 📊 Vérifications avant de valider

Avant de cliquer sur **"Ajouter une nouvelle tâche Cron"**, vérifiez :

### Checklist de validation :

- [ ] ✅ **Paramètres communs** : "Toutes les minutes (* * * * *)" sélectionné
- [ ] ✅ **Minute** : `*` (rempli automatiquement)
- [ ] ✅ **Heure** : `*` (rempli automatiquement)
- [ ] ✅ **Jour du mois** : `*` (rempli automatiquement)
- [ ] ✅ **Mois** : `*` (rempli automatiquement)
- [ ] ✅ **Jour de la semaine** : `*` (rempli automatiquement)
- [ ] ✅ **Commande** : Vérifier que l'identifiant utilisateur est correct
- [ ] ✅ **Commande** : Contient bien `--stop-when-empty` (CRUCIAL)
- [ ] ✅ **Commande** : Contient bien `--max-time=230` (sous la limite de 4 min)

### Commande finale à copier-coller :

**⚠️ REMPLACEZ `lws-302769` par votre identifiant réel !**

```bash
/usr/bin/php /home/lws-302769/laravel-app/artisan queue:work --stop-when-empty --max-time=230 --tries=3 2>&1
```

---

## ✅ Après avoir cliqué sur "Ajouter"

### 1. Vérifier que la tâche est créée

Vous devriez voir :
- **Tâche cron utilisée(s)** : 1 (au lieu de 0)
- La tâche apparaît dans la liste avec :
  - ✅ Statut : **Actif**
  - ✅ Fréquence : `* * * * *` (toutes les minutes)
  - ✅ Commande : Votre commande complète

### 2. Attendre 1-2 minutes

La première exécution aura lieu à la prochaine minute.

### 3. Vérifier l'exécution

#### Via le Panel LWS :

Cherchez une section **"Historique"** ou **"Logs"** des tâches CRON pour voir les exécutions.

#### Via SSH :

```bash
# Se connecter en SSH
ssh lws-302769@webdb29.lws-hosting.com

# Aller dans le dossier Laravel
cd laravel-app

# Vérifier les jobs en attente
php artisan tinker --execute="echo 'Jobs en attente: ' . DB::table('jobs')->count();"

# Consulter les logs Laravel
tail -n 50 storage/logs/laravel.log
```

---

## 🧪 Tester le fonctionnement

### Test complet en 5 étapes :

#### 1. Envoyer un message de test

Allez sur votre site : **https://zbinvestments-ci.com/contact**

Remplissez et envoyez le formulaire de contact.

#### 2. Vérifier que le job est créé

Via SSH :
```bash
cd /home/lws-302769/laravel-app
php artisan tinker --execute="echo 'Jobs: ' . DB::table('jobs')->count();"
```

Devrait afficher : **Jobs: 2** (1 pour l'admin, 1 pour le client)

#### 3. Attendre 1 minute maximum

La tâche CRON va s'exécuter automatiquement.

#### 4. Vérifier que les jobs sont traités

Re-vérifier le nombre de jobs :
```bash
php artisan tinker --execute="echo 'Jobs: ' . DB::table('jobs')->count();"
```

Devrait afficher : **Jobs: 0** (tous traités)

#### 5. Vérifier la réception des emails

- ✅ **Admin** : Devrait avoir reçu un email "Nouveau message de contact"
- ✅ **Client** : Devrait avoir reçu un email de confirmation

---

## 🛠️ Dépannage

### Problème 1 : La tâche CRON ne s'exécute pas

#### Vérifications :

1. **Chemin utilisateur incorrect** :
   ```bash
   # Vérifier votre identifiant
   ssh votre-user@webdb29.lws-hosting.com
   pwd
   # Note le résultat : /home/XXX
   ```

2. **Chemin PHP incorrect** :
   ```bash
   # Trouver le chemin PHP
   which php
   # Utiliser le résultat dans la commande CRON
   ```

3. **Fichier artisan manquant** :
   ```bash
   ls -lh /home/lws-302769/laravel-app/artisan
   # Devrait afficher le fichier
   ```

### Problème 2 : Les jobs ne sont pas traités

#### Vérifications :

1. **Queue connection incorrecte** :

   Vérifier le fichier `.env` sur le serveur :
   ```bash
   grep "QUEUE_CONNECTION" /home/lws-302769/laravel-app/.env
   ```

   Devrait afficher : `QUEUE_CONNECTION=database`

2. **Table jobs manquante** :
   ```bash
   php artisan migrate:status
   ```

3. **Permissions insuffisantes** :
   ```bash
   ls -lh storage/
   # Vérifier que les permissions sont 775

   # Si besoin :
   chmod -R 775 storage bootstrap/cache
   ```

### Problème 3 : Timeout (dépassement de 4 minutes)

Si vous avez beaucoup de jobs qui s'accumulent :

**Solution 1** : Réduire le max-time
```bash
# Passer de 230 à 200 secondes
--max-time=200
```

**Solution 2** : Augmenter la fréquence
- Passer de "toutes les minutes" à "toutes les 30 secondes" (voir section alternatives ci-dessous)

---

## 🎯 Configurations alternatives

### Configuration 1 : Traiter 1 job à la fois (très faible trafic)

**Paramètres communs** : Toutes les minutes
**Commande** :
```bash
/usr/bin/php /home/lws-302769/laravel-app/artisan queue:work --once 2>&1
```

✅ Traite 1 seul job puis s'arrête

### Configuration 2 : Toutes les 5 minutes (faible trafic)

**Paramètres communs** : Toutes les 5 minutes (*/5 * * * *)
**Commande** :
```bash
/usr/bin/php /home/lws-302769/laravel-app/artisan queue:work --stop-when-empty --max-time=230 --tries=3 2>&1
```

### Configuration 3 : Deux fois par heure (très faible trafic)

**Paramètres communs** : Deux fois par heure (0,30 * * * *)
**Commande** :
```bash
/usr/bin/php /home/lws-302769/laravel-app/artisan queue:work --stop-when-empty --max-time=230 --tries=3 2>&1
```

---

## 📞 Support

### Si vous avez besoin d'aide :

1. **Support LWS** :
   - Panel : https://panel.lws.fr
   - Ouvrir un ticket de support
   - Chat en ligne (si disponible)

2. **Documentation LWS** :
   - Tâches CRON : https://aide.lws.fr/a/892

3. **Logs à consulter** :
   - Logs Laravel : `storage/logs/laravel.log`
   - Logs CRON : Dans le Panel LWS (section "Historique")

---

## ✅ Validation finale

Une fois la tâche CRON créée et testée :

- [x] ✅ Tâche CRON créée dans le Panel LWS
- [x] ✅ Statut : Actif
- [x] ✅ Fréquence : Toutes les minutes
- [x] ✅ Commande contient `--stop-when-empty`
- [x] ✅ Identifiant utilisateur correct dans le chemin
- [x] ✅ Test d'envoi de message effectué
- [x] ✅ Jobs traités automatiquement
- [x] ✅ Emails reçus avec succès

**🎉 Si toutes les cases sont cochées : CONFIGURATION TERMINÉE !**

---

## 📸 Captures d'écran de référence

Les images suivantes montrent l'interface exacte du Panel LWS :

1. **cron-1.png** : Formulaire de création de tâche CRON vide
2. **cron-2.png** : Menu déroulant "Paramètres communs" avec toutes les options

**Utilisez ces images comme référence visuelle lors de la configuration.**

---

*Configuration pour ZB Investments - Panel LWS*
*Identifiant : lws-302769*
*Date : Octobre 2025*
