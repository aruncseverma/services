@forelse($posts as $post)
    @include('Index::posts.components.post', [
        'displayNavigation' => false,
        'titleLink' => true,

        'post' => $post,
        'description' => $post->getDescription($postLangCode),
        'catIdsNames' => $postRepo->getCategoryNamesByCategoryIds($post->category_ids, $langCode, [
            'is_active' => true,
        ]),
        'tags' => $postRepo->getTagsByTagIds($post->tag_ids, [
            'is_active' => true,
        ]),
        'totalComments' => $post->totalApprovedComments(),
    ])
    <hr />
@empty

@endforelse
{{ $posts->links() }}