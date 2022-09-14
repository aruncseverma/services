@extends('MemberAdmin::layout')

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
<div class="col-lg-12">
    <div class="card">
        <div class="row">
            <div class="col-lg-2 col-md-4">
                <div class="card-body inbox-panel"><a href="{{ route('member_admin.emails.compose') }}" class="btn btn-primary m-b-20 p-10 btn-block waves-effect waves-light">@lang('Compose')</a>
                    <ul class="list-group list-group-full">
                        <li class="list-group-item active"> <a href="{{ route('member_admin.emails.manage') }}"><i class="mdi mdi-email"></i> @lang('Inbox') </a><span class="badge badge-success ml-auto">{{ $email_count }}</span></li>
                    </ul>
                </div>
            </div>
            <div class="col-lg-10 col-md-8">
                <div class="card-body">
                    <h3 class="card-title">@lang('Compose New Message')</h3>
                    @include('MemberAdmin::common.notifications')
                    <form method="POST" action="{{ route('member_admin.emails.send') }}" class="es es-validation">
                        @csrf
                        <div class="form-group">
                            <label for="receipient" class="es-required" style="display:none;">Receipient</label>
                            <input class="form-control" id="receipient" data-role="tagsinput" name="receipient" placeholder="To:" style="width: 100% !important" value="{{ (! empty($emails = implode(',', $requestedEmails))) ? $emails : old('receipient') }}">
                            @include('MemberAdmin::common.form.error', ['key' => 'receipient'])
                        </div>
                        <div class="form-group">
                            <label for="subject" class="es-required" style="display:none;">Subject</label>
                            <input class="form-control" id="subject" name=" subject" placeholder="@lang('Subject'):" value="{{ old('subject') }}">
                            @include('MemberAdmin::common.form.error', ['key' => 'subject'])
                        </div>
                        <div class="form-group">
                            <label for="content" class="es-required" data-error-next-to="1" style="display:none;">Content</label>
                            <textarea id="content" name=" content" class="textarea_editor form-control" rows="15" placeholder="@lang('Enter text') ...">{{ old('content') }}</textarea>
                            @include('MemberAdmin::common.form.error', ['key' => 'content'])
                        </div>
                        <button type="submit" class="btn btn-success m-t-20"><i class="fa fa-envelope-o"></i> @lang('Send')</button>
                        <a href="{{ route('member_admin.emails.manage') }}" class="btn btn-inverse m-t-20"><i class="fa fa-times"></i> @lang('Discard')</a>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@pushAssets('scripts.post')
<script src="{{ asset('assets/theme/admin/default/plugins/html5-editor/wysihtml5-0.3.0.js') }}"></script>
<script src="{{ asset('assets/theme/admin/default/plugins/html5-editor/bootstrap-wysihtml5.js') }}"></script>
<script>
    $(document).ready(function() {
        $('.textarea_editor').wysihtml5();
        var receipient = $('input[name="receipient"]');
        receipient.on('beforeItemAdd', function(event) {
            //event.cancel = true;
            fnAjax({
                url: '{{ route("member_admin.emails.check_email") }}',
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
</script>
@endPushAssets