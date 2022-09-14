<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <!-- Tell the browser to be responsive to screen width -->
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="author" content="http://bootstraptaste.com">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <meta name="description" content="{{ $metaDescription ?? '' }}">
    <meta name="keywords" content="{{ $metaKeywords ?? '' }}">

    @yield('meta.post')

    <!-- Favicon icon -->
    <link rel="icon" type="image/png" sizes="16x16" href="">
    <title>{{ sprintf('%s: %s', $title ?? '', config('site.name')) }}</title>

    {{-- styles --}}
    @include('Index::common.styles')
    {{-- end styles --}}
    
    {{-- scripts --}}
    @include('Index::common.scripts')
    {{-- end scripts --}}
</head>

<body>
    <!--<div class="preloader">
        <svg class="circular" viewBox="25 25 50 50">
            <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" /> </svg>
    </div>-->
    <div class="warningPop" id="warningpopup">
        <div class="warningScroll">
            <div class="warningSpace">
                <div class="warningPopB">
                    <div class="warningLogo"><img alt="" src="{{ asset('assets/theme/index/default/images/index/logo.png')}}"></div>
                    <div class="wContent">
                        <p>This website is showing adult contents and is strictly prohibited for persons under 18 years old. We decline any responsibility in case of abuse.</p>
                        <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book.</p>
                    </div>
                    <div class="wtwoBtn">
                        <a href="javascript:void(0)" class="enter">Accept All</a>
                        <a href="https://google.com" class="exit">Deny</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
        <header>
            {{-- Header --}}
            @include('Index::common.header')
            {{-- End Header--}}
        </header>        
        <div class="bodyArea">                
            <div class="mobileMenu">
                <div class="mobileWbg">
                    <ul class="mMenu">
                        <li><a href="{{ route('index.home') }}" title="Escorts" @if(Route::current()->getName() == 'index.home') class="active" @endif >ESCORTS</a></li>
                        <li><a href="{{ route('agency.home') }}" title="Agencies" @if(Route::current()->getName() == 'agency.home') class="active" @endif >AGENCIES</a></li>
                        <li><a href="#">WEBCAM</a></li>
                        <li><a href="{{ route('index.posts.list') }}" title="" @if(Route::current()->getName() == 'index.posts.list') class="active" @endif >BLOG</a></li>
                        <li><a href="/faq" title="FAQ">FAQ</a></li>
                        <li><a href="/contact" title="contact">CONTACT</a></li>
                    </ul>
                    <div class="loginAreaM">                            
                        <form method="POST" action="{{ route('index.auth.login') }}">
                        @csrf
                        <label>@lang('Email')</label>
                        <input type="email" name="email" class="emailBoxM" />
                        <label>@lang('Password')</label>
                        <input type="password" name="password" class="emailBoxM" />
                        <div class="btnM">
                            <a class="forgot">@lang('forgot password?')</a>
                            <button class="submitM">Submit</button>
                        </div>
                        </form>
                    </div>
                    <div class="arM">
                        <h4>Account Recovery</h4>
                        <div class="recoverMPass">
                            <label>Email Address</label>
                            <input type="email" class="emailBoxM">
                            <button class="recoverMPBtn">Recover my password</button>
                        </div>
                        <div class="thanku">
                            <p>We have sent you an email to recover your account. Thank you</p>
                            <button class="loginMPBtn">Login</button>
                        </div>
                    </div>
                    @if (auth('member_admin')->check())
                    <div class="welcomeMBox">
                        <div class="welcomeMT">Welcome!</div>
                        <div class="userNameM">Ronald Gaviola</div>
                        <ul>
                            <li><i class="far fa-envelope"></i>You have 3 messages</li>
                            <li><i class="far fa-comment"></i> have 15 comments</li>
                            <li><i class="fas fa-reply-all"></i>You have 4 new replies</li>
                        </ul>
                        <button class="gtDash">GO TO DASHBOARD</button>
                    </div>
                    @else                        
                    <div class="notMember">
                        <p>Not yet a member?</p>
                        <a class="signupM" href="{{ route('index.auth.register') }}">SIGNUP NOW</a>
                    </div>
                    @endif
                    
                </div>
            </div>
            {{-- Contents --}}
            @yield('main.content')
            {{-- End Contents --}}
            
        </div>
        

        {{-- Footer --}}
        @include('Index::common.footer')
        {{-- End Footer --}}
    

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