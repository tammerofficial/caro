@php
    if ($data == null || $data == '') {
        $data = [];
    } else {
        if (gettype($data) == 'string') {
            $data = explode(',', $data);
        }
    }

    $user_filter = isset($user_filter) && $user_filter == true ? 'true' : 'false';
@endphp
<input type="hidden" name="{{ $input }}" id="{{ $input }}_{{ $indicator }}"
    value="{{ implode(',', $data) }}">
<div class="image-box">
    <div class="d-flex flex-wrap gap-10 mb-3">
        <div id="multi_input_container_{{ $indicator }}" class="d-flex flex-wrap gap-10">
            @if (sizeof($data) == 0)
                <div class="preview-image-wrapper" id="div_preview">
                    <img src="{{ getPlaceHolderImagePath() }}" alt="{{ $input }}" width="150"
                        class="preview_image" id="preview_image" />
                </div>
            @endif
            @if (sizeof($data) > 0)
                @for ($i = 0; $i < sizeof($data); $i++)
                    @if ($data[$i] != null)
                        <div class="preview-image-wrapper"
                            id="div_preview_{{ $input }}_{{ $indicator }}_{{ $data[$i] }}">
                            <img src="{{ getFilePath($data[$i]) }}" alt="{{ $input }}" width="150"
                                class="preview_image"
                                id="preview_{{ $input }}_{{ $indicator }}_{{ $data[$i] }}" />
                            <button type="button" title="Remove image" class="remove-btn style--three"
                                id="remove_{{ $input }}_{{ $indicator }}_{{ $data[$i] }}"
                                onclick="removeSelectionForMultiSelect('#preview_{{ $input }}_{{ $indicator }}_{{ $data[$i] }},#{{ $input }}_{{ $indicator }},#remove_{{ $input }}_{{ $indicator }}_{{ $data[$i] }},#div_preview_{{ $input }}_{{ $indicator }}_{{ $data[$i] }}',{{ $data[$i] }})"><i
                                    class="icofont-close"></i></button>
                        </div>
                    @endif
                @endfor
            @endif
        </div>
    </div>
    <div class="image-box-actions">
        <button type="button" class="btn-link" data-toggle="modal" data-target="#mediaUploadModal"
            id="{{ $input }}_choose"
            onclick="setDataInsertableIdsForMultiSelect('#{{ $input }},{{ $container_id }}',{{ $indicator }}, {{ $user_filter }})">
            {{ translate('Choose Files') }}
        </button>
    </div>
</div>