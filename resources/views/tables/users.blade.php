<x-app-layout>
    <div
        class="bg-white border-b border-gray-200 dark:bg-white dark:from-gray-700/50 dark:via-transparent dark:border-gray-700">
        <div class="p-6 lg:p-8">
            <div class="container">
                <div class="row">
                    <div class="col-lg-6 col-sm-12 col-md-4">
                        <form id="searchForm" method="POST" class="mt-3">
                            @csrf
                            <div class="mb-3 input-group">
                                <input type="text" class="form-control" id="searchInput" name="searchInput"
                                    placeholder="Buscar usuario">
                                <div class="input-group-append">
                                    <button id="searchButton" class="btn btn-outline-primary">Buscar</button>
                                </div>
                            </div>
                        </form>
                    </div>
                    <div class="col-lg-2 col-md-2 col-sm-6">
                        <div class="mt-3 input-group-append">
                            <button id="crearButton" class="btn btn-success" onclick="add()">Agregar
                                Usuario</button>
                        </div>
                    </div>
                </div>
                <div class="pt-4 table-responsive">
                    <table class="table row-border hover compact stripe" id="example">
                        <thead>
                            <tr>
                                <th>Nombre</th>
                                <th>Email</th>
                                <th>Area</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
            {{-- modal starts --}}
            <div class="modal fade" id="company-modal" aria-hidden="true">
                <div class="modal-dialog modal-lg">
                    <div class="modal-content">
                        <div class="modal-header">
                            <h4 class="modal-title" id="CompanyModal"></h4>
                        </div>
                        <div class="modal-body">
                            <form action="{{ url('users_create') }}" id="CompanyForm" name="CompanyForm"
                                class="form-horizontal" method="POST" enctype="multipart/form-data">
                                @csrf
                                <input type="hidden" name="id" id="id">
                                <div class="row">
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name" class=" control-label">Nombre del
                                                personal:</label>
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control" id="name" name="name"
                                                    placeholder="Ejemplo: Juan de Jesus Matamoros" maxlength="50"
                                                    required="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name" class="col-sm-2 control-label">Username:</label>
                                            <div class="col-sm-12">
                                                <input type="text" class="form-control" id="username"
                                                    name="username" placeholder="Ejemplo: Juan24" maxlength="50"
                                                    required="">
                                            </div>
                                        </div>
                                    </div>
                                    <div class="pt-1 col-md-6 ">
                                        <x-dynamic-select :class="'form-select form-select-sm w-full border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500 shadow-sm sm:text-sm'" :selectName="'Rol*'" :col="'col-md-12'"
                                            :fields="['name']" :collectionName="'Role'" :useOptgroups="false" id="rol"
                                            optionsArrayName="" optionValueField="" optionDisplayField="" />
                                    </div>

                                    <div class="pt-1 col-md-6 ">
                                        <x-dynamic-select :class="'form-select form-select-sm w-full border border-gray-300 rounded-md focus:ring-indigo-500 focus:border-indigo-500 shadow-sm sm:text-sm'" :selectName="'Dependencia*'" :col="'col-md-12'"
                                            :fields="['name']" :collectionName="'Dependencies'" :useOptgroups="true" id="area"
                                            optgroupField="name" optionsArrayName="areas" optionValueField="_id"
                                            optionDisplayField="area_name" />
                                    </div>
                                    <div class="col-md-6">
                                        <div class="form-group">
                                            <label for="name" class="col-sm-6 control-label">Correo
                                                Electronico:</label>
                                            <div class="col-sm-12">
                                                <input type="email" class="form-control" id="email" name="email"
                                                    placeholder="Email" maxlength="50">
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <div class="mt-2 col-sm-offset-2 col-sm-10">
                                    <button type="submit" class="btn btn-secondary" id="btn-save">Guardar
                                    </button>
                                </div>

                            </form>
                        </div>
                        <div class="modal-footer">

                        </div>
                    </div>
                </div>
            </div>
        </div>
        {{-- modal ends --}}
        <script type="text/javascript">
            $(document).ready(function() {
                $('.select2').select2();
            });
            $(document).on('click', '.delete-button', function() {
                var data = $(this).data('data');
                deleteFunc(data);
            });
            $(document).on('click', '.edit-button', function() {
                var data = $(this).data('data');
                editFunc(data);
            });
            $(document).on('click', '.reset-button', function() {
                var data = $(this).data('data');
                resetFunc(data);
            });
            let table = $('#example').DataTable({
                responsive: true,
                dom: 'Bfrtip',
                language: {
                    url: '//cdn.datatables.net/plug-ins/2.0.3/i18n/es-ES.json',
                },
                buttons: ['excel'],
                ajax: {
                    url: '{{ route('users') }}', // URL para cargar los datos
                    data: function(d) {
                        d.searchInput = $('#searchInput').val(); // Agrega el valor del input al request
                    },
                    dataSrc: 'data' // Nombre del campo que contiene los datos en la respuesta JSON
                },
                columns: [{
                        data: 'name'
                    },
                    {
                        data: 'email'
                    },
                    {
                        data: 'area'
                    },
                    {
                        data: null,
                        name: 'action',
                        orderable: false,
                        searchable: false,
                        render: function(data, type, full, meta) {
                            // Agregar dos botones en la tercera columna
                            return `<button type="button" class="btn btn-danger delete-button" data-data='${JSON.stringify(data)}'>Eliminar</button>
                                    <button type="button" class="btn btn-secondary edit-button" data-data='${JSON.stringify(data)}'>Editar</button>
                                    <button type="button" style="background-color:rgb(255, 192, 0); color:white;"class="btn reset-button" data-data='${JSON.stringify(data)}'>Reset</button>`;
                        }
                    }
                ],
                columnDefs: [{
                        targets: 2,
                        width: '20%'
                    } // Define el ancho de la tercera columna (índice 2) como un porcentaje pequeño
                ]
            });
            $('#searchForm').on('submit', function(e) {
                e.preventDefault();
                table.ajax.reload();
            });

            function deleteFunc(id) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "POST",
                    url: "{{ url('users_delete') }}",
                    data: {
                        id: id
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.message === 'User reseted successfully') {
                            // Refresh or update the UI as needed
                            location.reload(); // Refresh the page for example
                        } else {
                            console.error('Error deleting user:', response);
                        }
                    }
                });
            }

            function resetFunc(id) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "POST",
                    url: "{{ url('users_reset') }}",
                    data: {
                        id: id
                    },
                    dataType: 'json',
                    success: function(response) {
                        if (response.message === 'User reseted successfully') {
                            // Refresh or update the UI as needed
                            location.reload(); // Refresh the page for example
                        } else {
                            console.error('Error deleting user:', response);
                        }
                    }
                });
            }

            function editFunc(id) {
                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                    }
                });
                $.ajax({
                    type: "POST",
                    url: "{{ url('users_edit') }}",
                    data: {
                        id: id
                    },
                    dataType: 'json',
                    success: function(res) {
                        var user = res[0];
                        $('#CompanyModal').html("Actualizar Usuario");
                        $('#company-modal').modal('show');
                        $('#id').val(user._id);
                        $('#name').val(user.name);
                        $('#username').val(user.username);
                        $('#email').val(user.email);
                        $("#rol").val(user.role);
                        $("#area").val(user.area);
                    }
                });
            }

            function add() {
                $('#CompanyForm').trigger("reset");
                $('#CompanyModal').html("Añadir Usuario");
                $('#company-modal').modal('show');
                $('#id').val('');
            }
        </script>
    </div>
</x-app-layout>
