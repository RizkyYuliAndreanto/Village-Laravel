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
                <li class="text-primary-800 font-medium">{{ ucwords(str_replace('_', ' ', $kategori)) }}</li>
            </ol>
        </nav>

        <!-- Header -->
        <div class="text-center">
            <h1 class="text-4xl lg:text-5xl font-bold text-heading mb-4">
                📂 {{ ucwords(str_replace('_', ' ', $kategori)) }}
            </h1>
            <p class="text-lg text-body max-w-3xl mx-auto leading-relaxed">
                @switch($kategori)
                    @case('informasi_berkala')
                        Dokumen informasi yang wajib disediakan dan diumumkan secara berkala sesuai dengan ketentuan peraturan perundang-undangan
                        @break
                    @case('informasi_sertamerta')
                        Dokumen informasi yang wajib diumumkan serta merta karena dapat mengancam hajat hidup orang banyak dan ketertiban umum
                        @break
                    @case('informasi_setiap_saat')
                        Dokumen informasi yang wajib tersedia setiap saat dan dapat diakses oleh publik sesuai dengan kebutuhan
                        @break
                    @case('informasi_dikecualikan')
                        Dokumen informasi yang dikecualikan berdasarkan undang-undang dengan pertimbangan tertentu
                        @break
                    @default
                        Kumpulan dokumen informasi publik dalam kategori {{ str_replace('_', ' ', $kategori) }}
                @endswitch
            </p>
        </div>
    </div>
</div>

<!-- Filter & Search Section -->
<div class="bg-white py-8 border-b">
    <div class="container mx-auto px-4 lg:px-8">
        <div class="card-bg rounded-2xl p-6">
            <form method="GET" action="{{ route('ppid.kategori', $kategori) }}" class="space-y-4 lg:space-y-0 lg:flex lg:items-center lg:space-x-6">
                
                <!-- Search Input -->
                <div class="flex-1">
                    <div class="relative">
                        <svg class="absolute left-4 top-1/2 transform -translate-y-1/2 w-5 h-5 text-primary-400" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"></path>
                        </svg>
                        <input type="text" 
                               name="search" 
                               value="{{ request('search') }}"
                               placeholder="🔍 Cari dokumen dalam kategori ini..."
                               class="w-full pl-12 pr-4 py-4 border-2 border-primary-200 rounded-xl focus:border-primary-500 focus:ring focus:ring-primary-200 bg-white text-body placeholder-muted transition-all">
                    </div>
                </div>

                <!-- Filter Tahun -->
                <div class="lg:w-48">
                    <select name="tahun" class="w-full px-4 py-4 border-2 border-primary-200 rounded-xl focus:border-primary-500 focus:ring focus:ring-primary-200 bg-white text-body transition-all">
                        <option value="">📅 Semua Tahun</option>
                        @foreach($tahunList as $thn)
                            <option value="{{ $thn->tahun }}" {{ request('tahun') == $thn->tahun ? 'selected' : '' }}>
                                {{ $thn->tahun }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Sort -->
                <div class="lg:w-56">
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
                    
                    @if(request()->hasAny(['search', 'tahun', 'sort']))
                        <a href="{{ route('ppid.kategori', $kategori) }}" class="btn-secondary px-6 py-4 rounded-xl font-medium hover:scale-105 transition-all">
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
                            📊 Hasil Pencarian
                        </h3>
                        <p class="text-body">
                            Menampilkan <strong>{{ $dokumen->count() }}</strong> dari <strong>{{ $dokumen->total() }}</strong> dokumen
                            @if(request('search'))
                                untuk pencarian "<strong>{{ request('search') }}</strong>"
                            @endif
                            @if(request('tahun'))
                                tahun <strong>{{ request('tahun') }}</strong>
                            @endif
                        </p>
                    </div>
                    <div class="mt-4 lg:mt-0">
                        <span class="px-4 py-2 bg-primary-500 text-white rounded-full text-sm font-medium shadow-lg">
                            📂 {{ ucwords(str_replace('_', ' ', $kategori)) }}
                        </span>
                    </div>
                </div>
            </div>
        </div>

        @if($dokumen->count() > 0)
            <!-- Documents Grid -->
            <div class="grid grid-cols-1 lg:grid-cols-2 xl:grid-cols-3 gap-8 mb-12">
                @foreach($dokumen as $item)
                    <article class="card-bg rounded-2xl overflow-hidden shadow-lg hover:shadow-2xl transform hover:-translate-y-2 transition-all duration-300 group">
                        <div class="p-8">
                            <!-- Header dengan badge tahun -->
                            <div class="flex items-start justify-between mb-6">
                                <span class="px-3 py-1 bg-primary-100 text-primary-700 rounded-full text-sm font-medium">
                                    📅 {{ $item->tahun }}
                                </span>
                                <div class="text-right text-xs text-muted">
                                    <div>📤 {{ $item->uploader }}</div>
                                    <div>{{ $item->tanggal_upload->translatedFormat('d M Y') }}</div>
                                </div>
                            </div>

                            <!-- Title -->
                            <h3 class="text-xl font-bold text-heading group-hover:text-primary-600 transition-colors line-clamp-3 mb-4 leading-tight">
                                <a href="{{ route('ppid.show', $item->id) }}">
                                    {{ $item->judul_dokumen }}
                                </a>
                            </h3>

                            <!-- Kategori Info -->
                            <div class="bg-gray-50 rounded-lg p-4 mb-6">
                                <h4 class="font-semibold text-sm text-heading mb-2">📋 Jenis Dokumen:</h4>
                                <p class="text-sm text-body">
                                    @switch($kategori)
                                        @case('informasi_berkala')
                                            📅 Informasi yang diumumkan secara berkala sesuai peraturan
                                            @break
                                        @case('informasi_sertamerta')
                                            ⚡ Informasi yang diumumkan segera karena urgensi publik
                                            @break
                                        @case('informasi_setiap_saat')
                                            ⏰ Informasi yang selalu tersedia untuk publik
                                            @break
                                        @case('informasi_dikecualikan')
                                            🔒 Informasi dengan akses terbatas sesuai UU
                                            @break
                                        @default
                                            📄 Dokumen informasi publik
                                    @endswitch
                                </p>
                            </div>

                            <!-- Action Buttons -->
                            <div class="flex space-x-3">
                                <a href="{{ route('ppid.show', $item->id) }}" 
                                   class="flex-1 btn-secondary text-center py-3 rounded-xl font-medium hover:scale-105 transition-all">
                                    👁️ Lihat Detail
                                </a>
                                <a href="{{ route('ppid.download', $item->id) }}" 
                                   class="flex-1 btn-primary text-center py-3 rounded-xl font-medium hover:scale-105 transition-all"
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
                        @if(request()->hasAny(['search', 'tahun']))
                            Tidak ada dokumen yang sesuai dengan filter pencarian Anda dalam kategori ini.
                        @else
                            Belum ada dokumen dalam kategori <strong>{{ ucwords(str_replace('_', ' ', $kategori)) }}</strong>.
                        @endif
                    </p>
                    <div class="flex flex-col sm:flex-row gap-4 justify-center">
                        @if(request()->hasAny(['search', 'tahun']))
                            <a href="{{ route('ppid.kategori', $kategori) }}" class="btn-primary px-8 py-4 rounded-xl font-medium hover:scale-105 transition-all">
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

        <!-- Kategori Lainnya -->
        @if($kategoriLain->count() > 0)
        <section class="mt-16">
            <h2 class="text-3xl font-bold text-heading mb-8 text-center">
                📂 Kategori Lainnya
            </h2>
            
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($kategoriLain as $kat)
                    <a href="{{ route('ppid.kategori', $kat->kategori) }}" 
                       class="card-bg rounded-2xl p-6 text-center hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 group">
                        <div class="text-4xl mb-4">
                            @switch($kat->kategori)
                                @case('informasi_berkala') 📅 @break
                                @case('informasi_sertamerta') ⚡ @break
                                @case('informasi_setiap_saat') ⏰ @break
                                @case('informasi_dikecualikan') 🔒 @break
                                @default 📄 
                            @endswitch
                        </div>
                        <h3 class="font-bold text-heading group-hover:text-primary-600 transition-colors mb-2">
                            {{ ucwords(str_replace('_', ' ', $kat->kategori)) }}
                        </h3>
                        <p class="text-sm text-muted mb-3">{{ $kat->total }} dokumen</p>
                        <div class="btn-primary text-sm px-4 py-2 rounded-lg">
                            Lihat Dokumen →
                        </div>
                    </a>
                @endforeach
            </div>
        </section>
        @endif
    </div>
</div>
@endsection