<?php

namespace App\Livewire;

use Illuminate\Http\Request;
use Livewire\Component;
use App\Models\User;
use Livewire\Attributes\Layout;
use Illuminate\Support\Facades\Hash;
use App\Models\Dependencies;
use Livewire\Attributes\On;
use Livewire\Attributes\Validate;

class UsersModals extends Component
{
    #[Validate('required')]
    public $area, $role, $name, $username;
    public function mount()
    {
        $this->dispatch('render_select2');
    }
    #[Layout('layouts.modals')]
    public function render()
    {

        return view('modals_views.user_modal');

    }
    public function save_user()
    {
        $this->dispatch('render_select2');
        $this->validate();

        if ($this->name && $this->username && $this->area && $this->role) {
            $dependence = Dependencies::where('areas.area_name', $this->area)->first();
            User::create([
                'name' => $this->name,
                'password' => Hash::make('12345678'),
                'username' => $this->username,
                'active' => "REQUIRED",
                'role' => $this->role,
                'area' => $this->area,
                'dependence' => $dependence->name,
                'status' => "1"
            ]);
            return "it works";
        } else {
            $this->dispatch('render_select2');
            return 'error';
        }

    }
    #[On('updateSelect2')]
    public function getSelectData($id, $value)
    {
        $this->$id = $value;
        $this->dispatch('render_select2');

    }
}
