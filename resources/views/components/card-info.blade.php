@props([
    'title' => 'Judul Default',
    'summary' => 'Deskripsi singkat',
    'image' => asset('images/logo-placeholder.jpg'),
])

<div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md overflow-hidden flex flex-col hover:shadow-lg transition duration-300 w-full h-80">
    <img src="{{ $image }}" alt="{{ $title }}" class="w-full h-32 object-contain bg-gray-100">
    
    <div class="p-4 flex flex-col flex-grow text-left">
        <h3 class="text-base font-semibold text-gray-800 dark:text-white line-clamp-1">{{ $title }}</h3>
        <p class="text-sm text-gray-600 dark:text-gray-400 mt-2 flex-grow line-clamp-3">
            {{ $summary }}
        </p>
        <a href="#"
           class="text-indigo-600 text-sm mt-3 inline-block hover:underline">
           Baca selengkapnya →
        </a>
    </div>
</div>
