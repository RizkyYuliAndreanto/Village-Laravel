<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Desa Banyukambang')</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <style>
        /* Navbar full width fix */
        nav[class*="fixed"] {
            width: 100vw !important;
            left: 0 !important;
            right: 0 !important;
            margin: 0 !important;
        }
        
        nav[class*="fixed"] > div {
            max-width: none !important;
            width: 100% !important;
            margin: 0 !important;
        }
        
        body {
            padding-top: 80px; /* Space untuk fixed navbar */
            margin: 0 !important;
        }
        
        @media (max-width: 767px) {
            body {
                padding-top: 70px; /* Smaller padding for mobile */
            }
        }
    </style>
    </head>
<body class="main-gradient min-h-screen">
    @include('frontend.layouts.partials.navbar')

    <main>
        @yield('content')
    </main>

    @include('frontend.layouts.partials.footer')
</body>
</html>