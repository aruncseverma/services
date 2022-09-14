<div class="post-categories">
    @forelse($catIdsNames as $catId => $catName)
    <a href="{{ route('index.posts.categories.redirect', ['category_name' => $catName]) }}">{{ $catName }}</a>
    @empty
    {{-- <a href="{{ route('index.posts.categories.view', ['path' => 'uncategorized']) }}">@lang('Uncategorized')</a> --}}
    @endforelse
</div>