<!-- Section 4: Peta Desa (Banyukambang, Jatim) -->
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
</section>