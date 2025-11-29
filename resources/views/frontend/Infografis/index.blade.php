{{-- File: resources/views/frontend/Infografis/index.blade.php --}}
@extends('frontend.layouts.infografis')

@section('content')

{{-- Hero Section --}}
<section class="relative min-h-[60vh] lg:min-h-[80vh] flex items-center bg-gradient-to-br from-cyan-50 to-teal-50 py-16 overflow-hidden">

    {{-- Background Blob Decorations --}}
    <div class="absolute top-0 right-0 w-96 h-96 bg-cyan-200 rounded-full mix-blend-multiply blur-3xl opacity-30 animate-blob"></div>
    <div class="absolute top-10 left-0 w-96 h-96 bg-teal-200 rounded-full mix-blend-multiply blur-3xl opacity-30 animate-blob animation-delay-2000"></div>

    <div class="container mx-auto px-6 grid lg:grid-cols-2 gap-12 items-center relative z-10">

        {{-- LEFT: TEXT --}}
        <div class="text-center lg:text-left space-y-6">

            <span class="inline-block px-4 py-1 bg-cyan-100 text-cyan-700 text-xs font-semibold rounded-full tracking-wide">
                DATA DESA TERPADU
            </span>

            <h1 class="text-4xl lg:text-5xl font-extrabold text-gray-900 leading-tight drop-shadow-sm">
                Infografis Desa
            </h1>

            <p class="text-gray-700 text-base lg:text-lg leading-relaxed max-w-lg mx-auto lg:mx-0">
                Jelajahi data komprehensif mengenai kependudukan, potensi, dan statistik Desa secara transparan.
                Pilih tahun data untuk melihat kondisi desa pada periode tersebut.
            </p>

            {{-- FILTER TAHUN --}}
            <div class="inline-flex items-center gap-3 bg-white/90 backdrop-blur-md px-4 py-3 rounded-xl shadow-md border border-gray-200 relative">
                <i class="fas fa-calendar-alt text-cyan-600 text-lg"></i>

                <select id="global-tahun-selector"
                    onchange="changeGlobalYear(this.value)"
                    class="bg-transparent text-cyan-700 font-semibold text-sm lg:text-base cursor-pointer
                   focus:outline-none appearance-none border-none pr-6">
                    @foreach($tahunTersedia as $t)
                    @php $yearVal = is_object($t) ? $t->tahun : $t; @endphp
                    <option value="{{ $yearVal }}" {{ $tahunAktif == $yearVal ? 'selected' : '' }}>
                        {{ $yearVal }}
                    </option>
                    @endforeach
                </select>
            </div>


        </div>

        {{-- RIGHT: IMAGE --}}
        <div class="flex justify-center my-20">
            <div class="relative w-full max-w-[300px] sm:max-w-sm group">
                <div class="absolute inset-0 bg-gradient-to-tr from-cyan-500 to-teal-400 rounded-2xl rotate-3 scale-105 opacity-30 transition-transform"></div>

                <img src="{{ asset('images/Kabupaten_Madiun.png') }}"
                    alt="Infografis Desa"
                    class="relative rounded-2xl shadow-2xl w-full object-cover group-hover:scale-[1.02] transition duration-500">
            </div>
        </div>

    </div>
</section>

{{-- Sections --}}
@include('frontend.Infografis.sections.demografi')
@include('frontend.Infografis.sections.kelompok-umur')
@include('frontend.Infografis.sections.pendidikan')
@include('frontend.Infografis.sections.pekerjaan')
@include('frontend.Infografis.sections.wajib-pilih')
@include('frontend.Infografis.sections.perkawinan')
@include('frontend.Infografis.sections.agama')

@endsection


@push('styles')
<style>
    /* Blob Animation */
    @keyframes blob {
        0% {
            transform: translate(0, 0) scale(1);
        }

        33% {
            transform: translate(30px, -40px) scale(1.1);
        }

        66% {
            transform: translate(-20px, 30px) scale(0.95);
        }

        100% {
            transform: translate(0, 0) scale(1);
        }
    }

    .animate-blob {
        animation: blob 8s infinite ease-in-out;
    }

    .animation-delay-2000 {
        animation-delay: 2s;
    }

    /* Ensure charts always scale properly */
    canvas {
        width: 100% !important;
        height: auto !important;
    }
</style>
@endpush


@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
    // Smooth Year Change
    function changeGlobalYear(year) {
        document.body.style.opacity = '0.6';
        const url = new URL(window.location.href);
        url.searchParams.set('tahun', year);
        window.location.href = url.toString();
    }
</script>
@endpush