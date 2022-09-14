<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    @yield('meta.post')

    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="">
    <title>{{ sprintf('%s: %s', $title ?? '', config('site.name')) }}</title>

    {{-- styles --}}
    @include('EscortAdmin::common.styles')

    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
    <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <script src="https://oss.maxcdn.com/libs/respond.js/1.4.2/respond.min.js"></script>
    <![endif]-->
</head>

<body class="@if (! isset($isDefaultClassBodyDisabled)) fix-header card-no-border fix-sidebar @endif">
    <div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
    </div>

    {{-- loader --}}
    @include('EscortAdmin::common.loader')
    {{-- end loader --}}

    {{-- Main Wrapper --}}
    @if (! isset($disableMainWrapper))
        <div id="main-wrapper">

            {{-- Topbar --}}
            @include('EscortAdmin::common.topbar')
            {{-- End Topbar --}}

            {{-- Sidebar --}}
            @include('EscortAdmin::common.sidebar', ['from' => 'escort_admin'])
            {{-- End Sidebar --}}

            {{-- Content --}}
            <div class="page-wrapper">
                {{-- Section: Content --}}
                <div class="container-fluid">
                    <div class="row page-titles">
                        <div class="col-md-6 col-8 align-self-center">
                            <h3 class="text-themecolor m-b-0 m-t-0">@yield('main.content.title')</h3>
                            {{-- @todo breadcrumbs --}}
                        </div>

                        {{-- additional --}}
                        @yield('main.content.title.right')
                        {{-- end additional--}}
                    </div>
                    <div class="row">
                        @yield('main.content')
                    </div>
                </div>
                {{-- End Section: Content --}}

                {{-- Footer --}}
                <footer class="footer">
                    © {{ config('site.name') }} {{ Carbon\Carbon::now()->format('Y') }} @lang('All rights reserved.')
                </footer>

            </div>
            {{-- End Content --}}
        </div>
    @else
        @yield('main.content')
    @endif

    {{-- scripts --}}
    @include('EscortAdmin::common.scripts')
</body>
<!-- Matomo -->
<script>
  var _paq = window._paq = window._paq || [];
  / tracker methods like "setCustomDimension" should be called before "trackPageView" /
  _paq.push(['trackPageView']);
  _paq.push(['enableLinkTracking']);
  (function() {
    var u="//www.bloxmedia.com/stats/";
    _paq.push(['setTrackerUrl', u+'matomo.php']);
    _paq.push(['setSiteId', '45']);
    var d=document, g=d.createElement('script'), s=d.getElementsByTagName('script')[0];
    g.async=true; g.src=u+'matomo.js'; s.parentNode.insertBefore(g,s);
  })();
</script>
<!-- End Matomo Code -->
</html>
