@extends('frontend.layouts.belanja')

@section('content')
{{-- Anggaran Pendapatan --}}
@include('frontend.belanja.sections.content-section', [
    'title' => 'ANGGARAN PENDAPATAN DESA',
    'description' => 'Rincian sumber-sumber pendapatan desa yang berasal dari Dana Desa, ADD, PAD, dan sumber lainnya.',
    'image' => asset('images/logo-placeholder.jpg'),
    'alt' => 'Anggaran Pendapatan Desa'
])

{{-- Anggaran Belanja --}}
@include('frontend.belanja.sections.content-section', [
    'title' => 'ANGGARAN BELANJA DESA',
    'description' => 'Rincian penggunaan anggaran desa untuk pembangunan infrastruktur, pemberdayaan masyarakat, dan operasional pemerintahan.',
    'image' => asset('images/logo-placeholder.jpg'),
    'alt' => 'Anggaran Belanja Desa'
])

{{-- Laporan Keuangan --}}
@include('frontend.belanja.sections.content-section', [
    'title' => 'LAPORAN KEUANGAN DESA',
    'description' => 'Laporan realisasi penggunaan dana desa dan pertanggungjawaban keuangan secara transparan.',
    'image' => asset('images/logo-placeholder.jpg'),
    'alt' => 'Laporan Keuangan Desa'
])

{{-- Grafik APBDES --}}
@include('frontend.belanja.sections.content-section', [
    'title' => 'VISUALISASI DATA APBDES',
    'description' => 'Grafik dan chart yang menampilkan data pendapatan dan belanja desa secara visual dan mudah dipahami.',
    'image' => asset('images/logo-placeholder.jpg'),
    'alt' => 'Grafik APBDES'
])
@endsection