<div class="col-lg-12">
    <div class="card">
        <div class="card-header" data-toggle="collapse" data-target="#change_password">
            <div class="card-actions">
                <a class="btn-minimize"><i class="mdi mdi-window-minimize"></i></a>
            </div>
            <span>@lang('Password')</span>
        </div>
        <div class="card-header-sub">
            @lang('Change your password')<br />@lang('Change it now! you have been hacked!')
        </div>
        <div class="card-body collapse show" id="change_password">

            {{-- notification --}}
            @if (old('notify') === 'change_password')
            @include('EscortAdmin::common.notifications')
            @endif
            {{-- end notification --}}

            <form method="POST" action="{{ route('escort_admin.account_settings.change_password') }}" class="es es-validation">

                {{ csrf_field() }}

                @component('EscortAdmin::common.form.group', ['key' => 'current_password', 'labelClasses' => 'es-required'])
                    @slot('label')
                        @lang('Current Password')
                    @endslot

                    @slot('input')
                        <input type="password" class="form-control" name="current_password" id="current_password" placeholder="{{ __('Password')}}" value="">
                    @endslot
                @endcomponent

                @component('EscortAdmin::common.form.group', ['key' => 'confirm_password', 'labelClasses' => 'es-required es-same', 'labelAttrs' => 'data-same-target=current_password'])
                    @slot('label')
                        @lang('Confirm Password')
                    @endslot

                    @slot('input')
                        <input type="password" class="form-control" name="confirm_password" id="confirm_password" placeholder="{{ __('Confirm Password')}}" value="">
                    @endslot
                @endcomponent

                @component('EscortAdmin::common.form.group', ['key' => 'new_password', 'labelClasses' => 'es-required es-min-len', 'labelAttrs' => 'data-min-len=6'])
                    @slot('label')
                        @lang('New Password')
                    @endslot

                    @slot('input')
                        <input type="password" class="form-control" name="new_password" id="new_password" placeholder="{{ __('New Password')}}" value="">
                    @endslot
                @endcomponent

                @component('EscortAdmin::common.form.group', ['key' => 'confirm_new_password', 'labelClasses' => 'es-required es-same', 'labelAttrs' => 'data-same-target=new_password'])
                    @slot('label')
                        @lang('Confirm New Password')
                    @endslot

                    @slot('input')
                        <input type="password" class="form-control" name="confirm_new_password" id="confirm_new_password" placeholder="{{ __('Confirm New Password')}}" value="">
                    @endslot
                @endcomponent

                <button type="submit" class="btn btn-primary waves-effect waves-light button-save text-uppercase">@lang('Save')</button>

            </form>
        </div>
    </div>
</div>
