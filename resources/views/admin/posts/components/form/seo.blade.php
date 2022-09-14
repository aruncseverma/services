@php($has_grid = false)

@component('Admin::posts.components.form.card_collapse', ['cardId' => 'card_seo'])
@slot('cardTitle')
@lang('SEO')
@endslot
@slot('cardContent')

@component('Admin::common.form.group', ['has_grid' => $has_grid, 'key' => 'post.slug', 'labelClasses' => 'es-slug', 'labelId' => 'slug'])
@slot('label')
@lang('Slug')
@endslot
@slot('input')
<input type="text" id="slug" name="post[slug]" class="form-control" placeholder="@lang('Slug')" value="{{ $post->slug }}">
<small><i>The last part of the URL.</i></small>
@endslot
@endcomponent

@if($post->getKey())
View Post
<a href="{{ url($post->slug) }}" target="_blank"> {{ url($post->slug) }} <i class="mdi mdi-eye"></i></a>
@endif

@endslot
@endcomponent