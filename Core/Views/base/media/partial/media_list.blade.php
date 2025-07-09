@php
    $media_file_type = config('settings.media_file_type');
    $media_type = array_flip(config('settings.media_type'));
    $year_months = getMonthsForUploadedFiles();
@endphp

<!-- Media List -->
<ul class="attachments list-unstyled" id="attachment-list">
    @php
        $data = json_encode($media_ids);
    @endphp
    @foreach ($all_media as $media)
        <li onclick="nextMediaSlide(event,'{{ $data }}','{{ $media->id }}')"
            id="list_item_{{ $media->id }}">
            <div class="attachment-preview">
                <div class="thumbnail">
                    @php
                        $media_path = getFilePath($media->id);
                        if ($media->file_type == 'pdf') {
                            $media_path = project_asset('/backend/assets/img/pdf-placeholder.png');
                        } elseif ($media->file_type == 'zip') {
                            $media_path = project_asset('/backend/assets/img/zip-placeholder.png');
                        } elseif ($media->file_type == 'mp4' || $media->file_type == 'video') {
                            $media_path = project_asset('/backend/assets/img/mp4-placeholder.png');
                        }
                    @endphp
                    <img class="lozad" src="{{ $media_path }}" alt="{{ $media->alt }}" />
                </div>
            </div>

            <button type="button" class="check" id="check_{{ $media->id }}">
                <i class="icofont-check icon-check"></i>
                <i class="icofont-minus icon-minus"></i>
            </button>
        </li>
    @endforeach
</ul>
<!-- /Media List -->
