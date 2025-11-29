@extends('frontend.layouts.main')

@section('title', 'Galeri Desa')

@section('content')
    {{-- Header Section --}}
    <section class="relative bg-gray-900 py-24 px-6 overflow-hidden">
        <div class="absolute inset-0">
            <img src="{{ asset('images/hero 2.jpg') }}" alt="Background" class="w-full h-full object-cover opacity-30">
            <div class="absolute inset-0 bg-gradient-to-t from-gray-900 via-gray-900/60 to-transparent"></div>
        </div>
        <div class="relative container mx-auto text-center z-10">
            <h1 class="text-4xl md:text-5xl font-extrabold text-white mb-4">Galeri Desa</h1>
            <p class="text-lg text-gray-300 max-w-2xl mx-auto">
                Kumpulan dokumentasi kegiatan terkini, berita, dan potensi UMKM Desa Ngengor.
            </p>
        </div>
    </section>

    {{-- Gallery Grid --}}
    <section class="py-16 bg-gray-50 min-h-screen">
        <div class="container mx-auto px-6">
            
            @if($galeri->count() > 0)
                <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-6 mb-12">
                    @foreach($galeri as $item)
                        <div class="group bg-white rounded-2xl shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden border border-gray-100 flex flex-col h-full">
                            {{-- Image Wrapper --}}
                            <div class="relative h-56 overflow-hidden">
                                <img src="{{ asset('storage/' . $item->image) }}" 
                                     alt="{{ $item->title }}" 
                                     class="w-full h-full object-cover transform group-hover:scale-110 transition-transform duration-700">
                                
                                {{-- Badge Type --}}
                                <div class="absolute top-4 left-4">
                                    <span class="px-3 py-1 text-xs font-bold text-white rounded-full 
                                        {{ $item->type == 'Berita' ? 'bg-blue-600' : 'bg-orange-500' }} shadow-lg">
                                        {{ $item->type }}
                                    </span>
                                </div>

                                {{-- Overlay Link --}}
                                <a href="{{ $item->url }}" class="absolute inset-0 bg-black/0 group-hover:bg-black/20 transition-colors duration-300"></a>
                            </div>

                            {{-- Content --}}
                            <div class="p-5 flex flex-col flex-grow">
                                <div class="text-xs text-gray-500 mb-2 flex items-center">
                                    <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                                    {{ \Carbon\Carbon::parse($item->date)->translatedFormat('d F Y') }}
                                </div>

                                <h3 class="text-lg font-bold text-gray-800 mb-2 line-clamp-2 hover:text-primary-600 transition-colors">
                                    <a href="{{ $item->url }}">{{ $item->title }}</a>
                                </h3>
                                
                                <p class="text-gray-600 text-sm line-clamp-3 mb-4 flex-grow">
                                    {{ $item->description }}
                                </p>

                                <a href="{{ $item->url }}" class="inline-flex items-center text-sm font-semibold text-primary-600 hover:text-primary-800 transition-colors mt-auto">
                                    Lihat Detail
                                    <svg class="w-4 h-4 ml-1 transform group-hover:translate-x-1 transition-transform" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8l4 4m0 0l-4 4m4-4H3"></path></svg>
                                </a>
                            </div>
                        </div>
                    @endforeach
                </div>

                {{-- Pagination Links --}}
                <div class="flex justify-center mt-8">
                    {{ $galeri->links() }} 
                </div>

            @else
                <div class="text-center py-20">
                    <div class="inline-block p-4 rounded-full bg-gray-100 mb-4">
                        <svg class="w-12 h-12 text-gray-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"></path></svg>
                    </div>
                    <h3 class="text-xl font-medium text-gray-900">Belum ada galeri</h3>
                    <p class="text-gray-500 mt-1">Data galeri akan muncul otomatis dari postingan Berita dan UMKM.</p>
                </div>
            @endif
        </div>
    </section>
@endsection