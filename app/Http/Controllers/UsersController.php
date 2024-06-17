<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use App\Models\Dependencies;
use Illuminate\Validation\Rules\Password;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Redirect;

class UsersController extends Controller
{
    public $error;
    public function index(Request $request)
    {

        if ($request->ajax()) {

            $search = $request->get('searchInput'); // Obtiene el valor del input

            if ($request->has('searchInput')) {
                $data = User::query()
                    ->where('active', '<>', 'OFF') // Exclude active OFF users
                    ->when($search, function ($query) use ($search) {
                        $query->where('name', 'like', "%" . $search . "%");
                    })
                    ->get();
                return response()->json(['data' => $data]);
            } else {
                $data = User::where('active', '<>', 'OFF') // Exclude active OFF users
                    ->get();

                return response()->json(['data' => $data]);
            }
        }

        return view('tables.users');
    }
    public function store(Request $request)
    {
        $dependence = Dependencies::where('areas.area_name', $request->area)->first();

        if ($request->id) {
            // Update existing user
            User::where('_id', $request->id)
                ->update([
                    'name' => $request->name,
                    'email' => $request->email,
                    'username' => $request->username,
                    'role' => $request->rol,
                    'area' => $request->area,
                    'dependence' => $dependence->name

                ]);
        } else {
            // Create new user
            User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make('12345678'),
                'username' => $request->username,
                'active' => "REQUIRED",
                'role' => $request->rol,
                'area' => $request->area,
                'dependence' => $dependence->name


            ]);
        }
        return view('tables.users');
    }
    public function edit(Request $request)
    {
        $id = $request->id;
        $userdata = User::find($id);
        return Response()->json($userdata);
    }
    public function delete(Request $request)
    {
        if ($request->id) {
            // Update existing user
            User::where('_id', $request->id['_id'])
                ->update([
                    'active' => "OFF"
                ]);
            return response()->json(['message' => 'User deleted successfully']);
        } else {
            $error = "Hubo un problema al realizar la operacion";
            return $error;
        }
    }
    public function reset(Request $request)
    {
        if ($request->id) {
            // Update existing user
            User::where('_id', $request->id['_id'])
                ->update([
                    'active' => "REQUIRED",
                    'password' => Hash::make('12345678'),

                ]);
            return response()->json(['message' => 'User reseted successfully']);
        } else {
            $error = "Hubo un problema al realizar la operacion";
            return $error;
        }
    }
    public function changePasswordView(){
        return view('forms.updateDefaultPassword_addon');

    }

public function changePassword(Request $request)
{
    $error = Validator::make($request->all(), [
        'newPass' => [
            'required',
            Password::min(8) // Mínimo 8 caracteres
                ->mixedCase() // Al menos una mayúscula y una minúscula
                ->numbers() // Al menos un número
                ->symbols() // Al menos un carácter especial
                ->uncompromised(), // Verifica que no haya fugas de datos
        ],
    ]);

    if ($request->data_id) {
        // Actualiza el usuario existente
        User::where('_id', $request->data_id)
            ->update([
                'password' => Hash::make($request->newPass),
                'active'=> 'ON',
            ]);
            session()->flash('alert', ['type' => 'success', 'message' => 'Se ha registrado exitosamente!']);

            return Redirect::route('dashboard');
    }
}

}
