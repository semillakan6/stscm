<?php

namespace App\Livewire;

use Livewire\Component;
use App\Models\Dependencies;
use Illuminate\Http\Request;
use App\Models\LogModel;
use Illuminate\Support\Facades\Auth;

class DependenciesController extends Component
{
    public $dependencies, $name, $active, $status, $tag, $areas, $dependency_id, $depency_to_update;

    public $updateMode = false;

    public function index(Request $request)
    {
        if ($request->ajax()) {

            $data = Dependencies::where('active', '<>', 'OFF') // Exclude active OFF users
                ->get();

            return response()->json(['data' => $data]);
        }
    }

    public function render()
    {
        return view('tables.dependence');
    }
    public function mount()
    {
        $this->dispatch('rendered_data');
    }
    private function resetInputFields()
    {
        $this->name = "";
        $this->active = "";
        $this->status = "";
        $this->tag = "";
    }

    public function store()
    {

        $this->validate([
            'name' => 'required',
        ]);
        $validatedData = $this->generateTagAndUpdateData();

        $dependenci=Dependencies::create($validatedData);
        LogModel::create([
            'tag_log'   => 'Actividad en el Sistema',
            'made_log'   => Auth::user()->name,
            'alter_log'   => 'Creacion de dependencia',
            'info_log'   => 'Se creo la dependencia:' . $dependenci->name. ".",
            'alerts_log'   => 'Info',
            'status'   => '1',
            'madeToId'   => Auth::id(),
        ]);
        $this->dispatch('rendered_data');
        $this->dispatch('depedence_saved');
        $this->reset('name');
    }

    private function generateUniqueTag($tag)
    {
        $newTag = $tag;
        $counter = 1;

        while (Dependencies::where('tag', $newTag)->exists()) {
            $newTag = $tag . $counter;
            $counter++;
        }

        return $newTag;
    }
    private function generateTagAndUpdateData()
    {
        $name = $this->name;
        $name = ucwords(strtolower($name));
        $words = explode(' ', $name);
        $tag = '';
        foreach ($words as $word) {
            $tag .= substr($word, 0, 1);
        }
        // Comprueba si ya existe un registro con el mismo "tag"
        $existingTag = Dependencies::where('tag', $tag)->exists();
        if ($existingTag) {
            $tag = $this->generateUniqueTag($tag);
        }

        return [
            'name' => $name,
            'active' => 'ON',
            'status' => '1',
            'tag' => $tag,
        ];
    }
    public function edit($id)
    {
        $dependency = Dependencies::findOrFail($id);
        $this->dependency_id = $id;
        $this->name = $dependency->name; // Set $this->name with the name inside dependency

        $this->updateMode = true;
        $this->dispatch('nametoupdate');
    }

    public function cancel()
    {
        $this->updateMode = false;
        $this->reset();
        $this->dispatch('updatedcanceled');
    }

    public function update()
    {
        $validatedData = $this->validate([
            'name' => 'required',
        ]);

        $dependency = Dependencies::find($this->dependency_id);

        // Comprueba si el nombre ha cambiado
        if ($dependency->name !== $this->name) {
            // Genera un nuevo "tag" basado en el nuevo nombre
            $validatedData = $this->generateTagAndUpdateData();
        }
        // Actualiza otros campos
        $dependency->fill($validatedData);
        $dependency->save();

        $this->updateMode = false;

        $this->resetInputFields();
        $this->dispatch('dependenceupdated');
    }

    public function delete(Request $request)
    {
        if ($request->id) {
            Dependencies::where('_id', $request->id)
                ->update([
                    'active' => "OFF"
                ]);
            LogModel::create([
                'tag_log'   => 'Actividad en el Sistema',
                'made_log'   => Auth::user()->name,
                'alter_log'   => 'Eliminacion de Registro de dependencia',
                'info_log'   => 'Se ha eliminado el registro de la dependencia con ID:' . $request->id . ".",
                'alerts_log'   => 'Danger',
                'status'   => '1',
                'madeToId'   => Auth::id(),
            ]);

            return response()->json(['message' => '1']);
        } else {
            // error occured, return error message
            $error = "Hubo un problema al realizar la operacion";
            return response()->json(['message' => 'error', 'details' => $error]);
        }
    }

    public function getIdDependency($id)
    {
        $this->dispatch('init_areastable');
        $this->dependency_id = $id;
    }
}
