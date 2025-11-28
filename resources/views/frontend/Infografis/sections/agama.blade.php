{{-- Section: Berdasarkan Agama --}}
<section class="py-8 sm:py-12 lg:py-20 infografis-section">
    <div class="container mx-auto px-4 sm:px-6">
        <div class="text-center mb-4 sm:mb-6 lg:mb-8">
            <h3 class="text-xl sm:text-2xl lg:text-3xl font-extrabold mb-3 sm:mb-4 lg:mb-6 infografis-title">
                Berdasarkan Agama 
                <span id="tahun-display-agama" class="text-sm sm:text-base lg:text-lg text-primary-600 block sm:inline">
                    ({{ $tahunAktif ?? date('Y') }})
                </span>
            </h3>
        </div>

      
        <div id="agama-content" class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4 sm:gap-6 lg:gap-8">

            <div class="infografis-card p-4 sm:p-6 lg:p-8 rounded-lg shadow">
                <div class="flex items-center gap-3 sm:gap-4 lg:gap-6">
                    <div class="flex-shrink-0">
                        <img src="{{ asset('images/infografis/icon-islam-CvTs3lrK.svg') }}" class="w-10 h-10 sm:w-12 sm:h-12 lg:w-16 lg:h-16" alt="Icon">
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="text-lg sm:text-xl lg:text-3xl font-bold text-primary-600 truncate" data-field="islam">{{ $islam ?? 0 }}</div>
                        <div class="text-sm sm:text-base lg:text-lg text-gray-600 truncate">Islam</div>
                    </div>
                </div>
            </div>

            <div class="infografis-card p-4 sm:p-6 lg:p-8 rounded-lg shadow">
                <div class="flex items-center gap-3 sm:gap-4 lg:gap-6">
                    <div class="flex-shrink-0">
                        <img src="{{ asset('images/infografis/icon-katolik-Bh6D2yYr.svg') }}" class="w-10 h-10 sm:w-12 sm:h-12 lg:w-16 lg:h-16" alt="Icon">
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="text-lg sm:text-xl lg:text-3xl font-bold text-primary-600 truncate">{{ $katolik ?? 0 }}</div>
                        <div class="text-sm sm:text-base lg:text-lg text-gray-600 truncate">Katolik</div>
                    </div>
                </div>
            </div>

            <div class="infografis-card p-4 sm:p-6 lg:p-8 rounded-lg shadow">
                <div class="flex items-center gap-3 sm:gap-4 lg:gap-6">
                    <div class="flex-shrink-0">
                        <img src="{{ asset('images/infografis/icon-kristen-DnmWrutu.svg') }}" class="w-10 h-10 sm:w-12 sm:h-12 lg:w-16 lg:h-16" alt="Icon">
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="text-lg sm:text-xl lg:text-3xl font-bold text-primary-600 truncate">{{ $kristen ?? 0 }}</div>
                        <div class="text-sm sm:text-base lg:text-lg text-gray-600 truncate">Kristen</div>
                    </div>
                </div>
            </div>

            <div class="infografis-card p-4 sm:p-6 lg:p-8 rounded-lg shadow">
                <div class="flex items-center gap-3 sm:gap-4 lg:gap-6">
                    <div class="flex-shrink-0">
                        <img src="{{ asset('images/infografis/icon-hindu-O6CRjU7v.svg') }}" class="w-10 h-10 sm:w-12 sm:h-12 lg:w-16 lg:h-16" alt="Icon">
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="text-lg sm:text-xl lg:text-3xl font-bold text-primary-600 truncate">{{ $hindu ?? 0 }}</div>
                        <div class="text-sm sm:text-base lg:text-lg text-gray-600 truncate">Hindu</div>
                    </div>
                </div>
            </div>

            <div class="infografis-card p-4 sm:p-6 lg:p-8 rounded-lg shadow">
                <div class="flex items-center gap-3 sm:gap-4 lg:gap-6">
                    <div class="flex-shrink-0">
                        <img src="{{ asset('images/infografis/icon-buddha-4LzubUEG.svg') }}" class="w-10 h-10 sm:w-12 sm:h-12 lg:w-16 lg:h-16" alt="Icon">
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="text-lg sm:text-xl lg:text-3xl font-bold text-primary-600 truncate">{{ $buddha ?? 0 }}</div>
                        <div class="text-sm sm:text-base lg:text-lg text-gray-600 truncate">Buddha</div>
                    </div>
                </div>
            </div>

            <div class="infografis-card p-4 sm:p-6 lg:p-8 rounded-lg shadow">
                <div class="flex items-center gap-3 sm:gap-4 lg:gap-6">
                    <div class="flex-shrink-0">
                        <img src="{{ asset('images/infografis/icon-konghuchu-S2zKN_1w.svg') }}" class="w-10 h-10 sm:w-12 sm:h-12 lg:w-16 lg:h-16" alt="Icon">
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="text-lg sm:text-xl lg:text-3xl font-bold text-primary-600 truncate">{{ $konghucu ?? 0 }}</div>
                        <div class="text-sm sm:text-base lg:text-lg text-gray-600 truncate">Konghucu</div>
                    </div>
                </div>
            </div>

            <div class="infografis-card p-4 sm:p-6 lg:p-8 rounded-lg shadow">
                <div class="flex items-center gap-3 sm:gap-4 lg:gap-6">
                    <div class="flex-shrink-0">
                        <img src="{{ asset('images/infografis/icon-kepercayaan-lainnya-CtFL_S6_.svg') }}" class="w-10 h-10 sm:w-12 sm:h-12 lg:w-16 lg:h-16" alt="Icon">
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="text-lg sm:text-xl lg:text-3xl font-bold text-primary-600 truncate">{{ $kepercayaan_lain ?? 0 }}</div>
                        <div class="text-sm sm:text-base lg:text-lg text-gray-600 truncate">Kepercayaan Lainnya</div>
                    </div>
                </div>
            </div>

        </div>
    </div>
</section>