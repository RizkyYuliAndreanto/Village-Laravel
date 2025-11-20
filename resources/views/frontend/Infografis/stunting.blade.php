@extends('frontend.layouts.main')

@section('content')
<!-- ===== Visi & Misi ===== -->
<section class="min-h-screen flex flex-col bg-gray-100 dark:bg-gray-900 py-16">
  <!-- Submenu -->
  <div class="flex justify-end mb-6">
    @include('layouts.partials.submenu')  
  </div>

  <!-- Konten Utama -->
  <div class="container mx-auto px-6 flex flex-col lg:flex-row items-center justify-between gap-12">
    
    <!-- Gambar -->
    <div class="flex-shrink-0">
      <img 
        class="rounded-2xl shadow-lg max-w-sm w-full object-cover"
        src="{{ asset('images/logo-placeholder.jpg') }}"
        alt="Logo Desa"
      >
    </div>

    <!-- Teks -->
    <div class="max-w-xl text-center lg:text-left">
      <h3 class="text-3xl font-extrabold mb-4 text-gray-900 dark:text-white">
        Jelajahi Desa
      </h3>
      <p class="text-gray-700 dark:text-gray-300 leading-relaxed text-justify">
        Melalui website ini Anda dapat menjelajahi segala hal yang terkait dengan Desa.
        Pemerintahan, penduduk, demografi, potensi Desa, dan juga berita tentang Desa.
      </p>
    </div>

  </div>
</section>

<!-- ===== Bagan Desa ===== -->
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
<!-- ===== Sejarah Desa ===== -->
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