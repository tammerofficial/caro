@php
    $image_types = getAllImageTypes();
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
    {{ translate('Media Settings') }}
@endsection
@section('custom_css')
    <link rel="stylesheet" href="{{ asset('/public/backend/assets/plugins/select2/select2.min.css') }}">
@endsection
@section('main_content')
    <!-- Image Settings -->
    <div class="row">
        <div class="col-md-8 mb-30 mx-auto">
            <div class="card">
                <div class="card-header bg-white py-3">
                    <h4 class="mb-0">{{ translate('Media Settings') }}</h4>
                </div>
                <div class="card-body">
                    <form action="{{ route('core.store.media.settings') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @if (!isTenant())
                            <div class="form-row mb-20">
                                <div class="col-sm-4">
                                    <label class="font-14 bold black">{{ translate('File Storage') }} </label>
                                </div>
                                <div class="col-sm-8">
                                    <select name="file_storage" class="theme-input-style file_storage_option">
                                        <option value="public" @if (getGeneralSetting('file_storage') == 'public') selected @endif>
                                            {{ translate('Local') }}
                                        </option>
                                        <option value="amazons3" @if (getGeneralSetting('file_storage') == 'amazons3') selected @endif>
                                            {{ translate('Amazone S3') }}
                                        </option>
                                    </select>
                                    @if ($errors->has('file_storage'))
                                        <div class="invalid-input">{{ $errors->first('file_storage') }}</div>
                                    @endif
                                </div>
                            </div>
                            <!--Amazon s3 settings-->
                            <div
                                class="amazon-s3-setup {{ getGeneralSetting('file_storage') == 'amazons3' ? '' : 'd-none' }}">
                                <div class="form-row mb-20">
                                    <div class="col-sm-4">
                                        <label class="font-14 bold black">{{ translate('AWS ACCESS KEY ID') }}
                                        </label>
                                    </div>
                                    <div class="col-sm-8">
                                        <input type="text" name="aws_access_key_id" class="theme-input-style"
                                            placeholder="{{ translate('Type here') }}"
                                            value="{{ env('AWS_ACCESS_KEY_ID') }}">
                                        @if ($errors->has('aws_access_key_id'))
                                            <div class="invalid-input">{{ $errors->first('aws_access_key_id') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-row mb-20">
                                    <div class="col-sm-4">
                                        <label class="font-14 bold black">{{ translate('AWS SECRET ACCESS KEY') }}
                                        </label>
                                    </div>
                                    <div class="col-sm-8">
                                        <input type="text" name="aws_secret_access_key" class="theme-input-style"
                                            placeholder="{{ translate('Type here') }}"
                                            value="{{ env('AWS_SECRET_ACCESS_KEY') }}">
                                        @if ($errors->has('aws_secret_access_key'))
                                            <div class="invalid-input">{{ $errors->first('aws_secret_access_key') }}
                                            </div>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-row mb-20">
                                    <div class="col-sm-4">
                                        <label class="font-14 bold black">{{ translate('AWS DEFAULT REGION') }}
                                        </label>
                                    </div>
                                    <div class="col-sm-8">
                                        <input type="text" name="aws_default_region" class="theme-input-style"
                                            placeholder="{{ translate('Type here') }}"
                                            value="{{ env('AWS_DEFAULT_REGION') }}">
                                        @if ($errors->has('aws_default_region'))
                                            <div class="invalid-input">
                                                {{ $errors->first('aws_default_region') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-row mb-20">
                                    <div class="col-sm-4">
                                        <label class="font-14 bold black">{{ translate('AWS BUCKET') }}
                                        </label>
                                    </div>
                                    <div class="col-sm-8">
                                        <input type="text" name="aws_bucket" class="theme-input-style"
                                            placeholder="{{ translate('Type here') }}" value="{{ env('AWS_BUCKET') }}">
                                        @if ($errors->has('aws_bucket'))
                                            <div class="invalid-input">
                                                {{ $errors->first('aws_bucket') }}</div>
                                        @endif
                                    </div>
                                </div>
                                <div class="form-row mb-20">
                                    <div class="col-sm-4">
                                        <label class="font-14 bold black">{{ translate('AWS URL') }}
                                        </label>
                                    </div>
                                    <div class="col-sm-8">
                                        <input type="text" name="aws_endpoint" class="theme-input-style"
                                            placeholder="{{ translate('Type here') }}" value="{{ env('AWS_URL') }}">
                                        @if ($errors->has('aws_endpoint'))
                                            <div class="invalid-input">
                                                {{ $errors->first('aws_endpoint') }}</div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <!--End Amazon s3 settings-->
                            <hr>
                        @else
                            <input type="hidden" name="file_storage"
                                value="{{ getGeneralSetting('file_storage') == 'public' ? 'public' : 'amazons3' }}">
                        @endif

                        <div class="form-row mb-20">
                            <div class="col-md-4">
                                <label class="font-14 bold black">{{ translate('Placeholder Image') }}</label>
                            </div>
                            <div class="col-md-8">
                                @include('core::base.includes.media.media_input', [
                                    'input' => 'placeholder_image',
                                    'data' => getGeneralSetting('placeholder_image'),
                                ])
                                @if ($errors->has('placeholder_image'))
                                    <div class="invalid-input">{{ $errors->first('placeholder_image') }}</div>
                                @endif
                            </div>
                        </div>
                        <hr>
                        <h4 class="mb-4">{{ translate('Watermark Settings') }}</h4>
                        <div class="form-row mb-20">
                            <div class="col-md-4">
                                <label class="font-14 bold black">{{ translate('Enable/Disable Watermark') }}</label>
                            </div>
                            <div class="col-md-8">
                                <label class="switch glow primary medium">
                                    <input type="checkbox" name="watermark_status" id="watermark_status"
                                        @checked(getGeneralSetting('watermark_status') == 'on')>
                                    <span class="control"></span>
                                </label>
                            </div>
                        </div>

                        <div
                            class="form-row mb-20 watermark_image_settings {{ getGeneralSetting('watermark_status') == 'on' ? '' : 'd-none' }}">
                            <div class="col-md-4">
                                <label class="font-14 bold black">{{ translate('Watermark Image') }}</label>
                            </div>
                            <div class="col-md-8">
                                @include('core::base.includes.media.media_input', [
                                    'input' => 'watermark_image',
                                    'data' => getGeneralSetting('watermark_image'),
                                ])
                                @if ($errors->has('watermark_image'))
                                    <div class="invalid-input">{{ $errors->first('watermark_image') }}</div>
                                @endif
                            </div>
                        </div>

                        <div
                            class="form-row mb-20 watermark_image_settings {{ getGeneralSetting('watermark_status') == 'on' ? '' : 'd-none' }}">
                            <div class="col-md-4">
                                <label class="font-14 bold black">{{ translate('Watermark Image Position') }}</label>
                            </div>
                            <div class="col-md-8">
                                <select class="theme-input-style" name="watermark_image_position">
                                    <option value="top-left" class="text-uppercase" @selected(getGeneralSetting('watermark_image_position') == 'top-left')>
                                        {{ translate('Top Left') }}
                                    </option>
                                    <option value="top" class="text-uppercase" @selected(getGeneralSetting('watermark_image_position') == 'top')>
                                        {{ translate('Top') }}
                                    </option>
                                    <option value="top-right" class="text-uppercase" @selected(getGeneralSetting('watermark_image_position') == 'top-right')>
                                        {{ translate('Top Right') }}
                                    </option>
                                    <option value="left" class="text-uppercase" @selected(getGeneralSetting('watermark_image_position') == 'left')>
                                        {{ translate('Left') }}
                                    </option>
                                    <option value="center" class="text-uppercase" @selected(getGeneralSetting('watermark_image_position') == 'center')>
                                        {{ translate('Center') }}
                                    </option>
                                    <option value="right" class="text-uppercase" @selected(getGeneralSetting('watermark_image_position') == 'right')>
                                        {{ translate('Right') }}
                                    </option>
                                    <option value="bottom-left" class="text-uppercase" @selected(getGeneralSetting('watermark_image_position') == 'bottom-left')>
                                        {{ translate('Bottom Left') }}
                                    </option>
                                </select>
                                @if ($errors->has('watermark_image'))
                                    <div class="invalid-input">{{ $errors->first('watermark_image') }}</div>
                                @endif
                            </div>

                        </div>

                        <div
                            class="form-row mb-20 watermark_image_settings {{ getGeneralSetting('watermark_status') == 'on' ? '' : 'd-none' }}">
                            <div class="col-md-4">
                                <label
                                    class="font-14 bold black">{{ translate('Watermarking image opacity (%)') }}</label>
                            </div>
                            <div class="col-md-8">
                                <input type="number" name="water_marking_image_opacity" min="1"
                                    class="theme-input-style"
                                    value="{{ getGeneralSetting('water_marking_image_opacity') }}"
                                    placeholder="{{ translate('Watermarking image opacity') }}">
                                @if ($errors->has('water_marking_image_opacity'))
                                    <div class="invalid-input">{{ $errors->first('water_marking_image_opacity') }}
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="form-row">
                            <div class="col-md-12 text-right">
                                <button type="submit" class="btn long">{{ translate('Submit') }}</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    @include('core::base.media.partial.media_modal')
    </div>
    <!-- /Image Settings -->
@endsection
@section('custom_scripts')
    <script src="{{ asset('/public/backend/assets/plugins/select2/select2.min.js') }}"></script>
    <script>
        (function($) {
            "use strict";
            initDropzone()
            $(document).ready(function() {
                is_for_browse_file = true
                filtermedia()
                //Select file storage system
                $('.file_storage_option').on('change', function(e) {
                    let value = $(this).val();
                    if (value == 'amazons3') {
                        $('.amazon-s3-setup').removeClass('d-none');
                    } else {
                        $('.amazon-s3-setup').addClass('d-none');
                    }
                });
                //Enable and disbale watermark image
                $('#watermark_status').on('change', function(e) {
                    if (!$('#watermark_status').is(":checked")) {
                        $('.watermark_image_settings').addClass('d-none');
                    } else {
                        $('.watermark_image_settings').removeClass('d-none');
                    }
                });
            });
        })(jQuery);
    </script>
@endsection