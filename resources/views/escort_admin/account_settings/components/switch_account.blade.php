<div class="col-md-6">
    <div class="card">
        <div class="card-header" data-toggle="collapse" data-target="#switch_acount">
            <div class="card-actions">
                <a class="btn-minimize"><i class="mdi mdi-window-minimize"></i></a>
            </div>
            <span>@lang('Switch Account')</span>
        </div>
        <div class="card-header-sub">
            @lang('Switch to your other accounts')
        </div>
        <div class="card-body collapse show" id="switch_acount">

            {{-- notification --}}
            @if (old('notify') === 'switch_account')
            @include('EscortAdmin::common.notifications')
            @endif
            {{-- end notification --}}

            <form method="POST" action="{{ route('escort_admin.account_settings.switch_account') }}" class="es es-validation">

                {{ csrf_field() }}

                @component('EscortAdmin::common.form.group', ['key' => 'switch_email', 'labelClasses' => 'es-required es-email', 'labelId' => 'switch_email'])
                    @slot('label')
                        @lang('E-mail Address')
                    @endslot

                    @slot('input')
                        <input type="text" class="form-control" name="switch_email" id="switch_email" placeholder="{{ __('Enter E-mail Address')}}" value="">
                    @endslot
                @endcomponent

                <button type="submit" class="btn btn-primary waves-effect waves-light button-save text-uppercase">@lang('Save')</button>

            </form>
        </div>
    </div>
</div>
