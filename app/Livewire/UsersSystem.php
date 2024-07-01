<?php

namespace App\Livewire;

use Illuminate\Http\Request;
use Livewire\Component;
use App\Models\User;

class UsersSystem extends Component
{
    public function mount()
    {
        $this->dispatch('render_users');
    }

    public function render()
    {
        return view('tables.users-system');

    }

    public function getUsersData(Request $request)
    {
        if ($request->ajax()) {
            $username = $request->input('username');
            $query = User::where('status', '=', '1');

            if ($username) {
                $query->where('username', '=', $username);
            }

            $users = $query->get();
            return response()->json(['data' => $users->toArray()]);
        }

    }

}
