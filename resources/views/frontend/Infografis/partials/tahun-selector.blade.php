{{-- partials/tahun-selector.blade.php --}}
<div class="flex flex-col sm:flex-row items-center justify-center mb-6 gap-2">
    <label for="tahun-{{ $sectionId ?? 'default' }}" class="font-medium text-gray-700">Pilih Tahun:</label>
    <select 
        id="tahun-{{ $sectionId ?? 'default' }}" 
        class="tahun-selector form-select block w-full sm:w-32 rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-200 focus:ring-opacity-50 text-center sm:text-left"
        data-section="{{ $sectionId ?? '' }}"
    >
        @foreach($tahunTersedia as $t)
            @php
                $year = is_object($t) ? ($t->tahun ?? $t) : $t;
            @endphp

            <option value="{{ $year }}" {{ (string)($tahunAktif ?? '') === (string)$year ? 'selected' : '' }}>
                {{ $year }}
            </option>
        @endforeach
    </select>
</div>