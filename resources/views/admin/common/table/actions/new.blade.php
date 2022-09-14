<a href="#" class="btn btn-info" title="{{ __('New Information') }}" data-toggle="modal" data-target="#edit-info-0">New</a>

<div class="modal fade" id="edit-info-0" data-href="{{ $href }}" data-object-id="0">
    <div class="modal-dialog modal-lg">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">@lang('New Information')</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>
            <form method="POST" action="{{ $action ?? '' }}" class="form">
            <div class="modal-body" id="edit-info-body-0">
                <i class="fa fa-circle-o-notch fa-spin"></i>
            </div>

            <div class="modal-footer">
                <input type="submit" value="@lang('Save')" class="btn btn-info">
                <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">@lang('Close')</button>
            </div>
          </form>
        </div>
    </div>
</div>

@pushAssets('scripts.post')
    {{-- table action view info --}}
    <script type="text/javascript">
        $(function () {
            $('[id^="edit-info-"]').on('shown.bs.modal', function () {
                //var objectId = $(this).data('object-id');
                var href = $(this).data('href');
                var $body = $('#edit-info-body-0');

                $.ajax({
                    url: href,
                    cache: false,
                    success: function (data) {
                        $body.html(data);
                    },
                    error: function (xhr) {
                        $body.html('Error while doing your request. Error Code: ' + xhr.status);
                    }
                })
            });
        });
    </script>
    {{-- end table action view info --}}
@endPushAssets
