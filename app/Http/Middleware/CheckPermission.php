<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use App\Models\Role;

class CheckPermission
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @param  string|null  $role
     * @param  string|null  $permission
     * @return mixed
     */
    public function handle($request, Closure $next, $permission, $role = null)
    {
        $user = Auth::user();

        if (!$user) {
            return Redirect::route('dashboard')->with('warning', 'Unauthorized');
        }

        // Load the user's role from the MongoDB collection
        $userRole = Role::where('name', $user->role)->first();
        //Cambiar a SweetAlerts
        if (!$userRole) {
            //return Redirect::route('dashboard')->with('warning', 'No tiene permiso de acceder a esta pagina.');
            session()->flash('alert-tmp', ['type' => 'error', 'message' => 'No tiene permiso de acceder a esta pagina.']);
            return Redirect::route('dashboard');
        }

        // Check if the user has the required permission within the role
        if (!in_array($permission, $userRole->permissions)) {
            //return Redirect::route('dashboard')->with('warning', 'No tiene permiso de acceder a esta pagina.');
            session()->flash('alert-tmp', ['type' => 'error', 'message' => 'No tiene permiso de acceder a esta pagina.']);
            return Redirect::route('dashboard');
        }

        // If role is provided, confirm user's role matches
        if ($role !== null && $userRole->name !== $role) {
            //return Redirect::route('dashboard')->with('warning', 'No tiene permiso de acceder a esta pagina.');
            session()->flash('alert-tmp', ['type' => 'error', 'message' => 'No tiene permiso de acceder a esta pagina.']);
            return Redirect::route('dashboard');
        }

        return $next($request);
    }
}
