<nav aria-label="">
    <ul class="pagination pagination-sm justify-content-end">
        {{-- Previous Page Link --}}
        <li class="page-item @if ($paginator->onFirstPage()) disabled @endif">
            <a class="page-link" href="#" tabindex="-1">@lang('Previous')</a>
        </li>

        {{-- Pagination Elements --}}
        @foreach ($elements as $element)
            {{-- "Three Dots" Separator --}}
            @if (is_string($element))
                <li class="page-item disabled" aria-disabled="true"><span class="page-link">{{ $element }}</span></li>
            @endif

            {{-- Array Of Links --}}
            @if (is_array($element))
                @foreach ($element as $page => $url)
                    @if ($page == $paginator->currentPage())
                        <li class="page-item active"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                    @else
                        <li class="page-item"><a class="page-link" href="{{ $url }}">{{ $page }}</a></li>
                    @endif
                @endforeach
            @endif
        @endforeach

        {{-- Next Page Link --}}
        <li class="page-item @if (!$paginator->hasMorePages()) disabled @endif">
            <a class="page-link" href="#">@lang('Next')</a>
        </li>
    </ul>
</nav>
