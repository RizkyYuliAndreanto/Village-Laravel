@extends('frontend.layouts.berita')

@section('content')
<!-- Hero Section dengan Background Gradient -->
<div class="section-bg-primary py-16">
    <div class="container mx-auto px-4 py-16 lg:px-8">
        <!-- Page Title -->
        <div class="text-center mb-12">
            <h1 class="text-4xl lg:text-5xl font-bold text-heading mb-4">
                📰 Berita Desa
            </h1>
            <p class="text-lg text-body max-w-2xl mx-auto leading-relaxed">
                Informasi terbaru seputar desa, pengumuman penting, dan kegiatan masyarakat yang dapat Anda ikuti.
            </p>
        </div>

        <!-- Statistik Cards -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
            <div class="stat-card text-center">
                <div class="stat-number">{{ $totalBerita }}</div>
                <div class="stat-label">Total Berita</div>
            </div>
            <div class="stat-card text-center">
                <div class="stat-number">{{ $beritaBulanIni }}</div>
                <div class="stat-label">Berita Bulan Ini</div>
            </div>
            <div class="stat-card text-center">
                <div class="stat-number">{{ $kategoris->count() }}</div>
                <div class="stat-label">Kategori Berita</div>
            </div>
        </div>
    </div>
</div>

<!-- Content Section -->
<div class="bg-white py-16">
    <div class="container mx-auto px-4 lg:px-8">
        
        <!-- Filter Search -->
        <div class="card-bg p-6 rounded-2xl mb-12">
            <h3 class="text-xl font-semibold text-heading mb-6 flex items-center">
                <svg class="w-6 h-6 mr-2 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                </svg>
                Filter & Pencarian
            </h3>
            
            <form method="GET" class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-5 gap-4">
                <div class="relative">
                    <input 
                        type="text" 
                        name="search"
                        value="{{ $search }}"
                        placeholder="Cari judul atau penulis..."
                        class="w-full border-2 border-primary-200 rounded-xl px-4 py-3 pl-10 focus:border-primary-500 focus:ring-0 transition-colors"
                    >
                    <svg class="absolute left-3 top-3.5 w-5 h-5 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>

                <select name="kategori" class="border-2 border-primary-200 rounded-xl px-4 py-3 focus:border-primary-500 focus:ring-0 transition-colors">
                    <option value="">📂 Semua Kategori</option>
                    @foreach($kategoris as $item)
                        <option value="{{ $item }}" {{ $kategori == $item ? 'selected' : '' }}>
                            {{ ucfirst($item) }}
                        </option>
                    @endforeach
                </select>

                <select name="tahun" class="border-2 border-primary-200 rounded-xl px-4 py-3 focus:border-primary-500 focus:ring-0 transition-colors">
                    <option value="">📅 Semua Tahun</option>
                    @foreach($tahuns as $th)
                        <option value="{{ $th }}" {{ $tahun == $th ? 'selected' : '' }}>
                            {{ $th }}
                        </option>
                    @endforeach
                </select>

                <select name="bulan" class="border-2 border-primary-200 rounded-xl px-4 py-3 focus:border-primary-500 focus:ring-0 transition-colors">
                    <option value="">🗓️ Semua Bulan</option>
                    @for($b = 1; $b <= 12; $b++)
                        <option value="{{ $b }}" {{ $bulan == $b ? 'selected' : '' }}>
                            {{ \Carbon\Carbon::create()->month($b)->translatedFormat('F') }}
                        </option>
                    @endfor
                </select>

                <button type="submit" class="btn-primary flex items-center justify-center space-x-2 px-6 py-3 rounded-xl font-medium transition-all hover:scale-105">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <span>Cari</span>
                </button>
            </form>
            
            @if($search || $kategori || $tahun || $bulan)
                <div class="mt-4 flex items-center justify-between">
                    <div class="text-sm text-muted">
                        Menampilkan {{ $berita->count() }} dari {{ $berita->total() }} berita
                        @if($search) untuk "{{ $search }}" @endif
                        @if($kategori) dalam kategori "{{ $kategori }}" @endif
                        @if($tahun) tahun {{ $tahun }} @endif
                        @if($bulan) bulan {{ \Carbon\Carbon::create()->month($bulan)->translatedFormat('F') }} @endif
                    </div>
                    <a href="{{ route('berita.index') }}" class="text-primary-600 hover:text-primary-700 text-sm font-medium">
                        🔄 Reset Filter
                    </a>
                </div>
            @endif
        </div>

        @if($berita->count() > 0)
            <!-- Berita Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
                @foreach($berita as $item)
                    <article class="card-bg rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transform hover:-translate-y-2 transition-all duration-300 group">
                        <a href="{{ route('berita.show', $item->id) }}" class="block">
                            <!-- Image -->
                            <div class="relative overflow-hidden">
                                @if ($item->gambar_url)
                                    <img src="{{ $item->gambar_url }}" 
                                         alt="{{ $item->judul }}"
                                         class="w-full h-56 object-cover group-hover:scale-110 transition-transform duration-500">
                                @else
                                    <div class="w-full h-56 bg-gradient-to-br from-primary-100 to-secondary-100 flex items-center justify-center">
                                        <svg class="w-16 h-16 text-primary-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                                        </svg>
                                    </div>
                                @endif
                                
                                <!-- Kategori Badge -->
                                <div class="absolute top-4 left-4">
                                    <span class="px-3 py-1 text-xs font-medium bg-primary-500 text-white rounded-full shadow-lg">
                                        📂 {{ ucfirst($item->kategori) }}
                                    </span>
                                </div>
                                
                                <!-- Views Badge -->
                                <div class="absolute top-4 right-4">
                                    <span class="px-2 py-1 text-xs bg-black bg-opacity-50 text-white rounded-full flex items-center space-x-1">
                                        <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"></path>
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"></path>
                                        </svg>
                                        <span>{{ number_format($item->views ?? 0) }}</span>
                                    </span>
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="p-6">
                                <h3 class="text-xl font-bold text-heading mb-3 line-clamp-2 group-hover:text-primary-600 transition-colors">
                                    {{ $item->judul }}
                                </h3>

                                <p class="text-body text-sm leading-relaxed mb-4 line-clamp-3">
                                    {{ strip_tags(Str::limit($item->konten ?? $item->isi, 120)) }}
                                </p>

                                <!-- Meta Info -->
                                <div class="flex items-center justify-between text-xs text-muted">
                                    <div class="flex items-center space-x-3">
                                        <span class="flex items-center space-x-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                            </svg>
                                            <span>{{ $item->penulis }}</span>
                                        </span>
                                        <span class="flex items-center space-x-1">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            <span>{{ $item->created_at?->translatedFormat('d M Y') }}</span>
                                        </span>
                                    </div>
                                    
                                    <span class="text-primary-600 font-medium group-hover:text-primary-700">
                                        Baca Selengkapnya →
                                    </span>
                                </div>
                            </div>
                        </a>
                    </article>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="flex justify-center">
                <div class="card-bg rounded-2xl p-2">
                    {{ $berita->appends(request()->query())->links() }}
                </div>
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-16">
                <div class="card-bg rounded-2xl p-12 max-w-lg mx-auto">
                    <svg class="w-24 h-24 text-primary-300 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                    </svg>
                    <h3 class="text-2xl font-semibold text-heading mb-3">Tidak Ada Berita</h3>
                    <p class="text-body mb-6">
                        @if($search || $kategori || $tahun || $bulan)
                            Tidak ditemukan berita yang sesuai dengan filter yang Anda pilih.
                        @else
                            Saat ini belum ada berita yang dipublikasikan.
                        @endif
                    </p>
                    @if($search || $kategori || $tahun || $bulan)
                        <a href="{{ route('berita.index') }}" class="btn-primary inline-flex items-center space-x-2 px-6 py-3 rounded-xl">
                            <span>🔄 Lihat Semua Berita</span>
                        </a>
                    @endif
                </div>
            </div>
        @endif
    </div>
</div>
@endsection