@extends('Admin::users.form', ['action' => route('admin.escort.save'), 'cancelHref' => route('admin.escorts.manage')])

@section('form.inputs.post')
    {{-- newsletter subscriber --}}
    @component('Admin::common.form.group', ['key' => 'is_newsletter_subscriber'])
        @slot('label')
            @lang('Subscribe to newsletter?')
        @endslot

        @slot('input')
            <div class="m-b-10">
                <label class="custom-control custom-radio">
                    <input id="is_newsletter_subscriber_yes" name="is_newsletter_subscriber" type="radio" class="custom-control-input" @if ($user->isNewsletterSubscriber()) checked="" @endif value="1">
                    <span class="custom-control-label">@lang('Yes')</span>
                </label>
                <label class="custom-control custom-radio">
                    <input id="is_newsletter_subscriber_no" name="is_newsletter_subscriber" type="radio" class="custom-control-input"  @if (! $user->isNewsletterSubscriber()) checked="" @endif value="0">
                    <span class="custom-control-label">@lang('No')</span>
                </label>
            </div>
        @endslot
    @endcomponent
    {{-- end newsletter --}}

    {{-- origin --}}
    @component('Admin::common.form.group', ['key' => 'origin_id'])
        @slot('label')
            @lang('Origin')
        @endslot

        @slot('input')
            @include(
                'Admin::common.form.country',
                [
                    'name' => 'origin_id',
                    'value' => $user->userData->originId ?? old('origin_id'),
                    'classes' => 'form-control select2', 
                    'attributes' => 'data-live-search="true"',
                ]
            )
        @endslot
    @endcomponent
    {{-- end origin --}}
@endsection
