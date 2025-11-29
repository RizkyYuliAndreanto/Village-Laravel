{{-- Section: SOTK (Struktur Organisasi & Tatakelola) --}}
<section class="min-h-screen flex flex-col justify-center py-10 sm:py-16 section-bg-alternate">
    <div class="container mx-auto px-4 sm:px-6 text-center">
        <h2 class="text-2xl sm:text-3xl font-bold text-heading">SOTK</h2>
        <p class="mb-6 sm:mb-8 text-body text-sm sm:text-base">Struktur Organisasi & Tatakelola Desa Banyukambang</p>
        
        <div class="grid grid-cols-2 gap-3 sm:gap-4 md:gap-6 lg:grid-cols-4 max-w-6xl mx-auto">
            @if(isset($strukturOrganisasi) && count($strukturOrganisasi) > 0)
                @foreach($strukturOrganisasi->take(4) as $pejabat)
                    <div class="w-full">
                        <x-card-info 
                            title="{{ $pejabat->nama }}" 
                            summary="{{ $pejabat->jabatan }}" 
                            image="{{ $pejabat->foto_url ? $pejabat->foto_url : asset('images/logo-placeholder.jpg') }}" />
                    </div>
                @endforeach
            @else
                {{-- Data dummy jika belum ada data real --}}
                <div class="w-full">
                    <x-card-info title="Lorem" summary="Kepala Desa" image="{{ asset('images/logo-placeholder.jpg') }}" />
                </div>
                <div class="w-full">
                    <x-card-info title="Ipsum" summary="Sekretaris Desa" image="{{ asset('images/logo-placeholder.jpg') }}" />
                </div>
                <div class="w-full">
                    <x-card-info title="Dolor" summary="Kaur Tata Usaha dan Umum" image="{{ asset('images/logo-placeholder.jpg') }}" />
                </div>
                <div class="w-full">
                    <x-card-info title="Sit Amet" summary="Kaur Keuangan" image="{{ asset('images/logo-placeholder.jpg') }}" />
                </div>
            @endif
        </div>
        
        <div class="flex mt-8 sm:mt-10 justify-center sm:justify-end px-2">
            <a href="{{ route('profil-desa.struktur-organisasi') }}"
                class="inline-block px-6 py-2.5 font-semibold rounded-lg shadow transition-all duration-300 text-white text-center"
                style="background: linear-gradient(135deg, #14b8a6, #0891b2); width: 100%; max-width: 200px;">
                Lihat Selengkapnya →
            </a>
        </div>
    </div>
</section>