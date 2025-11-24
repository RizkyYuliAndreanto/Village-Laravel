@extends('frontend.layouts.profil-desa')

@section('title', 'Visi Misi - Desa Ngengor')

@section('content')
<!-- Hero Section with Breadcrumb -->
<section class="bg-gradient-to-br from-profil-primary via-profil-accent to-teal-700 text-white py-16">
    <div class="container mx-auto px-4 py-16">
        <div class="text-center">
            <h1 class="text-4xl md:text-5xl font-bold mb-4">Visi & Misi</h1>
            <p class="text-xl text-white/90 max-w-3xl mx-auto">
                Komitmen Desa Ngengor dalam membangun masa depan yang lebih baik
            </p>
        </div>
    </div>
</section>

<!-- Visi Misi Content -->
<section class="py-20 bg-gradient-to-br from-white to-profil-bg">
    <div class="container mx-auto px-4">
        <div class="grid lg:grid-cols-2 gap-12">
            <!-- Visi Section -->
            <div data-aos="fade-up" class="visi-section">
                <div class="bg-white rounded-2xl shadow-xl p-8 border-l-8 border-profil-primary">
                    <div class="text-center mb-8">
                        <div class="w-20 h-20 bg-gradient-to-br from-profil-primary to-profil-accent rounded-full flex items-center justify-center mx-auto mb-4">
                            <span class="text-3xl">🎯</span>
                        </div>
                        <h2 class="text-3xl font-bold text-heading mb-2">VISI</h2>
                        <div class="w-24 h-1 bg-gradient-to-r from-profil-primary to-profil-accent mx-auto"></div>
                    </div>
                    
                    <blockquote class="text-lg text-gray-700 leading-relaxed text-center italic">
                        "Terwujudnya Desa Banyukambang yang Sejahtera, Mandiri, dan Berkelanjutan 
                        berdasarkan Kearifan Lokal menuju Desa Wisata yang Berkarakter"
                    </blockquote>
                    
                    <div class="mt-8 p-4 bg-profil-bg rounded-lg">
                        <p class="text-sm text-gray-600 text-center">
                            Visi ini mencerminkan cita-cita besar Desa Banyukambang untuk menjadi desa yang maju 
                            dengan tetap mempertahankan nilai-nilai budaya dan kearifan lokal.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Misi Section -->
            <div data-aos="fade-up" data-aos-delay="200" class="misi-section">
                <div class="bg-white rounded-2xl shadow-xl p-8 border-l-8 border-profil-accent">
                    <div class="text-center mb-8">
                        <div class="w-20 h-20 bg-gradient-to-br from-profil-accent to-profil-primary rounded-full flex items-center justify-center mx-auto mb-4">
                            <span class="text-3xl">🚀</span>
                        </div>
                        <h2 class="text-3xl font-bold text-heading mb-2">MISI</h2>
                        <div class="w-24 h-1 bg-gradient-to-r from-profil-accent to-profil-primary mx-auto"></div>
                    </div>
                    
                    <div class="space-y-4">
                        <div class="flex items-start space-x-4 p-4 bg-profil-bg rounded-lg hover:shadow-md transition-shadow">
                            <div class="w-8 h-8 bg-profil-primary text-white rounded-full flex items-center justify-center text-sm font-bold mt-1">1</div>
                            <p class="text-gray-700 leading-relaxed">
                                Meningkatkan kualitas sumber daya manusia (SDM)
                            </p>
                        </div>
                        
                        <div class="flex items-start space-x-4 p-4 bg-profil-bg rounded-lg hover:shadow-md transition-shadow">
                            <div class="w-8 h-8 bg-profil-primary text-white rounded-full flex items-center justify-center text-sm font-bold mt-1">2</div>
                            <p class="text-gray-700 leading-relaxed">
                                Mengembangkan potensi ekonomi desa melalui pengembangan UMKM dan industri kreatif berbasis lokal
                            </p>
                        </div>
                        
                        <div class="flex items-start space-x-4 p-4 bg-profil-bg rounded-lg hover:shadow-md transition-shadow">
                            <div class="w-8 h-8 bg-profil-primary text-white rounded-full flex items-center justify-center text-sm font-bold mt-1">3</div>
                            <p class="text-gray-700 leading-relaxed">
                                Memperbaiki dan mengembangkan infrastruktur desa untuk mendukung kehidupan masyarakat
                            </p>
                        </div>
                        
                        <div class="flex items-start space-x-4 p-4 bg-profil-bg rounded-lg hover:shadow-md transition-shadow">
                            <div class="w-8 h-8 bg-profil-primary text-white rounded-full flex items-center justify-center text-sm font-bold mt-1">4</div>
                            <p class="text-gray-700 leading-relaxed">
                                Melestarikan budaya dan kearifan lokal sebagai identitas dan daya tarik wisata desa
                            </p>
                        </div>
                        
                        <div class="flex items-start space-x-4 p-4 bg-profil-bg rounded-lg hover:shadow-md transition-shadow">
                            <div class="w-8 h-8 bg-profil-primary text-white rounded-full flex items-center justify-center text-sm font-bold mt-1">5</div>
                            <p class="text-gray-700 leading-relaxed">
                                Meningkatkan tata kelola pemerintahan desa yang transparan, akuntabel, dan partisipatif
                            </p>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <!-- Vision Goals Section -->
        <div class="mt-16" data-aos="fade-up" data-aos-delay="400">
            <div class="text-center mb-12">
                <h2 class="text-3xl font-bold text-heading mb-4">Target Pencapaian</h2>
                <p class="text-lg text-body max-w-3xl mx-auto">
                    Langkah konkret menuju visi Desa Banyukambang yang sejahtera
                </p>
            </div>
            
            <div class="grid md:grid-cols-3 gap-8">
                <!-- Target 1 -->
                <div class="bg-white rounded-xl shadow-lg p-6 text-center hover:shadow-xl transition-shadow">
                    <div class="w-16 h-16 bg-gradient-to-br from-green-400 to-green-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl">📈</span>
                    </div>
                    <h3 class="text-xl font-bold text-heading mb-2">2025</h3>
                    <p class="text-sm text-body">
                        Peningkatan pendapatan masyarakat sebesar 30% melalui pengembangan UMKM
                    </p>
                </div>
                
                <!-- Target 2 -->
                <div class="bg-white rounded-xl shadow-lg p-6 text-center hover:shadow-xl transition-shadow">
                    <div class="w-16 h-16 bg-gradient-to-br from-blue-400 to-blue-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl">🏛️</span>
                    </div>
                    <h3 class="text-xl font-bold text-heading mb-2">2026</h3>
                    <p class="text-sm text-body">
                        Terwujudnya infrastruktur desa yang memadai dan berkelanjutan
                    </p>
                </div>
                
                <!-- Target 3 -->
                <div class="bg-white rounded-xl shadow-lg p-6 text-center hover:shadow-xl transition-shadow">
                    <div class="w-16 h-16 bg-gradient-to-br from-purple-400 to-purple-600 rounded-full flex items-center justify-center mx-auto mb-4">
                        <span class="text-2xl">🎭</span>
                    </div>
                    <h3 class="text-xl font-bold text-heading mb-2">2027</h3>
                    <p class="text-sm text-body">
                        Desa Banyukambang menjadi destinasi wisata budaya terkemuka di daerah
                    </p>
                </div>
            </div>
        </div>
    </div>
</section>

<!-- Call to Action -->
<section class="py-16 bg-gradient-to-r from-profil-primary to-profil-accent text-white">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-3xl font-bold mb-4">Mari Bersama Mewujudkan Visi Desa</h2>
        <p class="text-xl mb-8 max-w-2xl mx-auto">
            Partisipasi aktif masyarakat adalah kunci utama dalam mewujudkan visi dan misi Desa Banyukambang
        </p>
        <div class="flex flex-col sm:flex-row gap-4 justify-center">
            <a href="{{ route('profil-desa.struktur-organisasi') }}" 
               class="bg-white text-profil-primary px-8 py-3 rounded-full font-semibold hover:shadow-lg transition-all">
                Lihat Struktur Organisasi
            </a>
            <a href="{{ route('profil-desa.potensi-desa') }}" 
               class="border-2 border-white text-white px-8 py-3 rounded-full font-semibold hover:bg-white hover:text-profil-primary transition-all">
                Potensi Desa
            </a>
        </div>
    </div>
</section>
@endsection