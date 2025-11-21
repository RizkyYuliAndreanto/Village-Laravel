@extends('frontend.layouts.main')

@section('title', 'Test Bootstrap')

@section('content')
<div class="container mt-5">
    <div class="row">
        <div class="col-12">
            <h1 class="text-primary">Bootstrap Test</h1>
            <div class="alert alert-success">
                <i class="fas fa-check"></i> Jika Anda melihat styling yang bagus dan ikon ini, Bootstrap sudah ter-load!
            </div>
            
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title">Test Card</h5>
                    <p class="card-text">Ini adalah test card Bootstrap.</p>
                    <button class="btn btn-primary">
                        <i class="fas fa-heart"></i> Test Button
                    </button>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection