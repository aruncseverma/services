@extends('AgencyAdmin::layout')

@section('main.content.title')
    <i class="mdi mdi-email"></i>&nbsp;{{ $title }}
@endsection

@pushAssets('styles.post')
<!-- wysihtml5 CSS -->
<link rel="stylesheet" href="{{ asset('assets/theme/admin/default/plugins/html5-editor/bootstrap-wysihtml5.css') }}" />
<style>
    /** fixed tab input width */
    .bootstrap-tagsinput {
        width: 100% !important
    }
</style>
@endPushAssets

@section('main.content')
    <div class="col-lg-2 col-md-4">
        <div class="card-body inbox-panel"><a href="{{ route('agency_admin.emails.compose') }}" class="btn btn-primary m-b-20 p-10 btn-block waves-effect waves-light">@lang('Compose')</a>
            <ul class="list-group list-group-full">
                <li class="list-group-item active"> <a href="{{ route('agency_admin.emails.manage') }}"><i class="mdi mdi-email"></i> @lang('Inbox') </a><span class="badge badge-success ml-auto">{{ $email_count }}</span></li>
            </ul>
        </div>
    </div>
    <div class="col-lg-10 col-md-8">
        <div class="card-body">
            <h3 class="card-title">@lang('Compose New Message')</h3>
            @include('AgencyAdmin::common.notifications')
            <form method="POST" action="{{ route('agency_admin.emails.send') }}" class="es es-validation">
            @csrf
                <div class="form-group">
                    <input class="form-control" data-role="tagsinput" id="receipient" name="receipient" placeholder="To:" style="width: 100% !important" value="{{ (! empty($emails = implode(',', $requestedEmails))) ? $emails : old('receipient') }}">
                    @include('AgencyAdmin::common.form.error', ['key' => 'receipient'])
                    <label for="receipient" class="es-required" data-error-after-label="true" style="display:none;">Receipent</label>
                </div>
                <div class="form-group">
                    <label for="subject" class="es-required" style="display:none;">Subject</label>
                    <input class="form-control" id="subject" name="subject" placeholder="@lang('Subject'):" value="{{ old('subject') }}">
                    @include('AgencyAdmin::common.form.error', ['key' => 'subject'])
                </div>
                <div class="form-group">
                    <textarea id="content" name="content" class="textarea_editor form-control" rows="15" placeholder="@lang('Enter text') ...">{{ old('content') }}</textarea>
                    @include('AgencyAdmin::common.form.error', ['key' => 'content'])
                    <label for="content" class="es-required" data-error-after-label="true" style="display:none;">Content</label>
                </div>
                <button type="submit" class="btn btn-success m-t-20"><i class="fa fa-envelope-o"></i> @lang('Send')</button>
                <a href="{{ route('agency_admin.emails.manage') }}" class="btn btn-inverse m-t-20"><i class="fa fa-times"></i> @lang('Discard')</a>
            </form>
        </div>
    </div>
@endsection

@pushAssets('scripts.post')
<script src="{{ asset('assets/theme/admin/default/plugins/html5-editor/wysihtml5-0.3.0.js') }}"></script>
<script src="{{ asset('assets/theme/admin/default/plugins/html5-editor/bootstrap-wysihtml5.js') }}"></script>
<script>
$(document).ready(function() {
$(document).ready(function() {
        $('.textarea_editor').wysihtml5();
        var receipient = $('input[name="receipient"]');
        receipient.on('beforeItemAdd', function(event) {
            //event.cancel = true;
            fnAjax({
                url: '{{ route("agency_admin.emails.check_email") }}',
                data: {
                    email: event.item
                },
                success: function(data) {
                    if (data.status == 0) {
                        fnAlert(data.message);
                        receipient.tagsinput('remove', event.item);
                    }
                }
            });
        });
    });
});
</script>
@endPushAssets
