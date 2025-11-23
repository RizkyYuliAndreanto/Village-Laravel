{{-- Section: APBD Desa --}}
<section class="min-h-screen flex flex-col justify-center py-10 bg-gradient-to-br from-cyan-50 to-teal-50">
    <div class="container mx-auto px-6 text-center">
        <h2 class="text-3xl font-bold text-heading mb-2">
            APBD Desa Tahun {{ $tahunDataTerbaru ?? date('Y') }}
        </h2>
        <p class="text-lg text-body mb-12">
            Akses cepat dan transparan terhadap APB Desa serta proyek pembangunan.
        </p>

        @if($apbdData && isset($apbdData['hasData']) && $apbdData['hasData'])
            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <!-- Pendapatan Desa -->
                <div class="card-bg rounded-lg card-shadow p-6">
                    <h3 class="text-xl font-bold mb-3 text-heading">Pendapatan Desa</h3>
                    <p class="text-2xl font-bold text-green-600 mb-4">
                        Rp {{ number_format($apbdData['pendapatan']['realisasi'] ?? 0, 0, ',', '.') }}
                    </p>
                    <div class="mb-4">
                        <div class="flex justify-between text-sm text-body mb-1">
                            <span>Realisasi</span>
                            <span>{{ number_format($apbdData['pendapatan']['persentase'] ?? 0, 1) }}%</span>
                        </div>
                        <div class="w-full bg-gray-300 rounded-full h-2">
                            <div class="bg-green-600 h-2 rounded-full" 
                                 style="width: {{ min($apbdData['pendapatan']['persentase'] ?? 0, 100) }}%"></div>
                        </div>
                    </div>
                    <p class="text-sm text-muted">
                        Target: Rp {{ number_format($apbdData['pendapatan']['target'] ?? 0, 0, ',', '.') }}
                    </p>
                </div>

                <!-- Belanja Desa -->
                <div class="card-bg rounded-lg card-shadow p-6">
                    <h3 class="text-xl font-bold mb-3 text-heading">Belanja Desa</h3>
                    <p class="text-2xl font-bold text-red-600 mb-4">
                        Rp {{ number_format($apbdData['belanja']['realisasi'] ?? 0, 0, ',', '.') }}
                    </p>
                    <div class="mb-4">
                        <div class="flex justify-between text-sm text-body mb-1">
                            <span>Realisasi</span>
                            <span>{{ number_format($apbdData['belanja']['persentase'] ?? 0, 1) }}%</span>
                        </div>
                        <div class="w-full bg-gray-300 rounded-full h-2">
                            <div class="bg-red-600 h-2 rounded-full" 
                                 style="width: {{ min($apbdData['belanja']['persentase'] ?? 0, 100) }}%"></div>
                        </div>
                    </div>
                    <p class="text-sm text-muted">
                        Target: Rp {{ number_format($apbdData['belanja']['target'] ?? 0, 0, ',', '.') }}
                    </p>
                </div>
            </div>

            <div class="flex justify-end mt-10">
                <a href="{{ route('belanja.index') }}" 
                   class="btn-primary inline-block px-8 py-3 font-semibold rounded-lg shadow transition-all duration-300">
                    Lihat Data Lengkap →
                </a>
            </div>
        @else
            <div class="card-bg rounded-lg card-shadow p-8">
                <div class="text-muted mb-4">
                    <svg class="w-16 h-16 mx-auto mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                </div>
                <p class="text-center text-lg text-body">
                    Data APBDes belum tersedia untuk ditampilkan.
                </p>
                <p class="text-center text-sm text-muted mt-2">
                    Silakan hubungi admin desa untuk informasi lebih lanjut.
                </p>
            </div>
        @endif
    </div>
</section>