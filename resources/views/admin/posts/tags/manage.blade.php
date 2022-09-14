@extends('Admin::layout')

{{-- title --}}
@section('main.content.title')
{{ $title }}
@endsection
{{-- end title --}}

@section('main.content.title.right')
<div class="col-md-6 col-8 align-self-center text-right">
    <a href="{{ route('admin.posts.tags.create') }}" class="btn btn-info">@lang('New')</a>
    @if($tags->count())
    <div class="dropdown" style="display:inline-block;">
        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            {{--<i class="fa fa-gear"></i>--}}
            @lang('Actions')
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <a href="#" class="dropdown-item es es-submit es-need-selected-items" data-need-selected-items-selector=".ids" data-form-id="manage_form" data-form-action="{{ route('admin.posts.tags.m_update_status', ['status' => 1]) }}">@lang('Activate selected')</a>
            <a href="#" class="dropdown-item es es-submit es-need-selected-items" data-need-selected-items-selector=".ids" data-form-id="manage_form" data-form-action="{{ route('admin.posts.tags.m_update_status', ['status' => 0]) }}">@lang('Disable selected')</a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item es es-submit es-confirm es-need-selected-items" data-need-selected-items-selector=".ids" data-form-id="manage_form" data-form-action="{{ route('admin.posts.tags.m_delete') }}">@lang('Delete selected')</a>
        </div>
    </div>
    @endif
</div>
@endsection

@section('main.content')
<div class="col-lg-12">
    <div class="row">
        <!-- Column -->
        <div class="col-md-6 col-lg-4 col-xlg-4">
            <div class="card card-inverse card-info">
                <a href="{{ route('admin.posts.tags.manage') }}">
                    <div class="box bg-info text-center">
                        <h1 class="font-light text-white">{{ $totalTags ?? 0 }}</h1>
                        <h6 class="text-white">@lang('Total')</h6>
                    </div>
                </a>
            </div>
        </div>
        <!-- Column -->
        <div class="col-md-6 col-lg-4 col-xlg-4">
            <div class="card card-primary card-inverse">
                <a href="{{ route('admin.posts.tags.manage', ['is_active' => 1]) }}">
                    <div class="box text-center">
                        <h1 class="font-light text-white">{{ $totalActiveTags ?? 0 }}</h1>
                        <h6 class="text-white">@lang('Active')</h6>
                    </div>
                </a>
            </div>
        </div>
        <!-- Column -->
        <div class="col-md-6 col-lg-4 col-xlg-4">
            <div class="card card-inverse card-warning">
                <a href="{{ route('admin.posts.tags.manage', ['is_active' => 0]) }}">
                    <div class="box text-center">
                        <h1 class="font-light text-white">{{ $totalInactiveTags ?? 0 }}</h1>
                        <h6 class="text-white">@lang('Inactive')</h6>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            {{-- search --}}
            @component('Admin::common.search', ['action' => route('admin.posts.tags.manage')])
            <input type="hidden" name="limit" value="{{ $search['limit'] }}">

            <div class="row p-t-20">
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label" for="name">@lang('Name')</label>
                        <input type="text" id="name" class="form-control" name="name" value="{{ $search['name'] }}">
                    </div>
                </div>
                <div class="col-md-4">
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
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label" for="slug">@lang('Slug')</label>
                        <input type="text" id="slug" class="form-control" name="slug" value="{{ $search['slug'] }}">
                    </div>
                </div>
            </div>
            @endcomponent
            {{-- end search --}}

            {{-- notification --}}
            @include('Admin::common.notifications')
            {{-- end notification --}}

            <form id="manage_form" method="POST">
                @csrf
                @component('Admin::common.table')
                @slot('head')
                <th>
                    <div class="checkbox" style="height: 20px;">
                        <input type="checkbox" id="checkbox0" value="check" class="es es-check-items" data-check-items-selector=".ids">
                        <label for="checkbox0"></label>
                    </div>
                </th>
                <th>@lang('Name')</th>
                <th>@lang('Slug')</th>
                <th>@lang('Count')</th>
                <th>@lang('Status')</th>
                <th>@lang('Actions')</th>
                @endslot

                @slot('body')
                @forelse ($tags as $tag)
                <tr>
                    <td style="width:40px">
                        <div class="checkbox">
                            <input type="checkbox" name="ids[]" class="ids" id="checkbox{{ $tag->getKey() }}" value="{{ $tag->getKey() }}">
                            <label for="checkbox{{ $tag->getKey() }}"></label>
                        </div>
                    </td>
                    <td>{{ $tag->getDescription($langCode)->name }}</td>
                    <td>{{ $tag->slug ?? '--' }}</td>
                    <td><a href="{{ route('admin.posts.manage', ['tag_id'=> $tag->getKey()]) }}">{{ $tag->getTotalPosts() }}</a></td>
                    <td>@include('Admin::common.account_status', ['isActive' => $tag->isActive()])</td>
                    <td>
                        @component('Admin::common.table.dropdown_actions', [
                        'optionActions' => [
                        'edit_' . $tag->getKey() => __('Update'),
                        'update_status_' . $tag->getKey() => $tag->isActive() ? __('Disable') : __('Activate'),
                        'delete_' . $tag->getKey() => __('Delete'),
                        'preview_' . $tag->getKey() => __('Preview'),
                        ]
                        ])
                        @include('Admin::common.table.actions.update', ['href' => route('admin.posts.tags.update', ['id' => $tag->getKey()]), 'btnId' => 'edit_' . $tag->getKey()])
                        @include('Admin::common.table.actions.update_status', [
                        'route' => 'admin.posts.tags.update_status',
                        'id' => $tag->getKey(),
                        'isActive' => $tag->isActive(),
                        'btnId' => 'update_status_' . $tag->getKey(),
                        ])
                        @include('Admin::common.table.actions.delete', ['to' => route('admin.posts.tags.delete'), 'id' => $tag->getKey(), 'btnId' => 'delete_' . $tag->getKey()])
                        <a id="preview_{{ $tag->getKey() }}" href="{{ route('index.posts.tags.view',['path'=>$tag->slug, 'lang_code' => $langCode]) }}" class="btn btn-secondary btn-xs" target="_blank"><i class="mdi mdi-eye"></i></a>
                        @endcomponent
                    </td>
                </tr>
                @empty
                @include('Admin::common.table.no_results', ['colspan' => 5])
                @endforelse
                @endslot
                @endcomponent
            </form>

            {{ $tags->links() }}
        </div>
    </div>
</div>
@endsection