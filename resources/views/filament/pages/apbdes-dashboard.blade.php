<x-filament-panels::page>
    <div class="space-y-6">
        <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-6">
            <div class="flex flex-col md:flex-row md:items-center justify-between gap-4">
                <div>
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Filter Tahun Anggaran</h3>
                    <p class="text-sm text-gray-500 dark:text-gray-400">Pilih tahun untuk menyaring data statistik di atas.</p>
                </div>
                <div class="w-full md:w-64">
                    {{ $this->form }}
                </div>
            </div>
        </div>

        @if($laporan)
            <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-4">
                <div class="flex items-center justify-between">
                    <div class="flex items-center space-x-3">
                        <div class="p-2 bg-primary-50 dark:bg-primary-900/20 rounded-lg">
                            <x-heroicon-o-document-text class="w-6 h-6 text-primary-600 dark:text-primary-400" />
                        </div>
                        <div>
                            <h2 class="text-base font-semibold text-gray-900 dark:text-white">{{ $laporan->nama_laporan }}</h2>
                            <p class="text-xs text-gray-500 dark:text-gray-400">Dirilis: {{ $laporan->nama_bulan }} {{ $laporan->tahunData->tahun }}</p>
                        </div>
                    </div>
                    <span class="px-3 py-1 text-xs font-medium rounded-full 
                        {{ $laporan->status === 'diterbitkan' 
                            ? 'bg-green-100 text-green-700 dark:bg-green-900/30 dark:text-green-400' 
                            : 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/30 dark:text-yellow-400' }}">
                        {{ ucfirst($laporan->status) }}
                    </span>
                </div>
            </div>

            @if(isset($statistik['realisasi_bidang']) && $statistik['realisasi_bidang']->count() > 0)
            <div class="bg-white dark:bg-gray-900 rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                <div class="px-6 py-4 border-b border-gray-200 dark:border-gray-800 bg-gray-50 dark:bg-white/5">
                    <h3 class="text-lg font-medium text-gray-900 dark:text-white">Realisasi Anggaran per Bidang</h3>
                </div>
                <div class="p-6 grid gap-6 md:grid-cols-2">
                    @foreach($statistik['realisasi_bidang'] as $bidang)
                    <div class="p-4 rounded-lg border border-gray-100 dark:border-gray-700 hover:border-primary-200 dark:hover:border-primary-800 transition-colors">
                        <div class="flex justify-between items-start mb-2">
                            <h4 class="font-medium text-gray-800 dark:text-gray-200 text-sm line-clamp-1" title="{{ $bidang['bidang'] }}">
                                {{ $bidang['bidang'] }}
                            </h4>
                            <span class="text-xs font-bold {{ $bidang['persentase'] >= 90 ? 'text-green-600 dark:text-green-400' : ($bidang['persentase'] >= 50 ? 'text-blue-600 dark:text-blue-400' : 'text-orange-600 dark:text-orange-400') }}">
                                {{ $bidang['persentase'] }}%
                            </span>
                        </div>
                        
                        <div class="w-full bg-gray-100 dark:bg-gray-700 rounded-full h-2.5 mb-3">
                            <div class="h-2.5 rounded-full {{ $bidang['persentase'] >= 90 ? 'bg-green-500' : ($bidang['persentase'] >= 50 ? 'bg-blue-500' : 'bg-orange-500') }}" 
                                 style="width: {{ min($bidang['persentase'], 100) }}%"></div>
                        </div>

                        <div class="flex justify-between items-center text-xs text-gray-500 dark:text-gray-400">
                            <div>
                                <span class="block">Realisasi</span>
                                <span class="font-semibold text-gray-700 dark:text-gray-300">Rp {{ number_format($bidang['realisasi'], 0, ',', '.') }}</span>
                            </div>
                            <div class="text-right">
                                <span class="block">Anggaran</span>
                                <span class="font-semibold text-gray-700 dark:text-gray-300">Rp {{ number_format($bidang['anggaran'], 0, ',', '.') }}</span>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif

        @else
            <div class="flex flex-col items-center justify-center py-12 bg-white dark:bg-gray-900 rounded-xl border border-dashed border-gray-300 dark:border-gray-700">
                <div class="p-3 rounded-full bg-gray-100 dark:bg-gray-800 mb-4">
                    <x-heroicon-o-document-magnifying-glass class="w-8 h-8 text-gray-400 dark:text-gray-500" />
                </div>
                <h3 class="text-lg font-medium text-gray-900 dark:text-white">Data APBDes Tidak Ditemukan</h3>
                <p class="text-gray-500 dark:text-gray-400 text-sm mt-1 max-w-sm text-center">Tidak ada laporan APBDes yang diterbitkan untuk tahun yang dipilih. Silakan pilih tahun lain atau buat laporan baru.</p>
                <div class="mt-6">
                    <x-filament::button
                        tag="a"
                        href="/admin/laporan-apbdes/create"
                        icon="heroicon-o-plus"
                    >
                        Buat Laporan Baru
                    </x-filament::button>
                </div>
            </div>
        @endif
    </div>
</x-filament-panels::page>