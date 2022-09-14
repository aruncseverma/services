@if ($menu->hasPermission())
    <li class="@if ($menu->isActive()) active @endif">
        <a class="@if ($menu->isParent()) has-arrow @endif @if ($menu->isActive()) active @endif" href="{{ (! $menu->isParent()) ? $menu->getLink() : '#' }}" aria-expanded="false">
            @if ($menu->hasIcon())
                <i class="{{ $menu->getIcon() }}"></i>
            @endif
            @if ($menu->hasIcon())
                <span class="hide-menu">
                    {{ $menu->getText() }}
                    {{-- append badge --}}
                    @if ($key == 'email' && $newEmailsCount > 0)
                        <span class="label label-rounded label-success">{{ $newEmailsCount }}</span>
                    @endif
                    {{-- end badge --}}
                </span>
            @else
                {{ $menu->getText() }}
            @endif
        </a>
        @if ($menu->hasChildren() && $menu->isParent())
            <ul aria-expanded="false" class="@if ($menu->hasActiveChildren()) in collapse @endif">
                @foreach ($menu->children() as $childKey => $child)
                    @include('EscortAdmin::common.sidebar.menu', ['menu' => $child, 'key' => $childKey])
                @endforeach
            </ul>
        @endif
    </li>
@endif
