@extends('frontend.layouts.main')

@section('content')
<!-- ===== Visi & Misi ===== -->
<section class="min-h-screen flex items-center justify-center pb-10 bg-gray-100 dark:bg-gray-900">
  <div class="container mx-auto px-6 flex flex-col md:flex-row items-stretch justify-center gap-10">
    <!-- ===== VISI ===== -->
    <div class="flex-1 bg-white dark:bg-gray-800 text-gray-900 dark:text-white rounded-xl shadow-md p-20">
      <h2 class="text-2xl font-bold text-center mb-4">Visi</h2>
      <p class="text-center text-lg mb-4">
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Ullam, voluptates reiciendis.
      </p>
      <ul class="list-disc list-inside space-y-1 text-center md:text-left">
        <li>Menjadikan desa yang mandiri dan sejahtera</li>
        <li>Meningkatkan kualitas pendidikan masyarakat</li>
        <li>Memperkuat ekonomi berbasis potensi lokal</li>
        <li>Mewujudkan pemerintahan yang transparan</li>
      </ul>
    </div>

    <!-- ===== MISI ===== -->
    <div class="flex-1 bg-white dark:bg-gray-800 text-gray-900 dark:text-white rounded-xl shadow-md p-8">
      <h2 class="text-2xl font-bold text-center mb-4">Misi</h2>
      <p class="text-justify text-lg mb-4">
        Lorem ipsum dolor sit amet consectetur adipisicing elit. Ullam, voluptates reiciendis.
      </p>
      <ul class="list-disc list-inside space-y-1">
        <li>Mendorong partisipasi masyarakat dalam pembangunan</li>
        <li>Mengembangkan infrastruktur pedesaan yang memadai</li>
        <li>Meningkatkan pelayanan publik yang efisien</li>
        <li>Melestarikan nilai budaya dan lingkungan</li>
      </ul>
    </div>

  </div>
</section>

<!-- ===== Bagan Desa ===== -->
<section class="min-h-screen flex pb-10 bg-gray-100 dark:bg-gray-900 border border-red py-20">
  <div class="container mx-auto px-6 flex flex-col gap-10 border border-red">
    <div class="flex flex-col bg-gray-90 mb-10">
      <h2 class="text-4xl font-bold text-start">Bagan Desa</h2>
    </div>
    <div class="flex flex-row">
      <div class="flex flex-col mx-auto">
        <p class="text-l text-center font-bold mb-5">
          Struktur Organisasi Pemerintahan Desa
        </p>
        <div class="flex flex-shrink-0 justify-center">
          <img class="rounded-lg shadow-md max-w-sm"
            src="{{ asset('images/logo-placeholder.jpg') }}"
            alt="Logo Desa">
        </div>
      </div>
      <div class="flex flex-col mx-auto">
        <p class="text-l text-center font-bold mb-5">
          Struktur Organisasi Badan Permusyawaratan Desa
        </p>
        <div class="flex flex-shrink-0 justify-center">
          <img class="rounded-lg shadow-md max-w-sm"
            src="{{ asset('images/logo-placeholder.jpg') }}"
            alt="Logo Desa">
        </div>
      </div>
    </div>
  </div>
</section>

<!-- ===== Sejarah Desa ===== -->
<section class="min-h-screen flex pb-10 bg-gray-100 dark:bg-gray-900 border border-red py-20">
  <div class="container mx-auto px-6 flex flex-col gap-10 border border-red">
    <div class="flex flex-col bg-gray-90 mb-10">
      <h2 class="text-4xl font-bold text-start">Sejarah Desa Ngengor</h2>
    </div>
    <div class="flex flex-row">
      <div class="flex flex-shrink-0 justify-center mr-5">
        <img class="rounded-lg shadow-md max-w-sm"
          src="{{ asset('images/logo-placeholder.jpg') }}"
          alt="Logo Desa">
      </div>
      <div class="mb-5 max-w-prose border border-red">
        <p class="text-l text-justify font-bold">
          Lorem ipsum dolor sit amet, consectetur adipisicing elit. Vel quod quisquam modi facere numquam tenetur explicabo sint officia saepe similique amet earum placeat dolorem, aperiam labore architecto autem, obcaecati est?
          Lorem ipsum dolor sit amet consectetur, adipisicing elit. Ipsum deserunt nemo, ad sint quam commodi in mollitia libero. Obcaecati delectus quasi quidem maiores esse iste adipisci quod facere. Temporibus, totam.
        </p>
      </div>
    </div>
  </div>
</section>

<!-- ===== Peta Lokasi ===== -->
<section class="min-h-screen flex pb-10 bg-gray-100 dark:bg-gray-900 py-20">
  <div class="container mx-auto px-6 flex flex-col gap-10">
    <!-- Judul -->
    <div class="flex flex-col mb-10">
      <h2 class="text-4xl font-bold text-start">Peta Lokasi Desa</h2>
    </div>

    <!-- Konten Utama -->
    <div class="flex flex-col md:flex-row gap-8">
      
      <!-- Info Desa -->
      <div class="flex-1 flex flex-col justify-center gap-4 bg-white dark:bg-gray-800 p-6 rounded-lg shadow-md">
        <!-- Batas Desa -->
        <div>
          <h3 class="text-2xl font-semibold mb-3">Batas Desa:</h3>
          <ul class="space-y-2">
            <li class="flex justify-between border-b border-gray-200 dark:border-gray-700 pb-1">
              <span class="font-medium">Utara</span>
              <span>Desa Aw</span>
            </li>
            <li class="flex justify-between border-b border-gray-200 dark:border-gray-700 pb-1">
              <span class="font-medium">Timur</span>
              <span>Desa Aw</span>
            </li>
            <li class="flex justify-between border-b border-gray-200 dark:border-gray-700 pb-1">
              <span class="font-medium">Selatan</span>
              <span>Desa Aw</span>
            </li>
            <li class="flex justify-between border-b border-gray-200 dark:border-gray-700 pb-1">
              <span class="font-medium">Barat</span>
              <span>Desa Aw</span>
            </li>
          </ul>
        </div>

        <!-- Keterangan -->
        <div>
          <h3 class="text-2xl font-semibold mb-2">Luas Desa:</h3>
          <p class="text-gray-700 dark:text-gray-300">
            111.543 m2
          </p>
        </div>

        <!-- Jumlah Penduduk -->
        <div>
          <h3 class="text-2xl font-semibold mb-2">Jumlah Penduduk:</h3>
          <p class="text-gray-700 dark:text-gray-300">1000 jiwa</p>
        </div>
      </div>

      <!-- Peta -->
      <div class="flex-1">
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
  </div>
</section>

@endsection