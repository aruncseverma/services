@pushAssets('styles.post')
    <link href="{{ asset('assets/theme/admin/default/plugins/dropify/dist/css/dropify.min.css') }}" rel="stylesheet" />
@endPushAssets

<div class="col-md-6">
    <div class="card">
        <div class="card-header" data-toggle="collapse" data-target="#prof-photo">
            <div class="card-actions">
                <a class="btn-minimize"><i class="mdi mdi-window-minimize"></i></a>
            </div>
            <span>@lang('Profile Photo')</span>
        </div>
        <div class="card-header-sub">
            @lang('Change your Profile Photo')
        </div>
        <div class="card-body collapse show" id="prof-photo">
            @if (old('notify') == 'profile_photo')
                @include('MemberAdmin::common.notifications')
            @endif
            @lang('Recommended 150x200')
            <form action="{{ route('member_admin.profile.upload_profile_photo') }}" method="POST" enctype="multipart/form-data" class="es es-validation">
                @csrf
                <label for="elm_inpt_profile_photo" class="es-required" style="display:none;">Profie Photo</label>
                <input type="file" class="dropify" name="profile_photo" id="elm_inpt_profile_photo" data-default-file="{{ $member->profilePhotoUrl }}"/>
                @include('MemberAdmin::common.form.error', ['key' => 'profile_photo'])
                <button type="submit" class="btn btn-outline-danger waves-effect waves-light button-save m-t-20 text-uppercase">@lang('Save')</button>
            </form>
        </div>
    </div>
</div>

@pushAssets('scripts.post')
    <script src="{{ asset('assets/theme/admin/default/plugins/dropify/dist/js/dropify.min.js') }}"></script>
    <script src="{{ asset('assets/theme/admin/default/js/growl.min.js') }}"></script>
    <script type="text/javascript">
        // init dropify
        var drEvent = $('#elm_inpt_profile_photo').dropify();
        var DELETE_PROFILE_PHOTO_ACTION_URL = '{{ route("member_admin.profile.delete_profile_photo") }}';
        // before dropify delete event
        drEvent.on('dropify.beforeClear', function () {
            swal({
                title: 'Delete?',
                text: 'Are you sure? All changes done cannot be reverted.',
                type: "warning",
                showCancelButton: true,
                confirmButtonColor: "#DD6B55",
                confirmButtonText: 'Yes',
            }, function () {
                setTimeout(function () {
                    var $form = $('<form></form>');
                    $form.attr('action', DELETE_PROFILE_PHOTO_ACTION_URL);
                    $form.attr('method', 'POST');
                    $form.append($('<input></input>').attr('name', '_token').val($('meta[name="csrf-token"]').attr('content')));
                    $('body').append($form);
                    $form.trigger('submit');
                }, 50);
            });
            return false;
        });
    </script>
@endPushAssets
