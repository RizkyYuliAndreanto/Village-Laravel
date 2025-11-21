{{-- Ringkasan Keuangan Section --}}
<div class="apbdes-card mb-12 overflow-hidden">
    {{-- Header --}}
    <div class="bg-gradient-to-r from-cyan-500 to-blue-600 text-white px-8 py-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div class="mb-4 md:mb-0">
                <h2 class="text-3xl font-bold mb-2 flex items-center">
                    <i class="fas fa-chart-line mr-3"></i>
                    Ringkasan Keuangan {{ $tahunDipilih }}
                </h2>
                <p class="text-cyan-100">Transparansi pengelolaan keuangan desa</p>
            </div>
            <div class="text-right">
                <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-bold text-white 
                           {{ $balance['status'] == 'surplus' ? 'apbdes-surplus' : 
                              ($balance['status'] == 'defisit' ? 'apbdes-defisit' : 'apbdes-balance') }} shadow-lg">
                    @if($balance['status'] == 'surplus')
                        <i class="fas fa-arrow-up mr-2"></i> Surplus
                    @elseif($balance['status'] == 'defisit')
                        <i class="fas fa-arrow-down mr-2"></i> Defisit
                    @else
                        <i class="fas fa-balance-scale mr-2"></i> Seimbang
                    @endif
                </span>
            </div>
        </div>
    </div>

    <div class="p-8">
        {{-- Main Stats Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            {{-- Total Pendapatan --}}
            <div class="bg-gradient-to-br from-green-50 to-green-100 rounded-xl p-6 text-center border border-green-200 hover:shadow-lg transition-all duration-300">
                <div class="w-16 h-16 apbdes-pendapatan rounded-full mb-4 mx-auto flex items-center justify-center shadow-lg">
                    <i class="fas fa-arrow-up text-2xl"></i>
                </div>
                <p class="apbdes-pendapatan-text text-sm font-bold mb-2 uppercase tracking-wide">Total Pendapatan</p>
                <p class="text-2xl font-bold apbdes-pendapatan-text mb-3">
                    Rp {{ number_format($balance['total_pendapatan'] ?? 0, 0, ',', '.') }}
                </p>
                <div class="w-full apbdes-pendapatan-progress rounded-full h-2.5">
                    <div class="apbdes-pendapatan-bar h-2.5 rounded-full transition-all duration-1000" style="width: {{ $balance['persentase_pendapatan'] ?? 0 }}%"></div>
                </div>
                <p class="text-xs apbdes-pendapatan-text font-medium mt-2">{{ $balance['persentase_pendapatan'] ?? 0 }}% dari Total</p>
            </div>

            {{-- Total Belanja --}}
            <div class="bg-gradient-to-br from-red-50 to-red-100 rounded-xl p-6 text-center border border-red-200 hover:shadow-lg transition-all duration-300">
                <div class="w-16 h-16 apbdes-belanja rounded-full mb-4 mx-auto flex items-center justify-center shadow-lg">
                    <i class="fas fa-arrow-down text-2xl"></i>
                </div>
                <p class="apbdes-belanja-text text-sm font-bold mb-2 uppercase tracking-wide">Total Belanja</p>
                <p class="text-2xl font-bold apbdes-belanja-text mb-3">
                    Rp {{ number_format($balance['total_belanja'] ?? 0, 0, ',', '.') }}
                </p>
                <div class="w-full apbdes-belanja-progress rounded-full h-2.5">
                    <div class="apbdes-belanja-bar h-2.5 rounded-full transition-all duration-1000" style="width: {{ $balance['persentase_belanja'] ?? 0 }}%"></div>
                </div>
                <p class="text-xs apbdes-belanja-text font-medium mt-2">{{ $balance['persentase_belanja'] ?? 0 }}% dari Total</p>
            </div>

            {{-- Selisih/Balance --}}
            <div class="bg-gradient-to-br from-blue-50 to-blue-100 rounded-xl p-6 text-center border border-blue-200 hover:shadow-lg transition-all duration-300">
                <div class="w-16 h-16 apbdes-balance rounded-full mb-4 mx-auto flex items-center justify-center shadow-lg">
                    <i class="fas fa-balance-scale text-2xl"></i>
                </div>
                <p class="text-heading text-sm font-bold mb-2 uppercase tracking-wide">Selisih</p>
                <p class="text-2xl font-bold {{ $balance['selisih'] >= 0 ? 'apbdes-pendapatan-text' : 'apbdes-belanja-text' }} mb-3">
                    {{ $balance['selisih'] >= 0 ? '+' : '' }}Rp {{ number_format($balance['selisih'] ?? 0, 0, ',', '.') }}
                </p>
                <div class="flex items-center justify-center">
                    @if($balance['selisih'] >= 0)
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold apbdes-surplus-light">
                            <i class="fas fa-arrow-up mr-1"></i> Surplus
                        </span>
                    @else
                        <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-800">
                            <i class="fas fa-arrow-down mr-1"></i> Defisit
                        </span>
                    @endif
                </div>
            </div>

            {{-- Status Laporan --}}
            <div class="bg-gradient-to-br from-purple-50 to-purple-100 rounded-xl p-6 text-center border border-purple-200 hover:shadow-lg transition-all duration-300">
                <div class="w-16 h-16 bg-purple-500 text-white rounded-full mb-4 mx-auto flex items-center justify-center shadow-lg">
                    <i class="fas fa-file-alt text-2xl"></i>
                </div>
                <p class="text-purple-800 text-sm font-bold mb-2 uppercase tracking-wide">Status Laporan</p>
                <p class="text-lg font-bold text-purple-900 mb-3">{{ ucfirst($laporan->status) }}</p>
                <div class="flex items-center justify-center">
                    <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-semibold bg-purple-100 text-purple-800">
                        <i class="fas fa-calendar mr-1"></i> {{ $laporan->nama_bulan }}
                    </span>
                </div>
            </div>
        </div>

        {{-- Summary Info Cards --}}
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
            {{-- Informasi Laporan --}}
            <div class="bg-gradient-to-r from-cyan-50 to-blue-50 rounded-xl p-6 border border-cyan-200">
                <h3 class="text-lg font-bold text-cyan-800 mb-4 flex items-center">
                    <i class="fas fa-info-circle mr-2"></i>
                    Informasi Laporan
                </h3>
                <div class="space-y-3">
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Nama Laporan:</span>
                        <span class="font-semibold text-gray-800">{{ $laporan->nama_laporan }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Bulan Rilis:</span>
                        <span class="font-semibold text-gray-800">{{ $laporan->nama_bulan }} {{ $tahunDipilih }}</span>
                    </div>
                    <div class="flex justify-between items-center">
                        <span class="text-gray-600">Status:</span>
                        <span class="px-2 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-800">
                            {{ ucfirst($laporan->status) }}
                        </span>
                    </div>
                </div>
            </div>

            {{-- Perbandingan Dana --}}
            <div class="bg-gradient-to-r from-yellow-50 to-orange-50 rounded-xl p-6 border border-yellow-200">
                <h3 class="text-lg font-bold text-yellow-800 mb-4 flex items-center">
                    <i class="fas fa-chart-pie mr-2"></i>
                    Perbandingan Dana
                </h3>
                <div class="space-y-4">
                    {{-- Pendapatan Bar --}}
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm font-medium text-gray-600">Pendapatan</span>
                            <span class="text-sm font-bold text-green-600">{{ $balance['persentase_pendapatan'] }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-3">
                            <div class="bg-green-500 h-3 rounded-full transition-all duration-1000" style="width: {{ $balance['persentase_pendapatan'] }}%"></div>
                        </div>
                    </div>
                    {{-- Belanja Bar --}}
                    <div>
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-sm font-medium text-gray-600">Belanja</span>
                            <span class="text-sm font-bold text-red-600">{{ $balance['persentase_belanja'] }}%</span>
                        </div>
                        <div class="w-full bg-gray-200 rounded-full h-3">
                            <div class="bg-red-500 h-3 rounded-full transition-all duration-1000" style="width: {{ $balance['persentase_belanja'] }}%"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
                <div class="w-14 h-14 bg-orange-100 text-orange-600 rounded-full mb-4 mx-auto shadow-sm flex items-center justify-center">
                    <i class="fas fa-arrow-up text-2xl"></i>
                </div>
                <p class="text-gray-700 text-xs font-bold mb-2 uppercase tracking-wider">Total Belanja</p>
                <p class="text-2xl font-bold text-gray-900 mb-3">
                    Rp {{ number_format($balance['total_belanja'] ?? 0, 0, ',', '.') }}
                </p>
                <div class="w-full bg-gray-200 rounded-full h-2 mb-2">
                    <div class="bg-orange-500 h-2 rounded-full transition-all duration-1000 ease-in-out" style="width: {{ $balance['persentase_belanja'] ?? 0 }}%"></div>
                </div>
                <p class="text-xs text-gray-600 font-medium mt-2">{{ $balance['persentase_belanja'] ?? 0 }}% dari Total Dana</p>
            </div>

            {{-- Balance (Selisih) --}}
            <div class="rounded-xl p-6 text-center shadow-md border transition-all duration-300 hover:shadow-lg
                       {{ $balance['status'] == 'surplus' ? 'bg-emerald-50 border-emerald-200' : 
                          ($balance['status'] == 'defisit' ? 'bg-red-50 border-red-200' : 'bg-amber-50 border-amber-200') }}">
                <div class="rounded-full mb-4 mx-auto flex items-center justify-center w-14 h-14
                           {{ $balance['status'] == 'surplus' ? 'bg-emerald-100 text-emerald-600' : 
                              ($balance['status'] == 'defisit' ? 'bg-red-100 text-red-600' : 'bg-amber-100 text-amber-600') }}">
                    @if($balance['status'] == 'surplus')
                        <i class="fas fa-plus-circle text-2xl"></i>
                    @elseif($balance['status'] == 'defisit')
                        <i class="fas fa-minus-circle text-2xl"></i>
                    @else
                        <i class="fas fa-equals text-2xl"></i>
                    @endif
                </div>
                <p class="text-gray-900 text-xs font-bold mb-2 uppercase tracking-wider">
                    {{ $balance['status'] == 'surplus' ? 'Surplus' : 
                       ($balance['status'] == 'defisit' ? 'Defisit' : 'Berimbang') }}
                </p>
                <p class="text-2xl font-bold text-gray-900 mb-2">
                    Rp {{ number_format(abs($balance['selisih'] ?? 0), 0, ',', '.') }}
                </p>
                <p class="text-xs text-gray-700">
                    {{ $balance['status'] == 'surplus' ? 'Sisa anggaran' : 
                       ($balance['status'] == 'defisit' ? 'Kekurangan dana' : 'Anggaran setara') }}
                </p>
            </div>

            {{-- Quick Stats (Bidang) --}}
            <div class="bg-white rounded-xl p-6 text-center shadow-md border border-gray-200 transition-all duration-300 hover:shadow-lg">
                <div class="w-14 h-14 bg-purple-100 text-purple-600 rounded-full mb-4 mx-auto shadow-sm flex items-center justify-center">
                    <i class="fas fa-list-check text-2xl"></i>
                </div>
                <p class="text-gray-700 text-xs font-bold mb-2 uppercase tracking-wider">Total Bidang</p>
                <p class="text-3xl font-bold text-gray-900 mb-2">
                    {{ ($pendapatan ? $pendapatan->count() : 0) + ($belanja ? $belanja->count() : 0) }}
                </p>
                <p class="text-xs text-gray-600 font-medium">
                    {{ $pendapatan ? $pendapatan->count() : 0 }} Pendapatan, {{ $belanja ? $belanja->count() : 0 }} Belanja
                </p>
            </div>
        </div>

        <hr class="border-gray-200 my-8">
    </div>
</div>
