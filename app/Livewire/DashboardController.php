<?php

namespace App\Livewire;

use Livewire\Component;
use Illuminate\Http\Request;
use App\Models\VehicleData;
use Illuminate\Support\Facades\Auth;
use App\Models\Service_Order_Addons;
use MongoDB\BSON\UTCDateTime;
use DateTime;

class DashboardController extends Component
{
    public $userSicotam;
    public function render()
    {

        return view('livewire.dashboard-controller');
    }
    public function mount()
    {
        $this->userSicotam = Auth::user();
        $this->dispatch('render_dashboard');
    }

    public function dashboard_table(Request $request)
    {

    }
}
