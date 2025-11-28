{{-- Partial: Tahun Selector --}}
<div class="flex flex-col sm:flex-row items-start sm:items-center gap-2 sm:gap-3 mb-4 sm:mb-6">
    <label for="tahunSelector-{{ $sectionId }}" class="text-sm font-medium text-gray-700 dark:text-gray-300 whitespace-nowrap">
        Pilih Tahun Data:
    </label>
    <div class="flex items-center gap-2 w-full sm:w-auto">
        <select id="tahunSelector-{{ $sectionId }}" 
                class="tahun-selector px-3 py-2 border border-gray-300 dark:border-gray-600 rounded-md text-sm 
                       bg-white dark:bg-gray-700 text-gray-900 dark:text-white focus:ring-2 focus:ring-blue-500
                       w-full sm:w-auto min-w-[120px]"
                data-section="{{ $sectionId }}">
            @if(isset($tahunTersedia) && count($tahunTersedia) > 0)
                @foreach($tahunTersedia as $tahunData)
                    <option value="{{ $tahunData->tahun }}" {{ ($tahunData->tahun == ($tahunAktif ?? date('Y'))) ? 'selected' : '' }}>
                        {{ $tahunData->tahun }}
                    </option>
                @endforeach
            @else
                <option value="{{ $tahunAktif ?? date('Y') }}" selected>
                    {{ $tahunAktif ?? date('Y') }}
                </option>
            @endif
        </select>
        <div id="loading-{{ $sectionId }}" class="hidden">
            <svg class="animate-spin h-4 w-4 text-blue-500" fill="none" viewBox="0 0 24 24">
                <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
            </svg>
        </div>
    </div>
</div>