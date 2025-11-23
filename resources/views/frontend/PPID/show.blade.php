@extends('frontend.layouts.ppid')

@section('content')
<!-- Hero Section dengan Background Gradient -->
<div class="section-bg-primary py-8">
    <div class="container mx-auto px-4 lg:px-8">
        <!-- Breadcrumb -->
        <nav class="mb-6" aria-label="Breadcrumb">
            <ol class="flex items-center space-x-2 text-sm">
                <li><a href="{{ route('home') }}" class="text-primary-600 hover:text-primary-700 transition-colors">Beranda</a></li>
                <li class="text-primary-400">/</li>
                <li><a href="{{ route('ppid.index') }}" class="text-primary-600 hover:text-primary-700 transition-colors">PPID</a></li>
                <li class="text-primary-400">/</li>
                <li class="text-primary-800 font-medium">{{ Str::limit($dokumen->judul_dokumen, 30) }}</li>
            </ol>
        </nav>
    </div>
</div>

<!-- Content Section -->
<div class="bg-white py-12">
    <div class="container mx-auto px-4 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-4 gap-12">

            <!-- Konten utama -->
            <main class="lg:col-span-3">
                <article class="card-bg rounded-2xl overflow-hidden shadow-lg">
                    
                    <!-- Header -->
                    <div class="p-8 lg:p-12 border-b border-primary-100">
                        <!-- Kategori Badge -->
                        <div class="mb-6">
                            <span class="px-4 py-2 bg-primary-500 text-white rounded-full text-sm font-medium shadow-lg">
                                📁 {{ ucwords(str_replace('_', ' ', $dokumen->kategori)) }}
                            </span>
                        </div>

                        <!-- Title -->
                        <h1 class="text-3xl lg:text-4xl font-bold text-heading mb-6 leading-tight">
                            {{ $dokumen->judul_dokumen }}
                        </h1>

                        <!-- Meta Information -->
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 text-sm text-muted">
                            <div class="space-y-3">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"></path>
                                    </svg>
                                    <span class="font-medium">Diunggah oleh:</span>
                                    <span>{{ $dokumen->uploader }}</span>
                                </div>
                                
                                <div class="flex items-center space-x-2">
                                    <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                    </svg>
                                    <span class="font-medium">Tanggal Upload:</span>
                                    <span>{{ $dokumen->tanggal_upload->translatedFormat('d F Y') }}</span>
                                </div>
                            </div>
                            
                            <div class="space-y-3">
                                <div class="flex items-center space-x-2">
                                    <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"></path>
                                    </svg>
                                    <span class="font-medium">Tahun:</span>
                                    <span>{{ $dokumen->tahun }}</span>
                                </div>
                                
                                <div class="flex items-center space-x-2">
                                    <svg class="w-5 h-5 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <span class="font-medium">Jenis:</span>
                                    <span>Dokumen {{ ucwords(str_replace('_', ' ', $dokumen->kategori)) }}</span>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Document Actions -->
                    <div class="p-8 lg:p-12">
                        <div class="bg-gradient-to-r from-primary-50 to-secondary-50 rounded-2xl p-6 mb-8">
                            <h3 class="text-xl font-semibold text-heading mb-4 flex items-center">
                                <svg class="w-6 h-6 mr-2 text-primary-500" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                </svg>
                                Download Dokumen
                            </h3>
                            <p class="text-body mb-6">
                                Klik tombol di bawah untuk mengunduh dokumen ini. Dokumen tersedia dalam format PDF 
                                dan dapat dibuka dengan aplikasi pembaca PDF standar.
                            </p>
                            <div class="flex flex-col sm:flex-row gap-4">
                                <a href="{{ route('ppid.download', $dokumen->id) }}" 
                                   class="btn-primary inline-flex items-center justify-center space-x-2 px-8 py-4 rounded-xl font-medium transition-all hover:scale-105"
                                   target="_blank">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"></path>
                                    </svg>
                                    <span>📥 Download Dokumen</span>
                                </a>
                                <button onclick="copyToClipboard()" 
                                        class="btn-secondary inline-flex items-center justify-center space-x-2 px-6 py-4 rounded-xl font-medium transition-all">
                                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"></path>
                                    </svg>
                                    <span>🔗 Copy Link</span>
                                </button>
                            </div>
                        </div>

                        <!-- Document Information -->
                        <div class="space-y-6">
                            <h3 class="text-2xl font-semibold text-heading">📋 Tentang Dokumen Ini</h3>
                            
                            <div class="bg-gray-50 rounded-2xl p-6">
                                <h4 class="font-semibold text-heading mb-3">Kategori Informasi:</h4>
                                <div class="text-body leading-relaxed">
                                    @switch($dokumen->kategori)
                                        @case('informasi berkala')
                                            <p>📅 <strong>Informasi Berkala</strong><br>
                                            Informasi yang wajib disediakan dan diumumkan secara berkala sesuai dengan ketentuan peraturan perundang-undangan.</p>
                                            @break
                                        @case('informasi sertamerta')
                                            <p>⚡ <strong>Informasi Sertamerta</strong><br>
                                            Informasi yang wajib diumumkan serta merta karena dapat mengancam hajat hidup orang banyak dan ketertiban umum.</p>
                                            @break
                                        @case('informasi setiap saat')
                                            <p>⏰ <strong>Informasi Setiap Saat</strong><br>
                                            Informasi yang wajib tersedia setiap saat dan dapat diakses oleh publik sesuai dengan kebutuhan.</p>
                                            @break
                                        @case('informasi dikecualikan')
                                            <p>🔒 <strong>Informasi Dikecualikan</strong><br>
                                            Informasi yang dikecualikan berdasarkan undang-undang dengan pertimbangan tertentu.</p>
                                            @break
                                        @default
                                            <p>📄 Dokumen informasi publik yang tersedia untuk masyarakat.</p>
                                    @endswitch
                                </div>
                            </div>
                            
                            <div class="bg-blue-50 rounded-2xl p-6">
                                <h4 class="font-semibold text-heading mb-3">ℹ️ Cara Menggunakan Dokumen:</h4>
                                <ul class="text-body space-y-2">
                                    <li>• Klik tombol "Download Dokumen" untuk mengunduh file</li>
                                    <li>• Gunakan aplikasi pembaca PDF untuk membuka dokumen</li>
                                    <li>• Dokumen dapat disimpan dan dicetak untuk keperluan pribadi</li>
                                    <li>• Untuk keperluan komersial, hubungi pihak berwenang</li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </article>

                <!-- Dokumen Terkait -->
                @if($dokumenTerkait->count() > 0)
                <section class="mt-12">
                    <h2 class="text-2xl font-bold text-heading mb-8 flex items-center">
                        <span class="text-3xl mr-3">📚</span>
                        Dokumen Terkait
                    </h2>

                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                        @foreach($dokumenTerkait as $item)
                            <article class="card-bg rounded-xl overflow-hidden shadow-lg hover:shadow-xl transform hover:-translate-y-1 transition-all duration-300 group">
                                <div class="p-6">
                                    <div class="flex items-start justify-between mb-3">
                                        <span class="px-3 py-1 text-xs bg-primary-100 text-primary-700 rounded-full">
                                            {{ ucwords(str_replace('_', ' ', $item->kategori)) }}
                                        </span>
                                        <span class="text-xs text-muted">{{ $item->tahun }}</span>
                                    </div>
                                    
                                    <h4 class="font-semibold text-heading group-hover:text-primary-600 transition-colors line-clamp-2 mb-3">
                                        <a href="{{ route('ppid.show', $item->id) }}">{{ $item->judul_dokumen }}</a>
                                    </h4>
                                    
                                    <div class="flex items-center text-xs text-muted space-x-4 mb-4">
                                        <span>📤 {{ $item->uploader }}</span>
                                        <span>📅 {{ $item->tanggal_upload->translatedFormat('d M Y') }}</span>
                                    </div>
                                    
                                    <div class="flex space-x-2">
                                        <a href="{{ route('ppid.show', $item->id) }}" 
                                           class="flex-1 btn-secondary text-center py-2 rounded-lg text-sm">
                                            👁️ Lihat
                                        </a>
                                        <a href="{{ route('ppid.download', $item->id) }}" 
                                           class="flex-1 btn-primary text-center py-2 rounded-lg text-sm"
                                           target="_blank">
                                            📥 Download
                                        </a>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>
                </section>
                @endif
            </main>

            <!-- Sidebar -->
            <aside class="space-y-8">
                <!-- Dokumen Terbaru -->
                @if($dokumenTerbaru->count() > 0)
                <div class="card-bg rounded-2xl p-6">
                    <h3 class="text-xl font-bold text-heading mb-6 flex items-center">
                        <span class="text-2xl mr-2">🆕</span>
                        Dokumen Terbaru
                    </h3>

                    <div class="space-y-4">
                        @foreach($dokumenTerbaru as $item)
                            <article class="group">
                                <a href="{{ route('ppid.show', $item->id) }}" class="block">
                                    <div class="p-4 rounded-xl bg-gray-50 group-hover:bg-primary-50 transition-colors">
                                        <div class="flex items-start justify-between mb-2">
                                            <span class="px-2 py-1 text-xs bg-primary-100 text-primary-700 rounded">
                                                {{ ucwords(str_replace('_', ' ', $item->kategori)) }}
                                            </span>
                                            <span class="text-xs text-muted">{{ $item->tahun }}</span>
                                        </div>
                                        
                                        <h4 class="font-semibold text-sm text-heading group-hover:text-primary-600 transition-colors line-clamp-2 mb-2">
                                            {{ $item->judul_dokumen }}
                                        </h4>
                                        
                                        <div class="flex items-center text-xs text-muted space-x-2">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path>
                                            </svg>
                                            <span>{{ $item->tanggal_upload->translatedFormat('d M Y') }}</span>
                                        </div>
                                    </div>
                                </a>
                            </article>
                            
                            @if(!$loop->last)
                                <hr class="border-primary-100">
                            @endif
                        @endforeach
                    </div>

                    <div class="mt-6 pt-4 border-t border-primary-100">
                        <a href="{{ route('ppid.index') }}" 
                           class="btn-secondary w-full flex items-center justify-center space-x-2 py-3 rounded-xl font-medium">
                            <span>📚 Lihat Semua Dokumen</span>
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"></path>
                            </svg>
                        </a>
                    </div>
                </div>
                @endif

                <!-- Quick Info -->
                <div class="card-bg rounded-2xl p-6">
                    <h3 class="text-lg font-semibold text-heading mb-4 flex items-center">
                        <span class="text-xl mr-2">ℹ️</span>
                        Informasi PPID
                    </h3>
                    
                    <div class="space-y-4 text-sm text-body">
                        <div class="bg-blue-50 rounded-lg p-4">
                            <h4 class="font-semibold mb-2">📧 Kontak PPID</h4>
                            <p>Email: ppid@desa.go.id<br>
                            Telp: (021) 123-4567</p>
                        </div>
                        
                        <div class="bg-green-50 rounded-lg p-4">
                            <h4 class="font-semibold mb-2">⏰ Jam Layanan</h4>
                            <p>Senin - Jumat<br>
                            08:00 - 16:00 WIB</p>
                        </div>
                        
                        <div class="bg-yellow-50 rounded-lg p-4">
                            <h4 class="font-semibold mb-2">📍 Alamat</h4>
                            <p>Kantor Desa<br>
                            Jl. Raya Desa No. 123</p>
                        </div>
                    </div>
                </div>

                <!-- Back Button -->
                <div class="card-bg rounded-2xl p-6">
                    <a href="{{ route('ppid.index') }}" 
                       class="btn-secondary w-full flex items-center justify-center space-x-2 py-3 rounded-xl font-medium">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"></path>
                        </svg>
                        <span>🔙 Kembali ke Daftar</span>
                    </a>
                </div>
            </aside>
        </div>
    </div>
</div>

<!-- JavaScript for copy link functionality -->
<script>
function copyToClipboard() {
    navigator.clipboard.writeText(window.location.href).then(function() {
        // Success feedback
        const button = event.target.closest('button');
        const originalText = button.innerHTML;
        button.innerHTML = '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg><span>✅ Link Disalin!</span>';
        button.classList.add('bg-green-500', 'hover:bg-green-600', 'text-white');
        button.classList.remove('btn-secondary');
        
        setTimeout(() => {
            button.innerHTML = originalText;
            button.classList.remove('bg-green-500', 'hover:bg-green-600', 'text-white');
            button.classList.add('btn-secondary');
        }, 2000);
    }).catch(function() {
        // Fallback for older browsers
        const textArea = document.createElement('textarea');
        textArea.value = window.location.href;
        document.body.appendChild(textArea);
        textArea.select();
        document.execCommand('copy');
        document.body.removeChild(textArea);
        
        const button = event.target.closest('button');
        const originalText = button.innerHTML;
        button.innerHTML = '<svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg><span>✅ Link Disalin!</span>';
        setTimeout(() => {
            button.innerHTML = originalText;
        }, 2000);
    });
}
</script>
@endsection