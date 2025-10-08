<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactContent extends Model
{
    use HasFactory;

    protected $fillable = [
        'section',
        'key',
        'value',
        'is_active',
        'order',
    ];

    protected $casts = [
        'is_active' => 'boolean',
        'order' => 'integer',
    ];

    /**
     * Récupérer le contenu par section
     */
    public static function getBySection(string $section): array
    {
        return static::where('section', $section)
            ->where('is_active', true)
            ->orderBy('order')
            ->pluck('value', 'key')
            ->toArray();
    }

    /**
     * Mettre à jour une section complète
     */
    public static function updateSection(string $section, array $data): void
    {
        foreach ($data as $key => $value) {
            static::updateOrCreate(
                ['section' => $section, 'key' => $key],
                ['value' => $value, 'is_active' => true]
            );
        }
    }
}
