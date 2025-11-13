@extends('frontend.layout')

@section('title', 'Daftar UMKM')

@section('content')
<div class="container">
    <!-- Header Section -->
    <div class="row mb-4">
        <div class="col-12">
            <h1 class="display-5 fw-bold text-center mb-3">
                <i class="fas fa-store text-primary me-2"></i>
                UMKM Desa
            </h1>
            <p class="text-center text-muted mb-4">
                Temukan dan jelajahi {{ $totalUmkm }} UMKM dari {{ $totalKategori }} kategori di desa kami
            </p>
        </div>
    </div>

    <!-- Filter Section -->
    <div class="filter-section">
        <form method="GET" action="{{ route('umkm.index') }}">
            <div class="row g-3">
                <!-- Search Box -->
                <div class="col-md-4">
                    <label class="form-label fw-bold">
                        <i class="fas fa-search me-1"></i>Pencarian
                    </label>
                    <input type="text" 
                           name="search" 
                           class="form-control" 
                           placeholder="Cari nama UMKM atau pemilik..."
                           value="{{ $search }}">
                </div>

                <!-- Kategori Filter -->
                <div class="col-md-3">
                    <label class="form-label fw-bold">
                        <i class="fas fa-tags me-1"></i>Kategori
                    </label>
                    <select name="kategori" class="form-select">
                        <option value="">Semua Kategori</option>
                        @foreach($kategoris as $kategori)
                            <option value="{{ $kategori->id }}" 
                                    {{ $kategori_id == $kategori->id ? 'selected' : '' }}>
                                {{ $kategori->icon }} {{ $kategori->nama_kategori }}
                            </option>
                        @endforeach
                    </select>
                </div>

                <!-- Dusun Filter -->
                <div class="col-md-3">
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
    @if($search || $kategori_id || $dusun)
        <div class="alert alert-info">
            <i class="fas fa-info-circle me-2"></i>
            Menampilkan {{ $umkms->count() }} dari {{ $umkms->total() }} UMKM
            @if($search) 
                untuk pencarian "<strong>{{ $search }}</strong>"
            @endif
            @if($kategori_id)
                @php $selectedKategori = $kategoris->find($kategori_id); @endphp
                dalam kategori "<strong>{{ $selectedKategori->nama_kategori }}</strong>"
            @endif
            @if($dusun)
                di dusun "<strong>{{ $dusun }}</strong>"
            @endif
        </div>
    @endif

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
                        <!-- Kategori Badge -->
                        <div class="mb-2">
                            <span class="badge bg-primary kategori-badge">
                                {{ $umkm->kategori->icon }} {{ $umkm->kategori->nama_kategori }}
                            </span>
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
                    <i class="fas fa-search fa-4x text-muted mb-3"></i>
                    <h4 class="text-muted">Tidak ada UMKM ditemukan</h4>
                    <p class="text-muted">Coba ubah kriteria pencarian Anda</p>
                    <a href="{{ route('umkm.index') }}" class="btn btn-primary">
                        <i class="fas fa-refresh me-1"></i>Reset Filter
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
</div>
@endsection

@push('scripts')
<script>
// Auto-submit form when filter changes (optional enhancement)
document.querySelectorAll('select[name="kategori"], select[name="dusun"]').forEach(function(element) {
    element.addEventListener('change', function() {
        this.form.submit();
    });
});
</script>
@endpush