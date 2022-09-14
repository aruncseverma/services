<div class="col-lg-12">
    <div class="card">
        <div class="card-header" data-toggle="collapse" data-target="#update_email">
            <div class="card-actions">
                <a class="btn-minimize"><i class="mdi mdi-window-minimize"></i></a>
            </div>
            <span>@lang('E-mail Address')</span>
        </div>
        <div class="card-header-sub">
            @lang('Your current email address')
        </div>
        <div class="card-body collapse show" id="update_email">

            {{-- notification --}}
            @if (old('notify') === 'change_email')
            @include('MemberAdmin::common.notifications')
            @endif
            {{-- end notification --}}

            <form method="POST" action="{{ route('member_admin.account_settings.update_email') }}" class="es es-validation">

                {{ csrf_field() }}

                @component('MemberAdmin::common.form.group', ['key' => 'change_email', 'labelClasses' => 'es-required es-email'])
                    @slot('label')
                        @lang('E-mail Address')
                    @endslot

                    @slot('input')
                        <input type="text" class="form-control" name="change_email" id="change_email" placeholder="{{ __('Enter E-mail Address')}}" value="{{ $user->email }}">
                    @endslot
                @endcomponent

                <button type="submit" class="btn btn-primary waves-effect waves-light button-save text-uppercase">@lang('Save')</button>

            </form>
        </div>
    </div>
</div>
