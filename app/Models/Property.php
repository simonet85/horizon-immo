<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class Property extends Model implements HasMedia
{
    use HasFactory;
    use InteractsWithMedia;

    protected $fillable = [
        'title',
        'description',
        'price',
        'currency',
        'city',
        'address',
        'transaction_type',
        'bedrooms',
        'bathrooms',
        'surface_area',
        'images',
        'status',
        'is_featured',
        'category_id',
        'town_id',
    ];

    protected $casts = [
        'images' => 'array',
        'is_featured' => 'boolean',
        'price' => 'decimal:2',
        'surface_area' => 'decimal:2',
    ];

    public function getFormattedPriceAttribute()
    {
        return number_format($this->price, 0, ',', ' ').' '.$this->currency;
    }

    protected static function boot()
    {
        parent::boot();

        // Définir automatiquement FCFA comme devise par défaut lors de la création
        static::creating(function ($property) {
            if (empty($property->currency)) {
                $property->currency = 'FCFA';
            }
        });
    }

    /**
     * Register media conversions for image optimization
     */
    public function registerMediaConversions(?Media $media = null): void
    {
        // Thumbnail : 300x200 (pour les listes de propriétés)
        $this->addMediaConversion('thumb')
            ->width(300)
            ->height(200)
            ->sharpen(10)
            ->format('webp')
            ->quality(80)
            ->nonQueued(); // Généré immédiatement

        // Preview : 800x600 (pour les sliders et previews)
        $this->addMediaConversion('preview')
            ->width(800)
            ->height(600)
            ->sharpen(10)
            ->format('webp')
            ->quality(85)
            ->performOnCollections('images')
            ->queued(); // Généré en arrière-plan

        // Optimized : 1920x1080 (pour l'affichage détaillé)
        $this->addMediaConversion('optimized')
            ->width(1920)
            ->height(1080)
            ->format('webp')
            ->quality(90)
            ->performOnCollections('images')
            ->queued();
    }

    /**
     * Register media collections
     */
    public function registerMediaCollections(): void
    {
        $this->addMediaCollection('images')
            ->acceptsMimeTypes(['image/jpeg', 'image/png', 'image/gif', 'image/webp']);
        // Note: File size validation (max 10MB) is handled in PropertyController validation rules
    }

    /**
     * Get main image URL (compatible avec l'ancien système)
     */
    public function getMainImageAttribute()
    {
        // Essayer d'abord avec Spatie Media Library
        $media = $this->getFirstMedia('images');
        if ($media) {
            return $media->getUrl('preview');
        }

        // Fallback sur l'ancien système (JSON)
        $allImages = $this->all_images;
        if (! empty($allImages) && is_array($allImages)) {
            return $allImages[0];
        }

        return '/images/placeholder-property.jpg';
    }

    /**
     * Get all images URLs with different sizes
     */
    public function getImagesUrlsAttribute()
    {
        return $this->getMedia('images')->map(function ($media) {
            return [
                'id' => $media->id,
                'original' => $media->getUrl(),
                'thumb' => $media->getUrl('thumb'),
                'preview' => $media->getUrl('preview'),
                'optimized' => $media->getUrl('optimized'),
            ];
        });
    }

    /**
     * Get all images for display (compatible avec l'ancien système)
     */
    public function getAllImagesAttribute()
    {
        // Essayer d'abord avec Spatie Media Library
        $mediaImages = $this->getMedia('images');
        if ($mediaImages->isNotEmpty()) {
            return $mediaImages->map(fn ($media) => $media->getUrl('preview'))->toArray();
        }

        // Fallback sur l'ancien système (JSON)
        $oldImages = $this->attributes['images'] ?? null;

        // Si c'est une chaîne JSON, la décoder
        if (is_string($oldImages)) {
            $decoded = json_decode($oldImages, true);

            return is_array($decoded) ? $decoded : [];
        }

        // Si c'est déjà un tableau
        if (is_array($oldImages)) {
            return $oldImages;
        }

        return [];
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function town()
    {
        return $this->belongsTo(Town::class);
    }
}
