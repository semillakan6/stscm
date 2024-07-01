<div class="p-6">
    <div class="mx-auto " style="max-width: 90%;">

        <div class="card w-100 bg-base-100 shadow-xl">

            <div class="card-body grid grid-cols-4 gap-2 adduser">

            </div>
            <div class="card-body" style="">
                <form id="searchForm" method="POST">
                    <label class="form-control ">

                        <div class="grid grid-cols-4 gap-2">
                            <div class="">
                                <div class="label">
                                    <span class="label-text">Dependencia</span>
                                </div>
                                <input type="text" placeholder="Transito" class="input input-bordered " />

                            </div>
                            <div class="">
                                <div class="label">
                                    <span class="label-text">Rol</span>
                                </div>
                                <input type="text" placeholder="super-admin" class="input input-bordered " />
                            </div>
                        </div>


                    </label>
                </form>
            </div>
            <div class="card-body">
                <table id="userstable" class="display" style="width:100%">
                    <thead>
                        <tr>
                            <th>Nombre</th>
                            <th>Nickname</th>
                            <th>Rol</th>
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
        <script>
            Livewire.on('render_users', () => {
                // Select the input element by its ID
                let userPermissions = [];

                $.get('/user_permissions', function(data) {
                    userPermissions = data;
                });
                let table = new DataTable('#userstable', {
                    autoWidth: false,
                    order: [0, 'desc'],
                    dom: 'Blfrtip',
                    language: {
                        url: 'https://cdn.datatables.net/plug-ins/1.11.5/i18n/es-ES.json',
                    },
                    ajax: {
                        url: '{{ route('users_info') }}',
                        data: function(d) {
                            d.username = $('#username').val();
                        }
                    },
                    columns: [{
                            data: 'name'
                        },
                        {
                            data: 'username'
                        },
                        {
                            data: 'role'
                        },
                        {
                            data: null,
                            orderable: false,
                            searchable: false,
                            render: function(data, type, full, meta) {
                                let buttons = '';
                                buttons += createModalButton(data._id, 'Editar', 'fas fa-plus',
                                    'info', 'edit_user_modal/', 'Editar_Usuario', true);
                                return `<div class="flex justify-center mt-2">${buttons}</div>`;
                            }
                        }
                    ],
                    initComplete: function(settings, json) {
                        // Modify the search input after DataTables initialization
                        const searchInput = document.getElementById('dt-search-0');
                        const selectInput = document.getElementById('dt-length-0');

                        // Check if the element exists before modifying it
                        if (searchInput) {
                            // Remove the gray style classes
                            searchInput.classList.remove(
                                'border-gray-200',
                                'placeholder-gray-500',
                                'dark:bg-gray-800',
                                'dark:border-gray-600',
                                'dark:placeholder-gray-400'
                            );
                            selectInput.classList.remove(
                                'border-gray-200',
                                'focus:border-blue-500',
                                'focus:ring',
                                'focus:ring-blue-500',
                                'focus:ring-opacity-50',
                                'dark:bg-gray-800',
                                'dark:border-gray-600',
                                'dark:focus:border-blue-500',
                                'px-3'
                            );
                            selectInput.classList.add('px-5');

                            // Optionally, you can add classes to apply new styles
                            // searchInput.classList.add('new-style');
                        } else {
                            console.error("Search input with ID 'dt-search-0' not found.");
                        }
                    }

                });
                $(document).ready(function() {
                    const newButton = createModalButton('', 'crearUsuario',
                        'fa fa-user-edit', 'success', 'user_modal/', 'Añadir Usuario');
                    $('.adduser').append(newButton);
                });
            })
            Livewire.on('render_select2', () => {
                $(document).ready(function() {
                    $(".select2").select2();

                });
                $(".select2").select2().on('change', function(e) {
                    let id = $(this).attr('id');
                    let value = $(this).val();
                    Livewire.dispatch('updateSelect2', {
                        id: id,
                        value: value
                    }); // Use Livewire.emit to call a method on the component
                });
            })
        </script>
    @endpush
</div>
