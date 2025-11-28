{{-- Section: SOTK (Struktur Organisasi & Tatakelola) --}}
<section class="min-h-screen flex flex-col justify-center py-10 sm:py-16 section-bg-alternate">
    <div class="container mx-auto px-4 sm:px-6 text-center">
        <h2 class="text-2xl sm:text-3xl font-bold text-heading">SOTK</h2>
        <p class="mb-6 sm:mb-8 text-body text-sm sm:text-base">Struktur Organisasi & Tatakelola Desa Banyukambang</p>
        
        <div class="flex overflow-x-auto space-x-4 pb-4 horizontal-scroll sm:grid sm:grid-cols-2 lg:grid-cols-4 sm:gap-6 sm:space-x-0 sm:overflow-visible sm:pb-0 max-w-6xl mx-auto">
            @if(isset($strukturOrganisasi) && count($strukturOrganisasi) > 0)
                @foreach($strukturOrganisasi->take(4) as $pejabat)
                    <div class="flex-none w-64 sm:w-auto">
                        <x-card-info 
                            title="{{ $pejabat->nama }}" 
                            summary="{{ $pejabat->jabatan }}" 
                            image="{{ $pejabat->foto_url ? asset('storage/'.$pejabat->foto_url) : asset('images/logo-placeholder.jpg') }}" />
                    </div>
                @endforeach
            @else
                {{-- Data dummy jika belum ada data real --}}
                <div class="flex-none w-64 sm:w-auto">
                    <x-card-info title="Lorem" summary="Kepala Desa" image="{{ asset('images/logo-placeholder.jpg') }}" />
                </div>
                <div class="flex-none w-64 sm:w-auto">
                    <x-card-info title="Ipsum" summary="Sekretaris Desa" image="{{ asset('images/logo-placeholder.jpg') }}" />
                </div>
                <div class="flex-none w-64 sm:w-auto">
                    <x-card-info title="Dolor" summary="Kaur Tata Usaha dan Umum" image="{{ asset('images/logo-placeholder.jpg') }}" />
                </div>
                <div class="flex-none w-64 sm:w-auto">
                    <x-card-info title="Sit Amet" summary="Kaur Keuangan" image="{{ asset('images/logo-placeholder.jpg') }}" />
                </div>
            @endif
        </div>
        
        <div class="flex mt-8 sm:mt-10 justify-center sm:justify-end px-2">
            <a href="{{ route('profil-desa.struktur-organisasi') }}"
                class="w-full sm:w-auto text-center btn-primary inline-block px-6 py-2.5 font-semibold rounded-lg shadow transition-all duration-300">
                Lihat Selengkapnya →
            </a>
        </div>
    </div>
</section>