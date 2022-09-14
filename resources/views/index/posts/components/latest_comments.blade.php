<div class="recent-comments">
    <h2>@lang('Recent Comments')</h2>
    @if($latestComments)
    <ul>
        @foreach($latestComments as $comment)
        <li>
            <a href="{{ $comment->url ?? $comment->name }}">{{ $comment->name }}</a> on <a href="{{ url($comment->post->slug) }}#comment-{{ $comment->getKey() }}">{{ $comment->post->getDescription($langCode, true)->title }}</a>
        </li>
        @endforeach
    </ul>
    @endif
</div>

@pushAssets('post.styles')
<style>
    .recent-comments {
        margin-top: 50px;
    }

    .recent-comments h2 {
        text-align: left;
        margin-bottom: 30px;
    }

    .recent-comments li a {
        color: #d52e40;
    }

    .recent-comments li:first-child {
        margin-top: 0;
    }

    .recent-comments li {
        margin: 20px 0 0 0;
        font-weight: bold;
        font-size: 18px;
    }
</style>
@endPushAssets