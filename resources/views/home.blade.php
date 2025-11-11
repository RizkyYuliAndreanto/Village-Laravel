@extends('layouts.main')

@section('content')

<div class="bg-indigo-600 dark:bg-indigo-800">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8 py-24 text-center">
        <h1 class="text-4xl lg:text-5xl font-extrabold mb-4">
            Selamat Datang di VillageLaravel
        </h1>
        <p class="text-lg lg:text-xl text-indigo-100 mb-8">
            Solusi manajemen data desa berbasis Laravel 12.
        </p>
        <a href="{{ route('register') }}" class="bg-white text-indigo-700 font-bold py-3 px-6 rounded-lg shadow-md hover:bg-gray-100 transition">
            Mulai Sekarang
        </a>
    </div>
</div>
<div class="flex flex-row py-16">
    <div class="flex px-20">
        <img class="h-10vh w-auto"
            src="{{ asset('images/logo-placeholder.jpg') }}"
            alt="Logo {{ config('app.name', 'Laravel') }}">
    </div>
    <div class="flex flex-col px-10 text-black justify-center align-center">

        <h2 class="text-3xl font-bold mb-2 justify-center align-center">
            JELAJAHI DESA
        </h2>

        <p class="text-justify max-w-3xl">
            Melalui website ini Anda dapat menjelajahi segala hal yang terkait dengan Desa.
            Aspek pemerintahan, penduduk, demografi, potensi Desa, dan juga berita tentang Desa.
        </p>

    </div>
</div>
<div class="py-16 bg-white rounded-xl shadow-md">
    <div class="max-w-4xl mx-auto px-6 text-center">
        <h3 class="text-2xl font-bold text-gray-800">Peta Desa</h3>
        <p class="text-gray-600 mt-2">Menampilkan lokasi Desa Ngengor.</p>
    </div>

    <div class="mt-10 flex justify-center">
        <div class="rounded-xl overflow-hidden shadow-xl"
            style="width: 85%; max-width: 900px; height: 480px;"> 
            
            <iframe
                src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d3952.631219133637!2d111.650074!3d-7.589247999999999!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e79ba3d20425c79%3A0x5027a76e3567d10!2sNgengor%2C%20Pilangkenceng%2C%20Kabupaten%20Madiun%2C%20Jawa%20Timur!5e0!3m2!1sid!2sid!4v1731323450000!5m2!1sid!2sid"
                width="100%"
                height="100%"
                style="border:0;"
                allowfullscreen=""
                loading="lazy"
                referrerpolicy="no-referrer-when-downgrade">
            </iframe>
        </div>
    </div>
</div>
<div class="bg-gray-100 dark:bg-gray-900 py-16">
    <div class="container mx-auto px-4 sm:px-6 lg:px-8">
        
        <h2 class="text-3xl font-bold text-start text-gray-900 dark:text-gray-100 mb-2">
           STOK
        </h2>
        <p class="mb-12">Strktur Organisasi dan Tata Kerja Desa Ngegor</p>
        
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden flex flex-col">
                <img class="w-full h-32 object-cover" src="{{ asset('images/logo-placeholder.jpg') }}" alt="Pengumuman Desa">
                
                <div class="p-6 flex-grow"> <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-2">
                        Pengumuman Desa
                    </h3>
                    <p class="text-gray-600 dark:text-gray-300 text-sm">
                        Ini adalah deskripsi singkat untuk konten card pertama.
                        Bisa diisi dengan pengumuman atau berita terbaru dari desa.
                    </p>
                </div>
                <div class="p-6 pt-0">
                    <a href="#" class="font-semibold text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 transition">
                        Lihat Selengkapnya →
                    </a>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden flex flex-col">
                <img class="w-full h-32 object-cover" src="{{ asset('images/logo-placeholder.jpg') }}" alt="Data Penduduk">
                
                <div class="p-6 flex-grow">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-2">
                        Data Penduduk
                    </h3>
                    <p class="text-gray-600 dark:text-gray-300 text-sm">
                        Akses cepat untuk melihat statistik dan data kependudukan desa terkini.
                    </p>
                </div>
                <div class="p-6 pt-0">
                    <a href="#" class="font-semibold text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 transition">
                        Lihat Selengkapnya →
                    </a>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden flex flex-col">
                <img class="w-full h-32 object-cover" src="{{ asset('images/logo-placeholder.jpg') }}" alt="Layanan Surat">

                <div class="p-6 flex-grow">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-2">
                        Layanan Surat
                    </h3>
                    <p class="text-gray-600 dark:text-gray-300 text-sm">
                        Ajukan surat pengantar, KTP, atau surat keterangan lainnya secara online.
                    </p>
                </div>
                <div class="p-6 pt-0">
                    <a href="#" class="font-semibold text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 transition">
                        Lihat Selengkapnya →
                    </a>
                </div>
            </div>

            <div class="bg-white dark:bg-gray-800 rounded-lg shadow-lg overflow-hidden flex flex-col">
                <img class="w-full h-32 object-cover" src="{{ asset('images/logo-placeholder.jpg') }}" alt="Agenda Desa">
                
                <div class="p-6 flex-grow">
                    <h3 class="text-xl font-semibold text-gray-900 dark:text-gray-100 mb-2">
                        Agenda Desa
                    </h3>
                    <p class="text-gray-600 dark:text-gray-300 text-sm">
                        Jangan lewatkan kegiatan dan agenda penting desa yang akan datang.
                    </p>
                </div>
                <div class="p-6 pt-0">
                    <a href="#" class="font-semibold text-indigo-600 dark:text-indigo-400 hover:text-indigo-500 transition">
                        Lihat Selengkapnya →
                    </a>
                </div>
            </div>
            
        </div> </div>
</div>
@endsection