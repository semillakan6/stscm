<?php

namespace App\Livewire;

use Livewire\Component;
use Livewire\Attributes\Layout;
use App\Models\Dependencies;
use Illuminate\Http\Request;
use App\Models\LogModel;
use Illuminate\Support\Facades\Auth;

use MongoDB\BSON\ObjectId;

class DependenciesAreasController extends Component
{
    public $dependency, $active, $status, $dependency_id, $areas;
    public $area_name, $area_id;
    public $updateareaMode;
    #[Layout('layouts.modals')]
    public function render()
    {
        return view('forms.dependence_addAreas');
    }
    public function mount($id)
    {
        $this->dependency_id = $id;
        $this->updateareaMode = false;
    }

    public function updateAreas($value)
    {
        $this->dependency = Dependencies::find($this->dependency_id);
        $this->validate([
            'areas' => 'required',
        ]);
        $AreaData = ['_id' => new ObjectId(), 'area_name' => $this->areas, 'status' => '1'];

        if ($value) {
            // Add permission
            $this->dependency->push('areas', $AreaData);
        }
        $this->dependency->save();
        $this->dispatch('init_areastable');
        $this->reset('areas');
    }

    public function updateAreaName($update)
    {
        $dependency = Dependencies::find($this->dependency_id);
        $this->validate([
            'areas' => 'required',
        ]);

        if ($dependency) {
            // Encuentra y actualiza el área específica por su ID
            foreach ($dependency->areas as $key => $area) {
                if ($area['_id'] == $this->area_id) {
                    // Actualiza el nombre del área utilizando el método update
                    if ($update) {
                        Dependencies::where('_id', $this->dependency_id)
                            ->update(['areas.' . $key . '.area_name' => $this->areas,]);
                    } else {
                        Dependencies::where('_id', $this->dependency_id)
                            ->update(['areas.' . $key . '.status' => 0,]);
                    }
                    // Termina el bucle una vez que se ha encontrado y actualizado el área
                    break;
                }
            }

            // Marcamos que estamos en modo de actualización
            $this->updateareaMode = false;
        }
        $this->dispatch('init_areastable');
    }


    public function cancelAreas()
    {
        $this->reset('areas');
        $this->dispatch('updatedcanceled');
        $this->updateareaMode = false;
    }
    public function updateAreasView($area, $id, $isdelete)
    {
        $this->areas = $area;
        $this->area_id = $id;
        if ($isdelete) {
            $this->updateAreaName(false);
        } else {
            $this->updateareaMode = true;
        }
    }
    public function getAreas(Request $request)
    {
        if ($request->ajax()) {
            $data = Dependencies::find($request->dependence);
            $areas = [];
            if ($data) {
                $areas = array_filter($data->areas ?? [], function ($area) {
                    return isset($area['status']) && $area['status'] == 1;
                });

                // Reindexar el array después de la filtración
                $areas = array_values($areas);
                return response()->json(['areas' => $areas]);
            } else {
                return response()->json(['areas' => $areas]);
            }
        }
    }
}