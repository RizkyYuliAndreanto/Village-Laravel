<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'VillageLaravel') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100 text-gray-900 dark:bg-gray-950 dark:text-gray-100">

    <div class="flex flex-col min-h-screen">

        {{-- Navbar --}}
        @include('layouts.partials.navbar')
        
        {{-- Konten utama (section penuh layar) --}}
        <main class="flex-grow w-full">
            @yield('content')
        </main>

        {{-- Footer --}}
        @include('layouts.partials.footer')

    </div>

    {{-- Stack untuk script khusus halaman (seperti Chart.js) --}}
    @stack('scripts')
</body>
</html>