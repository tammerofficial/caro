<!-- Media Modal -->
<div class="modal fade" id="mediaUploadModal" tabindex="-1" role="dialog" aria-labelledby="mediaUploadModalLable"
    aria-hidden="true">
    <div class="modal-dialog modal-full" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLongTitle">
                    {{ translate('Media Library') }}
                </h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <div>
                    @include('core::base.media.partial.media_manager')
                </div>
            </div>
        </div>
    </div>
</div>
<!-- End Media Modal -->

<!-- Media Details-->
<div class="media-sidebar">
    <div class="media-sidebar-close pb-4">
        <i class="icofont-close-circled"></i>
    </div>
    <h6 class="mb-3">{{ translate('Media Details') }}</h6>
    <div class="media-sidebar-content">
    </div>
    <div class="media-action-area d-flex gap-10 justify-content-end flex-wrap mt-2">
        @can('Manage Media')
            <button type="button" class="btn sm btn-danger" onclick="deleteMediaFile()">
                <i class="icofont-ui-delete"></i>
            </button>
        @endcan
        <button type="button" class="btn sm btn-info insert_image">
            {{ translate('Insert') }}
        </button>
    </div>
</div>
<!-- End Media Details-->
