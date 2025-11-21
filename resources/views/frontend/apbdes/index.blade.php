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
<script>
document.addEventListener('DOMContentLoaded', function() {
    // Pastikan Chart.js sudah dimuat
    if (typeof Chart === 'undefined') {
        console.error('Chart.js tidak dimuat');
        return;
    }
    
    // Set default font untuk Chart.js
    Chart.defaults.font.family = "'Poppins', sans-serif";
    Chart.defaults.font.size = 12;
    Chart.defaults.color = '#374151';

    // Fungsi untuk memformat angka
    function formatRupiah(number) {
        return new Intl.NumberFormat('id-ID').format(number);
    }

    // Pie Chart: Pendapatan vs Belanja
    const pieCanvas = document.getElementById('pendapatanBelanjaChart');
    if (pieCanvas) {
        const ctx1 = pieCanvas.getContext('2d');
        new Chart(ctx1, {
            type: 'pie',
            data: {
                labels: {!! json_encode($grafikData['pendapatan_vs_belanja']['labels']) !!},
                datasets: [{
                    data: {!! json_encode($grafikData['pendapatan_vs_belanja']['data']) !!},
                    backgroundColor: ['#10B981', '#F59E0B'],
                    borderWidth: 3,
                    borderColor: '#ffffff',
                    hoverBorderWidth: 5,
                    hoverOffset: 8
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
                            }
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        titleColor: '#ffffff',
                        bodyColor: '#ffffff',
                        borderColor: '#ffffff',
                        borderWidth: 1,
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
        console.log('Pie chart berhasil dibuat');
    }

    // Bar Chart: Belanja per Bidang
    const barCanvas = document.getElementById('belanjaBidangChart');
    if (barCanvas) {
        const ctx2 = barCanvas.getContext('2d');
        new Chart(ctx2, {
            type: 'bar',
            data: {
                labels: {!! json_encode($grafikData['belanja_per_bidang']['labels']) !!},
                datasets: [{
                    label: 'Realisasi Belanja (Rp)',
                    data: {!! json_encode($grafikData['belanja_per_bidang']['data']) !!},
                    backgroundColor: '#06B6D4',
                    borderColor: '#0891B2',
                    borderWidth: 2,
                    borderRadius: 8,
                    hoverBackgroundColor: '#0891B2',
                    hoverBorderWidth: 3
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
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        titleColor: '#ffffff',
                        bodyColor: '#ffffff',
                        borderColor: '#ffffff',
                        borderWidth: 1,
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
                            color: 'rgba(0, 0, 0, 0.05)',
                            drawBorder: false
                        },
                        border: {
                            display: false
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
                                size: 11,
                                weight: 'bold'
                            },
                            color: '#6B7280'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        border: {
                            display: false
                        },
                        ticks: {
                            maxRotation: 45,
                            minRotation: 0,
                            font: {
                                size: 11,
                                weight: 'bold'
                            },
                            color: '#374151'
                        }
                    }
                }
            }
        });
        console.log('Bar chart berhasil dibuat');
    }
    });

    // Yearly Comparison Chart
    const lineCanvas = document.getElementById('yearlyComparisonChart');
    if (lineCanvas) {
        const ctx3 = lineCanvas.getContext('2d');
        const currentYear = {{ $tahunDipilih ?? date('Y') }};
        const years = [];
        const pendapatanData = [];
        const belanjaData = [];
        
        // Generate data untuk 5 tahun terakhir
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
                    tension: 0.4,
                    pointBackgroundColor: '#10B981',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 3,
                    pointHoverBackgroundColor: '#ffffff',
                    pointHoverBorderColor: '#10B981',
                    pointHoverBorderWidth: 3,
                    pointRadius: 6,
                    pointHoverRadius: 8
                }, {
                    label: 'Belanja',
                    data: belanjaData,
                    borderColor: '#F59E0B',
                    backgroundColor: 'rgba(245, 158, 11, 0.1)',
                    borderWidth: 3,
                    fill: true,
                    tension: 0.4,
                    pointBackgroundColor: '#F59E0B',
                    pointBorderColor: '#ffffff',
                    pointBorderWidth: 3,
                    pointHoverBackgroundColor: '#ffffff',
                    pointHoverBorderColor: '#F59E0B',
                    pointHoverBorderWidth: 3,
                    pointRadius: 6,
                    pointHoverRadius: 8
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
                            }
                        }
                    },
                    tooltip: {
                        backgroundColor: 'rgba(0, 0, 0, 0.8)',
                        titleColor: '#ffffff',
                        bodyColor: '#ffffff',
                        borderColor: '#ffffff',
                        borderWidth: 1,
                        titleFont: { 
                            size: 14, 
                            weight: 'bold' 
                        },
                        bodyFont: { 
                            size: 12 
                        },
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
                            color: 'rgba(0, 0, 0, 0.05)',
                            drawBorder: false
                        },
                        border: {
                            display: false
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
                                size: 11,
                                weight: 'bold' 
                            },
                            color: '#6B7280'
                        }
                    },
                    x: {
                        grid: {
                            display: false
                        },
                        border: {
                            display: false
                        },
                        ticks: {
                            font: { 
                                size: 11,
                                weight: 'bold' 
                            },
                            color: '#374151'
                        }
                    }
                }
            }
        });
        console.log('Line chart berhasil dibuat');
    }
    
    console.log('Semua chart APBDes berhasil diinisialisasi');
});
</script>
@endif
@endpush