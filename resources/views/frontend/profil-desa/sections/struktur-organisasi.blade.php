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

    {{-- PERBAIKAN: Menggunakan $strukturOrganisasi (bukan $sotk) --}}
    @if(isset($strukturOrganisasi) && $strukturOrganisasi->count() > 0)
    <div class="max-w-6xl mx-auto">

        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
            @foreach($strukturOrganisasi->take(3) as $struktur)
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

        <div class="text-center mt-10">
            <a href="{{ route('profil-desa.struktur-anggota.index') }}"
               class="px-6 py-3 bg-profil-primary text-white rounded-full hover:bg-cyan-700 shadow-lg transition-all">
               Lihat Struktur Lengkap →
            </a>
        </div>

    </div>
    @else
    <div class="text-center py-12">
        <p class="text-gray-500">Data struktur organisasi belum tersedia.</p>
    </div>
    @endif
</section>