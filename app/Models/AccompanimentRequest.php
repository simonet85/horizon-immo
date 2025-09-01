<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AccompanimentRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'first_name',
        'last_name',
        'country_residence',
        'age',
        'profession',
        'email',
        'phone',
        'desired_city',
        'property_type',
        'budget_range',
        'additional_info',
        'personal_contribution_percentage',
        'status'
    ];

    public function getFullNameAttribute()
    {
        return $this->first_name . ' ' . $this->last_name;
    }
}
