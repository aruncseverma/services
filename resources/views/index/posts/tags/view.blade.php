@extends('Index::layout')

{{-- title --}}
@section('main.content.title')
{{ $title }}
@endsection
{{-- end title --}}

@section('main.content')

<div class="archive-header">
    <h1 class="archive-title"><span>Tag:</span> {{ $description->name }}</h1>
    <p class="archive-description">{{ $description->description }}</p>
</div>

@include('Index::posts.components.posts', ['order'=> 'desc', 'tag_id' => $tag->getKey()])

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
</style>
@endPushAssets