@php
$authAuths = $authAuths ?? [];

$titleLink = $titleLink ?? false;
$displayNavigation = $displayNavigation ?? true;
$limiText = $limitText ?? false;
$displayFeaturedImage = $displayFeaturedImage ?? true;

$postLangCode = $postLangCode ?? $langCode;
$description = $description ?? $post->getDescription($postLangCode);
$totalComments = $totalComments ?? $post->totalApprovedComments();
$catIdsNames = $catIdsNames ?? [];
$tags = $tags ?? [];
$postUrl = url($post->slug);
$prevPost = $prevPost ?? $post->previous();
$nextPost = $nextPost ?? $post->next();
@endphp

<div class="col-12">

    <div class="post-header">
        @include('Index::posts.components.categories', [
        'catIdsNames' => $catIdsNames
        ])

        <h1 class="post-title">
            @if ($titleLink)
            <a href="{{ $postUrl }}">
                {{ $description->title }}
            </a>
            @else
            {{ $description->title }}
            @endif
        </h1>

        <div class="post-meta">
            <span class="post-meta-item post-author"><i class="fa fa-user"></i> By {{ $post->author->name }}</span>
            <span class="post-meta-item post-date"><i class="fa fa-calendar"></i> {{ $post->post_at }}</span>
            @if($totalComments>0 || $post->isAllowedComment())
            <span class="post-meta-item post-total-comments"><i class="fa fa-comment"></i>
                @if($totalComments>0)
                <a href="{{ $postUrl }}#comment-container">{{ $totalComments }} comments</a>
                @else
                <a href="{{ $postUrl }}#comment-container">No comments</a>
                @endif
            </span>
            @endif
        </div>
    </div>

    @if ($displayFeaturedImage && $post->featuredPhotoUrl)
    <div class="post-featured-media">
        <img src="{{ $post->featuredPhotoUrl }}" 
        @if(isset($post->featuredPhoto->data['alt_text']) && !empty($post->featuredPhoto->data['alt_text'])) 
        alt="{{ $post->featuredPhoto->data['alt_text'] }}"
        @endif
        />
        @if(isset($post->featuredPhoto->data['caption']) && !empty($post->featuredPhoto->data['caption']))
        <p class="post-featured-image-caption">{{ $post->featuredPhoto->data['caption'] }}</p>
        @endif
    </div>
    @endif

    <div class="post-content">
        @if($limiText)
        {!! str_limit(strip_tags($description->content), 215, ' […]') !!}
        @else
        {!! $description->content !!}
        @endif
    </div>

    @if(isset($activeAuths[$post->user_id]))
    <div class="post-edit">
        <i class="fa fa-pencil-square-o"></i> <a href="{{ route('admin.post.update', ['id'=> $post->getKey()]) }}">@lang('Edit')</a>
    </div>
    @endif

    @include('Index::posts.components.tags', [
    'tags' => $tags,
    'langCode' => $langCode
    ])

    @if($displayNavigation)
    <hr />
    <div class="post-navigation">
        @if($prevPost)
        <a href="{{ url($prevPost->slug) }}" class="post-navigation-link post-prev-link">
            <i class="fa fa-arrow-left"></i>
            {{ $prevPost->getDescription($langCode, true)->title }}
        </a>
        @endif
        @if($nextPost)
        <a href="{{ url($nextPost->slug) }}" class="post-navigation-link post-next-link">
            {{ $nextPost->getDescription($langCode, true)->title }}
            <i class="fa fa-arrow-right"></i>
        </a>
        @endif
    </div>
    <hr />
    @endif
</div>
