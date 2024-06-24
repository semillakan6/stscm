<div class="p-6">
    <div class="mx-auto " style="max-width: 90%;">

        <div class="card w-100 bg-base-100 shadow-xl">
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
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>

            </div>
        </div>

    </div>
    <script>
        Livewire.on('render_users', () => {
            // Select the input element by its ID

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

        })
    </script>
</div>
