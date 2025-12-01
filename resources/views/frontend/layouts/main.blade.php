<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Desa Banyukambang')</title>
    
    <!-- Preload fonts for better performance -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS dan Font Awesome -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Font Awesome Icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Horizontal Scroll CSS -->
    <link rel="stylesheet" href="{{ asset('css/horizontal-scroll.css') }}">
    
    @stack('styles')
    
    <style>
        html {
            scroll-behavior: smooth;
            font-family: 'Inter', system-ui, -apple-system, sans-serif;
        }
        
        body {
            padding-top: 80px; /* Space untuk fixed navbar */
        }
    </style>
</head>
<body class="main-gradient min-h-screen">
    @include('frontend.layouts.partials.navbar')

    <main class="relative">
        @yield('content')
    </main>

    @include('frontend.layouts.partials.footer')


    
    @stack('scripts')
</body>
</html>