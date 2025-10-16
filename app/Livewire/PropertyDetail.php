<?php

namespace App\Livewire;

use App\Models\Property;
use Livewire\Component;

class PropertyDetail extends Component
{
    public Property $property;

    public $currentImageIndex = 0;

    public $showGalleryModal = false;

    public $modalImageIndex = 0;

    public function mount($id)
    {
        $this->property = Property::with('town', 'category')->findOrFail($id);
    }

    public function nextImage()
    {
        $totalImages = count($this->property->images);
        if ($totalImages > 0) {
            $this->currentImageIndex = ($this->currentImageIndex + 1) % $totalImages;
        }
    }

    public function previousImage()
    {
        $totalImages = count($this->property->images);
        if ($totalImages > 0) {
            $this->currentImageIndex = ($this->currentImageIndex - 1 + $totalImages) % $totalImages;
        }
    }

    public function goToImage($index)
    {
        $this->currentImageIndex = $index;
    }

    public function openGallery($imageIndex)
    {
        $this->modalImageIndex = $imageIndex;
        $this->showGalleryModal = true;
    }

    public function closeGallery()
    {
        $this->showGalleryModal = false;
    }

    public function nextModalImage()
    {
        $totalImages = count($this->property->images);
        if ($totalImages > 0) {
            $this->modalImageIndex = ($this->modalImageIndex + 1) % $totalImages;
        }
    }

    public function previousModalImage()
    {
        $totalImages = count($this->property->images);
        if ($totalImages > 0) {
            $this->modalImageIndex = ($this->modalImageIndex - 1 + $totalImages) % $totalImages;
        }
    }

    public function goToModalImage($index)
    {
        $this->modalImageIndex = $index;
    }

    public function render()
    {
        // Récupérer 3 propriétés similaires (même catégorie et ville, excluant la propriété actuelle)
        $similarProperties = Property::with('town', 'category')
            ->where('category_id', $this->property->category_id)
            ->where(function ($query) {
                // Support pour les deux systèmes : ancien champ city et nouvelle relation town
                if ($this->property->town_id) {
                    $query->where('town_id', $this->property->town_id);
                } elseif ($this->property->city) {
                    $query->where('city', $this->property->city);
                }
            })
            ->where('id', '!=', $this->property->id)
            ->where('status', 'available')
            ->take(3)
            ->get();

        // Si on n'a pas assez de propriétés similaires par ville, compléter avec la même catégorie
        if ($similarProperties->count() < 3) {
            $additionalProperties = Property::with('town', 'category')
                ->where('category_id', $this->property->category_id)
                ->where('id', '!=', $this->property->id)
                ->whereNotIn('id', $similarProperties->pluck('id'))
                ->where('status', 'available')
                ->take(3 - $similarProperties->count())
                ->get();

            $similarProperties = $similarProperties->merge($additionalProperties);
        }

        // Si on n'a toujours pas assez, compléter avec n'importe quelles propriétés disponibles
        if ($similarProperties->count() < 3) {
            $moreProperties = Property::with('town', 'category')
                ->where('id', '!=', $this->property->id)
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
