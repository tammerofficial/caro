@extends('errors.error-layout')
@section('title')
    Not Found
@endsection

@section('content')
    <div class="col-xl-12 text-center">
        <h1 class="my-4 title">404 | Page Not Found</h1>
        <div class="image-wrapper">
            <img src="{{ asset('public/errors/404.png') }}" alt="404">
        </div>
        <div class="pt-5 mt-2">
            <a href="{{ route('admin.dashboard') }}" class="details-btn">
                Back To Home <i class="icofont-arrow-right"></i>
            </a>
        </div>
    </div>
@endsection
