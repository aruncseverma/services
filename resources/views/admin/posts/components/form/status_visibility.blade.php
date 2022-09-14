@php($has_grid = false)

@component('Admin::posts.components.form.card_collapse', ['cardId' => 'status_visibility'])
@slot('cardTitle')
@lang('Status and Availability')
@endslot
@slot('cardContent')

    {{-- is active --}}
    @component('Admin::common.form.group', ['has_grid' => $has_grid, 'key' => 'post.is_active'])
    @slot('label')
    @lang('Status')
    @endslot

    @slot('input')
    <div class="m-b-10">
        <label class="custom-control custom-radio">
            <input id="active" name="post[is_active]" type="radio" class="custom-control-input" @if ($post->isActive()) checked="" @endif value="1">
            <span class="custom-control-label">@lang('Active')</span>
        </label>
        <label class="custom-control custom-radio">
            <input id="inactive" name="post[is_active]" type="radio" class="custom-control-input" @if (! $post->isActive()) checked="" @endif value="0">
            <span class="custom-control-label">@lang('Inactive')</span>
        </label>
    </div>
    @endslot
    @endcomponent
    {{-- end is active --}}

    @component('Admin::common.form.group', ['has_grid' => $has_grid, 'key' => 'post.post_at', 'labelClasses' => 'es-required', 'labelId' => 'post_at'])
    @slot('label')
    @lang('Publish Date')
    @endslot
    @slot('input')
    <input type="text" id="post_at" name="post[post_at]" class="form-control" placeholder="mm/dd/yyyy" value="{{ $post->post_at }}">
    @endslot
    @endcomponent

@endslot
@endcomponent