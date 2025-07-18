@extends('core::base.layouts.master')
@section('title')
    {{ translate('Smtp Configuration') }}
@endsection

@section('main_content')
    <div class="row">
        <div class="col-lg-6">
            <div class="card">
                <div class="card-header bg-white border-bottom2">
                    <h4>{{ translate('Email Configuration') }}</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('core.email.update.smtp.configuration') }}" method="POST">
                        @csrf
                        <div class="form-row mb-20">
                            <div class="col-sm-4">
                                <label class="font-14 bold black">{{ translate('Type') }} </label>
                            </div>
                            <div class="col-sm-8">
                                <select name="mail_driver" class="theme-input-style mail_driver">
                                    <option value="smtp" @if ($mail_driver == 'smtp') selected @endif>
                                        {{ translate('smtp') }}</option>
                                </select>
                                @if ($errors->has('mail_host'))
                                    <div class="invalid-input">{{ $errors->first('mail_host') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="setup-send-mail-smtp">
                            <div class="form-row mb-20">
                                <div class="col-sm-4">
                                    <label class="font-14 bold black">{{ translate('MAIL HOST') }} </label>
                                </div>
                                <div class="col-sm-8">
                                    <input type="text" name="mail_host" class="theme-input-style"
                                        placeholder="{{ translate('Type here') }}" value="{{ $mail_host }}">
                                    @if ($errors->has('mail_host'))
                                        <div class="invalid-input">{{ $errors->first('mail_host') }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="form-row mb-20">
                                <div class="col-sm-4">
                                    <label class="font-14 bold black">{{ translate('MAIL PORT') }} </label>
                                </div>
                                <div class="col-sm-8">
                                    <input type="text" name="mail_port" class="theme-input-style"
                                        placeholder="{{ translate('Type here') }}" value="{{ $mail_port }}">
                                    @if ($errors->has('mail_port'))
                                        <div class="invalid-input">{{ $errors->first('mail_port') }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="form-row mb-20">
                                <div class="col-sm-4">
                                    <label class="font-14 bold black">{{ translate('MAIL USERNAME') }} </label>
                                </div>
                                <div class="col-sm-8">
                                    <input type="text" name="mail_user_name" class="theme-input-style"
                                        placeholder="{{ translate('Type here') }}" value="{{ $mail_user_name }}">
                                    @if ($errors->has('mail_user_name'))
                                        <div class="invalid-input">{{ $errors->first('mail_user_name') }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="form-row mb-20">
                                <div class="col-sm-4">
                                    <label class="font-14 bold black">{{ translate('MAIL PASSWORD') }} </label>
                                </div>
                                <div class="col-sm-8">
                                    <input type="text" name="mail_password" class="theme-input-style"
                                        placeholder="{{ translate('Type here') }}" value="{{ $mail_password }}">
                                    @if ($errors->has('mail_password'))
                                        <div class="invalid-input">{{ $errors->first('mail_password') }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="form-row mb-20">
                                <div class="col-sm-4">
                                    <label class="font-14 bold black">{{ translate('MAIL ENCRYPTION') }} </label>
                                </div>
                                <div class="col-sm-8">
                                    <input type="text" name="mail_encryption" class="theme-input-style"
                                        placeholder="{{ translate('Type here') }}" value="{{ $mail_encryption }}">
                                    @if ($errors->has('mail_encryption'))
                                        <div class="invalid-input">{{ $errors->first('mail_encryption') }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="form-row mb-20">
                                <div class="col-sm-4">
                                    <label class="font-14 bold black">{{ translate('MAIL FROM ADDRESS') }} </label>
                                </div>
                                <div class="col-sm-8">
                                    <input type="text" name="mail_from" class="theme-input-style"
                                        placeholder="{{ translate('Type here') }}" value="{{ $mail_from }}">
                                    @if ($errors->has('mail_from'))
                                        <div class="invalid-input">{{ $errors->first('mail_from') }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="form-row mb-20">
                                <div class="col-sm-4">
                                    <label class="font-14 bold black">{{ translate('MAIL FROM NAME') }} </label>
                                </div>
                                <div class="col-sm-8">
                                    <input type="text" name="mail_from_name" class="theme-input-style"
                                        placeholder="{{ translate('Type here') }}" value="{{ $mail_from_name }}">
                                    @if ($errors->has('mail_from_name'))
                                        <div class="invalid-input">{{ $errors->first('mail_from_name') }}</div>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-12 text-right">
                                <button type="submit" class="btn long">{{ translate('Save Changes') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-lg-6 mt-3 mt-lg-0">
            <div class="card">
                <div class="card-header bg-white border-bottom2">
                    <h4>{{ translate('Send Test Mail') }}</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('core.email.send.test') }}" method="POST">
                        @csrf

                        <div class="form-row mb-20">
                            <div class="col-sm-4">
                                <label class="font-14 bold black">{{ translate('Email') }} </label>
                            </div>
                            <div class="col-sm-8">
                                <input type="email" name="email" class="theme-input-style"
                                    placeholder="{{ translate('Type here') }}">
                                @if ($errors->has('email'))
                                    <div class="invalid-input">{{ $errors->first('email') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="form-row mb-20">
                            <div class="col-sm-4">
                                <label class="font-14 bold black">{{ translate('Subject') }} </label>
                            </div>
                            <div class="col-sm-8">
                                <input type="text" name="subject" class="theme-input-style"
                                    placeholder="{{ translate('Type here') }}">
                                @if ($errors->has('subject'))
                                    <div class="invalid-input">{{ $errors->first('subject') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="form-row mb-20">
                            <div class="col-sm-4">
                                <label class="font-14 bold black">{{ translate('Message') }} </label>
                            </div>
                            <div class="col-sm-8">
                                <input type="text" name="message" class="theme-input-style"
                                    placeholder="{{ translate('Type here') }}">
                                @if ($errors->has('message'))
                                    <div class="invalid-input">{{ $errors->first('message') }}</div>
                                @endif
                            </div>
                        </div>
                        <div class="form-row">
                            <div class="col-12 text-right">
                                <button type="submit" class="btn long">{{ translate('Send') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('custom_scripts')
    <script>
        $('.mail_driver').on('change', function() {
            "use strict";
            let value = $('.mail_driver').val();
            if (value == 'smtp' || value == 'sendmail') {
                $('.main-gun-setup').addClass('d-none');
            } else {
                $('.main-gun-setup').removeClass('d-none');
            }
        });
    </script>
@endsection
