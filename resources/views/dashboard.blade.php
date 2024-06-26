<x-app-layout>
    <div class="py-12">
        <div class="container mx-auto">
            <div class="flex flex-wrap">
                <x-area-card>
                    @section('title')
                        <i class="fas fa-bullhorn mr-2"></i> Denuncias
                    @endsection
                    @section('body-text')
                        <p class="text-4xl font-bold">0</p>
                    @endsection
                </x-area-card>
                <x-area-card>
                    @section('title')
                        <i class="fas fa-search mr-2"></i> Investigación
                    @endsection
                    @section('body-text')
                        <p class="text-4xl font-bold">0</p>
                    @endsection
                </x-area-card>
                <x-area-card>
                    @section('title')
                        <i class="fas fa-file-invoice mr-2"></i> Substanciación
                    @endsection
                    @section('body-text')
                        <p class="text-4xl font-bold">0</p>
                    @endsection
                </x-area-card>
                <x-area-card>
                    @section('title')
                        <i class="fas fa-balance-scale mr-2"></i> Resolución
                    @endsection
                    @section('body-text')
                        <p class="text-4xl font-bold">0</p>
                    @endsection
                </x-area-card>
            </div>
        </div>
        <div class="card lg:card-side bg-base-100 shadow-xl">

        </div>
    </div>
    </div>
</x-app-layout>
