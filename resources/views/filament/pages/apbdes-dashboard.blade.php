<x-filament-panels::page>
    <div class="space-y-6">
        <!-- Year Selector -->
        <div class="bg-white rounded-lg shadow p-6">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="text-lg font-medium text-gray-900">Filter Tahun</h3>
                    <p class="text-sm text-gray-600 mt-1">Pilih tahun untuk melihat data APBDes</p>
                </div>
                <div class="w-48">
                    <div class="relative">
                        {{ $this->form }}
                        <style>
                            .fi-select-input {
                                color: #1f2937 !important;
                                background-color: #ffffff !important;
                                border: 1px solid #d1d5db !important;
                            }
                            .fi-select-input::placeholder {
                                color: #6b7280 !important;
                            }
                            .fi-select-input option {
                                color: #1f2937 !important;
                                background-color: #ffffff !important;
                            }
                            /* Override Filament's default select styling */
                            [x-data*="select"] select {
                                color: #1f2937 !important;
                                background-color: #ffffff !important;
                            }
                            [x-data*="select"] select option {
                                color: #1f2937 !important;
                                background-color: #ffffff !important;
                            }
                        </style>
                    </div>
                </div>
            </div>
        </div>

        @if($laporan)
            <!-- Header Info -->
            <div class="bg-white rounded-lg shadow p-6">
                <div class="flex items-center justify-between">
                    <div>
                        <h2 class="text-xl font-semibold text-gray-900">{{ $laporan->nama_laporan }}</h2>
                        <p class="text-sm text-gray-600 mt-1">
                            Tahun {{ $laporan->tahunData->tahun }} • 
                            Dirilis {{ $laporan->nama_bulan }} {{ $laporan->tahunData->tahun }}
                        </p>
                    </div>
                    <div class="text-right">
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-medium
                            @if($laporan->status === 'diterbitkan') 
                                bg-green-100 text-green-800
                            @elseif($laporan->status === 'selesai')
                                bg-blue-100 text-blue-800
                            @else
                                bg-yellow-100 text-yellow-800
                            @endif">
                            {{ ucfirst($laporan->status) }}
                        </span>
                    </div>
                </div>
            </div>

            <!-- Balance Summary -->
            @if(isset($statistik['total_pendapatan']))
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <div class="bg-green-50 rounded-lg p-6 border border-green-200">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-green-600">Total Pendapatan</p>
                            <p class="text-2xl font-semibold text-green-900">
                                Rp {{ number_format($statistik['total_pendapatan'], 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-orange-50 rounded-lg p-6 border border-orange-200">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-orange-100 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-orange-600">Total Belanja</p>
                            <p class="text-2xl font-semibold text-orange-900">
                                Rp {{ number_format($statistik['total_belanja'], 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                </div>

                <div class="bg-{{ $statistik['status_balance'] === 'surplus' ? 'blue' : 'red' }}-50 rounded-lg p-6 border border-{{ $statistik['status_balance'] === 'surplus' ? 'blue' : 'red' }}-200">
                    <div class="flex items-center">
                        <div class="flex-shrink-0">
                            <div class="w-8 h-8 bg-{{ $statistik['status_balance'] === 'surplus' ? 'blue' : 'red' }}-100 rounded-full flex items-center justify-center">
                                <svg class="w-5 h-5 text-{{ $statistik['status_balance'] === 'surplus' ? 'blue' : 'red' }}-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    @if($statistik['status_balance'] === 'surplus')
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                                    @else
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path>
                                    @endif
                                </svg>
                            </div>
                        </div>
                        <div class="ml-4">
                            <p class="text-sm font-medium text-{{ $statistik['status_balance'] === 'surplus' ? 'blue' : 'red' }}-600">
                                {{ ucfirst($statistik['status_balance']) }}
                            </p>
                            <p class="text-2xl font-semibold text-{{ $statistik['status_balance'] === 'surplus' ? 'blue' : 'red' }}-900">
                                Rp {{ number_format(abs($statistik['balance']), 0, ',', '.') }}
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            <!-- Realisasi per Bidang -->
            @if(isset($statistik['realisasi_bidang']) && $statistik['realisasi_bidang']->count() > 0)
            <div class="bg-white rounded-lg shadow">
                <div class="px-6 py-4 border-b border-gray-200">
                    <h3 class="text-lg font-medium text-gray-900">Realisasi Anggaran per Bidang</h3>
                    <p class="text-sm text-gray-600 mt-1">Persentase realisasi anggaran belanja per bidang</p>
                </div>
                <div class="p-6">
                    <div class="space-y-4">
                        @foreach($statistik['realisasi_bidang'] as $bidang)
                        <div class="border rounded-lg p-4">
                            <div class="flex items-center justify-between mb-2">
                                <h4 class="text-sm font-medium text-gray-900">{{ $bidang['bidang'] }}</h4>
                                <span class="text-sm text-gray-600">{{ $bidang['persentase'] }}%</span>
                            </div>
                            <div class="w-full bg-gray-200 rounded-full h-2">
                                <div class="bg-blue-600 h-2 rounded-full" style="width: {{ min($bidang['persentase'], 100) }}%"></div>
                            </div>
                            <div class="flex justify-between text-xs text-gray-600 mt-1">
                                <span>Realisasi: Rp {{ number_format($bidang['realisasi'], 0, ',', '.') }}</span>
                                <span>Anggaran: Rp {{ number_format($bidang['anggaran'], 0, ',', '.') }}</span>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

        @else
            <!-- No Data State -->
            <div class="text-center py-12">
                <svg class="mx-auto h-12 w-12 text-gray-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z" />
                </svg>
                <h3 class="mt-2 text-sm font-medium text-gray-900">Belum ada data APBDes</h3>
                <p class="mt-1 text-sm text-gray-500">Mulai dengan membuat laporan APBDes baru.</p>
                <div class="mt-6">
                    <a href="/admin/laporan-apbdes/create" class="inline-flex items-center px-4 py-2 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700">
                        <svg class="-ml-1 mr-2 h-5 w-5" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6" />
                        </svg>
                        Buat Laporan APBDes
                    </a>
                </div>
            </div>
        @endif
    </div>
</x-filament-panels::page>