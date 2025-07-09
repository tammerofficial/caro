@php
    $roles = getAllRoleForAssign();
    
    $placeholder_info = getPlaceHolderImage();
    $placeholder_image = '';
    $placeholder_image_alt = '';
    
    if ($placeholder_info != null) {
        $placeholder_image = $placeholder_info->placeholder_image;
        $placeholder_image_alt = $placeholder_info->placeholder_image_alt;
    }
@endphp
@extends('core::base.layouts.master')
@section('title')
    {{ translate('Update User') }}
@endsection
@section('custom_css')
    <link rel="stylesheet" href="{{ asset('/public/backend/assets/plugins/select2/select2.min.css') }}">

    <link rel="stylesheet" href="{{ asset('/public/backend/assets/plugins/daterangepicker/daterangepicker.css') }}">
@endsection
@section('main_content')
    <div class="row">
        <div class="col-md-7 mb-30">
            <!-- User profile-->
            <div class="card">
                <div class="card-body">
                    <div class="post-head d-flex justify-content-between align-items-center mb-3">
                        <div class="d-flex align-items-center">
                            <div class="content">
                                <h4 class="mb-1">{{ translate('Update Profile') }}</h4>
                            </div>
                        </div>
                    </div>

                    <div>
                        <form action="{{ route('core.update.profile') }}" method="POST" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="id" value="{{ $user->id }}">
                            <input type="hidden" name="is_for_profile" value="true">
                            <div class="form-row mb-20">
                                <div class="col-md-4">
                                    <label class="font-14 bold black">{{ translate('Profile Picture') }}</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="hidden" name="pro_pic" id="pro_pic_id" value="{{ $user->pro_pic_id }}">
                                    <div class="image-box">
                                        <div class="d-flex flex-wrap gap-10 mb-3">
                                            @if ($user->pro_pic)
                                                <div class="preview-image-wrapper">
                                                    <img src="{{ project_asset($user->pro_pic) }}"
                                                        alt="{{ $user->pro_pic_alt }}" width="150" class="preview_image"
                                                        id="pro_pic_preview" />
                                                    <button type="button" title="Remove image"
                                                        class="remove-btn style--three" id="pro_pic_remove"
                                                        onclick="removeSelection('#pro_pic_preview,#pro_pic_id,#pro_pic_remove')"><i
                                                            class="icofont-close"></i></button>
                                                </div>
                                            @else
                                                <div class="preview-image-wrapper">
                                                    <img src="{{ project_asset($placeholder_image) }}" width="150"
                                                        class="preview_image" id="pro_pic_preview" />
                                                    <button type="button" title="Remove image"
                                                        class="remove-btn style--three d-none" id="pro_pic_remove"
                                                        onclick="removeSelection('#pro_pic_preview,#pro_pic_id,#pro_pic_remove')"><i
                                                            class="icofont-close"></i></button>
                                                </div>
                                            @endif
                                        </div>
                                        <div class="image-box-actions">
                                            <button type="button" class="btn-link" data-toggle="modal"
                                                data-target="#mediaUploadModal" id="pro_pic_choose"
                                                onclick="setDataInsertableIds('#pro_pic_preview,#pro_pic_id,#pro_pic_remove')">
                                                {{ translate('Choose image') }}
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="form-row mb-20">
                                <div class="col-md-4">
                                    <label class="font-14 bold black">{{ translate('Name') }}</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="text" name="name" class="theme-input-style"
                                        value="{{ $user->name }}" placeholder="{{ translate('Give your name') }}">
                                    @if ($errors->has('name'))
                                        <div class="invalid-input">{{ $errors->first('name') }}</div>
                                    @endif
                                </div>
                            </div>

                            <div class="form-row mb-20">
                                <div class="col-md-4">
                                    <label class="font-14 bold black">{{ translate('Email') }}</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="email" name="email" class="theme-input-style"
                                        value="{{ $user->email }}"
                                        placeholder="{{ translate('Give your email address') }}">
                                    @if ($errors->has('email'))
                                        <div class="invalid-input">{{ $errors->first('email') }}</div>
                                    @endif
                                </div>
                            </div>

                            <div class="form-row mb-20">
                                <div class="col-md-4">
                                    <label class="font-14 bold black">{{ translate('Old Password') }}</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="password" name="old_password" class="theme-input-style"
                                        placeholder="{{ translate('Old password') }}">
                                    @if ($errors->has('old_password'))
                                        <div class="invalid-input">{{ $errors->first('old_password') }}</div>
                                    @endif
                                </div>
                            </div>

                            <div class="form-row mb-20">
                                <div class="col-md-4">
                                    <label class="font-14 bold black">{{ translate('Password') }}</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="password" name="password" class="theme-input-style"
                                        placeholder="{{ translate('Give your password') }}">
                                    @if ($errors->has('password'))
                                        <div class="invalid-input">{{ $errors->first('password') }}</div>
                                    @endif
                                </div>
                            </div>

                            <div class="form-row mb-20">
                                <div class="col-md-4">
                                    <label class="font-14 bold black">{{ translate('Confirm Password') }}</label>
                                </div>
                                <div class="col-md-8">
                                    <input type="password" name="password_confirmation" class="theme-input-style"
                                        placeholder="{{ translate('Confirm your password') }}">
                                    @if ($errors->has('password_confirmation'))
                                        <div class="invalid-input">{{ $errors->first('password_confirmation') }}</div>
                                    @endif
                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-md-12 text-right">
                                    <button type="submit" class="btn long">{{ translate('Update') }}</button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <!-- /User profile-->

            @include('core::base.media.partial.media_modal')

        </div>
    </div>
@endsection
@section('custom_scripts')
    <script>
        (function($) {
            "use strict";
            initDropzone()
            $(document).ready(function() {
                $('#mediaUploadModal').on('shown.bs.modal', function() {
                    $(document).off('focusin.modal');
                });

                is_for_browse_file = true
                enable_multiple_file_select = true
                filtermedia()
            })
        })(jQuery);
    </script>
@endsection
