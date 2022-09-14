
	<div class="centerwrap">
    	<div class="logo"><a href="{{ route('index.home') }}"><img src="{{ asset('assets/theme/index/default/images/index/logo.png')}}" alt="EscortServicesLogo" title="EscortServicesLogo" /></a></div>
        <div class="headerRight">
        	<div class="resNavB ">
            	<span></span>
                <span></span>
                <span></span>
            </div>
            <nav>
                <ul>
                    <li><a href="{{ route('index.home') }}" title="Escort" @if(Route::current()->getName() == 'index.home') class="active" @endif>Escort</a></li>
                    <li><a href="{{ route('agency.home') }}" title="Agencies" @if(Route::current()->getName() == 'agency.home') class="active" @endif>Agencies</a></li>
                    <li><a href="#" title="Webcams">Webcams</a></li>
                    <li><a href="{{ route('index.posts.list') }}" title="Blog" @if(Route::current()->getName() == 'index.posts.list') class="active" @endif>Blog</a></li>
                    <li><a href="/faq" title="FAQ">FAQ</a></li>
                    <li><a href="/contact" title="Contact">Contact</a></li>
                    @if (auth('member_admin')->check())
                        <li><a href="{{ route('index.auth.logout') }}" title="@lang('Logout')" data-target="">@lang('Logout')</a></li>
                    @else
                    <li><a href="#" class="loginPopup">LOGIN</a>
                    	<div class="loginArea">
                        	<div class="loginSection">
                            	<h4>Login</h4>
                                <form method="POST" action="{{ route('index.auth.login') }}">
                                    @csrf
                                    <div class="loginBlock">
                                        <label>@lang('Email')</label>
                                        <input type="text" name="email" class="loginBox">
                                    </div>
                                    <div class="loginBlock">
                                        <label>@lang('Password')</label>
                                        <input type="password" name="password" class="loginBox">
                                    </div>
                                    <div class="loginTwo">
                                        <div class="forgotPassword">@lang('forgot password?')</div>
                                        <input type="submit" value="Submit" class="loginSubmit">
                                    </div>
                                    <div class="nyMember">
                                        <div class="notMemberY">Not yet a member?</div>
                                        <div class="signupNow">SIGNUP NOW</div>
                                    </div>
                                </form>
                            </div>
                            <div class="accRecovery">
                            	<h4>Account Recovery</h4>
                                <div class="loginBlock lowspace">
                                	<label>Email</label>
                                    <input type="text" class="loginBox">
                                </div>
                                <div class="nyam">Not yet a member?</div>
                                <div class="twoRSbtn">
                                	<a href="#" class="recoverPass">RECOVER PASSWORD</a>
                                    <a href="#" class="signNow">SIGNUP NOW</a>
                                </div>
                            </div>
                            <div class="emailsent">
                            	<h4>Account Recovery</h4>
                                <div class="recoveremail">
                                	We have sent you an email to recover your account. Thank you
                                </div>
                                <div class="nyam">Not yet a member?</div>
                                <div class="twoRSbtn">
                                	<a href="#" class="login">Login</a>
                                    <a href="#" class="signNow2">SIGNUP NOW</a>
                                </div>
                            </div>
                        </div>
                    </li>
                    @endif

                    @if (auth('member_admin')->check())
                        <li><a href="{{ route('member_admin.auth.login_form') }}" title="MY ADMIN">MY ADMIN</a></li>
                    @else
                        <li><a href="{{ route('index.auth.register') }}" titie="Register">REGISTER</a></li>
                    @endif
                </ul>
            </nav>
            {{-- additional headers --}}
                @stackAssets('header.additional')
            {{-- end additional headers --}}
            <div class="searchAreaD">
            	<div class="searchID"><i class="fas fa-search"></i></div>
            </div>
        </div>
    </div>
   
   <!--<div class="container">
        <div class="row">
            <div class="col-lg-4">
                <div class="logo-container">
                    <a href="#" id="open_nav"></a>
                    <a href="#" id="open_profile"><i class="fa fa-map-marker"></i></a>
                    <a href="#" id="open_search"><i class="fa fa-filter"></i></a>
                    <a href="#" id="open_gender" class="gen-active-fem"></a>
                    <a href="#" class="logos">
                        <img class="logo-p" src="{{ asset('assets/theme/index/default/images/index/mainLogo.png') }}" alt="EscortServicesLogo" title="EscortServicesLogo" />
                        <img class="logo-m" src="{{ asset('assets/theme/index/default/images/index/mainLogo-icon.png') }}" alt="EscortServicesLogo" title="EscortServicesLogo" />
                        <img class="logo-t" src="{{ asset('assets/theme/index/default/images/index/mainLogo-small.png') }}" alt="EscortServicesLogo" title="EscortServicesLogo" />
                    </a>
                </div>
            </div>

            <div class="col-lg-16">
                <div class="navigation">
                    <div class="dashboard_lang hidden-lg">
                        <a href="#" title="English"><img src="{{ asset('assets/theme/index/default/images/index/eng_lang.png') }}" alt="English" title="English">English</a>
                        <a href="#" title="Spanish"><img src="{{ asset('assets/theme/index/default/images/index/spanish_lang.png') }}" alt="Spanish" title="Spanish">Spanish</a>
                    </div>
                    <nav>
                        <ul>
                            <li><a href="{{ route('index.home') }}" title="Escort" @if(Route::current()->getName() == 'index.home') class="active" @endif>Escort</a></li>
                            <li><a href="{{ route('agency.home') }}" title="Agencies">Agencies</a></li>
                            <li><a href="#" title="Webcams">Webcams</a></li>
                            <li><a href="{{ route('index.posts.list') }}" title="Blog">Blog</a></li>
                            <li><a href="/faq" title="FAQ">FAQ</a></li>
                            <li><a href="/contact" title="Contact">Contact</a></li>
                            @if (auth('member_admin')->check())
                                <li><a href="{{ route('index.auth.logout') }}" class="text-uppercase" title="@lang('Logout')" data-target="">@lang('Logout')</a></li>
                            @else
                                <li><a href="{{ route('index.auth.login_form') }}" class="text-uppercase" title="@lang('Login')">@lang('Login')</a></li>
                            @endif

                            @if (auth('member_admin')->check())
                                <li><a href="{{ route('member_admin.auth.login_form') }}" title="MY ADMIN">MY ADMIN</a></li>
                            @else
                                <li><a href="{{ route('index.auth.register') }}" title="Register">Register</a></li>
                            @endif
                            
                            @if (auth()->guest())
                                <li class="login_form">
                                    <form method="POST" action="{{ route('index.auth.login') }}">
                                        @csrf
                                        <div class="input_login">
                                            <label>@lang('Email')</label>
                                            <input type="text" name="email">
                                        </div>
                                        <div class="input_login">
                                            <label>@lang('Password')</label>
                                            <input type="password" name="password">
                                        </div>
                                        <a class="forgot_pass" href="#">@lang('Forgot Password?')</a>
                                        <button class="btn_submit" type="submit">@lang('Submit')</button>
                                    </form>
                                </li>
                            @endif
                        </ul>
                    </nav>
                </div>

                {{-- additional headers --}}
                @stackAssets('header.additional')
                {{-- end additional headers --}}
            </div>
        </div>
    </div> -->