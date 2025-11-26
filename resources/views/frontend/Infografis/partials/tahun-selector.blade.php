{{-- partials/tahun-selector.blade.php --}}
<div class="flex items-center justify-center mb-6">
    <label for="tahun-{{ $sectionId ?? 'default' }}" class="mr-3 font-medium text-gray-700">Pilih Tahun:</label>
    <select 
        id="tahun-{{ $sectionId ?? 'default' }}" 
        class="tahun-selector form-select block w-32 rounded-md border-gray-300 shadow-sm focus:border-primary-500 focus:ring focus:ring-primary-200 focus:ring-opacity-50"
        data-section="{{ $sectionId ?? '' }}"
    >
        @foreach($tahunTersedia as $t)
            @php
                // jika $t object (model), ambil property ->tahun, jika int/string, pakai langsung
                $year = is_object($t) ? ($t->tahun ?? $t) : $t;
            @endphp

            <option value="{{ $year }}" {{ (string)($tahunAktif ?? '') === (string)$year ? 'selected' : '' }}>
                {{ $year }}
            </option>
        @endforeach
    </select>
</div>
