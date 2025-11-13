<?php

namespace App\Livewire;

use App\Models\Property;
use Livewire\Attributes\Computed;
use Livewire\Component;

class PropertyListing extends Component
{
    use \Livewire\WithPagination;
    public $search = '';
    public $minPrice = '';
    public $maxPrice = '';
    public $propertyType = '';
    public $listingType = '';
    public $city = '';
    public $minBedrooms = '';
    public $featuredOnly = false;
    public $sortBy = 'created_at';
    public $sortDirection = 'desc';
    public $viewMode = 'grid'; // or 'list'
    protected$queryString = [
        'search' => ['except' => ''],
        'minPrice' => ['except' => ''],
        'maxPrice' => ['except' => ''],
        'propertyType' => ['except' => ''],
        'listingType' => ['except' => ''],
        'minBedrooms' => ['except' => ''],
        'featuredOnly' => ['except' => false],
        'sortBy' => ['except' => 'created_at'],
        'sortDirection' => ['except' => 'desc'],
        'viewMode' => ['except' => 'grid'],
    ];

    public function updatingSearch(){
        $this->resetPage();
    }
    public function updatingPropertyType(){
        $this->resetPage();
    }
    public function updatingListingType(){
        $this->resetPage();
    }
    public function updatingMinBedrooms(){
        $this->resetPage();
    }
    public function updatingMinPrice(){
        $this->resetPage();
    }
    public function updatingMaxPrice(){
        $this->resetPage();
    }
    public function toggleViewMode($mode){
        $this->viewMode = $mode;
    }
    public function sortBy($field){
        if($this->sortBy === $field){
            $this->sortDirection = $this->sortDirection ==='asc' ? 'desc' : 'asc';
        }else{
            $this->sortBy = $field;
            $this->sortDirection = 'asc';
        }
    }
    public function updatingFeaturedOnly(){
        $this->resetPage();
    }

    public function updatingCity(){
        $this->resetPage();
    }

    public function resetFilters(){
        $this->reset(['search', 'minPrice', 'maxPrice', 'propertyType', 'listingType', 'minBedrooms', 'featuredOnly', 'sortBy', 'city', 'sortDirection']);
    }

    #[Computed]
    public function properties(){
        return Property::query()->isAvailable()
            ->when($this->search, fn($query) => $query->where(function($q){
                $q->where('title', 'like', '%'.$this->search.'%')
                  ->orWhere('description', 'like', '%'.$this->search.'%')
                  ->orWhere('city', 'like', '%'.$this->search.'%')
                  ->orWhere('state', 'like', '%'.$this->search.'%')
                  ->orWhere('country', 'like', '%'.$this->search.'%');
            }))
            ->when($this->minPrice, fn($query) => $query->where('price', '>=', $this->minPrice))
            ->when($this->maxPrice, fn($query) => $query->where('price', '<=', $this->maxPrice))
            ->when($this->propertyType, fn($query) => $query->where('type', $this->propertyType))
            ->when($this->listingType, fn($query) => $query->where('listing_type', $this->listingType))
            ->when($this->city, fn($query) => $query->where('city', 'like', '%'.$this->city.'%'))
            ->when($this->minBedrooms, fn($query) => $query->where('bedrooms', '>=', $this->minBedrooms))
            ->when($this->featuredOnly, fn($query) => $query->where('is_featured', true))
            ->orderBy($this->sortBy, $this->sortDirection)
            ->paginate(10);
    }
    public function render()
    {
        return view('livewire.property-listing');
    }
}
