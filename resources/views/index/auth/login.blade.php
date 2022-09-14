@extends('Index::layout')

@section('main.content')
<section id="wrapper">
    <div class="row">
        <div class="login-register col-md-10">
            <div class="login-box panel panel-primary">
                <div class="panel-heading">
                    <h3 class="box-title m-b-20">@lang('Existing Members')</h3>
                </div>
                <div class="panel-body" style="padding:30px">
                    <form class="form-horizontal form-material" id="loginform" action="{{ route('index.auth.login') }}" method="POST" novalidate>
                        {{ csrf_field() }}
                        <input type="hidden" name="redirect_url" value="{{ $redirectUrl }}">
                        {{-- notification --}}
                        @include('Index::common.notifications')
                        {{-- end notification --}}

                        <div class="form-group">
                            <div class="col-xs-20">
                                <input class="form-control" type="text" required="" placeholder="@lang('Your Email Address')" name="email">
                                @include('Index::common.form.error', ['key' => 'email'])
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-xs-20">
                                <input class="form-control" type="password" required="" placeholder="@lang('Your Password')" name="password">
                                @include('Index::common.form.error', ['key' => 'password'])
                            </div>
                        </div>
                        <div class="form-group">
                            <div class="col-md-20">
                                <div class="checkbox-primary pull-left p-t-0">
                                    <input id="checkbox-signup" type="checkbox" name="remember_me">
                                    <label for="checkbox-signup"> @lang('Remember Me')</label>
                                </div>
                                <a href="{{ route('index.auth.forgot_password') }}" class="text-dark pull-right"><i class="fa fa-lock m-r-5"></i> @lang('Forgot pwd?')</a>
                            </div>
                        </div>
                        <div class="form-group text-center m-t-20">
                            <div class="col-xs-20">
                                <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">@lang('Login')</button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
        <div class="col-md-10">
            <div class="panel panel-primary">
                <div class="panel-heading">
                    <h3 class="box-title m-b-20">@lang('New Member Registration')</h3>
                </div>
                <div class="panel-body" style="height:308px;padding:30px">
                    <center>
                        <h3>@lang('New Members')<br><small>Create your escort services account.</small></h3> <br />
                        <a class="btn btn-info btn-lg text-uppercase waves-effect waves-light" href="{{ route('index.auth.register') }}" style="color: white">CREATE ACCOUNT</a>
                    </center>
                </div>
            </div>
        </div>
    </div>
</section>
@endsection
