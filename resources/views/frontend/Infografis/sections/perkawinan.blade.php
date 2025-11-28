{{-- Section: Berdasarkan Perkawinan --}}
<section class="py-8 sm:py-12 lg:py-20 bg-gradient-to-br from-cyan-50 to-teal-50">
    <div class="container mx-auto px-4 sm:px-6">
        <div class="text-center mb-4 sm:mb-6 lg:mb-8">
            <h3 class="text-xl sm:text-2xl lg:text-3xl font-bold infografis-title mb-3 sm:mb-4 lg:mb-6">
                Berdasarkan Perkawinan 
                <span id="tahun-display-perkawinan" class="text-sm sm:text-base lg:text-lg text-primary-600 block sm:inline">
                    ({{ $tahunAktif ?? date('Y') }})
                </span>
            </h3>
        </div>

      
        <div id="perkawinan-content" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 lg:gap-8">
            @php
                $perkawinanCards = [
                    [
                        'label' => 'Kawin',
                        'value' => $kawin ?? 0,
                        'icon' => 'images/infografis/icon-kawin-DDA193Z5.svg', // ganti sesuai kebutuhan
                    ],
                    [
                        'label' => 'Cerai Mati',
                        'value' => $cerai_mati ?? 0,
                        'icon' => 'images/infografis/icon-cerai-mati-VdEzxQgX.svg',
                    ],
                    [
                        'label' => 'Cerai Hidup',
                        'value' => $cerai_hidup ?? 0,
                        'icon' => 'images/infografis/icon-cerai-hidup-c75sVKpW.svg',
                    ],
                    [
                        'label' => 'Kawin Tercatat',
                        'value' => $kawin_tercatat ?? 0,
                        'icon' => 'images/infografis/icon-kawin-tercatat-Cr_1J14L.svg',
                    ],
                    [
                        'label' => 'Kawin Tidak Tercatat',
                        'value' => $kawin_tidak_tercatat ?? 0,
                        'icon' => 'images/infografis/icon-kawin-tak-tercatat-Ba6jJHqw.svg',
                    ],
                ];
            @endphp
            @foreach($perkawinanCards as $card)
            <div class="infografis-card p-4 sm:p-6 lg:p-8 rounded-lg shadow">
                <div class="flex items-center gap-3 sm:gap-4 lg:gap-6">
                    <div class="flex-shrink-0">
                        <img src="{{ asset($card['icon']) }}" class="w-10 h-10 sm:w-12 sm:h-12 lg:w-16 lg:h-16" alt="Icon {{ $card['label'] }}">
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="text-lg sm:text-xl lg:text-3xl font-bold text-cyan-600 truncate">{{ $card['value'] }}</div>
                        <div class="text-sm sm:text-base lg:text-lg text-gray-600 truncate">{{ $card['label'] }}</div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>