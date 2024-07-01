<div>
    <label class="form-control">
        <div class="label">
            <span class="label-text">Nombre Completo:</span>
        </div>
        <input type="text" class="input input-bordered" placeholder="Ejemplo: Juan Cardenas Perez" wire:model="name" />
        @error('name')
            <div class="label">
                <span class="label-text-alt text-rose-600">{{ $message }}</span>
            </div>
        @enderror
    </label>
    <label class="form-control">
        <div class="label">
            <span class="label-text">Nombre usuario:</span>
        </div>
        <input type="text" class="input input-bordered" placeholder="Ejemplo: Johan_Alberto" wire:model="username" />
        <div class="label">
            <span class="label-text-alt">Bottom Left label</span>
        </div>
    </label>
    <label class="form-control">
        <div class="label">
        </div>
        <div class="grid grid-cols-2 gap-2">
            <div>
                <div class="label">
                    <span class="label-text">Rol:</span>

                </div>
                <x-dinamic-select :class="'form-control w-full'" :selectName="'Rol*'" :col="'col-md-12'" :fields="['name']"
                    :collectionName="'Role'" :useOptgroups="false" id="role" optionsArrayName="" optionValueField=""
                    optionDisplayField="" :multiSelect="false" />

                <div class="label">
                    <span class="label-text-alt">Bottom Left label</span>
                </div>
            </div>

            <div>
                <div class="label">
                    <span class="label-text">Area:</span>
                </div>
                <x-dinamic-select :class="'form-control w-full '" :selectName="'Dependencia*'" :col="'col-md-12'" :fields="['name']"
                    :collectionName="'Dependencies'" :useOptgroups="true" id="area" optgroupField="name" optionsArrayName="areas"
                    optionValueField="_id" optionDisplayField="area_name" />
            </div>
        </div>
    </label>
    <div class="form-control m-10">
        <button wire:click="save_user" wire:loading.attr="disabled" class="btn btn-neutral">
            Guardar
        </button>
        <span wire:loading><button class="btn">
                <span class="loading loading-spinner"></span>
                loading
            </button></span>
    </div>
</div>
