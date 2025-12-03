    @extends('frontend.layouts.infografis')

@section('content')
    <div class="margin-top-navbar">
        <div class="space-y-4 sm:space-y-6 lg:space-y-8">
            {{-- Section: Statistik Demografi Penduduk --}}
            @include('frontend.infografis.sections.demografi')

            {{-- Section: Berdasarkan Kelompok Umur --}}
            @include('frontend.infografis.sections.kelompok-umur')

            {{-- Section: Berdasarkan Pendidikan --}}
            @include('frontend.infografis.sections.pendidikan')

            {{-- Section: Berdasarkan Pekerjaan --}}
            @include('frontend.infografis.sections.pekerjaan')

            {{-- Section: Berdasarkan Wajib Pilih --}}
            @include('frontend.infografis.sections.wajib-pilih')

            {{-- Section: Berdasarkan Perkawinan --}}
            @include('frontend.infografis.sections.perkawinan')

            {{-- Section: Berdasarkan Agama --}}
            @include('frontend.infografis.sections.agama')

            {{-- Section: Berdasarkan Dusun --}}
            @include('frontend.infografis.sections.dusun')
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="{{ asset('css/infografis-tahun-selector.css') }}">
@endpush

@push('scripts')
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
  
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