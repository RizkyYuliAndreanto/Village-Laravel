<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Infografis - Desa Banyukambang')</title>
    
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
        
        /* Responsive styles for infografis */
        .margin-top-navbar {
            margin-top: 80px; /* Space for fixed navbar */
        }
        
        @media (max-width: 767px) {
            .margin-top-navbar {
                margin-top: 70px; /* Smaller margin for mobile */
            }
        }
        
        /* Mobile-first responsive grid */
        .responsive-grid {
            display: grid;
            gap: 1rem;
            grid-template-columns: 1fr;
        }
        
        @media (min-width: 640px) {
            .responsive-grid {
                grid-template-columns: repeat(2, 1fr);
                gap: 1.25rem;
            }
        }
        
        @media (min-width: 1024px) {
            .responsive-grid {
                grid-template-columns: repeat(3, 1fr);
                gap: 1.5rem;
            }
        }
        
        @media (min-width: 1280px) {
            .responsive-grid {
                grid-template-columns: repeat(4, 1fr);
            }
        }
        
        /* Chart responsiveness */
        .chart-container {
            position: relative;
            height: 300px;
            width: 100%;
        }
        
        @media (min-width: 768px) {
            .chart-container {
                height: 400px;
            }
        }
        
        @media (min-width: 1024px) {
            .chart-container {
                height: 500px;
            }
        }
        
        /* Mobile responsive table */
        @media (max-width: 767px) {
            .responsive-table {
                font-size: 12px;
            }
            .responsive-table th,
            .responsive-table td {
                padding: 6px 8px;
            }
            .mobile-wrap {
                word-wrap: break-word;
                max-width: 120px;
            }
        }
            }
        /* Card hover effects */
        .infografis-card {
            transition: all 0.3s ease;
        }
        
        .infografis-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }
        
        /* Mobile touch-friendly elements */
        @media (max-width: 767px) {
            .infografis-card {
                min-height: 60px;
            }
            
            .hero-title {
                font-size: 1.875rem;
                line-height: 1.2;
            }
            
            .hero-subtitle {
                font-size: 0.95rem;
                line-height: 1.4;
            }
            
            .stat-card {
                min-height: 50px;
            }
        }
        
        /* Ensure mobile menu works properly */
        @media (max-width: 1023px) {
            #mobile-menu-toggle {
                display: block !important;
            }
            
            .navbar-bg {
                backdrop-filter: blur(10px);
            }
        }
        
        @media (min-width: 1024px) {
            .chart-container {
                height: 500px;
            }
        }
        
        /* Mobile text sizing */
        @media (max-width: 640px) {
            .infografis-title {
                font-size: 1.5rem;
                line-height: 1.3;
            }
            
            .hero-title {
                font-size: 2rem !important;
            }
            
            .hero-subtitle {
                font-size: 1rem;
            }
            
            .quick-stats {
                flex-direction: column;
                align-items: stretch;
            }
            
            .stat-card {
                width: 100%;
                min-height: 60px;
            }
            
            /* Better text wrapping for mobile */
            .mobile-wrap {
                word-wrap: break-word;
                overflow-wrap: break-word;
                hyphens: auto;
            }
            
            /* Smaller padding for mobile */
            .mobile-padding {
                padding: 0.75rem;
            }
            
            /* Responsive table */
            .responsive-table {
                font-size: 0.75rem;
            }
            
            .responsive-table th,
            .responsive-table td {
                padding: 0.25rem 0.5rem;
            }
            
            /* Horizontal card adjustments for mobile */
            .infografis-card .flex {
                gap: 0.75rem;
            }
            
            .infografis-card img {
                width: 40px;
                height: 40px;
            }
        }
        
        /* Card hover effects */
        .infografis-card {
            transition: all 0.3s ease;
        }
        
        .infografis-card:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0, 0, 0, 0.15);
        }
        
        /* Smooth transitions */
        .smooth-transition {
            transition: all 0.3s ease-in-out;
        }
        
        /* Hide scrollbars for mobile chart containers */
        .chart-container::-webkit-scrollbar {
            display: none;
        }
        .chart-container {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        
        /* Touch-friendly elements */
        @media (max-width: 768px) {
            .infografis-card {
                min-height: 44px; /* iOS touch target minimum */
            }
            
            .tahun-selector {
                min-height: 44px;
                padding: 0.75rem;
            }
            
            button, .btn {
                min-height: 44px;
                min-width: 44px;
            }
        }
        
        /* Prevent text selection on touch devices for better UX */
        .no-select {
            -webkit-touch-callout: none;
            -webkit-user-select: none;
            -khtml-user-select: none;
            -moz-user-select: none;
            -ms-user-select: none;
            user-select: none;
        }
    </style>

    <!-- Chart.js responsive configuration -->
    <script>
        // Global Chart.js configuration for responsiveness
        document.addEventListener('DOMContentLoaded', function() {
            if (typeof Chart !== 'undefined') {
                Chart.defaults.responsive = true;
                Chart.defaults.maintainAspectRatio = false;
                Chart.defaults.plugins.legend.labels.usePointStyle = true;
                
                // Mobile-specific adjustments
                if (window.innerWidth < 768) {
                    Chart.defaults.plugins.legend.labels.font = { size: 10 };
                    Chart.defaults.scale.ticks.font = { size: 9 };
                } else if (window.innerWidth < 1024) {
                    Chart.defaults.plugins.legend.labels.font = { size: 11 };
                    Chart.defaults.scale.ticks.font = { size: 10 };
                }
                
                // Handle window resize for charts
                window.addEventListener('resize', function() {
                    Chart.helpers.each(Chart.instances, function(instance) {
                        instance.resize();
                    });
                });
            }
        });
    </script>
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
        
        // Handle window resize for better chart responsiveness
        let resizeTimeout;
        window.addEventListener('resize', function() {
            clearTimeout(resizeTimeout);
            resizeTimeout = setTimeout(function() {
                // Trigger chart resize after window resize is complete
                if (typeof Chart !== 'undefined') {
                    Chart.helpers.each(Chart.instances, function(instance) {
                        instance.resize();
                    });
                }
            }, 250);
        });
        
        // Handle mobile orientation change
        window.addEventListener('orientationchange', function() {
            setTimeout(function() {
                if (typeof Chart !== 'undefined') {
                    Chart.helpers.each(Chart.instances, function(instance) {
                        instance.resize();
                    });
                }
            }, 500);
        });
    </script>
    
    <!-- Stack untuk script tambahan dari sections -->
    @stack('scripts')
    
    <!-- Custom JS untuk Infografis -->
    <script src="{{ asset('js/infografis-simple.js') }}"></script>
</body>
</html>