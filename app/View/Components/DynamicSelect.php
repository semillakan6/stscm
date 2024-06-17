<?php

namespace App\View\Components;

use Closure;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;
use Illuminate\Support\Facades\Auth;
use App\Models\Dependencies;

class DynamicSelect extends Component
{
    public $collectionName;
    public $required;
    public $selectName, $col, $id;
    public $fields;
    public $collection;
    public $class;
    public $useOptgroups, $optgroupField, $optionsArrayName, $optionValueField, $optionDisplayField, $multiSelect;


    /*
    * Create a new component instance.
    */
    public function __construct($collectionName, $selectName, $fields, $col, $id, $class, $useOptgroups = false, $optgroupField = null, $optionsArrayName = null, $optionValueField = null, $optionDisplayField = null, $required=null, $multiSelect=false) // Added $optionValueField = null, $optionDisplayField = null
    {
        $this->collectionName = $collectionName;
        $this->selectName = $selectName;
        $this->col = $col;
        $this->id = $id;
        $this->required = $required;
        $this->fields = $fields;
        $this->class = $class;
        $this->useOptgroups = $useOptgroups;
        $this->optgroupField = $optgroupField;
        $this->optionsArrayName = $optionsArrayName;
        $this->optionValueField = $optionValueField; // Store value field
        $this->optionDisplayField = $optionDisplayField; // Store display field
        $this->fields = is_array($fields) ? $fields : [$fields]; // Ensure that $fields is an array
        $this->multiSelect = $multiSelect; // Store multi-select state

        $this->collection = $this->getCollectionData();

    }

    /**
     * Get the view / contents that represent the component.
     */
    public function render()
    {
        return view('components.dynamic-select', [
            'selectName' => $this->selectName,
            'collection' => $this->collection,
            'col' => $this->col,
            'id' => $this->id,
            'useOptgroups' => $this->useOptgroups,
            'optgroupField' => $this->optgroupField,
            'optionsArrayName' => $this->optionsArrayName,
            'required'=> $this->required,
            'multiSelect' => $this->multiSelect,
        ]);
    }

    private function getCollectionData()
    {
        $modelClassName = "App\\Models\\" . $this->collectionName;

        if (class_exists($modelClassName)) {
            $model = new $modelClassName;

            $documents = $model::where('active', '<>', 'OFF')->where('status', '<>', 0); // Retrieve all documents
            if ($this->collectionName == 'CarInventory' && Auth::user()->role != 'super-admin') {
                $areasDependencies = Dependencies::where('name', '=', Auth::user()->dependence)->first();
                foreach ($areasDependencies->areas as $areas) {

                    $documents->orWhere('area', $areas['area_name']);
                }

            }

            $filteredDocuments = $documents->get()->map(function ($document) {
                $fieldData = [];
                foreach ($this->fields as $field) { // Iterate over fields
                    if (isset($document->$field)) {
                        $fieldData[$field] = is_string($document->$field) ? trim($document->$field) : $document->$field; // Collect and trim the data for each field
                    }
                }
                if ($this->useOptgroups && $this->optionsArrayName) {
                    // Filter the '$optionsArrayName' array to exclude items with 'status' of 0 and trim names
                    if (isset($document->{$this->optionsArrayName}) && is_array($document->{$this->optionsArrayName})) {
                        $filteredOptionsArray = array_filter($document->{$this->optionsArrayName}, function ($option) {
                            return isset($option['status']) && $option['status'] != 0;
                        });

                        // Trim the names and other string fields in the filtered options array
                        $trimmedOptionsArray = array_map(function ($option) {
                            return array_map(function ($value) {
                                return is_string($value) ? trim($value) : $value;
                            }, $option);
                        }, $filteredOptionsArray);

                        $fieldData[$this->optionsArrayName] = $trimmedOptionsArray;
                    }
                }
                return $fieldData;
            });

            // Final pass to ensure all strings are trimmed before returning
            $trimmedFilteredDocuments = $filteredDocuments->map(function ($document) {
                return array_map(function ($value) {
                    if (is_array($value)) {
                        return array_map(function ($innerValue) {
                            return is_string($innerValue) ? trim($innerValue) : $innerValue;
                        }, $value);
                    }
                    return is_string($value) ? trim($value) : $value;
                }, $document);
            });


            return collect($filteredDocuments);
        }

        return collect();
    }
}
