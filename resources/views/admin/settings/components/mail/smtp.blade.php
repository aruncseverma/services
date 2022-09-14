<div id="smtp-settings" @if(config("{$group}.driver") != 'smtp')  style="display:none" @endif>
    {{-- mail.smtp_host --}}
    @component('Admin::common.form.group', ['key' => "{$group}.host", 'lbl_classes' => 'es-required', 'lbl_for' => "{$group}_host"])
        @slot('label')
            @lang('SMTP Host') <span class="text text-danger">*</span>
        @endslot

        @slot('input')
            <input type="text" id="{{ $group }}_host" name="{{ $group }}[host]" class="form-control" value="{{ config("{$group}.host") }}" >
        @endslot
    @endcomponent
    {{-- end mail.smtp_host --}}

    {{-- mail.smtp_port --}}
    @component('Admin::common.form.group', ['key' => "{$group}.port", 'lbl_classes' => 'es-required', 'lbl_for' => "{$group}_port"])
        @slot('label')
            @lang('SMTP Port') <span class="text text-danger">*</span>
        @endslot

        @slot('input')
            <input type="text" id="{{ $group }}_port" name="{{ $group }}[port]" class="form-control" value="{{ config("{$group}.port") }}" >
        @endslot
    @endcomponent
    {{-- end mail.smtp_port --}}

    {{-- mail.smtp_username --}}
    @component('Admin::common.form.group', ['key' => "{$group}.username", 'lbl_classes' => 'es-required', 'lbl_for' => "{$group}_username"])
        @slot('label')
            @lang('SMTP Username') <span class="text text-danger">*</span>
        @endslot

        @slot('input')
            <input type="text" id="{{ $group }}_username" name="{{ $group }}[username]" class="form-control" value="{{ config("{$group}.username") }}" >
        @endslot
    @endcomponent
    {{-- end mail.smtp_username --}}

    {{-- mail.smtp_password --}}
    @component('Admin::common.form.group', ['key' => "{$group}.password", 'lbl_classes' => 'es-required', 'lbl_for' => "{$group}_password"])
        @slot('label')
            @lang('SMTP Password') <span class="text text-danger">*</span>
        @endslot

        @slot('input')
            <input type="password"  id="{{ $group }}_password" name="{{ $group }}[password]" class="form-control" value="{{ config("{$group}.password") }}" >
        @endslot
    @endcomponent
    {{-- end mail.smtp_password --}}
</div>
