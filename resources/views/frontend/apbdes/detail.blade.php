@extends('frontend.layouts.apbdes')

@section('title', 'Detail APBDes - ' . $laporan->nama_laporan)

@push('styles')
<style>
    .detail-card {
        transition: all 0.3s ease;
        border: 1px solid #e5e7eb;
    }
    .detail-card:hover {
        transform: translateY(-1px);
        box-shadow: 0 4px 12px rgba(0,0,0,0.1);
    }
    .progress-bar {
        height: 8px;
        border-radius: 4px;
        overflow: hidden;
        background-color: #f3f4f6;
    }
    .progress-fill {
        height: 100%;
        transition: width 0.5s ease;
    }
</style>
@endpush

@section('content')
<div class="container mx-auto px-4 py-8">
    
    {{-- Header --}}
    <div class="mb-8">
        <nav class="flex mb-4" aria-label="Breadcrumb">
            <ol class="inline-flex items-center space-x-1 md:space-x-3">
                <li class="inline-flex items-center">
                    <a href="{{ route('frontend.apbdes.index') }}" class="text-blue-600 hover:text-blue-800">
                        APBDes
                    </a>
                </li>
                <li>
                    <div class="flex items-center">
                        <svg class="w-6 h-6 text-gray-400" fill="currentColor" viewBox="0 0 20 20">
                            <path fill-rule="evenodd" d="M7.293 14.707a1 1 0 010-1.414L10.586 10 7.293 6.707a1 1 0 011.414-1.414l4 4a1 1 0 010 1.414l-4 4a1 1 0 01-1.414 0z" clip-rule="evenodd"></path>
                        </svg>
                        <span class="text-gray-500 ml-1 md:ml-2">{{ $laporan->nama_laporan }}</span>
                    </div>
                </li>
            </ol>
        </nav>
        
        <div class="bg-white rounded-lg shadow-md p-6">
            <div class="flex flex-col md:flex-row md:items-center md:justify-between">
                <div>
                    <h1 class="text-3xl font-bold text-gray-800 mb-2">{{ $laporan->nama_laporan }}</h1>
                    <div class="flex flex-wrap items-center gap-4 text-sm text-gray-600">
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                            </svg>
                            Tahun {{ $laporan->tahunData->tahun ?? 'N/A' }}
                        </span>
                        <span class="flex items-center">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                            </svg>
                            Status: {{ ucfirst($balance['status']) }}
                        </span>
                    </div>
                </div>
                
                <div class="mt-4 md:mt-0">
                    <span class="inline-flex items-center px-4 py-2 rounded-full text-sm font-medium
                                 {{ $balance['status'] == 'surplus' ? 'bg-green-100 text-green-800' : 
                                    ($balance['status'] == 'defisit' ? 'bg-red-100 text-red-800' : 'bg-yellow-100 text-yellow-800') }}">
                        {{ $balance['status'] == 'surplus' ? '📈 Surplus' : ($balance['status'] == 'defisit' ? '📉 Defisit' : '⚖️ Seimbang') }}
                        Rp {{ number_format(abs($balance['selisih']), 0, ',', '.') }}
                    </span>
                </div>
            </div>
        </div>
    </div>

    {{-- Summary Cards --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-8">
        {{-- Total Pendapatan --}}
        <div class="detail-card bg-gradient-to-br from-green-50 to-green-100 rounded-lg p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-green-600 text-sm font-medium mb-1">Total Pendapatan</p>
                    <p class="text-2xl font-bold text-green-800">
                        Rp {{ number_format($balance['total_pendapatan'], 0, ',', '.') }}
                    </p>
                </div>
                <div class="bg-green-200 p-3 rounded-full">
                    <svg class="w-6 h-6 text-green-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <div class="progress-bar">
                    <div class="progress-fill bg-green-500" style="width: {{ $balance['persentase_pendapatan'] }}%"></div>
                </div>
                <p class="text-xs text-green-600 mt-1">{{ $balance['persentase_pendapatan'] }}% dari total anggaran</p>
            </div>
        </div>

        {{-- Total Belanja --}}
        <div class="detail-card bg-gradient-to-br from-orange-50 to-orange-100 rounded-lg p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-orange-600 text-sm font-medium mb-1">Total Belanja</p>
                    <p class="text-2xl font-bold text-orange-800">
                        Rp {{ number_format($balance['total_belanja'], 0, ',', '.') }}
                    </p>
                </div>
                <div class="bg-orange-200 p-3 rounded-full">
                    <svg class="w-6 h-6 text-orange-700" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <div class="progress-bar">
                    <div class="progress-fill bg-orange-500" style="width: {{ $balance['persentase_belanja'] }}%"></div>
                </div>
                <p class="text-xs text-orange-600 mt-1">{{ $balance['persentase_belanja'] }}% dari total anggaran</p>
            </div>
        </div>

        {{-- Balance --}}
        <div class="detail-card bg-gradient-to-br 
                    {{ $balance['status'] == 'surplus' ? 'from-blue-50 to-blue-100' : 
                       ($balance['status'] == 'defisit' ? 'from-red-50 to-red-100' : 'from-yellow-50 to-yellow-100') }} 
                    rounded-lg p-6">
            <div class="flex items-center justify-between">
                <div>
                    <p class="text-sm font-medium mb-1
                              {{ $balance['status'] == 'surplus' ? 'text-blue-600' : 
                                 ($balance['status'] == 'defisit' ? 'text-red-600' : 'text-yellow-600') }}">
                        {{ $balance['status'] == 'surplus' ? 'Surplus' : ($balance['status'] == 'defisit' ? 'Defisit' : 'Seimbang') }}
                    </p>
                    <p class="text-2xl font-bold
                              {{ $balance['status'] == 'surplus' ? 'text-blue-800' : 
                                 ($balance['status'] == 'defisit' ? 'text-red-800' : 'text-yellow-800') }}">
                        Rp {{ number_format(abs($balance['selisih']), 0, ',', '.') }}
                    </p>
                </div>
                <div class="p-3 rounded-full
                            {{ $balance['status'] == 'surplus' ? 'bg-blue-200' : 
                               ($balance['status'] == 'defisit' ? 'bg-red-200' : 'bg-yellow-200') }}">
                    <svg class="w-6 h-6 
                               {{ $balance['status'] == 'surplus' ? 'text-blue-700' : 
                                  ($balance['status'] == 'defisit' ? 'text-red-700' : 'text-yellow-700') }}" 
                         fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        @if($balance['status'] == 'surplus')
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"></path>
                        @elseif($balance['status'] == 'defisit')
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 17h8m0 0V9m0 8l-8-8-4 4-6-6"></path>
                        @else
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 0l3 3m-3-3l3-3"></path>
                        @endif
                    </svg>
                </div>
            </div>
            <div class="mt-4">
                <p class="text-xs 
                          {{ $balance['status'] == 'surplus' ? 'text-blue-600' : 
                             ($balance['status'] == 'defisit' ? 'text-red-600' : 'text-yellow-600') }}">
                    {{ $balance['status'] == 'surplus' ? 'Sisa anggaran yang dapat dimanfaatkan' : 
                       ($balance['status'] == 'defisit' ? 'Kekurangan yang perlu ditangani' : 'Anggaran berimbang sempurna') }}
                </p>
            </div>
        </div>
    </div>

    {{-- Detailed Tables --}}
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
        
        {{-- Detail Pendapatan --}}
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-green-600 text-white px-6 py-4">
                <h3 class="text-xl font-semibold flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"></path>
                    </svg>
                    Detail Pendapatan Desa
                </h3>
                <p class="text-green-100 text-sm mt-1">{{ $pendapatan->count() }} bidang pendapatan</p>
            </div>
            
            <div class="p-6">
                @if($pendapatan && $pendapatan->count() > 0)
                <div class="space-y-4">
                    @foreach($pendapatan as $item)
                    <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition-colors">
                        <div class="flex justify-between items-start mb-3">
                            <div class="flex-1">
                                <h4 class="font-semibold text-gray-800">{{ $item['bidang'] }}</h4>
                                @if($item['kode_bidang'])
                                <p class="text-xs text-gray-500 mt-1">Kode: {{ $item['kode_bidang'] }}</p>
                                @endif
                            </div>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                         {{ $item['persentase'] >= 80 ? 'bg-green-100 text-green-800' : 
                                            ($item['persentase'] >= 60 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                {{ $item['persentase'] }}%
                            </span>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <p class="text-gray-600 mb-1">Anggaran</p>
                                <p class="font-medium">Rp {{ number_format($item['anggaran'], 0, ',', '.') }}</p>
                            </div>
                            <div>
                                <p class="text-gray-600 mb-1">Realisasi</p>
                                <p class="font-semibold text-green-600">Rp {{ number_format($item['realisasi'], 0, ',', '.') }}</p>
                            </div>
                        </div>
                        
                        <div class="mt-3">
                            <div class="progress-bar">
                                <div class="progress-fill 
                                           {{ $item['persentase'] >= 80 ? 'bg-green-500' : 
                                              ($item['persentase'] >= 60 ? 'bg-yellow-500' : 'bg-red-500') }}" 
                                     style="width: {{ min($item['persentase'], 100) }}%"></div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-8">
                    <div class="text-gray-400 text-4xl mb-4">📊</div>
                    <p class="text-gray-500">Belum ada data pendapatan</p>
                </div>
                @endif
            </div>
        </div>

        {{-- Detail Belanja --}}
        <div class="bg-white rounded-lg shadow-md overflow-hidden">
            <div class="bg-orange-600 text-white px-6 py-4">
                <h3 class="text-xl font-semibold flex items-center">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M20 12H4"></path>
                    </svg>
                    Detail Belanja Desa
                </h3>
                <p class="text-orange-100 text-sm mt-1">{{ $belanja->count() }} bidang belanja</p>
            </div>
            
            <div class="p-6">
                @if($belanja && $belanja->count() > 0)
                <div class="space-y-4">
                    @foreach($belanja as $item)
                    <div class="border border-gray-200 rounded-lg p-4 hover:bg-gray-50 transition-colors">
                        <div class="flex justify-between items-start mb-3">
                            <div class="flex-1">
                                <h4 class="font-semibold text-gray-800">{{ $item['bidang'] }}</h4>
                                @if($item['kode_bidang'])
                                <p class="text-xs text-gray-500 mt-1">Kode: {{ $item['kode_bidang'] }}</p>
                                @endif
                            </div>
                            <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium
                                         {{ $item['persentase'] >= 80 ? 'bg-green-100 text-green-800' : 
                                            ($item['persentase'] >= 60 ? 'bg-yellow-100 text-yellow-800' : 'bg-red-100 text-red-800') }}">
                                {{ $item['persentase'] }}%
                            </span>
                        </div>
                        
                        <div class="grid grid-cols-2 gap-4 text-sm">
                            <div>
                                <p class="text-gray-600 mb-1">Anggaran</p>
                                <p class="font-medium">Rp {{ number_format($item['anggaran'], 0, ',', '.') }}</p>
                            </div>
                            <div>
                                <p class="text-gray-600 mb-1">Realisasi</p>
                                <p class="font-semibold text-orange-600">Rp {{ number_format($item['realisasi'], 0, ',', '.') }}</p>
                            </div>
                        </div>
                        
                        <div class="mt-3">
                            <div class="progress-bar">
                                <div class="progress-fill 
                                           {{ $item['persentase'] >= 80 ? 'bg-green-500' : 
                                              ($item['persentase'] >= 60 ? 'bg-yellow-500' : 'bg-red-500') }}" 
                                     style="width: {{ min($item['persentase'], 100) }}%"></div>
                            </div>
                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="text-center py-8">
                    <div class="text-gray-400 text-4xl mb-4">💰</div>
                    <p class="text-gray-500">Belum ada data belanja</p>
                </div>
                @endif
            </div>
        </div>
    </div>

    {{-- Description --}}
    @if($laporan->deskripsi)
    <div class="bg-gray-50 rounded-lg p-6 mt-8">
        <h3 class="text-lg font-semibold text-gray-800 mb-3">Keterangan</h3>
        <p class="text-gray-700 leading-relaxed">{{ $laporan->deskripsi }}</p>
    </div>
    @endif

    {{-- Action Buttons --}}
    <div class="flex justify-center mt-8">
        <a href="{{ route('frontend.apbdes.index') }}" 
           class="inline-flex items-center px-6 py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors">
            <svg class="w-4 h-4 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"></path>
            </svg>
            Kembali ke Daftar APBDes
        </a>
    </div>
</div>
@endsection