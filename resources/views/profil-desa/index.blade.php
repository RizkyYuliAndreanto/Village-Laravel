@extends('layouts.profil_desa')

@section('content')
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h1 class="text-2xl font-bold mb-4">Profil Desa</h1>
                    <p>Selamat datang di halaman Profil Desa. Di sini akan ditampilkan sejarah, visi misi, dan struktur organisasi desa.</p>
                    
                    {{-- Contoh placeholder konten --}}
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-6">
                        <div class="p-4 border rounded shadow-sm">
                            <h2 class="text-xl font-semibold">Sejarah Desa</h2>
                            <p class="mt-2 text-gray-600">Lorem ipsum dolor sit amet...</p>
                        </div>
                        <div class="p-4 border rounded shadow-sm">
                            <h2 class="text-xl font-semibold">Visi & Misi</h2>
                            <p class="mt-2 text-gray-600">Lorem ipsum dolor sit amet...</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection