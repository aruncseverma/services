<div id="sendmail-settings" @if(config("{$group}.driver") != 'sendmail')  style="display:none" @endif>

    {{-- mail.sendmail --}}
    @component('Admin::common.form.group', ['key' => "{$group}.sendmail", 'lbl_classes' => 'es-required', 'lbl_for' => "{$group}_sendmail"])
        @slot('label')
            @lang('Sendmail Command') <span class="text text-danger">*</span>
        @endslot

        @slot('input')
            <input type="text" id="{{ $group }}_sendmail" name="{{ $group }}[sendmail]" class="form-control" value="{{ config("{$group}.sendmail") }}">
        @endslot
    @endcomponent
    {{-- end mail.sendmail --}}

</div>
