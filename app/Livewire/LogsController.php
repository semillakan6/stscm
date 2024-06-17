<?php

namespace App\Livewire;

use App\Models\LogModel;
use Livewire\Component;
use Illuminate\Http\Request;

class LogsController extends Component
{

    public function mount(){
        $this->dispatch('render');

    }
    public function render()
    {
        return view('tables.logs');
    }

    public function index(Request $request)
    {
        if ($request->ajax()) {
            $startingDate = $request->input('startDate');
            $endDate = $request->input('endDate');
            $user = $request->input('username');
            $query = LogModel::where('status', '=', '1');
            if (!empty($startingDate) && !empty($endDate)) {
                $formattedStartingDate = \DateTime::createFromFormat('d/m/Y', $startingDate)->format('Y-m-d');
                $startingFormattedDate = date('Y-m-d\T00:00:00.000\Z', strtotime($formattedStartingDate));
                $endDateFormatted = \DateTime::createFromFormat('d/m/Y', $endDate)->format('Y-m-d');
                $formattedEndDate = date('Y-m-d\T23:59:59.999\Z', strtotime($endDateFormatted));#formato para que abarque todo el dia


                $query->whereBetween('starting_date', [
                    new UTCDateTime(strtotime($startingFormattedDate) * 1000),
                    new UTCDateTime(strtotime($formattedEndDate) * 1000)
                ]);
            } elseif (!empty($startingDate)) {
                $formattedStartingDate1 = \DateTime::createFromFormat('d/m/Y', $startingDate)->format('Y-m-d');
                $startingFormattedDate1 = date('Y-m-d\T00:00:00.000\Z', strtotime($formattedStartingDate1));
                $formattedStartingDate2 = \DateTime::createFromFormat('d/m/Y', $startingDate)->format('Y-m-d');
                $startingFormattedDate2 = date('Y-m-d\T23:59:59.999\Z', strtotime($formattedStartingDate2));#formato para que abarque todo el dia
                // dd($startingFormattedDate1,$startingFormattedDate2);
                $query->where('starting_date', '>=', new UTCDateTime(strtotime($formattedStartingDate1) * 1000));
                $query->where('starting_date', '<=', new UTCDateTime(strtotime($startingFormattedDate2) * 1000));
            }
            elseif (!empty($endDate)) {
                $formattedEndDate1 = date('Y-m-d\T00:00:00.000\Z', strtotime($endDate));
                $formattedEndDate2 = date('Y-m-d\T23:59:59.999\Z', strtotime($endDate));

                $query->where('starting_date', '>=', new UTCDateTime(strtotime($formattedEndDate1) * 1000));
                $query->where('starting_date', '<=', new UTCDateTime(strtotime($formattedEndDate2) * 1000));
            }

            if ($user) {
                $query->where('made_log', '=', $user);

            // if ($area) {
            //     $query->where('dependence', '=', $area);
            // }
            // $data = $query->get()->map(function ($datum) {
            //     $servicio = Service_Order_Addons::where('orderId', $datum->_id)->get();
            //     $datum->servicio = $servicio ? $servicio->toArray() : null;
            //     $datum->date = $datum->created_at->toDateTime()->format('Y-m-d');
            //     return $datum;
            // });
            }
        $data = $query->get()->map(function ($datum) {
            $datum->date = $datum->created_at->toDateTime()->format('Y-m-d H:i');
            return $datum;
        });
        return response()->json(['data' => $data->toArray()]);
     }
    }
}
