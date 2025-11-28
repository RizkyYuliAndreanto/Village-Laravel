<div>
    @if ($imageUrl)
        <div class="rounded-lg border border-gray-200 p-4">
            <img src="{{ $imageUrl }}" 
                 alt="{{ $alt }}" 
                 class="max-w-full h-auto max-h-48 rounded-lg shadow-sm">
            <p class="text-sm text-gray-500 mt-2">{{ basename($imageUrl) }}</p>
        </div>
    @else
        <div class="rounded-lg border border-gray-200 p-4 text-center text-gray-500">
            <svg class="w-12 h-12 mx-auto mb-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
            </svg>
            <p class="text-sm">Belum ada gambar</p>
        </div>
    @endif
</div>