@php
$objectId = $objectId ?? '';
$btnId = $btnId ?? 'open_note_' . $objectId;
@endphp
<button id="{{ $btnId }}" class="btn btn-xs btn-info" title="{{ __('Add Note') }}" data-toggle="modal" data-target="#note-modal-{{ $objectId }}">
    <i class="fa fa-edit"></i>
</button>

@pushAssets('scripts.post')

<div class="modal fade" id="note-modal-{{ $objectId }}" data-object-id="{{ $objectId }}" data-notes-url="{{ route('admin.notes.view', ['object_id' => $objectId]) }}">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">@lang('Add Note')</h4>
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
            </div>

            <form method="POST" action="{{ route('admin.note.add') }}" class="es es-validation">
                <div class="modal-body">

                    <div id="prev-notes-{{ $objectId }}">
                        <i class="fa fa-circle-o-notch fa-spin"></i>
                    </div>

                    {{ csrf_field() }}
                    <input type="hidden" value="{{ $objectId }}" name="object_id">

                    <hr />
                    <textarea class="form-control" id="add_note_{{ $objectId }}" name="content" rows="5"></textarea>
                    <label for="add_note_{{ $objectId }}" class="es-required" data-error-after-label="true" style="display:none;">Note</label>
                </div>

                <div class="modal-footer">
                    <button type="submit" class="btn btn-info waves-effect">@lang('Save')</button>
                    <button type="button" class="btn btn-danger waves-effect" data-dismiss="modal">@lang('Close')</button>
                </div>
            </form>
        </div>
    </div>
</div>

{{-- table action add notes --}}
<script type=" text/javascript">
    $(function() {
        $('[id^="note-modal-" ]').on('shown.bs.modal', function() {
            var href = $(this).data('notes-url');
            var objectId = $(this).data('object-id');
            var $target = $('#prev-notes-' + objectId);
            $.ajax({
                url: href,
                cache: false,
                success: function(data) {
                    $target.html(data);
                },
                error: function(xhr) {
                    $target.html('Error while doing your request. Error Code: ' + xhr.status);
                }
            })
        });
    });
</script>
{{-- end table action add notes --}}
@endPushAssets