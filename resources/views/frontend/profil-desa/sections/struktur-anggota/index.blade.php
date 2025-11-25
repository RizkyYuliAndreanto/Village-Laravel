@extends('frontend.layouts.main')

@section('title', 'Struktur Organisasi - Desa Ngengor')

@section('content')

<section class="mb-24 pt-28">
    <div class="text-center mb-16">
        <h2 class="text-4xl lg:text-5xl font-bold text-heading mb-4">
            👥 Struktur Organisasi Desa Ngengor
        </h2>
        <div class="section-divider"></div>
        <p class="text-lg text-body max-w-3xl mx-auto">
            Daftar lengkap perangkat desa beserta jabatan dan tugasnya
        </p>
    </div>

    <div class="max-w-6xl mx-auto">
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">

            @foreach($strukturOrganisasi as $struktur)
            <a href="{{ route('profil-desa.struktur-anggota.show', $struktur->id_struktur) }}">
                
                <div class="relative h-80 bg-gradient-to-br from-cyan-100 to-blue-100 overflow-hidden">
                    @if($struktur->foto || $struktur->image || $struktur->foto_url)
                        <img src="{{ asset('storage/' . ($struktur->foto ?? $struktur->image ?? $struktur->foto_url)) }}"
                            alt="{{ $struktur->nama }}"
                            class="w-full h-full object-cover object-top group-hover:scale-105 transition-transform duration-500">
                    @else
                        <div class="w-full h-full flex items-center justify-center bg-gray-200">
                            <div class="w-24 h-24 bg-white/50 rounded-full flex items-center justify-center backdrop-blur-sm">
                                <span class="text-4xl text-profil-primary">👤</span>
                            </div>
                        </div>
                    @endif

                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent opacity-80"></div>

                    <div class="absolute bottom-0 left-0 right-0 p-6 text-white">
                        <h3 class="text-xl font-bold mb-1">{{ $struktur->nama }}</h3>
                        <p class="text-cyan-300 font-medium tracking-wide text-sm uppercase">{{ $struktur->jabatan }}</p>
                    </div>
                </div>

                @if($struktur->keterangan)
                <div class="p-5 bg-white border-t border-gray-100">
                    <p class="text-sm text-body line-clamp-3">{{ $struktur->keterangan }}</p>
                </div>
                @endif

            </a>
            @endforeach

        </div>
    </div>
</section>

@endsection
