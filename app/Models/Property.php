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
        'type',
        'transaction_type',
        'bedrooms',
        'bathrooms',
        'surface_area',
        'images',
        'status',
        'is_featured',
        'category_id',
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

    public function getMainImageAttribute()
    {
        return $this->images[0] ?? '/images/placeholder-property.jpg';
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
}
