@extends('frontend.layouts.main')

@section('title', 'Profil Desa - Desa Ngengor')

@section('content')
@php
    // Fallback: Init variabel jika tidak dikirim dari controller untuk menghindari error
    if (!isset($strukturOrganisasi)) $strukturOrganisasi = collect();
    
    // Default values untuk stats jika belum ada (menghindari error undefined index)
    $sdmStats = $sdmStats ?? ['laki_laki' => 0, 'perempuan' => 0, 'kk' => 0];
    $pekerjaanStats = $pekerjaanStats ?? ['pertanian' => 0, 'buruh_tani' => 0, 'perdagangan' => 0, 'jasa' => 0, 'pns_tni' => 0, 'wiraswasta' => 0, 'pegawai_swasta' => 0, 'belum_bekerja' => 0];
    $pendidikanStats = $pendidikanStats ?? ['sarjana' => 0, 'slta' => 0, 'sltp' => 0, 'sd' => 0, 'tidak_tamat' => 0, 'tidak_sekolah' => 0];
@endphp

<div class="section-bg-profil py-16">
    <div class="container mx-auto px-4 lg:px-8">
        <div class="text-center text-white">
            <h1 class="text-5xl lg:text-6xl font-bold mb-6 animate-on-scroll">
                🏘️ Profil Desa Ngengor
            </h1>
            <p class="text-xl lg:text-2xl mb-8 max-w-4xl mx-auto leading-relaxed animate-on-scroll stagger-1">
                Mengenal lebih dekat dengan Desa Ngengor, Pilangkenceng, Madiun - dari visi misi, struktur organisasi, 
                potensi desa hingga peta wilayah lengkap
            </p>
            
            <div class="flex flex-wrap justify-center gap-4 animate-on-scroll stagger-2">
                <a href="#visi-misi" class="bg-white/20 hover:bg-white/30 px-6 py-3 rounded-full font-medium transition-all hover:scale-105 backdrop-blur-sm border border-white/10">
                    🎯 Visi & Misi
                </a>
                <a href="#struktur-organisasi" class="bg-white/20 hover:bg-white/30 px-6 py-3 rounded-full font-medium transition-all hover:scale-105 backdrop-blur-sm border border-white/10">
                    👥 Struktur Organisasi
                </a>
                <a href="#potensi-desa" class="bg-white/20 hover:bg-white/30 px-6 py-3 rounded-full font-medium transition-all hover:scale-105 backdrop-blur-sm border border-white/10">
                    🌾 Potensi Desa
                </a>
                <a href="#peta-desa" class="bg-white/20 hover:bg-white/30 px-6 py-3 rounded-full font-medium transition-all hover:scale-105 backdrop-blur-sm border border-white/10">
                    🗺️ Peta Desa
                </a>
            </div>
        </div>
    </div>
</div>

<div class="py-16 bg-slate-50">
    <div class="container mx-auto px-4 lg:px-8">
        
        <section id="visi-misi" class="mb-24 scroll-mt-24">
            <div class="text-center mb-16">
                <h2 class="text-4xl lg:text-5xl font-bold text-heading mb-4">
                    🎯 Visi & Misi Desa
                </h2>
                <div class="section-divider"></div>
                <p class="text-lg text-body max-w-3xl mx-auto">
                    Landasan filosofis dan arah pengembangan Desa Ngengor menuju masa depan yang lebih sejahtera
                </p>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-12">
                <div class="card-profil rounded-3xl p-8 lg:p-12 shadow-xl hover:shadow-2xl transition-shadow duration-300">
                    <div class="text-center mb-8">
                        <div class="w-20 h-20 bg-profil-primary rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg shadow-cyan-500/30">
                            <span class="text-3xl text-white">🎯</span>
                        </div>
                        <h3 class="text-3xl font-bold text-heading">VISI</h3>
                    </div>
                    
                    <div class="bg-gradient-to-br from-cyan-50 to-blue-50 rounded-2xl p-8 text-center border border-cyan-100">
                        <blockquote class="text-xl lg:text-2xl font-semibold text-heading leading-relaxed italic">
                            "MEMBANGUN DESA NGENGOR LEBIH MAJU, MANDIRI, SEJAHTERA, SEHAT, AMAN, BERAHLAK MULIA DENGAN MENJUNJUNG TRANSPARANSI"
                        </blockquote>
                    </div>
                </div>

                <div class="card-profil rounded-3xl p-8 lg:p-12 shadow-xl hover:shadow-2xl transition-shadow duration-300">
                    <div class="text-center mb-8">
                        <div class="w-20 h-20 bg-profil-primary rounded-full flex items-center justify-center mx-auto mb-4 shadow-lg shadow-cyan-500/30">
                            <span class="text-3xl text-white">🚀</span>
                        </div>
                        <h3 class="text-3xl font-bold text-heading">MISI</h3>
                    </div>
                    
                    <div class="space-y-4">
                        @php
                            $misiList = [
                                'Meningkatkan kualitas sumber daya manusia (SDM)',
                                'Menumbuh kembangkan potensi asli desa',
                                'Meningkatkan taraf hidup masyarakat dengan ekonomi lemah',
                                'Meningkatkan pembangunan infrastruktur',
                                'Meningkatkan derajat kesehatan masyarakat',
                                'Meningkatkan bidang keamanan dan ketertiban'
                            ];
                        @endphp

                        @foreach($misiList as $index => $misi)
                        <div class="flex items-start space-x-4 p-4 bg-white hover:bg-cyan-50 rounded-xl transition-colors border border-gray-100 hover:border-cyan-100">
                            <div class="w-8 h-8 bg-profil-primary text-white rounded-full flex items-center justify-center font-bold flex-shrink-0 text-sm">
                                {{ $index + 1 }}
                            </div>
                            <p class="text-body font-medium pt-1">{{ $misi }}</p>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </section>

        <section id="struktur-organisasi" class="mb-24 scroll-mt-24">
            <div class="text-center mb-16">
                <h2 class="text-4xl lg:text-5xl font-bold text-heading mb-4">
                    👥 Struktur Organisasi
                </h2>
                <div class="section-divider"></div>
                <p class="text-lg text-body max-w-3xl mx-auto">
                    Susunan organisasi pemerintahan Desa Ngengor dengan tugas dan fungsi masing-masing
                </p>
            </div>

            @if($strukturOrganisasi->count() > 0)
                <div class="max-w-6xl mx-auto">
                    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                        @foreach($strukturOrganisasi as $index => $struktur)
                            <div class="card-profil rounded-2xl overflow-hidden shadow-lg hover-profil-primary transition-all duration-300 group">
                                <div class="relative h-80 bg-gradient-to-br from-cyan-100 to-blue-100 overflow-hidden">
                                    @if($struktur->foto || $struktur->image || $struktur->foto_url)
                                        <img src="{{ asset('storage/' . ($struktur->foto ?? $struktur->image ?? $struktur->foto_url)) }}" 
                                             alt="{{ $struktur->nama }}"
                                             class="w-full h-full object-cover object-top group-hover:scale-105 transition-transform duration-500">
                                    @else
                                        <div class="w-full h-full flex items-center justify-center bg-gray-200">
                                            <div class="w-24 h-24 bg-white/50 rounded-full flex items-center justify-center backdrop-blur-sm">
                                                <span class="text-4xl text-profil-primary">👤</span>
                                            </div>
                                        </div>
                                    @endif
                                    
                                    <div class="absolute inset-0 bg-gradient-to-t from-black/70 via-transparent to-transparent opacity-80"></div>
                                    
                                    <div class="absolute bottom-0 left-0 right-0 p-6 text-white">
                                        <h3 class="text-xl font-bold mb-1">{{ $struktur->nama }}</h3>
                                        <p class="text-cyan-300 font-medium tracking-wide text-sm uppercase">{{ $struktur->jabatan }}</p>
                                    </div>
                                </div>
                                
                                @if($struktur->keterangan)
                                <div class="p-5 bg-white border-t border-gray-100">
                                    <p class="text-sm text-body line-clamp-3">{{ $struktur->keterangan }}</p>
                                </div>
                                @endif
                            </div>
                        @endforeach
                    </div>
                </div>
            @else
                <div class="text-center py-16 bg-white rounded-3xl shadow-sm border border-gray-100">
                    <div class="w-24 h-24 bg-gray-100 rounded-full flex items-center justify-center mx-auto mb-6">
                        <span class="text-4xl text-gray-400">👥</span>
                    </div>
                    <h3 class="text-2xl font-bold text-gray-800 mb-2">Belum Ada Data</h3>
                    <p class="text-gray-500">Data struktur organisasi akan segera diperbarui.</p>
                </div>
            @endif
        </section>

        <section id="potensi-desa" class="mb-24 scroll-mt-24">
            <div class="text-center mb-16">
                <h2 class="text-4xl lg:text-5xl font-bold text-heading mb-4">
                    🌾 Potensi Desa
                </h2>
                <div class="section-divider"></div>
                <p class="text-lg text-body max-w-3xl mx-auto">
                    Berbagai potensi dan kekayaan yang dimiliki Desa Ngengor sebagai modal pembangunan
                </p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                
                <div class="card-profil rounded-3xl p-8 shadow-xl hover-profil-primary transition-all duration-300 border-t-4 border-green-500">
                    <div class="text-center mb-6">
                        <div class="w-20 h-20 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <span class="text-3xl">🌾</span>
                        </div>
                        <h3 class="text-2xl font-bold text-heading">Sumber Daya Alam</h3>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="bg-green-50 rounded-xl p-4 border border-green-100">
                            <h4 class="font-semibold text-heading mb-1">Lahan Pertanian: 100 ha</h4>
                            <p class="text-sm text-body">Lahan produktif padi & palawija</p>
                        </div>
                        <div class="bg-green-50 rounded-xl p-4 border border-green-100">
                            <h4 class="font-semibold text-heading mb-1">Lahan Perkebunan: 13 ha</h4>
                            <p class="text-sm text-body">Kebun kelapa & tanaman keras</p>
                        </div>
                        <div class="bg-green-50 rounded-xl p-4 border border-green-100">
                            <h4 class="font-semibold text-heading mb-1">Fasilitas: 0,37 ha</h4>
                            <p class="text-sm text-body">Perkantoran & Lapangan Olahraga</p>
                        </div>
                    </div>
                </div>

                <div class="card-profil rounded-3xl p-8 shadow-xl hover-profil-primary transition-all duration-300 border-t-4 border-blue-500">
                    <div class="text-center mb-6">
                        <div class="w-20 h-20 bg-blue-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <span class="text-3xl">👥</span>
                        </div>
                        <h3 class="text-2xl font-bold text-heading">Sumber Daya Manusia</h3>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="bg-blue-50 rounded-xl p-4 border border-blue-100">
                            <h4 class="font-semibold text-heading mb-1">Laki-laki: {{ number_format($sdmStats['laki_laki']) }} jiwa</h4>
                            <p class="text-sm text-body">Populasi penduduk laki-laki</p>
                        </div>
                        <div class="bg-blue-50 rounded-xl p-4 border border-blue-100">
                            <h4 class="font-semibold text-heading mb-1">Perempuan: {{ number_format($sdmStats['perempuan']) }} jiwa</h4>
                            <p class="text-sm text-body">Populasi penduduk perempuan</p>
                        </div>
                        <div class="bg-blue-50 rounded-xl p-4 border border-blue-100">
                            <h4 class="font-semibold text-heading mb-1">Total KK: {{ number_format($sdmStats['kk']) }} Keluarga</h4>
                            <p class="text-sm text-body">Jumlah Kepala Keluarga</p>
                        </div>
                    </div>
                </div>

                <div class="card-profil rounded-3xl p-8 shadow-xl hover-profil-primary transition-all duration-300 border-t-4 border-purple-500">
                    <div class="text-center mb-6">
                        <div class="w-20 h-20 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <span class="text-3xl">🎓</span>
                        </div>
                        <h3 class="text-2xl font-bold text-heading">Tingkat Pendidikan</h3>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="bg-purple-50 rounded-xl p-4 border border-purple-100">
                            <h4 class="font-semibold text-heading mb-1">Perguruan Tinggi: {{ number_format($pendidikanStats['sarjana']) }}</h4>
                            <p class="text-sm text-body">Lulusan Diploma, S1, S2, S3</p>
                        </div>
                        <div class="bg-purple-50 rounded-xl p-4 border border-purple-100">
                            <h4 class="font-semibold text-heading mb-1">Menengah (SMA/SMP): {{ number_format($pendidikanStats['slta'] + $pendidikanStats['sltp']) }}</h4>
                            <p class="text-sm text-body">Lulusan SMA/SMK dan SMP/Mts</p>
                        </div>
                        <div class="bg-purple-50 rounded-xl p-4 border border-purple-100">
                            <h4 class="font-semibold text-heading mb-1">Dasar (SD): {{ number_format($pendidikanStats['sd']) }}</h4>
                            <p class="text-sm text-body">Lulusan Sekolah Dasar/MI</p>
                        </div>
                    </div>
                </div>

                <div class="card-profil rounded-3xl p-8 shadow-xl hover-profil-primary transition-all duration-300 border-t-4 border-orange-500">
                    <div class="text-center mb-6">
                        <div class="w-20 h-20 bg-orange-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <span class="text-3xl">💼</span>
                        </div>
                        <h3 class="text-2xl font-bold text-heading">Sektor Pekerjaan</h3>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="bg-orange-50 rounded-xl p-4 border border-orange-100">
                            <h4 class="font-semibold text-heading mb-1">Petani: {{ number_format($pekerjaanStats['pertanian']) }} orang</h4>
                            <p class="text-sm text-body">Sektor pertanian & perkebunan</p>
                        </div>
                        <div class="bg-orange-50 rounded-xl p-4 border border-orange-100">
                            <h4 class="font-semibold text-heading mb-1">Wiraswasta: {{ number_format($pekerjaanStats['wiraswasta']) }} orang</h4>
                            <p class="text-sm text-body">Pedagang & pengusaha mandiri</p>
                        </div>
                        <div class="bg-orange-50 rounded-xl p-4 border border-orange-100">
                            <h4 class="font-semibold text-heading mb-1">Pegawai Swasta: {{ number_format($pekerjaanStats['pegawai_swasta']) }} orang</h4>
                            <p class="text-sm text-body">Karyawan perusahaan swasta</p>
                        </div>
                        <div class="bg-orange-50 rounded-xl p-4 border border-orange-100">
                            <h4 class="font-semibold text-heading mb-1">Belum Bekerja: {{ number_format($pekerjaanStats['belum_bekerja']) }} orang</h4>
                            <p class="text-sm text-body">Sedang mencari pekerjaan</p>
                        </div>
                    </div>
                </div>

                <div class="card-profil rounded-3xl p-8 shadow-xl hover-profil-primary transition-all duration-300 border-t-4 border-teal-500">
                    <div class="text-center mb-6">
                        <div class="w-20 h-20 bg-teal-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <span class="text-3xl">🏫</span>
                        </div>
                        <h3 class="text-2xl font-bold text-heading">Fasilitas Umum</h3>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="bg-teal-50 rounded-xl p-4 border border-teal-100">
                            <h4 class="font-semibold text-heading mb-1">Pendidikan: 0,20 ha</h4>
                            <p class="text-sm text-body">Sekolah & sarana belajar</p>
                        </div>
                        <div class="bg-teal-50 rounded-xl p-4 border border-teal-100">
                            <h4 class="font-semibold text-heading mb-1">Pemakaman: 0,38 ha</h4>
                            <p class="text-sm text-body">Area pemakaman umum</p>
                        </div>
                        <div class="bg-teal-50 rounded-xl p-4 border border-teal-100">
                            <h4 class="font-semibold text-heading mb-1">Masjid/Musholla</h4>
                            <p class="text-sm text-body">Sarana ibadah masyarakat</p>
                        </div>
                    </div>
                </div>

                <div class="card-profil rounded-3xl p-8 shadow-xl hover-profil-primary transition-all duration-300 border-t-4 border-indigo-500">
                    <div class="text-center mb-6">
                        <div class="w-20 h-20 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-4">
                            <span class="text-3xl">📊</span>
                        </div>
                        <h3 class="text-2xl font-bold text-heading">Ringkasan Potensi</h3>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="bg-indigo-50 rounded-xl p-4 border border-indigo-100">
                            <h4 class="font-semibold text-heading mb-1">Total Wilayah: 113,87 ha</h4>
                            <p class="text-sm text-body">Luas wilayah administratif</p>
                        </div>
                        
                        <div class="bg-indigo-50 rounded-xl p-4 border border-indigo-100">
                            <h4 class="font-semibold text-heading mb-1">Penduduk: {{ number_format($sdmStats['laki_laki'] + $sdmStats['perempuan']) }} jiwa</h4>
                            <p class="text-sm text-body">Total populasi saat ini</p>
                        </div>
                        
                        <div class="bg-indigo-50 rounded-xl p-4 border border-indigo-100">
                            <h4 class="font-semibold text-heading mb-1">Sektor Utama: Pertanian</h4>
                            <p class="text-sm text-body">Basis ekonomi ({{ number_format($pekerjaanStats['pertanian']) }} petani)</p>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <section id="peta-desa" class="mb-24 scroll-mt-24">
            <div class="text-center mb-16">
                <h2 class="text-4xl lg:text-5xl font-bold text-heading mb-4">
                    🗺️ Peta Desa Ngengor
                </h2>
                <div class="section-divider"></div>
                <p class="text-lg text-body max-w-3xl mx-auto">
                    Lokasi geografis dan batas wilayah Desa Ngengor dengan fasilitas dan landmark penting
                </p>
            </div>

            <div class="card-profil rounded-3xl overflow-hidden shadow-2xl border border-gray-200">
                <div class="bg-gradient-to-r from-cyan-500 to-blue-600 p-6 text-white">
                    <div class="flex flex-col lg:flex-row lg:items-center lg:justify-between">
                        <div>
                            <h3 class="text-2xl font-bold mb-1">📍 Lokasi Desa Ngengor</h3>
                            <p class="text-cyan-100">Kecamatan Pilangkenceng, Kabupaten Madiun, Jawa Timur</p>
                        </div>
                        <div class="mt-4 lg:mt-0">
                            <a href="https://www.google.com/maps/search/?api=1&query=Desa+Ngengor+Madiun" target="_blank" class="px-4 py-2 bg-white/20 hover:bg-white/30 rounded-full text-sm font-medium transition-colors backdrop-blur-md inline-flex items-center">
                                <span class="mr-2">🗺️</span> Buka di Google Maps
                            </a>
                        </div>
                    </div>
                </div>

                <div class="relative bg-gray-100 h-[500px] w-full">
                    <iframe 
                        src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d15822.36797413543!2d111.6055!3d-7.5098!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x2e79ec6c7a62a79b%3A0x4027a76e3532740!2sNgengor%2C%20Kec.%20Pilangkenceng%2C%20Kabupaten%20Madiun%2C%20Jawa%20Timur!5e0!3m2!1sid!2sid!4v1620000000000!5m2!1sid!2sid" 
                        width="100%" 
                        height="100%" 
                        style="border:0;" 
                        allowfullscreen="" 
                        loading="lazy" 
                        class="absolute inset-0 w-full h-full">
                    </iframe>
                </div>
                
                <div class="p-6 bg-gray-50 border-t border-gray-200">
                    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-sm text-center">
                        <div class="p-2">
                            <span class="block font-bold text-gray-800">Utara</span>
                            <span class="text-gray-500">Desa Kenongorejo</span>
                        </div>
                        <div class="p-2 border-l border-gray-200">
                            <span class="block font-bold text-gray-800">Selatan</span>
                            <span class="text-gray-500">Desa Wonoayu</span>
                        </div>
                        <div class="p-2 border-l border-gray-200">
                            <span class="block font-bold text-gray-800">Timur</span>
                            <span class="text-gray-500">Desa Krebet</span>
                        </div>
                        <div class="p-2 border-l border-gray-200">
                            <span class="block font-bold text-gray-800">Barat</span>
                            <span class="text-gray-500">Desa Gandul</span>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</div>

<button id="backToTop" class="fixed bottom-8 right-8 w-12 h-12 bg-profil-primary text-white rounded-full shadow-2xl hover:bg-cyan-600 transition-all duration-300 opacity-0 pointer-events-none z-50 flex items-center justify-center">
    <span class="text-xl font-bold">↑</span>
</button>
@endsection

@push('styles')
<style>
    /* Custom Gradient Background */
    .section-bg-profil {
        background: linear-gradient(135deg, #0891b2 0%, #0e7490 50%, #155e75 100%);
        position: relative;
        z-index: 1;
    }
    
    /* Background Pattern Overlay */
    .section-bg-profil::before {
        content: '';
        position: absolute;
        inset: 0;
        background-image: radial-gradient(circle at 20% 30%, rgba(255,255,255,0.1) 0%, transparent 10%),
                          radial-gradient(circle at 80% 70%, rgba(255,255,255,0.1) 0%, transparent 10%);
        background-size: 100% 100%;
        pointer-events: none;
    }

    .card-profil {
        background: #ffffff;
        position: relative;
        z-index: 2;
    }

    .bg-profil-primary { background-color: #0891b2; }
    .text-profil-primary { color: #0891b2; }
    .hover-profil-primary:hover { transform: translateY(-8px); }

    .text-heading { color: #1e293b; }
    .text-body { color: #64748b; }

    /* Section Divider Animation */
    .section-divider {
        position: relative;
        width: 80px;
        height: 4px;
        background: #e2e8f0;
        margin: 0 auto 1.5rem;
        border-radius: 2px;
        overflow: hidden;
    }
    
    .section-divider::after {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 40%;
        height: 100%;
        background: #0891b2;
        animation: slideDivider 2s infinite ease-in-out alternate;
    }

    @keyframes slideDivider {
        0% { left: 0; }
        100% { left: 60%; }
    }

    /* Smooth Scroll padding for sticky header */
    .scroll-mt-24 { scroll-margin-top: 6rem; }
</style>
@endpush

@push('scripts')
<script>
    // Back to top functionality
    const backToTop = document.getElementById('backToTop');
    
    window.addEventListener('scroll', () => {
        if (window.pageYOffset > 300) {
            backToTop.classList.remove('opacity-0', 'pointer-events-none');
            backToTop.classList.add('opacity-100', 'translate-y-0');
        } else {
            backToTop.classList.add('opacity-0', 'pointer-events-none');
            backToTop.classList.remove('opacity-100', 'translate-y-0');
        }
    });

    backToTop.addEventListener('click', () => {
        window.scrollTo({ top: 0, behavior: 'smooth' });
    });

    // Simple fade-in animation on scroll
    const observerOptions = { threshold: 0.1 };
    const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('opacity-100', 'translate-y-0');
                entry.target.classList.remove('opacity-0', 'translate-y-10');
            }
        });
    }, observerOptions);

    document.querySelectorAll('.card-profil').forEach(el => {
        el.classList.add('transition-all', 'duration-700', 'opacity-0', 'translate-y-10');
        observer.observe(el);
    });
</script>
@endpush