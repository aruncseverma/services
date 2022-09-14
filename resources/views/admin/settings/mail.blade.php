@extends('Admin::settings.form')

@section('settings.form_input')
    {{-- mail.driver --}}
    @component('Admin::common.form.group', ['key' => "{$group}.driver"])
        @slot('label')
            @lang('Driver') <span class="text text-danger">*</span>
        @endslot

        @slot('input')
            <select name="{{ $group }}[driver]" class="form-control" required="" id="driver">
                @foreach (['smtp', 'sendmail'] as $driver)
                    <option value="{{ $driver }}" @if(config("{$group}.driver") == $driver) selected="" @endif>@lang($driver)</option>
                @endforeach
            </select>
        @endslot
    @endcomponent
    {{-- end mail.driver --}}

    @include('Admin::settings.components.mail.smtp')
    @include('Admin::settings.components.mail.sendmail')

    {{-- mail.encryption --}}
    @component('Admin::common.form.group', ['key' => "{$group}.encryption"])
        @slot('label')
            @lang('Encryption')
        @endslot

        @slot('input')
            <select name="{{ $group }}[encryption]" class="form-control" required="">
                @foreach (['tls', 'ssl'] as $encryption)
                    <option value="{{ $encryption }}" @if(config("{$group}.encryption") == $encryption) selected="" @endif>@lang($encryption)</option>
                @endforeach
            </select>
        @endslot
    @endcomponent
    {{-- end mail.encryption --}}


    {{-- mail.from.address --}}
    @component('Admin::common.form.group', ['key' => "{$group}.from.address", 'lbl_classes' => 'es-required es-email', 'lbl_for' => "{$group}_from_address"])
        @slot('label')
            @lang('E-mail Address') <span class="text text-danger">*</span>
        @endslot

        @slot('input')
            <input type="text" id="{{ $group }}_from_address" name="{{ $group }}[from.address]" class="form-control" value="{{ config("{$group}.from.address") }}" >
        @endslot
    @endcomponent
    {{-- end mail.from.address --}}

    {{-- mail.from.name --}}
    @component('Admin::common.form.group', ['key' => "{$group}.from.name", 'lbl_classes' => 'es-required', 'lbl_for' => "{$group}_from_name"])
        @slot('label')
            @lang('E-mail Name') <span class="text text-danger">*</span>
        @endslot

        @slot('input')
            <input type="text" id="{{ $group }}_from_name" name="{{ $group }}[from.name]" class="form-control" value="{{ config("{$group}.from.name") }}" >
        @endslot
    @endcomponent
    {{-- end mail.from.name --}}
@endsection

@pushAssets('scripts.post')
    <script type="text/javascript">
        $(function() {
            var mail_host = $('[for="mail_host"]');
            var mail_port = $('[for="mail_port"]');
            var mail_username = $('[for="mail_username"]');
            var mail_password = $('[for="mail_password"]');
            var mail_sendmail = $('[for="mail_sendmail"]');

            var driver = $('#driver');
            driver.on('change', function() {
                var $target = $('#' + this.value + '-settings');

                // hide others
                $('[id$="-settings"').hide();

                // show selected
                $target.show();

                changeFormValidation();
            });

            var changeFormValidation = function() {
                if (driver.val() == 'smtp') {
                    mail_host.addClass('es-required');
                    mail_port.addClass('es-required');
                    mail_username.addClass('es-required');
                    mail_password.addClass('es-required');

                    mail_sendmail.removeClass('es-required');
                } else {
                    mail_host.removeClass('es-required');
                    mail_port.removeClass('es-required');
                    mail_username.removeClass('es-required');
                    mail_password.removeClass('es-required');

                    mail_sendmail.addClass('es-required');
                }
            }

            changeFormValidation();
        });
    </script>
@endPushAssets
