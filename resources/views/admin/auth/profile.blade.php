@extends('Admin::layout')

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

                <form method="POST" action="{{ $action ?? '' }}" class="form">
                    <h4 class="card-title">@lang('Basic Information')</h4>
                    <hr/>

                    {{ csrf_field() }}

                    {{-- email --}}
                    @component('Admin::common.form.group', ['key' => 'email'])
                        @slot('label')
                            @lang('Email Address') <span class="text text-danger">*</span>
                        @endslot
                        @slot('input')
                            <input type="email" id="email" class="form-control" name="email" placeholder="{{ __('Your email address') }}" value="{{ $user->email }}">
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

                    {{-- password --}}
                    @component('Admin::common.form.group', ['key' => 'password'])
                        @slot('label')
                            @lang('Password') <span class="text text-danger">*</span>
                        @endslot
                        @slot('input')
                            <input type="password" id="password" class="form-control" name="password" placeholder="@lang('Your password')">
                        @endslot
                    @endcomponent
                    {{-- end password --}}

                    {{-- confirm_password --}}
                    @component('Admin::common.form.group', ['key' => 'confirm_password'])
                        @slot('label')
                            @lang('Confirm Password') <span class="text text-danger">*</span>
                        @endslot
                        @slot('input')
                            <input type="password" id="confirm_password" class="form-control" name="confirm_password" placeholder="@lang('Re-type your password')">
                        @endslot
                    @endcomponent
                    {{-- end confirm_password --}}

                    {{-- name --}}
                    @component('Admin::common.form.group', ['key' => 'name'])
                        @slot('label')
                            @lang('First Name')
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
                            @if ($user->isActive())
                                <label class="label label-success">@lang('Active')</label>
                            @else
                                <label class="label label-success">@lang('Inactive')</label>
                            @endif
                        @endslot
                    @endcomponent
                    {{-- end is active --}}

                    <hr/>

                    <div class="form-actions pull-right">
                        <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> @lang('Save')</button>
                    </div>
                </form>
            </div>
        </div>
    </div>

@endsection
