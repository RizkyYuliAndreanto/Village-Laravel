<!-- Section 2: Struktur Organisasi (Banyukambang, Jatim) -->
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