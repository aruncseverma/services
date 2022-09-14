@extends('Index::layout')

{{-- title --}}
@section('main.content.title')
{{ $title }}
@endsection
{{-- end title --}}

@section('main.content')

@include('Index::posts.components.post', [

])

<div class="post-comments">
    @include('Index::posts.components.comments', [
    'post' => $post,
    'display_pending_id' => old('guest_comment_id', null),
    ])
</div>

@include('Index::posts.components.post_footer')

@endsection

@pushAssets('post.styles')
<link href="{{ asset('assets/theme/index/default/css/index/post.css') }}" rel="stylesheet" />
@endPushAssets