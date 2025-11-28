@props([
    'title' => 'Judul Default',
    'summary' => 'Deskripsi singkat',
    'image' => asset('images/logo-placeholder.jpg'),
])

<div class="bg-white dark:bg-gray-800 rounded-2xl shadow-md overflow-hidden flex flex-col hover:shadow-lg transition duration-300 w-full h-80">
    <!-- Foto lebih besar -->
    <div class="h-48 bg-gray-100 overflow-hidden">
        <img src="{{ $image }}" alt="{{ $title }}" class="w-full h-full object-cover">
    </div>
    
    <!-- Content area yang lebih compact -->
    <div class="p-4 flex flex-col justify-center text-center bg-gradient-to-b from-slate-50 to-white">
        <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-1">{{ $title }}</h3>
        <p class="text-sm font-medium text-indigo-600 dark:text-indigo-400">
            {{ $summary }}
        </p>
    </div>
</div>
