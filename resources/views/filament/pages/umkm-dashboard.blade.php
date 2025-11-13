<x-filament-panels::page>
    <div class="grid grid-cols-1 gap-6">
        <!-- Header Info -->
        <div class="rounded-xl bg-gradient-to-r from-blue-500 to-indigo-600 p-6 text-white">
            <div class="flex items-center justify-between">
                <div>
                    <h1 class="text-2xl font-bold">Dashboard UMKM</h1>
                    <p class="mt-1 text-blue-100">
                        Pantau dan analisis perkembangan UMKM di village Anda
                    </p>
                </div>
                <div class="text-right">
                    <div class="text-3xl font-bold">
                        {{ \App\Models\Umkm::count() }}
                    </div>
                    <div class="text-blue-100">Total UMKM</div>
                </div>
            </div>
        </div>
        
        <!-- Widgets Container -->
        <div class="space-y-6">
            @foreach ($this->getWidgets() as $widget)
                @livewire($widget, key($widget))
            @endforeach
        </div>
        
        <!-- Footer Info -->
        <div class="rounded-lg border border-gray-200 bg-gray-50 p-4 dark:border-gray-700 dark:bg-gray-800">
            <div class="flex items-center justify-between text-sm text-gray-600 dark:text-gray-400">
                <div>
                    <span class="font-medium">Last Update:</span>
                    {{ now()->format('d M Y, H:i') }} WIB
                </div>
                <div class="flex items-center space-x-4">
                    <div>
                        <span class="font-medium">UMKM Aktif:</span>
                        {{ \App\Models\Umkm::where('status_usaha', 'aktif')->count() }}
                    </div>
                    <div>
                        <span class="font-medium">Total Omset:</span>
                        Rp {{ number_format(\App\Models\Umkm::where('status_usaha', 'aktif')->sum('omset_per_bulan'), 0, ',', '.') }}
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-filament-panels::page>