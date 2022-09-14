@extends('Index::layout')

@section('main.content')
<section id="wrapper">
    <div class="login-register">
        <div class="login-box card">
            <div class="card-body">
                <h3 class="box-title m-b-20">@lang('Verify Your Email Address')</h3>
                {{-- notification --}}
                @include('Index::common.notifications')
                {{-- end notification --}}

                {{ __('Before proceeding, please check your email for a verification link.') }}
                {{ __('If you did not receive the email') }},
                <form class="d-inline" method="GET" action="{{ route('index.verification.resend') }}">
                    <button type="submit" class="btn btn-link p-0 m-0 align-baseline">{{ __('click here to request another') }}</button>.
                </form>
            </div>
        </div>
    </div>

</section>
@endsection