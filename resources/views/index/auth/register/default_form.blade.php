@extends('Index::layout')

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
            @include('Index::common.notifications')
            {{-- end notification --}}

            <form method="POST" action="{{ $action ?? '' }}" class="form" id="register_form">
                {{-- hidden --}}
                {{ csrf_field() }}
                {{-- end hidden --}}

                {{-- additional pre fields --}}
                @yield('form.inputs.pre')
                {{-- end additional --}}

                <h4 class="card-title">@lang('Login Information')</h4>
                <hr />

                {{-- email --}}
                @component('Index::common.form.group', ['key' => 'email'])
                @slot('label')
                @lang('Email Address') <span class="text text-danger">*</span>
                @endslot
                @slot('input')
                <input type="email" id="email" class="form-control" name="email" placeholder="{{ __('Your email address') }}" value="{{ old('email') }}">
                @endslot
                @endcomponent
                {{-- end email --}}

                {{-- username --}}
                @component('Index::common.form.group', ['key' => 'username'])
                @slot('label')
                @lang('Username')
                @endslot
                @slot('input')
                <input type="text" id="username" class="form-control" name="username" placeholder="{{ __('Your username') }}" value="{{ old('username') }}">
                @endslot
                @endcomponent
                {{-- end username --}}

                {{-- password --}}
                @component('Index::common.form.group', ['key' => 'password'])
                @slot('label')
                @lang('Password') <span class="text text-danger">*</span>
                @endslot
                @slot('input')
                <input type="password" id="password" class="form-control" name="password" placeholder="@lang('Your password')">
                @endslot
                @endcomponent
                {{-- end password --}}

                {{-- confirm_password --}}
                @component('Index::common.form.group', ['key' => 'confirm_password'])
                @slot('label')
                @lang('Confirm Password') <span class="text text-danger">*</span>
                @endslot
                @slot('input')
                <input type="password" id="confirm_password" class="form-control" name="confirm_password" placeholder="@lang('Re-type your password')">
                @endslot
                @endcomponent
                {{-- end confirm_password --}}

                {{-- additional pre fields --}}
                @yield('form.inputs.post')
                {{-- end additional --}}

                <h4 class="card-title">@lang('Other Information')</h4>
                <hr />

                {{-- terms --}}
                @component('Admin::common.form.group', ['key' => 'terms'])
                @slot('label')
                @endslot

                @slot('input')
                <div class="m-b-10">
                    <label class="custom-control custom-radio">
                        <input id="terms" name="terms" type="checkbox" class="custom-control-input" @if (old('terms')==1) checked="" @endif value="1">
                        <span class="custom-control-label">@lang('You Must Agree To Our <a href="/page/terms-conditions" target="_blank">Terms Of Service</a>')</span>
                    </label>
                </div>
                @endslot
                @endcomponent
                {{-- end terms --}}

                {{-- newsletter subscriber --}}
                @component('Admin::common.form.group', ['key' => 'is_newsletter_subscriber'])
                @slot('label')
                @endslot

                @slot('input')
                <div class="m-b-10">
                    <label class="custom-control custom-radio">
                        <input id="is_newsletter_subscriber" name="is_newsletter_subscriber" type="checkbox" class="custom-control-input" @if (old('is_newsletter_subscriber')==1) checked="" @endif value="1">
                        <span class="custom-control-label">@lang('Subscribe to newsletter?')</span>
                    </label>
                </div>
                @endslot
                @endcomponent
                {{-- end newsletter --}}


                <hr />
                <div class="form-actions pull-right">
                    @include('Index::common.form.recaptcha_button', [
                    'formId' => 'register_form',
                    'txt' => '<i class="fa fa-check"></i> '. __('Register'),
                    'classes' => 'btn btn-success'
                    ])
                </div>
            </form>
        </div>
    </div>
</div>

@endsection