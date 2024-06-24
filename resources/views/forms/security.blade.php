<div class="py-12">
    <div class="max-w-7xl mx-auto">
        <div class="bg-white dark:bg-white shadow-xl rounded-lg">
            <div class="bg-white dark:bg-white border-b border-gray-200 dark:border-gray-700 rounded-lg">
                <div class="p-6 lg:p-8">
                    <div class="container">
                        <div class="row">
                            <div class="overflow-x-auto">
                                <table class="table w-full">
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
                                                    <button class="btn btn-ghost hs-collapse-toggle" type="button" data-hs-collapse="#permissions-{{ $role->id }}" wire:ignore>
                                                        Ver Permisos
                                                    </button>
                                                </td>
                                                <td>
                                                    <button class="btn btn-error" wire:ignore x-on:click="window.confirmDelete('{{ $role->id }}')">Eliminar</button>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td colspan="3" class="p-0" style="height: 0px; padding: 0px;">
                                                    <div id="permissions-{{ $role->id }}" class="hs-collapse hidden w-full overflow-hidden transition-[height] duration-300" wire:ignore.self>
                                                        <div class="card">
                                                            <div class="card-body">
                                                                @foreach ($permissions as $permission)
                                                                    <div class="form-control">
                                                                        <label class="label cursor-pointer p-0 flex justify-start">
                                                                            <input type="checkbox"
                                                                                class="toggle toggle-accent"
                                                                                value="{{ $permission->name }}"
                                                                                id="{{ $role->id . '-' . $permission->name }}"
                                                                                @if(in_array($permission->name, $role->permissions ?? [])) checked @endif
                                                                                wire:change="updatePermissions('{{ $role->id }}', '{{ $permission->name }}', $event.target.checked)">
                                                                            <span class="label-text">{!! $permission->icon !!} {{ ucwords(str_replace('_', ' ', $permission->description)) }}</span>
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
                title: '¿Estás seguro que deseas eliminarlo?',
                text: "No se podrá recuperar.",
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
                Swal.fire('Success!', 'Se ha eliminado el rol.', 'success');
            });
        });
    </script>
@endpush
