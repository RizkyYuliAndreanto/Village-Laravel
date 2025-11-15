@extends('frontend.layouts.berita')

@section('content')
<div class="bg-gray-100 dark:bg-gray-900 py-16">
    <div class="container mx-auto px-4 lg:px-8">
        
        <!-- Page Title -->
        <div class="text-center mb-10">
            <h1 class="text-4xl font-extrabold text-gray-800 dark:text-gray-100">
                Berita Desa
            </h1>
            <p class="text-gray-600 dark:text-gray-300">
                Informasi terbaru seputar desa, pengumuman, dan kegiatan masyarakat.
            </p>
        </div>

        <!-- Filter Search -->
        <form method="GET" class="mb-10 grid grid-cols-1 md:grid-cols-4 gap-4">
            <input 
                type="text" 
                name="search"
                value="{{ $search }}"
                placeholder="Cari judul / penulis..."
                class="border rounded-lg px-4 py-2 dark:bg-gray-800 dark:text-white"
            >

            <select name="kategori" class="border rounded-lg px-4 py-2 dark:bg-gray-800 dark:text-white">
                <option value="">Semua Kategori</option>
                @foreach($kategoris as $item)
                    <option value="{{ $item }}" {{ $kategori == $item ? 'selected' : '' }}>
                        {{ ucfirst($item) }}
                    </option>
                @endforeach
            </select>

            <select name="tahun" class="border rounded-lg px-4 py-2 dark:bg-gray-800 dark:text-white">
                <option value="">Semua Tahun</option>
                @foreach($tahuns as $th)
                    <option value="{{ $th }}" {{ $tahun == $th ? 'selected' : '' }}>
                        {{ $th }}
                    </option>
                @endforeach
            </select>

            <select name="bulan" class="border rounded-lg px-4 py-2 dark:bg-gray-800 dark:text-white">
                <option value="">Semua Bulan</option>
                @for($b = 1; $b <= 12; $b++)
                    <option value="{{ $b }}" {{ $bulan == $b ? 'selected' : '' }}>
                        {{ \Carbon\Carbon::create()->month($b)->translatedFormat('F') }}
                    </option>
                @endfor
            </select>
        </form>

        <!-- Statistik -->
        <div class="mb-8 grid grid-cols-2 md:grid-cols-4 gap-4">
            <div class="p-4 bg-white dark:bg-gray-800 rounded-lg shadow text-center">
                <h3 class="text-xl font-bold">{{ $totalBerita }}</h3>
                <p class="text-gray-500 text-sm">Total Berita</p>
            </div>

            <div class="p-4 bg-white dark:bg-gray-800 rounded-lg shadow text-center">
                <h3 class="text-xl font-bold">{{ $beritaBulanIni }}</h3>
                <p class="text-gray-500 text-sm">Bulan Ini</p>
            </div>
        </div>

        <!-- Berita Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($berita as $item)
                <a href="{{ route('berita.show', $item->id) }}" 
                   class="bg-white dark:bg-gray-800 rounded-xl shadow hover:shadow-lg transition overflow-hidden">

                    @if ($item->image_url)
                        <img src="{{ $item->image_url }}" class="w-full h-48 object-cover">
                    @else
                        <div class="w-full h-48 bg-gray-300 dark:bg-gray-700"></div>
                    @endif

                    <div class="p-5">
                        <span class="px-3 py-1 text-xs bg-indigo-600 text-white rounded-full">
                            {{ ucfirst($item->kategori) }}
                        </span>

                        <h3 class="text-lg font-bold mt-3 text-gray-800 dark:text-white">
                            {{ $item->judul }}
                        </h3>

                        <p class="text-gray-500 dark:text-gray-400 text-sm mt-2 line-clamp-3">
                            {{ strip_tags(Str::limit($item->isi, 100)) }}
                        </p>

                        <div class="text-gray-400 text-xs mt-3">
                            {{ $item->penulis }} – {{ $item->created_at?->translatedFormat('d M Y') }}
                        </div>
                    </div>
                </a>
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-10">
            {{ $berita->links() }}
        </div>

    </div>
</div>
@endsection
