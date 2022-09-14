@extends('AgencyAdmin::layout')

{{-- title --}}
@section('main.content.title')
{{ $title }}
@endsection
{{-- end title --}}

@section('main.content')

<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            {{-- notification --}}
            @include('Admin::common.notifications')
            {{-- end notification --}}

            <form method="POST" action="{{ route('agency_admin.escort.save') }}" class="form es es-validation">
                <h4 class="card-title">@lang('Basic Information')</h4>
                <hr />

                {{-- hidden --}}
                {{ csrf_field() }}
                <input type="hidden" name="id" value="{{ $user->username }}">
                {{-- end hidden --}}

                {{-- additional pre fields --}}
                @yield('form.inputs.pre')
                {{-- end additional --}}

                {{-- email --}}
                @component('Admin::common.form.group', ['key' => 'email', 'labelClasses' => 'es-required es-email'])
                @slot('label')
                @lang('Email Address') <span class="text text-danger">*</span>
                @endslot
                @slot('input')
                <input type="text" id="email" class="form-control" name="email" placeholder="{{ __('Your email address') }}" value="{{ $user->email }}">
                @endslot
                @endcomponent
                {{-- end email --}}

                {{-- username --}}
                @component('Admin::common.form.group', ['key' => 'username'])
                @slot('label')
                @lang('Username')
                @endslot
                @slot('input')
                <input type="text" id="username" class="form-control" name="username" placeholder="{{ __('Your username') }}" value="{{ $user->username }}">
                @endslot
                @endcomponent
                {{-- end username --}}
                
                @if($user->getKey())

                {{-- password --}}
                @component('Admin::common.form.group', ['key' => 'password', 'labelClasses' => 'es-min-len', 'labelAttrs' => 'data-min-len=6'])
                @slot('label')
                @lang('Password')
                @endslot
                @slot('input')
                <input type="password" id="password" class="form-control" name="password" placeholder="@lang('Your password')">
                @endslot
                @endcomponent
                {{-- end password --}}

                {{-- confirm_password --}}
                @component('Admin::common.form.group', ['key' => 'confirm_password', 'labelClasses' => 'es-same', 'labelAttrs' => 'data-same-target=password'])
                @slot('label')
                @lang('Confirm Password')
                @endslot
                @slot('input')
                <input type="password" id="confirm_password" class="form-control" name="confirm_password" placeholder="@lang('Re-type your password')">
                @endslot
                @endcomponent
                {{-- end confirm_password --}}

                @else

                {{-- password --}}
                @component('Admin::common.form.group', ['key' => 'password', 'labelClasses' => 'es-required es-min-len', 'labelAttrs' => 'data-min-len=6'])
                @slot('label')
                @lang('Password') <span class="text text-danger">*</span>
                @endslot
                @slot('input')
                <input type="password" id="password" class="form-control" name="password" placeholder="@lang('Your password')">
                @endslot
                @endcomponent
                {{-- end password --}}

                {{-- confirm_password --}}
                @component('Admin::common.form.group', ['key' => 'confirm_password', 'labelClasses' => 'es-required es-same', 'labelAttrs' => 'data-same-target=password'])
                @slot('label')
                @lang('Confirm Password') <span class="text text-danger">*</span>
                @endslot
                @slot('input')
                <input type="password" id="confirm_password" class="form-control" name="confirm_password" placeholder="@lang('Re-type your password')">
                @endslot
                @endcomponent
                {{-- end confirm_password --}}

                @endif

                {{-- name --}}
                @component('Admin::common.form.group', ['key' => 'name'])
                @slot('label')
                @lang('Name')
                @endslot
                @slot('input')
                <input type="text" id="name" class="form-control" name="name" placeholder="@lang('Your Name')" value="{{ $user->name }}">
                @endslot
                @endcomponent
                {{-- end name --}}

                {{-- is active --}}
                @component('Admin::common.form.group', ['key' => 'is_active'])
                @slot('label')
                @lang('Profile Status')
                @endslot

                @slot('input')
                <div class="m-b-10">
                    <label class="custom-control custom-radio">
                        <input id="active" name="is_active" type="radio" class="custom-control-input" @if ($user->isActive()) checked="" @endif value="1">
                        <span class="custom-control-label">@lang('Active')</span>
                    </label>
                    <label class="custom-control custom-radio">
                        <input id="inactive" name="is_active" type="radio" class="custom-control-input" @if (! $user->isActive()) checked="" @endif value="0">
                        <span class="custom-control-label">@lang('Inactive')</span>
                    </label>
                </div>
                @endslot
                @endcomponent
                {{-- end is active --}}

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
                        <input id="is_newsletter_subscriber_no" name="is_newsletter_subscriber" type="radio" class="custom-control-input" @if (! $user->isNewsletterSubscriber()) checked="" @endif value="0">
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
                'classes' => 'select2 form-control',
                ]
                )
                @endslot
                @endcomponent
                {{-- end origin --}}

                <hr />

                <div class="form-actions pull-right">
                    <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> @lang('Save')</button>
                    <a href="{{ route('agency_admin.escorts') }}" class="btn btn-inverse">@lang('Cancel')</a>
                </div>
            </form>
        </div>
    </div>
</div>

@endsection