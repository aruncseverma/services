@extends('Admin::layout')

{{-- title --}}
@section('main.content.title')
{{ $title }}
@endsection
{{-- end title --}}

@section('main.content.title.right')
<div class="col-md-6 col-12 text-right">
    @if($post->getKey())
    {{--
    @include('Admin::common.table.actions.delete', ['to' => route('admin.page.delete'), 'id' => $post->getKey(), 'btnText' => __('Delete'), 'btnCls' => 'btn btn-danger'])
    <a href="{{ route('admin.page.clone', ['id' => $post->getKey()]) }}" class="btn btn-secondary"> <i class="mdi mdi-content-copy"></i> @lang('Clone')</a>
    <a href="{{ $post->getPostUrl() }}?lang_code={{ $langCode }}" class="btn btn-secondary" target="_blank"> <i class="mdi mdi-eye"></i> @lang('Preview')</a>
    --}}
    <div class="dropdown" style="display:inline-block;">
        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            @lang('Actions')
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <a href="{{ route('admin.page.clone', ['id' => $post->getKey()]) }}" class="dropdown-item"><i class="mdi mdi-content-copy"></i> @lang('Clone')</a>
            <a href="{{ $post->getPostUrl() }}?lang_code={{ $langCode }}" class="dropdown-item" target="_blank"><i class="mdi mdi-eye"></i> @lang('Preview')</a>
            <div class="dropdown-divider"></div>
            @include('Admin::common.table.actions.delete', ['to' => route('admin.page.delete'), 'id' => $post->getKey(), 'btnText' => __('Delete'), 'btnCls' => 'dropdown-item es es-submit'])
        </div>
    </div>
    @endif
    <button type="button" class="btn btn-success es es-submit" data-form-id="form-save"> <i class="fa fa-check"></i> @lang('Save')</button>
    <a href="{{ route('admin.pages.manage') }}" class="btn btn-inverse">@lang('Cancel')</a>
</div>
@endsection

@section('main.content')
<div class="col-lg-12">
    <div class="card">
        <div class="card-body">
            {{-- notification --}}
            @if (old('notify') != 'post_photo')
            @include('Admin::common.notifications')
            @endif
            {{-- end notification --}}

            <form id="form-save" class="form es es-validation" action="{{ route('admin.page.save') }}" method="POST">
                <h4 class="card-title">@lang('Page Information')</h4>
                <hr />

                {{-- hidden --}}
                {{ csrf_field() }}
                <input type="hidden" id="post_id" name="post[id]" value="{{ $post->getKey() }}">
                {{-- end hidden --}}

                @component('Admin::common.form.group', ['key' => 'post.parent_id', 'labelId' => 'parent_id'])
                @slot('label')
                @lang('Parent Page')
                @endslot
                @slot('input')
                @include('Admin::pages.components.select_parent', [
                'id' => 'parent_id',
                'name' => 'post[parent_id]',
                'value' => $post->parent_id,
                'except_id' => $post->getKey(),
                ])
                @endslot
                @endcomponent

                @component('Admin::common.form.group', ['key' => 'post.slug', 'labelClasses' => 'es-slug', 'labelId' => 'slug'])
                @slot('label')
                @lang('Slug')
                @endslot
                @slot('input')
                <input type="text" id="slug" name="post[slug]" class="form-control" placeholder="@lang('Slug')" value="{{ $post->slug }}">
                @endslot
                @endcomponent

                {{-- is active --}}
                @component('Admin::common.form.group', ['key' => 'post.is_active'])
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

                @component('Admin::common.form.group', ['key' => 'post.post_at', 'labelClasses' => 'es-required', 'labelId' => 'post_at'])
                @slot('label')
                @lang('Publish Date')
                @endslot
                @slot('input')
                <input type="text" id="post_at" name="post[post_at]" class="form-control" placeholder="mm/dd/yyyy" value="{{ $post->post_at }}">
                @endslot
                @endcomponent

                @component('Admin::common.form.group', ['key' => 'description.lang_code', 'labelClasses' => 'es-required', 'labelId' => 'lang_code'])
                @slot('label')
                @lang('Language')
                @endslot

                @slot('input')
                <select name="description[lang_code]" id="lang_code" class="form-control">
                    @foreach ($languages as $language)
                    <option data-lang="{{ $language->code }}" data-href=" {{ $languageUrl }}&lang_code={{ $language->code }}" value="{{ $language->code }}" @if($language->code == $langCode) selected @endif>{{ $language->name }}</option>
                    @endforeach
                </select>
                @endslot
                @endcomponent

                @component('Admin::common.form.group', ['key' => 'description.title', 'labelClasses' => 'es-required', 'labelId' => 'title'])
                @slot('label')
                @lang('Title')
                @endslot
                @slot('input')
                <input type="text" id="title" name="description[title]" class="form-control" placeholder="@lang('Title')" value="{{ $description->title }}">
                @endslot
                @endcomponent

                @component('Admin::common.form.group', ['key' => 'description.content', 'labelClasses' => 'es-required', 'labelId' => 'content', 'labelAttrs' => 'data-error-next-to=1'])
                @slot('label')
                @lang('Content')
                @endslot
                @slot('input')
                <textarea id="content" name="description[content]" class="form-control textarea_editor" placeholder="@lang('Content')" rows="15">{{ $description->content }}</textarea>
                @endslot
                @endcomponent

                <h4 class="card-title">@lang('Meta Data')</h4>
                <hr />

                @component('Admin::common.form.group', ['key' => 'description.meta_description'])
                @slot('label')
                @lang('Page Title')
                @endslot
                @slot('input')
                <input type="text" id="page_title" name="description[page_title]" class="form-control" placeholder="@lang('Page Title')" value="{{ $description->page_title }}" />
                @endslot
                @endcomponent

                @component('Admin::common.form.group', ['key' => 'description.meta_description'])
                @slot('label')
                @lang('Meta Description')
                @endslot
                @slot('input')
                <textarea id="meta_description" name="description[meta_description]" class="form-control" placeholder="@lang('Meta Description')">{{ $description->meta_description }}</textarea>
                @endslot
                @endcomponent

                @component('Admin::common.form.group', ['key' => 'description.meta_keywords'])
                @slot('label')
                @lang('Meta Keywords')
                @endslot
                @slot('input')
                <input id="meta_keywords" name="description[meta_keywords]" class="form-control" data-role="tagsinput" placeholder="@lang('Meta Keywords')" value="{{ $description->meta_keywords }}">
                @endslot
                @endcomponent

                <h4 class="card-title">@lang('Discussion')</h4>
                <hr />
                @include('Admin::posts.components.form.discussion', [
                'post' => $post,
                'has_grid' => true,
                'has_collapse' => false,
                ])

                {{--<div class="form-actions pull-right">
                    @if($post->getKey())
                    @include('Admin::common.table.actions.delete', ['to' => route('admin.page.delete'), 'id' => $post->getKey(), 'btnText' => __('Delete'), 'btnCls' => 'btn btn-danger'])
                    <a href="{{ route('admin.page.clone', ['id' => $post->getKey()]) }}" class="btn btn-secondary"> <i class="mdi mdi-content-copy"></i> @lang('Clone')</a>
                <a href="{{ $post->getPostUrl() }}?lang_code={{ $langCode }}" class="btn btn-secondary" target="_blank"> <i class="mdi mdi-eye"></i> @lang('Preview')</a>
                @endif
                <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> @lang('Save')</button>
                <a href="{{ route('admin.pages.manage') }}" class="btn btn-inverse">@lang('Cancel')</a>
        </div>--}}

        </form>
    </div>
</div>
</div>

@if($post->getKey())
@include('Admin::posts.components.featured_image', [
'uploadUrl' => route('admin.page.upload_photo'),
'deleteUrl' => route('admin.page.delete_photo')
])
@endif

@endsection

@pushAssets('styles.post')
<!-- wysihtml5 CSS -->
<link rel="stylesheet" href="{{ asset('assets/theme/admin/default/plugins/html5-editor/bootstrap-wysihtml5.css') }}" />
<!-- DateTime Picker Plugin JavaScript -->
<link href="{{ asset('assets/theme/admin/default/plugins/bootstrap-datetimepicker/build/css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet" type="text/css" />
<style>
    /** fixed tab input width */
    .bootstrap-tagsinput {
        width: 100% !important
    }
</style>
@endPushAssets

@pushAssets('scripts.post')
<script src="{{ asset('assets/theme/admin/default/plugins/html5-editor/wysihtml5-0.3.0.js') }}"></script>
<script src="{{ asset('assets/theme/admin/default/plugins/html5-editor/bootstrap-wysihtml5.js') }}"></script>
<!-- Moment -->
<script src="{{ asset('assets/theme/admin/default/plugins/moment/moment.min.js') }}"></script>
<!-- DateTime Picker Plugin JavaScript -->
<script src="{{ asset('assets/theme/admin/default/plugins/bootstrap-datetimepicker/build/js/bootstrap-datetimepicker.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $('.textarea_editor').wysihtml5();

        var $post_id = $('#post_id');
        var $title = $('#title');
        var $content = $('#content');
        var $meta_description = $('#meta_description');
        var $meta_keywords = $('#meta_keywords');

        $('#lang_code').on('change', function() {
            // var $targetUrl = $(this).children("option:selected").data('href');
            // if (typeof $targetUrl !== 'undefined' && $targetUrl != '') {
            //     fnRedirect($targetUrl);
            //     return false;
            // }

            fnAjax({
                url: '{{ route("admin.page.get_description") }}',
                data: {
                    post_id: $post_id.val(),
                    lang_code: $(this).children("option:selected").data('lang')
                },
                success: function(data) {
                    if (data.status == 0) {
                        fnAlert(data.message);
                    }

                    $title.val(data.data.title || '');

                    $content.val(data.data.content || '');
                    // manual remove editor
                    $('.wysihtml5-toolbar, .wysihtml5-sandbox').remove();
                    // display textarea then apply editor again
                    $content.show().wysihtml5();

                    $meta_description.val(data.data.meta_description || '');
                    $meta_keywords.tagsinput('removeAll');
                    $meta_keywords.tagsinput('add', data.data.meta_keywords || '');
                }
            });
        });

        $('#post_at').datetimepicker({
            icons: {
                time: "fa fa-clock-o",
                date: "fa fa-calendar",
                up: "fa fa-arrow-up",
                down: "fa fa-arrow-down"
            }
        });
    });
</script>
@endPushAssets