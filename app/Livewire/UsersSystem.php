<?php

namespace App\Livewire;
use Illuminate\Http\Request;
use Livewire\Component;

class UsersSystem extends Component
{
    public function render()
    {
        return view('livewire.users-system');
    }

    public function getUsersData(Request $request){
        if($request->ajax()){
            $username = $request->input('username');
            $query=User::query()
            ->where()
            ->get();
        }
    }
}
