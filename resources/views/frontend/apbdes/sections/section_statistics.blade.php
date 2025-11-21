{{-- Main Financial Summary Card --}}
<div class="bg-white rounded-2xl shadow-2xl overflow-hidden mb-12">
    {{-- Header Card Ringkasan --}}
    <div class="bg-gradient-to-r from-gray-100 to-gray-200 text-black px-8 py-6">
        <div class="flex flex-col md:flex-row md:items-center md:justify-between">
            <div class="mb-4 md:mb-0">
                <h2 class="text-3xl md:text-4xl font-bold mb-2 text-gray-900 flex items-center">
                    <i class="fas fa-wallet mr-3 text-cyan-600"></i>
                    Ringkasan Keuangan {{ $tahunDipilih }}
                </h2>
                <p class="text-gray-600 font-medium">Overview lengkap pendapatan, belanja, dan status balance keuangan desa</p>
            </div>
            <div class="text-right">
                <div class="inline-block">
                    <span class="inline-flex items-center px-5 py-2 rounded-full text-lg font-bold text-white shadow-lg
                               {{ $balance['status'] == 'surplus' ? 'bg-gradient-to-r from-emerald-500 to-emerald-600' : 
                                  ($balance['status'] == 'defisit' ? 'bg-gradient-to-r from-red-500 to-red-600' : 'bg-gradient-to-r from-amber-500 to-amber-600') }}">
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
    </div>

    <div class="p-8">
        {{-- Main Stats Grid --}}
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-8">
            {{-- Total Pendapatan --}}
            <div class="bg-white rounded-xl p-6 text-center shadow-md border border-gray-200 transition-all duration-300 hover:shadow-lg">
                <div class="w-14 h-14 bg-green-100 text-green-600 rounded-full mb-4 mx-auto shadow-sm flex items-center justify-center">
                    <i class="fas fa-arrow-down text-2xl"></i>
                </div>
                <p class="text-gray-700 text-xs font-bold mb-2 uppercase tracking-wider">Total Pendapatan</p>
                <p class="text-2xl font-bold text-gray-900 mb-3">
                    Rp {{ number_format($balance['total_pendapatan'] ?? 0, 0, ',', '.') }}
                </p>
                <div class="w-full bg-gray-200 rounded-full h-2 mb-2">
                    <div class="bg-green-500 h-2 rounded-full transition-all duration-1000 ease-in-out" style="width: {{ $balance['persentase_pendapatan'] ?? 0 }}%"></div>
                </div>
                <p class="text-xs text-gray-600 font-medium mt-2">{{ $balance['persentase_pendapatan'] ?? 0 }}% dari Total Dana</p>
            </div>

            {{-- Total Belanja --}}
            <div class="bg-white rounded-xl p-6 text-center shadow-md border border-gray-200 transition-all duration-300 hover:shadow-lg">
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
