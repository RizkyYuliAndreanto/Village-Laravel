<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Desa Banyukambang')</title>
    
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- Chart.js -->
    <script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.min.js"></script>
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom Styles -->
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
            font-family: 'Poppins', sans-serif;
            background: linear-gradient(135deg, #f0f9ff 0%, #e0f2fe 100%);
            min-height: 100vh;
            padding-top: 80px; /* Space untuk fixed navbar */
            margin: 0 !important;
        }
        
        @media (max-width: 767px) {
            body {
                padding-top: 70px; /* Smaller padding for mobile */
            }
        }
        .apbdes-card {
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border-radius: 1rem;
            box-shadow: 0 10px 30px rgba(0, 0, 0, 0.1);
            border: 1px solid rgba(255, 255, 255, 0.2);
        }
        .apbdes-title {
            color: #0c4a6e;
        }
        .apbdes-subtitle {
            color: #075985;
        }
        .loading-spinner {
            display: inline-block;
            width: 20px;
            height: 20px;
            border: 3px solid #f3f3f3;
            border-top: 3px solid #0ea5e9;
            border-radius: 50%;
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
        .year-selector {
            transition: all 0.3s ease;
        }
        .year-selector:focus {
            ring: 2px;
            ring-color: #0ea5e9;
            border-color: #0ea5e9;
        }
    </style>
    
    @stack('styles')
</head>
<body class="main-gradient min-h-screen bg-gradient-to-br from-slate-50 to-blue-50">
    @include('frontend.layouts.partials.navbar')

    <main>
        @yield('content')
    </main>

    @include('frontend.layouts.partials.footer')
    
    <!-- Stack untuk script tambahan dari sections -->
    @stack('scripts')
    
    <!-- Custom JS untuk APBDes -->
    <script>
        // Year selector handler
        document.addEventListener('DOMContentLoaded', function() {
            const yearSelectors = document.querySelectorAll('.year-selector');
            
            yearSelectors.forEach(selector => {
                selector.addEventListener('change', function() {
                    const tahun = this.value;
                    const url = new URL(window.location);
                    url.searchParams.set('tahun', tahun);
                    
                    // Show loading
                    const loadingEl = document.querySelector('.loading-indicator');
                    if (loadingEl) {
                        loadingEl.classList.remove('hidden');
                    }
                    
                    // Redirect
                    window.location.href = url.toString();
                });
            });
        });
        
        // Format currency function
        function formatRupiah(number) {
            return new Intl.NumberFormat('id-ID', {
                style: 'currency',
                currency: 'IDR',
                minimumFractionDigits: 0,
                maximumFractionDigits: 0
            }).format(number);
        }
        
        // Format number function
        function formatNumber(number) {
            return new Intl.NumberFormat('id-ID').format(number);
        }
    </script>
</body>
</html>