<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>@yield('title', 'Profil Desa') - {{ config('app.name', 'Website Desa') }}</title>

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=figtree:400,500,600&display=swap" rel="stylesheet" />

    <!-- Scripts & Styles -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    
    <!-- AOS Animation -->
    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
    <script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
    
    @stack('styles')
</head>
<body class="font-sans antialiased">
    <div class="min-h-screen bg-gray-50">
        @yield('content')
    </div>

    @stack('scripts')
    
    <!-- Initialize AOS -->
    <script>
        AOS.init({
            duration: 800,
            once: true,
            offset: 100
        });
    </script>
</body>
</html>

@push('styles')
<style>
/* Custom styles untuk profil desa */
.section-bg-profil {
    background: linear-gradient(135deg, #0891b2 0%, #0e7490 50%, #155e75 100%);
}

.card-profil {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(8, 145, 178, 0.1);
}

.text-profil-primary {
    color: #0891b2;
}

.bg-profil-primary {
    background-color: #0891b2;
}

.text-profil-accent {
    color: #0e7490;
}

.bg-profil-accent {
    background-color: #0e7490;
}

.bg-profil-bg {
    background-color: #f8fafc;
}

.text-heading {
    color: #1e293b;
}

.text-body {
    color: #64748b;
}

/* Smooth scrolling */
html {
    scroll-behavior: smooth;
}

/* Section dividers */
.section-divider {
    position: relative;
    overflow: hidden;
}

.section-divider::before {
    content: '';
    position: absolute;
    top: 0;
    left: -100%;
    width: 100%;
    height: 2px;
    background: linear-gradient(90deg, transparent, #0891b2, transparent);
    animation: shimmer 2s infinite;
}

@keyframes shimmer {
    0% { left: -100%; }
    100% { left: 100%; }
}

/* Card hover effects */
.hover-lift {
    transition: transform 0.3s ease, box-shadow 0.3s ease;
}

.hover-lift:hover {
    transform: translateY(-5px);
    box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
}

/* Gradient text */
.gradient-text {
    background: linear-gradient(135deg, #0891b2, #0e7490);
    -webkit-background-clip: text;
    background-clip: text;
    -webkit-text-fill-color: transparent;
}

/* Custom animations */
@keyframes fadeInUp {
    from {
        opacity: 0;
        transform: translateY(30px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

.fade-in-up {
    animation: fadeInUp 0.6s ease-out;
}

/* Responsive adjustments */
@media (max-width: 768px) {
    .hero-title {
        font-size: 2.5rem;
    }
    
    .section-padding {
        padding: 3rem 0;
    }
}

/* Stats counter animation */
@keyframes countUp {
    from {
        opacity: 0;
        transform: scale(0.5);
    }
    to {
        opacity: 1;
        transform: scale(1);
    }
}

.stats-number {
    animation: countUp 0.8s ease-out;
}

/* Loading skeleton */
.skeleton {
    background: linear-gradient(90deg, #f0f0f0 25%, #e0e0e0 50%, #f0f0f0 75%);
    background-size: 200% 100%;
    animation: loading 1.5s infinite;
}

@keyframes loading {
    0% { background-position: 200% 0; }
    100% { background-position: -200% 0; }
}
</style>
@endpush