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
            @if (old('notify') == 'contact_information')
            @include('AgencyAdmin::common.notifications')
            @endif
            <form action="{{ route('agency_admin.profile.update_contact_information') }}" method="POST" class="es es-validation">
                @csrf
                <div class="form-group row">
                    <label for="elm_contact_number" class="col-6 col-form-label es-phone">@lang('Contact number')</label>
                    <div class="col-6">
                        <input class="form-control" name="phone" ype="text" value="{{ $agency->phone }}" id="elm_contact_number">
                    </div>
                </div>
                <div class="form-group row">

                    <div class="col-md-6 offset-6">
                        <label class="custom-control custom-checkbox">
                            <input type="checkbox" @if (in_array('call', $agencyContactPlatformIds)) checked="" @endif name="user_data[contact_platform_ids][]" value="call" class="custom-control-input">
                            <i class="mdi mdi-cellphone-iphone"></i>
                            <span class="custom-control-label">@lang('Call')</span>
                        </label>
                        <label class="custom-control custom-checkbox">
                            <input type="checkbox" @if (in_array('sms', $agencyContactPlatformIds)) checked="" @endif name="user_data[contact_platform_ids][]" value="sms" class="custom-control-input">
                            <i class="mdi mdi-message"></i>
                            <span class="custom-control-label">@lang('SMS')</span>
                        </label>
                        <label class="custom-control custom-checkbox">
                            <input type="checkbox" @if (in_array('whatsapp', $agencyContactPlatformIds)) checked="" @endif name="user_data[contact_platform_ids][]" value="whatsapp" class="custom-control-input">
                            <i class="mdi mdi-whatsapp"></i>
                            <span class="custom-control-label">@lang('Whatsapp')</span>
                        </label>
                        <label class="custom-control custom-checkbox">
                            <input type="checkbox" @if (in_array('telegram', $agencyContactPlatformIds)) checked="" @endif name="user_data[contact_platform_ids][]" value="telegram" class="custom-control-input">
                            <i class="mdi mdi-telegram"></i>
                            <span class="custom-control-label">@lang('Telegram')</span>
                        </label>
                        <label class="custom-control custom-checkbox">
                            <input type="checkbox" @if (in_array('viber', $agencyContactPlatformIds)) checked="" @endif name="user_data[contact_platform_ids][]" value="viber" class="custom-control-input">
                            <img src="{{ asset('/assets/theme/admin/default/images/viber-icon.png') }}" />
                            <span class="custom-control-label">@lang('Viber')</span>
                        </label>
                    </div>
                    @include('AgencyAdmin::common.form.error', ['key' => 'user_data.contact_platform_ids'])
                </div>
                <div class="form-group row">
                    <label for="elm_contact_skype" class="col-6 col-form-label">@lang('Skype ID')</label>
                    <div class="col-6">
                        <input class="form-control" name="user_data[skype_id]" type="text" value="{{ $agency->userData->skypeId }}" id="elm_contact_skype">
                        @include('AgencyAdmin::common.form.error', ['key' => 'user_data.skype_id'])
                    </div>
                </div>
                <div class="form-group row">
                    <label for="elm_website" class="col-6 col-form-label es-url">Website</label>
                    <div class="col-6">
                        <input class="form-control" name="user_data[website]" placeholder="http://" type="text" value="{{ $agency->userData->website }}" id="elm_website">
                        @include('AgencyAdmin::common.form.error', ['key' => 'user_data.website'])
                    </div>
                </div>
                <button type="submit" class="btn btn-outline-danger waves-effect waves-light button-save text-uppercase">@lang('Save')</button>
            </form>
        </div>
    </div>
</div>