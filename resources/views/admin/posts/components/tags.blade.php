@php
$tagUrl = url(request()->path() . '?' . http_build_query(array_merge(request()->except('tag_id'))));
@endphp
@forelse($tagIdsNames as $tagId => $tagName)
<a href="{{ $tagUrl }}&tag_id={{ $tagId }}">{{ $tagName }}</a>@if(!$loop->last), @endif
@empty
@lang('--')
@endforelse