{{-- Template Section untuk Belanja --}}
<section class="min-h-screen flex items-center pb-10 bg-gray-100 dark:bg-gray-900">
  <div class="container mx-auto px-6 flex flex-col lg:flex-row items-center justify-between gap-10">
    <div class="flex-shrink-0">
      <img class="rounded-lg shadow-md max-w-sm"
        src="{{ $image ?? asset('images/logo-placeholder.jpg') }}"
        alt="{{ $alt ?? 'Logo Desa' }}">
    </div>
    <div class="max-w-xl">
      <h3 class="text-2xl font-bold mb-4 text-gray-800 dark:text-gray-100">{{ $title ?? 'JELAJAHI DESA' }}</h3>
      <p class="text-gray-700 dark:text-gray-300 leading-relaxed text-justify">
        {{ $description ?? 'Melalui website ini Anda dapat menjelajahi segala hal yang terkait dengan Desa. Pemerintahan, penduduk, demografi, potensi Desa, dan juga berita tentang Desa.' }}
      </p>
    </div>
  </div>
</section>