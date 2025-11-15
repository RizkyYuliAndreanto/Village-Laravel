@extends('frontend.layouts.ppid')

@section('content')

<!-- ==================== HERO ==================== -->
<section class="py-16 bg-gray-100 dark:bg-gray-900">
    <div class="container mx-auto px-6 text-center">
        <h1 class="text-4xl font-extrabold text-gray-900 dark:text-white mb-3">
            PPID Desa
        </h1>
        <p class="text-gray-700 dark:text-gray-300 max-w-2xl mx-auto">
            Akses informasi publik desa secara cepat, mudah, dan transparan.
        </p>
    </div>
</section>

<!-- ==================== FILTER ==================== -->
<section class="py-8 bg-white dark:bg-gray-800 shadow">
    <div class="container mx-auto px-6">

        <form method="GET" class="grid grid-cols-1 md:grid-cols-4 gap-4">
            <input 
                type="text" 
                name="search" 
                value="{{ $search }}"
                placeholder="Cari dokumen..."
                class="w-full px-4 py-2 border rounded-lg dark:bg-gray-900 dark:border-gray-700"
            >

            <select name="kategori" class="px-4 py-2 border rounded-lg dark:bg-gray-900 dark:border-gray-700">
                <option value="">Semua Kategori</option>
                @foreach ($kategoris as $kat)
                    <option value="{{ $kat }}" {{ $kategori == $kat ? 'selected' : '' }}>{{ $kat }}</option>
                @endforeach
            </select>

            <select name="jenis_dokumen" class="px-4 py-2 border rounded-lg dark:bg-gray-900 dark:border-gray-700">
                <option value="">Semua Jenis</option>
                @foreach ($jenisDokumens as $jenis)
                    <option value="{{ $jenis }}" {{ $jenisDokumen == $jenis ? 'selected' : '' }}>
                        {{ ucfirst(str_replace('_',' ', $jenis)) }}
                    </option>
                @endforeach
            </select>

            <select name="tahun" class="px-4 py-2 border rounded-lg dark:bg-gray-900 dark:border-gray-700">
                <option value="">Semua Tahun</option>
                @foreach ($tahuns as $th)
                    <option value="{{ $th }}" {{ $tahun == $th ? 'selected' : '' }}>{{ $th }}</option>
                @endforeach
            </select>
        </form>
    </div>
</section>

<!-- ==================== DATA LIST ==================== -->
<section class="py-10 bg-gray-100 dark:bg-gray-900">
    <div class="container mx-auto px-6">

        @if ($dokumen->count() == 0)
            <p class="text-center text-gray-600 dark:text-gray-400 py-10">
                Tidak ada dokumen ditemukan.
            </p>
        @endif

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
            @foreach ($dokumen as $item)
                <div class="p-5 bg-white dark:bg-gray-800 rounded-lg shadow">
                    <h3 class="text-lg font-bold mb-2 text-gray-900 dark:text-white">
                        {{ $item->judul_dokumen }}
                    </h3>

                    <p class="text-sm text-gray-600 dark:text-gray-400 mb-3">
                        {{ \Carbon\Carbon::parse($item->tanggal_dokumen)->format('d M Y') }}
                    </p>

                    <p class="text-sm text-gray-700 dark:text-gray-300 mb-3 line-clamp-2">
                        {{ $item->deskripsi }}
                    </p>

                    <div class="flex justify-between items-center mt-4">
                        <span class="text-xs bg-blue-100 dark:bg-blue-900 text-blue-600 dark:text-blue-300 px-2 py-1 rounded">
                            {{ $item->kategori_informasi }}
                        </span>

                        <a href="{{ route('ppid.show', $item->id) }}"
                           class="text-blue-600 dark:text-blue-400 hover:underline text-sm">
                            Lihat Detail
                        </a>
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-8">
            {{ $dokumen->links() }}
        </div>

    </div>
</section>

@endsection
