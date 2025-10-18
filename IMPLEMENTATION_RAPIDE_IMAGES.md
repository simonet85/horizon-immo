# 🚀 Implémentation Rapide - Optimisation d'Images

## ✅ Packages déjà installés
- `spatie/laravel-medialibrary` v11.15
- `spatie/image-optimizer` v1.8
- `intervention/image` v3.11

## 📋 Étapes d'implémentation (30 minutes)

### 1️⃣ Configuration initiale (5 min)

```bash
# Publier la configuration
php artisan vendor:publish --provider="Spatie\MediaLibrary\MediaLibraryServiceProvider" --tag="medialibrary-config"

# Créer la table media
php artisan migrate

# Créer la table jobs pour les queues
php artisan queue:table
php artisan migrate

# Modifier .env
QUEUE_CONNECTION=database
```

### 2️⃣ Modifier le modèle Property (10 min)

Voir fichier complet : `GUIDE_OPTIMISATION_IMAGES.md` section "Étape 3"

**Résumé des changements** :
```php
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;

class Property extends Model implements HasMedia
{
    use InteractsWithMedia;

    public function registerMediaConversions(?Media $media = null): void
    {
        $this->addMediaConversion('thumb')
            ->width(300)->height(200)->format('webp')->quality(80);

        $this->addMediaConversion('preview')
            ->width(800)->height(600)->format('webp')->quality(85)->queued();

        $this->addMediaConversion('optimized')
            ->width(1920)->height(1080)->format('webp')->quality(90)->queued();
    }
}
```

### 3️⃣ Job créé ✅

Le Job `ProcessPropertyImages` a déjà été créé dans `app/Jobs/ProcessPropertyImages.php`

### 4️⃣ Modifier PropertyController (10 min)

**Changements clés** :

```php
// Dans store()
public function store(Request $request)
{
    // ... validation ...

    $property = Property::create($validated);

    // Upload asynchrone
    if ($request->hasFile('images')) {
        $tempPaths = [];
        foreach ($request->file('images') as $image) {
            if ($image && $image->isValid()) {
                $tempPath = $image->store('temp', 'local');
                $tempPaths[] = storage_path('app/' . $tempPath);
            }
        }

        if (!empty($tempPaths)) {
            \App\Jobs\ProcessPropertyImages::dispatch($property, $tempPaths);
        }
    }

    return redirect()->route('admin.properties.index')
        ->with('success', 'Propriété créée. Les images sont en cours de traitement.');
}
```

### 5️⃣ Démarrer le worker (5 min)

**En local (Laragon)** :
```bash
php artisan queue:work
```

**Sur LWS (production)** :
```bash
ssh zbinv2677815@ssh.horizonimmo.com
cd /home/zbinv2677815/laravel-app
nohup php artisan queue:work --queue=default --tries=3 --timeout=300 > storage/logs/queue.log 2>&1 &
```

---

## 🎯 Avantages immédiats

| Avant | Après |
|-------|-------|
| Upload synchrone 10s | Upload asynchrone 1s |
| 3-5 MB par image | 200-500 KB par image |
| Pas de miniatures | 3 versions (thumb, preview, optimized) |
| Format JPEG/PNG | Format WebP (meilleur) |
| Difficile à gérer | API complète Spatie |

---

## 🧪 Tester

```bash
# En local, dans un terminal séparé
php artisan queue:work

# Dans l'admin
# 1. Créer une propriété avec images
# 2. Vérifier les logs : storage/logs/laravel.log
# 3. Vérifier la table media : SELECT * FROM media;
```

---

## 📊 Migration des données existantes

Pour migrer les images actuelles :

```bash
php artisan make:command MigrateImagesToMediaLibrary
```

Code complet disponible dans `GUIDE_OPTIMISATION_IMAGES.md`

---

## ⚙️ Configuration recommandée

### `.env` production (LWS)
```env
QUEUE_CONNECTION=database
LOG_CHANNEL=stack
LOG_LEVEL=info
```

### Supervisor config (LWS)
```ini
[program:horizon-immo-queue]
process_name=%(program_name)s_%(process_num)02d
command=php /home/zbinv2677815/laravel-app/artisan queue:work --sleep=3 --tries=3 --max-time=3600
autostart=true
autorestart=true
user=zbinv2677815
numprocs=1
redirect_stderr=true
stdout_logfile=/home/zbinv2677815/laravel-app/storage/logs/queue.log
```

---

## 🚨 Problèmes courants

### Les images ne sont pas traitées
**Solution** : Vérifier que le worker tourne
```bash
php artisan queue:work
```

### Erreur "Class HasMedia not found"
**Solution** : Vérifier les imports dans Property.php
```php
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
```

### Images pas compressées
**Solution** : Installer les optimiseurs système
```bash
# Ubuntu/Debian
sudo apt-get install jpegoptim optipng pngquant gifsicle

# macOS
brew install jpegoptim optipng pngquant gifsicle
```

---

## 📚 Documentation complète

Voir `GUIDE_OPTIMISATION_IMAGES.md` pour :
- Architecture détaillée
- Exemples de code complets
- Configuration avancée
- Migration des données
- Statistiques et benchmarks

---

## ✅ Checklist

- [ ] Config publiée
- [ ] Migration executée
- [ ] Modèle Property modifié
- [ ] Job créé et testé
- [ ] PropertyController modifié
- [ ] Queue configurée dans .env
- [ ] Worker démarré
- [ ] Test d'upload réussi
- [ ] Migration données existantes (optionnel)

---

**Temps total** : ~30 minutes
**Gain de performance** : -90% temps upload, -80% poids images
