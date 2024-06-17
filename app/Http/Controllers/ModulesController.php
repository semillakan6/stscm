<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Modules as Module;
use App\Models\Permissions as Permission;

class ModulesController extends Controller
{
    public function index(Module $modules, Permission $permissions)
    {
        $modules = Module::all()->sortBy('order_index');
        $permissions = Permission::all();

        return view('navigation-menu', compact('modules', 'permissions'));
    }
}
