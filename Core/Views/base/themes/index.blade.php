@extends('core::base.layouts.master')
@section('title')
    {{ translate('Themes') }}
@endsection
@section('custom_css')
@endsection
@section('main_content')
    <div class="align-items-center border-bottom2 d-flex flex-wrap gap-10 justify-content-between mb-4 pb-3">
        <h4><i class="icofont-ui-theme"></i> {{ translate('Themes') }}</h4>
        @if (!isTenant())
            <div class="d-flex align-items-center gap-10 flex-wrap">
                <a href="{{ route('core.themes.create') }}" class="btn long">{{ translate('Install New Theme') }}</a>
            </div>
        @endif
    </div>
    @if (!isTenant())
        <div class="app-items theme-items">
            <div class="row">
                @foreach ($themes->where('type', 'saas') as $theme)
                    <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 mb-30">
                        <div class="app-item">
                            <div class="app-icon">
                                <img src="{{ asset('/themes' . '/' . $theme->location . '/banner.png') }}"
                                    alt="{{ $theme->name }}" />
                            </div>
                            <div class="app-details">
                                <h4 class="app-name">{{ $theme->name }}</h4>
                            </div>
                            <div class="app-footer">
                                <div class="app-author">
                                    {{ translate('By:') }}
                                    <a href="{{ $theme->url }}" target="_blank">{{ $theme->author }}</a>
                                </div>
                                <div class="app-version">{{ translate('Version:') }} {{ $theme->version }}</div>
                                <div class="app-description" title="{{ $theme->name }}">
                                    {{ $theme->description }}
                                </div>
                                <div class="app-actions">
                                    @if ($theme->is_activated == 1)
                                        <button class="btn sm btn-success btn-trigger-change-status"
                                            data-theme="{{ $theme->id }}">
                                            <i class="icofont-ui-check"></i> {{ translate('Activated') }}
                                        </button>
                                    @else
                                        <button class="btn sm btn-info btn-trigger-change-status activate-theme"
                                            data-theme="{{ $theme->id }}">
                                            {{ translate('Activate') }}
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="row mr-0 mt-2">
                <div class="border-bottom2 col-lg-12 mb-4 mx-3 pb-3 px-0">
                    <h4><i class="icofont-ui-theme"></i> {{ translate('Tenant Themes') }}</h4>
                </div>
                @foreach ($themes->where('type', 'store') as $theme)
                    <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 mb-30">
                        <div class="app-item">
                            <div class="app-icon">
                                <img src="{{ asset('/themes' . '/' . $theme->location . '/banner.png') }}"
                                    alt="{{ $theme->name }}" />
                            </div>
                            <div class="app-details">
                                <h4 class="app-name">{{ $theme->name }}</h4>
                            </div>
                            <div class="app-footer">
                                <div class="app-author">
                                    {{ translate('By:') }}
                                    <a href="{{ $theme->url }}" target="_blank">{{ $theme->author }}</a>
                                </div>
                                <div class="app-version">{{ translate('Version:') }} {{ $theme->version }}</div>
                                <div class="app-description" title="{{ $theme->name }}">
                                    {{ $theme->description }}
                                </div>
                                <div class="app-actions">
                                    @if ($theme->is_activated == 1)
                                        <button class="btn sm btn-success btn-trigger-change-status"
                                            data-theme="{{ $theme->id }}">{{ translate('Active') }}
                                        </button>
                                    @else
                                        <button class="btn sm btn-info btn-trigger-change-status activate-theme"
                                            data-theme="{{ $theme->id }}">
                                            {{ translate('Activate') }}
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif

    @if (isTenant())
        <div class="app-items theme-items">
            <div class="row">
                @foreach ($themes as $theme)
                    <div class="col-xl-3 col-lg-4 col-md-4 col-sm-6 mb-30">
                        <div class="app-item">
                            <div class="app-icon">
                                <img src="{{ asset('/themes' . '/' . $theme->location . '/banner.png') }}"
                                    alt="{{ $theme->name }}" />
                            </div>
                            <div class="app-details">
                                <h4 class="app-name">{{ str_replace('TL', 'E-', $theme->name) }}</h4>
                            </div>
                            <div class="app-footer">
                                <div class="app-actions">
                                    @if ($theme->is_activated == 1)
                                        <button class="btn sm btn-success btn-trigger-change-status"
                                            data-theme="{{ $theme->id }}">
                                            <i class="icofont-ui-check"></i> {{ translate('Activated') }}
                                        </button>
                                    @else
                                        <button class="btn sm btn-info btn-trigger-change-status activate-theme"
                                            data-theme="{{ $theme->id }}">
                                            {{ translate('Activate') }}
                                        </button>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        </div>
    @endif
    <!--Active Modal-->
    <div id="active-modal" class="delete-modal modal fade show" aria-modal="true">
        <div class="modal-dialog modal-sm modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title h6">{{ translate('activate Confirmation') }}</h4>
                </div>
                <div class="modal-body text-center">
                    <p class="mt-1">{{ translate('Are you sure to active this theme') }}?</p>
                    <form method="POST" action="{{ route('core.themes.activate') }}">
                        @csrf
                        <input type="hidden" id="active-theme-id" name="id">
                        <button type="button" class="btn long mt-2 btn-danger"
                            data-dismiss="modal">{{ translate('cancel') }}</button>
                        <button type="submit" class="btn long mt-2">{{ translate('Activate') }}</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <!--End Active  Modal-->
@endsection
@section('custom_scripts')
    <script>
        /**
         * Activate theme
         * */
        $('.activate-theme').on('click', function(e) {
            "use strict";
            e.preventDefault();
            let $this = $(this);
            let id = $this.data('theme');
            $("#active-theme-id").val(id);
            $('#active-modal').modal('show');
        });
    </script>
@endsection
