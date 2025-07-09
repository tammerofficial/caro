@php
$system_name = getGeneralSetting('system_name');
$desktop_logo = !empty(getGeneralSetting('admin_logo')) ? getFilePath(getGeneralSetting('admin_logo')) : '';
$login_bg_image = !empty(getGeneralSetting('login_bg_image')) ? getFilePath(getGeneralSetting('login_bg_image')) : '';
@endphp
@extends('core::base.auth.auth_layout')
@section('title')
{{ translate('Login') }}
@endsection
@section('custom_css')
<style>
    body {
        background-image: url('{{ $login_bg_image }}');
        background-size: cover;
        position: relative;
        min-height: 100vh;
    }

    body:before {
        content: "";
        background-color: rgb(183 180 180 / 50%);
        top: 0;
        height: 100%;
        left: 0;
        width: 100%;
        position: absolute;
    }

    .login-page-layout {
        height: 100vh;
        min-height: 100%;
    }
</style>
@endsection
@section('main_content')
<div class="container-fluid login-page-layout position-relative">
    <div class="align-items-center h-100 justify-content-center row py-5">
        <div class="col-xl-3 col-lg-4  col-12 mx-auto">
            <div class="card bg-white p-3 py-4">
                <div class="auth-card-header text-center pt-3">
                    <div class="logo">
                        <a href="/" class="default-logo">
                            @if (!empty($desktop_logo))
                            <img src="{{ $desktop_logo }}" alt="TLCommerce Saas">
                            @else
                            <h3>{{ $system_name }}</h3>
                            @endif
                        </a>
                    </div>
                    <h4 class="mt-3">{{ translate('Welcome Back') }}</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('core.attemptLogin') }}" method="post">
                        @csrf
                        <!-- Form Group -->
                        <div class="form-group mb-20">
                            <label for="email" class="mb-2 font-14 bold black">{{ translate('Email') }}</label>
                            <input type="email" id="email" name="email" class="theme-input-style" placeholder="{{ translate('Email Address') }}" value="{{ old('email') }}">
                            @if ($errors->has('email'))
                            <div class="text-danger mt-2">{{ $errors->first('email') }}</div>
                            @endif
                        </div>
                        <!-- End Form Group -->

                        <!-- Form Group -->
                        <div class="form-group mb-20">
                            <label for="password" class="mb-2 font-14 bold black">{{ translate('Password') }}</label>
                            <input type="password" id="password" name="password" class="theme-input-style" placeholder="{{ translate('********') }}">
                            @if ($errors->has('password'))
                            <div class="text-danger mt-2">{{ $errors->first('password') }}</div>
                            @endif
                        </div>
                        <!-- End Form Group -->

                        <div class="d-flex justify-content-between mb-20">
                            <a href="{{ route('core.password.reset.link') }}" class="font-12 text_color">{{ translate('Forgot Password?') }}</a>
                        </div>

                        <div class="d-flex align-items-center">
                            <button type="submit" class="btn btn-block">{{ translate('Log In') }}</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
