{{-- Section: Berdasarkan Dusun --}}
<section class="py-20 infografis-section">
    <div class="container mx-auto px-6">
        <h3 class="text-3xl font-extrabold mb-6 infografis-title">
            Berdasarkan Dusun 
            <span id="tahun-display-dusun" class="text-lg text-primary-600">
                ({{ $tahunAktif ?? date('Y') }})
            </span>
        </h3>

        {{-- Tahun Selector --}}
        @include('frontend.infografis.partials.tahun-selector', [
            'sectionId' => 'dusun',
            'tahunTersedia' => $tahunTersedia ?? [],
            'tahunAktif' => $tahunAktif ?? date('Y')
        ])

        <div id="dusun-content" class="grid lg:grid-cols-2 gap-8">
            
            {{-- Chart Section --}}
            <div class="infografis-card p-6 rounded-xl shadow">
                <h4 class="text-xl font-bold infografis-title mb-4 text-center">Distribusi Penduduk per Dusun</h4>
                <div class="relative h-80 flex items-center justify-center">
                    <canvas id="chartDusun" width="400" height="400"></canvas>
                </div>
            </div>

            {{-- Data Cards Section --}}
            <div class="space-y-4">
                <h4 class="text-xl font-bold infografis-title mb-4">Detail Statistik Dusun</h4>
                
                <div class="grid gap-4" id="dusun-cards">
                    @foreach($dusunStatistik as $index => $dusun)
                        <div class="infografis-card p-4 rounded-lg shadow-sm border-l-4" 
                             style="border-left-color: {{ $dusunChartConfig['colors'][$index] ?? '#3B82F6' }}">
                            <div class="flex justify-between items-center">
                                <div>
                                    <h5 class="text-lg font-semibold infografis-title">{{ strtoupper($dusun->nama_dusun) }}</h5>
                                    <p class="text-sm text-gray-600">{{ number_format($dusun->jumlah_kk) }} KK</p>
                                </div>
                                <div class="text-right">
                                    <div class="text-2xl font-bold text-primary-600" data-field="penduduk_{{ str_replace(' ', '_', strtolower($dusun->nama_dusun)) }}">
                                        {{ number_format($dusun->jumlah_penduduk) }}
                                    </div>
                                    <div class="text-sm text-gray-500">
                                        {{ $dusunChartConfig['percentages'][$index] ?? 0 }}%
                                    </div>
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Summary Card - Dinamis --}}
                <div class="infografis-card p-6 rounded-xl shadow bg-gradient-to-r from-primary-50 to-primary-100 border border-primary-200">
                    <div class="text-center">
                        <h5 class="text-lg font-semibold infografis-title mb-2">Total Keseluruhan</h5>
                        <div class="grid grid-cols-2 gap-4">
                            <div>
                                <div class="text-2xl font-bold text-primary-600" data-field="total_penduduk_dusun">
                                    {{ number_format($totalPendudukDusun ?? 0) }}
                                </div>
                                <div class="text-sm text-gray-600">Total Penduduk</div>
                            </div>
                            <div>
                                <div class="text-2xl font-bold text-primary-600" data-field="total_kk_dusun">
                                    {{ number_format($totalKKDusun ?? 0) }}
                                </div>
                                <div class="text-sm text-gray-600">Total KK</div>
                            </div>
                        </div>
                        <div class="text-xs text-gray-500 mt-3">
                            Data dari {{ count($dusunStatistik) }} dusun
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

@push('scripts')
<script>
    // Chart Dusun
    document.addEventListener('DOMContentLoaded', function() {
        console.log('Loading Dusun Chart...');
        
        if (typeof Chart === 'undefined') {
            console.error('Chart.js is not loaded!');
            return;
        }
        
        const chartElement = document.getElementById("chartDusun");
        if (chartElement) {
            console.log('Dusun chart element found, creating chart...');
            const dusun = chartElement.getContext("2d");

        // Data dari controller
        const dusunLabels = {!! json_encode($dusunChartConfig['labels'] ?? []) !!};
        const dusunDataValues = {!! json_encode($dusunChartConfig['data'] ?? []) !!};
        const dusunPercentages = {!! json_encode($dusunChartConfig['percentages'] ?? []) !!};
        
        // Color configuration
        const defaultColors = [
            'rgba(59, 130, 246, 0.8)',
            'rgba(34, 197, 94, 0.8)', 
            'rgba(251, 191, 36, 0.8)',
            'rgba(239, 68, 68, 0.8)'
        ];
        const defaultBorderColors = [
            'rgba(59, 130, 246, 1)',
            'rgba(34, 197, 94, 1)',
            'rgba(251, 191, 36, 1)', 
            'rgba(239, 68, 68, 1)'
        ];
        
        const dusunColors = {!! json_encode($dusunChartConfig['colors'] ?? ['#3B82F6', '#10B981', '#F59E0B', '#EF4444', '#8B5CF6']) !!};
        const dusunBorderColors = dusunColors;

        new Chart(dusun, {
            type: "doughnut",
            data: {
                labels: dusunLabels,
                datasets: [{
                    data: dusunDataValues,
                    backgroundColor: dusunColors,
                    borderColor: dusunBorderColors,
                    borderWidth: 2,
                    hoverBorderWidth: 3,
                    hoverBorderColor: '#ffffff'
                }]
            },
            options: {
                responsive: true,
                maintainAspectRatio: false,
                plugins: {
                    legend: {
                        position: 'bottom',
                        labels: {
                            padding: 20,
                            usePointStyle: true,
                            font: {
                                size: 12,
                                weight: '500'
                            }
                        }
                    },
                    tooltip: {
                        callbacks: {
                            label: function(context) {
                                const label = context.label || '';
                                const value = context.parsed || 0;
                                const percentage = dusunPercentages[context.dataIndex] || 0;
                                return `${label}: ${value.toLocaleString()} orang (${percentage}%)`;
                            }
                        },
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        titleColor: '#ffffff',
                        bodyColor: '#ffffff',
                        borderColor: '#ffffff',
                        borderWidth: 1
                    }
                },
                animation: {
                    animateScale: true,
                    animateRotate: true
                },
                cutout: '50%',
                layout: {
                    padding: 10
                }
            }
        });
        }
    });
</script>
@endpush