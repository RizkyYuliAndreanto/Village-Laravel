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
        <form method="GET" onchange="this.form.submit()" class="mb-10 grid grid-cols-1 md:grid-cols-4 gap-4">
            <input 
                type="text" 
                name="search"
                value="{{ $search }}"
                placeholder="Cari judul / penulis..."
                class="border rounded-lg px-4 py-2 dark:bg-gray-800 dark:text-white"
            >

            <select name="kategori" ... onchange="this.form.submit()" class="border rounded-lg px-4 py-2 dark:bg-gray-800 dark:text-white">
                <option value="">Semua Kategori</option>
                @foreach($kategoris as $item)
                    <option value="{{ $item }}" {{ $kategori == $item ? 'selected' : '' }}>
                        {{ ucfirst($item) }}
                    </option>
                @endforeach
            </select>

            <select name="tahun" ... onchange="this.form.submit()" class="border rounded-lg px-4 py-2 dark:bg-gray-800 dark:text-white">
                <option value="">Semua Tahun</option>
                @foreach($tahuns as $th)
                    <option value="{{ $th }}" {{ $tahun == $th ? 'selected' : '' }}>
                        {{ $th }}
                    </option>
                @endforeach
            </select>

            <select name="bulan" ... onchange="this.form.submit()" class="border rounded-lg px-4 py-2 dark:bg-gray-800 dark:text-white">
                <option value="">Semua Bulan</option>
                @for($b = 1; $b <= 12; $b++)
                    <option value="{{ $b }}" {{ $bulan == $b ? 'selected' : '' }}>
                        {{ \Carbon\Carbon::create()->month($b)->translatedFormat('F') }}
                    </option>
                @endfor
            </select>
        </form>

        <!-- Berita Grid -->
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($berita as $item)
            <x-frontend.components.berita-card :item="$item" type="full" />
            @endforeach
        </div>

        <!-- Pagination -->
        <div class="mt-10">
            {{ $berita->links() }}
        </div>

    </div>
</div>
@endsection
