@php($has_grid = false)

@component('Admin::posts.components.form.card_collapse', ['cardId' => 'tags'])
@slot('cardTitle')
@lang('Tags')
    @component('Admin::common.tooltip')
        @slot('tooltipText')
        <p>Tag is one of the default tools you can use categorize your posts. Each post can contain multiple tags and visitors can click on a tag to find similar posts that have that same tag.</p>
        <p>Tags are completely optional. That is, you’re free to add tags to your post, but you can also publish a post without tags. The choice is yours!</p>
        @endslot
    @endcomponent
@endslot
@slot('cardContent')

@component('Admin::common.form.group', ['has_grid' => $has_grid, 'key' => 'post.tag_ids', 'labelClasses' => '', 'labelId' => 'tag_ids'])
@slot('label')
@endslot
@slot('input')
@include('Admin::posts.tags.components.select_tags', [
    'id' => 'tag_ids',
    'name' => 'post[tag_ids][]',
    'value' => $post->tag_ids ?? [],
    'add' => true,
])
@endslot
@endcomponent

@endslot
@endcomponent