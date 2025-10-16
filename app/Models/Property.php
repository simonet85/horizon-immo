<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Property extends Model
{
    use HasFactory;

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

    public function getMainImageAttribute()
    {
        return $this->images[0] ?? '/images/placeholder-property.jpg';
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
