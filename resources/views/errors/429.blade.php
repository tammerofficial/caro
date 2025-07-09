@extends('errors.error-layout')
@section('title')
    Too Many Requests
@endsection

@section('content')
    <div class="col-xl-12 text-center">
        <h1 class="my-4 title">429 | Too Many Requests</h1>
        <div class="image-wrapper">
            <img src="{{ asset('public/errors/500.png') }}" alt="429">
        </div>
        <div class="pt-5 mt-2">
            <a href="{{ route('admin.dashboard') }}" class="details-btn">
                Back To Home <i class="icofont-arrow-right"></i>
            </a>
        </div>
    </div>
@endsection
