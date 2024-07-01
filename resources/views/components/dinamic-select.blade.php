<div class="{{ $col }}">
    <div class="form-group">
        <div class="">
            <select class="select2 js-states {{ $class }}" id="{{ $id }}"
                name="{{ $multiSelect ? $id . '[]' : $id }}" wire:model="{{ $id }}"
                wire:model.change="{{ $id }}" {{ $required }} data-multiple="{{ $multiSelect }}"
                {{ $multiSelect ? 'multiple=multiple' : '' }} data-placeholder="Seleccione una opción...">
                <option></option>
                @if ($useOptgroups && $optgroupField && $optionsArrayName)
                    @foreach ($collection as $item)
                        @if (isset($item[$optgroupField]))
                            <optgroup label="{{ $item[$optgroupField] }}">
                                @if (isset($item[$optionsArrayName]) && is_array($item[$optionsArrayName]))
                                    @foreach ($item[$optionsArrayName] as $option)
                                        @if (isset($option[$optionValueField]) && isset($option[$optionDisplayField]))
                                            <option value="{{ $option[$optionDisplayField] }}">
                                                {{ $option[$optionDisplayField] }}</option>
                                        @endif
                                    @endforeach
                                @endif
                            </optgroup>
                        @endif
                    @endforeach
                @else
                    @foreach ($collection as $item)
                        @if (isset($item[$fields[0]]))
                            <option value="{{ $item[$fields[0]] }}">{{ $item[$fields[0]] }}</option>
                        @endif
                    @endforeach
                @endif
            </select>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        $('.select2').each(function() {
            var isMultiple = $(this).data('multiple') || false;
            $(this).select2({
                multiple: isMultiple,
                placeholder: 'Seleccione una opción...',
                allowClear: true
            });

            // Explicitly clear the selection
            /*if(isMultiple){
                $(this).val(null).trigger('change');
            }*/
        });
    });
</script>
