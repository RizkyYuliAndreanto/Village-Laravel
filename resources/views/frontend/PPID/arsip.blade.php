@extends('frontend.layouts.ppid')

@section('content')
<!-- Hero Section dengan Background Gradient -->
<div class="section-bg-primary py-12">
    <div class="container mx-auto px-4 lg:px-8">
        <!-- Breadcrumb -->
        <nav class="mb-8" aria-label="Breadcrumb">
            <ol class="flex items-center space-x-2 text-sm">
                <li><a href="{{ route('home') }}" class="text-primary-600 hover:text-primary-700 transition-colors">Beranda</a></li>
                <li class="text-primary-400">/</li>
                <li><a href="{{ route('ppid.index') }}" class="text-primary-600 hover:text-primary-700 transition-colors">PPID</a></li>
                <li class="text-primary-400">/</li>
                <li class="text-primary-800 font-medium">Arsip {{ $tahun }}</li>
            </ol>
        </nav>

        <!-- Header -->
        <div class="text-center">
            <h1 class="text-4xl lg:text-5xl font-bold text-heading mb-4">
                🗂️ Arsip Dokumen {{ $tahun }}
            </h1>
            <p class="text-lg text-body max-w-3xl mx-auto leading-relaxed">
                Kumpulan dokumen informasi publik yang diterbitkan pada tahun {{ $tahun }}.
                Temukan berbagai dokumen resmi yang telah diarsipkan berdasarkan kategori dan jenisnya.
            </p>
        </div>
    </div>
</div>

<!-- Filter & Search Section -->
<div class="bg-white py-8 border-b">
    <div class="container mx-auto px-4 lg:px-8">
        <div class="card-bg rounded-2xl p-6">
            <form method="GET" action="{{ route('ppid.arsip', $tahun) }}" class="space-y-4 lg:space-y-0 lg:flex lg:items-center lg:space-x-6">
                
                <!-- Search Input -->
                <div class="flex-1">
                    <div class="relative">
                        <svg class="absolute left-4 top-1/2 transform -translate-y-1/2 w-5 h-5 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}"
                               placeholder="🔍 Cari dokumen tahun {{ $tahun }}..."
                               class="w-full pl-12 pr-4 py-4 border-2 border-primary-200 rounded-xl focus:border-primary-500 focus:ring focus:ring-primary-200 bg-white text-body placeholder-muted transition-all">
                    </div>
                </div>

                <!-- Filter Kategori -->
                <div class="lg:w-56">
                    <select name="kategori" class="w-full px-4 py-4 border-2 border-primary-200 rounded-xl focus:border-primary-500 focus:ring focus:ring-primary-200 bg-white text-body transition-all">
                        <option value="">📂 Semua Kategori</option>
                        @foreach($kategoriList as $kat)
                            <option value="{{ $kat->kategori }}" {{ request('kategori') == $kat->kategori ? 'selected' : '' }}>
                                {{ ucwords(str_replace('_', ' ', $kat->kategori)) }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Filter Bulan -->
                <div class="lg:w-48">
                    <select name="bulan" class="w-full px-4 py-4 border-2 border-primary-200 rounded-xl focus:border-primary-500 focus:ring focus:ring-primary-200 bg-white text-body transition-all">
                        <option value="">📅 Semua Bulan</option>
                        @foreach($bulanList as $bln)
                            <option value="{{ $bln->bulan }}" {{ request('bulan') == $bln->bulan ? 'selected' : '' }}>
                                {{ $namaBulan[$bln->bulan] ?? "Bulan {$bln->bulan}" }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Sort -->
                <div class="lg:w-48">
                    <select name="sort" class="w-full px-4 py-4 border-2 border-primary-200 rounded-xl focus:border-primary-500 focus:ring focus:ring-primary-200 bg-white text-body transition-all">
                        <option value="terbaru" {{ request('sort', 'terbaru') == 'terbaru' ? 'selected' : '' }}>📅 Terbaru</option>
                        <option value="terlama" {{ request('sort') == 'terlama' ? 'selected' : '' }}>📅 Terlama</option>
                        <option value="a-z" {{ request('sort') == 'a-z' ? 'selected' : '' }}>🔤 A-Z</option>
                        <option value="z-a" {{ request('sort') == 'z-a' ? 'selected' : '' }}>🔤 Z-A</option>
                    </select>
                </div>

                <!-- Button Search -->
                <div class="flex space-x-3">
                    <button type="submit" class="btn-primary px-8 py-4 rounded-xl font-medium flex items-center space-x-2 hover:scale-105 transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <span>Cari</span>
                    </button>
                    
                    @if(request()->hasAny(['search', 'kategori', 'bulan', 'sort']))
                        <a href="{{ route('ppid.arsip', $tahun) }}" class="btn-secondary px-6 py-4 rounded-xl font-medium hover:scale-105 transition-all">
                            ↻ Reset
                        </a>
                    @endif
                </div>
            </form>
        </div>
    </div>
</div>

<!-- Content Section -->
<div class="bg-gray-50 py-12">
    <div class="container mx-auto px-4 lg:px-8">
        
        <!-- Stats Header -->
        <div class="mb-8">
            <div class="bg-gradient-to-r from-primary-50 to-secondary-50 rounded-2xl p-6">
                <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                    <div>
                        <h3 class="text-2xl font-bold text-heading mb-2">
                            📊 Arsip Tahun {{ $tahun }}
                        </h3>
                        <p class="text-body">
                            Menampilkan <strong>{{ $dokumen->count() }}</strong> dari <strong>{{ $dokumen->total() }}</strong> dokumen
                            @if(request('search'))
                                untuk pencarian "<strong>{{ request('search') }}</strong>"
                            @endif
                            @if(request('kategori'))
                                kategori <strong>{{ ucwords(str_replace('_', ' ', request('kategori'))) }}</strong>
                            @endif
                            @if(request('bulan'))
                                bulan <strong>{{ $namaBulan[request('bulan')] ?? request('bulan') }}</strong>
                            @endif
                        </p>
                    </div>
                    <div class="mt-4 lg:mt-0">
                        <span class="px-4 py-2 bg-primary-500 text-white rounded-full text-sm font-medium shadow-lg">
                            🗓️ {{ $tahun }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        <!-- Year Navigation -->
        @if($tahunTersedia->count() > 1)
        <div class="mb-8">
            <div class="card-bg rounded-2xl p-6">
                <h3 class="text-lg font-semibold text-heading mb-4 flex items-center">
                    <span class="text-xl mr-2">📅</span>
                    Pilih Tahun Lain
                </h3>
                <div class="flex flex-wrap gap-3">
                    @foreach($tahunTersedia as $thn)
                        <a href="{{ route('ppid.arsip', $thn->tahun) }}" 
                           class="px-4 py-2 rounded-lg font-medium transition-all {{ $thn->tahun == $tahun ? 'bg-primary-500 text-white' : 'bg-gray-100 text-body hover:bg-primary-100 hover:text-primary-700' }}">
                            {{ $thn->tahun }}
                            <span class="text-xs opacity-75">({{ $thn->total }})</span>
                        </a>
                    @endforeach
                </div>
            </div>
        </div>
        @endif

        @if($dokumen->count() > 0)
            <!-- Timeline berdasarkan bulan -->
            @php
                $dokumenPerBulan = $dokumen->groupBy(function($item) {
                    return $item->tanggal_upload->format('n'); // angka bulan
                });
            @endphp

            @foreach($dokumenPerBulan as $bulan => $dokumenBulan)
                <section class="mb-12">
                    <div class="flex items-center mb-6">
                        <div class="w-12 h-12 bg-primary-500 text-white rounded-full flex items-center justify-center font-bold mr-4">
                            {{ $bulan }}
                        </div>
                        <div>
                            <h2 class="text-2xl font-bold text-heading">
                                {{ $namaBulan[$bulan] ?? "Bulan $bulan" }} {{ $tahun }}
                            </h2>
                            <p class="text-muted">{{ $dokumenBulan->count() }} dokumen</p>
                        </div>
                    </div>

                    <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-6">
                        @foreach($dokumenBulan as $item)
                            <article class="card-bg rounded-xl overflow-hidden shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 group">
                                <div class="p-6">
                                    <!-- Header dengan kategori -->
                                    <div class="flex items-start justify-between mb-4">
                                        <span class="px-3 py-1 text-xs rounded-full
                                            @switch($item->kategori)
                                                @case('informasi_berkala') bg-blue-100 text-blue-700 @break
                                                @case('informasi_sertamerta') bg-red-100 text-red-700 @break
                                                @case('informasi_setiap_saat') bg-green-100 text-green-700 @break
                                                @case('informasi_dikecualikan') bg-yellow-100 text-yellow-700 @break
                                                @default bg-gray-100 text-gray-700
                                            @endswitch
                                        ">
                                            @switch($item->kategori)
                                                @case('informasi_berkala') 📅 @break
                                                @case('informasi_sertamerta') ⚡ @break
                                                @case('informasi_setiap_saat') ⏰ @break
                                                @case('informasi_dikecualikan') 🔒 @break
                                                @default 📄
                                            @endswitch
                                            {{ ucwords(str_replace('_', ' ', $item->kategori)) }}
                                        </span>
                                        <div class="text-right text-xs text-muted">
                                            <div>{{ $item->tanggal_upload->translatedFormat('d M') }}</div>
                                        </div>
                                    </div>

                                    <!-- Title -->
                                    <h3 class="font-bold text-heading group-hover:text-primary-600 transition-colors line-clamp-2 mb-3 leading-tight">
                                        <a href="{{ route('ppid.show', $item->id) }}">
                                            {{ $item->judul_dokumen }}
                                        </a>
                                    </h3>

                                    <!-- Metadata -->
                                    <div class="space-y-2 mb-4 text-xs text-muted">
                                        <div class="flex items-center space-x-2">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                            <span>{{ $item->uploader }}</span>
                                        </div>
                                    </div>

                                    <!-- Action Buttons -->
                                    <div class="flex space-x-2">
                                        <a href="{{ route('ppid.show', $item->id) }}" 
                                           class="flex-1 btn-secondary text-center py-2 rounded-lg text-sm hover:scale-105 transition-all">
                                            👁️ Detail
                                        </a>
                                        <a href="{{ route('ppid.download', $item->id) }}" 
                                           class="flex-1 btn-primary text-center py-2 rounded-lg text-sm hover:scale-105 transition-all"
                                           target="_blank">
                                            📥 Download
                                        </a>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </section>
            @endforeach

            <!-- Pagination -->
            <div class="flex justify-center mt-12">
                <div class="bg-white rounded-2xl p-6 shadow-lg">
                    {{ $dokumen->appends(request()->query())->links('pagination::tailwind') }}
                </div>
            </div>

        @else
            <!-- Empty State -->
            <div class="text-center py-16">
                <div class="card-bg rounded-3xl p-12 max-w-2xl mx-auto">
                    <div class="text-8xl mb-6">📭</div>
                    <h3 class="text-3xl font-bold text-heading mb-4">
                        Tidak Ada Dokumen
                    </h3>
                    <p class="text-lg text-body mb-8 leading-relaxed">
                        @if(request()->hasAny(['search', 'kategori', 'bulan']))
                            Tidak ada dokumen yang sesuai dengan filter pencarian Anda pada tahun {{ $tahun }}.
                        @else
                            Belum ada dokumen yang diarsipkan pada tahun {{ $tahun }}.
                        @endif
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        @if(request()->hasAny(['search', 'kategori', 'bulan']))
                            <a href="{{ route('ppid.arsip', $tahun) }}" class="btn-primary px-8 py-4 rounded-xl font-medium hover:scale-105 transition-all">
                                🔄 Reset Filter
                            </a>
                        @endif
                        <a href="{{ route('ppid.index') }}" class="btn-secondary px-8 py-4 rounded-xl font-medium hover:scale-105 transition-all">
                            📚 Lihat Semua Dokumen
                        </a>
                    </div>
                </div>
            </div>
        @endif

        <!-- Statistik Tahun -->
        @if($statistikKategori->count() > 0)
        <section class="mt-16">
            <h2 class="text-3xl font-bold text-heading mb-8 text-center">
                📊 Statistik Dokumen {{ $tahun }}
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($statistikKategori as $stat)
                    <div class="card-bg rounded-2xl p-6 text-center">
                        <div class="text-4xl mb-4">
                            @switch($stat->kategori)
                                @case('informasi_berkala') 📅 @break
                                @case('informasi_sertamerta') ⚡ @break
                                @case('informasi_setiap_saat') ⏰ @break
                                @case('informasi_dikecualikan') 🔒 @break
                                @default 📄 
                            @endswitch
                        </div>
                        <h3 class="font-bold text-heading mb-2">
                            {{ ucwords(str_replace('_', ' ', $stat->kategori)) }}
                        </h3>
                        <div class="text-3xl font-bold text-primary-600 mb-2">{{ $stat->total }}</div>
                        <p class="text-sm text-muted">dokumen</p>
                        <div class="mt-4">
                            <a href="{{ route('ppid.kategori', $stat->kategori) }}?tahun={{ $tahun }}" 
                               class="btn-primary text-sm px-4 py-2 rounded-lg">
                                Lihat Semua →
                            </a>
                        </div>
                    </div>
                @endforeach
            </div>
        </section>
        @endif
    </div>
</div>
@endsection