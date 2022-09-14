@php
$catUrl = url(request()->path() . '?' . http_build_query(array_merge(request()->except('category_id'))));
@endphp
@forelse($catIdsNames as $catId => $catName)
<a href="{{ $catUrl }}&category_id={{ $catId }}">{{ $catName }}</a>@if(!$loop->last), @endif
@empty
@lang('Uncategorized')
@endforelse