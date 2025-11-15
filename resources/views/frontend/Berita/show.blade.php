@extends('frontend.layouts.berita')

@section('content')
<div class="bg-gray-100 dark:bg-gray-900 py-16">
    <div class="container mx-auto px-4 lg:px-8 grid grid-cols-1 lg:grid-cols-3 gap-10">

        <!-- Konten utama -->
        <div class="lg:col-span-2">
            
            @if ($berita->image_url)
                <img src="{{ $berita->image_url }}" class="w-full rounded-xl mb-6 shadow">
            @endif

            <span class="px-3 py-1 bg-indigo-600 text-white rounded-full text-xs">
                {{ ucfirst($berita->kategori) }}
            </span>

            <h1 class="mt-4 text-4xl font-extrabold dark:text-white">
                {{ $berita->judul }}
            </h1>

            <div class="text-gray-500 dark:text-gray-400 text-sm mt-2">
                {{ $berita->penulis }} • 
                {{ $berita->created_at->translatedFormat('d F Y') }} • 
                {{ $berita->views }} views
            </div>

            <div class="prose dark:prose-invert mt-6">
                {!! $berita->isi !!}
            </div>

            <!-- Berita Terkait -->
            <h2 class="text-2xl font-bold mt-12 mb-6 dark:text-white">Berita Terkait</h2>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                @foreach($beritaTerkait as $item)
                    <a href="{{ route('berita.show', $item->id) }}"
                       class="bg-white dark:bg-gray-800 p-4 rounded-xl shadow hover:shadow-lg transition">

                        <h4 class="font-bold dark:text-white">{{ $item->judul }}</h4>
                        <p class="text-sm text-gray-500 dark:text-gray-400">
                            {{ $item->created_at->translatedFormat('d M Y') }}
                        </p>
                    </a>
                @endforeach
            </div>
        </div>

        <!-- Sidebar -->
        <div>
            <h3 class="text-xl font-bold mb-4 dark:text-white">Berita Terbaru</h3>

            @foreach($beritaTerbaru as $item)
                <a href="{{ route('berita.show', $item->id) }}" class="block mb-4">
                    <div class="bg-white dark:bg-gray-800 p-4 rounded-xl shadow hover:shadow-lg transition">
                        <h4 class="font-semibold">{{ $item->judul }}</h4>
                        <span class="text-gray-500 text-sm">
                            {{ $item->created_at->translatedFormat('d M Y') }}
                        </span>
                    </div>
                </a>
            @endforeach
        </div>

    </div>
</div>
@endsection
