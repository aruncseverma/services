@extends('Index::layout')

{{-- title --}}
@section('main.content.title')
{{ $title }}
@endsection
{{-- end title --}}

@section('main.content')
@include('Index::pages.components.page_nav')
@include('Index::pages.components.page_nav', [
    'isMobile' => true
])

<div class="col-lg-20">
    <div class="post-header">
        <h1 class="post-title">{{ $description->title }}</h1>
    </div>

    @if ($page->featuredPhotoUrl)
    <div class="post-featured-media">
        <img src="{{ $page->featuredPhotoUrl }}" />
    </div>
    @endif

    <div class="post-content">
        {!! $description->content !!}
    </div>

    <hr />
</div>

<div class="post-comments">
    @include('Index::posts.components.comments', [
    'post' => $page,
    'display_pending_id' => old('guest_comment_id', null),
    ])
</div>

@endsection

@pushAssets('post.styles')
<link href="{{ asset('assets/theme/index/default/css/index/post.css') }}" rel="stylesheet" />
@endPushAssets