@extends('frontend.layouts.berita')

@section('content')
<!-- Hero Section dengan Background Gradient -->
<div class="section-bg-primary py-16">
    <div class="container mx-auto px-4 lg:px-8">
        <!-- Breadcrumb -->
        <nav class="mb-8" aria-label="Breadcrumb">
            <ol class="flex items-center space-x-2 text-sm">
                <li><a href="{{ route('home') }}" class="text-primary-600 hover:text-primary-700 transition-colors">Beranda</a></li>
                <li class="text-primary-400">/</li>
                <li><a href="{{ route('berita.index') }}" class="text-primary-600 hover:text-primary-700 transition-colors">Berita</a></li>
                <li class="text-primary-400">/</li>
                <li class="text-primary-800 font-medium">Arsip {{ $tahun }}@if($bulan) - {{ data_get($namaBulan, $bulan, 'Bulan ' . $bulan) }}@endif</li>
            </ol>
        </nav>

        <!-- Page Title -->
        <div class="text-center mb-12">
            <h1 class="text-4xl lg:text-5xl font-bold text-heading mb-4">
                📅 Arsip Berita Tahun {{ $tahun }}
                @if($bulan)
                    <br><span class="text-3xl text-primary-600">{{ data_get($namaBulan, $bulan, 'Bulan ' . $bulan) }}</span>
                @endif
            </h1>
            <p class="text-lg text-body max-w-2xl mx-auto leading-relaxed">
                @if($bulan)
                    Koleksi berita dari bulan {{ data_get($namaBulan, $bulan, 'Bulan ' . $bulan) }} {{ $tahun }}
                @else
                    Koleksi berita dari tahun {{ $tahun }} - pilih bulan untuk melihat berita yang lebih spesifik
                @endif
            </p>
        </div>
    </div>
</div>

<!-- Content Section -->
<div class="bg-white py-16">
    <div class="container mx-auto px-4 lg:px-8">

        <!-- Month Selector -->
        <div class="card-bg rounded-2xl p-6 mb-12">
            <h3 class="text-xl font-semibold text-heading mb-6 flex items-center">
                <svg class="w-6 h-6 mr-2 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                </svg>
                Pilih Bulan
            </h3>
            
            <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-3">
                <!-- All Year Button -->
                <a href="{{ route('berita.arsip', ['tahun' => $tahun]) }}"
                   class="text-center px-4 py-3 rounded-xl font-medium transition-all transform hover:scale-105
                          @if(!$bulan)
                              btn-primary text-white shadow-lg
                          @else
                              bg-white border-2 border-primary-200 text-primary-700 hover:border-primary-400
                          @endif">
                    <div class="text-sm font-semibold">Seluruh Tahun</div>
                    <div class="text-xs mt-1 opacity-75">
                        {{ array_sum($statistikBulan) }} berita
                    </div>
                </a>

                @foreach($namaBulan as $num => $bln)
                    <a href="{{ route('berita.arsip', ['tahun' => $tahun, 'bulan' => $num]) }}"
                       class="text-center px-4 py-3 rounded-xl font-medium transition-all transform hover:scale-105
                              @if($bulan == $num)
                                  btn-primary text-white shadow-lg
                              @else
                                  bg-white border-2 border-primary-200 text-primary-700 hover:border-primary-400
                                  @if(($statistikBulan[$num] ?? 0) == 0) opacity-50 @endif
                              @endif">
                        <div class="text-sm font-semibold">{{ $bln }}</div>
                        <div class="text-xs mt-1 opacity-75">
                            {{ $statistikBulan[$num] ?? 0 }} berita
                        </div>
                    </a>
                @endforeach
            </div>
        </div>

        @if($berita->count() > 0)
            <!-- Statistics -->
            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 mb-12">
                <div class="stat-card text-center">
                    <div class="stat-number">{{ $berita->total() }}</div>
                    <div class="stat-label">
                        Total Berita 
                        @if($bulan) {{ data_get($namaBulan, $bulan, 'Bulan ' . $bulan) }} @endif 
                        {{ $tahun }}
                    </div>
                </div>
                <div class="stat-card text-center">
                    <div class="stat-number">{{ $berita->count() }}</div>
                    <div class="stat-label">Ditampilkan</div>
                </div>
                <div class="stat-card text-center">
                    <div class="stat-number">{{ $berita->currentPage() }}</div>
                    <div class="stat-label">Halaman {{ $berita->lastPage() }}</div>
                </div>
            </div>

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
                                         class="w-full h-48 object-cover group-hover:scale-110 transition-transform duration-500">
                                @else
                                    <div class="w-full h-48 bg-gradient-to-br from-primary-100 to-secondary-100 flex items-center justify-center">
                                        <svg class="w-12 h-12 text-primary-300" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 20H5a2 2 0 01-2-2V6a2 2 0 012-2h10a2 2 0 012 2v1m2 13a2 2 0 01-2-2V7m2 13a2 2 0 002-2V9a2 2 0 00-2-2h-2m-4-3H9M7 16h6M7 8h6v4H7V8z"></path>
                                        </svg>
                                    </div>
                                @endif
                                
                                <!-- Date Badge -->
                                <div class="absolute top-4 left-4">
                                    <span class="px-3 py-1 text-xs font-medium bg-primary-500 text-white rounded-full shadow-lg">
                                        📅 {{ $item->created_at->translatedFormat('d M') }}
                                    </span>
                                </div>
                                
                                <!-- Category Badge -->
                                <div class="absolute top-4 right-4">
                                    <span class="px-2 py-1 text-xs bg-secondary-500 text-white rounded-full">
                                        {{ ucfirst($item->kategori) }}
                                    </span>
                                </div>
                            </div>

                            <!-- Content -->
                            <div class="p-6">
                                <h3 class="text-lg font-bold text-heading mb-3 line-clamp-2 group-hover:text-primary-600 transition-colors">
                                    {{ $item->judul }}
                                </h3>

                                <p class="text-body text-sm leading-relaxed mb-4 line-clamp-2">
                                    {{ strip_tags(Str::limit($item->konten ?? $item->isi, 100)) }}
                                </p>

                                <!-- Meta Info -->
                                <div class="flex items-center justify-between text-xs text-muted">
                                    <div class="flex items-center space-x-2">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                        </svg>
                                        <span>{{ $item->penulis }}</span>
                                    </div>
                                    
                                    <span class="text-primary-600 font-medium group-hover:text-primary-700">
                                        Baca →
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
                    {{ $berita->links() }}
                </div>
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-16">
                <div class="card-bg rounded-2xl p-12 max-w-lg mx-auto">
                    <svg class="w-24 h-24 text-primary-300 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                    </svg>
                    <h3 class="text-2xl font-semibold text-heading mb-3">Tidak Ada Berita</h3>
                    <p class="text-body mb-6">
                        Tidak ada berita yang dipublikasikan 
                        @if($bulan)
                            pada bulan {{ data_get($namaBulan, $bulan, 'Bulan ' . $bulan) }}
                        @endif
                        tahun {{ $tahun }}.
                    </p>
                    <div class="space-y-3">
                        @if($bulan)
                            <a href="{{ route('berita.arsip', ['tahun' => $tahun]) }}" class="btn-primary inline-flex items-center space-x-2 px-6 py-3 rounded-xl">
                                <span>📅 Lihat Seluruh Tahun {{ $tahun }}</span>
                            </a>
                        @endif
                        <div>
                            <a href="{{ route('berita.index') }}" class="btn-secondary inline-flex items-center space-x-2 px-6 py-3 rounded-xl">
                                <span>📰 Lihat Semua Berita</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @endif

        <!-- Back Navigation -->
        <div class="mt-12 text-center">
            <div class="flex flex-wrap justify-center gap-4">
                @if($bulan)
                    <a href="{{ route('berita.arsip', ['tahun' => $tahun]) }}" 
                       class="btn-secondary inline-flex items-center space-x-2 px-6 py-3 rounded-xl">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        <span>📅 Seluruh Tahun {{ $tahun }}</span>
                    </a>
                @endif
                <a href="{{ route('berita.index') }}" 
                   class="btn-primary inline-flex items-center space-x-2 px-6 py-3 rounded-xl">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                    </svg>
                    <span>📰 Semua Berita</span>
                </a>
            </div>
        </div>
    </div>
</div>
@endsection
