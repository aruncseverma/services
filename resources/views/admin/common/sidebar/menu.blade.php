@if ($menu->hasPermission())
    <li class="@if ($menu->isActive()) active @endif">
        <a class="@if ($menu->isParent()) has-arrow @endif @if ($menu->isActive()) active @endif" href="{{ (! $menu->isParent()) ? $menu->getLink() : '#' }}" aria-expanded="false">
            @if ($menu->hasIcon())
                <i class="{{ $menu->getIcon() }}"></i>
            @endif
            @if ($menu->hasIcon())
                <span class="hide-menu">{{ $menu->getText() }}</span>
            @else
                {{ $menu->getText() }}
            @endif

            @if(isset($notifications[$key]))
                <span class="badge badge-round badge-success pull-right">{{ $notifications[$key] }}</span>
            @endif
        </a>
        @if ($menu->hasChildren() && $menu->isParent())
            <ul aria-expanded="false" class="@if ($menu->hasActiveChildren()) in collapse @endif">
                @foreach($menu->getChildren() as $key => $menu)
                    @include('Admin::common.sidebar.menu')
                @endforeach 
            </ul>
        @endif
    </li>
@endif
