<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Infografis - Website Desa')</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Chart.js - Versi yang paling stabil -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/3.9.1/chart.min.js"></script>
    
    <!-- Custom CSS untuk Infografis -->
    <link rel="stylesheet" href="{{ asset('css/infografis-tahun-selector.css') }}">
    
    <style>
        .infografis-section {
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
        }
        .infografis-card {
            background: rgba(255, 255, 255, 0.9);
            backdrop-filter: blur(10px);
        }
        .infografis-title {
            color: #0c4a6e;
        }
        .infografis-subtitle {
            color: #075985;
        }
    </style>
</head>
<body class="bg-gradient-to-br from-slate-50 to-blue-50">
    @include('frontend.layouts.partials.navbar')

    <main>
        @yield('content')
    </main>

    @include('frontend.layouts.partials.footer')
    
    <!-- Debug Chart.js -->
    <script>
        console.log('Chart.js loaded:', typeof Chart !== 'undefined');
        if (typeof Chart === 'undefined') {
            console.error('Chart.js is not loaded properly!');
        }
    </script>
    
    <!-- Stack untuk script tambahan dari sections -->
    @stack('scripts')
    
    <!-- Custom JS untuk Infografis -->
    <script src="{{ asset('js/infografis-simple.js') }}"></script>
</body>
</html>