@extends('frontend.layouts.main')

@section('title', 'Potensi Desa - Desa Ngengor')

@section('content')
<!-- Hero Section with Breadcrumb -->
<section class="bg-gradient-to-br from-profil-primary via-profil-accent to-teal-700 text-white py-16">
    <div class="container mx-auto px-4 py-16">
        <div class="text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Potensi Desa</h1>
            <p class="text-xl text-white/90 max-w-3xl mx-auto">
                Kekayaan alam, budaya, dan sumber daya yang menjadi keunggulan Desa Ngengor
            </p>
        </div>
    </div>
</section>

<!-- Potensi Overview -->
<section class="py-20 bg-gradient-to-br from-white to-profil-bg">
    <div class="container mx-auto px-4">
        <!-- Section Header -->
        <div class="text-center mb-16" data-aos="fade-up">
            <h2 class="text-3xl md:text-4xl font-bold text-heading mb-4">Kekayaan Desa Ngengor</h2>
            <p class="text-lg text-body max-w-3xl mx-auto">
                Desa Ngengor memiliki berbagai potensi yang dapat dikembangkan untuk meningkatkan 
                kesejahteraan masyarakat dan daya tarik wisata
            </p>
            <div class="w-24 h-1 bg-gradient-to-r from-profil-primary to-profil-accent mx-auto mt-6"></div>
        </div>

        <!-- Potensi Cards Grid -->
        <div class="grid lg:grid-cols-3 md:grid-cols-2 gap-8 mb-16">
            <!-- Potensi Alam -->
            <div data-aos="fade-up" data-aos-delay="0" class="potensi-card">
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="relative h-48 bg-gradient-to-br from-green-400 to-green-600">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <span class="text-6xl">🌿</span>
                        </div>
                        <div class="absolute bottom-4 left-4 right-4">
                            <h3 class="text-2xl font-bold text-white">Potensi Alam</h3>
                        </div>
                    </div>
                    <div class="p-6">
                        <ul class="space-y-3 text-sm">
                            <li class="flex items-center space-x-3">
                                <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                                <span>Lahan pertanian subur seluas 450 hektar</span>
                            </li>
                            <li class="flex items-center space-x-3">
                                <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                                <span>Hutan bambu dan kayu produktif</span>
                            </li>
                            <li class="flex items-center space-x-3">
                                <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                                <span>Sumber mata air jernih dan alami</span>
                            </li>
                            <li class="flex items-center space-x-3">
                                <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                                <span>Pemandangan pegunungan yang indah</span>
                            </li>
                            <li class="flex items-center space-x-3">
                                <span class="w-2 h-2 bg-green-500 rounded-full"></span>
                                <span>Udara sejuk dan lingkungan asri</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Potensi Budaya -->
            <div data-aos="fade-up" data-aos-delay="200" class="potensi-card">
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="relative h-48 bg-gradient-to-br from-purple-400 to-purple-600">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <span class="text-6xl">🎭</span>
                        </div>
                        <div class="absolute bottom-4 left-4 right-4">
                            <h3 class="text-2xl font-bold text-white">Potensi Budaya</h3>
                        </div>
                    </div>
                    <div class="p-6">
                        <ul class="space-y-3 text-sm">
                            <li class="flex items-center space-x-3">
                                <span class="w-2 h-2 bg-purple-500 rounded-full"></span>
                                <span>Tradisi Seren Taun (Syukuran Panen)</span>
                            </li>
                            <li class="flex items-center space-x-3">
                                <span class="w-2 h-2 bg-purple-500 rounded-full"></span>
                                <span>Kesenian Wayang Golek tradisional</span>
                            </li>
                            <li class="flex items-center space-x-3">
                                <span class="w-2 h-2 bg-purple-500 rounded-full"></span>
                                <span>Tarian Jaipong dan Ketuk Tilu</span>
                            </li>
                            <li class="flex items-center space-x-3">
                                <span class="w-2 h-2 bg-purple-500 rounded-full"></span>
                                <span>Cerita rakyat dan legenda lokal</span>
                            </li>
                            <li class="flex items-center space-x-3">
                                <span class="w-2 h-2 bg-purple-500 rounded-full"></span>
                                <span>Arsitektur rumah adat Sunda</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>

            <!-- Potensi Ekonomi -->
            <div data-aos="fade-up" data-aos-delay="400" class="potensi-card">
                <div class="bg-white rounded-2xl shadow-xl overflow-hidden hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                    <div class="relative h-48 bg-gradient-to-br from-orange-400 to-orange-600">
                        <div class="absolute inset-0 bg-gradient-to-t from-black/50 to-transparent"></div>
                        <div class="absolute inset-0 flex items-center justify-center">
                            <span class="text-6xl">💰</span>
                        </div>
                        <div class="absolute bottom-4 left-4 right-4">
                            <h3 class="text-2xl font-bold text-white">Potensi Ekonomi</h3>
                        </div>
                    </div>
                    <div class="p-6">
                        <ul class="space-y-3 text-sm">
                            <li class="flex items-center space-x-3">
                                <span class="w-2 h-2 bg-orange-500 rounded-full"></span>
                                <span>Produksi padi dan sayuran organik</span>
                            </li>
                            <li class="flex items-center space-x-3">
                                <span class="w-2 h-2 bg-orange-500 rounded-full"></span>
                                <span>Industri kerajinan bambu dan rotan</span>
                            </li>
                            <li class="flex items-center space-x-3">
                                <span class="w-2 h-2 bg-orange-500 rounded-full"></span>
                                <span>Usaha makanan tradisional khas desa</span>
                            </li>
                            <li class="flex items-center space-x-3">
                                <span class="w-2 h-2 bg-orange-500 rounded-full"></span>
                                <span>Peternakan sapi dan kambing</span>
                            </li>
                            <li class="flex items-center space-x-3">
                                <span class="w-2 h-2 bg-orange-500 rounded-full"></span>
                                <span>Budidaya ikan air tawar</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <!-- Detailed Sections -->
        <div class="space-y-16">
            <!-- Potensi Pertanian -->
            <div data-aos="fade-up" class="potensi-detail">
                <div class="bg-white rounded-2xl shadow-xl p-8">
                    <div class="flex items-center mb-6">
                        <div class="w-16 h-16 bg-gradient-to-br from-green-400 to-green-600 rounded-full flex items-center justify-center mr-4">
                            <span class="text-2xl">🌾</span>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-heading">Sektor Pertanian</h3>
                            <p class="text-body">Tulang punggung ekonomi desa</p>
                        </div>
                    </div>
                    
                    <div class="grid md:grid-cols-2 gap-8">
                        <div>
                            <h4 class="text-lg font-semibold text-heading mb-4">Komoditas Unggulan</h4>
                            <div class="space-y-3">
                                <div class="flex justify-between items-center p-3 bg-profil-bg rounded-lg">
                                    <span class="font-medium">Padi</span>
                                    <span class="text-green-600 font-semibold">300 ton/tahun</span>
                                </div>
                                <div class="flex justify-between items-center p-3 bg-profil-bg rounded-lg">
                                    <span class="font-medium">Jagung</span>
                                    <span class="text-green-600 font-semibold">150 ton/tahun</span>
                                </div>
                                <div class="flex justify-between items-center p-3 bg-profil-bg rounded-lg">
                                    <span class="font-medium">Sayuran</span>
                                    <span class="text-green-600 font-semibold">200 ton/tahun</span>
                                </div>
                                <div class="flex justify-between items-center p-3 bg-profil-bg rounded-lg">
                                    <span class="font-medium">Buah-buahan</span>
                                    <span class="text-green-600 font-semibold">100 ton/tahun</span>
                                </div>
                            </div>
                        </div>
                        
                        <div>
                            <h4 class="text-lg font-semibold text-heading mb-4">Program Pengembangan</h4>
                            <ul class="space-y-3">
                                <li class="flex items-start space-x-3">
                                    <span class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center mt-0.5">✓</span>
                                    <span class="text-sm">Sistem irigasi modern dan berkelanjutan</span>
                                </li>
                                <li class="flex items-start space-x-3">
                                    <span class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center mt-0.5">✓</span>
                                    <span class="text-sm">Pelatihan teknik pertanian organik</span>
                                </li>
                                <li class="flex items-start space-x-3">
                                    <span class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center mt-0.5">✓</span>
                                    <span class="text-sm">Bantuan alat dan mesin pertanian</span>
                                </li>
                                <li class="flex items-start space-x-3">
                                    <span class="w-6 h-6 bg-green-100 rounded-full flex items-center justify-center mt-0.5">✓</span>
                                    <span class="text-sm">Pengembangan koperasi petani</span>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Potensi Wisata -->
            <div data-aos="fade-up" data-aos-delay="200" class="potensi-detail">
                <div class="bg-white rounded-2xl shadow-xl p-8">
                    <div class="flex items-center mb-6">
                        <div class="w-16 h-16 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center mr-4">
                            <span class="text-2xl">🏞️</span>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-heading">Potensi Wisata</h3>
                            <p class="text-body">Destinasi wisata alam dan budaya</p>
                        </div>
                    </div>
                    
                    <div class="grid md:grid-cols-3 gap-6">
                        <!-- Wisata Alam -->
                        <div class="bg-profil-bg p-6 rounded-xl">
                            <h4 class="font-semibold text-heading mb-3 flex items-center">
                                <span class="mr-2">🌲</span>
                                Wisata Alam
                            </h4>
                            <ul class="space-y-2 text-sm">
                                <li>• Trekking hutan bambu</li>
                                <li>• Air terjun tersembunyi</li>
                                <li>• Pemandangan sawah terasering</li>
                                <li>• Spot sunrise/sunset</li>
                            </ul>
                        </div>
                        
                        <!-- Wisata Budaya -->
                        <div class="bg-profil-bg p-6 rounded-xl">
                            <h4 class="font-semibold text-heading mb-3 flex items-center">
                                <span class="mr-2">🏛️</span>
                                Wisata Budaya
                            </h4>
                            <ul class="space-y-2 text-sm">
                                <li>• Pertunjukan wayang golek</li>
                                <li>• Workshop kerajinan bambu</li>
                                <li>• Festival Seren Taun</li>
                                <li>• Rumah adat tradisional</li>
                            </ul>
                        </div>
                        
                        <!-- Wisata Kuliner -->
                        <div class="bg-profil-bg p-6 rounded-xl">
                            <h4 class="font-semibold text-heading mb-3 flex items-center">
                                <span class="mr-2">🍽️</span>
                                Wisata Kuliner
                            </h4>
                            <ul class="space-y-2 text-sm">
                                <li>• Nasi liwet tradisional</li>
                                <li>• Keripik pisang organik</li>
                                <li>• Dodol garut khas desa</li>
                                <li>• Bandrek dan bajigur</li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Potensi SDM -->
            <div data-aos="fade-up" data-aos-delay="400" class="potensi-detail">
                <div class="bg-white rounded-2xl shadow-xl p-8">
                    <div class="flex items-center mb-6">
                        <div class="w-16 h-16 bg-gradient-to-br from-indigo-400 to-indigo-600 rounded-full flex items-center justify-center mr-4">
                            <span class="text-2xl">👥</span>
                        </div>
                        <div>
                            <h3 class="text-2xl font-bold text-heading">Sumber Daya Manusia</h3>
                            <p class="text-body">Aset berharga desa</p>
                        </div>
                    </div>
                    
                    <div class="grid md:grid-cols-4 gap-6">
                        <div class="text-center">
                            <div class="w-16 h-16 bg-indigo-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                <span class="text-2xl">📚</span>
                            </div>
                            <div class="text-2xl font-bold text-profil-primary">85%</div>
                            <div class="text-sm text-gray-600">Tingkat Literasi</div>
                        </div>
                        
                        <div class="text-center">
                            <div class="w-16 h-16 bg-green-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                <span class="text-2xl">💼</span>
                            </div>
                            <div class="text-2xl font-bold text-profil-primary">120</div>
                            <div class="text-sm text-gray-600">Pelaku UMKM</div>
                        </div>
                        
                        <div class="text-center">
                            <div class="w-16 h-16 bg-yellow-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                <span class="text-2xl">🎨</span>
                            </div>
                            <div class="text-2xl font-bold text-profil-primary">45</div>
                            <div class="text-sm text-gray-600">Pengrajin</div>
                        </div>
                        
                        <div class="text-center">
                            <div class="w-16 h-16 bg-purple-100 rounded-full flex items-center justify-center mx-auto mb-3">
                                <span class="text-2xl">🌾</span>
                            </div>
                            <div class="text-2xl font-bold text-profil-primary">200</div>
                            <div class="text-sm text-gray-600">Petani Aktif</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Investment Opportunities -->
<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <div class="text-center mb-12" data-aos="fade-up">
            <h2 class="text-3xl font-bold text-heading mb-4">Peluang Investasi</h2>
            <p class="text-lg text-body max-w-2xl mx-auto">
                Berbagai sektor potensial untuk pengembangan dan investasi di Desa Banyukambang
            </p>
        </div>
        
        <div class="grid md:grid-cols-2 lg:grid-cols-4 gap-6">
            <div data-aos="fade-up" data-aos-delay="0" class="bg-gradient-to-br from-green-50 to-green-100 p-6 rounded-xl text-center">
                <div class="w-12 h-12 bg-green-500 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-white text-xl">🏭</span>
                </div>
                <h3 class="font-bold text-heading mb-2">Agro Industri</h3>
                <p class="text-sm text-body">Pengolahan hasil pertanian</p>
            </div>
            
            <div data-aos="fade-up" data-aos-delay="100" class="bg-gradient-to-br from-blue-50 to-blue-100 p-6 rounded-xl text-center">
                <div class="w-12 h-12 bg-blue-500 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-white text-xl">🏨</span>
                </div>
                <h3 class="font-bold text-heading mb-2">Eco Tourism</h3>
                <p class="text-sm text-body">Homestay dan wisata alam</p>
            </div>
            
            <div data-aos="fade-up" data-aos-delay="200" class="bg-gradient-to-br from-purple-50 to-purple-100 p-6 rounded-xl text-center">
                <div class="w-12 h-12 bg-purple-500 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-white text-xl">🎨</span>
                </div>
                <h3 class="font-bold text-heading mb-2">Craft Center</h3>
                <p class="text-sm text-body">Pusat kerajinan lokal</p>
            </div>
            
            <div data-aos="fade-up" data-aos-delay="300" class="bg-gradient-to-br from-orange-50 to-orange-100 p-6 rounded-xl text-center">
                <div class="w-12 h-12 bg-orange-500 rounded-full flex items-center justify-center mx-auto mb-4">
                    <span class="text-white text-xl">💡</span>
                </div>
                <h3 class="font-bold text-heading mb-2">Renewable Energy</h3>
                <p class="text-sm text-body">Energi terbarukan</p>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="py-16 bg-gradient-to-r from-profil-primary to-profil-accent text-white">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-3xl font-bold mb-4">Tertarik Mengembangkan Potensi Desa?</h2>
        <p class="text-xl mb-8 max-w-2xl mx-auto">
            Mari bersama-sama membangun dan mengembangkan potensi Desa Banyukambang untuk masa depan yang lebih sejahtera
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('profil-desa.peta-desa') }}" 
               class="bg-white text-profil-primary px-8 py-3 rounded-full font-semibold hover:shadow-lg transition-all">
                Lihat Lokasi Desa
            </a>
            <a href="{{ route('profil-desa.struktur-organisasi') }}" 
               class="border-2 border-white text-white px-8 py-3 rounded-full font-semibold hover:bg-white hover:text-profil-primary transition-all">
                Hubungi Pemerintah Desa
            </a>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
.text-profil-primary { color: #0891b2; }
.bg-profil-primary { background-color: #0891b2; }
.text-profil-accent { color: #0e7490; }
.bg-profil-accent { background-color: #0e7490; }
.bg-profil-bg { background-color: #f8fafc; }
.text-heading { color: #1e293b; }
.text-body { color: #64748b; }
</style>
@endpush