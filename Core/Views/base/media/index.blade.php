@extends('core::base.layouts.master')
@section('title')
    {{ translate('Media') }}
@endsection
@section('custom_css')
    <link rel="stylesheet" href="{{ asset('/public/backend/assets/plugins/dropzone/dropzone.min.css') }}" />
    <link rel="stylesheet" href="{{ asset('/public/backend/assets/plugins/daterangepicker/daterangepicker.css') }}">
@endsection
@section('main_content')
    <div>
        @include('core::base.media.partial.media_manager')
    </div>

    <!--Media Details Modal-->
    <div class="modal fade" id="browseImgPrev" tabindex="-1" role="dialog" aria-labelledby="browseImgPrevLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered modal-full" role="document">
            <div class="modal-content">
                <div class="modal-header align-items-center">
                    <h5 class="modal-title" id="exampleModalLongTitle">
                        {{ translate('Media Details') }}
                    </h5>
                    <div class="media-nav-wrap d-flex align-items-center" id="media_slide">
                        <span class="media-prev mr-1" onclick=""><i class="icofont-simple-left"></i></span>
                        <span class="media-next" onclick=""><i class="icofont-simple-right"></i></span>
                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">&times;</span>
                        </button>
                    </div>
                </div>
                <div class="modal-body">
                    <div class="media-img-single-preview media-library-media-preview">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!--End Media Details Modal--->
@endsection
@section('custom_scripts')
    <script src="{{ asset('/public/backend/assets/plugins/moment/moment.min.js') }}"></script>
    <script src="{{ asset('/public/backend/assets/plugins/daterangepicker/daterangepicker.js') }}"></script>
    <script src="{{ asset('/public/backend//assets/plugins/datepicker/datepicker.min.js') }}"></script>
    <script src="{{ asset('/public/backend/assets/plugins/datepicker/custom-form-datepicker.js') }}"></script>
    <script>
        (function($) {
            "use strict";
            initDropzone()
            $(document).ready(function() {
                enable_multiple_file_select = true
                filtermedia()
            })
        })(jQuery);
    </script>
@endsection
