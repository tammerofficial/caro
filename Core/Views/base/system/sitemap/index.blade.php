@php
    $accpt_update = true;
    $system_current_version = systemCurrentVersion();
    $mysqlVersion = DB::select('select version() as version')[0]->version;

    $required_post_max_size = 200;
    $post_max_size = substr(ini_get('post_max_size'), 0, -1);
    if ($post_max_size < $required_post_max_size) {
        $accpt_update = false;
    }

    $required_upload_max_filesize = 200;
    $upload_max_filesize = substr(ini_get('upload_max_filesize'), 0, -1);
    if ($upload_max_filesize < $required_upload_max_filesize) {
        $accpt_update = false;
    }

    if (!is_writable(public_path())) {
        $accpt_update = false;
    }

@endphp
@extends('core::base.layouts.master')
@section('title')
    {{ translate('Site Map') }}
@endsection
@section('custom_css')
    <style>
        .update-submit-btn {
            text-decoration: none;
            padding: 10px 20px;
            background: tomato;
            display: inline-flex !important;
            align-items: center;
            margin: 0;
            color: white;
        }

        .lds-ellipsis {
            display: inline-block;
            position: relative;
            width: 70px;
            height: 13px;
        }

        .lds-ellipsis div {
            position: absolute;
            top: 0px;
            width: 13px;
            height: 13px;
            border-radius: 50%;
            background: #fff;
            animation-timing-function: cubic-bezier(0, 1, 1, 0);
        }

        .lds-ellipsis div:nth-child(1) {
            left: 8px;
            animation: lds-ellipsis1 0.6s infinite;
        }

        .lds-ellipsis div:nth-child(2) {
            left: 8px;
            animation: lds-ellipsis2 0.6s infinite;
        }

        .lds-ellipsis div:nth-child(3) {
            left: 32px;
            animation: lds-ellipsis2 0.6s infinite;
        }

        .lds-ellipsis div:nth-child(4) {
            left: 56px;
            animation: lds-ellipsis3 0.6s infinite;
        }

        @keyframes lds-ellipsis1 {
            0% {
                transform: scale(0);
            }

            100% {
                transform: scale(1);
            }
        }

        @keyframes lds-ellipsis3 {
            0% {
                transform: scale(1);
            }

            100% {
                transform: scale(0);
            }
        }

        @keyframes lds-ellipsis2 {
            0% {
                transform: translate(0, 0);
            }

            100% {
                transform: translate(24px, 0);
            }
        }
    </style>
@endsection
@section('main_content')
    <div class="row">
        <div class="col-lg-6 mx-auto mb-30">
            <div class="card">
                <div class="align-items-center bg-white card-header py-3">
                    <h4>{{ translate('Sitemap') }}</h4>

                </div>
                <div class="card-body">
                    <p class="alert alert-danger d-none alert-message">
                        <i class="icofont-warning"></i>
                        {{ translate('Do not reload or close tab while generating sitemap. It may takes some times') }}
                    </p>
                    <div class="row m-0">
                        @if (isTenant())
                            <button class="btn rounded update-submit-btn">
                                @if (!file_exists(public_path(isTenant() . '_sitemap.xml')))
                                    <span class="update-submit-btn-label">{{ translate('Generate Sitemap') }}</span>
                                @else
                                    <span class="update-submit-btn-label">{{ translate('Regenerate Sitemap') }}</span>
                                @endif
                                <div class="spinner">
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                </div>
                            </button>
                        @else
                            <button class="btn rounded update-submit-btn">
                                @if (!file_exists(public_path('sitemap.xml')))
                                    <span class="update-submit-btn-label">{{ translate('Generate Sitemap') }}</span>
                                @else
                                    <span class="update-submit-btn-label">{{ translate('Regenerate Sitemap') }}</span>
                                @endif
                                <div class="spinner">
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                    <div></div>
                                </div>
                            </button>
                        @endif
                    </div>
                    <!--Download link-->

                    @if (isTenant() && file_exists(public_path(isTenant() . '_sitemap.xml')))
                        <div class="justify-content-between m-0 mt-4 row gap-10">
                            <div class="file-info">
                                {{ asset('public/' . isTenant() . '_sitemap.xml') }}
                                <span class="mt-2 d-block sitemap-time">Last Update -
                                    {{ date('F d Y H:i:s', filemtime(public_path(isTenant() . '_sitemap.xml'))) }}
                                </span>
                            </div>
                            <a href="{{ route('core.admin.site.map.download') }}" class="btn rounded">
                                {{ translate('Download Sitemap') }}
                            </a>
                        </div>
                    @endif
                    @if (!isTenant() && file_exists(public_path('sitemap.xml')))
                        <div class="justify-content-between m-0 mt-4 row gap-10">
                            <div class="file-info">
                                {{ asset('public/sitemap.xml') }}
                                <span class="mt-2 d-block sitemap-time">Last Update -
                                    {{ date('F d Y H:i:s', filemtime(public_path('sitemap.xml'))) }}
                                </span>
                            </div>
                            <a href="{{ route('core.admin.site.map.download') }}" class="btn rounded">
                                {{ translate('Download Sitemap') }}
                            </a>
                        </div>
                    @endif
                    <!--End Download link-->
                </div>
            </div>
        </div>
    </div>
@endsection

@section('custom_scripts')
    <script type="application/javascript">
        (function($) {
            "use strict";
            /**
            * Generate Sitemap
            **/
           $('.update-submit-btn').on('click',function(e){
            $(".alert-message").removeClass('d-none');
            $(".update-submit-btn-label").text("Please wait");
                $('.spinner').addClass("lds-ellipsis");
            $.ajax({
                    headers: {
                        'X-CSRF-TOKEN': $('meta[name="_token"]').attr('content')
                    },
                    type: "POST",
                    url: '{{ route('core.admin.site.map.generate') }}',
                    success: function(response) {
                         if(response.success){
                            toastr.success('{{ translate('Sitemap generate successfully') }}');
                         }else{
                            toastr.error('{{ translate('Sitemap generate failed') }}');
                         }
                        location.reload();
                    },
                    error: function(error) {
                        toastr.error('{{ translate('Something went wrong. Please try againg') }}');
                        location.reload();
                    }
                });

           });
        })(jQuery);
    </script>
@endsection
