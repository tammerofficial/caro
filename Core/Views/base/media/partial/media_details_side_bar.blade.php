@php
    $media_path = getFilePath($details->id);
    if ($details->file_type == 'pdf') {
        $media_path = project_asset('/backend/assets/img/pdf-placeholder.png');
    } elseif ($details->file_type == 'zip') {
        $media_path = project_asset('/backend/assets/img/zip-placeholder.png');
    } elseif ($details->file_type == 'mp4' || $details->file_type == 'video') {
        $media_path = project_asset('/backend/assets/img/mp4-placeholder.png');
    }
@endphp
<div class="attachment-info align-items-center d-flex">
    <div class="thumbnail thumbnail-image">
        <img id="selected_media" src="{{ $media_path }}" alt="media" />
    </div>

    <div class="details">
        <div class="filename" id="media_name">{{ $details->name }}</div>
        <div class="media_file_uploading_date" id="media_file_uploading_date">{{ $details->created_at }}</div>
        <div class="media_file_size" id="media_file_size">{{ $details->size / 100 }} KB</div>
    </div>

</div>
<div class="attachment-meta-wrap">
    <input type="hidden" name="id" id="media_id" value="{{ $details->id }}">
    <div class="settings-wrap pb-3 mb-3 border-bottom2">
        <span class="setting mb-10 has-description">
            <label for="attachment-details-alt-text" class="name">{{ translate('Alt Text :') }}</label>
            <span id="attachment-details-alt-text">{{ $details->alt }}</span>
        </span>
        <span class="setting mb-10">
            <label for="attachment-details-title" class="name">{{ translate('Title :') }}</label>
            <span id="attachment-details-title">{{ $details->title }}</span>
        </span>
        <span class="setting mb-10">
            <label for="attachment-details-caption" class="name">{{ translate('Caption :') }}</label>
            <span id="attachment-details-caption">{{ $details->caption }}</span>
        </span>
        <span class="setting mb-10">
            <label for="attachment-details-description" class="name">{{ translate('Description :') }}</label>
            <span id="attachment-details-description">{{ $details->description }}</span>
        </span>
    </div>
</div>
