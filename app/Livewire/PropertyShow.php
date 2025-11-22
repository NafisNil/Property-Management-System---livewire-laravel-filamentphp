<?php

namespace App\Livewire;

use App\Models\Property;
use Livewire\Attributes\Layout;
use Livewire\Component;

#[Layout('components.layouts.app')]
class PropertyShow extends Component
{
    public Property $property;

    public function mount(Property $property): void
    {
        $this->property = $property;
    }

    public function render()
    {
        return view('livewire.property-show');
    }
}
