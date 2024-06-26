<x-app-layout>
    <div class="py-12">
        <div class="container mx-auto">
            <div class="card bg-base-100 w-72 ">
                <div class="card-body items-start text-start prose prose-slate pt-2 pb-2 pl-2">
                    <h2 class="card-title mb-0 font-normal text-lg">
                        <i class="fas fa-bullhorn"></i> Denuncias
                    </h2>
                    <p class="prose-strong text-2xl font-bold">0</p>
                </div>
            </div>
            <div class="card lg:card-side bg-base-100 shadow-xl">

            </div>
        </div>
    </div>
    <script>
        let table = new DataTable('#myTable', {
            // config options...
        });
    </script>
</x-app-layout>
