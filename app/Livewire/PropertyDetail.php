<?php

namespace App\Livewire;

use App\Models\Property;
use Livewire\Component;

class PropertyDetail extends Component
{
    public Property $property;

    public function mount($id)
    {
        $this->property = Property::findOrFail($id);
    }

    public function render()
    {
        // Récupérer 3 propriétés similaires (même type et ville, excluant la propriété actuelle)
        $similarProperties = Property::where('type', $this->property->type)
            ->where('city', $this->property->city)
            ->where('id', '!=', $this->property->id)
            ->where('status', 'available')
            ->take(3)
            ->get();

        // Si on n'a pas assez de propriétés similaires par ville, compléter avec le même type
        if ($similarProperties->count() < 3) {
            $additionalProperties = Property::where('type', $this->property->type)
                ->where('id', '!=', $this->property->id)
                ->whereNotIn('id', $similarProperties->pluck('id'))
                ->where('status', 'available')
                ->take(3 - $similarProperties->count())
                ->get();

            $similarProperties = $similarProperties->merge($additionalProperties);
        }

        // Si on n'a toujours pas assez, compléter avec n'importe quelles propriétés disponibles
        if ($similarProperties->count() < 3) {
            $moreProperties = Property::where('id', '!=', $this->property->id)
                ->whereNotIn('id', $similarProperties->pluck('id'))
                ->where('status', 'available')
                ->take(3 - $similarProperties->count())
                ->get();

            $similarProperties = $similarProperties->merge($moreProperties);
        }

        return view('livewire.property-detail', [
            'similarProperties' => $similarProperties,
        ])->layout('layouts.site');
    }
}
