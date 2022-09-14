@php
$post = $post ?? null;
$has_collapse = $has_collapse ?? true;
$has_grid = $has_grid ?? false;
@endphp

@if($has_collapse)
    @component('Admin::posts.components.form.card_collapse', ['cardId' => 'discussion'])
    @slot('cardTitle')
    @lang('Discussion')
    @endslot
    @slot('cardContent')
@endif

    {{-- allow comment --}}
    @component('Admin::common.form.group', ['has_grid' => $has_grid, 'key' => 'post.allow_comment'])
    @slot('label')
    @lang('Allow comments')
    @endslot
    @slot('input')
    <div class="m-b-10">
        <label class="custom-control custom-radio">
            <input id="active" name="post[allow_comment]" type="radio" class="custom-control-input" @if ($post->isAllowedComment()) checked="" @endif value="1">
            <span class="custom-control-label">@lang('Yes')</span>
        </label>
        <label class="custom-control custom-radio">
            <input id="inactive" name="post[allow_comment]" type="radio" class="custom-control-input" @if (! $post->isAllowedComment()) checked="" @endif value="0">
            <span class="custom-control-label">@lang('No')</span>
        </label>
    </div>
    @endslot
    @endcomponent
    {{-- end allow comment --}}

    {{-- allow guest to comment --}}
    @component('Admin::common.form.group', ['has_grid' => $has_grid, 'key' => 'post.allow_comment'])
    @slot('label')
    @lang('Allow guests to comment')
    @endslot
    @slot('input')
    <div class="m-b-10">
        <label class="custom-control custom-radio">
            <input id="active" name="post[allow_guest_comment]" type="radio" class="custom-control-input" @if ($post->isAllowedGuestComment()) checked="" @endif value="1">
            <span class="custom-control-label">@lang('Yes')</span>
        </label>
        <label class="custom-control custom-radio">
            <input id="inactive" name="post[allow_guest_comment]" type="radio" class="custom-control-input" @if (! $post->isAllowedGuestComment()) checked="" @endif value="0">
            <span class="custom-control-label">@lang('No')</span>
        </label>
    </div>
    @endslot
    @endcomponent
    {{-- end allow guest to comment --}}

@if($has_collapse)
    @endslot
    @endcomponent
@endif