@extends('frontend.layouts.main')

@section('title', 'Profil Desa - Desa Banyukambang')

@section('content')
@php
    // Fallback: Jika variabel $strukturOrganisasi tidak dikirim dari controller, 
    // inisialisasi sebagai koleksi kosong untuk menghindari error ->count()
    if (!isset($strukturOrganisasi)) {
        $strukturOrganisasi = collect(); 
    }
@endphp
<!-- Hero Section -->
<div class="section-bg-profil py-16">
    <div class="container mx-auto px-4 lg:px-8">
        <!-- Hero Content -->
        <div class="text-center text-white">
            <h1 class="text-5xl lg:text-6xl font-bold mb-6">
                🏘️ Profil Desa Banyukambang
            </h1>
            <p class="text-xl lg:text-2xl mb-8 max-w-4xl mx-auto leading-relaxed">
                Mengenal lebih dekat dengan Desa Banyukambang, Wonoasri, Madiun - dari visi misi, struktur organisasi, 
                potensi desa hingga peta wilayah lengkap
            </p>
            
            <!-- Navigation Menu -->
            <div class="flex flex-wrap justify-center gap-4">
                <a href="#visi-misi" class="bg-white/20 hover:bg-white/30 px-6 py-3 rounded-full font-medium transition-all hover:scale-105">
                    🎯 Visi & Misi
                </a>
                <a href="#struktur-organisasi" class="bg-white/20 hover:bg-white/30 px-6 py-3 rounded-full font-medium transition-all hover:scale-105">
                    👥 Struktur Organisasi
                </a>
                <a href="#potensi-desa" class="bg-white/20 hover:bg-white/30 px-6 py-3 rounded-full font-medium transition-all hover:scale-105">
                    🌾 Potensi Desa
                </a>
                <a href="#peta-desa" class="bg-white/20 hover:bg-white/30 px-6 py-3 rounded-full font-medium transition-all hover:scale-105">
                    🗺️ Peta Desa
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Main Content -->
<div class="py-16">
    <div class="container mx-auto px-4 lg:px-8">
        
        <!-- Section 1: Visi & Misi -->
        <section id="visi-misi" class="mb-24">
            <div class="text-center mb-16">
                <h2 class="text-4xl lg:text-5xl font-bold text-heading mb-4">
                    🎯 Visi & Misi Desa
                </h2>
                <div class="section-divider"></div>
                <p class="text-lg text-body max-w-3xl mx-auto">
                    Landasan filosofis dan arah pengembangan Desa Banyukambang menuju masa depan yang lebih sejahtera
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <!-- Visi -->
                <div class="card-profil rounded-3xl p-8 lg:p-12 shadow-2xl">
                    <div class="text-center mb-8">
                        <div class="w-20 h-20 bg-profil-primary rounded-full flex items-center justify-center mx-auto mb-4">
                            <span class="text-3xl text-white">🎯</span>
                        </div>
                        <h3 class="text-3xl font-bold text-heading">VISI</h3>
                    </div>
                    
                    <div class="bg-gradient-to-br from-cyan-50 to-blue-50 rounded-2xl p-8 text-center">
                        <blockquote class="text-xl lg:text-2xl font-semibold text-heading leading-relaxed italic">
                            "MEMBANGUN DESA BANYUKAMBANG LEBIH MAJU, MANDIRI, SEJAHTERA, SEHAT, AMAN, BERAHLAK MULIADENGAN MENJUNJUNG TRANSPARANSI"
                        </blockquote>
                    </div>
                </div>

                <!-- Misi -->
                <div class="card-profil rounded-3xl p-8 lg:p-12 shadow-2xl">
                    <div class="text-center mb-8">
                        <div class="w-20 h-20 bg-profil-primary rounded-full flex items-center justify-center mx-auto mb-4">
                            <span class="text-3xl text-white">🚀</span>
                        </div>
                        <h3 class="text-3xl font-bold text-heading">MISI</h3>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="flex items-start space-x-4 p-4 bg-gradient-to-r from-cyan-50 to-transparent rounded-xl">
                            <div class="w-8 h-8 bg-profil-primary text-white rounded-full flex items-center justify-center font-bold flex-shrink-0">1</div>
                            <p class="text-body font-medium">Meningkatkan kualitas sumber daya manusia SDM</p>
                        </div>
                        
                        <div class="flex items-start space-x-4 p-4 bg-gradient-to-r from-cyan-50 to-transparent rounded-xl">
                            <div class="w-8 h-8 bg-profil-primary text-white rounded-full flex items-center justify-center font-bold flex-shrink-0">2</div>
                            <p class="text-body font-medium">Menumbuh kembangkan potensi asli desa</p>
                        </div>
                        
                        <div class="flex items-start space-x-4 p-4 bg-gradient-to-r from-cyan-50 to-transparent rounded-xl">
                            <div class="w-8 h-8 bg-profil-primary text-white rounded-full flex items-center justify-center font-bold flex-shrink-0">3</div>
                            <p class="text-body font-medium">Meningkatkan taraf hidup masyarakat dengan ekonomi lemah</p>
                        </div>
                        
                        <div class="flex items-start space-x-4 p-4 bg-gradient-to-r from-cyan-50 to-transparent rounded-xl">
                            <div class="w-8 h-8 bg-profil-primary text-white rounded-full flex items-center justify-center font-bold flex-shrink-0">4</div>
                            <p class="text-body font-medium">Meningkatkan pembangunan infrastruktur</p>
                        </div>
                        
                        <div class="flex items-start space-x-4 p-4 bg-gradient-to-r from-cyan-50 to-transparent rounded-xl">
                            <div class="w-8 h-8 bg-profil-primary text-white rounded-full flex items-center justify-center font-bold flex-shrink-0">5</div>
                            <p class="text-body font-medium">Meningkatkan derajat kesehatan masyarakat</p>
                        </div>
                        <div class="flex items-start space-x-4 p-4 bg-gradient-to-r from-cyan-50 to-transparent rounded-xl">
                            <div class="w-8 h-8 bg-profil-primary text-white rounded-full flex items-center justify-center font-bold flex-shrink-0">5</div>
                            <p class="text-body font-medium">Meningkatkan bidang keamanan</p>
                        </div>
                        <div class="flex items-start space-x-4 p-4 bg-gradient-to-r from-cyan-50 to-transparent rounded-xl">
                            <div class="w-8 h-8 bg-profil-primary text-white rounded-full flex items-center justify-center font-bold flex-shrink-0">5</div>
                            <p class="text-body font-medium">Meningkatkan bidang keamanan</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Section 2: Struktur Organisasi -->
        <section id="struktur-organisasi" class="mb-24">
            <div class="text-center mb-16">
                <h2 class="text-4xl lg:text-5xl font-bold text-heading mb-4">
                    👥 Struktur Organisasi
                </h2>
                <div class="section-divider"></div>
                <p class="text-lg text-body max-w-3xl mx-auto">
                    Susunan organisasi pemerintahan Desa Banyukambang dengan tugas dan fungsi masing-masing
                </p>
            </div>

            

            @if($strukturOrganisasi->count() > 0)
                <!-- Org Chart -->
                <div class="max-w-6xl mx-auto">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach($strukturOrganisasi as $index => $struktur)
                            <div class="card-profil rounded-2xl overflow-hidden shadow-xl hover-profil-primary transition-all duration-300 animate-on-scroll" style="animation-delay: {{ $index * 0.1 }}s">
                                <!-- Photo -->
                                <div class="relative h-64 bg-gradient-to-br from-cyan-100 to-blue-100">
                                    @if($struktur->foto_url)
                                        <img src="{{ asset('storage/' . $struktur->foto_url) }}" 
                                             alt="{{ $struktur->nama }}"
                                             class="w-full h-full object-cover">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center">
                                            <div class="w-24 h-24 bg-profil-primary rounded-full flex items-center justify-center">
                                                <span class="text-3xl text-white">👤</span>
                                            </div>
                                        </div>
                                    @endif
                                    
                                    <!-- Overlay -->
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                                </div>
                                
                                <!-- Content -->
                                <div class="p-6">
                                    <h3 class="text-xl font-bold text-heading mb-2">{{ $struktur->nama }}</h3>
                                    <p class="text-profil-primary font-semibold mb-3">{{ $struktur->jabatan }}</p>
                                    
                                    @if($struktur->keterangan)
                                        <p class="text-sm text-body line-clamp-3 mb-4">{{ $struktur->keterangan }}</p>
                                    @endif
                                    
                                    <!-- Contact Info - fields not available in current schema -->
                                    <div class="space-y-2 text-sm">
                                        <div class="flex items-center space-x-2 text-body">
                                            <span>👤</span>
                                            <span>{{ $struktur->jabatan }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <!-- Placeholder jika belum ada data -->
                <div class="text-center py-16">
                    <div class="card-profil rounded-3xl p-12 max-w-2xl mx-auto">
                        <div class="text-8xl mb-6">👥</div>
                        <h3 class="text-3xl font-bold text-heading mb-4">Struktur Organisasi</h3>
                        <p class="text-lg text-body mb-8">Data struktur organisasi akan segera ditampilkan di sini</p>
                        <div class="bg-gradient-to-r from-cyan-50 to-blue-50 rounded-2xl p-6">
                            <p class="text-body">Silakan hubungi admin untuk memperbarui informasi struktur organisasi</p>
                        </div>
                    </div>
                </div>
            @endif
        </section>

        <!-- Section 3: Potensi Desa -->
        <section id="potensi-desa" class="mb-24">
            <div class="text-center mb-16">
                <h2 class="text-4xl lg:text-5xl font-bold text-heading mb-4">
                    🌾 Potensi Desa
                </h2>
                <div class="section-divider"></div>
                <p class="text-lg text-body max-w-3xl mx-auto">
                    Berbagai potensi dan kekayaan yang dimiliki Desa Banyukambang sebagai modal pembangunan
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Potensi Sumber Daya Alam -->
                <div class="card-profil rounded-3xl p-8 shadow-xl hover-profil-primary transition-all duration-300">
                    <div class="text-center mb-6">
                        <div class="w-20 h-20 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-4">
                            <span class="text-3xl text-white">🌾</span>
                        </div>
                        <h3 class="text-2xl font-bold text-heading">Sumber Daya Alam</h3>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="bg-green-50 rounded-xl p-4">
                            <h4 class="font-semibold text-heading mb-2">Lahan Pertanian: 100 ha</h4>
                            <p class="text-sm text-body">Lahan produktif untuk budidaya padi dan palawija</p>
                        </div>
                        
                        <div class="bg-green-50 rounded-xl p-4">
                            <h4 class="font-semibold text-heading mb-2">Lahan Perkebunan: 13 ha</h4>
                            <p class="text-sm text-body">Kebun kelapa, cengkeh, dan tanaman keras</p>
                        </div>
                        
                        <div class="bg-green-50 rounded-xl p-4">
                            <h4 class="font-semibold text-heading mb-2">Lahan Perkantoran: 0,12 ha</h4>
                            <p class="text-sm text-body">Area pemerintahan dan pelayanan publik</p>
                        </div>
                        
                        <div class="bg-green-50 rounded-xl p-4">
                            <h4 class="font-semibold text-heading mb-2">Lapangan Olahraga: 0,25 ha</h4>
                            <p class="text-sm text-body">Fasilitas olahraga dan kegiatan masyarakat</p>
                        </div>
                    </div>
                </div>

                <!-- Potensi Sumber Daya Manusia -->
                <div class="card-profil rounded-3xl p-8 shadow-xl hover-profil-primary transition-all duration-300">
                    <div class="text-center mb-6">
                        <div class="w-20 h-20 bg-blue-500 rounded-full flex items-center justify-center mx-auto mb-4">
                            <span class="text-3xl text-white">👥</span>
                        </div>
                        <h3 class="text-2xl font-bold text-heading">Sumber Daya Manusia</h3>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="bg-blue-50 rounded-xl p-4">
                            <h4 class="font-semibold text-heading mb-2">Penduduk Laki-laki: 814 orang</h4>
                            <p class="text-sm text-body">Sebagian besar berusia produktif</p>
                        </div>
                        
                        <div class="bg-blue-50 rounded-xl p-4">
                            <h4 class="font-semibold text-heading mb-2">Penduduk Perempuan: 883 orang</h4>
                            <p class="text-sm text-body">Berperan aktif dalam pembangunan</p>
                        </div>
                        
                        <div class="bg-blue-50 rounded-xl p-4">
                            <h4 class="font-semibold text-heading mb-2">Jumlah KK: 658 kepala keluarga</h4>
                            <p class="text-sm text-body">Total keluarga di seluruh desa</p>
                        </div>
                        
                        <div class="bg-blue-50 rounded-xl p-4">
                            <h4 class="font-semibold text-heading mb-2">Tenaga Kerja Pertanian: 305 orang</h4>
                            <p class="text-sm text-body">Penghasilan utama dari sektor pertanian</p>
                        </div>
                    </div>
                </div>

                <!-- Potensi Pendidikan -->
                <div class="card-profil rounded-3xl p-8 shadow-xl hover-profil-primary transition-all duration-300">
                    <div class="text-center mb-6">
                        <div class="w-20 h-20 bg-purple-500 rounded-full flex items-center justify-center mx-auto mb-4">
                            <span class="text-3xl text-white">🎓</span>
                        </div>
                        <h3 class="text-2xl font-bold text-heading">Tingkat Pendidikan</h3>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="bg-purple-50 rounded-xl p-4">
                            <h4 class="font-semibold text-heading mb-2">Lulusan S-1, S-2: 89 orang</h4>
                            <p class="text-sm text-body">Sarjana yang berkontribusi pada pembangunan</p>
                        </div>
                        
                        <div class="bg-purple-50 rounded-xl p-4">
                            <h4 class="font-semibold text-heading mb-2">Lulusan SLTA: 445 orang</h4>
                            <p class="text-sm text-body">Tenaga kerja siap pakai</p>
                        </div>
                        
                        <div class="bg-purple-50 rounded-xl p-4">
                            <h4 class="font-semibold text-heading mb-2">Lulusan SLTP: 250 orang</h4>
                            <p class="text-sm text-body">Generasi muda yang potensial</p>
                        </div>
                        
                        <div class="bg-purple-50 rounded-xl p-4">
                            <h4 class="font-semibold text-heading mb-2">Lulusan SD/MI: 288 orang</h4>
                            <p class="text-sm text-body">Dasar pendidikan yang solid</p>
                        </div>
                    </div>
                </div>

                <!-- Potensi Pekerja Profesional -->
                <div class="card-profil rounded-3xl p-8 shadow-xl hover-profil-primary transition-all duration-300">
                    <div class="text-center mb-6">
                        <div class="w-20 h-20 bg-orange-500 rounded-full flex items-center justify-center mx-auto mb-4">
                            <span class="text-3xl text-white">💼</span>
                        </div>
                        <h3 class="text-2xl font-bold text-heading">Pekerja Profesional</h3>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="bg-orange-50 rounded-xl p-4">
                            <h4 class="font-semibold text-heading mb-2">Buruh Tani: 25 orang</h4>
                            <p class="text-sm text-body">Tenaga kerja di sektor pertanian</p>
                        </div>
                        
                        <div class="bg-orange-50 rounded-xl p-4">
                            <h4 class="font-semibold text-heading mb-2">Perdagangan: 4 orang</h4>
                            <p class="text-sm text-body">Penggerak ekonomi lokal</p>
                        </div>
                        
                        <div class="bg-orange-50 rounded-xl p-4">
                            <h4 class="font-semibold text-heading mb-2">Jasa: 25 orang</h4>
                            <p class="text-sm text-body">Berbagai layanan masyarakat</p>
                        </div>
                        
                        <div class="bg-orange-50 rounded-xl p-4">
                            <h4 class="font-semibold text-heading mb-2">PNS/TNI/POLRI: 37 orang</h4>
                            <p class="text-sm text-body">Aparatur negara dan keamanan</p>
                        </div>
                    </div>
                </div>

                <!-- Potensi Fasilitas Umum -->
                <div class="card-profil rounded-3xl p-8 shadow-xl hover-profil-primary transition-all duration-300">
                    <div class="text-center mb-6">
                        <div class="w-20 h-20 bg-teal-500 rounded-full flex items-center justify-center mx-auto mb-4">
                            <span class="text-3xl text-white">🏫</span>
                        </div>
                        <h3 class="text-2xl font-bold text-heading">Fasilitas Umum</h3>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="bg-teal-50 rounded-xl p-4">
                            <h4 class="font-semibold text-heading mb-2">Tempat Pendidikan: 0,20 ha</h4>
                            <p class="text-sm text-body">Sekolah untuk melayani pendidikan anak</p>
                        </div>
                        
                        <div class="bg-teal-50 rounded-xl p-4">
                            <h4 class="font-semibold text-heading mb-2">Pemakaman Umum: 0,38 ha</h4>
                            <p class="text-sm text-body">Area pemakaman untuk masyarakat</p>
                        </div>
                        
                        <div class="bg-teal-50 rounded-xl p-4">
                            <h4 class="font-semibold text-heading mb-2">Tidak Tamat SD: 325 orang</h4>
                            <p class="text-sm text-body">Potensi untuk program pendidikan</p>
                        </div>
                        
                        <div class="bg-teal-50 rounded-xl p-4">
                            <h4 class="font-semibold text-heading mb-2">Tidak Sekolah: 300 orang</h4>
                            <p class="text-sm text-body">Target program literasi dan pendidikan</p>
                        </div>
                    </div>
                </div>

                <!-- Ringkasan Statistik -->
                <div class="card-profil rounded-3xl p-8 shadow-xl hover-profil-primary transition-all duration-300">
                    <div class="text-center mb-6">
                        <div class="w-20 h-20 bg-indigo-500 rounded-full flex items-center justify-center mx-auto mb-4">
                            <span class="text-3xl text-white">📊</span>
                        </div>
                        <h3 class="text-2xl font-bold text-heading">Ringkasan Potensi</h3>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="bg-indigo-50 rounded-xl p-4">
                            <h4 class="font-semibold text-heading mb-2">Total Luas Wilayah: 113,87 ha</h4>
                            <p class="text-sm text-body">Kombinasi lahan produktif dan fasilitas</p>
                        </div>
                        
                        <div class="bg-indigo-50 rounded-xl p-4">
                            <h4 class="font-semibold text-heading mb-2">Total Penduduk: 1.697 jiwa</h4>
                            <p class="text-sm text-body">Kekuatan SDM untuk pembangunan</p>
                        </div>
                        
                        <div class="bg-indigo-50 rounded-xl p-4">
                            <h4 class="font-semibold text-heading mb-2">Sektor Utama: Pertanian</h4>
                            <p class="text-sm text-body">Basis ekonomi masyarakat desa</p>
                        </div>
                        
                        <div class="bg-indigo-50 rounded-xl p-4">
                            <h4 class="font-semibold text-heading mb-2">Potensi Pengembangan: Tinggi</h4>
                            <p class="text-sm text-body">Berbagai sektor dapat dikembangkan</p>
                        </div>
                    </div>
                </div>
            </div>
        </section>

        <!-- Section 4: Peta Desa -->
        <section id="peta-desa" class="mb-24">
            <div class="text-center mb-16">
                <h2 class="text-4xl lg:text-5xl font-bold text-heading mb-4">
                    🗺️ Peta Desa Banyukambang
                </h2>
                <div class="section-divider"></div>
                <p class="text-lg text-body max-w-3xl mx-auto">
                    Lokasi geografis dan batas wilayah Desa Banyukambang dengan fasilitas dan landmark penting
                </p>
            </div>

            <!-- Maps Container -->
            <div class="card-profil rounded-3xl overflow-hidden shadow-2xl">
                <!-- Maps Header -->
                <div class="bg-gradient-to-r from-cyan-500 to-blue-600 p-6 text-white">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                        <div>
                            <h3 class="text-2xl font-bold mb-2">📍 Lokasi Desa Banyukambang</h3>
                            <p class="text-cyan-100">Kecamatan Wonoasri, Kabupaten Madiun, Jawa Timur</p>
                        </div>
                        <div class="mt-4 lg:mt-0">
                            <div class="flex flex-wrap gap-3">
                                <span class="px-3 py-1 bg-white/20 rounded-full text-sm">Lihat Peta Lengkap</span>
                                <span class="px-3 py-1 bg-white/20 rounded-full text-sm">Google Maps</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Interactive Map -->
                <div class="relative">
                    <div id="google-map" class="w-full rounded-lg overflow-hidden shadow-lg">
                        <!-- Google Maps Embed -->
                        <iframe
                            src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d6490.213136885581!2d111.61038091419914!3d-7.566344995919133!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e79c77e54572b49%3A0xfe8dd17be060f69a!2sBanyukambang%2C%20Kec.%20Wonoasri%2C%20Kabupaten%20Madiun%2C%20Jawa%20Timur!5e1!3m2!1sid!2sid!4v1763516050934!5m2!1sid!2sid"
                            width="100%"
                            height="480"
                            style="border:0;"
                            allowfullscreen=""
                            loading="lazy"
                            referrerpolicy="no-referrer-when-downgrade"
                            title="Peta Desa Banyukambang">
                        </iframe>
                    </div>
                    
                    <!-- Map Info Overlay -->
                    <div class="absolute bottom-4 left-4 bg-white/95 backdrop-blur-sm rounded-lg shadow-lg p-3 max-w-xs">
                        <div class="text-sm">
                            <p class="font-semibold text-heading">📍 Desa Banyukambang</p>
                            <p class="text-body">Kec. Wonoasri, Kab. Madiun</p>
                            <p class="text-body">Jawa Timur, Indonesia</p>
                        </div>
                    </div>
                </div>

                <!-- Map Info -->
                <div class="p-6 bg-profil-bg">
                    <div class="text-center">
                        <h4 class="text-lg font-bold text-heading mb-2">🗺️ Peta Desa Banyukambang</h4>
                        <p class="text-body text-sm">Lokasi: Kecamatan Wonoasri, Kabupaten Madiun, Jawa Timur</p>
                        <div class="mt-4">
                            <a href="{{ route('profil-desa.peta-desa') }}" 
                               class="inline-flex items-center space-x-2 bg-profil-primary text-white px-4 py-2 rounded-lg text-sm hover:bg-cyan-600 transition-colors">
                                <span>🔍</span>
                                <span>Lihat Peta Lengkap</span>
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- <!-- Geographical Info -->
            <div class="grid grid-cols-1 lg:grid-cols-3 gap-8 mt-12">
                <!-- Batas Wilayah -->
                <div class="card-profil rounded-2xl p-8 shadow-xl">
                    <div class="text-center mb-6">
                        <div class="w-16 h-16 bg-profil-primary rounded-full flex items-center justify-center mx-auto mb-4">
                            <span class="text-2xl text-white">🧭</span>
                        </div>
                        <h3 class="text-xl font-bold text-heading">Batas Wilayah</h3>
                    </div>
                    
                    <div class="space-y-3 text-sm">
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <span class="font-medium">Utara:</span>
                            <span class="text-body">Desa Wonoasri</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <span class="font-medium">Selatan:</span>
                            <span class="text-body">Desa Gunungsari</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <span class="font-medium">Timur:</span>
                            <span class="text-body">Desa Kebonsari</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <span class="font-medium">Barat:</span>
                            <span class="text-body">Desa Bancong</span>
                        </div>
                    </div>
                </div>

                <!-- Data Geografis -->
                <div class="card-profil rounded-2xl p-8 shadow-xl">
                    <div class="text-center mb-6">
                        <div class="w-16 h-16 bg-profil-primary rounded-full flex items-center justify-center mx-auto mb-4">
                            <span class="text-2xl text-white">📊</span>
                        </div>
                        <h3 class="text-xl font-bold text-heading">Data Geografis</h3>
                    </div>
                    
                    <div class="space-y-3 text-sm">
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <span class="font-medium">Luas Total:</span>
                            <span class="text-body">8.5 km²</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <span class="font-medium">Ketinggian:</span>
                            <span class="text-body">95 mdpl</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <span class="font-medium">Lokasi:</span>
                            <span class="text-body">Wonoasri, Madiun</span>
                        </div>
                        <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                            <span class="font-medium">Provinsi:</span>
                            <span class="text-body">Jawa Timur</span>
                        </div>
                    </div>
                </div>

                <!-- Akses Transportasi -->
                <div class="card-profil rounded-2xl p-8 shadow-xl">
                    <div class="text-center mb-6">
                        <div class="w-16 h-16 bg-profil-primary rounded-full flex items-center justify-center mx-auto mb-4">
                            <span class="text-2xl text-white">🚌</span>
                        </div>
                        <h3 class="text-xl font-bold text-heading">Akses Transportasi</h3>
                    </div>
                    
                    <div class="space-y-3 text-sm">
                        <div class="p-3 bg-gray-50 rounded-lg">
                            <div class="font-medium mb-1">🚗 Jalan Raya</div>
                            <div class="text-body">Jarak ke kota: 15 km</div>
                        </div>
                        <div class="p-3 bg-gray-50 rounded-lg">
                            <div class="font-medium mb-1">🚌 Angkutan Umum</div>
                            <div class="text-body">Bus dan angkot tersedia</div>
                        </div>
                        <div class="p-3 bg-gray-50 rounded-lg">
                            <div class="font-medium mb-1">🛣️ Infrastruktur</div>
                            <div class="text-body">Jalan beraspal 80%</div>
                        </div>
                        <div class="p-3 bg-gray-50 rounded-lg">
                            <div class="font-medium mb-1">🏍️ Ojek Online</div>
                            <div class="text-body">Area coverage tersedia</div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div> --}}

<!-- Back to Top Button -->
<button id="backToTop" class="fixed bottom-8 right-8 w-12 h-12 bg-profil-primary text-white rounded-full shadow-2xl hover:bg-cyan-600 transition-all duration-300 opacity-0 pointer-events-none">
    <span class="text-xl">↑</span>
</button>
@endsection

@push('styles')
<style>
/* Custom styles untuk profil desa */
.section-bg-profil {
    background: linear-gradient(135deg, #0891b2 0%, #0e7490 50%, #155e75 100%);
    position: relative;
    z-index: 1;
}

.card-profil {
    background: rgba(255, 255, 255, 0.95);
    backdrop-filter: blur(10px);
    border: 1px solid rgba(8, 145, 178, 0.1);
    position: relative;
    z-index: 2;
}

/* Ensure all content is visible */
main {
    position: relative;
    z-index: 1;
}

body {
    overflow-x: hidden;
    overflow-y: auto;
}

.text-profil-primary {
    color: #0891b2;
}

.bg-profil-primary {
    background-color: #0891b2;
}

.text-profil-accent {
    color: #0e7490;
}

.bg-profil-accent {
    background-color: #0e7490;
}

.bg-profil-bg {
    background-color: #f8fafc;
}

.text-heading {
    color: #1e293b;
}

.text-body {
    color: #64748b;
}

/* Section dividers */
.section-divider {
    position: relative;
    width: 80px;
    height: 4px;
    background: linear-gradient(90deg, #0891b2, #0e7490);
    margin: 0 auto 1.5rem;
    border-radius: 2px;
}

.section-divider::before {
    content: '';
    position: absolute;
    top: 0;
    left: -20px;
    width: 100%;
    height: 100%;
    background: linear-gradient(90deg, transparent, #0891b2, transparent);
    animation: shimmer 2s infinite;
}

@keyframes shimmer {
    0% { left: -100%; }
    100% { left: 100%; }
}

/* Card hover effects */
.hover-profil-primary:hover {
    transform: translateY(-8px);
    box-shadow: 0 25px 50px -12px rgba(8, 145, 178, 0.25);
}

/* Animation classes - Fixed visibility */
.animate-on-scroll {
    opacity: 1 !important; /* Force visibility */
    transform: translateY(0) !important; /* Remove transform */
    transition: all 0.8s ease-out;
}

.animate-on-scroll.in-view {
    opacity: 1;
    transform: translateY(0);
}

.stagger-1 { transition-delay: 0.1s; }
.stagger-2 { transition-delay: 0.2s; }
.stagger-3 { transition-delay: 0.3s; }
.stagger-4 { transition-delay: 0.4s; }
.stagger-5 { transition-delay: 0.5s; }
.stagger-6 { transition-delay: 0.6s; }

/* Responsive adjustments */
@media (max-width: 768px) {
    .hero-title {
        font-size: 2.5rem;
    }
    
    .section-padding {
        padding: 3rem 0;
    }
}
</style>
@endpush

@push('scripts')
<script>
// Back to top functionality
window.addEventListener('scroll', function() {
    const backToTop = document.getElementById('backToTop');
    if (window.pageYOffset > 300) {
        backToTop.style.opacity = '1';
        backToTop.style.pointerEvents = 'auto';
    } else {
        backToTop.style.opacity = '0';
        backToTop.style.pointerEvents = 'none';
    }
});

document.getElementById('backToTop').addEventListener('click', function() {
    window.scrollTo({
        top: 0,
        behavior: 'smooth'
    });
});

// Maps functionality placeholder
function loadMap() {
    // Placeholder untuk inisialisasi Google Maps
    const mapContainer = document.getElementById('map');
    mapContainer.innerHTML = `
        <div class="w-full h-full bg-gradient-to-br from-blue-100 to-green-100 flex items-center justify-center">
            <div class="text-center">
                <div class="text-6xl mb-4">🗺️</div>
                <h4 class="text-xl font-bold text-heading mb-2">Peta Sedang Dimuat</h4>
                <p class="text-body">Integrasi dengan Google Maps akan ditambahkan di sini</p>
            </div>
        </div>
    `;
    
    // TODO: Implementasi Google Maps API
    // const map = new google.maps.Map(mapContainer, {
    //     center: { lat: -7.4347, lng: 109.2912 },
    //     zoom: 15
    // });
}

function zoomIn() {
    console.log('Zoom in');
    // TODO: Implementasi zoom in
}

function zoomOut() {
    console.log('Zoom out');
    // TODO: Implementasi zoom out
}
</script>
@endpush