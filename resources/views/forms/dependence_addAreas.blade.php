<div style="modal-with">
    <div class="container">
        <form class="p-4 rounded-lg">

            <div class="form-group">
                <input type="hidden" wire:model="area_id" id="area_id">

                <label for="name">Nombre del area:</label>
                <input type="text" class="form-control" id="areas" placeholder="Ingresa un nombre"
                    wire:model="areas">
                @error('areas')
                    <span class="text-danger">{{ $message }}</span>
                @enderror
            </div>

            <div class="mt-4">
                @if ($updateareaMode)
                    <div id="areasNameActions">
                        <button wire:click.prevent="updateAreaName(true)" class="btn btn-secondary">Actualizar</button>
                        <button wire:click.prevent="cancelAreas()" class="btn btn-danger">Cancel</button>
                    </div>
                @else
                    <div id="saveareaAction">
                        <button wire:click.prevent="updateAreas(true)" onclick="cleanFields(['areas'])"
                            class="btn btn-success">
                            Guardar
                        </button>
                        <span wire:loading>Guardando...</span>
                    </div>
                @endif
            </div>
        </form>

        <div class="pt-4 table-responsive" wire:ignore>
            <table class="table datatable row-border hover compact stripe w-100" id="tblDependence2">
                <thead>
                    <tr>
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
