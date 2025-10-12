<?php

namespace App\Livewire;

use App\Models\Property;
use Livewire\Component;

class HomePage extends Component
{
    public $showVideoModal = true;

    public function closeVideoModal()
    {
        $this->showVideoModal = false;
    }

    public function render()
    {
        $featuredProperties = Property::where('is_featured', true)
            ->where('status', 'available')
            ->take(3)
            ->get();

        return view('livewire.home-page', [
            'featuredProperties' => $featuredProperties,
        ])->layout('layouts.site');
    }
}
