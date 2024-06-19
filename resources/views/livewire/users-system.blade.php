<div class="p-6">
    <div class="mx-auto " style="max-width: 90%;">
        <div>
            <form id="searchForm" method="POST">
                <div class="col-lg-2 col-sm-6 col-md-3">
                    <div class="mb-3 input-group">
                        <input type="text" class="form-control form-control-sm" id="marca" name="marca"
                            placeholder="Marca">
                    </div>

                </div>
            </form>
        </div>
        <div class="card w-100 bg-base-100 shadow-xl">
            <div class="card-body">
                <table id="userstable" class="display">
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
        Livewire.on('rendered', () => {
            let table = new DataTable('#userstable', {
                autoWidth: false,
                order: [0, 'desc'],
                dom: 'Blfrtip',
                language: {
                    url: '//cdn.datatables.net/plug-ins/2.0.3/i18n/es-ES.json',
                },
                ajax: {
                    url: '{{ route('users_info') }}',
                    data: function(d) {
                        d.username = $('#username').val();
                    }
                }
            });
        });
    </script>
</div>
