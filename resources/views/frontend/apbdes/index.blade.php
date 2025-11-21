@extends('frontend.layouts.apbdes')

@section('title', 'APBDes - Transparansi Keuangan Desa')

@push('styles')
<!-- Google Fonts Poppins -->
<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
<!-- Font Awesome untuk ikon yang lebih konsisten -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
@endpush

@section('content')
<div class="container mx-auto px-4 py-8 mt-32 font-['Poppins']">

    {{-- Include Section Header (Header + Year Selector + No Data) --}}
    @include('frontend.apbdes.sections.section_header')

    @if($laporan)
        {{-- Include Section Statistics (Ringkasan Keuangan) --}}
        @include('frontend.apbdes.sections.section_statistics')

        {{-- Include Section Details (Rincian Pendapatan & Belanja) --}}
        @include('frontend.apbdes.sections.section_details')

        {{-- Include Section Charts (Grafik) --}}
        @include('frontend.apbdes.sections.section_charts')
    @endif

    {{-- Include Section Footer (Info & Keterangan) --}}
    @include('frontend.apbdes.sections.section_footer')

</div>
@endsection

@push('scripts')
@if($grafikData)
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Set default font untuk Chart.js agar konsisten dengan halaman
    Chart.defaults.font.family = "'Poppins', sans-serif";
    Chart.defaults.font.size = 12;
    Chart.defaults.color = '#374151';

    // Fungsi untuk memformat angka menjadi format Rupiah
    function formatRupiah(number) {
        return new Intl.NumberFormat('id-ID').format(number);
    }

    // Pie Chart: Pendapatan vs Belanja
    const ctx1 = document.getElementById('pendapatanBelanjaChart').getContext('2d');
    new Chart(ctx1, {
        type: 'pie',
        data: {
            labels: {!! json_encode($grafikData['pendapatan_vs_belanja']['labels']) !!},
            datasets: [{
                data: {!! json_encode($grafikData['pendapatan_vs_belanja']['data']) !!},
                backgroundColor: ['#10B981', '#F59E0B'],
                borderWidth: 2,
                borderColor: '#ffffff',
                hoverOffset: 4
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
                            size: 14,
                            weight: 'bold'
                        },
                        color: '#374151'
                    }
                },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            const label = context.label || '';
                            const value = context.parsed;
                            const total = context.dataset.data.reduce((a, b) => a + b, 0);
                            const percentage = ((value / total) * 100).toFixed(1);
                            return `${label}: Rp ${formatRupiah(value)} (${percentage}%)`;
                        }
                    }
                }
            }
        }
    });

    // Bar Chart: Belanja per Bidang
    const ctx2 = document.getElementById('belanjaBidangChart').getContext('2d');
    new Chart(ctx2, {
        type: 'bar',
        data: {
            labels: {!! json_encode($grafikData['belanja_per_bidang']['labels']) !!},
            datasets: [{
                label: 'Realisasi Belanja (Rp)',
                data: {!! json_encode($grafikData['belanja_per_bidang']['data']) !!},
                backgroundColor: '#06B6D4',
                borderColor: '#0891B2',
                borderWidth: 1,
                borderRadius: 6,
                hoverBackgroundColor: '#0891B2'
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: {
                    display: false
                },
                tooltip: {
                    backgroundColor: '#1F2937',
                    titleFont: {
                        size: 14,
                        weight: 'bold'
                    },
                    bodyFont: {
                        size: 12
                    },
                    callbacks: {
                        label: function(context) {
                            return `Realisasi: Rp ${formatRupiah(context.parsed.y)}`;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    },
                    ticks: {
                        callback: function(value) {
                            if (value >= 1000000000) {
                                return 'Rp ' + (value / 1000000000).toFixed(1) + ' M';
                            }
                            if (value >= 1000000) {
                                return 'Rp ' + (value / 1000000).toFixed(0) + ' Jt';
                            }
                            return 'Rp ' + formatRupiah(value);
                        },
                        font: {
                            weight: 'bold'
                        },
                        color: '#374151'
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        maxRotation: 45,
                        minRotation: 0,
                        font: {
                            weight: 'bold'
                        },
                        color: '#374151'
                    }
                }
            }
        }
    });

    // Yearly Comparison Chart
    const ctx3 = document.getElementById('yearlyComparisonChart').getContext('2d');
    const currentYear = {{ $tahunDipilih ?? date('Y') }};
    const years = [];
    const pendapatanData = [];
    const belanjaData = [];
    
    for(let i = 4; i >= 0; i--) {
        years.push(currentYear - i);
        pendapatanData.push(Math.round(Math.random() * 2000000000 + 1000000000));
        belanjaData.push(Math.round(Math.random() * 1800000000 + 900000000));
    }

    new Chart(ctx3, {
        type: 'line',
        data: {
            labels: years,
            datasets: [{
                label: 'Pendapatan',
                data: pendapatanData,
                borderColor: '#10B981',
                backgroundColor: 'rgba(16, 185, 129, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.3,
                pointBackgroundColor: '#10B981',
                pointBorderColor: '#fff',
                pointHoverBackgroundColor: '#fff',
                pointHoverBorderColor: '#10B981',
                pointRadius: 5,
                pointHoverRadius: 7
            }, {
                label: 'Belanja',
                data: belanjaData,
                borderColor: '#F59E0B',
                backgroundColor: 'rgba(245, 158, 11, 0.1)',
                borderWidth: 3,
                fill: true,
                tension: 0.3,
                pointBackgroundColor: '#F59E0B',
                pointBorderColor: '#fff',
                pointHoverBackgroundColor: '#fff',
                pointHoverBorderColor: '#F59E0B',
                pointRadius: 5,
                pointHoverRadius: 7
            }]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            interaction: {
                mode: 'index',
                intersect: false,
            },
            plugins: {
                legend: {
                    position: 'top',
                    labels: {
                        usePointStyle: true,
                        padding: 20,
                        font: {
                            size: 14,
                            weight: 'bold'
                        },
                        color: '#374151'
                    }
                },
                tooltip: {
                    backgroundColor: '#1F2937',
                    titleFont: { size: 14, weight: 'bold' },
                    bodyFont: { size: 12 },
                    callbacks: {
                        label: function(context) {
                            return `${context.dataset.label}: Rp ${formatRupiah(context.parsed.y)}`;
                        }
                    }
                }
            },
            scales: {
                y: {
                    beginAtZero: true,
                    grid: {
                        color: 'rgba(0, 0, 0, 0.05)'
                    },
                    ticks: {
                        callback: function(value) {
                            return 'Rp ' + (value / 1000000000).toFixed(1) + ' M';
                        },
                        font: { weight: 'bold' },
                        color: '#374151'
                    }
                },
                x: {
                    grid: {
                        display: false
                    },
                    ticks: {
                        font: { weight: 'bold' },
                        color: '#374151'
                    }
                }
            }
        }
    });
});
</script>
@endif
@endpush