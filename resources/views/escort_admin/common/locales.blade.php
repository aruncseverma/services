<li class="nav-item dropdown">
    <a class="nav-link dropdown-toggle text-muted waves-effect waves-dark" href="#" title="{{ $locale->name }}" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> <i class="flag-icon flag-icon-{{ strtolower($locale->countryCode) }}"></i></a>

    @if ($locales->count())
        <div class="dropdown-menu dropdown-menu-right animated bounceInDown">
            @foreach ($locales as $locale)
                <a class="dropdown-item" href="{{ $locale->path }}"><i class="flag-icon flag-icon-{{ strtolower($locale->countryCode) }}"></i> {{ $locale->name }}</a>
            @endforeach
        </div>
    @endif
</li>
