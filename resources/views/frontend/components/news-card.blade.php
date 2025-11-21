@props([
    'image' => asset('images/logo-placeholder.jpg'), //
    'title' => 'Judul Berita Default',
    'summary' => 'Ringkasan singkat...',
    'url' => '#'
])

<div class="card-bg card-shadow rounded-xl overflow-hidden flex flex-col w-60 h-full card-hover">
    
    <img src="{{ $image }}" alt="{{ $title }}" class="w-full h-40 object-cover">
    
    <div class="p-4 text-left flex flex-col flex-grow">
        <h3 class="font-semibold text-gray-800 dark:text-white">{{ $title }}</h3>
        <p class="text-sm text-gray-600 dark:text-gray-400 mt-2 flex-grow">
            {{ $summary }}
        </p>
        
        <a href="{{ $url }}" class="text-indigo-600 text-sm mt-4 inline-block hover:underline">
            Baca selengkapnya →
        </a>
    </div>
</div>