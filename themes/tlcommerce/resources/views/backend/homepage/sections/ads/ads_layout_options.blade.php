@php
    $options = explode('_', $layout);
@endphp
@if ($layout != null)
    <div class="row m-0">
        @foreach ($options as $key => $option)
            <div class="col-{{ $option }}" style="border:1px dotted">
                <div class="form-row mb-20">
                    <div class="col-sm-12">
                        <label class="font-14 bold black">{{ translate('Image') }} </label>
                    </div>
                    <div class="col-md-12">
                        @include('core::base.includes.media.media_input', [
                            'input' => $key + 1 . '_' . $option . '_image',
                            'data' => old($key + 1 . '_' . $option . '_image'),
                        ])

                    </div>
                </div>
                <div class="form-row mb-20">
                    <div class="col-sm-12">
                        <label class="font-14 bold black">{{ translate('Url') }} </label>
                    </div>
                    <div class="col-md-12">
                        <input type="text" class="theme-input-style" name="{{ $key + 1 . '_' . $option . '_url' }}">
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <p class="alert alert-danger">{{ translate('Please select a layout') }}</p>
@endif
