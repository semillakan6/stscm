<?php

namespace App\Livewire;

use Livewire\Component;

class CarInventory extends Component
{
    public function render()
    {
        $this->dispatch('rendered');
        return view('forms.vehicle_inventory');
    }
}
