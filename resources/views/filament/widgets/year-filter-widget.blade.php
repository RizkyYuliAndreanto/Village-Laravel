<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            Filter Tahun Data
        </x-slot>

        <div class="space-y-4">
            {{ $this->form }}
            
            @if($validationResults)
                <div class="mt-6">
                    {{-- UBAH 1: Tambahkan dark:text-white pada judul --}}
                    <h3 class="text-lg font-semibold text-gray-900 dark:text-white mb-4">Hasil Validasi Data Tahun {{ $selectedYear ? \App\Models\TahunData::find($selectedYear)?->tahun : '' }}</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($validationResults as $category => $result)
                            {{-- UBAH 2: Tambahkan dark:bg-gray-800 dan dark:border-gray-700 agar card jadi gelap di mode malam --}}
                            <div class="bg-white dark:bg-gray-800 rounded-lg border border-gray-200 dark:border-gray-700 p-4">
                                <div class="flex items-center justify-between mb-2">
                                    {{-- UBAH 3: Tambahkan dark:text-white agar teks nama kategori terbaca --}}
                                    <h4 class="font-medium text-gray-900 dark:text-white capitalize">{{ str_replace('_', ' ', $category) }}</h4>
                                    
                                    @if(is_array($result) && isset($result['isValid']) && $result['isValid'])
                                        {{-- UBAH 4: Sesuaikan badge warna hijau untuk dark mode --}}
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800 dark:bg-green-900 dark:text-green-300">
                                            Valid
                                        </span>
                                    @elseif(is_array($result) && isset($result['isValid']) && !$result['isValid'])
                                        {{-- UBAH 5: Sesuaikan badge warna merah untuk dark mode --}}
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800 dark:bg-red-900 dark:text-red-300">
                                            Invalid
                                        </span>
                                    @endif
                                </div>
                                
                                @if(is_array($result) && isset($result['errors']) && !empty($result['errors']))
                                    {{-- UBAH 6: Sesuaikan warna teks error --}}
                                    <ul class="text-sm text-red-600 dark:text-red-400 space-y-1">
                                        @foreach($result['errors'] as $error)
                                            <li>• {{ $error }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    {{-- UBAH 7: Sesuaikan warna teks sukses --}}
                                    <p class="text-sm text-green-600 dark:text-green-400">Data valid dan konsisten</p>
                                @endif
                                
                                @if(!empty($result['summary']))
                                    {{-- UBAH 8: Sesuaikan warna teks summary --}}
                                    <div class="mt-2 text-xs text-gray-500 dark:text-gray-400">
                                        {{ $result['summary'] }}
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </x-filament::section>
</x-filament-widgets::widget>