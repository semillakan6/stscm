<x-app-layout>
    <div class="py-12">
        <div class="container mx-auto">
            <div class="flex flex-wrap justify-around">
                <x-area-card title="<i class='fas fa-bullhorn mr-2'></i> Denuncias"
                    bodyText="<p class='text-4xl font-bold'>0</p>" />
                <x-area-card title="<i class='fas fa-search mr-2'></i> Investigación"
                    bodyText="<p class='text-4xl font-bold'>0</p>" />
                <x-area-card title="<i class='fas fa-file-invoice mr-2'></i> Substanciación"
                    bodyText="<p class='text-4xl font-bold'>0</p>" />
                <x-area-card title="<i class='fas fa-balance-scale mr-2'></i> Resolución"
                    bodyText="<p class='text-4xl font-bold'>0</p>" />
            </div>
        </div>
        <div class="container mx-auto py-8">
            <div class="card lg:card-side bg-base-100 shadow-xl" data-theme="light">
                <div class="overflow-x-auto">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Folio</th>
                                <th>Motivo</th>
                                <th>Denunciante</th>
                                <th>No. Servidores</th>
                                <th>Estatus</th>
                                <th>Calificativa</th>
                                <th>Etapa</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                        <tbody>
                            <tr class="hover">
                                <th>050000205</th>
                                <td>Causa daño a la hacienda publica o al patrimonio de una institucion</td>
                                <td class="text-center">
                                    <p class="font-bold">Anonimo</p>
                                </td>
                                <td class="text-center">0</td>
                                <td>
                                    <x-status-badge statusColor="bg-blue-600 text-white" statusText="Nuevo" />
                                </td>
                                <td><x-badge badgeColor="bg-yellow-50" badgeText="Falta grave" /></td>
                                <td>
                                    <x-area-label areaLabelPColor="bg-yellow-100" areaLabelSColor="text-yellow-600" areaLabelIcon="fas fa-search" areaLabelText="En Investigación" />
                                </td>
                                <td><button class="btn btn-ghost"><i class="fas fa-trash"></button></i></td>
                            </tr>
                            <tr class="hover">
                                <th>050000205</th>
                                <td>Causa daño a la hacienda publica o al patrimonio de una institucion</td>
                                <td class="text-center">
                                    <p class="font-bold">Anonimo</p>
                                </td>
                                <td class="text-center">0</td>
                                <td>
                                    <x-status-badge statusColor="bg-blue-600 text-white" statusText="Nuevo" />
                                </td>
                                <td><x-badge badgeColor="bg-pink-50" badgeText="Por definir" /></td>
                                <td>
                                    <x-area-label areaLabelPColor="bg-yellow-100" areaLabelSColor="text-yellow-600" areaLabelIcon="fas fa-search" areaLabelText="En Investigación" />
                                </td>
                                <td><button class="btn btn-ghost"><i class="fas fa-trash"></button></i></td>
                            </tr>
                            <tr class="hover">
                                <th>050000205</th>
                                <td>Causa daño a la hacienda publica o al patrimonio de una institucion</td>
                                <td class="text-center">
                                    <p class="font-bold">Anonimo</p>
                                </td>
                                <td class="text-center">0</td>
                                <td>
                                    <x-status-badge statusColor="bg-red-600 text-white" statusText="Cerrado" />
                                </td>
                                <td><x-badge badgeColor="bg-yellow-50" badgeText="Falta grave" /></td>
                                <td>
                                    <x-area-label areaLabelPColor="bg-orange-100" areaLabelSColor="text-orange-600" areaLabelIcon="fas fa-file-invoice" areaLabelText="En Substanciación" />
                                </td>
                                <td><button class="btn btn-ghost"><i class="fas fa-trash"></button></i></td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    </div>
</x-app-layout>
