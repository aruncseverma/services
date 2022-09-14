@if($latestPosts)
<div class="recent-entries">
    <h2>@lang('Recent Posts')</h2>
    <ul>
        @foreach($latestPosts as $post)
        <li>
            <a href="{{ url($post->slug) }}">{{ $post->getDescription($langCode, true)->title }}</a>
        </li>
        @endforeach
    </ul>
</div>
@endif
@pushAssets('post.styles')
<style>
    .recent-entries {
        margin-top: 50px;
    }

    .recent-entries h2 {
        text-align: left;
        margin-bottom: 30px;
    }

    .recent-entries li a {
        color: #d52e40;
    }

    .recent-entries li:first-child {
        margin-top: 0;
    }

    .recent-entries li {
        margin: 20px 0 0 0;
        font-weight: bold;
        font-size: 18px;
    }
</style>
@endPushAssets