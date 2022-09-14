<div class="col-md-6">
    <div class="card">
        <div class="card-header" data-toggle="collapse" data-target="#newsletter_setting">
            <div class="card-actions">
                <a class="btn-minimize"><i class="mdi mdi-window-minimize"></i></a>
            </div>
            <span>@lang('Newsletter Settings')</span>
        </div>
        <div class="card-header-sub">
            @lang('Edit newsletter settings here')
        </div>
        <div class="card-body collapse show" id="newsletter_setting">

            {{-- notification --}}
            @if (old('notify') === 'newsletter_setting')
            @include('EscortAdmin::common.notifications')
            @endif
            {{-- end notification --}}

            <form method="POST" action="{{ route('escort_admin.account_settings.change_newsletter_subscription') }}">

                {{ csrf_field() }}

                @component('EscortAdmin::common.form.group', ['key' => 'is_subscribed'])
                    @slot('input')
                        <div class="m-b-10">
                            <p class="card-text">@lang('Get updated on our latest promos and discounts')</p>
                            <label class="custom-control custom-radio">
                                <input id="is_subscribed_yes" name="is_subscribed" type="radio" value="1" class="custom-control-input" @if ($user->isNewsletterSubscriber()) checked="" @endif>
                                <span class="custom-control-label">@lang('Subscribe')</span>
                            </label>
                            <label class="custom-control custom-radio">
                                <input id="is_subscribed_no" name="is_subscribed" value="0" type="radio" class="custom-control-input" @if (! $user->isNewsletterSubscriber()) checked="" @endif>
                                <span class="custom-control-label">@lang('Unsubscribe')</span>
                            </label>
                        </div>
                    @endslot
                @endcomponent

                <button type="submit" class="btn btn-primary waves-effect waves-light button-save text-uppercase">@lang('Save')</button>

            </form>
        </div>
    </div>
</div>
