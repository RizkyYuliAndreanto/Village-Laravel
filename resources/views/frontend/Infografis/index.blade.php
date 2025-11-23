@extends('frontend.layouts.infografis')

@section('content')

    {{-- Hero Section --}}
    <section class="min-h-screen flex flex-col bg-gradient-to-br from-cyan-50 to-teal-50 py-16">
        <div class="flex justify-end mb-6">
            @include('frontend.layouts.partials.submenu')
        </div>

        <div class="container mx-auto px-6 flex flex-col lg:flex-row items-center justify-between gap-12">
            <div class="max-w-xl text-center lg:text-left">
                <h3 class="text-3xl font-extrabold mb-4 infografis-title">DEMOGRAFI PENDUDUK</h3>
                <p class="infografis-subtitle leading-relaxed text-justify">
                    Melalui website ini Anda dapat menjelajahi segala hal yang terkait dengan Desa.
                    Pemerintahan, penduduk, demografi, potensi Desa, dan juga berita tentang Desa.
                </p>
            </div>

            <div class="flex-shrink-0">
                <img class="rounded-2xl shadow-lg max-w-sm w-full object-cover"
                    src="{{ asset('images/logo-placeholder.jpg') }}" alt="Logo Desa">
            </div>
        </div>
    </section>

    {{-- Section: Statistik Demografi Penduduk --}}
    @include('frontend.Infografis.sections.demografi')

    {{-- Section: Berdasarkan Kelompok Umur --}}
    @include('frontend.Infografis.sections.kelompok-umur')

    {{-- Section: Berdasarkan Pendidikan --}}
    @include('frontend.Infografis.sections.pendidikan')

    {{-- Section: Berdasarkan Pekerjaan --}}
    @include('frontend.Infografis.sections.pekerjaan')

    {{-- Section: Berdasarkan Wajib Pilih --}}
    @include('frontend.Infografis.sections.wajib-pilih')

    {{-- Section: Berdasarkan Perkawinan --}}
    @include('frontend.Infografis.sections.perkawinan')

    {{-- Section: Berdasarkan Agama --}}
    @include('frontend.Infografis.sections.agama')

@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/infografis-tahun-selector.css') }}">
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <script src="{{ asset('js/infografis-tahun-selector.js') }}"></script>
    <script>
        document.addEventListener("DOMContentLoaded", function() {
            // Initialize charts dengan data awal
            console.log('Infografis page loaded with year selector functionality');
            
            // Data tahun tersedia dari backend
            @if(isset($tahunTersedia))
                window.tahunTersedia = @json($tahunTersedia);
            @endif
            
            // Tahun aktif saat ini
            @if(isset($tahunAktif))
                window.tahunAktif = '{{ $tahunAktif }}';
            @endif
        });
    </script>
@endpush