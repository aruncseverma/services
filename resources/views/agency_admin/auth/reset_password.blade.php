@extends('AgencyAdmin::layout')

@section('main.content')
    <section id="wrapper">
        <div class="login-register">
            <div class="login-box card">
            <div class="card-body">
                <form class="form-horizontal" method="POST" action="{{ route('agency_admin.auth.reset_password') }}">
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <h3>@lang('Recover Password')</h3>
                            {{-- notification --}}
                            @include('AgencyAdmin::common.notifications')
                            {{-- end notification --}}
                            <p class="text-muted">@lang('Enter your Email and instructions will be sent to you!')</p>
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <input class="form-control" type="email" required="" placeholder="@lang('Email Address')" name="email">
                            @include('AgencyAdmin::common.form.error', ['key' => 'email'])
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <input class="form-control" type="password" required="" placeholder="@lang('New Password')" name="password">
                            @include('AgencyAdmin::common.form.error', ['key' => 'password'])
                        </div>
                    </div>
                    <div class="form-group ">
                        <div class="col-xs-12">
                            <input class="form-control" type="password" required="" placeholder="@lang('Confirm New Pasword')" name="password_confirmation">
                            @include('AgencyAdmin::common.form.error', ['key' => 'password_confirmation'])
                        </div>
                    </div>
                    <div class="form-group text-center m-t-20">
                        <div class="col-xs-12">
                            <button class="btn btn-primary btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">@lang('Reset')</button>
                        </div>
                    </div>

                    <input type="hidden" name="token" value="{{ $token }}">

                    {{ csrf_field() }}
                </form>
            </div>
          </div>
        </div>

    </section>
@endsection
