<div class="col-md-6">
    <div class="card">
        <div class="card-header" data-toggle="collapse" data-target="#account_deletion">
            <div class="card-actions">
                <a class="btn-minimize"><i class="mdi mdi-window-minimize"></i></i></a>
            </div>
            <span>@lang('Account Deletion')</span>
        </div>
        <div class="card-header-sub">
            @lang('Delete your account')
        </div>
        <div class="card-body collapse show" id="account_deletion">
            <form method="POST" action="{{ route('escort_admin.account_settings.account_deletion') }}" class="es es-validation">

                {{ csrf_field() }}

                @component('EscortAdmin::common.form.group', ['key' => 'reason'])
                    @slot('label')
                        @lang('Please specify your reason why you want to delete your account')
                    @endslot

                    @slot('input')
                        <textarea class="form-control" rows="5" name="reason" id="reason"></textarea>
                        <label for="reason" class="es-required" data-error-after-label="true" style="display:none;">Reason</label>
                    @endslot
                @endcomponent

                <button type="submit" class="btn btn-primary waves-effect waves-light button-save text-uppercase es es-confirm">@lang('delete')</button>

            </form>
        </div>
    </div>
</div>
