@extends('frontend.layout')

@section('title', 'Daftar UMKM')

@section('content')
<div class="container">
    {{-- Header Section --}}
    @include('frontend.umkm.sections.header')

    {{-- Filter Section --}}
    @include('frontend.umkm.sections.filter')

    {{-- Results Info --}}
    @include('frontend.umkm.sections.results-info')

    {{-- UMKM Grid --}}
    @include('frontend.umkm.sections.grid')

    {{-- Pagination --}}
    @include('frontend.umkm.sections.pagination')
</div>
@endsection