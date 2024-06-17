<div>
    {{-- @if (session()->has('message'))
        <div class="alert alert-success">
            {{ session('message') }}
        </div>
    @endif --}}

    <div id="includesContainer">
        <form class="p-4 rounded-lg" wire:submit.prevent="store">
            <input type="hidden" wire:model="dependency_id">

            <div class="form-group">
                <label for="name">Nombre de la Dependencia:</label>
                <input type="text" class="form-control" id="name" placeholder="Ingresa un nombre"
                    wire:model.change="name">
                @error('name')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="mt-4">
                @if ($updateMode)
                    <button wire:click.prevent="update()" class="btn btn-dark">Update</button>
                    <button wire:click.prevent="cancel()" class="btn btn-danger">Cancel</button>
                @else
                    <button type="submit" class="btn btn-success">
                        Guardar
                    </button>
                    <span wire:loading>cargando..</span>
                @endif
            </div>
        </form>
    </div>
    <div class="container">
        <div class="pt-4 table-responsive" wire:ignore>
            <table class="table datatable row-border hover compact stripe" id="tblDependence">
                <thead>
                    <tr>
                        <th>Dependencia</th>
                        <th>TAG</th>
                        <th>Areas</th>
                        <th>Acciones</th>
                    </tr>
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
    </div>

</div>
@push('scripts')
    <script type="text/javascript">
        Livewire.on('rendered_data', () => {
            destroy_table(['#tblDependence', '#tblDependence2']);
            tabledependences();
        });

        Livewire.on('depedence_saved', () => {
            succesModal({
                title: 'Dependencia Guardada'
            });
            limpiarNombres(['name']);
        })
        Livewire.on('dependenceupdated', () => {
            succesModal({
                title: 'Dependencia Actualizada'
            });
            limpiarNombres(['name']);
            destroy_table(['#tblDependence', '#tblDependence2']);
            tabledependences();
        })

        Livewire.on('updatedcanceled', () => {
            // Establecemos el nuevo valor en el input usando jQuery
            limpiarNombres(['name']);
            limpiarNombres(['areas']);
        })
        Livewire.on('init_areastable', () => {
            destroy_table(['#tblDependence2']);
            tableareas();
            limpiarNombres(['areas']);
        })
        Livewire.on('nametoupdate', () => {
            // Establecemos el nuevo valor en el input usando jQuery
            setValuesToInput([
                ['name', @this.name]
            ]);
        })

        function setValuesToInput(arrValues) {
            for (let i = 0; i < arrValues.length; i++) {
                let idInput = arrValues[i][0];
                let valueInput = arrValues[i][1];
                $('#' + idInput).val(valueInput);
            }

        }


        function tableareas() {
            $('#name').val("");
            let table2 = $('#tblDependence2').DataTable({
                responsive: true,
                dom: 'Bfrtip',
                buttons: [
                    'copy', 'excel', 'pdf'
                ],
                ajax: {
                    url: '{{ route('getAreas') }}', // URL para cargar los datos
                    data: function(d) {
                        d.dependence = @this.dependency_id; // Agrega el valor del input al request
                    },
                    dataSrc: 'areas' // Nombre del campo que contiene los datos en la respuesta JSON
                },
                columns: [{
                        data: 'area_name',
                    },
                    {
                        data: null,
                        orderable: false,
                        searchable: false,
                        render: function(areas, type, full, meta) {
                            return `<button type="button" class="btn btn-outline-secondary " onclick="setValuesToInput([['areas','${areas.area_name}'],['area_id','${areas._id.$oid}']])" wire:click="updateAreasView('${areas.area_name}','${areas._id.$oid}',false)"><i class="fas fa-edit")"></i> Actualizar</button>
                            <button type="button" class="btn btn-outline-danger " wire:click="updateAreasView('${areas.area_name}','${areas._id.$oid}',true)"><i class="fas fa-trash" ></i> Eliminar</button>`;
                        }
                    },

                ]
            });
        }

        function tabledependences() {
            let table = $('#tblDependence').DataTable({
                responsive: true,
                dom: 'Bfrtip',
                language: {
                    url: '//cdn.datatables.net/plug-ins/2.0.3/i18n/es-ES.json',
                },
                buttons: [
                    'copy', 'excel', 'pdf'
                ],
                ajax: {
                    url: '{{ route('dependence_info') }}', // URL para cargar los datos
                    data: function(d) {
                        //d.searchInput = $('#searchInput').val(); // Agrega el valor del input al request
                    },
                    dataSrc: 'data' // Nombre del campo que contiene los datos en la respuesta JSON
                },
                columns: [{
                        data: 'name'
                    },
                    {
                        data: 'tag'
                    },
                    {
                        data: null,
                        orderable: false,
                        searchable: false,
                        render: function(data, type, full, meta) {
                            return `<button type="button" class="btn btn-outline-dark areas-button" data-dependence='AddAreas/${data._id}' wire:click="getIdDependency('${data._id}')"><i class="fas fa-th-list"></i> Areas</button>`;
                        }
                    },
                    {
                        data: null,
                        orderable: false,
                        searchable: false,
                        render: function(data, type, full, meta) {
                            return `<button type="button" class="btn btn-outline-dark edit-button" wire:click="edit ('${data._id}')" ><i class="fas fa-edit"></i> Editar</button>
                                    <button type="button" class="btn btn-outline-danger delete-button" onclick="dynamicDelFunc('{{ url('delete_rgsdependence') }}', '${data._id}');"><i class="far fa-times-circle"></i> Eliminar</button>`;
                        }
                    }
                ],
                columnDefs: [{
                        targets: 1,
                        width: '20%'
                    }, {
                        targets: 0,
                        width: '30%'
                    }, {
                        targets: 2,
                        width: '30%'
                    }, {
                        targets: 3,
                        width: '50%'
                    }
                    // Define el ancho de la sexta columna (índice 5) como un porcentaje pequeño
                ]
            });
            $('body').on('click', '.areas-button', function() {
                const route = $(this).data('dependence');

                $.get(route, function(formContent) {
                    showModal({
                        title: "Areas Administrativas",
                        content: formContent,
                        width: 1000
                        // you can specify more options here like width, padding, background
                    });

                });
            });
        }

        function limpiarNombres(idinputs) {
            idinputs.forEach(function(nombre) {
                // Establecer el valor del elemento con el id 'name' en blanco
                $('#' + nombre).val("");
            });
        }
    </script>
@endpush
