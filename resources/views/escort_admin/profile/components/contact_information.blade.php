<div class="col-md-6">
    <div class="card">
        <div class="card-header" data-toggle="collapse" data-target="#contact-info">
            <div class="card-actions">
                <a class="btn-minimize"><i class="mdi mdi-window-minimize"></i></a>
            </div>
            <span>@lang('Contact Information')</span>
        </div>
        <div class="card-header-sub">
            @lang('Please provide your contact information')
        </div>
        <div class="card-body collapse show" id="contact-info">
            <form action="{{ route('escort_admin.profile.contact_information') }}" method="POST" class="es es-validation">
                @csrf
                <div class="form-group row">
                    <label for="contact_number" class="col-6 col-form-label es-required es-phone">@lang('Contact number')</label>
                    <div class="col-6">
                        <input class="form-control" type="text" value="{{ $user->phone ?? '' }}" id="contact_number" name="contact_number">
                        @include('EscortAdmin::common.form.error', ['key' => "contact_number"])
                    </div>
                </div>
                <div class="form-group row">
                    <div class="col-md-6 offset-6">
                        <label class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="contact_platform_ids[]" value="call" @if ($user->userData->contactPlatformIds && in_array('call', $user->userData->contactPlatformIds)) checked="checked" @endif>
                            <i class="mdi mdi-cellphone-iphone"></i>
                            <span class="custom-control-label">@lang('Call')</span>
                        </label>
                        <label class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="contact_platform_ids[]" value="sms" @if ($user->userData->contactPlatformIds && in_array('sms', $user->userData->contactPlatformIds)) checked="checked" @endif>
                            <i class="mdi mdi-message"></i>
                            <span class="custom-control-label">@lang('SMS')</span>
                        </label>
                        <label class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="contact_platform_ids[]" value="whatsapp" @if ($user->userData->contactPlatformIds && in_array('whatsapp', $user->userData->contactPlatformIds)) checked="checked" @endif>
                            <i class="mdi mdi-whatsapp"></i>
                            <span class="custom-control-label">@lang('Whatsapp')</span>
                        </label>
                        <label class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="contact_platform_ids[]" value="telegram" @if ($user->userData->contactPlatformIds && in_array('telegram', $user->userData->contactPlatformIds)) checked="checked" @endif>
                            <i class="mdi mdi-telegram"></i>
                            <span class="custom-control-label">@lang('Telegram')</span>
                        </label>
                        <label class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="contact_platform_ids[]" value="viber" @if ($user->userData->contactPlatformIds && in_array('viber', $user->userData->contactPlatformIds)) checked="checked" @endif>
                            <img src="/assets/theme/admin/default/images/viber-icon.png" />
                            <span class="custom-control-label">@lang('Viber')</span>
                        </label>
                    </div>
                </div>
                <div class="form-group row">
                    <label for="skype_id" class="col-6 col-form-label es-required">@lang('Skype ID')</label>
                    <div class="col-6">
                        <input class="form-control" type="text" value="{{ $user->userData->skypeId ?? '' }}" id="skype_id" name="skype_id">
                        @include('EscortAdmin::common.form.error', ['key' => "skype_id"])
                    </div>
                </div>
                <button type="submit" class="btn btn-outline-danger waves-effect waves-light button-save">@lang('SAVE')</button>
            </form>
        </div>
    </div>
</div>