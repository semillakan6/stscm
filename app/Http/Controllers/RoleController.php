<?php

namespace App\Http\Controllers;

use Spatie\Permission\Models\Role;
use Illuminate\Http\Request;

class RoleController extends Controller
{
    public function __construct()
    {
        $this->middleware(['auth', 'role:admin']);
    }

    public function create()
    {
        return view('roles.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:roles',
        ]);

        Role::create(['name' => $request->name]);

        return redirect()
            ->route('roles.index')
            ->with('success', 'Role created successfully');
    }

    public function edit(Role $role)
    {
        return view('roles.edit', compact('role'));
    }

    public function update(Request $request, Role $role)
    {
        $request->validate([
            'name' => 'required|unique:roles,name,' . $role->id,
        ]);

        $role->update(['name' => $request->name]);

        return redirect()
            ->route('roles.index')
            ->with('success', 'Role updated successfully');
    }
}
