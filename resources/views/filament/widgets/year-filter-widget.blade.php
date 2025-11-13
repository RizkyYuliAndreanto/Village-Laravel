<div class="fi-wi-year-filter">
    <div class="rounded-xl bg-white shadow-sm ring-1 ring-gray-950/5 dark:bg-gray-900 dark:ring-white/10">
        <div class="p-6">
            <div class="mb-4">
                <h3 class="text-base font-semibold leading-6 text-gray-900 dark:text-white">
                    Dashboard Validasi Populasi
                </h3>
                <p class="mt-1 text-sm text-gray-500 dark:text-gray-400">
                    Pilih tahun untuk melihat hasil validasi data statistik populasi
                </p>
            </div>

            <div class="mb-6">
                {{ $this->form }}
            </div>

            @if(isset($this->validationResults['error']))
                <div class="rounded-lg bg-red-50 p-4 dark:bg-red-900/20">
                    <div class="flex">
                        <div class="flex-shrink-0">
                            <x-heroicon-s-exclamation-triangle class="h-5 w-5 text-red-400" />
                        </div>
                        <div class="ml-3">
                            <h3 class="text-sm font-medium text-red-800 dark:text-red-200">
                                Data Tidak Tersedia
                            </h3>
                            <div class="mt-2 text-sm text-red-700 dark:text-red-300">
                                {{ $this->validationResults['error'] }}
                            </div>
                        </div>
                    </div>
                </div>
            @elseif(!empty($this->validationResults))
                <div class="space-y-4">
                    <!-- Summary Card -->
                    <div class="rounded-lg border border-gray-200 bg-gray-50 p-4 dark:border-gray-700 dark:bg-gray-800/50">
                        <div class="flex items-center justify-between">
                            <div>
                                <h4 class="text-lg font-medium text-gray-900 dark:text-white">
                                    Tahun {{ $this->validationResults['yearName'] }}
                                </h4>
                                <p class="text-sm text-gray-500 dark:text-gray-400">
                                    Total Populasi: {{ number_format($this->validationResults['totalPopulation']) }} jiwa
                                </p>
                            </div>
                            <div class="flex items-center">
                                @if($this->validationResults['allValid'])
                                    <span class="inline-flex items-center rounded-full bg-green-100 px-3 py-0.5 text-sm font-medium text-green-800 dark:bg-green-900/20 dark:text-green-400">
                                        <x-heroicon-s-check-circle class="-ml-1 mr-1.5 h-4 w-4" />
                                        Semua Valid
                                    </span>
                                @else
                                    <span class="inline-flex items-center rounded-full bg-red-100 px-3 py-0.5 text-sm font-medium text-red-800 dark:bg-red-900/20 dark:text-red-400">
                                        <x-heroicon-s-x-circle class="-ml-1 mr-1.5 h-4 w-4" />
                                        {{ $this->validationResults['totalInconsistencies'] }} Tidak Konsisten
                                    </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- Statistics Grid -->
                    <div class="grid grid-cols-1 gap-4 sm:grid-cols-2 lg:grid-cols-3">
                        @foreach($this->validationResults['statistics'] as $type => $stat)
                            <div class="rounded-lg border border-gray-200 bg-white p-4 dark:border-gray-700 dark:bg-gray-800">
                                <div class="flex items-center justify-between">
                                    <div class="flex-1">
                                        <h5 class="text-sm font-medium text-gray-900 dark:text-white">
                                            {{ $stat['name'] }}
                                        </h5>
                                        <p class="mt-1 text-lg font-semibold text-gray-900 dark:text-white">
                                            {{ number_format($stat['totalCount']) }}
                                        </p>
                                        @if(!$stat['isValid'])
                                            <p class="text-xs text-red-600 dark:text-red-400">
                                                Selisih: {{ number_format(abs($stat['difference'])) }}
                                            </p>
                                        @endif
                                    </div>
                                    <div class="flex-shrink-0">
                                        @if($stat['isValid'])
                                            <x-heroicon-s-check-circle class="h-5 w-5 text-green-500" />
                                        @else
                                            <x-heroicon-s-x-circle class="h-5 w-5 text-red-500" />
                                        @endif
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <div class="h-2 rounded-full bg-gray-200 dark:bg-gray-700">
                                        @php
                                            $percentage = $stat['expectedCount'] > 0 
                                                ? min(100, ($stat['totalCount'] / $stat['expectedCount']) * 100)
                                                : 0;
                                            $colorClass = $stat['isValid'] ? 'bg-green-500' : 'bg-red-500';
                                        @endphp
                                        <div 
                                            class="h-2 rounded-full {{ $colorClass }}" 
                                            style="width: {{ $percentage }}%"
                                        ></div>
                                    </div>
                                    <p class="mt-1 text-xs text-gray-500 dark:text-gray-400">
                                        {{ number_format($percentage, 1) }}% dari target populasi
                                    </p>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>
</div>