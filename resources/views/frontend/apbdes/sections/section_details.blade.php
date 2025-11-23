{{-- Detailed Summary --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-12">
    {{-- Pendapatan Summary --}}
    <div class="bg-white rounded-xl p-6 shadow-lg border border-gray-200">
        <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
            <span class="bg-green-500 text-white px-3 py-2 rounded-lg mr-3 font-bold text-sm shadow-md">
                <i class="fas fa-arrow-down"></i>
            </span>
            Rincian Pendapatan
        </h3>
        @if($pendapatan && $pendapatan->count() > 0)
            <div class="space-y-3">
                @foreach($pendapatan as $item)
                <div class="bg-gray-50 rounded-lg p-4 border-l-4 border-green-500 shadow-sm transition-all duration-300 hover:shadow-md hover:bg-white">
                    <div class="flex justify-between items-start gap-3">
                        <div class="flex-1 min-w-0">
                            <h4 class="font-semibold text-gray-900 text-sm break-words">{{ $item['bidang'] ?? 'N/A' }}</h4>
                            <p class="text-xs text-gray-700 mt-2 leading-relaxed">
                                <span class="block">Realisasi: <span class="font-bold text-gray-900">Rp {{ number_format($item['realisasi'] ?? 0, 0, ',', '.') }}</span></span>
                                <span class="block text-gray-600">Anggaran: Rp {{ number_format($item['anggaran'] ?? 0, 0, ',', '.') }}</span>
                            </p>
                        </div>
                        <div class="flex-shrink-0 min-w-max">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold text-white whitespace-nowrap
                                       {{ ($item['persentase'] ?? 0) >= 80 ? 'bg-emerald-500' : 
                                          (($item['persentase'] ?? 0) >= 60 ? 'bg-amber-500' : 'bg-red-500') }}">
                                {{ $item['persentase'] ?? 0 }}%
                            </span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <p class="text-center text-gray-600 py-8">Belum ada data pendapatan</p>
        @endif
    </div>

    {{-- Belanja Summary --}}
    <div class="bg-white rounded-xl p-6 shadow-lg border border-gray-200">
        <h3 class="text-xl font-bold text-gray-900 mb-6 flex items-center">
            <span class="bg-orange-500 text-white px-3 py-2 rounded-lg mr-3 font-bold text-sm shadow-md">
                <i class="fas fa-arrow-up"></i>
            </span>
            Rincian Belanja
        </h3>
        @if($belanja && $belanja->count() > 0)
            <div class="space-y-3">
                @foreach($belanja as $item)
                <div class="bg-gray-50 rounded-lg p-4 border-l-4 border-orange-500 shadow-sm transition-all duration-300 hover:shadow-md hover:bg-white">
                    <div class="flex justify-between items-start gap-3">
                        <div class="flex-1 min-w-0">
                            <h4 class="font-semibold text-gray-900 text-sm break-words">{{ $item['bidang'] ?? 'N/A' }}</h4>
                            <p class="text-xs text-gray-700 mt-2 leading-relaxed">
                                <span class="block">Realisasi: <span class="font-bold text-gray-900">Rp {{ number_format($item['realisasi'] ?? 0, 0, ',', '.') }}</span></span>
                                <span class="block text-gray-600">Anggaran: Rp {{ number_format($item['anggaran'] ?? 0, 0, ',', '.') }}</span>
                            </p>
                        </div>
                        <div class="flex-shrink-0 min-w-max">
                            <span class="inline-flex items-center px-3 py-1 rounded-full text-xs font-bold text-white whitespace-nowrap
                                       {{ ($item['persentase'] ?? 0) >= 80 ? 'bg-emerald-500' : 
                                          (($item['persentase'] ?? 0) >= 60 ? 'bg-amber-500' : 'bg-red-500') }}">
                                {{ $item['persentase'] ?? 0 }}%
                            </span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>
        @else
            <p class="text-center text-gray-600 py-8">Belum ada data belanja</p>
        @endif
    </div>
</div>
