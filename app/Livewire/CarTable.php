<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\VehicleData;

class CarTable extends Component
{
    public $cars;
  
    public function render()
    {
        $this->dispatch('rendered');
        return view('forms.shop_table');
    }
  
    public function enterShop()
    {
        // Here write the logic that happens when the button is clicked
        // This replaces your "dynamicLoad" function
    }
  
    public function deleteFunc($id)
    {
        // Here goes the logic to delete an item, replaces your AJAX logic
    }
  
    public function editFunc($id)
    {
        // Here goes the logic to edit an item, replacing your AJAX logic
    }
}
