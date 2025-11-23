@extends('frontend.layouts.app')

@section('title', 'Profil Desa')

@section('content')
<div class="min-h-screen bg-gray-50">
    @yield('profil-content')
</div>
@endsection

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

.border-profil-primary {
    border-color: #0891b2;
}

.hover-profil-primary:hover {
    background-color: #0e7490;
    transform: translateY(-2px);
}

.section-divider {
    position: relative;
    margin: 4rem 0;
}

.section-divider::before {
    content: '';
    position: absolute;
    top: 50%;
    left: 50%;
    transform: translate(-50%, -50%);
    width: 100px;
    height: 4px;
    background: linear-gradient(90deg, #0891b2, #06b6d4);
    border-radius: 2px;
}

/* Animation classes */
.fade-in-up {
    animation: fadeInUp 0.6s ease-out;
}

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

.stagger-1 { animation-delay: 0.1s; }
.stagger-2 { animation-delay: 0.2s; }
.stagger-3 { animation-delay: 0.3s; }
.stagger-4 { animation-delay: 0.4s; }
</style>
@endpush

@push('scripts')
<script>
// Smooth scroll untuk navigation
document.addEventListener('DOMContentLoaded', function() {
    // Smooth scroll for anchor links
    document.querySelectorAll('a[href^="#"]').forEach(anchor => {
        anchor.addEventListener('click', function (e) {
            e.preventDefault();
            const target = document.querySelector(this.getAttribute('href'));
            if (target) {
                target.scrollIntoView({
                    behavior: 'smooth',
                    block: 'start'
                });
            }
        });
    });
    
    // Add animation on scroll
    const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    };
    
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('fade-in-up');
            }
        });
    }, observerOptions);
    
    document.querySelectorAll('.animate-on-scroll').forEach(el => {
        observer.observe(el);
    });
});
</script>
@endpush