@extends('frontend.layouts.berita')

@section('content')
<div class="bg-gray-100 dark:bg-gray-900 py-16">
    <div class="container mx-auto px-4 lg:px-8">

        <h1 class="text-4xl font-bold mb-6 dark:text-white">
            Arsip Berita Tahun {{ $tahun }}
            @if($bulan)
                – {{ $namaBulan[$bulan] }}
            @endif
        </h1>

        <div class="grid grid-cols-2 md:grid-cols-6 gap-3 mb-10">
            @foreach($namaBulan as $num => $bln)
                <a href="{{ route('berita.arsip', ['tahun' => $tahun, 'bulan' => $num]) }}"
                   class="text-center px-3 py-2 rounded-lg text-sm 
                          @if($bulan == $num)
                              bg-indigo-600 text-white
                          @else
                              bg-white dark:bg-gray-800 dark:text-white shadow
                          @endif">
                    {{ $bln }}
                    <div class="text-xs text-gray-500">
                        {{ $statistikBulan[$num] ?? 0 }} berita
                    </div>
                </a>
            @endforeach
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            @foreach($berita as $item)
                <a href="{{ route('berita.show', $item->id) }}"
                   class="bg-white dark:bg-gray-800 p-5 rounded-xl shadow hover:shadow-lg transition">

                    <h3 class="font-bold text-lg dark:text-white">{{ $item->judul }}</h3>
                    <p class="text-gray-500 text-sm">
                        {{ $item->created_at->translatedFormat('d M Y') }}
                    </p>
                </a>
            @endforeach
        </div>

        <div class="mt-10">
            {{ $berita->links() }}
        </div>

    </div>
</div>
@endsection
