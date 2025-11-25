@extends('frontend.layouts.ppid')

@section('content')
<!-- Hero Section dengan Background Gradient -->
<div class="section-bg-primary py-16">
<div class="flex justify-end mb-6">
            @include('frontend.layouts.partials.submenu')
        </div>
    <div class="container mx-auto px-4 py-16 lg:px-8">
        <!-- Page Title -->
        <div class="text-center mb-12">
            <h1 class="text-4xl lg:text-5xl font-bold text-heading mb-4">
                📋 PPID - Layanan Informasi Publik
            </h1>
            <p class="text-lg text-body max-w-3xl mx-auto leading-relaxed">
                Pejabat Pengelola Informasi dan Dokumentasi (PPID) menyediakan akses informasi publik sesuai 
                dengan ketentuan Undang-Undang No. 14 Tahun 2008 tentang Keterbukaan Informasi Publik.
            </p>
        </div>

        <!-- Statistik Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-12">
            <div class="stat-card text-center">
                <div class="stat-number">{{ $totalDokumen }}</div>
                <div class="stat-label">Total Dokumen</div>
            </div>
            <div class="stat-card text-center">
                <div class="stat-number">{{ $kategoris->count() }}</div>
                <div class="stat-label">kategori Informasi</div>
            </div>
        </div>

        <!-- Info Cards Jenis Informasi -->
        <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-12">
            <div class="card-bg p-6 rounded-2xl text-center shadow-lg hover:shadow-xl transition-all hover:-translate-y-1">
                <div class="text-4xl mb-3">📅</div>
                <h3 class="font-semibold text-heading mb-2">Informasi Berkala</h3>
                <p class="text-sm text-body">Informasi yang wajib disediakan dan diumumkan secara berkala</p>
            </div>
            <div class="card-bg p-6 rounded-2xl text-center shadow-lg hover:shadow-xl transition-all hover:-translate-y-1">
                <div class="text-4xl mb-3">⚡</div>
                <h3 class="font-semibold text-heading mb-2">Informasi Sertamerta</h3>
                <p class="text-sm text-body">Informasi yang wajib diumumkan serta merta</p>
            </div>
            <div class="card-bg p-6 rounded-2xl text-center shadow-lg hover:shadow-xl transition-all hover:-translate-y-1">
                <div class="text-4xl mb-3">⏰</div>
                <h3 class="font-semibold text-heading mb-2">Informasi Setiap Saat</h3>
                <p class="text-sm text-body">Informasi yang wajib tersedia setiap saat</p>
            </div>
            <div class="card-bg p-6 rounded-2xl text-center shadow-lg hover:shadow-xl transition-all hover:-translate-y-1">
                <div class="text-4xl mb-3">🔒</div>
                <h3 class="font-semibold text-heading mb-2">Informasi Dikecualikan</h3>
                <p class="text-sm text-body">Informasi yang dikecualikan berdasarkan undang-undang</p>
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
                Filter & Pencarian Dokumen
            </h3>
            
            <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
                <div class="relative">
                    <input 
                        type="text" 
                        name="search"
                        value="{{ $search }}"
                        placeholder="Cari judul dokumen..."
                        class="w-full border-2 border-primary-200 rounded-xl px-4 py-3 pl-10 focus:border-primary-500 focus:ring-0 transition-colors"
                    >
                    <svg class="absolute left-3 top-3.5 w-5 h-5 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                </div>

                <select name="kategori" class="border-2 border-primary-200 rounded-xl px-4 py-3 focus:border-primary-500 focus:ring-0 transition-colors">
                    <option value="">📁 Semua Kategori</option>
                    @foreach($kategoris as $item)
                        <option value="{{ $item }}" {{ $kategori == $item ? 'selected' : '' }}>
                            {{ ucwords(str_replace('_', ' ', $item)) }}
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

                <button type="submit" class="btn-primary flex items-center justify-center space-x-2 px-6 py-3 rounded-xl font-medium transition-all hover:scale-105">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                    </svg>
                    <span>Cari</span>
                </button>
            </form>
            
            @if($search || $kategori || $tahun)
                <div class="mt-4 flex items-center justify-between">
                    <div class="text-sm text-muted">
                        Menampilkan {{ $dokumen->count() }} dari {{ $dokumen->total() }} dokumen
                        @if($search) untuk "{{ $search }}" @endif
                        @if($kategori) kategori "{{ ucwords(str_replace('_', ' ', $kategori)) }}" @endif
                        @if($tahun) tahun {{ $tahun }} @endif
                    </div>
                    <a href="{{ route('ppid.index') }}" class="text-primary-600 hover:text-primary-700 text-sm font-medium">
                        🔄 Reset Filter
                    </a>
                </div>
            @endif
        </div>

        @if($dokumen->count() > 0)
            <!-- Dokumen Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8 mb-12">
                @foreach($dokumen as $item)
                    <article class="card-bg rounded-2xl overflow-hidden shadow-lg hover:shadow-xl transform hover:-translate-y-2 transition-all duration-300 group">
                        <div class="p-6">
                            <!-- Header -->
                            <div class="flex items-start justify-between mb-4">
                                <div class="flex-1">
                                    <span class="px-3 py-1 text-xs font-medium bg-primary-500 text-white rounded-full">
                                        📄 {{ ucwords(str_replace('_', ' ', $item->kategori)) }}
                                    </span>
                                </div>
                                <div class="text-sm text-muted">
                                    {{ $item->tahun }}
                                </div>
                            </div>

                            <!-- Title -->
                            <h3 class="text-lg font-bold text-heading mb-3 line-clamp-2 group-hover:text-primary-600 transition-colors">
                                {{ $item->judul_dokumen }}
                            </h3>

                            <!-- Meta Info -->
                            <div class="space-y-2 mb-4 text-sm text-body">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-4 h-4 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    <span>{{ $item->uploader }}</span>
                                </div>
                                <div class="flex items-center space-x-2">
                                    <svg class="w-4 h-4 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <span>{{ $item->tanggal_upload->translatedFormat('d M Y') }}</span>
                                </div>
                            </div>

                            <!-- Actions -->
                            <div class="flex space-x-3">
                                <a href="{{ route('ppid.show', $item->id) }}" 
                                   class="flex-1 btn-secondary text-center py-2 rounded-xl text-sm font-medium transition-all">
                                    👁️ Lihat Detail
                                </a>
                                <a href="{{ route('ppid.download', $item->id) }}" 
                                   class="flex-1 btn-primary text-center py-2 rounded-xl text-sm font-medium transition-all"
                                   target="_blank">
                                    📥 Download
                                </a>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>

            <!-- Pagination -->
            <div class="flex justify-center">
                <div class="card-bg rounded-2xl p-2">
                    {{ $dokumen->appends(request()->query())->links() }}
                </div>
            </div>
        @else
            <!-- Empty State -->
            <div class="text-center py-16">
                <div class="card-bg rounded-2xl p-12 max-w-lg mx-auto">
                    <svg class="w-24 h-24 text-primary-300 mx-auto mb-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                    </svg>
                    <h3 class="text-2xl font-semibold text-heading mb-3">Tidak Ada Dokumen</h3>
                    <p class="text-body mb-6">
                        @if($search || $kategori || $tahun)
                            Tidak ditemukan dokumen yang sesuai dengan filter yang Anda pilih.
                        @else
                            Saat ini belum ada dokumen yang tersedia.
                        @endif
                    </p>
                    @if($search || $kategori || $tahun)
                        <a href="{{ route('ppid.index') }}" class="btn-primary inline-flex items-center space-x-2 px-6 py-3 rounded-xl">
                            <span>🔄 Lihat Semua Dokumen</span>
                        </a>
                    @endif
                </div>
            </div>
        @endif
    </div>
</div>
      </p>
    </div>
  </div>
</section>
@endsection