@php
    $has_max_allowed_packet_limit = maxAllowedPacketSize();
@endphp
@extends('install.layouts.master')
@section('template_title')
    Import SQL
@endsection
@section('title')
    Import SQL
@endsection

@section('container')
    <div class="text-center">
        @if (!$has_max_allowed_packet_limit)
            <div class="alert alert-warning align-items-center d-flex justify-content-between" role="alert">
                <b>Your max_allowed_packet limit is less than 64 MB please increase, otherwise subscribers database won't be
                    created. Please reload the page after increasing limit</b>
            </div>
        @endif
        <form method="POST" action="{{ route('install.database.import.ecommerce') }}">
            @csrf
            <div class="buttons">
                <button class="button process-btn" @if (!$has_max_allowed_packet_limit) disabled @endif>
                    Import SQL
                </button>
            </div>
        </form>
    </div>
@endsection
