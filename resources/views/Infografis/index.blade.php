@extends('layouts.infografis')

@section('content')
<!-- ===== Hero ===== -->
<section class="min-h-screen flex flex-col bg-gray-100 dark:bg-gray-900 py-16">
  <!-- Submenu -->
  <div class="flex justify-end mb-6">
    @include('layouts.partials.submenu')
  </div>

  <!-- Konten Utama -->
  <div class="container mx-auto px-6 flex flex-col lg:flex-row items-center justify-between gap-12">

    <!-- Teks -->
    <div class="max-w-xl text-center lg:text-left">
      <h3 class="text-3xl font-extrabold mb-4 text-gray-900 dark:text-white">
        DEMOGRAFI PENDUDUK
      </h3>
      <p class="text-gray-700 dark:text-gray-300 leading-relaxed text-justify">
        Melalui website ini Anda dapat menjelajahi segala hal yang terkait dengan Desa.
        Pemerintahan, penduduk, demografi, potensi Desa, dan juga berita tentang Desa.
      </p>
    </div>

    <!-- Gambar -->
    <div class="flex-shrink-0">
      <img
        class="rounded-2xl shadow-lg max-w-sm w-full object-cover"
        src="{{ asset('images/logo-placeholder.jpg') }}"
        alt="Logo Desa">
    </div>

  </div>
</section>

<!-- ===== Jumlah Penduduk ===== -->
<section class="min-h-screen flex items-center bg-gray-100 dark:bg-gray-900 py-20">
  <div class="container mx-auto px-6 flex flex-col items-center gap-10">

    <div class="text-center max-w-2xl">
      <h3 class="text-4xl font-extrabold mb-4 text-gray-900 dark:text-white">Statistik Demografi Penduduk</h3>
      <p class="text-gray-700 dark:text-gray-300 leading-relaxed">
        Berikut merupakan data terbaru demografi penduduk Desa Ngengor untuk tahun 
        <span class="font-semibold text-blue-600 dark:text-blue-400">
          {{ $tahunDataTerbaru->tahun ?? '-' }}
        </span>.
      </p>
    </div>

    <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-5 gap-6 mt-8">
      <x-stat-box :value="$totalPenduduk" label="Penduduk" />
      <x-stat-box :value="$totalLaki" label="Laki-laki" />
      <x-stat-box :value="$totalPerempuan" label="Perempuan" />
      <x-stat-box :value="$pendudukSementara" label="Penduduk Sementara" />
      <x-stat-box :value="$mutasiPenduduk" label="Mutasi Penduduk" />
    </div>
  </div>
</section>

<!-- ===== umur penduduk ===== -->
<section class="min-h-screen flex flex-col justify-center pb-10 bg-gray-100 dark:bg-gray-900">
  <div class="container mx-auto px-6 flex flex-col gap-8">

    <!-- Judul & Deskripsi -->
    <div class="text-left">
      <h3 class="text-3xl font-extrabold mb-3 text-gray-900 dark:text-white">
        Berdasarkan Kelompok Umur
      </h3>
      <p class="text-gray-700 dark:text-gray-300 max-w-2xl">
        Jumlah penduduk laki-laki dan perempuan berdasarkan kelompok umur.
      </p>
    </div>

    <!-- Chart Piramida Penduduk -->
    <div class="w-full bg-white dark:bg-gray-800 p-6 rounded-2xl shadow-md">
      <div class="h-[500px]">
        <canvas id="piramidaPenduduk"></canvas>
      </div>
    </div>

  </div>
  <!-- Deskripsi Data -->
  <div class="container mx-auto px-6 mt-10 space-y-6">
    <!-- Laki-laki -->
    <div class="bg-white dark:bg-gray-800 border-t-4 border-green-400 p-6 rounded-xl shadow-md">
      <p class="text-gray-700 dark:text-gray-300">
        Untuk jenis kelamin <span class="font-semibold">laki-laki</span>, kelompok umur 
        <span class="font-bold text-gray-900 dark:text-white">25–29</span> adalah kelompok umur tertinggi 
        dengan jumlah <span class="font-bold text-gray-900 dark:text-white">99 orang</span> atau 
        <span class="font-bold text-gray-900 dark:text-white">10.65%</span>. 
        Sedangkan, kelompok umur <span class="font-bold text-gray-900 dark:text-white">0–4</span> adalah yang terendah 
        dengan jumlah <span class="font-bold text-gray-900 dark:text-white">3 orang</span> atau 
        <span class="font-bold text-gray-900 dark:text-white">0.32%</span>.
      </p>
    </div>

    <!-- Perempuan -->
    <div class="bg-white dark:bg-gray-800 border-t-4 border-pink-400 p-6 rounded-xl shadow-md">
      <p class="text-gray-700 dark:text-gray-300">
        Untuk jenis kelamin <span class="font-semibold">perempuan</span>, kelompok umur 
        <span class="font-bold text-gray-900 dark:text-white">25–29</span> adalah kelompok umur tertinggi 
        dengan jumlah <span class="font-bold text-gray-900 dark:text-white">112 orang</span> atau 
        <span class="font-bold text-gray-900 dark:text-white">11.67%</span>. 
        Sedangkan, kelompok umur 
        <span class="font-bold text-gray-900 dark:text-white">85+ dan 80–84 tahun</span> adalah yang terendah 
        dengan masing-masing berjumlah <span class="font-bold text-gray-900 dark:text-white">8 orang</span> atau 
        <span class="font-bold text-gray-900 dark:text-white">0.83%</span>.
      </p>
    </div>
  </div>
</section>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
// @ts-nocheck  // (opsional untuk hilangkan VS Code warning)
const ctx = document.getElementById('piramidaPenduduk');

const labels = [
  '0-4', '5-9', '10-14', '15-19', '20-24',
  '25-29', '30-34', '35-39', '40-44', '45-49', '50+'
];

const dataLaki = [
  -{{ $umurData->umur_0_4 ?? 0 }},
  -{{ $umurData->umur_5_9 ?? 0 }},
  -{{ $umurData->umur_10_14 ?? 0 }},
  -{{ $umurData->umur_15_19 ?? 0 }},
  -{{ $umurData->umur_20_24 ?? 0 }},
  -{{ $umurData->umur_25_29 ?? 0 }},
  -{{ $umurData->umur_30_34 ?? 0 }},
  -{{ $umurData->umur_35_39 ?? 0 }},
  -{{ $umurData->umur_40_44 ?? 0 }},
  -{{ $umurData->umur_45_49 ?? 0 }},
  -{{ $umurData->umur_50_plus ?? 0 }}
];

const dataPerempuan = [
  {{ $umurData->umur_0_4 ?? 0 }},
  {{ $umurData->umur_5_9 ?? 0 }},
  {{ $umurData->umur_10_14 ?? 0 }},
  {{ $umurData->umur_15_19 ?? 0 }},
  {{ $umurData->umur_20_24 ?? 0 }},
  {{ $umurData->umur_25_29 ?? 0 }},
  {{ $umurData->umur_30_34 ?? 0 }},
  {{ $umurData->umur_35_39 ?? 0 }},
  {{ $umurData->umur_40_44 ?? 0 }},
  {{ $umurData->umur_45_49 ?? 0 }},
  {{ $umurData->umur_50_plus ?? 0 }}
];

new Chart(ctx, {
  type: 'bar',
  data: {
    labels: labels,
    datasets: [
      {
        label: 'Laki-Laki',
        data: dataLaki,
        backgroundColor: 'rgba(56, 161, 105, 0.8)',
      },
      {
        label: 'Perempuan',
        data: dataPerempuan,
        backgroundColor: 'rgba(244, 114, 182, 0.8)',
      }
    ]
  },
  options: {
    indexAxis: 'y',
    responsive: true,
    maintainAspectRatio: false,
    scales: {
      x: {
        stacked: true,
        ticks: {
          callback: value => Math.abs(value)
        }
      },
      y: {
        stacked: true
      }
    },
    plugins: {
      tooltip: {
        callbacks: {
          label: ctx => `${ctx.dataset.label}: ${Math.abs(ctx.raw)}`
        }
      },
      legend: {
        position: 'top'
      }
    }
  }
});
</script>


<!-- ===== Peta Lokasi ===== -->
<section class="min-h-screen flex items-center pb-10 bg-gray-100 dark:bg-gray-900 border border-red">
  <div class="container mx-auto px-6 flex flex-col lg:flex-row items-center justify-between gap-10 border border-red">
    <div class="flex-shrink-0">
      <img class="rounded-lg shadow-md max-w-sm"
        src="{{ asset('images/logo-placeholder.jpg') }}"
        alt="Logo Desa">
    </div>
    <div class="max-w-xl">
      <h3 class="text-2xl font-bold mb-4 text-gray-800 dark:text-gray-100">JELAJAHI DESA</h3>
      <p class="text-gray-700 dark:text-gray-300 leading-relaxed text-justify">
        Melalui website ini Anda dapat menjelajahi segala hal yang terkait dengan Desa.<br>
        Pemerintahan, penduduk, demografi, potensi Desa, dan juga berita tentang Desa.
      </p>
    </div>
  </div>
</section>
@endsection