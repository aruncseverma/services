<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="">
    <title>{{ sprintf('%s: %s', $__env->yieldContent('title') ?? '', config('site.name')) }}</title>

    <link href="{{ asset('assets/theme/admin/default/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/theme/admin/default/css/style.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/theme/admin/default/css/colors/blue.css') }}" rel="stylesheet">

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body class="fix-header">
    <section id="wrapper" class="error-page">
        <div class="error-box">
            <div class="error-body text-center">
                <h1 class="text-info">@yield('status.code')</h1>
                <h3 class="text-uppercase">@yield('title')</h3>
                <p class="text-muted mt-4 mb-4 text-uppercase">@yield('message')</p>
                <a href="{{ route('admin.dashboard') }}" class="btn btn-info btn-rounded waves-effect waves-light mb-5">Back to home</a>
            </div>

            @include('Admin::common.errors.footer')
        </div>
    </section>

    <script src="{{ asset('assets/theme/admin/default/plugins/jquery/jquery.min.js') }}"></script>
    <script src="{{ asset('assets/theme/admin/default/plugins/bootstrap/js/popper.min.js') }}"></script>
    <script src="{{ asset('assets/theme/admin/default/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
    <script src="{{ asset('assets/theme/admin/default/js/waves.js') }}"></script>
</body>
