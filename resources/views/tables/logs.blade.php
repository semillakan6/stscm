<div
    class="bg-white border-b border-gray-200 dark:bg-white dark:from-gray-700/50 dark:via-transparent dark:border-gray-700">
    <div class="p-6 lg:p-8">

        <div class="container">
            <h4 class="mb-3">Tabla de Logs</h4>
            <hr>

            {{-- <div>
                <form id="searchForm" method="POST" class="mt-3">
                    @csrf
                    <div class="row">
                        <div class="col-lg-4 col-sm-6 col-md-3">
                            <div class="mb-3 input-group">

                                <input type="text"
                                    class="w-full border border-gray-300 rounded-md shadow-sm form-control form-control-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm onlyDatePicker"
                                    id="startDateLogs" name="startDateLogs" placeholder="Fecha inicio" readonly
                                    required>
                            </div>

                        </div>
                        <div class="col-lg-4 col-sm-6 col-md-3">
                            <div class="mb-3 input-group">
                                <input type="text"
                                    class="w-full border border-gray-300 rounded-md shadow-sm form-control form-control-sm focus:ring-indigo-500 focus:border-indigo-500 sm:text-sm onlyDatePicker"
                                    id="endDateLogs" name="startDateLogs" placeholder="Fecha final" readonly required>
                            </div>

                        </div>
                        <div class="col-lg-4 col-sm-6 col-md-3">
                            <div class="mb-3 input-group">
                                <input type="text" class="form-control" id="username" name="username"
                                    placeholder="Nombre de usuario">
                            </div>

                        </div>
                        <div class="col-lg-4 col-sm-6 col-md-3">
                            <div class="mt-4 input-group">

                                <div class="ms-2 input-group-append">
                                    <button id="searchButton" class="btn btn-outline-primary">Buscar</button>
                                </div>
                            </div>

                        </div>
                    </div>

                </form>
            </div> --}}

            <div class="col-12">
                <div class="pt-4 table-responsive">
                    <table class="table datatable row-border hover stripe" id="tblLogs">
                        <thead>
                            <tr>
                                <th>Acción</th>
                                <th>Usuario</th>
                                <th>Detalles</th>
                                <th>Fecha</th>
                            </tr>
                        </thead>
                        <tbody>

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script type="text/javascript">
        Livewire.on('render', () => {

            let userPermissions = [];

            $.get('/user_permissions', function(data) {
                userPermissions = data;
            });

            let table = $('.datatable').DataTable({
                autoWidth: false,
                order: [3, 'desc'],
                dom: 'Bfrtip',
                language: {
                    url: '//cdn.datatables.net/plug-ins/2.0.3/i18n/es-ES.json',
                },
                buttons: [
                    'copy', 'excel', 'pdf'
                ],
                ajax: {
                    url: '{{ route('logs_table') }}',
                    data: function(d) {
                        d.startDate = $('#startDateLogs').val();
                        d.endDate = $('#endDateLogs').val();
                        d.username = $('#username').val();
                    },
                    dataSrc: function(json) {
                        //console.log(json); // output the raw AJAX response to browser console
                        return json.data;
                    }
                },
                columns: [{
                        data: 'alter_log'
                    },
                    {
                        data: 'made_log'
                    },
                    {
                        data: 'info_log'
                    },
                    {
                        data: 'date'
                    },
                ],
                // columnDefs: [{
                //         targets: 8,
                //         className: 'width-300'
                //     },
                //     {
                //         targets: 7,
                //         className: 'width-300'
                //     }, {
                //         targets: 9,
                //         className: 'width-400'
                //     }
                // ]
            });
            $('#searchForm').on('submit', function(e) {
                e.preventDefault();
                table.ajax.reload();
            });

        });
    </script>
@endpush
