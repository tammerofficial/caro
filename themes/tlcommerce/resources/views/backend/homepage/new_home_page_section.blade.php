@php
    
@endphp
@extends('core::base.layouts.master')
@section('title')
    {{ translate('New Home Page Section') }}
@endsection
@section('custom_css')
    <link rel="stylesheet" href="{{ asset('/public/backend/assets/plugins/select2/select2.min.css') }}">
@endsection
@section('main_content')
    <div>
        <form action="{{ route('theme.tlcommerce.home.page.sections.new.store') }}" method="POST" class="row">
            @csrf
            <div class="col-lg-8">
                <div class="card mb-30">
                    <div class="card-header bg-white border-bottom2">
                        <div class="d-sm-flex justify-content-between align-items-center">
                            <h4>{{ translate('Select Section') }}</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="form-row mb-20">
                            <div class="col-sm-12">
                                <select class="theme-input-style layout select-section" id="layout" name="layout"
                                    required>
                                    <option value="">{{ translate('Select Section') }}</option>
                                    <option value="ads">{{ translate('Ads') }}</option>
                                    <option value="blogs">{{ translate('Blogs') }}</option>
                                    @if (isActivePluging('flashdeal'))
                                        <option value="flashdeal">{{ translate('Flash Deal') }}</option>
                                    @endif
                                    <option value="featured_product">{{ translate('Featured Product') }}</option>
                                    <option value="category_slider">{{ translate('Category Slider') }}</option>
                                    <option value="product_collection">{{ translate('Product Collection') }}</option>
                                    <option value="custom_product_section">
                                        {{ translate('Custom Product Section') }}
                                    </option>
                                    @if (isActivePluging('multivendor'))
                                        <option value="seller_list">{{ translate('Seller List') }}</option>
                                    @endif
                                </select>
                                @if ($errors->has('layout'))
                                    <div class="invalid-input">{{ $errors->first('layout') }}</div>
                                @endif
                            </div>
                            <div class="col-sm-12 mt-10">
                                <div class="section_layout d-none category_slider">
                                    <img src="{{ asset('/public/themes/tlcommerce/assets/img/category_slide.png') }}">
                                </div>
                                <div class="section_layout d-none flashdeal">
                                    <img src="{{ asset('/public/themes/tlcommerce/assets/img/deals.png') }}">
                                </div>
                                <div class="section_layout d-none product_collection">
                                    <img src="{{ asset('/public/themes/tlcommerce/assets/img/collections.png') }}">
                                </div>
                                <div class="section_layout d-none custom_product_section">
                                    <img src="{{ asset('/public/themes/tlcommerce/assets/img/collections.png') }}">
                                </div>
                                <div class="section_layout d-none ads">
                                    <div class="selected_ads_layout">
                                        <img src="{{ asset('/public/themes/tlcommerce/assets/img/ads.png') }}">
                                    </div>
                                </div>
                                <div class="section_layout d-none featured_product">
                                    <img src="{{ asset('/public/themes/tlcommerce/assets/img/featured_product.png') }}">
                                </div>
                                <div class="section_layout d-none blogs">
                                    <img src="{{ asset('/public/themes/tlcommerce/assets/img/blog.png') }}">
                                </div>
                                <div class="section_layout d-none seller_list">
                                    <h4 class="mt-3">{{ translate('With Banner') }}</h4>
                                    <hr>
                                    <img src="{{ asset('/public/themes/tlcommerce/assets/img/seller_with_banner.png') }}">
                                    <h4 class="mt-3">{{ translate('Without Banner') }}</h4>
                                    <hr>
                                    <img
                                        src="{{ asset('/public/themes/tlcommerce/assets/img/seller_without_banner.png') }}">
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!--Section Properties-->
            <div class="col-lg-4">
                <div class="card mb-30">
                    <div class="card-header bg-white border-bottom2">
                        <div class="d-sm-flex justify-content-between align-items-center">
                            <h4>{{ translate('Section Properties') }}</h4>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="layout-options">

                        </div>
                        <div class="form-row d-none save-section">
                            <div class="col-12 text-right">
                                <button type="submit" class="btn long">{{ translate('Save') }}</button>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <!--End Section Properties-->
        </form>
    </div>
    @include('core::base.media.partial.media_modal')
@endsection
@section('custom_scripts')
    <script src="{{ asset('/public/backend/assets/plugins/select2/select2.min.js') }}"></script>
    <script>
        (function($) {
            "use strict";
            initDropzone();
            /**
             * Load section properties
             * 
             **/
            $('.select-section').on('change', function(e) {
                $('.layout-input').val('');
                let layout = $("select#layout option").filter(":selected").val();
                $('.section_layout').addClass('d-none');
                $('.' + layout).removeClass('d-none');
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    type: "POST",
                    data: {
                        layout: layout
                    },
                    url: '{{ route('theme.tlcommerce.home.page.sections.layout.options') }}',
                    success: function(data) {
                        $('.layout-options').html(data);
                        $('.save-section').removeClass('d-none');
                    }
                });
            });

        })(jQuery);

        function selectColor(e, color) {
            let target = e.target;
            $(target).closest('.addon').find('.color-input').val(color);
        }
    </script>
@endsection
