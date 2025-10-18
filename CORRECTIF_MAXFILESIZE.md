# ⚠️ Correctif : Erreur maxFilesize()

## Problème rencontré

Lors du test de l'implémentation du système d'optimisation d'images, l'erreur suivante est apparue :

```
Method Spatie\MediaLibrary\MediaCollections\MediaCollection::maxFilesize does not exist.
```

## Cause

La méthode `maxFilesize()` n'existe pas dans **Spatie Media Library v11.15**.

Cette méthode était présente dans les anciennes versions de la bibliothèque, mais a été supprimée dans les versions plus récentes.

## Solution appliquée

### ❌ Code incorrect (avant)

```php
public function registerMediaCollections(): void
{
    $this->addMediaCollection('images')
        ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/gif', 'image/webp'])
        ->maxFilesize(10 * 1024 * 1024); // ❌ Cette méthode n'existe plus
}
```

### ✅ Code corrigé (après)

```php
public function registerMediaCollections(): void
{
    $this->addMediaCollection('images')
        ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/gif', 'image/webp']);
    // Note: File size validation (max 10MB) is handled in PropertyController validation rules
}
```

## Validation de la taille des fichiers

La validation de la taille des fichiers est maintenant gérée **dans le contrôleur**, où elle doit normalement se trouver :

### PropertyController.php

```php
$validated = $request->validate([
    // ... autres règles
    'images' => 'nullable|array|max:10', // Max 10 images
    'images.*' => [
        'image',
        'mimes:jpeg,png,jpg,gif,webp',
        'max:10240', // ✅ 10MB (en kilobytes)
        'dimensions:min_width=800,min_height=600',
    ],
]);
```

## Fichiers corrigés

1. ✅ `app/Models/Property.php` - Suppression de `maxFilesize()`
2. ✅ `GUIDE_OPTIMISATION_IMAGES.md` - Documentation mise à jour
3. ✅ Code formaté avec Laravel Pint

## Vérification

Après correction, l'application fonctionne correctement :

```bash
# Tester l'accès à la page admin
php artisan serve
# Naviguer vers : http://horizonimmo.test/admin/properties
```

**Résultat attendu** : ✅ La page s'affiche sans erreur

## Alternative (si besoin de validation côté modèle)

Si vous souhaitez absolument valider la taille au niveau du modèle, utilisez la méthode `acceptsFile()` :

```php
public function registerMediaCollections(): void
{
    $this->addMediaCollection('images')
        ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/gif', 'image/webp'])
        ->acceptsFile(function (File $file) {
            // Vérifier la taille (10 MB max)
            return $file->size <= 10 * 1024 * 1024;
        });
}
```

**Mais cette approche n'est PAS recommandée** car :
- La validation doit se faire dans le contrôleur (principe MVC)
- Les messages d'erreur sont moins clairs pour l'utilisateur
- Plus difficile à tester

## Références

- **Spatie Media Library v11 Documentation** : https://spatie.be/docs/laravel-medialibrary/v11/introduction
- **Laravel Validation (File Upload)** : https://laravel.com/docs/10.x/validation#rule-file

---

**Date** : 17 Octobre 2025
**Statut** : ✅ Résolu
**Impact** : Aucun (validation déjà présente dans le contrôleur)
