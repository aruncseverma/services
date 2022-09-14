<header class="topbar">
    <nav class="navbar top-navbar navbar-expand-md navbar-light">
        <div class="navbar-header">
            {{-- Brand --}}
            <a class="navbar-brand" href="{{ route('admin.dashboard') }}">
                <i>
                    <img src="{{ asset('assets/theme/admin/default/images/logo-icon.png') }}" alt="homepage" class="dark-logo" />
                    <img src="{{ asset('assets/theme/admin/default/images/logo-icon.png') }}" alt="homepage" class="light-logo" />
                </i>
                <span>
                    <img src="{{ asset('assets/theme/admin/default/images/logo-text.png') }}" alt="homepage" class="dark-logo" />
                    <img src="{{ asset('assets/theme/admin/default/images/logo-text.png') }}" alt="homepage" class="light-logo" />
                </span>
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
                <!-- ============================================================== -->
                <!-- Coins -->
                <!-- ============================================================== -->
                <li class="nav-item dropdown mega-dropdown"> 
                    <div class="nav-link">
                        <i class="mdi mdi-coin" style="color: #fff"></i>
                        <span style="margin-right: 6px; color: #fff">{{ ($user->wallet) ? $user->wallet->amount : 0 }}</span>
                        <a href="{{ route('agency_admin.buycredits') }}" class="btn btn-info">{{ __('strings.buymore') }}</a>
                    </div>
                </li>
                <!-- ============================================================== -->
                <!-- End Coins -->
                <!-- ============================================================== -->
                @include('AgencyAdmin::common.locales')
            </ul>
        </div>
    </nav>
</header>
