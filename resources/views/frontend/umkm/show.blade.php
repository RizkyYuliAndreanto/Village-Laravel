@extends('frontend.layout')

@section('title', $umkm->nama . ' - Detail UMKM')

@section('content')
<div class="container">
    <!-- Breadcrumb -->
    <nav aria-label="breadcrumb">
        <ol class="breadcrumb">
            <li class="breadcrumb-item">
                <a href="{{ route('umkm.index') }}">
                    <i class="fas fa-home me-1"></i>UMKM
                </a>
            </li>
            <li class="breadcrumb-item">
                <a href="{{ route('umkm.kategori', $umkm->kategori->slug) }}">
                    {{ $umkm->kategori->nama_kategori }}
                </a>
            </li>
            <li class="breadcrumb-item active">{{ $umkm->nama }}</li>
        </ol>
    </nav>

    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- UMKM Header -->
            <div class="card mb-4">
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-4 text-center">
                            <!-- UMKM Logo -->
                            @if($umkm->logo_url)
                                <img src="{{ $umkm->logo_url }}" 
                                     alt="{{ $umkm->nama }}" 
                                     class="img-fluid rounded shadow mb-3"
                                     style="max-height: 200px;">
                            @else
                                <div class="bg-light rounded p-4 mb-3">
                                    <i class="fas fa-store fa-5x text-muted"></i>
                                </div>
                            @endif
                            
                            <!-- Kategori Badge -->
                            <div>
                                <span class="badge bg-primary fs-6 px-3 py-2">
                                    {{ $umkm->kategori->icon }} {{ $umkm->kategori->nama_kategori }}
                                </span>
                            </div>
                        </div>

                        <div class="col-md-8">
                            <!-- UMKM Name & Owner -->
                            <h1 class="fw-bold mb-2">{{ $umkm->nama }}</h1>
                            <p class="text-muted mb-3 fs-5">
                                <i class="fas fa-user me-2"></i>Pemilik: <strong>{{ $umkm->pemilik }}</strong>
                            </p>

                            <!-- Contact Information -->
                            <div class="contact-section">
                                <h5 class="fw-bold mb-3">
                                    <i class="fas fa-address-book me-2"></i>Informasi Kontak
                                </h5>
                                
                                <!-- Address -->
                                @if($umkm->alamat || $umkm->dusun)
                                    <div class="mb-2">
                                        <i class="fas fa-map-marker-alt text-danger me-2"></i>
                                        <strong>Alamat:</strong>
                                        <div class="ms-4">
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

                                <!-- Phone -->
                                @if($umkm->telepon)
                                    <div class="mb-2">
                                        <i class="fas fa-phone text-success me-2"></i>
                                        <strong>Telepon:</strong>
                                        <a href="tel:{{ $umkm->telepon }}" class="text-decoration-none">
                                            {{ $umkm->telepon }}
                                        </a>
                                    </div>
                                @endif

                                <!-- Email -->
                                @if($umkm->email)
                                    <div class="mb-2">
                                        <i class="fas fa-envelope text-info me-2"></i>
                                        <strong>Email:</strong>
                                        <a href="mailto:{{ $umkm->email }}" class="text-decoration-none">
                                            {{ $umkm->email }}
                                        </a>
                                    </div>
                                @endif
                            </div>

                            <!-- Social Media & Contact Buttons -->
                            <div class="social-contact mt-4">
                                <h6 class="fw-bold mb-2">Hubungi Kami:</h6>
                                <div class="d-flex flex-wrap gap-2">
                                    @if($umkm->whatsapp)
                                        <a href="https://wa.me/{{ $umkm->whatsapp }}" 
                                           class="btn btn-success" 
                                           target="_blank">
                                            <i class="fab fa-whatsapp me-1"></i>WhatsApp
                                        </a>
                                    @endif
                                    
                                    @if($umkm->sosial_instagram)
                                        <a href="https://instagram.com/{{ ltrim($umkm->sosial_instagram, '@') }}" 
                                           class="btn btn-danger" 
                                           target="_blank">
                                            <i class="fab fa-instagram me-1"></i>Instagram
                                        </a>
                                    @endif
                                    
                                    @if($umkm->sosial_facebook)
                                        <a href="{{ $umkm->sosial_facebook }}" 
                                           class="btn btn-primary" 
                                           target="_blank">
                                            <i class="fab fa-facebook me-1"></i>Facebook
                                        </a>
                                    @endif
                                    
                                    @if($umkm->website)
                                        <a href="{{ $umkm->website }}" 
                                           class="btn btn-info" 
                                           target="_blank">
                                            <i class="fas fa-globe me-1"></i>Website
                                        </a>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Description Section -->
            @if($umkm->deskripsi)
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="fw-bold mb-0">
                            <i class="fas fa-info-circle me-2"></i>Tentang {{ $umkm->nama }}
                        </h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-0" style="line-height: 1.8;">
                            {!! nl2br(e($umkm->deskripsi)) !!}
                        </p>
                    </div>
                </div>
            @endif

            <!-- Products/Services Section -->
            @if($umkm->produk_layanan)
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="fw-bold mb-0">
                            <i class="fas fa-box me-2"></i>Produk & Layanan
                        </h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-0" style="line-height: 1.8;">
                            {!! nl2br(e($umkm->produk_layanan)) !!}
                        </p>
                    </div>
                </div>
            @endif

            <!-- Operating Hours -->
            @if($umkm->jam_operasional)
                <div class="card mb-4">
                    <div class="card-header">
                        <h5 class="fw-bold mb-0">
                            <i class="fas fa-clock me-2"></i>Jam Operasional
                        </h5>
                    </div>
                    <div class="card-body">
                        <p class="mb-0" style="line-height: 1.8;">
                            {!! nl2br(e($umkm->jam_operasional)) !!}
                        </p>
                    </div>
                </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Business Info Card -->
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="fw-bold mb-0">
                        <i class="fas fa-chart-line me-2"></i>Informasi Bisnis
                    </h6>
                </div>
                <div class="card-body">
                    <!-- Business Status -->
                    <div class="mb-3">
                        <strong>Status Bisnis:</strong><br>
                        @if($umkm->status_aktif)
                            <span class="badge bg-success">
                                <i class="fas fa-check-circle me-1"></i>Aktif
                            </span>
                        @else
                            <span class="badge bg-secondary">
                                <i class="fas fa-pause-circle me-1"></i>Tidak Aktif
                            </span>
                        @endif
                    </div>

                    <!-- Founded Year -->
                    @if($umkm->tahun_berdiri)
                        <div class="mb-3">
                            <strong>Tahun Berdiri:</strong><br>
                            <span class="text-muted">{{ $umkm->tahun_berdiri }}</span>
                        </div>
                    @endif

                    <!-- Employee Count -->
                    @if($umkm->jumlah_karyawan)
                        <div class="mb-3">
                            <strong>Jumlah Karyawan:</strong><br>
                            <span class="text-muted">{{ $umkm->jumlah_karyawan }} orang</span>
                        </div>
                    @endif

                    <!-- Last Updated -->
                    <div class="mb-0">
                        <strong>Terakhir Diperbarui:</strong><br>
                        <small class="text-muted">
                            {{ $umkm->updated_at->format('d M Y, H:i') }}
                        </small>
                    </div>
                </div>
            </div>

            <!-- Share Section -->
            <div class="card mb-4">
                <div class="card-header">
                    <h6 class="fw-bold mb-0">
                        <i class="fas fa-share-alt me-2"></i>Bagikan
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <button type="button" 
                                class="btn btn-outline-primary btn-sm" 
                                onclick="copyToClipboard('{{ request()->url() }}')">
                            <i class="fas fa-copy me-1"></i>Salin Link
                        </button>
                        
                        <a href="https://wa.me/?text={{ urlencode($umkm->nama . ' - ' . request()->url()) }}" 
                           class="btn btn-outline-success btn-sm" 
                           target="_blank">
                            <i class="fab fa-whatsapp me-1"></i>Bagikan via WhatsApp
                        </a>
                    </div>
                </div>
            </div>

            <!-- Related UMKMs -->
            @if($relatedUmkms->count() > 0)
                <div class="card">
                    <div class="card-header">
                        <h6 class="fw-bold mb-0">
                            <i class="fas fa-store me-2"></i>UMKM Serupa
                        </h6>
                    </div>
                    <div class="card-body p-0">
                        @foreach($relatedUmkms as $related)
                            <div class="border-bottom p-3">
                                <h6 class="fw-bold mb-1">
                                    <a href="{{ route('umkm.show', $related->slug) }}" 
                                       class="text-decoration-none">
                                        {{ $related->nama }}
                                    </a>
                                </h6>
                                <small class="text-muted d-block mb-1">
                                    <i class="fas fa-user me-1"></i>{{ $related->pemilik }}
                                </small>
                                <small class="text-muted">
                                    <i class="fas fa-map-marker-alt me-1"></i>{{ $related->dusun }}
                                </small>
                            </div>
                        @endforeach
                    </div>
                </div>
            @endif
        </div>
    </div>

    <!-- Back Button -->
    <div class="text-center mt-4">
        <a href="{{ route('umkm.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-left me-1"></i>Kembali ke Daftar UMKM
        </a>
    </div>
</div>
@endsection

@push('scripts')
<script>
function copyToClipboard(text) {
    navigator.clipboard.writeText(text).then(function() {
        // Show success message
        const toast = document.createElement('div');
        toast.className = 'toast align-items-center text-white bg-success border-0 position-fixed';
        toast.style.cssText = 'top: 20px; right: 20px; z-index: 9999;';
        toast.innerHTML = `
            <div class="d-flex">
                <div class="toast-body">
                    <i class="fas fa-check me-1"></i>Link berhasil disalin!
                </div>
                <button type="button" class="btn-close btn-close-white me-2 m-auto" data-bs-dismiss="toast"></button>
            </div>
        `;
        
        document.body.appendChild(toast);
        const bsToast = new bootstrap.Toast(toast);
        bsToast.show();
        
        // Remove element after hiding
        toast.addEventListener('hidden.bs.toast', () => {
            toast.remove();
        });
    }).catch(function() {
        alert('Gagal menyalin link. Silakan salin secara manual.');
    });
}
</script>
@endpush