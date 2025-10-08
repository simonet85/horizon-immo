<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class FooterContent extends Model
{
    use HasFactory;

    protected $fillable = [
        'section',
        'key',
        'value',
        'is_active',
    ];

    protected $casts = [
        'is_active' => 'boolean',
    ];

    public static function getBySection(string $section): array
    {
        return self::where('section', $section)
            ->where('is_active', true)
            ->pluck('value', 'key')
            ->toArray();
    }

    public static function updateSection(string $section, array $data): void
    {
        foreach ($data as $key => $value) {
            self::updateOrCreate(
                ['section' => $section, 'key' => $key],
                ['value' => $value, 'is_active' => true]
            );
        }
    }
}
