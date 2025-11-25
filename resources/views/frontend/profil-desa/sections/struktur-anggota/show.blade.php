@extends('frontend.layouts.main')

@section('title', $item->nama . ' - Struktur Organisasi Desa')

@section('content')

<section class="pt-16 mb-24">
    <div class="max-w-4xl mx-auto">

        <a href="{{ route('profil-desa.struktur-anggota.index') }}"
            class="inline-flex items-center text-blue-600 hover:text-blue-800 mb-6">
            ← Kembali ke Struktur Lengkap
        </a>

        <div class="bg-white rounded-3xl shadow-xl overflow-hidden border border-gray-200">
            <div class="relative h-96 bg-gray-100">
                @if($item->foto || $item->image || $item->foto_url)
                <img src="{{ asset('storage/' . ($item->foto ?? $item->image ?? $item->foto_url)) }}"
                    alt="{{ $item->nama }}"
                    class="w-full h-full object-cover object-top">
                @else
                <div class="w-full h-full flex items-center justify-center bg-gray-200">
                    <div class="w-32 h-32 bg-white/50 rounded-full flex items-center justify-center backdrop-blur-sm">
                        <span class="text-6xl text-gray-500">👤</span>
                    </div>
                </div>
                @endif
            </div>

            <div class="p-8">
                <h2 class="text-3xl font-bold text-heading mb-2">{{ $item->nama }}</h2>
                <p class="text-blue-600 font-semibold text-lg mb-4 uppercase">{{ $item->jabatan }}</p>

                @if($item->keterangan)
                <div class="text-body leading-relaxed">
                    {!! nl2br(e($item->keterangan)) !!}
                </div>
                @else
                <p class="text-gray-500">Tidak ada keterangan tambahan.</p>
                @endif
            </div>
        </div>
    </div>
</section>

@endsection