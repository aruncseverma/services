@extends('Admin::layout')

{{-- title --}}
@section('main.content.title')
{{ $title }}
@endsection
{{-- end title --}}

@section('main.content.title.right')
<div class="col-md-6 col-12 text-right">
    @if($post->getKey())
    <div class="dropdown" style="display:inline-block;">
        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            @lang('Actions')
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <a href="{{ route('admin.post.clone', ['id' => $post->getKey()]) }}" class="dropdown-item"><i class="mdi mdi-content-copy"></i> @lang('Clone')</a>
            <a href="{{ url($post->slug) }}?lang_code={{ $langCode }}" class="dropdown-item" target="_blank"><i class="mdi mdi-eye"></i> @lang('Preview')</a>
            <div class="dropdown-divider"></div>
            @include('Admin::common.table.actions.delete', ['to' => route('admin.post.delete'), 'id' => $post->getKey(), 'btnText' => __('Delete'), 'btnCls' => 'dropdown-item es es-submit'])
        </div>
    </div>
    @endif
    <button type="button" class="btn btn-success" id="btn-save"> <i class="fa fa-check"></i> @lang('Save')</button>
    <a href="{{ route('admin.posts.manage') }}" class="btn btn-inverse">@lang('Cancel')</a>
</div>
@endsection

@section('main.content')
<form class="form es es-validation col-lg-12" action="{{ route('admin.post.save') }}" method="POST" enctype="multipart/form-data" id="form-save">
    {{-- hidden --}}
    {{ csrf_field() }}
    <input type="hidden" id="post_id" name="post[id]" value="{{ $post->getKey() }}">
    {{-- end hidden --}}
    <div class="col-lg-12">
        <div class="row">
            <div class="col-lg-9">
                <div class="card">
                    <div class="card-body">
                        {{-- notification --}}
                        @include('Admin::common.notifications')

                        {{-- end notification --}}

                        <h4 class="card-title">@lang('Information')</h4>
                        <hr />

                        @component('Admin::common.form.group', ['key' => 'description.lang_code', 'labelClasses' => 'es-required', 'labelId' => 'lang_code'])
                        @slot('label')
                        @lang('Language')
                        @endslot

                        @slot('input')
                        <select name="description[lang_code]" id="lang_code" class="form-control">
                            @foreach ($languages as $language)
                            <option data-lang="{{ $language->code }}" data-href="{{ $languageUrl }}&lang_code={{ $language->code }}" value="{{ $language->code }}" @if($language->code == $langCode) selected @endif>{{ $language->name }}</option>
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

                        <h4 class="card-title">
                            @lang('Meta Data')
                            @component('Admin::common.tooltip')
                            @slot('tooltipText')
                            <p>SEO metadata is what appears on search engine result pages (SERP) when a website comes up for certain queries. It includes the title of the page and its metadescription (descriptive text below the title).</p>
                            @endslot
                            @endcomponent
                        </h4>
                        <hr />

                        @component('Admin::common.form.group', ['key' => 'description.meta_description'])
                        @slot('label')
                        @lang('Page Title')
                        @component('Admin::common.tooltip')
                        @slot('tooltipText')
                        <p>Page Title displayed on a browser panel</p>
                        @endslot
                        @endcomponent
                        @endslot
                        @slot('input')
                        <input type="text" id="page_title" name="description[page_title]" class="form-control" placeholder="@lang('Page Title')" value="{{ $description->page_title }}" />
                        @endslot
                        @endcomponent

                        @component('Admin::common.form.group', ['key' => 'description.meta_description'])
                        @slot('label')
                        @lang('Meta Description')
                        @component('Admin::common.tooltip')
                        @slot('tooltipText')
                        <p>The meta description is an HTML attribute that provides a brief summary of a web page. Search engines such as Google often display the meta description in search results, which can influence click-through rates.</p>
                        @endslot
                        @endcomponent
                        @endslot
                        @slot('input')
                        <textarea id="meta_description" name="description[meta_description]" class="form-control" placeholder="@lang('Meta Description')">{{ $description->meta_description }}</textarea>
                        @endslot
                        @endcomponent

                        @component('Admin::common.form.group', ['key' => 'description.meta_keywords'])
                        @slot('label')
                        @lang('Meta Keywords')
                        @component('Admin::common.tooltip')
                        @slot('tooltipText')
                        <p>Keywords are the words and phrases that people type into search engines in order to find what they're looking for. By extension, they also describe what a piece of content (or an entire website!) is all about, and they're the words at the heart of on-page optimization. They still play an important role in a site's ability to rank, so by identifying the right words and phrases to target you can have an outsized impact on achieving your SEO goals.</p>
                        @endslot
                        @endcomponent
                        @endslot
                        @slot('input')
                        <input id="meta_keywords" name="description[meta_keywords]" class="form-control" data-role="tagsinput" placeholder="@lang('Meta Keywords')" value="{{ $description->meta_keywords }}">
                        @endslot
                        @endcomponent
                    </div>
                </div>
            </div>
            <div class="col-lg-3">

                @include('Admin::posts.components.form.status_visibility')
                @include('Admin::posts.components.form.seo')
                @include('Admin::posts.components.form.categories')
                @include('Admin::posts.components.form.tags')
                @include('Admin::posts.components.form.discussion')
                @include('Admin::posts.components.form.featured_image')
            </div>
        </div>
    </div>
</form>

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
        var $btnSave = $('#btn-save');
        var $formSave = $('#form-save');

        $('#lang_code').on('change', function() {
            // var $targetUrl = $(this).children("option:selected").data('href');
            // if (typeof $targetUrl !== 'undefined' && $targetUrl != '') {
            //     fnRedirect($targetUrl);
            //     return false;
            // }

            fnAjax({
                url: '{{ route("admin.post.get_description") }}',
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

        // content editor - auto set height
        var iframe = $('.wysihtml5-sandbox');
        var iframeDefaultHeight = iframe.height();
        var editor = iframe.contents().find('body');
        editor.on('keydown', function() {
            var editorHeight = editor.height();
            if (editorHeight > iframeDefaultHeight) {
                iframe.height(editorHeight);
            } else {
                iframe.height(iframeDefaultHeight);
            }
        });

        $btnSave.click(function() {
            $formSave.submit();
        });

        var $pageTitleContainer = $('.row.page-titles');
        var $pageTitleContainerTop = $pageTitleContainer.offset().top;
        var $pageTitleContainerWidth = $pageTitleContainer.width();
        var $isPageTitleFixed = false;
        $(window).on('scroll resize', function() {
            var wTop = $(this).scrollTop();
            if (wTop > 0) {
                $pageTitleContainerWidth = $pageTitleContainer.width();
                if (!$isPageTitleFixed) {
                    $pageTitleContainer.css({
                        'position': 'fixed',
                        'background-color': '#f2f7f8',
                        'top': ($pageTitleContainerTop - 25),
                        'z-index': 99,
                        'width': ($pageTitleContainerWidth) + 'px',
                        'padding-top': '25px'
                    });
                    $isPageTitleFixed = true;
                }

            } else {
                if ($isPageTitleFixed) {
                    $pageTitleContainer.css({
                        'position': '',
                        'background-color': '',
                        'top': '',
                        'width': '',
                        'padding-top': '',
                    });
                    $isPageTitleFixed = false;
                }
            }
        });
    });
</script>
@endPushAssets