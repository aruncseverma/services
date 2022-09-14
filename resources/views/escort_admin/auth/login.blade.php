@extends('EscortAdmin::layout')

@section('main.content')
    <section id="wrapper">
        <div class="login-register">
            <div class="login-box card">
            <div class="card-body">
                <form class="form-horizontal form-material" id="loginform" action="{{ route('escort_admin.auth.login') }}" method="POST" novalidate>
                    <h3 class="box-title m-b-20">@lang('Login')</h3>
                    {{-- notification --}}
                    @include('EscortAdmin::common.notifications')
                    {{-- end notification --}}

                    <div class="form-group">
                        <div class="col-xs-12">
                            <input class="form-control" type="text" required="" placeholder="@lang('Your Email Address')" name="email">
                            @include('EscortAdmin::common.form.error', ['key' => 'email'])
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-xs-12">
                            <input class="form-control" type="password" required="" placeholder="@lang('Your Password')" name="password">
                            @include('EscortAdmin::common.form.error', ['key' => 'password'])
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="col-md-12">
                            <div class="checkbox checkbox-primary pull-left p-t-0">
                                <input id="checkbox-signup" type="checkbox" name="remember_me">
                                <label for="checkbox-signup"> @lang('Remember Me')</label>
                            </div>
                                <a href="{{ route('escort_admin.auth.forgot_password') }}" class="text-dark pull-right"><i class="fa fa-lock m-r-5"></i> @lang('Forgot pwd?')</a>
                            </div>
                    </div>
                    <div class="form-group text-center m-t-20">
                        <div class="col-xs-12">
                            <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">@lang('Login')</button>
                        </div>
                    </div>

                    <input type="hidden" name="redirect_url" value="{{ $redirectUrl }}">

                    {{ csrf_field() }}
                </form>
            </div>
          </div>
        </div>

    </section>
@endsection
