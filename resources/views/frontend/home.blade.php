@extends('frontend.layouts.main')

@section('content')

<section class="min-h-screen flex items-center justify-center bg-indigo-600 dark:bg-indigo-800">
  <div class="container mx-auto px-6 text-center py-20">
    
    <h1 class="text-4xl md:text-5xl font-extrabold text-white mb-4">
      Selamat Datang
    </h1>

    <p class="text-lg md:text-xl text-indigo-100 mb-2">
      Web Informasi dan Profil Desa Ngengor
    </p>
    <p class="text-indigo-200 mb-8">
      Kecamatan Pilangkenceng, Kabupaten Madiun
    </p>

    <a href="#"
      class="inline-block bg-white text-indigo-700 font-semibold py-3 px-8 rounded-lg shadow-lg 
             hover:bg-indigo-50 hover:scale-105 transform transition duration-200">
      Mulai Sekarang
    </a>
  </div>
</section>

<section class="min-h-screen flex items-center pb-10 bg-gray-100 dark:bg-gray-900">
  <div class="container mx-auto px-6 flex flex-col lg:flex-row items-center justify-between gap-10">
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

<section class="min-h-screen flex flex-col justify-center pb-10 bg-gray-100 dark:bg-gray-900">
  <div class="container mx-auto px-6 text-center">
    <h3 class="text-4xl font-bold text-gray-800 dark:text-gray-100">Peta Desa</h3>
    <p class="text-gray-700 dark:text-gray-300 mt-2 mb-4">Menampilkan lokasi Desa Ngengor</p>
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

<section class="min-h-screen flex flex-col justify-center py-10 bg-gray-100 dark:bg-gray-900">
  <div class="container mx-auto px-6 text-center">
    <h2 class="text-3xl font-bold text-gray-800 dark:text-gray-100">SOTK</h2>
    <p class="mb-8 text-gray-700 dark:text-gray-300">Struktur Organisasi & Tatakelola Desa Ngengor</p>
    
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 max-w-6xl mx-auto">
      @forelse($sotk as $anggota)
        <x-card-info 
          :title="$anggota->nama" 
          :summary="$anggota->jabatan" 
          :image="asset($anggota->foto_url ?? 'images/logo-placeholder.jpg')" />
      @empty
        <p class="text-gray-700 dark:text-gray-300 col-span-4">Data SOTK belum tersedia.</p>
      @endforelse
    </div>
    <div class="flex mt-10 justify-end">
      <a href="{{ route('struktur.index') }}"
        class="inline-block px-6 py-2.5 bg-indigo-600 text-white font-semibold rounded-lg shadow hover:bg-indigo-700 transition">
        Lihat Selengkapnya →
      </a>
    </div>
  </div>
</section>

<section class="min-h-screen flex items-center py-10 bg-gray-100 dark:bg-gray-900">
  <div class="container mx-auto px-6">
    <h2 class="text-3xl font-bold text-indigo-700 dark:text-indigo-300 mb-4">Statistik Penduduk</h2>
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

<section class="min-h-screen flex flex-col justify-center py-10 bg-gray-100 dark:bg-gray-900">
  <div class="container mx-auto px-6 text-center">
    
    @if($apbdesLaporan && $apbdesLaporan->tahunData)
      <h2 class="text-3xl font-bold text-gray-800 dark:text-gray-100 mb-2">
        APBD Desa Tahun {{ $apbdesLaporan->tahunData->tahun }}
      </h2>
      <p class="text-lg text-gray-700 dark:text-gray-300 mb-12">
        Akses cepat dan transparan terhadap APB Desa serta proyek pembangunan.
      </p>

      <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
          <h3 class="text-xl font-bold mb-3 text-gray-800 dark:text-gray-100">Pendapatan Desa</h3>
          <p class="text-2xl font-bold text-green-600 mb-4">
            Rp {{ number_format($totalAnggaranPendapatan, 0, ',', '.') }}
          </p>
          <div class="mb-4">
            <div class="flex justify-between text-sm text-gray-700 dark:text-gray-300 mb-1">
              <span>Realisasi</span>
              <span>{{ number_format($persenRealisasiPendapatan, 2) }}%</span>
            </div>
            <div class="w-full bg-gray-300 rounded-full h-2">
              <div class="bg-green-600 h-2 rounded-full" style="width: {{ $persenRealisasiPendapatan }}%"></div>
            </div>
          </div>
        </div>
        <div class="bg-white dark:bg-gray-800 rounded-lg shadow-md p-6">
          <h3 class="text-xl font-bold mb-3 text-gray-800 dark:text-gray-100">Belanja Desa</h3>
          <p class="text-2xl font-bold text-red-600 mb-4">
            Rp {{ number_format($totalAnggaranPengeluaran, 0, ',', '.') }}
          </p>
          <div class="mb-4">
            <div class="flex justify-between text-sm text-gray-700 dark:text-gray-300 mb-1">
              <span>Realisasi</span>
              <span>{{ number_format($persenRealisasiPengeluaran, 2) }}%</span>
            </div>
            <div class="w-full bg-gray-300 rounded-full h-2">
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
      <h2 class="text-3xl font-bold text-gray-800 dark:text-gray-100 mb-2">
        APBD Desa
      </h2>
      <p class="text-center text-lg text-gray-700 dark:text-gray-300 mt-10">
        Data APBDes belum tersedia untuk ditampilkan.
      </p>
    @endif
  </div>
</section>

<section class="min-h-screen flex flex-col justify-center bg-gray-100 dark:bg-gray-900 py-20">
  <div class="container mx-auto px-6">
    <div class="text-center mb-10">
      <h2 class="text-3xl font-bold mb-2 text-gray-800 dark:text-gray-100">Berita Desa</h2>
      <p class="text-gray-700 dark:text-gray-300">
        Update terbaru seputar kegiatan, pengumuman, dan pembangunan desa
      </p>
    </div>

    <div class="flex flex-col items-center max-w-6xl mx-auto">
      
      <div class="flex overflow-x-auto snap-x snap-mandatory gap-6 w-full pb-6 mb-6
                  md:grid md:grid-cols-3 md:gap-10 md:overflow-visible md:pb-0">
        
        @forelse($beritaTerbaru as $berita)
          <div class="min-w-[85%] sm:min-w-[350px] flex-shrink-0 snap-center md:min-w-0 md:w-auto md:flex-shrink">
            <x-news-card 
              :title="$berita->judul" 
              :summary="Str::limit(strip_tags($berita->isi), 100)" 
              :image="$berita->image_url"  
              :url="route('berita.show', $berita->id)" 
            />
          </div>
        @empty
          <div class="col-span-3 w-full text-center">
            <p class="text-gray-700 dark:text-gray-300">Belum ada berita untuk ditampilkan.</p>
          </div>
        @endforelse

      </div>
    </div>
    
    <div class="flex justify-end mt-5">
      <a href="{{ route('berita.index') }}" class="bg-indigo-600 text-white px-6 py-2 rounded-lg hover:bg-indigo-700 transition">
        Lihat Selengkapnya →
      </a>
    </div>
  </div>
</section>

<section class="min-h-screen flex flex-col justify-center py-20 bg-gray-100 dark:bg-gray-900">
  <div class="container mx-auto px-6">
    
    <div class="flex flex-col text-center text-gray-700 dark:text-gray-300 mb-16">
      <h2 class="text-3xl md:text-4xl font-bold mb-4 text-gray-800 dark:text-gray-100">
        Potensi Desa Ngengor
      </h2>
      <p class="text-gray-600 dark:text-gray-400 max-w-2xl mx-auto leading-relaxed">
        Informasi tentang potensi dan kemajuan Desa di berbagai bidang seperti ekonomi,
        pariwisata, pertanian, industri kreatif, dan kelestarian lingkungan.
      </p>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-10 max-w-6xl mx-auto">
      
      @forelse($potensiDesa as $potensi)
        <div class="flex flex-col items-center text-center group">
          
          <div class="relative w-48 h-48 mb-6 rounded-full overflow-hidden shadow-lg border-4 border-white dark:border-gray-700 transition-transform duration-300 group-hover:scale-105 bg-gray-200">
             <img src="{{ $potensi->logo_url ? asset('storage/' . $potensi->logo_url) : asset('images/logo-placeholder.jpg') }}" 
                  alt="{{ $potensi->nama }}"
                  class="w-full h-full object-cover">
          </div>

          <h3 class="text-2xl font-bold text-gray-800 dark:text-gray-100 mb-3 group-hover:text-indigo-600 transition-colors">
            {{ $potensi->nama }}
          </h3>
          
          <p class="text-gray-600 dark:text-gray-400 leading-relaxed mb-4 line-clamp-3 px-2">
            {{ Str::limit(strip_tags($potensi->deskripsi), 120) }}
          </p>
          
          @if($potensi->slug)
            <a href="{{ route('umkm.show', $potensi->slug) }}" class="text-sm font-semibold text-indigo-600 hover:text-indigo-800 hover:underline">
              Lihat Detail
            </a>
          @endif

        </div>
      @empty
        <div class="col-span-3 text-center py-12 bg-white dark:bg-gray-800 rounded-lg shadow-sm opacity-75">
            <p class="text-gray-500 dark:text-gray-400 text-lg italic">
                Data Potensi Desa belum tersedia saat ini.
            </p>
        </div>
      @endforelse

    </div>

    <div class="flex justify-center md:justify-end mt-16 max-w-6xl mx-auto">
      <a href="{{ route('umkm.index') }}" class="inline-flex items-center gap-2 bg-indigo-600 text-white px-8 py-3 rounded-lg shadow-lg hover:bg-indigo-700 transition transform hover:-translate-y-1 font-semibold">
        Lihat Selengkapnya
        <svg xmlns="http://www.w3.org/2000/svg" class="h-5 w-5" viewBox="0 0 20 20" fill="currentColor">
            <path fill-rule="evenodd" d="M10.293 3.293a1 1 0 011.414 0l6 6a1 1 0 010 1.414l-6 6a1 1 0 01-1.414-1.414L14.586 11H3a1 1 0 110-2h11.586l-4.293-4.293a1 1 0 010-1.414z" clip-rule="evenodd" />
        </svg>
      </a>
    </div>

  </div>
</section>

<section class="min-h-screen flex flex-col justify-center py-20 bg-gray-100 dark:bg-gray-900">
  <div class="container mx-auto px-6 text-center">
    <h2 class="text-3xl font-bold text-gray-800 dark:text-gray-100 mb-2">Galeri Desa</h2>
    <p class="mb-10 text-gray-700 dark:text-gray-300">Kegiatan Warga Desa Ngengor</p>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 max-w-6xl mx-auto">
      <x-image-frame title="Lorem" summary="Kepala Desa" image="{{ asset('images/logo-placeholder.jpg') }}" />
      <x-image-frame title="Ipsum" summary="Sekretaris Desa" image="{{ asset('images/logo-placeholder.jpg') }}" />
      <x-image-frame title="Dolor" summary="Kaur Tata Usaha" image="{{ asset('images/logo-placeholder.jpg') }}" />
      <x-image-frame title="Sit Amet" summary="Kaur Keuangan" image="{{ asset('images/logo-placeholder.jpg') }}" />
    </div>
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 max-w-6xl mx-auto py-4">
      <x-image-frame title="Lorem" summary="Kepala Desa" image="{{ asset('images/logo-placeholder.jpg') }}" />
      <x-image-frame title="Ipsum" summary="Sekretaris Desa" image="{{ asset('images/logo-placeholder.jpg') }}" />
      <x-image-frame title="Dolor" summary="Kaur Tata Usaha" image="{{ asset('images/logo-placeholder.jpg') }}" />
      <x-image-frame title="Sit Amet" summary="Kaur Keuangan" image="{{ asset('images/logo-placeholder.jpg') }}" />
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