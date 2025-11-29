{{-- File: resources/views/frontend/Infografis/sections/agama.blade.php --}}
<section class="py-10 lg:py-20 infografis-section bg-gray-50 border-b border-gray-200">
    <div class="container mx-auto px-4"> {{-- Gunakan px-4 untuk mobile --}}
        
        {{-- Judul & Selector --}}
        <div class="flex flex-col items-center mb-8 text-center">
            <h3 class="text-2xl lg:text-3xl font-bold infografis-title text-gray-800 mb-2">
                Berdasarkan Agama
            </h3>
            <span id="tahun-display-agama" class="text-primary-600 font-medium mb-4">
                Tahun {{ $tahunAktif ?? date('Y') }}
            </span>
        </div>

        {{-- Konten Utama --}}
        <div class="flex flex-col lg:grid lg:grid-cols-3 gap-8">
            
            {{-- 1. BAGIAN CHART (Perbaikan Fatal Disini) --}}
            <div class="infografis-card bg-white p-4 rounded-xl shadow-sm border border-gray-100 w-full order-1 lg:order-1">
                {{-- Wajib ada div pembungkus dengan relative & height fix --}}
                <div class="relative h-[300px] w-full flex items-center justify-center">
                    <canvas id="chartAgama"></canvas>
                </div>
            </div>

            {{-- 2. BAGIAN DATA ANGKA --}}
            <div id="agama-content" class="order-2 lg:order-2 col-span-2 grid grid-cols-2 sm:grid-cols-3 gap-3">
                {{-- Item Data --}}
                <div class="infografis-card p-3 rounded-lg shadow-sm bg-white border border-gray-100 flex flex-col items-center justify-center">
                    <span class="text-xs text-gray-500 uppercase font-semibold tracking-wider">Islam</span>
                    <span class="text-xl lg:text-2xl font-bold text-primary-600 mt-1">{{ $agama->islam ?? 0 }}</span>
                </div>
                <div class="infografis-card p-3 rounded-lg shadow-sm bg-white border border-gray-100 flex flex-col items-center justify-center">
                    <span class="text-xs text-gray-500 uppercase font-semibold tracking-wider">Katolik</span>
                    <span class="text-xl lg:text-2xl font-bold text-primary-600 mt-1">{{ $agama->katolik ?? 0 }}</span>
                </div>
                <div class="infografis-card p-3 rounded-lg shadow-sm bg-white border border-gray-100 flex flex-col items-center justify-center">
                    <span class="text-xs text-gray-500 uppercase font-semibold tracking-wider">Kristen</span>
                    <span class="text-xl lg:text-2xl font-bold text-primary-600 mt-1">{{ $agama->kristen ?? 0 }}</span>
                </div>
                <div class="infografis-card p-3 rounded-lg shadow-sm bg-white border border-gray-100 flex flex-col items-center justify-center">
                    <span class="text-xs text-gray-500 uppercase font-semibold tracking-wider">Hindu</span>
                    <span class="text-xl lg:text-2xl font-bold text-primary-600 mt-1">{{ $agama->hindu ?? 0 }}</span>
                </div>
                <div class="infografis-card p-3 rounded-lg shadow-sm bg-white border border-gray-100 flex flex-col items-center justify-center">
                    <span class="text-xs text-gray-500 uppercase font-semibold tracking-wider">Buddha</span>
                    <span class="text-xl lg:text-2xl font-bold text-primary-600 mt-1">{{ $agama->buddha ?? 0 }}</span>
                </div>
                <div class="infografis-card p-3 rounded-lg shadow-sm bg-white border border-gray-100 flex flex-col items-center justify-center">
                    <span class="text-xs text-gray-500 uppercase font-semibold tracking-wider">Konghucu</span>
                    <span class="text-xl lg:text-2xl font-bold text-primary-600 mt-1">{{ $agama->konghucu ?? 0 }}</span>
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
    document.addEventListener("DOMContentLoaded", function() {
        if (document.getElementById("chartAgama")) {
            const ctx = document.getElementById("chartAgama").getContext("2d");
            window.infografisCharts = window.infografisCharts || {};

            const agamaData = {
                'Islam': {{ $agama->islam ?? 0 }},
                'Katolik': {{ $agama->katolik ?? 0 }},
                'Kristen': {{ $agama->kristen ?? 0 }},
                'Hindu': {{ $agama->hindu ?? 0 }},
                'Buddha': {{ $agama->buddha ?? 0 }},
                'Konghucu': {{ $agama->konghucu ?? 0 }},
                'Lainnya': {{ $agama->kepercayaan_lain ?? 0 }}
            };

            const labels = Object.keys(agamaData).filter(key => agamaData[key] > 0);
            const data = labels.map(key => agamaData[key]);

            window.infografisCharts['agama'] = new Chart(ctx, {
                type: 'doughnut',
                data: {
                    labels: labels,
                    datasets: [{
                        data: data,
                        backgroundColor: ['#10B981', '#3B82F6', '#F59E0B', '#EF4444', '#8B5CF6', '#6366F1', '#64748B'],
                        borderWidth: 0
                    }]
                },
                options: {
                    responsive: true,
                    maintainAspectRatio: false, // WAJIB FALSE AGAR TIDAK MELEBAR
                    plugins: {
                        legend: { 
                            position: 'bottom',
                            labels: {
                                padding: 20,
                                boxWidth: 10,
                                font: { size: 11 }
                            }
                        }
                    },
                    layout: {
                        padding: 10
                    }
                }
            });
        }
    });
</script>
@endpush