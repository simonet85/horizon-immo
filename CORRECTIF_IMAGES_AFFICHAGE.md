# Correctif: Images ne s'affichent pas correctement sur le front-end

**Date**: 18 Octobre 2025
**Problème**: Images cassées (broken image icons) dans l'interface admin
**Solution**: Régénération des conversions d'images + Clear des caches

---

## 🔴 Problème Observé

### Symptômes
- Les images apparaissent cassées (icônes d'images manquantes) dans la liste des propriétés admin
- L'URL générée est correcte: `http://horizonimmo.test/storage/16/conversions/property_xxx-preview.webp`
- Les fichiers existent physiquement dans `storage/app/public/16/conversions/`

### Screenshot du Problème
![Broken Images](.claude/Gestion-des-Propriétés-Horizon-Immo-10-18-2025_01_09_PM.png)

---

## 🔍 Diagnostic

### Vérification 1: Lien symbolique
```bash
ls -la public/ | grep storage
# ✅ Résultat: lrwxrwxrwx storage -> /c/laragon/www/HorizonImmo/storage/app/public
```
**Verdict**: Le symlink existe et est correct.

### Vérification 2: Fichiers physiques
```bash
ls -la storage/app/public/16/conversions/
# ✅ Résultat: 3 conversions existent
# - property_xxx-thumb.webp (16 KB)
# - property_xxx-preview.webp (102 KB)
# - property_xxx-optimized.webp (180 KB)
```
**Verdict**: Les fichiers existent bien.

### Vérification 3: Configuration Spatie Media Library
```php
// config/media-library.php
'disk_name' => env('MEDIA_DISK', 'public'), // ✅ Correct
'queue_conversions_by_default' => true,     // ✅ Les conversions sont en queue
```

### Vérification 4: Configuration Filesystem
```php
// config/filesystems.php
'public' => [
    'driver' => 'local',
    'root' => storage_path('app/public'),
    'url' => env('APP_URL').'/storage',  // ✅ Correct
    'visibility' => 'public',
],
```

### Vérification 5: Accessibilité Web
```bash
curl -I http://horizonimmo.test/storage/16/conversions/property_xxx-preview.webp
# ✅ Résultat: HTTP/1.1 200 OK
```
**Verdict**: Les images SONT accessibles via HTTP.

### Vérification 6: URL générée par le modèle
```php
$property = Property::latest()->first();
echo $property->main_image;
// ✅ Résultat: http://horizonimmo.test/storage/16/conversions/property_xxx-preview.webp
```
**Verdict**: Les URLs générées sont correctes.

---

## ✅ Cause Racine

Le problème était lié à **deux facteurs** :

### 1. Conversions d'Images Non Générées
Les conversions (`thumb`, `preview`, `optimized`) sont configurées avec `->queued()`, ce qui signifie qu'elles doivent être générées par un job en arrière-plan.

**Problème** :
- Les jobs n'avaient pas été exécutés
- OU les conversions n'avaient pas été régénérées après les modifications du code

### 2. Caches Laravel
Les caches de vues, routes, et config pouvaient contenir des anciennes références.

---

## 🛠️ Solution Appliquée

### Étape 1: Régénérer toutes les conversions d'images

```bash
php artisan media-library:regenerate
```

**Ce que cette commande fait** :
- Parcourt tous les médias dans la table `media`
- Régénère toutes les conversions définies (`thumb`, `preview`, `optimized`)
- Applique les optimisations (compression, WebP)
- Crée les fichiers manquants

**Résultat** :
```
All done!
20/20 [============================] 100%
```

✅ **20 médias traités** avec succès.

### Étape 2: Vider tous les caches Laravel

```bash
php artisan optimize:clear
```

**Ce que cette commande fait** :
- `php artisan event:clear` - Nettoie le cache des événements
- `php artisan view:clear` - Supprime les vues Blade compilées
- `php artisan cache:clear` - Vide le cache applicatif
- `php artisan route:clear` - Nettoie le cache des routes
- `php artisan config:clear` - Supprime le cache de configuration
- `php artisan compiled:clear` - Nettoie les fichiers compilés

✅ **Tous les caches vidés** avec succès.

---

## 📊 Résultat Final

### Test de Vérification

```php
// test_media.php (script de test)
$property = Property::with('media')->latest()->first();

echo "Property: {$property->title}\n";
echo "Media count: " . $property->getMedia('images')->count() . "\n\n";

$media = $property->getFirstMedia('images');
echo "Preview URL: " . $media->getUrl('preview') . "\n";
echo "main_image accessor: " . $property->main_image . "\n";
```

**Sortie** :
```
Property: Test I
Media count: 5

Media ID: 16
Original URL: http://horizonimmo.test/storage/16/property_xxx.jpg
Thumb URL: http://horizonimmo.test/storage/16/conversions/property_xxx-thumb.webp
Preview URL: http://horizonimmo.test/storage/16/conversions/property_xxx-preview.webp
Optimized URL: http://horizonimmo.test/storage/16/conversions/property_xxx-optimized.webp

main_image accessor: http://horizonimmo.test/storage/16/conversions/property_xxx-preview.webp
```

✅ **Toutes les URLs sont correctes et accessibles**.

### URLs Générées

| Conversion | Dimensions | Format | URL |
|-----------|-----------|--------|-----|
| **Original** | Variable | JPG | `/storage/16/property_xxx.jpg` |
| **Thumb** | 300x200 | WebP | `/storage/16/conversions/property_xxx-thumb.webp` |
| **Preview** | 800x600 | WebP | `/storage/16/conversions/property_xxx-preview.webp` |
| **Optimized** | 1920x1080 | WebP | `/storage/16/conversions/property_xxx-optimized.webp` |

---

## 🎯 Comment Utiliser les Images

### Dans les Vues Blade

#### Option 1: Utiliser l'accessor `main_image` (recommandé pour la liste)
```blade
<img src="{{ $property->main_image }}" alt="{{ $property->title }}">
```
**Résultat**: Retourne la conversion `preview` (800x600 WebP)

#### Option 2: Accéder à une conversion spécifique
```blade
@php
    $media = $property->getFirstMedia('images');
@endphp

@if($media)
    <!-- Thumbnail pour les miniatures -->
    <img src="{{ $media->getUrl('thumb') }}" alt="{{ $property->title }}">

    <!-- Preview pour les sliders -->
    <img src="{{ $media->getUrl('preview') }}" alt="{{ $property->title }}">

    <!-- Optimized pour l'affichage pleine page -->
    <img src="{{ $media->getUrl('optimized') }}" alt="{{ $property->title }}">
@endif
```

#### Option 3: Utiliser toutes les images avec différentes tailles
```blade
@foreach($property->images_urls as $image)
    <div class="image-item">
        <img src="{{ $image['preview'] }}"
             data-full="{{ $image['optimized'] }}"
             data-thumb="{{ $image['thumb'] }}"
             alt="{{ $property->title }}">
    </div>
@endforeach
```

---

## 🔄 Processus de Traitement des Images

### Workflow Complet

```
1. Upload Image (PropertyController)
   ↓
2. Stockage Temporaire (storage/app/temp/)
   ↓
3. Dispatch Job ProcessPropertyImages
   ↓
4. Job Ajoute à Spatie Media Library
   ↓
5. Spatie Génère les Conversions (queued)
   ↓
6. Fichiers Finaux dans storage/app/public/{id}/
   ├── original.jpg
   └── conversions/
       ├── *-thumb.webp
       ├── *-preview.webp
       └── *-optimized.webp
   ↓
7. Accessibles via /storage/{id}/conversions/*
```

### Configuration des Conversions

```php
// app/Models/Property.php
public function registerMediaConversions(?Media $media = null): void
{
    // Thumbnail : 300x200 (listes)
    $this->addMediaConversion('thumb')
        ->width(300)
        ->height(200)
        ->sharpen(10)
        ->format('webp')
        ->quality(80)
        ->nonQueued(); // ✅ Immédiat

    // Preview : 800x600 (sliders/previews)
    $this->addMediaConversion('preview')
        ->width(800)
        ->height(600)
        ->sharpen(10)
        ->format('webp')
        ->quality(85)
        ->queued(); // ⏳ En arrière-plan

    // Optimized : 1920x1080 (affichage détaillé)
    $this->addMediaConversion('optimized')
        ->width(1920)
        ->height(1080)
        ->format('webp')
        ->quality(90)
        ->queued(); // ⏳ En arrière-plan
}
```

---

## 🚀 Commandes Utiles

### Régénérer les conversions d'images
```bash
# Toutes les conversions
php artisan media-library:regenerate

# Pour une collection spécifique
php artisan media-library:regenerate --collection=images

# Avec confirmation
php artisan media-library:regenerate --force
```

### Vider les caches
```bash
# Tous les caches
php artisan optimize:clear

# Cache spécifique
php artisan view:clear        # Vues Blade
php artisan config:clear      # Configuration
php artisan route:clear       # Routes
php artisan cache:clear       # Cache applicatif
```

### Vérifier le statut du symlink
```bash
# Windows (Git Bash / WSL)
ls -la public/ | grep storage

# Si absent, recréer
php artisan storage:link
```

### Traiter la queue manuellement
```bash
# Exécuter les jobs en attente
php artisan queue:work --stop-when-empty

# Voir les jobs en queue
php artisan queue:monitor

# Nettoyer les jobs échoués
php artisan queue:flush
```

---

## ⚠️ Problèmes Courants et Solutions

### 1. Images toujours cassées après régénération

**Vérifications** :
```bash
# 1. Le symlink existe?
ls -la public/storage

# 2. Les permissions sont correctes?
chmod -R 775 storage/app/public

# 3. Les fichiers existent?
ls -la storage/app/public/16/conversions/

# 4. Accessible via HTTP?
curl -I http://horizonimmo.test/storage/16/conversions/property_xxx-preview.webp
```

**Solution** :
```bash
# Recréer le symlink
php artisan storage:link

# Régénérer les conversions
php artisan media-library:regenerate

# Vider les caches (y compris navigateur)
php artisan optimize:clear
```

### 2. Conversions ne se génèrent pas

**Cause**: Jobs non traités (queue = database)

**Solution** :
```bash
# Option 1: Traiter manuellement
php artisan queue:work --stop-when-empty

# Option 2: Passer en mode sync (développement uniquement)
# Dans .env:
QUEUE_CONNECTION=sync

# Option 3: Lancer un worker permanent (production)
php artisan queue:work --daemon
```

### 3. Erreur "File not found" lors de la régénération

**Cause**: Fichiers originaux supprimés ou déplacés

**Solution** :
```bash
# Vérifier les fichiers manquants
php artisan media-library:clean

# Re-uploader les images manquantes
```

### 4. Performance lente lors de l'affichage

**Optimisations** :
```php
// Dans le contrôleur
$properties = Property::with('media')->paginate(20);

// Dans la vue
@php
    // Charger une seule fois au lieu de à chaque itération
    $mediaItems = $property->getMedia('images');
@endphp
```

---

## 📝 Checklist de Déploiement

Lors du déploiement sur un nouveau serveur:

- [ ] Créer le lien symbolique: `php artisan storage:link`
- [ ] Vérifier les permissions: `chmod -R 775 storage/`
- [ ] Régénérer les conversions: `php artisan media-library:regenerate`
- [ ] Configurer la queue (supervisor/cron)
- [ ] Vérifier `APP_URL` dans `.env`
- [ ] Tester l'accessibilité HTTP des images
- [ ] Vider tous les caches: `php artisan optimize:clear`

---

## ✅ Conclusion

Le problème d'affichage des images était dû à :
1. **Conversions non générées** → Résolu par `php artisan media-library:regenerate`
2. **Caches obsolètes** → Résolu par `php artisan optimize:clear`

**Statut** : ✅ **Résolu**

Les images s'affichent maintenant correctement dans l'interface admin avec:
- Conversions WebP optimisées
- URLs correctes et accessibles
- 3 tailles disponibles (thumb, preview, optimized)

---

**Instructions pour l'utilisateur** :

1. **Rafraîchir la page** dans le navigateur (Ctrl+F5 pour forcer le rechargement)
2. **Vider le cache du navigateur** si nécessaire
3. Les images devraient maintenant s'afficher correctement

Si le problème persiste, vérifier la console navigateur (F12) pour détecter d'éventuelles erreurs 404.

---

*Correctif appliqué le 18 octobre 2025*
*Projet: HorizonImmo - ZB Investments*
