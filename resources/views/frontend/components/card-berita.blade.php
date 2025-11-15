@props([
    'item', // Ini adalah objek $berita
    'type' => 'full' // Kita buat 2 tipe: 'full' (untuk index) dan 'simple' (untuk sidebar)
])

@if ($type == 'full')
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

@elseif ($type == 'simple')
    <a href="{{ route('berita.show', $item->id) }}"
       class="bg-white dark:bg-gray-800 p-4 rounded-xl shadow hover:shadow-lg transition block mb-4">
        
        <h4 class="font-bold dark:text-white line-clamp-2">{{ $item->judul }}</h4>
        <p class="text-sm text-gray-500 dark:text-gray-400">
            {{ $item->created_at->translatedFormat('d M Y') }}
        </p>
    </a>
@endif