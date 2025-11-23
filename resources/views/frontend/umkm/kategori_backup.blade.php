@extends('frontend.layouts.main')

@section('title', $kategori->nama_kategori . ' - Kategori UMKM')
@section('meta_description', 'UMKM kategori ' . $kategori->nama_kategori . ' di desa kami. Temukan berbagai usaha berkualitas.')

@section('content')
<!-- Hero Section -->
<section class="hero-gradient py-4">
    <div class="container">
        <!-- Breadcrumb -->
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb text-white">
                <li class="breadcrumb-item">
                    <a href="{{ route('umkm.index') }}" class="text-white/80 hover:text-white">
                        <i class="fas fa-home me-1"></i>UMKM
                    </a>
                </li>
                <li class="breadcrumb-item active text-white">{{ $kategori->nama_kategori }}</li>
            </ol>
        </nav>
    </div>
</section>

<!-- Main Content -->
<section class="py-5 bg-gradient-to-br from-blue-50 to-white dark:from-blue-900 dark:to-gray-900">
    <div class="container">
        <!-- Category Header -->
        <div class="row mb-4">
        <div class="col-12">
            <div class="card bg-primary text-white">
                <div class="card-body text-center py-5">
                    <div class="mb-3">
                        <span style="font-size: 4rem;">{{ $kategori->icon }}</span>
                    </div>
                    <h1 class="display-5 fw-bold mb-3">{{ $kategori->nama_kategori }}</h1>
                    
                    @if($kategori->deskripsi)
                        <p class="lead mb-3">{{ $kategori->deskripsi }}</p>
                    @endif
                    
                    <p class="mb-0">
                        <i class="fas fa-store me-2"></i>
                        {{ $umkms->total() }} UMKM tersedia dalam kategori ini
                    </p>
                </div>
            </div>
        </div>
    </div>

    <!-- Search & Filter Section -->
    <div class="filter-section">
        <form method="GET" action="{{ route('umkm.kategori', $kategori->slug) }}">
            <div class="row g-3">
                <!-- Search Box -->
                <div class="col-md-6">
                    <label class="form-label fw-bold">
                        <i class="fas fa-search me-1"></i>Pencarian dalam {{ $kategori->nama_kategori }}
                    </label>
                    <input type="text" 
                           name="search" 
                           class="form-control" 
                           placeholder="Cari nama UMKM atau pemilik..."
                           value="{{ $search }}">
                </div>

                <!-- Dusun Filter -->
                <div class="col-md-4">
                    <label class="form-label fw-bold">
                        <i class="fas fa-map-marker-alt me-1"></i>Dusun
                    </label>
                    <select name="dusun" class="form-select">
                        <option value="">Semua Dusun</option>
                        @foreach($dusuns as $dusunItem)
                            <option value="{{ $dusunItem }}" 
                                    {{ $dusun == $dusunItem ? 'selected' : '' }}>
                                {{ $dusunItem }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Filter Button -->
                <div class="col-md-2">
                    <label class="form-label">&nbsp;</label>
                    <div class="d-grid">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-filter me-1"></i>Filter
                        </button>
                    </div>
                </div>
            </div>
        </form>
    </div>

    <!-- Results Info -->
    @if($search || $dusun)
        <div class="alert alert-info">
            <i class="fas fa-info-circle me-2"></i>
            Menampilkan {{ $umkms->count() }} dari {{ $umkms->total() }} UMKM {{ $kategori->nama_kategori }}
            @if($search) 
                untuk pencarian "<strong>{{ $search }}</strong>"
            @endif
            @if($dusun)
                di dusun "<strong>{{ $dusun }}</strong>"
            @endif
        </div>
    @endif

    <!-- Quick Stats -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <i class="fas fa-store fa-2x text-primary mb-2"></i>
                    <h4 class="fw-bold">{{ $umkms->total() }}</h4>
                    <small class="text-muted">Total UMKM</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <i class="fas fa-map-marker-alt fa-2x text-success mb-2"></i>
                    <h4 class="fw-bold">{{ $dusuns->count() }}</h4>
                    <small class="text-muted">Dusun</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <i class="fas fa-check-circle fa-2x text-info mb-2"></i>
                    <h4 class="fw-bold">{{ $activeCount }}</h4>
                    <small class="text-muted">Aktif</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card text-center">
                <div class="card-body">
                    <i class="fas fa-whatsapp fa-2x text-success mb-2"></i>
                    <h4 class="fw-bold">{{ $whatsappCount }}</h4>
                    <small class="text-muted">WhatsApp</small>
                </div>
            </div>
        </div>
    </div>

    <!-- UMKM Cards Grid -->
    <div class="row">
        @forelse($umkms as $umkm)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card umkm-card h-100">
                    <!-- UMKM Logo/Image -->
                    <div class="card-img-top bg-light d-flex align-items-center justify-content-center" 
                         style="height: 200px;">
                        @if($umkm->logo_url)
                            <img src="{{ $umkm->logo_url }}" 
                                 alt="{{ $umkm->nama }}" 
                                 class="img-fluid rounded" 
                                 style="max-height: 180px; max-width: 100%;">
                        @else
                            <div class="text-center text-muted">
                                <i class="fas fa-store fa-4x mb-2"></i>
                                <div>{{ $umkm->nama }}</div>
                            </div>
                        @endif
                    </div>

                    <div class="card-body">
                        <!-- Status Badge -->
                        <div class="mb-2">
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

                        <!-- UMKM Name -->
                        <h5 class="card-title fw-bold">{{ $umkm->nama }}</h5>
                        
                        <!-- Owner -->
                        <p class="text-muted mb-2">
                            <i class="fas fa-user me-1"></i>{{ $umkm->pemilik }}
                        </p>

                        <!-- Description -->
                        <p class="card-text">
                            {{ Str::limit($umkm->deskripsi, 100) }}
                        </p>

                        <!-- Contact Info -->
                        <div class="contact-info mb-3">
                            @if($umkm->dusun)
                                <div class="mb-1">
                                    <i class="fas fa-map-marker-alt text-danger me-1"></i>
                                    {{ $umkm->dusun }}
                                    @if($umkm->rt && $umkm->rw)
                                        RT {{ $umkm->rt }}/RW {{ $umkm->rw }}
                                    @endif
                                </div>
                            @endif
                            
                            @if($umkm->telepon)
                                <div class="mb-1">
                                    <i class="fas fa-phone text-success me-1"></i>
                                    {{ $umkm->telepon }}
                                </div>
                            @endif

                            @if($umkm->tahun_berdiri)
                                <div class="mb-1">
                                    <i class="fas fa-calendar text-info me-1"></i>
                                    Berdiri {{ $umkm->tahun_berdiri }}
                                </div>
                            @endif
                        </div>
                    </div>

                    <!-- Card Footer -->
                    <div class="card-footer bg-transparent">
                        <div class="d-flex justify-content-between align-items-center">
                            <!-- Social Media Links -->
                            <div>
                                @if($umkm->whatsapp)
                                    <a href="https://wa.me/{{ $umkm->whatsapp }}" 
                                       class="btn btn-success btn-sm me-1" 
                                       target="_blank" 
                                       title="WhatsApp">
                                        <i class="fab fa-whatsapp"></i>
                                    </a>
                                @endif
                                
                                @if($umkm->sosial_instagram)
                                    <a href="https://instagram.com/{{ ltrim($umkm->sosial_instagram, '@') }}" 
                                       class="btn btn-danger btn-sm me-1" 
                                       target="_blank" 
                                       title="Instagram">
                                        <i class="fab fa-instagram"></i>
                                    </a>
                                @endif
                            </div>

                            <!-- Detail Button -->
                            <a href="{{ route('umkm.show', $umkm->slug) }}" 
                               class="btn btn-primary btn-sm">
                                <i class="fas fa-eye me-1"></i>Detail
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <!-- No Results -->
            <div class="col-12">
                <div class="text-center py-5">
                    <div class="mb-4" style="font-size: 4rem; opacity: 0.3;">
                        {{ $kategori->icon }}
                    </div>
                    <h4 class="text-muted">Belum ada UMKM dalam kategori ini</h4>
                    <p class="text-muted">
                        @if($search || $dusun)
                            Tidak ada UMKM yang sesuai dengan kriteria pencarian Anda
                        @else
                            Kategori {{ $kategori->nama_kategori }} belum memiliki UMKM yang terdaftar
                        @endif
                    </p>
                    
                    @if($search || $dusun)
                        <a href="{{ route('umkm.kategori', $kategori->slug) }}" class="btn btn-primary me-2">
                            <i class="fas fa-refresh me-1"></i>Reset Filter
                        </a>
                    @endif
                    
                    <a href="{{ route('umkm.index') }}" class="btn btn-outline-primary">
                        <i class="fas fa-arrow-left me-1"></i>Lihat Semua UMKM
                    </a>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($umkms->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $umkms->links() }}
        </div>
    @endif

    <!-- Other Categories -->
    @if($otherCategories->count() > 0)
        <div class="mt-5">
            <h4 class="fw-bold mb-3">
                <i class="fas fa-tags me-2"></i>Kategori Lainnya
            </h4>
            
            <div class="row">
                @foreach($otherCategories as $otherKategori)
                    <div class="col-lg-3 col-md-4 col-sm-6 mb-3">
                        <a href="{{ route('umkm.kategori', $otherKategori->slug) }}" 
                           class="text-decoration-none">
                            <div class="card h-100 border-2 category-card">
                                <div class="card-body text-center">
                                    <div class="mb-2" style="font-size: 2.5rem;">
                                        {{ $otherKategori->icon }}
                                    </div>
                                    <h6 class="fw-bold mb-1">{{ $otherKategori->nama_kategori }}</h6>
                                    <small class="text-muted">
                                        {{ $otherKategori->umkm_count ?? 0 }} UMKM
                                    </small>
                                </div>
                            </div>
                        </a>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
</div>
@endsection

@push('styles')
<style>
.category-card {
    transition: all 0.3s ease;
    border-color: #e0e0e0 !important;
}

.category-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 8px 25px rgba(0,0,0,0.1);
    border-color: #007bff !important;
}
</style>
@endpush

@push('scripts')
<script>
// Auto-submit form when filter changes (optional enhancement)
document.querySelector('select[name="dusun"]').addEventListener('change', function() {
    this.form.submit();
});
</script>
@endpush