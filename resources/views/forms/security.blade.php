<div class="py-12">
    <div class="max-w-7xl">
        <div class="bg-white dark:bg-white overflow-hidden shadow-xl sm:rounded-lg">
            <div
                class="bg-white dark:bg-white dark:from-gray-700/50 dark:via-transparent border-b border-gray-200 dark:border-gray-700">
                <div class="p-6 lg:p-8">
                    <div class="container">
                        <div class="row">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Roles</th>
                                            <th>Permisos</th>
                                            <th>Acciones</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($roles as $role)
                                            <tr>
                                                <td>{!! $role->icon !!} {{ $role->role }}</td>
                                                <td>
                                                    <button class="btn btn-link" 
                                                            type="button" 
                                                            data-bs-toggle="collapse" 
                                                            data-bs-target="#permissions-{{ $role->id }}" 
                                                            aria-expanded="false" 
                                                            aria-controls="permissions-{{ $role->id }}">
                                                        Ver Permisos
                                                    </button>
                                                </td>
                                                <td>
                                                    <button class="btn btn-danger" 
                                                        wire:ignore
                                                        x-on:click="window.confirmDelete('{{ $role->id }}')">Eliminar</button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3">
                                                    <div wire:ignore.self class="collapse" id="permissions-{{ $role->id }}">
                                                        <div class="card">
                                                            <div class="card-body">
                                                                @foreach ($permissions as $permission)
                                                                    <div class="form-check">
                                                                        <input class="form-check-input" 
                                                                            type="checkbox"
                                                                            value="{{ $permission->name }}"
                                                                            id="{{ $role->id . '-' . $permission->name }}"
                                                                            @if(in_array($permission->name, $role->permissions ?? [])) checked @endif
                                                                            wire:change="updatePermissions('{{ $role->id }}', '{{ $permission->name }}', $event.target.checked)">
                                                                        <label class="form-check-label"
                                                                            for="{{ $role->id . '-' . $permission->name }}">
                                                                            {!! $permission->icon !!}
                                                                            {{ ucwords(str_replace('_', ' ', $permission->description)) }}
                                                                        </label>
                                                                    </div>
                                                                @endforeach
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@push('scripts')
    <script>
        window.confirmDelete = function(roleId) {
            Swal.fire({
                title: '¿Estas seguro que deseas eliminarlo?',
                text: "No se podra recuperar.",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#000',
                cancelButtonColor: '#d33',
                confirmButtonText: 'Borrar!',
                cancelButtonText: 'Cancelar'
            }).then((result) => {
                if (result.isConfirmed) {
                    @this.call('destroy', roleId)
                }
            })
        }
        
        document.addEventListener('livewire:initialized', () => {
            @this.on('role-deleted', () => {
                // Alert when post is created.
                Swal.fire('Success!', 'Se ha eliminado el rol.', 'success');
            });
        });
    </script>
@endpush
