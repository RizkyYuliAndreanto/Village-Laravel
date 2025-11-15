<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ config('app.name', 'Laravel') }}</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-gray-100 text-gray-900 dark:text-gray-100">
    <div class="min-h-screen flex flex-col">
        
        @include('layouts.partials.navbar')

        <main class="flex-grow">
            @yield('content')
        </main>

        @include('layouts.partials.footer')
        
    </div>
</body>
</html>