@extends('Admin::layout')

{{-- title --}}
@section('main.content.title')
{{ $title }}
@endsection
{{-- end title --}}

@section('main.content')
<div class="col-lg-12">
    @if($category->getKey())
    <div class="row">
        <!-- Column -->
        <div class="col-md-6 col-lg-3 col-xlg-3">
            <div class="card card-inverse card-info">
                <a href="{{ route('admin.posts.manage', ['category_id' => $category->getKey()]) }}">
                    <div class="box bg-info text-center">
                        <h1 class="font-light text-white">{{ $category->getTotalPosts() ?? 0 }}</h1>
                        <h6 class="text-white">@lang('Total')</h6>
                    </div>
                </a>
            </div>
        </div>
        <!-- Column -->
        <div class="col-md-6 col-lg-3 col-xlg-3">
            <div class="card card-primary card-inverse">
                <a href="{{ route('admin.posts.manage', ['published' => 1, 'category_id' => $category->getKey()]) }}">
                    <div class="box text-center">
                        <h1 class="font-light text-white">{{ $category->getTotalPostsPublished() ?? 0 }}</h1>
                        <h6 class="text-white">@lang('Published')</h6>
                    </div>
                </a>
            </div>
        </div>
        <!-- Column -->
        <div class="col-md-6 col-lg-3 col-xlg-3">
            <div class="card card-inverse card-success">
                <a href="{{ route('admin.posts.manage', ['published' => 0, 'category_id' => $category->getKey()]) }}">
                    <div class="box text-center">
                        <h1 class="font-light text-white">{{ $category->getTotalPostsNotPublishYet() ?? 0 }}</h1>
                        <h6 class="text-white">@lang('Not Publish Yet')</h6>
                    </div>
                </a>
            </div>
        </div>
        <!-- Column -->
        <div class="col-md-6 col-lg-3 col-xlg-3">
            <div class="card card-inverse card-warning">
                <a href="{{ route('admin.posts.manage', ['pending' => 1, 'category_id' => $category->getKey()]) }}">
                    <div class="box text-center">
                        <h1 class="font-light text-white">{{ $category->getTotalPostsPending() ?? 0 }}</h1>
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

            <form class="form es es-validation" action="{{ route('admin.posts.categories.save') }}" method="POST">
                <h4 class="card-title">@lang('Category Information')</h4>
                <hr />

                {{-- hidden --}}
                {{ csrf_field() }}
                <input type="hidden" id="category_id" name="category[id]" value="{{ $category->getKey() }}">
                {{-- end hidden --}}

                @component('Admin::common.form.group', ['key' => 'category.slug', 'labelClasses' => 'es-slug', 'labelId' => 'slug'])
                @slot('label')
                @lang('Slug')
                @endslot
                @slot('input')
                <input type="text" id="slug" name="category[slug]" class="form-control" placeholder="@lang('Slug')" value="{{ $category->slug }}">
                @endslot
                @endcomponent

                {{-- is active --}}
                @component('Admin::common.form.group', ['key' => 'category.is_active'])
                @slot('label')
                @lang('Status')
                @endslot

                @slot('input')
                <div class="m-b-10">
                    <label class="custom-control custom-radio">
                        <input id="active" name="category[is_active]" type="radio" class="custom-control-input" @if ($category->isActive()) checked="" @endif value="1">
                        <span class="custom-control-label">@lang('Active')</span>
                    </label>
                    <label class="custom-control custom-radio">
                        <input id="inactive" name="category[is_active]" type="radio" class="custom-control-input" @if (! $category->isActive()) checked="" @endif value="0">
                        <span class="custom-control-label">@lang('Inactive')</span>
                    </label>
                </div>
                @endslot
                @endcomponent
                {{-- end is active --}}

                @component('Admin::common.form.group', ['key' => 'category.parent_id', 'labelId' => 'parent_id'])
                @slot('label')
                @lang('Parent Category')
                @endslot
                @slot('input')
                @include('Admin::posts.categories.components.select_parent', [
                'id' => 'parent_id',
                'name' => 'category[parent_id]',
                'value' => $category->parent_id,
                'except_id' => $category->getKey(),
                ])
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
                    @if($category->getKey())
                    @include('Admin::common.table.actions.delete', ['to' => route('admin.posts.categories.delete'), 'id' => $category->getKey(), 'btnText' => __('Delete'), 'btnCls' => 'btn btn-danger'])
                    <a href="{{ route('admin.posts.categories.preview',['id'=>$category->getKey(), 'lang_code' => $langCode]) }}" class="btn btn-secondary" target="_blank"> <i class="mdi mdi-eye"></i> @lang('Preview')</a>
                    @endif
                    <button type="submit" class="btn btn-success"> <i class="fa fa-check"></i> @lang('Save')</button>
                    <a href="{{ route('admin.posts.categories.manage') }}" class="btn btn-inverse">@lang('Cancel')</a>
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
        var $category_id = $('#category_id');
        var $name = $('#name');
        var $description = $('#description');
        $('#lang_code').on('change', function() {
            // var $targetUrl = $(this).children("option:selected").data('href');
            // if (typeof $targetUrl !== 'undefined' && $targetUrl != '') {
            //     fnRedirect($targetUrl);
            //     return false;
            // }

            fnAjax({
                url: '{{ route("admin.posts.categories.get_description") }}',
                data: {
                    category_id: $category_id.val(),
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