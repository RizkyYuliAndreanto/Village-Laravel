{{-- Section: SOTK (Struktur Organisasi & Tatakelola) --}}
<section class="min-h-screen flex flex-col justify-center py-10 section-bg-alternate">
    <div class="container mx-auto px-6 text-center">
        <h2 class="text-3xl font-bold text-heading">SOTK</h2>
        <p class="mb-8 text-body">Struktur Organisasi & Tatakelola Desa Banyukambang</p>
        
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6 max-w-6xl mx-auto">
            @if(isset($strukturOrganisasi) && count($strukturOrganisasi) > 0)
                @foreach($strukturOrganisasi->take(4) as $pejabat)
                    <x-card-info 
                        title="{{ $pejabat->nama }}" 
                        summary="{{ $pejabat->jabatan }}" 
                        image="{{ $pejabat->foto_url ? asset('storage/'.$pejabat->foto_url) : asset('images/logo-placeholder.jpg') }}" />
                @endforeach
            @else
                {{-- Data dummy jika belum ada data real --}}
                <x-card-info title="Lorem" summary="Kepala Desa" image="{{ asset('images/logo-placeholder.jpg') }}" />
                <x-card-info title="Ipsum" summary="Sekretaris Desa" image="{{ asset('images/logo-placeholder.jpg') }}" />
                <x-card-info title="Dolor" summary="Kaur Tata Usaha dan Umum" image="{{ asset('images/logo-placeholder.jpg') }}" />
                <x-card-info title="Sit Amet" summary="Kaur Keuangan" image="{{ asset('images/logo-placeholder.jpg') }}" />
            @endif
        </div>
        
        <div class="flex mt-10 justify-end">
            <a href="{{ route('profil-desa.struktur-organisasi') }}"
                class="btn-primary inline-block px-6 py-2.5 font-semibold rounded-lg shadow transition-all duration-300">
                Lihat Selengkapnya →
            </a>
        </div>
    </div>
</section>