@extends('frontend.layouts.main')

@section('title', $umkm->nama . ' - Detail UMKM')

@section('content')
<section class="bg-gray-50 dark:bg-gray-900 py-12 pt-24 min-h-screen">
    <div class="container mx-auto px-6 max-w-7xl">
        
    <nav class="mb-6 text-sm text-gray-500 dark:text-gray-400" aria-label="breadcrumb">
            <ol class="flex items-center space-x-2">
                <li>
                    <a href="{{ route('umkm.index') }}" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition">
                        <i class="fas fa-store me-1"></i>UMKM
                    </a>
                </li>
                
                {{-- Pengecekan Kategori dan SLUG sebelum memanggil route() --}}
                @if($umkm->kategori && !empty($umkm->kategori->slug))
                    <li class="flex items-center">
                        <span class="mx-2">/</span>
                        <a href="{{ route('umkm.kategori', $umkm->kategori->slug) }}" class="hover:text-indigo-600 dark:hover:text-indigo-400 transition">
                            {{ $umkm->kategori->nama_kategori }}
                        </a>
                    </li>
                @endif
                
                <li class="flex items-center font-semibold text-gray-700 dark:text-gray-300">
                    <span class="mx-2">/</span>
                    {{ $umkm->nama }}
                </li>
            </ol>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <div class="lg:col-span-2">
                
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl mb-6 p-6 md:p-8">
                    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                        
                        <div class="md:col-span-1 text-center">
                            <div class="bg-gray-100 dark:bg-gray-700 p-4 rounded-lg shadow mb-4 flex justify-center items-center h-48">
                                @if($umkm->logo_url)
                                    <img src="{{ $umkm->logo_url ? asset('storage/' . $umkm->logo_url) : asset('images/logo-placeholder.jpg') }}" 
                                        alt="{{ $umkm->nama }}" 
                                        class="rounded object-contain"
                                        style="max-height: 100%;">
                                @else
                                    <i class="fas fa-store fa-5x text-gray-400 dark:text-gray-600"></i>
                                @endif
                            </div>
                            
                            @if($umkm->kategori)
                                <span class="inline-flex items-center bg-indigo-600 text-white text-lg font-semibold px-4 py-2 rounded-full shadow-md">
                                    {{ $umkm->kategori->icon }} {{ $umkm->kategori->nama_kategori }}
                                </span>
                            @else
                                <span class="inline-flex items-center bg-gray-500 text-white text-lg font-semibold px-4 py-2 rounded-full shadow-md">
                                    Tanpa Kategori
                                </span>
                            @endif
                        </div>

                        <div class="md:col-span-2">
                            <h1 class="text-3xl md:text-4xl font-extrabold text-gray-900 dark:text-white mb-2">{{ $umkm->nama }}</h1>
                            <p class="text-xl text-gray-500 dark:text-gray-400 mb-4">
                                <i class="fas fa-user me-2"></i>Pemilik: <strong class="text-gray-700 dark:text-gray-300">{{ $umkm->pemilik }}</strong>
                            </p>

                            <div class="contact-section">
                                <h5 class="text-xl font-bold text-gray-800 dark:text-gray-200 mb-4 border-b pb-2 border-gray-100 dark:border-gray-700">
                                    <i class="fas fa-address-book me-2 text-indigo-600"></i>Informasi Kontak
                                </h5>
                                
                                @if($umkm->alamat || $umkm->dusun)
                                    <div class="mb-3 text-gray-700 dark:text-gray-300">
                                        <i class="fas fa-map-marker-alt text-red-500 me-3 w-4 inline-block"></i>
                                        <strong class="text-gray-600 dark:text-gray-400">Alamat:</strong>
                                        <div class="mt-1 ml-7">
                                            @if($umkm->alamat)
                                                {{ $umkm->alamat }}<br>
                                            @endif
                                            @if($umkm->dusun)
                                                Dusun {{ $umkm->dusun }}
                                                @if($umkm->rt && $umkm->rw)
                                                    RT {{ $umkm->rt }}/RW {{ $umkm->rw }}
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                @endif

                                @if($umkm->telepon)
                                    <div class="mb-3 text-gray-700 dark:text-gray-300">
                                        <i class="fas fa-phone text-green-500 me-3 w-4 inline-block"></i>
                                        <strong class="text-gray-600 dark:text-gray-400">Telepon:</strong>
                                        <a href="tel:{{ $umkm->telepon }}" class="text-indigo-600 dark:text-indigo-400 hover:underline ml-1">
                                            {{ $umkm->telepon }}
                                        </a>
                                    </div>
                                @endif

                                @if($umkm->email)
                                    <div class="mb-3 text-gray-700 dark:text-gray-300">
                                        <i class="fas fa-envelope text-blue-500 me-3 w-4 inline-block"></i>
                                        <strong class="text-gray-600 dark:text-gray-400">Email:</strong>
                                        <a href="mailto:{{ $umkm->email }}" class="text-indigo-600 dark:text-indigo-400 hover:underline ml-1">
                                            {{ $umkm->email }}
                                        </a>
                                    </div>
                                @endif
                            </div>

                            <div class="social-contact mt-6">
                                <h6 class="font-bold text-gray-800 dark:text-gray-200 mb-3">Hubungi Kami:</h6>
                                <div class="flex flex-wrap gap-3">
                                    @if($umkm->whatsapp)
                                        <a href="https://wa.me/{{ $umkm->whatsapp }}" 
                                           class="inline-flex items-center px-4 py-2 bg-green-600 text-white rounded-lg shadow-md hover:bg-green-700 transition font-semibold" 
                                           target="_blank">
                                            <i class="fab fa-whatsapp me-2"></i>WhatsApp
                                        </a>
                                    @endif
                                    
                                    @if($umkm->sosial_instagram)
                                        <a href="https://instagram.com/{{ ltrim($umkm->sosial_instagram, '@') }}" 
                                           class="inline-flex items-center px-4 py-2 bg-pink-600 text-white rounded-lg shadow-md hover:bg-pink-700 transition font-semibold" 
                                           target="_blank">
                                            <i class="fab fa-instagram me-2"></i>Instagram
                                        </a>
                                    @endif
                                    
                                    @if($umkm->sosial_facebook)
                                        <a href="{{ $umkm->sosial_facebook }}" 
                                           class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg shadow-md hover:bg-blue-700 transition font-semibold" 
                                           target="_blank">
                                            <i class="fab fa-facebook me-2"></i>Facebook
                                        </a>
                                    @endif
                                    
                                    @if($umkm->website)
                                        <a href="{{ $umkm->website }}" 
                                           class="inline-flex items-center px-4 py-2 bg-gray-600 text-white rounded-lg shadow-md hover:bg-gray-700 transition font-semibold" 
                                           target="_blank">
                                            <i class="fas fa-globe me-2"></i>Website
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                @if($umkm->deskripsi)
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl mb-6">
                        <div class="p-4 border-b border-gray-100 dark:border-gray-700">
                            <h5 class="text-xl font-bold text-gray-800 dark:text-gray-200 mb-0">
                                <i class="fas fa-info-circle me-2 text-indigo-600"></i>Tentang {{ $umkm->nama }}
                            </h5>
                        </div>
                        <div class="p-4 md:p-6">
                            <p class="text-gray-700 dark:text-gray-300 whitespace-pre-line leading-relaxed">
                                {!! nl2br(e($umkm->deskripsi)) !!}
                            </p>
                        </div>
                    </div>
                @endif

                @if(isset($umkm->produk_layanan))
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl mb-6">
                        <div class="p-4 border-b border-gray-100 dark:border-gray-700">
                            <h5 class="text-xl font-bold text-gray-800 dark:text-gray-200 mb-0">
                                <i class="fas fa-box me-2 text-indigo-600"></i>Produk & Layanan
                            </h5>
                        </div>
                        <div class="p-4 md:p-6">
                            <p class="text-gray-700 dark:text-gray-300 whitespace-pre-line leading-relaxed">
                                {!! nl2br(e($umkm->produk_layanan)) !!}
                            </p>
                        </div>
                    </div>
                @endif

                @if(isset($umkm->jam_operasional))
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl mb-6">
                        <div class="p-4 border-b border-gray-100 dark:border-gray-700">
                            <h5 class="text-xl font-bold text-gray-800 dark:text-gray-200 mb-0">
                                <i class="fas fa-clock me-2 text-indigo-600"></i>Jam Operasional
                            </h5>
                        </div>
                        <div class="p-4 md:p-6">
                            <p class="text-gray-700 dark:text-gray-300 whitespace-pre-line leading-relaxed">
                                {!! nl2br(e($umkm->jam_operasional)) !!}
                            </p>
                        </div>
                    </div>
                @endif
            </div>

            <div class="lg:col-span-1">
                
                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl mb-6">
                    <div class="p-4 border-b border-gray-100 dark:border-gray-700">
                        <h6 class="font-bold text-gray-800 dark:text-gray-200 mb-0">
                            <i class="fas fa-chart-line me-2 text-indigo-600"></i>Informasi Bisnis
                        </h6>
                    </div>
                    <div class="p-4 md:p-6 text-sm text-gray-700 dark:text-gray-300">
                        
                        <div class="mb-4">
                            <strong class="block mb-1 text-gray-600 dark:text-gray-400">Status Bisnis:</strong>
                            @if($umkm->status_usaha == \App\Models\Umkm::STATUS_AKTIF)
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-green-100 text-green-800 dark:bg-green-900/50 dark:text-green-300">
                                    <i class="fas fa-check-circle me-1"></i>Aktif
                                </span>
                            @else
                                <span class="inline-flex items-center px-3 py-1 rounded-full text-sm font-semibold bg-gray-100 text-gray-600 dark:bg-gray-700 dark:text-gray-400">
                                    <i class="fas fa-pause-circle me-1"></i>Tidak Aktif
                                </span>
                            @endif
                        </div>

                        @if(isset($umkm->tahun_berdiri))
                            <div class="mb-4">
                                <strong class="block mb-1 text-gray-600 dark:text-gray-400">Tahun Berdiri:</strong>
                                <span class="text-gray-700 dark:text-gray-300">{{ $umkm->tahun_berdiri }}</span>
                            </div>
                        @endif

                        @if($umkm->jumlah_karyawan)
                            <div class="mb-4">
                                <strong class="block mb-1 text-gray-600 dark:text-gray-400">Jumlah Karyawan:</strong>
                                <span class="text-gray-700 dark:text-gray-300">{{ $umkm->jumlah_karyawan }} orang</span>
                            </div>
                        @endif

                        <div class="mb-0">
                            <strong class="block mb-1 text-gray-600 dark:text-gray-400">Terakhir Diperbarui:</strong>
                            <small class="text-gray-500 dark:text-gray-400">
                                {{ $umkm->updated_at->format('d M Y, H:i') }}
                            </small>
                        </div>
                    </div>
                </div>

                <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl mb-6">
                    <div class="p-4 border-b border-gray-100 dark:border-gray-700">
                        <h6 class="font-bold text-gray-800 dark:text-gray-200 mb-0">
                            <i class="fas fa-share-alt me-2 text-indigo-600"></i>Bagikan
                        </h6>
                    </div>
                    <div class="p-4 md:p-6">
                        <div class="grid grid-cols-1 gap-3">
                            <button type="button" 
                                    class="w-full bg-indigo-500 text-white font-semibold py-2 px-4 rounded-lg hover:bg-indigo-600 transition" 
                                    onclick="copyToClipboard('{{ request()->url() }}')">
                                <i class="fas fa-copy me-1"></i>Salin Link
                            </button>
                            
                            <a href="https://wa.me/?text={{ urlencode($umkm->nama . ' - ' . request()->url()) }}" 
                                class="w-full bg-green-500 text-white font-semibold py-2 px-4 rounded-lg hover:bg-green-600 transition text-center" 
                                target="_blank">
                                <i class="fab fa-whatsapp me-1"></i>Bagikan via WhatsApp
                            </a>
                        </div>
                    </div>
                </div>

                @if($relatedUmkms->count() > 0)
                    <div class="bg-white dark:bg-gray-800 rounded-xl shadow-xl mb-6">
                        <div class="p-4 border-b border-gray-100 dark:border-gray-700">
                            <h6 class="font-bold text-gray-800 dark:text-gray-200 mb-0">
                                <i class="fas fa-store me-2 text-indigo-600"></i>UMKM Serupa
                            </h6>
                        </div>
                        <div class="divide-y divide-gray-100 dark:divide-gray-700">
                            @foreach($relatedUmkms as $related)
                                <div class="p-4 hover:bg-gray-50 dark:hover:bg-gray-700/50 transition">
                                    <h6 class="font-semibold mb-1">
                                        <a href="{{ route('umkm.show', $related->slug) }}" 
                                            class="text-indigo-600 dark:text-indigo-400 hover:underline">
                                            {{ $related->nama }}
                                        </a>
                                    </h6>
                                    <small class="text-gray-500 dark:text-gray-400 d-block mb-1">
                                        <i class="fas fa-user me-1"></i>{{ $related->pemilik }}
                                    </small>
                                    <small class="text-gray-500 dark:text-gray-400">
                                        <i class="fas fa-map-marker-alt me-1"></i>{{ $related->dusun }}
                                    </small>
                                </div>
                            @endforeach
                        </div>
                    </div>
                @endif
            </div>
        </div>

        <div class="text-center mt-8">
            <a href="{{ route('umkm.index') }}" class="inline-flex items-center bg-gray-300 text-gray-800 font-semibold py-2 px-6 rounded-lg shadow-md hover:bg-gray-400 transition">
                <i class="fas fa-arrow-left me-1"></i>Kembali ke Daftar UMKM
            </a>
        </div>
    </div>
</section>

@push('scripts')
<script>
// Sederhanakan fungsi copyToClipboard menggunakan Web API
function copyToClipboard(text) {
    if (navigator.clipboard) {
        navigator.clipboard.writeText(text).then(function() {
            // Tampilkan notifikasi Tailwind sederhana
            const notification = document.createElement('div');
            notification.className = 'fixed top-4 right-4 bg-green-500 text-white px-4 py-3 rounded-lg shadow-lg z-50 text-sm animate-pulse';
            notification.innerHTML = '<i class="fas fa-check me-2"></i>Link berhasil disalin!';
            
            document.body.appendChild(notification);

            setTimeout(() => {
                notification.remove();
            }, 3000); // Hapus setelah 3 detik
        }).catch(function() {
            alert('Gagal menyalin link. Browser tidak mendukung.');
        });
    } else {
        alert('Gagal menyalin link. Silakan salin secara manual: ' + text);
    }
}
</script>
@endpush