# 🔄 Guide de Mise à Jour du Projet sur LWS

## 📋 Prérequis

- Accès FTP à votre serveur LWS
- FileZilla ou un client FTP installé
- Le projet local avec les dernières modifications

## 🚀 Procédure de Mise à Jour Rapide

### 1. 🔍 Identifier les Fichiers Modifiés

Vérifiez quels fichiers ont été modifiés depuis le dernier déploiement :

```bash
git status
git log --oneline -10
```

**Derniers commits à déployer :**
- `a36ce82` - Fix town edit form
- `df3a5c1` - Fix category edit form
- `01e2e9d` - Update contact messages UI
- `13a7af3` - Fix unread scope for contact messages
- `77641e2` - Fix contact messages badge counter
- (et autres commits récents)

### 2. 📂 Fichiers à Mettre à Jour via FTP

#### A. Fichiers Modèles (Models)
📍 **Destination sur LWS :** `/home/laravel-app/app/Models/`

```
app/Models/ContactMessage.php
app/Models/Property.php
app/Models/Town.php
```

#### B. Fichiers Contrôleurs (Controllers)
📍 **Destination sur LWS :** `/home/laravel-app/app/Http/Controllers/Admin/`

```
app/Http/Controllers/Admin/ContactMessageController.php
app/Http/Controllers/Admin/PropertyController.php
app/Http/Controllers/Admin/TownController.php
```

#### C. Fichiers Vues (Views)
📍 **Destination sur LWS :** `/home/laravel-app/resources/views/`

```
resources/views/admin/categories/edit.blade.php
resources/views/admin/towns/edit.blade.php
resources/views/admin/contact-messages/index.blade.php
resources/views/admin/contact-messages/show.blade.php
resources/views/admin/dashboard.blade.php
resources/views/errors/503.blade.php
```

#### D. Fichiers Providers
📍 **Destination sur LWS :** `/home/laravel-app/app/Providers/`

```
app/Providers/AdminViewServiceProvider.php
```

#### E. Fichiers Factories (pour les tests)
📍 **Destination sur LWS :** `/home/laravel-app/database/factories/`

```
database/factories/ContactMessageFactory.php
```

#### F. Fichiers Tests (optionnel)
📍 **Destination sur LWS :** `/home/laravel-app/tests/Feature/`

```
tests/Feature/ContactMessageBadgeTest.php
```

### 3. 🔌 Connexion FTP avec FileZilla

#### Paramètres de connexion :
```
Hôte : ftp.horizonimmo.com (ou ftp.cluster0XX.lws.fr)
Utilisateur : zbinv2677815
Mot de passe : [Votre mot de passe FTP]
Port : 21 (FTP) ou 22 (SFTP)
```

### 4. 📤 Upload des Fichiers

#### Option 1 : Upload Manuel (Recommandé pour petites mises à jour)

1. **Connectez-vous via FileZilla**
2. **Naviguez vers chaque dossier de destination**
3. **Glissez-déposez les fichiers modifiés**
4. **Confirmez l'écrasement** des fichiers existants

#### Option 2 : Upload par Glisser-Déposer Multiple

**Pour les Models :**
```
Local: C:\laragon\www\HorizonImmo\app\Models\
Remote: /home/laravel-app/app/Models/
```

**Pour les Controllers :**
```
Local: C:\laragon\www\HorizonImmo\app\Http\Controllers\Admin\
Remote: /home/laravel-app/app/Http/Controllers/Admin/
```

**Pour les Views :**
```
Local: C:\laragon\www\HorizonImmo\resources\views\
Remote: /home/laravel-app/resources/views/
```

### 5. 🧹 Nettoyer les Caches Laravel

Après l'upload, il est **ESSENTIEL** de vider les caches Laravel.

#### Méthode 1 : Via SSH (si disponible)

```bash
cd /home/laravel-app
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear
```

#### Méthode 2 : Via le script de cache web

Si vous avez uploadé le fichier `clear-cache-lws.php` à la racine :

1. Accédez à : `https://horizonimmo.com/clear-cache-lws.php`
2. Le script nettoiera automatiquement les caches
3. **Supprimez le fichier après usage** pour des raisons de sécurité

#### Méthode 3 : Via File Manager LWS

1. Connectez-vous au **File Manager LWS**
2. Naviguez vers `/home/laravel-app/bootstrap/cache/`
3. Supprimez les fichiers :
   - `config.php`
   - `routes-v7.php`
   - `services.php`

### 6. ✅ Vérification Post-Déploiement

#### Testez les fonctionnalités modifiées :

1. **Badge Messages Contact** ✅
   - Visitez `/admin/contact-messages`
   - Vérifiez que le badge affiche le bon nombre (3 messages)
   - Vérifiez que les badges "Non lu" s'affichent

2. **Édition Catégories** ✅
   - Visitez `/admin/categories/{id}/edit`
   - Cliquez sur "Enregistrer"
   - Vérifiez que la catégorie est **sauvegardée** (et non supprimée)

3. **Édition Villes** ✅
   - Visitez `/admin/towns/{id}/edit`
   - Cliquez sur "Enregistrer"
   - Vérifiez que la ville est **sauvegardée** (et non supprimée)

4. **Actions Messages Contact** ✅
   - Vérifiez que "Marquer comme lu" fonctionne
   - Vérifiez que le compteur se met à jour

### 7. 🚨 En Cas de Problème

#### Erreur 500 ?
1. Vérifiez les permissions :
   ```
   /home/laravel-app/storage/ → 775
   /home/laravel-app/bootstrap/cache/ → 775
   ```

2. Consultez les logs :
   ```
   /home/laravel-app/storage/logs/laravel.log
   ```

#### Cache problématique ?
1. Supprimez manuellement tous les fichiers dans :
   ```
   /home/laravel-app/bootstrap/cache/
   /home/laravel-app/storage/framework/cache/
   /home/laravel-app/storage/framework/views/
   ```

#### Vue non mise à jour ?
1. Videz le cache des vues :
   ```bash
   php artisan view:clear
   ```

## 📝 Checklist de Mise à Jour

- [ ] Connexion FTP établie
- [ ] Sauvegarde des fichiers actuels (optionnel mais recommandé)
- [ ] Upload des fichiers Models
- [ ] Upload des fichiers Controllers
- [ ] Upload des fichiers Views
- [ ] Upload des fichiers Providers
- [ ] Nettoyage des caches Laravel
- [ ] Test des fonctionnalités modifiées
- [ ] Vérification des logs d'erreurs

## 🔄 Pour les Prochaines Mises à Jour

### Script de Mise à Jour Automatique (optionnel)

Si vous avez accès SSH, créez un script `update.sh` :

```bash
#!/bin/bash

echo "🔄 Mise à jour en cours..."

# Se placer dans le bon dossier
cd /home/laravel-app

# Nettoyer les caches
php artisan config:clear
php artisan cache:clear
php artisan view:clear
php artisan route:clear

echo "✅ Caches nettoyés"

# Si vous utilisez Git sur le serveur
# git pull origin main

echo "✅ Mise à jour terminée !"
```

Exécution :
```bash
chmod +x update.sh
./update.sh
```

## 💡 Conseils Pro

### 1. Utilisez la Synchronisation de FileZilla
- **Outils → Recherche de répertoires** pour comparer local et distant
- Synchronisez uniquement les fichiers modifiés

### 2. Mode Maintenance (optionnel)
Avant une grosse mise à jour :
```bash
php artisan down --message="Mise à jour en cours. Retour dans 5 minutes."
```

Après la mise à jour :
```bash
php artisan up
```

### 3. Backup Avant Mise à Jour
Téléchargez toujours les fichiers actuels avant de les écraser :
```
Clic droit sur fichier distant → Télécharger
```

### 4. Upload par Lots
Pour de nombreux fichiers, uploadez dossier par dossier :
```
1. app/Models/ (tous les fichiers)
2. app/Http/Controllers/Admin/ (tous les fichiers)
3. resources/views/ (tous les fichiers)
```

## 📊 Résumé des Chemins Importants

| Type de Fichier | Chemin Local | Chemin Distant LWS |
|----------------|--------------|-------------------|
| Models | `app/Models/` | `/home/laravel-app/app/Models/` |
| Controllers | `app/Http/Controllers/` | `/home/laravel-app/app/Http/Controllers/` |
| Views | `resources/views/` | `/home/laravel-app/resources/views/` |
| Providers | `app/Providers/` | `/home/laravel-app/app/Providers/` |
| Migrations | `database/migrations/` | `/home/laravel-app/database/migrations/` |
| Config | `.env` | `/home/laravel-app/.env` |
| Public Assets | `public/build/` | `/htdocs/build/` |

## ⚠️ Fichiers à NE JAMAIS Modifier sur le Serveur

- ❌ `.env` (sauf si vous savez ce que vous faites)
- ❌ `vendor/` (géré par Composer)
- ❌ `node_modules/` (ne devrait pas exister en production)
- ❌ `storage/` (contient les uploads et logs)

---

**🎉 Votre projet est maintenant à jour sur LWS !**

Pour toute question, consultez le [CLAUDE.md](CLAUDE.md) pour le guide complet de déploiement.
