<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Role;
use App\Models\Permissions;

class Security extends Component
{
    public $roles, $name, $role_id, $permissions;
    public $updateMode = false;
    public $isPermissionsOpen = [];

    protected $listeners = [
        'checkboxToggled' => 'updatePermissions',
        'confirmedDelete' => 'destroy'
    ];

    public function mount()
    {
        // Fetching permissions using the Permissions Model
        $this->permissions = Permissions::all();
    }

    public function render()
    {
        $this->roles = Role::all();
        return view('forms.security', ['permissions' => $this->permissions]);
    }

    public function store()
    {
        $this->validate([
            'icon' => 'required',
            'name' => 'required',
            // Asegúrate de validar todos los atributos necesarios
        ]);

        Role::create([
            'icon' => $this->icon,
            'name' => $this->name,
            // Nuevamente, asegúrate de enviar todos los atributos necesarios
        ]);

        // Se podrían agregar mensajes de éxito aquí
        // Y recuerda limpiar las propiedades después de la creación
    }

    public function update()
    {
        $this->validate([
            'icon' => 'required',
            'name' => 'required',
            // Asegúrate de validar todos los atributos necesarios
        ]);

        if ($this->role_id) {
            $role = Role::find($this->role_id);
            $role->update([
                'icon' => $this->icon,
                'name' => $this->name,
                // Nuevamente, asegúrate de enviar todos los atributos necesarios
            ]);

            // Se podrían agregar mensajes de éxito aquí
            // Y recuerda limpiar las propiedades después de la actualización
        }
    }

    public function destroy($id)
    {
        if ($id) {
            $role = Role::find($id);
            if ($role) {
                $role->delete();
                $this->dispatch('role-deleted', ['message' => 'Role deleted successfully!']); 
            }
        }
    }

    public function updatePermissions($roleId, $permission, $value)
    {
        $role = Role::find($roleId);

        if($value) {
            // Add permission
            $role->permissions = array_unique(array_merge($role->permissions ?? [], [$permission]));
        } else {
            // Remove permission
            $role->permissions = array_values(array_diff($role->permissions ?? [], [$permission]));
        }

        $role->save();
        // We can add success messages here
    }
}
