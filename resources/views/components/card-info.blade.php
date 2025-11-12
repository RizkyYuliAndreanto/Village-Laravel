@props([
    'title' => 'Judul Default',
    'summary' => 'Deskripsi singkat',
    'image' => asset('images/logo-placeholder.jpg'),
])

<div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md overflow-hidden flex flex-col hover:shadow-lg transition duration-300 w-full h-full">
    <img src="{{ $image }}" alt="{{ $title }}" class="w-full h-48 object-cover">
    
    <div class="p-5 flex flex-col flex-grow text-left">
        <h3 class="text-lg font-semibold text-gray-800 dark:text-white">{{ $title }}</h3>
        <p class="text-sm text-gray-600 dark:text-gray-400 mt-2 flex-grow">
            {{ $summary }}
        </p>
        <a href="#"
           class="text-indigo-600 text-sm mt-4 inline-block hover:underline">
           Baca selengkapnya →
        </a>
    </div>
</div>
