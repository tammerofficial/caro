@php
    $options = explode('_', $layout);
@endphp
@foreach ($options as $key => $option)
    <div class="col-{{ $option }}" style="border:1px dotted">
        @php
            $image = $key + 1 . '_' . $option . '_image';
            $url = $key + 1 . '_' . $option . '_url';
        @endphp
        <div class="form-row mb-20">
            <div class="col-sm-12">
                <label class="font-14 bold black">{{ translate('Image') }} </label>
            </div>
            <div class="col-md-12">
                @include('core::base.includes.media.media_input', [
                    'input' => $image,
                    'data' => getHomePageSectionProperties($section_details->id, $image),
                ])

            </div>
        </div>
        <div class="form-row mb-20">
            <div class="col-sm-12">
                <label class="font-14 bold black">{{ translate('Url') }} </label>
            </div>
            <div class="col-md-12">
                <input type="text" class="theme-input-style" name="{{ $url }}"
                    value="{{ getHomePageSectionProperties($section_details->id, $url) }}">
            </div>
        </div>
    </div>
@endforeach
