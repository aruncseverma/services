<button type="submit" data-toggle="modal" data-target="#elm_watch_video_{{ $video->getKey() }}" class="btn btn-outline-danger waves-effect waves-light button-save m-t-10 m-b-10 text-uppercase" style="width: 100%">@lang('Watch Video')</button>

<div class="modal fade" id="elm_watch_video_{{ $video->getKey() }}" data-object-id="{{ $video->getKey() }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">@lang('Watch Video')</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>

            <div class="modal-body text-center">
                <video src="{{ route('common.video', ['id' => $video->getKey()]) }}" width="360" controls></video>
            </div>

            <div class="modal-footer">
                <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">@lang('Close')</button>
            </div>
        </div>
    </div>
</div>

@pushAssets('scripts.post')
<script type="text/javascript">
    $(function () {
        $('[id^="elm_watch_video_"]').on('hide.bs.modal', function (e) {
            $(this).find('video').each(function () {
                // pauses video displayed
                this.pause();
            });
        });
    });
</script>
@endPushAssets
