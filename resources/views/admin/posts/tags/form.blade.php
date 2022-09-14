@extends('Admin::layout')

{{-- title --}}
@section('main.content.title')
{{ $title }}
@endsection
{{-- end title --}}

@section('main.content')
<div class="col-lg-12">
    @if($tag->getKey())
    <div class="row">
        <!-- Column -->
        <div class="col-md-6 col-lg-3 col-xlg-3">
            <div class="card card-inverse card-info">
                <a href="{{ route('admin.posts.manage', ['tag_id' => $tag->getKey()]) }}">
                    <div class="box bg-info text-center">
                        <h1 class="font-light text-white">{{ $tag->getTotalPosts() ?? 0 }}</h1>
                        <h6 class="text-white">@lang('Total')</h6>
                    </div>
                </a>
            </div>
        </div>
        <!-- Column -->
        <div class="col-md-6 col-lg-3 col-xlg-3">
            <div class="card card-primary card-inverse">
                <a href="{{ route('admin.posts.manage', ['published' => 1, 'tag_id' => $tag->getKey()]) }}">
                    <div class="box text-center">
                        <h1 class="font-light text-white">{{ $tag->getTotalPostsPublished() ?? 0 }}</h1>
                        <h6 class="text-white">@lang('Published')</h6>
                    </div>
                </a>
            </div>
        </div>
        <!-- Column -->
        <div class="col-md-6 col-lg-3 col-xlg-3">
            <div class="card card-inverse card-success">
                <a href="{{ route('admin.posts.manage', ['published' => 0, 'tag_id' => $tag->getKey()]) }}">
                    <div class="box text-center">
                        <h1 class="font-light text-white">{{ $tag->getTotalPostsNotPublishYet() ?? 0 }}</h1>
                        <h6 class="text-white">@lang('Not Publish Yet')</h6>
                    </div>
                </a>
            </div>
        </div>
        <!-- Column -->
        <div class="col-md-6 col-lg-3 col-xlg-3">
            <div class="card card-inverse card-warning">
                <a href="{{ route('admin.posts.manage', ['pending' => 1, 'tag_id' => $tag->getKey()]) }}">
                    <div class="box text-center">
                        <h1 class="font-light text-white">{{ $tag->getTotalPostsPending() ?? 0 }}</h1>
                        <h6 class="text-white">@lang('Pending')</h6>
                    </div>
                </a>
            </div>
        </div>
    </div>
    @endif
    <div class="card">
        <div class="card-body">
            {{-- notification --}}
            @include('Admin::common.notifications')
            {{-- end notification --}}

            <form class="form es es-validation" action="{{ route('admin.posts.tags.save') }}" method="POST">
                <h4 class="card-title">@lang('Tag Information')</h4>
                <hr />

                {{-- hidden --}}
                {{ csrf_field() }}
                <input type="hidden" id="tag_id" name="tag[id]" value="{{ $tag->getKey() }}">
                {{-- end hidden --}}

                @component('Admin::common.form.group', ['key' => 'tag.slug', 'labelClasses' => 'es-slug', 'labelId' => 'slug'])
                @slot('label')
                @lang('Slug')
                @endslot
                @slot('input')
                <input type="text" id="slug" name="tag[slug]" class="form-control" placeholder="@lang('Slug')" value="{{ $tag->slug }}">
                @endslot
                @endcomponent

                {{-- is active --}}
                @component('Admin::common.form.group', ['key' => 'tag.is_active'])
                @slot('label')
                @lang('Status')
                @endslot

                @slot('input')
                <div class="m-b-10">
                    <label class="custom-control custom-radio">
                        <input id="active" name="tag[is_active]" type="radio" class="custom-control-input" @if ($tag->isActive()) checked="" @endif value="1">
                        <span class="custom-control-label">@lang('Active')</span>
                    </label>
                    <label class="custom-control custom-radio">
                        <input id="inactive" name="tag[is_active]" type="radio" class="custom-control-input" @if (! $tag->isActive()) checked="" @endif value="0">
                        <span class="custom-control-label">@lang('Inactive')</span>
                    </label>
                </div>
                @endslot
                @endcomponent
                {{-- end is active --}}

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

                @component('Admin::common.form.group', ['key' => 'description.name', 'labelClasses' => 'es-required', 'labelId' => 'name'])
                @slot('label')
                @lang('Name')
                @endslot
                @slot('input')
                <input type="text" id="name" name="description[name]" class="form-control" placeholder="@lang('Name')" value="{{ $description->name }}">
                @endslot
                @endcomponent

                @component('Admin::common.form.group', ['key' => 'description.description', 'labelClasses' => '', 'labelId' => 'description'])
                @slot('label')
                @lang('Description')
                @endslot
                @slot('input')
                <textarea id="description" name="description[description]" class="form-control textarea_editor" placeholder="@lang('Description')" rows="15">{{ $description->description }}</textarea>
                @endslot
                @endcomponent

                <div class="form-actions pull-right">
                    @if($tag->getKey())
                    @include('Admin::common.table.actions.delete', ['to' => route('admin.posts.tags.delete'), 'id' => $tag->getKey(), 'btnText' => __('Delete'), 'btnCls' => 'btn btn-danger'])
                    <a href="{{ route('index.posts.tags.view',['path'=>$tag->slug, 'lang_code' => $langCode]) }}" class="btn btn-secondary" target="_blank"> <i class="mdi mdi-eye"></i> @lang('Preview')</a>
                    @endif
                    <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> @lang('Save')</button>
                    <a href="{{ route('admin.posts.tags.manage') }}" class="btn btn-inverse">@lang('Cancel')</a>
                </div>

            </form>
        </div>
    </div>
</div>


@endsection

@pushAssets('styles.post')
@endPushAssets

@pushAssets('scripts.post')
<script>
    $(document).ready(function() {
        var $tag_id = $('#tag_id');
        var $name = $('#name');
        var $description = $('#description');
        $('#lang_code').on('change', function() {
            // var $targetUrl = $(this).children("option:selected").data('href');
            // if (typeof $targetUrl !== 'undefined' && $targetUrl != '') {
            //     fnRedirect($targetUrl);
            //     return false;
            // }

            fnAjax({
                url: '{{ route("admin.posts.tags.get_description") }}',
                data: {
                    tag_id: $tag_id.val(),
                    lang_code: $(this).children("option:selected").data('lang')
                },
                success: function(data) {
                    if (data.status == 0) {
                        fnAlert(data.message);
                    }

                    $name.val(data.data.name || '');
                    $description.val(data.data.description || '');
                }
            });
        });
    });
</script>
@endPushAssets