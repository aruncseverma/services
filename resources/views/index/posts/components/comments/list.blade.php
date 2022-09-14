@php
$postId = $post_id ?? '';
$showTitle = $show_title ?? true;
@endphp

@if($comments)
@foreach($comments as $comment)
<div id="comment-{{ $comment->getKey() }}" class="comment-items">
    <div class="comment-info">
        @if($comment->user_id)
        <img src="{{ $comment->user->profilePhotoUrl ?? $noImageUrl }}" style="width: 50px;" />
        @else
        <img src="{{ $noImageUrl }}" style="width: 50px;" />
        @endif

        @if($comment->url)
        <a href="{{ $comment->url }}">
            <h4>{{ $comment->name }}</h4>
        </a>
        @else
        <h4>{{ $comment->name }}</h4>
        @endif
        <p>{{ $comment->created_at }}</p>
    </div>

    <div class="comment-content">{{ $comment->content }}</div>

    <div class="comment-footer">
        @if($commentShowForm)
        <button type="button" class="btn btn-danger btn-reply-comment" data-comment-id="{{ $comment->getKey() }}">Reply</button>
        @elseif($commentShowLogin)
        <a href="#" class="btn-comment-login">LOG IN TO REPLY</a>
        @endif

        @if($comment->user_id == $post->user_id)
        <span class="by-post-author">BY POST AUTHOR</span>
        @endif
        <div class="comment-reply-container"></div>

        @if(!$comment->isApproved())
        <p class="comment-awaiting-moderation">Your comment is awaiting moderation.</p>
        @endif
    </div>

    @include('Index::posts.components.comments.list', [
    'post_id' => $postId,
    'parent_id' => $comment->getKey(),
    ])

</div>
@endforeach
@endif