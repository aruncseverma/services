@if($tags)
<div class="post-tags">
    <i class="fa fa-tags"></i>
    @foreach($tags as $tag)
    <a href="{{ route('index.posts.tags.view', ['path' => $tag->slug]) }}">{{ $tag->getDescription($langCode, true)->name }}</a>@if (!$loop->last), @endif
    @endforeach
</div>
@endif