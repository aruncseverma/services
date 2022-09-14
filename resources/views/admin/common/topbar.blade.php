<header class="topbar">
    <nav class="navbar top-navbar navbar-expand-md navbar-light">
        <div class="navbar-header">
            {{-- Brand --}}
            <a class="navbar-brand" href="{{ route('admin.dashboard') }}">
                <b><img src="{{ asset('assets/theme/admin/default/images/logo-icon.png') }}" alt="homepage" class="dark-logo" /></b>
                <span><img src="{{ asset('assets/theme/admin/default/images/logo-text.png') }}" alt="homepage" class="dark-logo" /></span>
            </a>
            {{-- End Brand --}}
        </div>

        <div class="navbar-collapse">
            {{-- Left --}}
            <ul class="navbar-nav mr-auto mt-md-0 ">
                <!-- This is  -->
                <li class="nav-item"> <a class="nav-link nav-toggler hidden-md-up text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="ti-menu"></i></a> </li>
                <li class="nav-item"> <a class="nav-link sidebartoggler hidden-sm-down text-muted waves-effect waves-dark" href="javascript:void(0)"><i class="icon-arrow-left-circle"></i></a> </li>
            </ul>
            {{-- End Left --}}

            <ul class="navbar-nav my-lg-0">
                <li class="nav-item dropdown">
                    <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="#" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"><img src="{{ $noImageUrl }}" alt="user" class="profile-pic" /></a>
                    <div class="dropdown-menu dropdown-menu-right animated flipInY">
                        <ul class="dropdown-user">
                            <li>
                                <div class="dw-user-box">
                                    <div class="u-img"><img src="{{ $noImageUrl }}" alt="user"></div>
                                    <div class="u-text">
                                        <h4>{{ $user->name }}</h4>
                                        <p class="text-muted">{{ $user->username }}</p>
                                        <a href="{{ route('admin.auth.profile_form') }}" class="btn btn-rounded btn-danger btn-sm">@lang('My Profile')</a>
                                    </div>
                                </div>
                            </li>
                            <li role="separator" class="divider"></li>
                            <li><a href="{{ route('admin.auth.profile_form') }}" class="dropdown-item"><i class="fa fa-user"></i> @lang('My Profile')</a></li>
                            <li role="separator" class="divider"></li>
                            <a href="{{ route('admin.auth.logout') }}" class="dropdown-item"><i class="fa fa-power-off"></i> @lang('Logout')</a>
                        </ul>
                    </div>
                </li>
            </ul>
        </div>
    </nav>
</header>