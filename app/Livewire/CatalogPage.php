<?php

namespace App\Livewire;

use App\Models\Property;
use Livewire\Component;
use Livewire\WithPagination;

class CatalogPage extends Component
{
    use WithPagination;

    public $search = '';

    public $selectedCity = '';

    public $selectedCategoryId = '';

    public $selectedStatus = '';

    public $priceRange = '';

    public $sortBy = 'created_at';

    public $sortDirection = 'desc';

    protected $queryString = [
        'search' => ['except' => ''],
        'selectedCity' => ['except' => ''],
        'selectedCategoryId' => ['except' => ''],
        'selectedStatus' => ['except' => ''],
        'priceRange' => ['except' => ''],
        'sortBy' => ['except' => 'created_at'],
        'sortDirection' => ['except' => 'desc'],
    ];

    public function updatedSearch()
    {
        $this->resetPage();
    }

    public function updatedSelectedCity()
    {
        $this->resetPage();
    }

    public function updatedSelectedCategoryId()
    {
        $this->resetPage();
    }

    public function updatedSelectedStatus()
    {
        $this->resetPage();
    }

    public function updatedPriceRange()
    {
        $this->resetPage();
    }

    public function updatedSortBy()
    {
        $this->resetPage();
    }

    public function updatedSortDirection()
    {
        $this->resetPage();
    }

    public function setSortBy($field)
    {
        \Log::info('setSortBy called with: '.$field);
        if ($this->sortBy === $field) {
            $this->sortDirection = $this->sortDirection === 'asc' ? 'desc' : 'asc';
        } else {
            $this->sortBy = $field;
            $this->sortDirection = 'asc';
        }
        $this->resetPage();
        \Log::info('New sort: '.$this->sortBy.' - '.$this->sortDirection);
    }

    public function resetFilters()
    {
        \Log::info('ResetFilters called');
        $this->search = '';
        $this->selectedCity = '';
        $this->selectedCategoryId = '';
        $this->selectedStatus = '';
        $this->priceRange = '';
        $this->sortBy = 'created_at';
        $this->sortDirection = 'desc';
        $this->resetPage();
        \Log::info('Filters reset complete');
    }

    public function render()
    {
        $query = Property::query();

        // Apply status filter (show all by default, filter only if selected)
        if ($this->selectedStatus) {
            $query->where('status', $this->selectedStatus);
        }
        // Note: Removed default filter to 'available' to show all properties

        // Apply search filter
        if ($this->search) {
            $query->where(function ($q) {
                $q->where('title', 'like', '%'.$this->search.'%')
                    ->orWhere('description', 'like', '%'.$this->search.'%')
                    ->orWhere('city', 'like', '%'.$this->search.'%');
            });
        }

        // Apply city filter
        if ($this->selectedCity) {
            $query->where('city', $this->selectedCity);
        }

        // Apply category filter
        if ($this->selectedCategoryId) {
            $query->where('category_id', $this->selectedCategoryId);
        }

        // Apply price range filter
        if ($this->priceRange) {
            $range = explode('-', $this->priceRange);
            if (count($range) === 2) {
                $query->whereBetween('price', [(int) $range[0], (int) $range[1]]);
            }
        }

        // Apply sorting
        $query->orderBy($this->sortBy, $this->sortDirection);

        $properties = $query->paginate(9);

        return view('livewire.catalog-page', [
            'properties' => $properties,
        ])->layout('layouts.site');
    }
}
