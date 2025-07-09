@extends('core::base.auth.auth_layout')
@section('title')
    {{ translate('Login') }}
@endsection
@section('main_content')
    <div class="mn-vh-100 d-flex align-items-center">
        <div class="container">
            <div class="col-xl-7 col-lg-9 offset-2">
                <div class="card">
                    <div class="card-header">{{ translate('Verify Your Email Address') }}</div>

                    <div class="card-body">
                        @if (session('resent'))
                            <div class="alert alert-success" role="alert">
                                {{ translate('A fresh verification link has been sent to your email address.') }}
                            </div>
                        @endif

                        {{ translate('Before proceeding, please check your email for a verification link.') }}
                        {{ translate('If you did not receive the email') }},
                        <form class="d-inline" method="POST" action="{{ route('verification.resend') }}">
                            @csrf
                            <button type="submit"
                                class="btn-link">{{ translate('click here to request another') }}</button>.
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection