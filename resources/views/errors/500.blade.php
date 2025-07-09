@extends('errors.error-layout')
@section('title')
    Server Error
@endsection

@section('content')
    <div class="col-xl-12 text-center">
        <h1 class="my-4 title">500 | Internal Server Error</h1>
        <div class="image-wrapper">
            <img src="{{ asset('public/errors/500.png') }}" alt="500">
        </div>
        <div class="pt-5 mt-2">
            <a href="/" class="details-btn">
                Back To Home <i class="icofont-arrow-right"></i>
            </a>
        </div>
    </div>
@endsection
