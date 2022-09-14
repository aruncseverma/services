{{-- Common Sidebar Template --}}
<aside class="left-sidebar">
    <div class="scroll-sidebar">
        {{-- User Profile --}}
        <div class="user-profile">
            <div class="profile-img">
                <img src="{{ $noImageUrl }}" alt="user" />
            </div>
            {{-- User Profile Text--}}
            <div class="profile-text">
                <span class="profile-name">{{ $user->name }}</span>
            </div>
        </div>
        {{-- End User Profile --}}

        {{-- Sidebar Menus --}}
        <nav class="sidebar-nav">
            <ul id="sidebarnav">
                <li class="nav-small-cap">@lang('Menus')</li>
                @foreach($menus as $key => $menu)
                    @include('Admin::common.sidebar.menu')
                @endforeach
            </ul>
        </nav>
        {{-- end sidebar menus --}}
    </div>
</aside>
{{-- End Common Sidebar Template --}}
