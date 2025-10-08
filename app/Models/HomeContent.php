<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HomeContent extends Model
{
    use HasFactory;

    protected $fillable = [
        'section',
        'key',
        'value',
        'type',
        'order',
        'active',
        'image_path',
    ];

    protected $casts = [
        'active' => 'boolean',
    ];

    public function scopeActive($query)
    {
        return $query->where('active', true);
    }

    public function scopeSection($query, $section)
    {
        return $query->where('section', $section);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('order');
    }

    /**
     * Récupérer le contenu d'une section spécifique
     */
    public static function getSection($section)
    {
        return self::section($section)->active()->ordered()->get()->keyBy('key');
    }

    /**
     * Mettre à jour ou créer un contenu
     */
    public static function updateContent($section, $key, $value, $type = 'text')
    {
        return self::updateOrCreate(
            ['section' => $section, 'key' => $key],
            ['value' => $value, 'type' => $type]
        );
    }
}
