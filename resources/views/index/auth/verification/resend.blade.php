@extends('Index::layout')

@section('main.content')
<section id="wrapper">
    <div class="login-register">
        <div class="login-box card">
            <div class="card-body">
                <form class="form-horizontal form-material" id="loginform" action="{{ route('index.verification.resend') }}" method="POST" novalidate>
                    {{ csrf_field() }}
                    <h3 class="box-title m-b-20">@lang('Email Verification')</h3>
                    {{-- notification --}}
                    @include('Index::common.notifications')
                    {{-- end notification --}}

                    <div class="form-group">
                        <div class="col-xs-12">
                            <input class="form-control" type="text" required="" placeholder="@lang('Your Email Address')" name="email">
                            @include('Index::common.form.error', ['key' => 'email'])
                        </div>
                    </div>
                    <div class="form-group text-center m-t-20">
                        <div class="col-xs-12">
                            <button class="btn btn-info btn-lg btn-block text-uppercase waves-effect waves-light" type="submit">@lang('Resend')</button>
                        </div>
                   
                </form>
            </div>
        </div>
    </div>

</section>
@endsection