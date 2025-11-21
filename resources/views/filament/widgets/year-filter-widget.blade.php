<x-filament-widgets::widget>
    <x-filament::section>
        <x-slot name="heading">
            Filter Tahun Data
        </x-slot>

        <div class="space-y-4">
            {{ $this->form }}
            
            @if($validationResults)
                <div class="mt-6">
                    <h3 class="text-lg font-semibold text-gray-900 mb-4">Hasil Validasi Data Tahun {{ $selectedYear ? \App\Models\TahunData::find($selectedYear)?->tahun : '' }}</h3>
                    
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
                        @foreach($validationResults as $category => $result)
                            <div class="bg-white rounded-lg border p-4">
                                <div class="flex items-center justify-between mb-2">
                                    <h4 class="font-medium text-gray-900 capitalize">{{ str_replace('_', ' ', $category) }}</h4>
                                    @if(is_array($result) && isset($result['isValid']) && $result['isValid'])
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-green-100 text-green-800">
                                            Valid
                                        </span>
                                    @elseif(is_array($result) && isset($result['isValid']) && !$result['isValid'])
                                        <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium bg-red-100 text-red-800">
                                            Invalid
                                        </span>
                                    @endif
                                </div>
                                
                                @if(is_array($result) && isset($result['errors']) && !empty($result['errors']))
                                    <ul class="text-sm text-red-600 space-y-1">
                                        @foreach($result['errors'] as $error)
                                            <li>• {{ $error }}</li>
                                        @endforeach
                                    </ul>
                                @else
                                    <p class="text-sm text-green-600">Data valid dan konsisten</p>
                                @endif
                                
                                @if(!empty($result['summary']))
                                    <div class="mt-2 text-xs text-gray-500">
                                        {{ $result['summary'] }}
                                    </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </x-filament::section>
</x-filament-widgets::widget>