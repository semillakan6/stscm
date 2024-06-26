<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" data-theme="light">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <meta name="alert" content="{{ session('alert') ? json_encode(session('alert')) : json_encode('no alert data') }}">
    <meta name="alert_tmp"
        content="{{ session('alert-tmp') ? json_encode(session('alert-tmp')) : json_encode('no alert-tmp data') }}">
    <link rel="icon" href="{{ asset('assets/img/escudo.png') }}">
    <title>{{ config('app.name', 'Sistema de Tramites y Servicios') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts -->
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.css" />

    <script src="{{ asset('assets/js/jquery-3.5.1.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>

    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@10"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    @livewireScripts
    @stack('scripts')

    <!-- Styles -->
    @livewireStyles

</head>

<body class="font-sans antialiased">
    <x-banner />
    <div class="min-h-screen">
        <!-- Page Heading -->
        <x-header />
        @livewire('navigation-menu')
        <!-- Page Content -->
        <main>
            {{ $slot }}
        </main>
    </div>
    @stack('modals')

</body>

</html>
