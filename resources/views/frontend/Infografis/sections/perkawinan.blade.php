{{-- File: resources/views/frontend/Infografis/sections/perkawinan.blade.php --}}
<section class="py-12 lg:py-20 bg-gradient-to-br from-cyan-50 to-teal-50">
    <div class="container mx-auto px-4">
        <div class="text-center mb-8">
            <h3 class="text-2xl lg:text-3xl font-bold infografis-title text-gray-800">
                Berdasarkan Perkawinan 
            </h3>
            <div class="mt-2 text-primary-600 font-medium">
                Tahun {{ $tahunAktif ?? date('Y') }}
            </div>
        </div>

        {{-- GRID FIX: grid-cols-1 di mobile (default), sm:grid-cols-2 (tablet), lg:grid-cols-3 (desktop) --}}
        <div id="perkawinan-content" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 lg:gap-6">
            @foreach([
                'Belum Kawin' => $belumKawin ?? 0,
                'Kawin' => $perkawinan->kawin ?? 0,
                'Cerai Mati' => $perkawinan->cerai_mati ?? 0,
                'Cerai Hidup' => $perkawinan->cerai_hidup ?? 0,
                'Kawin Tercatat' => $perkawinan->kawin_tercatat ?? 0,
                'Kawin Tdk Tercatat' => $perkawinan->kawin_tidak_tercatat ?? 0,
            ] as $label => $value)
            <div class="infografis-card bg-white p-5 rounded-xl shadow-sm border border-gray-100 text-center hover:shadow-md transition-shadow">
                {{-- Icon placeholder kecil saja di mobile --}}
                <div class="w-12 h-12 lg:w-16 lg:h-16 mx-auto mb-3 bg-cyan-100 rounded-full flex items-center justify-center text-cyan-600">
                    <svg xmlns="http://www.w3.org/2000/svg" class="h-6 w-6 lg:h-8 lg:w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z" />
                    </svg>
                </div>
                <div class="text-sm lg:text-base font-semibold text-gray-600">{{ $label }}</div>
                <div class="text-2xl lg:text-3xl font-bold text-cyan-600 mt-1">{{ number_format($value) }}</div>
            </div>
            @endforeach
        </div>
    </div>
</section>