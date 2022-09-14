<div class="post-footer">
    <div class="row">
        <div class="col-md-10 col-lg-10">
            @include('Index::posts.components.search_post')
            @include('Index::posts.components.latest_posts')
            @include('Index::posts.components.latest_comments')
        </div>

        <div class="col-md-10 col-lg-10">
            @include('Index::posts.components.used_categories')
        </div>
    </div>
</div>

@pushAssets('post.styles')
<style>
    .post-footer {
        padding-top: 80px;
    }
</style>
@endPushAssets