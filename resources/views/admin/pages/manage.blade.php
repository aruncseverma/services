@extends('Admin::layout')

{{-- title --}}
@section('main.content.title')
{{ $title }}
@endsection
{{-- end title --}}

@section('main.content.title.right')
<div class="col-md-6 col-8 align-self-center text-right">
    {{--@if($pages->count())
    <button type="button" class="btn btn-default es es-submit es-need-selected-items" data-need-selected-items-selector=".page-ids" data-form-id="form_pages" data-form-action="{{ route('admin.pages.m_clone') }}">@lang('Clone')</button>
    <button type="button" class="btn btn-danger es es-submit es-confirm es-need-selected-items" data-need-selected-items-selector=".page-ids" data-form-id="form_pages" data-form-action="{{ route('admin.pages.m_delete') }}">@lang('Delete')</button>
    <button type="button" class="btn btn-success es es-submit es-need-selected-items" data-need-selected-items-selector=".page-ids" data-form-id="form_pages" data-form-action="{{ route('admin.pages.m_update_status', ['status' => 1]) }}">@lang('Activate')</button>
    <button type="button" class="btn btn-danger es es-submit es-need-selected-items" data-need-selected-items-selector=".page-ids" data-form-id="form_pages" data-form-action="{{ route('admin.pages.m_update_status', ['status' => 0]) }}">@lang('Disable')</button>
    @endif--}}
    <a href="{{ route('admin.page.create') }}" class="btn btn-info">@lang('New')</a>
    @if($pages->count())
    <div class="dropdown" style="display:inline-block;">
        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            @lang('Actions')
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <a href="#" class="dropdown-item es es-submit es-need-selected-items" data-need-selected-items-selector=".page-ids" data-form-id="form_pages" data-form-action="{{ route('admin.pages.m_update_status', ['status' => 1]) }}">@lang('Activate selected')</a>
            <a href="#" class="dropdown-item es es-submit es-need-selected-items" data-need-selected-items-selector=".page-ids" data-form-id="form_pages" data-form-action="{{ route('admin.pages.m_update_status', ['status' => 0]) }}">@lang('Disable selected')</a>
            <a href="#" class="dropdown-item es es-submit es-need-selected-items" data-need-selected-items-selector=".page-ids" data-form-id="form_pages" data-form-action="{{ route('admin.pages.m_clone') }}">@lang('Clone selected')</a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item es es-submit es-confirm es-need-selected-items" data-need-selected-items-selector=".page-ids" data-form-id="form_pages" data-form-action="{{ route('admin.pages.m_delete') }}">@lang('Delete selected')</a>
        </div>
    </div>
    @endif
</div>
@endsection

@section('main.content')
<div class="col-lg-12">
    <div class="row">
        <!-- Column -->
        <div class="col-md-6 col-lg-3 col-xlg-3">
            <div class="card card-inverse card-info">
                <a href="{{ route('admin.pages.manage') }}">
                    <div class="box bg-info text-center">
                        <h1 class="font-light text-white">{{ $totalPosts ?? 0 }}</h1>
                        <h6 class="text-white">@lang('Total')</h6>
                    </div>
                </a>
            </div>
        </div>
        <!-- Column -->
        <div class="col-md-6 col-lg-3 col-xlg-3">
            <div class="card card-primary card-inverse">
                <a href="{{ route('admin.pages.manage', ['published' => 1]) }}">
                    <div class="box text-center">
                        <h1 class="font-light text-white">{{ $totalPublished ?? 0 }}</h1>
                        <h6 class="text-white">@lang('Published')</h6>
                    </div>
                </a>
            </div>
        </div>
        <!-- Column -->
        <div class="col-md-6 col-lg-3 col-xlg-3">
            <div class="card card-inverse card-success">
                <a href="{{ route('admin.pages.manage', ['published' => 0]) }}">
                    <div class="box text-center">
                        <h1 class="font-light text-white">{{ $totalNotPublishYet ?? 0 }}</h1>
                        <h6 class="text-white">@lang('Not Publish Yet')</h6>
                    </div>
                </a>
            </div>
        </div>
        <!-- Column -->
        <div class="col-md-6 col-lg-3 col-xlg-3">
            <div class="card card-inverse card-warning">
                <a href="{{ route('admin.pages.manage', ['pending' => 1]) }}">
                    <div class="box text-center">
                        <h1 class="font-light text-white">{{ $totalPending ?? 0 }}</h1>
                        <h6 class="text-white">@lang('Pending')</h6>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            {{-- search --}}
            @component('Admin::common.search', ['action' => route('admin.pages.manage')])
            <input type="hidden" name="limit" value="{{ $search['limit'] }}">

            <div class="row p-t-20">
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="control-label" for="title">@lang('Title')</label>
                        <input type="text" id="title" class="form-control" name="title" value="{{ $search['title'] }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="control-label" for="is_active">@lang('Status')</label>
                        <div class="m-b-10">
                            <label class="custom-control custom-radio">
                                <input id="active" name="is_active" type="radio" class="custom-control-input" @if ($search['is_active']=='1' ) checked="" @endif value="1">
                                <span class="custom-control-label">@lang('Active')</span>
                            </label>
                            <label class="custom-control custom-radio">
                                <input id="inactive" name="is_active" type="radio" class="custom-control-input" @if ($search['is_active']=='0' ) checked="" @endif value="0">
                                <span class="custom-control-label">@lang('Inactive')</span>
                            </label>
                            <label class="custom-control custom-radio">
                                <input id="all" name="is_active" type="radio" class="custom-control-input" @if ($search['is_active']=='*' ) checked="" @endif value="*">
                                <span class="custom-control-label">@lang('All')</span>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="control-label" for="parent_id">@lang('Parent')</label>
                        @include('Admin::pages.components.select_parent', [
                        'id' => 'parent_id',
                        'name' => 'parent_id',
                        'value' => $search['parent_id'] ?? '',
                        ])
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="control-label" for="slug">@lang('Slug')</label>
                        <input type="text" id="slug" class="form-control" name="slug" value="{{ $search['slug'] }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="control-label" for="slug">@lang('Date')</label>
                        <div class="m-b-10">
                            @include('Admin::common.form.date_range', [
                            'id' => 'post_at',
                            'name_start' => 'post_at_start',
                            'value_start' => $search['post_at_start'] ?? '',
                            'name_end' => 'post_at_end',
                            'value_end' => $search['post_at_end'] ?? '',
                            ])
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="control-label" for="author">@lang('Author')</label>
                        <input type="text" id="author" class="form-control" name="author" value="{{ $search['author'] }}">
                    </div>
                </div>
            </div>
            @endcomponent
            {{-- end search --}}

            {{-- notification --}}
            @include('Admin::common.notifications')
            {{-- end notification --}}

            <form id="form_pages" method="POST" action="{{ route('admin.posts.m_delete') }}">
                @csrf
                @component('Admin::common.table')
                @slot('head')
                <th>
                    <div class="checkbox" style="height: 20px;">
                        <input type="checkbox" id="checkbox0" value="check" class="es es-check-items" data-check-items-selector=".page-ids">
                        <label for="checkbox0"></label>
                    </div>
                </th>
                <th>@lang('title')</th>
                <th>@lang('Parent')</th>
                <th>@lang('Author')</th>
                <th>@lang('Comments')</th>
                <th>@lang('Slug')</th>
                <th>@lang('Status')</th>
                <th>@lang('Date')</th>
                <th>@lang('Actions')</th>
                @endslot

                @slot('body')
                @include('Admin::pages.components.table_rows')
                @endslot
                @endcomponent
            </form>
            @if(!$isParentToChild)
            {{ $pages->links() }}
            @else
            {{ $totalPosts ?? 0 }} items
            @endif
        </div>
    </div>
</div>
@endsection