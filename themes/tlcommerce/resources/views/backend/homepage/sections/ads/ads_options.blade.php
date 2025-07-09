<ul class="nav nav-tabs mb-20" id="myTab" role="tablist">
    <li class="nav-item">
        <a class="nav-link active" id="content-info-tab" data-toggle="tab" href="#content-info" role="tab"
            aria-controls="content-info" aria-selected="true">{{ translate('Content') }}</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="background-tab" data-toggle="tab" href="#background" role="tab"
            aria-controls="background" aria-selected="false">{{ translate('Background') }}</a>
    </li>
    <li class="nav-item">
        <a class="nav-link" id="advanced-tab" data-toggle="tab" href="#advanced" role="tab" aria-controls="button"
            aria-selected="false">{{ translate('Advanced') }}</a>
    </li>
</ul>
<div class="tab-content" id="myTabContent">

    <div class="tab-pane fade show active" id="content-info" role="tabpanel" aria-labelledby="content-info-tab">
        <div class="form-row mb-20">
            <div class="col-sm-12">
                <label class="font-14 bold black"> {{ translate('Select Layouts') }} </label>
            </div>
            <div class="col-sm-12">
                <select class="theme-input-style select-ads-layout" id="adsLayout" name="content" required>
                    <option value="">{{ translate('Select Layout') }}</option>
                    <option value="3_6_3">Layout 3-6-3 Column</option>
                    <option value="6_6">Layout 6-6 Column</option>
                    <option value="12">Layout 12 Column</option>
                    <option value="6_3_3">Layout 6-3-3 Column</option>
                    <option value="3_3_6">Layout 3-3-6 Column</option>
                </select>
                @if ($errors->has('background_size'))
                    <div class="invalid-input">{{ $errors->first('background_size') }}</div>
                @endif
            </div>
        </div>
        <div class="form-row mb-20">
            <div class="col-sm-12">
                <label class="font-14 bold black">{{ translate('Title') }} </label>
            </div>
            <div class="col-sm-12">
                <input type="text" name="title" class="theme-input-style" value="{{ old('title') }}"
                    placeholder="{{ translate('Type title') }}" required>
                @if ($errors->has('title'))
                    <div class="invalid-input">{{ $errors->first('title') }}</div>
                @endif
                <small>{{ translate('Title is not visible in homepage') }}</small>
            </div>
        </div>
    </div>

    <div class="tab-pane fade" id="background" role="tabpanel" aria-labelledby="background-tab">
        @include('theme/tlcommerce::backend.homepage.properties.background_properties_add')
    </div>

    <div class="tab-pane fade" id="advanced" role="tabpanel" aria-labelledby="advanced-tab">
        @include('theme/tlcommerce::backend.homepage.properties.advance_properties_add')
    </div>
</div>
<script>
    (function($) {

        /**
         * Select ads layout
         * 
         **/
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
</script>
