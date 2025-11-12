@extends('layouts.main')

@section('content')

<!-- ===== HERO SECTION ===== -->
<section class="min-h-screen flex items-center justify-center bg-indigo-600 dark:bg-indigo-800 py-20">
  <div class="container mx-auto px-6 text-center">
    <h1 class="text-5xl font-extrabold text-white mb-4">
      Selamat Datang di <span class="text-yellow-300">VillageLaravel</span>
    </h1>
    <p class="text-lg text-indigo-100 mb-8">
      Solusi manajemen data desa berbasis Laravel 12.
    </p>
    <a href="{{ route('register') }}"
      class="bg-white text-indigo-700 font-bold py-3 px-6 rounded-lg shadow-md hover:bg-gray-100 transition">
      Mulai Sekarang
    </a>
  </div>
</section>

<!-- ===== PROFIL DESA ===== -->
<section class="min-h-screen flex items-center bg-white dark:bg-gray-900 py-20">
  <div class="container mx-auto px-6 flex flex-col lg:flex-row items-center justify-between gap-10">
    <div class="flex-shrink-0">
      <img class="rounded-lg shadow-md max-w-sm"
           src="{{ asset('images/logo-placeholder.jpg') }}"
           alt="Logo Desa">
    </div>
    <div class="max-w-xl">
      <h3 class="text-2xl font-bold mb-4 text-indigo-700 dark:text-indigo-300">JELAJAHI DESA</h3>
      <p class="text-gray-700 dark:text-gray-300 leading-relaxed text-justify">
        Melalui website ini Anda dapat menjelajahi segala hal yang terkait dengan Desa.<br>
        Pemerintahan, penduduk, demografi, potensi Desa, dan juga berita tentang Desa.
      </p>
    </div>
  </div>
</section>

<!-- ===== PETA DESA ===== -->
<section class="min-h-screen flex flex-col justify-center bg-gray-100 dark:bg-gray-900 py-20">
  <div class="container mx-auto px-6 text-center">
    <h3 class="text-4xl font-bold text-gray-800 dark:text-gray-100">Peta Desa</h3>
    <p class="text-gray-600 dark:text-gray-400 mt-2 mb-8">Menampilkan lokasi Desa Ngengor</p>
    <div class="rounded-xl overflow-hidden shadow-xl mx-auto max-w-5xl">
      <iframe
        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3955.8787813640465!2d111.65516857411542!3d-7.478635773736994!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e79c5a292282275%3A0x8c8fde03ede35c!2sDesa%20ngengor!5e0!3m2!1sen!2sid!4v1762947300565!5m2!1sen!2sid"
        width="100%"
        height="480"
        style="border:0;"
        allowfullscreen=""
        loading="lazy"
        referrerpolicy="no-referrer-when-downgrade">
      </iframe>
    </div>
  </div>
</section>

<!-- ===== SOTK ===== -->
<section class="min-h-screen flex flex-col justify-center bg-gray-100 dark:bg-gray-900 py-20">
  <div class="container mx-auto px-6 text-center">
    <h2 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-2">SOTK</h2>
    <p class="mb-10 text-gray-600 dark:text-gray-400">Struktur Organisasi & Tatakelola Desa Ngengor</p>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 max-w-2xl h-max-2xl mx-auto">
      <x-card-info title="Lorem" summary="Kepala Desa" image="{{ asset('images/logo-placeholder.jpg') }}" />
      <x-card-info title="Ipsum" summary="Sekretaris Desa" image="{{ asset('images/logo-placeholder.jpg') }}" />
      <x-card-info title="Dolor" summary="Kaur Tata Usaha dan Umum" image="{{ asset('images/logo-placeholder.jpg') }}" />
      <x-card-info title="Sit Amet" summary="Kaur Keuangan" image="{{ asset('images/logo-placeholder.jpg') }}" />
    </div>
    <div class="flex mt-10 justify-end">
      <a href="#"
         class="inline-block px-6 py-2.5 bg-indigo-600 text-white font-semibold rounded-lg shadow hover:bg-indigo-700 transition">
        Lihat Selengkapnya →
      </a>
    </div>
  </div>
</section>

<!-- ===== STATISTIK PENDUDUK ===== -->
<section class="min-h-screen flex items-center bg-gray-100 dark:bg-gray-900 py-20">
  <div class="container mx-auto px-6">
    <h2 class="text-3xl font-bold text-red-600 mb-2">Administrasi Penduduk</h2>
    <p class="text-gray-700 dark:text-gray-300 max-w-3xl mb-10">
      Sistem digital yang mempermudah pengelolaan data dan informasi kependudukan untuk pelayanan publik yang efektif dan efisien.
    </p>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
      <x-stat-box :value="$totalPenduduk" label="Penduduk" />
      <x-stat-box :value="$totalLaki" label="Laki-Laki" />
      <x-stat-box :value="$totalPerempuan" label="Perempuan" />
      <x-stat-box :value="$pendudukSementara" label="Penduduk Sementara" />
      <x-stat-box :value="$mutasiPenduduk" label="Mutasi Penduduk" />
    </div>
  </div>
</section>

<!-- ===== APBD DESA ===== -->
<section class="min-h-screen flex flex-col justify-center bg-gray-100 dark:bg-gray-900 py-20">
  <div class="container mx-auto px-6 text-center">
    <h2 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-2">
      APBD Desa Tahun {{ $apbdesTahun ? $apbdesTahun->tahun : date('Y') }}
    </h2>
    <p class="text-lg text-gray-600 dark:text-gray-400 mb-12">
      Akses cepat dan transparan terhadap APB Desa serta proyek pembangunan.
    </p>

    @if ($apbdesTahun)
    <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
      <div class="bg-gray-50 dark:bg-gray-800 rounded-lg shadow-md p-6">
        <h3 class="text-xl font-bold mb-3 text-gray-800 dark:text-gray-100">Pendapatan Desa</h3>
        <p class="text-2xl font-bold text-green-600 mb-4">
          Rp {{ number_format($apbdesTahun->total_pendapatan, 0, ',', '.') }}
        </p>
        <div class="mb-4">
          <div class="flex justify-between text-sm text-gray-600 dark:text-gray-300 mb-1">
            <span>Realisasi</span>
            <span>{{ number_format($persenRealisasiPendapatan, 2) }}%</span>
          </div>
          <div class="w-full bg-gray-200 rounded-full h-2">
            <div class="bg-green-600 h-2 rounded-full" style="width: {{ $persenRealisasiPendapatan }}%"></div>
          </div>
        </div>
      </div>

      <div class="bg-gray-50 dark:bg-gray-800 rounded-lg shadow-md p-6">
        <h3 class="text-xl font-bold mb-3 text-gray-800 dark:text-gray-100">Belanja Desa</h3>
        <p class="text-2xl font-bold text-red-600 mb-4">
          Rp {{ number_format($apbdesTahun->total_pengeluaran, 0, ',', '.') }}
        </p>
        <div class="mb-4">
          <div class="flex justify-between text-sm text-gray-600 dark:text-gray-300 mb-1">
            <span>Realisasi</span>
            <span>{{ number_format($persenRealisasiPengeluaran, 2) }}%</span>
          </div>
          <div class="w-full bg-gray-200 rounded-full h-2">
            <div class="bg-red-600 h-2 rounded-full" style="width: {{ $persenRealisasiPengeluaran }}%"></div>
          </div>
        </div>
      </div>
    </div>

    <div class="flex justify-end mt-10">
      <a href="#" class="inline-block px-8 py-3 bg-indigo-600 text-white font-semibold rounded-lg shadow hover:bg-indigo-700 transition">
        Lihat Data Lengkap →
      </a>
    </div>
    @else
    <p class="text-center text-lg text-gray-500 dark:text-gray-400">
      Data APBDes belum tersedia untuk ditampilkan.
    </p>
    @endif
  </div>
</section>

<!-- ===== BERITA DESA ===== -->
<section class="min-h-screen flex flex-col justify-center bg-gray-100 dark:bg-gray-900 py-20">
  <div class="container mx-auto px-6">
    <h2 class="text-3xl font-bold mb-2 text-gray-800 dark:text-white">Berita Desa</h2>
    <p class="text-gray-600 dark:text-gray-400 mb-10">
      Update terbaru seputar kegiatan, pengumuman, dan pembangunan desa
    </p>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-10 mb-10">
      <x-news-card title="Judul Berita Desa 1" summary="Ringkasan berita lainnya." />
      <x-news-card title="Judul Berita Desa 2" summary="Ringkasan berita lainnya." />
      <x-news-card title="Judul Berita Desa 3" summary="Ringkasan berita lainnya." />
    </div>
    <div class="grid grid-cols-1 md:grid-cols-3 gap-10">
      <x-news-card title="Judul Berita Desa 1" summary="Ringkasan berita lainnya." />
      <x-news-card title="Judul Berita Desa 2" summary="Ringkasan berita lainnya." />
      <x-news-card title="Judul Berita Desa 3" summary="Ringkasan berita lainnya." />
    </div>
    <div class="flex justify-end mt-10">
      <a href="#" class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 transition">
        Lihat Selengkapnya →
      </a>
    </div>
  </div>
</section>

<!-- ===== POTENSI DESA ===== -->
<section class="min-h-screen flex flex-col justify-center bg-gray-100 dark:bg-gray-900 py-20">
  <div class="container mx-auto px-6">
    <div class="flex flex-col items-start">
      <x-circle-image-frame image="{{ asset('images/logo-placeholder.jpg') }}" alt="Wisata Alam Siling Kanu" />
      <h2 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mt-6">
        Wisata Alam Siling Kanu
      </h2>
    </div>
    <div class="flex justify-end mt-10">
      <a href="#" class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 transition">
        Lihat Selengkapnya →
      </a>
    </div>
  </div>
</section>

<!-- ==== Hero Section Duplicate ==== -->
<section class="min-h-screen flex items-center justify-center bg-indigo-600 dark:bg-indigo-800 py-20">
  <div class="container mx-auto px-6 text-center">
    <h1 class="text-5xl font-extrabold text-white mb-4">
      Selamat Datang di <span class="text-yellow-300">VillageLaravel</span>
    </h1>
    <p class="text-lg text-indigo-100 mb-8">
      Solusi manajemen data desa berbasis Laravel 12.
    </p>
    <a href="{{ route('register') }}"
      class="bg-white text-indigo-700 font-bold py-3 px-6 rounded-lg shadow-md hover:bg-gray-100 transition">
      Mulai Sekarang
    </a>
  </div>
</section>

<!-- ==== Pesan dari Desa ==== -->
<section class="min-h-screen flex flex-col justify-center bg-gray-100 dark:bg-gray-900 py-20">
  <div class="container mx-auto px-6 text-center">
    <h2 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-2">Beli dari Desa</h2>
    <p class="mb-10 text-gray-600 dark:text-gray-400">Berikut Produk Unggulan dari UMKM Kami</p>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 max-w-2xl h-max-2xl mx-auto mb-10">
      <x-image-frame title="Lorem" summary="Kepala Desa" image="{{ asset('images/logo-placeholder.jpg') }}" />
      <x-image-frame title="Lorem" summary="Kepala Desa" image="{{ asset('images/logo-placeholder.jpg') }}" />
      <x-image-frame title="Lorem" summary="Kepala Desa" image="{{ asset('images/logo-placeholder.jpg') }}" />
      <x-image-frame title="Lorem" summary="Kepala Desa" image="{{ asset('images/logo-placeholder.jpg') }}" />
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 max-w-2xl h-max-2xl mx-auto">
      <x-image-frame title="Lorem" summary="Kepala Desa" image="{{ asset('images/logo-placeholder.jpg') }}" />
      <x-image-frame title="Lorem" summary="Kepala Desa" image="{{ asset('images/logo-placeholder.jpg') }}" />
      <x-image-frame title="Lorem" summary="Kepala Desa" image="{{ asset('images/logo-placeholder.jpg') }}" />
      <x-image-frame title="Lorem" summary="Kepala Desa" image="{{ asset('images/logo-placeholder.jpg') }}" />
    </div>
    <div class="flex mt-8 justify-end">
      <a href="#"
         class="inline-block px-6 py-2.5 bg-indigo-600 text-white font-semibold rounded-lg shadow hover:bg-indigo-700 transition">
        Lihat Selengkapnya →
      </a>
    </div>
  </div>
</section>

<!-- ==== Galeri Desa ==== -->
<section class="min-h-screen flex flex-col justify-center bg-gray-100 dark:bg-gray-900 py-20">
  <div class="container mx-auto px-6 text-center">
    <h2 class="text-3xl font-bold text-gray-900 dark:text-gray-100 mb-2">Galeri Desa</h2>
    <p class="mb-10 text-gray-600 dark:text-gray-400">Kegiatan Warga Desa Ngengor</p>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 max-w-2xl h-max-2xl mx-auto mb-10">
      <x-image-frame title="Lorem" summary="Kepala Desa" image="{{ asset('images/logo-placeholder.jpg') }}" />
      <x-image-frame title="Lorem" summary="Kepala Desa" image="{{ asset('images/logo-placeholder.jpg') }}" />
      <x-image-frame title="Lorem" summary="Kepala Desa" image="{{ asset('images/logo-placeholder.jpg') }}" />
      <x-image-frame title="Lorem" summary="Kepala Desa" image="{{ asset('images/logo-placeholder.jpg') }}" />
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 max-w-2xl h-max-2xl mx-auto">
      <x-image-frame title="Lorem" summary="Kepala Desa" image="{{ asset('images/logo-placeholder.jpg') }}" />
      <x-image-frame title="Lorem" summary="Kepala Desa" image="{{ asset('images/logo-placeholder.jpg') }}" />
      <x-image-frame title="Lorem" summary="Kepala Desa" image="{{ asset('images/logo-placeholder.jpg') }}" />
      <x-image-frame title="Lorem" summary="Kepala Desa" image="{{ asset('images/logo-placeholder.jpg') }}" />
    </div>
    <div class="flex mt-8 justify-end">
      <a href="#"
         class="inline-block px-6 py-2.5 bg-indigo-600 text-white font-semibold rounded-lg shadow hover:bg-indigo-700 transition">
        Lihat Selengkapnya →
      </a>
    </div>
  </div>
</section>
@endsection