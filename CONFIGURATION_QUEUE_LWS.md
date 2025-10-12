# Configuration de la Queue Laravel sur LWS

## 🎯 Objectif

Faire en sorte que les emails en queue soient traités automatiquement sur le serveur LWS, sans avoir à lancer manuellement `php artisan queue:work`.

## ⚠️ Important

**NE PAS utiliser `php artisan queue:work` directement via SSH** car :
- ❌ La commande s'arrête quand vous fermez le terminal SSH
- ❌ Le processus peut être tué par le serveur
- ❌ Pas de redémarrage automatique en cas d'erreur

✅ **Solution : Utiliser une tâche CRON**

## 📋 Configuration - Tâche CRON sur LWS

### Méthode 1 : Traiter la queue toutes les minutes (Recommandé)

#### 1. Accéder aux tâches CRON

1. Connexion au **Panel LWS** : https://panel.lws.fr
2. Aller dans : **Tâches planifiées (CRON)** ou **CRON Jobs**
3. Cliquer sur **Ajouter une nouvelle tâche CRON**

#### 2. Configuration de la tâche

**Paramètres** :

| Champ | Valeur | Description |
|-------|--------|-------------|
| **Commande** | `/usr/bin/php /home/zbinv2677815/laravel-app/artisan queue:work --stop-when-empty --max-time=50 2>&1` | Traite tous les jobs puis s'arrête |
| **Minute** | `*` | Chaque minute |
| **Heure** | `*` | Toutes les heures |
| **Jour du mois** | `*` | Tous les jours |
| **Mois** | `*` | Tous les mois |
| **Jour de la semaine** | `*` | Tous les jours de la semaine |

**Commande complète** :
```bash
/usr/bin/php /home/zbinv2677815/laravel-app/artisan queue:work --stop-when-empty --max-time=50 2>&1
```

#### Explication des options :

- `--stop-when-empty` : Traite tous les jobs en attente puis s'arrête (au lieu de rester en mémoire)
- `--max-time=50` : S'arrête après 50 secondes (pour éviter les conflits avec le prochain CRON à 60s)
- `2>&1` : Redirige les erreurs vers la sortie standard pour debugging

#### 3. Alternative : Traiter toutes les 5 minutes

Si vous avez beaucoup d'emails à envoyer, vous pouvez espacer :

```bash
*/5 * * * * /usr/bin/php /home/zbinv2677815/laravel-app/artisan queue:work --stop-when-empty --max-time=280 2>&1
```

**Paramètres** :
- **Minute** : `*/5` (toutes les 5 minutes)
- **max-time** : `280` (4 minutes 40 secondes)

### Méthode 2 : Traiter UN job à la fois (Pour faible trafic)

Si vous recevez peu de messages :

```bash
* * * * * /usr/bin/php /home/zbinv2677815/laravel-app/artisan queue:work --once 2>&1
```

**Option** :
- `--once` : Traite 1 seul job puis s'arrête

## 🔍 Trouver le bon chemin PHP sur LWS

Le chemin `/usr/bin/php` peut varier selon votre version PHP. Pour trouver le bon chemin :

### Via SSH :

```bash
which php
# Résultat possible : /usr/bin/php ou /opt/php8.2/bin/php

# Vérifier la version
php -v
```

### Chemins courants sur LWS :

| Version PHP | Chemin |
|-------------|--------|
| PHP 7.4 | `/usr/bin/php` ou `/opt/php7.4/bin/php` |
| PHP 8.0 | `/opt/php8.0/bin/php` |
| PHP 8.1 | `/opt/php8.1/bin/php` |
| PHP 8.2 | `/opt/php8.2/bin/php` |
| PHP 8.3 | `/opt/php8.3/bin/php` |

## 📊 Vérification du fonctionnement

### 1. Vérifier que la tâche CRON est active

Dans le **Panel LWS → Tâches CRON**, vous devriez voir :
- ✅ Statut : Actif
- ✅ Dernière exécution : Date/heure récente
- ✅ Prochaine exécution : Dans 1 minute (si configuré à `* * * * *`)

### 2. Vérifier les logs CRON

LWS stocke généralement les logs des tâches CRON. Consulter :
- **Panel LWS → Tâches CRON → Historique/Logs**

Ou via SSH :
```bash
# Logs des tâches CRON (si disponibles)
tail -n 50 /var/log/cron

# Ou consulter les logs Laravel
tail -n 50 /home/zbinv2677815/laravel-app/storage/logs/laravel.log
```

### 3. Tester manuellement via SSH

Pour vérifier que la commande fonctionne :

```bash
cd /home/zbinv2677815/laravel-app

# Traiter tous les jobs en attente
php artisan queue:work --stop-when-empty

# Voir les jobs échoués
php artisan queue:failed

# Compter les jobs en attente
php artisan tinker --execute="echo DB::table('jobs')->count();"
```

## 🛠️ Dépannage

### Problème 1 : La tâche CRON ne s'exécute pas

**Vérifications** :

1. **Chemin PHP correct ?**
   ```bash
   which php
   ```

2. **Chemin Laravel correct ?**
   ```bash
   ls -la /home/zbinv2677815/laravel-app/artisan
   ```
   Devrait afficher le fichier `artisan`

3. **Permissions correctes ?**
   ```bash
   chmod +x /home/zbinv2677815/laravel-app/artisan
   ```

### Problème 2 : Les jobs ne sont pas traités

**Vérifications** :

1. **Y a-t-il des jobs en attente ?**
   ```bash
   php artisan tinker --execute="echo 'Jobs: ' . DB::table('jobs')->count();"
   ```

2. **Y a-t-il des jobs échoués ?**
   ```bash
   php artisan queue:failed
   ```

3. **Configuration de la queue dans .env** :
   ```ini
   QUEUE_CONNECTION=database
   ```

4. **Table jobs existe ?**
   ```bash
   php artisan migrate:status
   ```

### Problème 3 : Erreurs dans les logs

**Consulter les logs** :
```bash
tail -n 100 /home/zbinv2677815/laravel-app/storage/logs/laravel.log
```

**Erreurs courantes** :

| Erreur | Cause | Solution |
|--------|-------|----------|
| "Class not found" | Autoload corrompu | `composer dump-autoload` |
| "Connection refused" | Mauvais credentials BDD | Vérifier `.env` |
| "Permission denied" | Permissions storage | `chmod -R 775 storage` |
| "SMTP error" | Config mail incorrecte | Vérifier variables d'env |

## 🎯 Configuration recommandée pour ZB Investments

### Trafic normal (quelques messages par jour)

**Fréquence** : Toutes les minutes
**Commande** :
```bash
* * * * * /usr/bin/php /home/zbinv2677815/laravel-app/artisan queue:work --stop-when-empty --max-time=50 2>&1
```

**Avantages** :
- ✅ Emails envoyés rapidement (dans la minute)
- ✅ Pas de surcharge serveur (s'arrête quand la queue est vide)
- ✅ Redémarre automatiquement chaque minute

### Trafic élevé (dizaines de messages par heure)

**Fréquence** : Toutes les 2 minutes
**Commande** :
```bash
*/2 * * * * /usr/bin/php /home/zbinv2677815/laravel-app/artisan queue:work --stop-when-empty --max-time=110 --tries=3 2>&1
```

**Options supplémentaires** :
- `--tries=3` : Réessaye 3 fois en cas d'échec

## 📝 Exemple de configuration dans le Panel LWS

### Interface LWS CRON

Quand vous ajoutez une tâche CRON, remplissez ainsi :

```
┌─────────────────────────────────────────────────────────────┐
│ Ajouter une tâche CRON                                      │
├─────────────────────────────────────────────────────────────┤
│                                                             │
│ Minute :          [*]                                       │
│ Heure :           [*]                                       │
│ Jour du mois :    [*]                                       │
│ Mois :            [*]                                       │
│ Jour de semaine : [*]                                       │
│                                                             │
│ Commande :                                                  │
│ [/usr/bin/php /home/zbinv2677815/laravel-app/artisan ...]  │
│                                                             │
│ Email notification : [ ] (décocher pour éviter spam)       │
│                                                             │
│                                   [Annuler]  [Enregistrer] │
└─────────────────────────────────────────────────────────────┘
```

## ✅ Checklist finale

Avant de valider :

- [ ] Chemin PHP vérifié avec `which php`
- [ ] Chemin Laravel vérifié (`/home/zbinv2677815/laravel-app/artisan` existe)
- [ ] Permissions correctes sur `storage/` (775)
- [ ] Configuration `.env` correcte (`QUEUE_CONNECTION=database`)
- [ ] Table `jobs` existe dans la base de données
- [ ] Tâche CRON créée dans le Panel LWS
- [ ] Test manuel réussi : `php artisan queue:work --stop-when-empty`
- [ ] Logs vérifiés après 2-3 minutes

## 🚀 Alternative : Laravel Horizon (Avancé)

Pour une gestion plus avancée de la queue, vous pouvez installer **Laravel Horizon** :

```bash
composer require laravel/horizon
php artisan horizon:install
```

Mais cela nécessite Redis et une configuration plus complexe sur LWS.

## 📞 Support

### Ressources Laravel
- Documentation Queue : https://laravel.com/docs/queues
- Laravel Horizon : https://laravel.com/docs/horizon

### Support LWS
- Panel : https://panel.lws.fr
- Documentation CRON : https://aide.lws.fr/a/892

---

**Note importante** : Après avoir configuré la tâche CRON, attendez 1-2 minutes puis vérifiez que les jobs sont bien traités en consultant les logs ou en envoyant un message de test via le formulaire de contact.

---

*Configuration pour ZB Investments - Octobre 2025*
