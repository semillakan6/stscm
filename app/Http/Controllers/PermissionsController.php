<?php

namespace App\Http\Controllers;

use App\Models\Role;
use App\Models\Permissions as Permission;

use App\Http\Requests\StorePermissionsRequest;
use App\Http\Requests\UpdatePermissionsRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class PermissionsController extends Controller
{
    // PermissionController.php

    public function index()
    {
        $permissions = Permission::all();
        return view('permissions.index', compact('permissions'));
    }

    public function getUserPermissions()
    {
        $user = Auth::user();
        $userRole = Role::where('name', $user->role)->first();
        return response()->json($userRole->permissions);
    }

    public function create()
    {
        return view('permissions.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:permissions',
        ]);

        Permission::create(['name' => $request->name]);

        return redirect()
            ->route('permissions.index')
            ->with('success', 'Permiso creado exitosamente');
    }

    public function edit(Permission $permission)
    {
        return view('permissions.edit', compact('permission'));
    }

    public function update(Request $request, Permission $permission)
    {
        $request->validate([
            'name' => 'required|unique:permissions,name,' . $permission->id,
        ]);

        $permission->update(['name' => $request->name]);

        return redirect()
            ->route('permissions.index')
            ->with('success', 'Permiso actulizado exitosamente,');
    }

    public function destroy(Permission $permission)
    {
        $permission->delete();

        return redirect()
            ->route('permissions.index')
            ->with('success', 'Permiso eliminado exitosamente.');
    }
}
