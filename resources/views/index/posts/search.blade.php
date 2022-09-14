@extends('Index::layout')

{{-- title --}}
@section('main.content.title')
{{ $title }}
@endsection
{{-- end title --}}

@section('main.content')

<div class="archive-header">
    <h1 class="archive-title"><span>Search:</span> "{{ $searchText ?? '--' }}"</h1>
    <p class="archive-description">
        @if ($posts->total() > 0)
        We found {{ $posts->total() }} results for your search.
        @else
        We could not find any results for your search. You can give it another try through the search form below.
        @endif
    </p>
</div>

@if($posts->total() > 0)
@foreach($posts as $post)
@include('Index::posts.components.post', [
'displayNavigation' => false,
'titleLink' => true,
'limitText' => true,
'displayFeaturedImage' => false,

'post' => $post,
'description' => $post->getDescription($langCode),
'catIdsNames' => $postRepo->getCategoryNamesByCategoryIds($post->category_ids, $langCode, [
'is_active' => true,
]),
'tags' => $postRepo->getTagsByTagIds($post->tag_ids, [
'is_active' => true,
]),
'totalComments' => $post->totalApprovedComments(),
])
<hr />
@endforeach
{{ $posts->links() }}
@else
<div class="no-search-results">
    @include('Index::posts.components.search_post')
</div>
@endif

@include('Index::posts.components.post_footer')

@endsection

@pushAssets('post.styles')
<link href="{{ asset('assets/theme/index/default/css/index/post.css') }}" rel="stylesheet" />
<style>
    .archive-header {
        padding: 40px 0;
        text-align: center;
        border-bottom: 1px solid #363636;
    }

    .archive-title {
        font-size: 30px;
        font-weight: bold;
    }

    .archive-title span {
        color: #d52e40;
    }

    .no-search-results {
        margin-top: 80px;
        margin-left: auto;
        margin-right: auto;
        max-width: 580px;
    }
</style>
@endPushAssets