@extends('core::base.layouts.master')
@section('title')
    {{ translate('Update Section') }}
@endsection
@section('custom_css')
    <style>
        .color-picker {
            width: 50px !important;
        }
    </style>
    <link rel="stylesheet" href="{{ asset('/public/backend/assets/plugins/select2/select2.min.css') }}">
@endsection
@section('main_content')
    <div>
        @if ($section_details != null)
            <form action="{{ route('theme.tlcommerce.home.page.sections.update') }}" method="POST" class="row">
                @csrf
                <div class="col-lg-8">
                    <div class="card mb-30">
                        <div class="card-header bg-white border-bottom2">
                            <div class="d-sm-flex justify-content-between align-items-center">
                                <h4>{{ getHomePageSectionProperties($section_details->id, 'title') != null ? getHomePageSectionProperties($section_details->id, 'title') : 'Section' }}
                                </h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-row mb-20 d-none">
                                <div class="col-sm-12">
                                    <select class="area-disabled layout theme-input-style" id="layout"readonly>
                                        <option value="ads" @selected(getHomePageSectionProperties($section_details->id, 'layout') == 'ads')>
                                            {{ translate('Ads') }}
                                        </option>
                                        <option value="blogs" @selected(getHomePageSectionProperties($section_details->id, 'layout') == 'blogs')>
                                            {{ translate('Blogs') }}
                                        </option>
                                        @if (isActivePluging('flashdeal'))
                                            <option value="flashdeal" @selected(getHomePageSectionProperties($section_details->id, 'layout') == 'flashdeal')>
                                                {{ translate('Flash Deal') }}
                                            </option>
                                        @endif
                                        <option value="featured_product" @selected(getHomePageSectionProperties($section_details->id, 'layout') == 'featured_product')>
                                            {{ translate('Featured Product') }}
                                        </option>
                                        <option value="category_slider" @selected(getHomePageSectionProperties($section_details->id, 'layout') == 'category_slider')>
                                            {{ translate('Category Slider') }}
                                        </option>
                                        <option value="product_collection" @selected(getHomePageSectionProperties($section_details->id, 'layout') == 'product_collection')>
                                            {{ translate('Product Collection') }}
                                        </option>
                                        <option value="custom_product_section" @selected(getHomePageSectionProperties($section_details->id, 'layout') == 'custom_product_section')>
                                            {{ translate('Custom Product Section') }}
                                        </option>
                                    </select>
                                    @if ($errors->has('layout'))
                                        <div class="invalid-input">{{ $errors->first('layout') }}</div>
                                    @endif
                                </div>
                            </div>
                            <div class="form-row">
                                <div class="col-sm-12 mt-10">
                                    <div
                                        class="section_layout {{ getHomePageSectionProperties($section_details->id, 'layout') == 'category_slider' ? 'category_slider' : 'd-none' }}">
                                        <img src="{{ asset('/public/themes/tlcommerce/assets/img/category_slide.png') }}">
                                    </div>
                                    <div
                                        class="section_layout {{ getHomePageSectionProperties($section_details->id, 'layout') == 'flashdeal' ? 'flashdeal' : 'd-none' }}">
                                        <img src="{{ asset('/public/themes/tlcommerce/assets/img/deals.png') }}">
                                    </div>
                                    <div
                                        class="section_layout {{ getHomePageSectionProperties($section_details->id, 'layout') == 'product_collection' ? 'product_collection' : 'd-none' }}">
                                        <img src="{{ asset('/public/themes/tlcommerce/assets/img/collections.png') }}">
                                    </div>
                                    <div
                                        class="section_layout {{ getHomePageSectionProperties($section_details->id, 'layout') == 'custom_product_section' ? 'custom_product_section' : 'd-none' }}">
                                        <img src="{{ asset('/public/themes/tlcommerce/assets/img/collections.png') }}">
                                    </div>
                                    <div
                                        class="section_layout {{ getHomePageSectionProperties($section_details->id, 'layout') == 'featured_product' ? 'featured_product' : 'd-none' }} ">
                                        <img
                                            src="{{ asset('/public/themes/tlcommerce/assets/img/featured_product.png') }}">
                                    </div>
                                    <div
                                        class="section_layout {{ getHomePageSectionProperties($section_details->id, 'layout') == 'blogs' ? 'blogs' : 'd-none' }} ">
                                        <img src="{{ asset('/public/themes/tlcommerce/assets/img/blog.png') }}">
                                    </div>
                                    <div
                                        class="section_layout {{ getHomePageSectionProperties($section_details->id, 'layout') == 'ads' ? 'ads' : 'd-none' }} ">
                                        <div class="selected_ads_layout row m-0">
                                            @include(
                                                'theme/tlcommerce::backend.homepage.sections.ads.ads_layout_options_edit',
                                                [
                                                    'layout' => getHomePageSectionProperties(
                                                        $section_details->id,
                                                        'content'),
                                                    'details' => $section_details,
                                                ]
                                            )
                                        </div>
                                    </div>
                                    @if (isActivePluging('multivendor'))
                                        <div
                                            class="section_layout {{ getHomePageSectionProperties($section_details->id, 'layout') == 'seller_list' ? 'seller_list' : 'd-none' }} ">
                                            <h4 class="mt-3">{{ translate('With Banner') }}</h4>
                                            <hr>
                                            <img
                                                src="{{ asset('/public/themes/tlcommerce/assets/img/seller_with_banner.png') }}">
                                            <h4 class="mt-3">{{ translate('Without Banner') }}</h4>
                                            <hr>
                                            <img
                                                src="{{ asset('/public/themes/tlcommerce/assets/img/seller_without_banner.png') }}">
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                </div>

                <div class="col-lg-4">
                    <div class="card mb-30">
                        <div class="card-header bg-white border-bottom2">
                            <div class="d-sm-flex justify-content-between align-items-center">
                                <h4>{{ translate('Section Properties') }}</h4>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="layout-options">
                                <!--Section Properties-->
                                @if (getHomePageSectionProperties($section_details->id, 'layout') == 'product_collection')
                                    @include(
                                        'theme/tlcommerce::backend.homepage.sections.product_collection.collection_options_edit',
                                        [
                                            'details' => $section_details,
                                        ]
                                    )
                                @endif

                                @if (getHomePageSectionProperties($section_details->id, 'layout') == 'category_slider')
                                    @include(
                                        'theme/tlcommerce::backend.homepage.sections.category_slider.category_slider_option_edit',
                                        [
                                            'details' => $section_details,
                                        ]
                                    )
                                @endif

                                @if (getHomePageSectionProperties($section_details->id, 'layout') == 'flashdeal')
                                    @include(
                                        'theme/tlcommerce::backend.homepage.sections.flash_deal.deal_option_edit',
                                        [
                                            'details' => $section_details,
                                        ]
                                    )
                                @endif

                                @if (getHomePageSectionProperties($section_details->id, 'layout') == 'featured_product')
                                    @include(
                                        'theme/tlcommerce::backend.homepage.sections.featured_product.featured_product_options_edit',
                                        [
                                            'details' => $section_details,
                                        ]
                                    )
                                @endif

                                @if (getHomePageSectionProperties($section_details->id, 'layout') == 'custom_product_section')
                                    @include(
                                        'theme/tlcommerce::backend.homepage.sections.custom_collection.custom_product_section_edit_option',
                                        [
                                            'details' => $section_details,
                                        ]
                                    )
                                @endif

                                @if (getHomePageSectionProperties($section_details->id, 'layout') == 'blogs')
                                    @include(
                                        'theme/tlcommerce::backend.homepage.sections.blogs.blogs_options_edit',
                                        [
                                            'details' => $section_details,
                                        ]
                                    )
                                @endif

                                @if (getHomePageSectionProperties($section_details->id, 'layout') == 'ads')
                                    @include(
                                        'theme/tlcommerce::backend.homepage.sections.ads.ads_option_edit',
                                        [
                                            'details' => $section_details,
                                        ]
                                    )
                                @endif

                                @if (getHomePageSectionProperties($section_details->id, 'layout') == 'seller_list')
                                    @include(
                                        'theme/tlcommerce::backend.homepage.sections.seller_list.seller_section_options_edit',
                                        [
                                            'details' => $section_details,
                                        ]
                                    )
                                @endif
                                <!--End Section Properties-->
                            </div>
                            <input type="hidden" name="layout" class="layout-input"
                                value="{{ getHomePageSectionProperties($section_details->id, 'layout') }}">
                            <input type="hidden" name="id" class="layout-input" value="{{ $section_details->id }}">
                            <div class="form-row">
                                <div class="col-12 text-right">
                                    <button type="submit" class="btn long">{{ translate('Save Changes') }}</button>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
            </form>
        @else
            <div class="row">
                <div class="col-12">
                    <p class="alert alert-danger text-center">{{ translate('Section not found') }}</p>
                </div>
            </div>
        @endif
    </div>
    @include('core::base.media.partial.media_modal')

@endsection
@section('custom_scripts')
    <script src="{{ asset('/public/backend/assets/plugins/select2/select2.min.js') }}"></script>
    <script>
        (function($) {
            "use strict";
            initDropzone();
            //Select ads layout
            $('.select-ads-layout').on('change', function(e) {
                let selected_ads_layout = $("select#adsLayout option").filter(":selected").val();;
                let data = {
                    'layout': selected_ads_layout,
                }
                $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    type: "POST",
                    data: data,
                    url: '{{ route('theme.tlcommerce.home.page.sections.ads.layout.options') }}',
                    success: function(data) {
                        $('.selected_ads_layout').html(data);
                    }
                });
            });
        })(jQuery);

        function selectColor(e, color) {
            let target = e.target;
            $(target).closest('.addon').find('.color-input').val(color);
        }
    </script>
    @if (isActivePluging('multivendor'))
        @include('theme/tlcommerce::backend.homepage.sections.seller_list.selller_dropdown')
    @endif
@endsection
