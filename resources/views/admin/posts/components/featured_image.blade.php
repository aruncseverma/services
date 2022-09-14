@php
$uploadUrl = $uploadUrl ?? route('admin.post.upload_photo');
$deleteUrl = $deleteUrl ?? route('admin.post.delete_photo');
@endphp
@pushAssets('styles.post')
<link href="{{ asset('assets/theme/admin/default/plugins/dropify/dist/css/dropify.min.css') }}" rel="stylesheet" />
@endPushAssets

<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            {{-- notification --}}
            @if (old('notify') == 'post_photo')
            @include('Admin::common.notifications')
            @endif
            {{-- end notification --}}
            <h4 class="card-title">@lang('Featured Image')</h4>
            <hr />
            @lang('Recommended 150x200')
            <form action="{{ $uploadUrl }}" method="POST" enctype="multipart/form-data" class="es es-validation">
                @csrf
                <input type="hidden" name="notify" value="post_photo" />
                <input type="hidden" name="post_id" value="{{ $post->getKey() }}" />
                <div class="form-group  row">
                    <label for="elm_inpt_photo" class="col-3 control-label">Featured Photo</label>
                    <div class="col-9">
                        <input type="file" class="dropify" name="post_photo" id="elm_inpt_photo" data-default-file="{{ $post->featuredPhotoUrl }}" />
                        @include('Admin::common.form.error', ['key' => 'post_photo'])
                        @include('Admin::common.form.error', ['key' => 'post_id'])
                        <label for="elm_inpt_photo" class="es-required es-image" data-error-after-label="true" style="display:none;">Featured Photo</label>
                    </div>
                </div>
                <div class="form-actions pull-right">
                    <button type="submit" class="btn btn-success" id="btn_upload" style="display:none;">@lang('Save')</button>
                </div>
            </form>
        </div>
    </div>
</div>

@pushAssets('scripts.post')
<script src="{{ asset('assets/theme/admin/default/plugins/dropify/dist/js/dropify.min.js') }}"></script>
<script src="{{ asset('assets/theme/admin/default/js/growl.min.js') }}"></script>
<script type="text/javascript">
    var btn_upload = $('#btn_upload')
    var input_photo = $('#elm_inpt_photo');
    // init dropify
    var drEvent = input_photo.dropify();

    var DELETE_PROFILE_PHOTO_ACTION_URL = '{{ $deleteUrl }}?id={{ $post->getKey() }}';
    // before dropify delete event
    drEvent.on('dropify.beforeClear', function() {
        if (input_photo.val() == '' && input_photo.data('default-file') != '') {
            swal({
                title: 'Delete?',
                text: 'Are you sure? All changes done cannot be reverted.',
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: 'Yes',
            }, function() {
                setTimeout(function() {
                    var $form = $('<form></form>');
                    $form.attr('action', DELETE_PROFILE_PHOTO_ACTION_URL);
                    $form.attr('method', 'POST');
                    $form.append($('<input></input>').attr('name', '_token').val($('meta[name="csrf-token"]').attr('content')));
                    $('body').append($form);
                    $form.trigger('submit');
                }, 50);
            });
            return false;
        }
        btn_upload.hide();
        return true;
    });

    drEvent.on('dropify.fileReady', function() {
        btn_upload.show();
    });

    drEvent.on('dropify.afterClear', function() {
        if (input_photo.data('default-file') != '') {
            input_photo.data('dropify').setPreview(true, input_photo.data('default-file'));
        }
    });
</script>
@endPushAssets