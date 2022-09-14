{{-- Common Sidebar Template --}}
<aside class="left-sidebar">
    <div class="scroll-sidebar">
        {{-- User Profile --}}
        <div class="user-profile">
            <div class="profile-img">
                <img src="{{ $user->profilePhotoUrl ?? $noImageUrl }}" alt="user" height="50" width="50" />
            </div>
            {{-- User Profile Text--}}
            <div class="profile-text">
                <a href="#" class="profile-name dropdown-toggle link u-dropdown" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="true">
                    {{ $user->name }} <span class="caret"></span>
                </a>

                {{-- verified status --}}
                @if ($user->isVerified())
                    <button class="btn btn-outline-success waves-effect waves-light m-b-5" type="button">
                        <span class="btn-label"><i class="fa fa-check"></i></span>{{ strtoupper(__('Agency Verified')) }}
                    </button>
                @else
                    <button class="btn btn-outline-secondary waves-effect waves-light m-b-5" type="button">
                        <span class="btn-label"><i class="fa fa-times text-danger"></i></span>{{ strtoupper(__('Get Verified')) }}
                    </button>
                @endif
                {{-- end --}}

                {{-- approval status --}}
                @if ($user->isApproved())
                    <button class="btn btn-outline-success waves-effect waves-light" type="button">
                        <span class="btn-label"><i class="fa fa-check text-warning"></i></span>{{ strtoupper(__('Approved')) }}
                    </button>
                @else
                    <button class="btn btn-outline-secondary waves-effect waves-light" type="button">
                        <span class="btn-label"><i class="fa fa-exclamation-triangle text-danger"></i></span>{{ strtoupper(__('Get Approved')) }}
                    </button>
                @endif
                {{-- end --}}

                <div class="dropdown-menu animated flipInY">
                    <a href="{{ route('escort_admin.profile') }}" class="dropdown-item"><i class="ti-user"></i> @lang('My Profile')</a>
                    <a href="{{ route('escort_admin.emails.manage') }}" class="dropdown-item"><i class="ti-email"></i> @lang('Inbox')</a>
                    <div class="dropdown-divider"></div> <a href="{{ route('escort_admin.account_settings') }}" class="dropdown-item"><i class="ti-settings"></i> @lang('Account Setting')</a>
                    <div class="dropdown-divider"></div> <a href="{{ route('escort_admin.auth.logout') }}" class="dropdown-item"><i class="fa fa-power-off"></i> @lang('Logout')</a>
                </div>
            </div>
        </div>
        {{-- End User Profile --}}

        {{-- Sidebar Menus --}}
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                @foreach ($menus as $key => $menu)
                    @include('EscortAdmin::common.sidebar.menu', ['menu' => $menu, 'key' => $key])
                @endforeach
            </ul>
        </nav>
        {{-- end sidebar menus --}}
    </div>
</aside>
{{-- End Common Sidebar Template --}}
