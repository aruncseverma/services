@extends('Admin::layout')

{{-- title --}}
@section('main.content.title')
{{ $title }}
@endsection
{{-- end title --}}

@section('main.content.title.right')
<div class="col-md-6 col-8 align-self-center text-right">
    <a href="{{ route('admin.post.create') }}" class="btn btn-info">@lang('New')</a>
    @if($posts->count())
    <div class="dropdown" style="display:inline-block;">
        <button class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
            {{--<i class="fa fa-gear"></i>--}}
            @lang('Actions')
        </button>
        <div class="dropdown-menu" aria-labelledby="dropdownMenuButton">
            <a href="#" class="dropdown-item es es-submit es-need-selected-items" data-need-selected-items-selector=".post-ids" data-form-id="form_posts" data-form-action="{{ route('admin.posts.m_update_status', ['status' => 1]) }}">@lang('Activate selected')</a>
            <a href="#" class="dropdown-item es es-submit es-need-selected-items" data-need-selected-items-selector=".post-ids" data-form-id="form_posts" data-form-action="{{ route('admin.posts.m_update_status', ['status' => 0]) }}">@lang('Disable selected')</a>
            <a href="#" class="dropdown-item es es-submit es-need-selected-items" data-need-selected-items-selector=".post-ids" data-form-id="form_posts" data-form-action="{{ route('admin.posts.m_clone') }}">@lang('Clone selected')</a>
            <div class="dropdown-divider"></div>
            <a href="#" class="dropdown-item es es-submit es-confirm es-need-selected-items" data-need-selected-items-selector=".post-ids" data-form-id="form_posts" data-form-action="{{ route('admin.posts.m_delete') }}">@lang('Delete selected')</a>
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
                <a href="{{ route('admin.posts.manage') }}">
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
                <a href="{{ route('admin.posts.manage', ['published' => 1]) }}">
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
                <a href="{{ route('admin.posts.manage', ['published' => 0]) }}">
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
                <a href="{{ route('admin.posts.manage', ['pending' => 1]) }}">
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
            @component('Admin::common.search', ['action' => route('admin.posts.manage')])
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
                        <label class="control-label" for="is_active">@lang('Categories')</label>
                        <div class="m-b-10">
                            @include('Admin::posts.categories.components.select_parent', [
                            'id' => 'category_ids',
                            'name' => 'category_id',
                            'value' => $search['category_id'] ?? '',
                            'is_multiple' => true,
                            ])
                        </div>
                    </div>
                </div>
                <div class="col-md-3">
                    <div class="form-group">
                        <label class="control-label" for="is_active">@lang('Tags')</label>
                        <div class="m-b-10">
                            @include('Admin::posts.tags.components.select_tags', [
                            'id' => 'tag_id',
                            'name' => 'tag_id[]',
                            'value' => $search['tag_id'] ?? [],
                            'add' => false,
                            ])
                        </div>
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
                        <label class="control-label" for="slug">@lang('Date Published')</label>
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

            <form id="form_posts" method="POST" action="{{ route('admin.posts.m_delete') }}">
                @csrf
                @component('Admin::common.table')
                @slot('head')
                <th>
                    <div class="checkbox" style="height: 20px;">
                        <input type="checkbox" id="checkbox0" value="check" class="es es-check-items" data-check-items-selector=".post-ids">
                        <label for="checkbox0"></label>
                    </div>
                </th>
                <th>@lang('Title')</th>
                <th>@lang('Author')</th>
                <th>@lang('Categories')</th>
                <th>@lang('Tags')</th>
                <th>@lang('Comments')</th>
                <th>@lang('Slug')</th>
                <th>@lang('Status')</th>
                <th>@lang('Date')</th>
                <th>@lang('Actions')</th>
                @endslot

                @slot('body')
                @forelse ($posts as $post)
                @php
                $postDesc = $post->getDescription($langCode);
                $hasAttr = $postDesc->getAttributes();
                @endphp
                <tr @if(!$hasAttr) class="table-danger" @endif>
                    <td style="width:40px">
                        <div class="checkbox">
                            <input type="checkbox" name="ids[]" class="post-ids" id="checkbox{{ $post->getKey() }}" value="{{ $post->getKey() }}">
                            <label for="checkbox{{ $post->getKey() }}"></label>
                        </div>
                    </td>
                    <td>@if(!$hasAttr) @lang('[No description]') @else {{ $postDesc->title }} @endif</td>
                    <td>{{ $post->author->name }}</td>
                    <td>
                        @include('Admin::posts.components.categories', [
                        'catIdsNames' => $catIdsNames[$post->category_ids] ?? []
                        ])
                    </td>
                    <td>
                        @include('Admin::posts.components.tags', [
                        'tagIdsNames' => $tagIdsNames[$post->tag_ids_str] ?? []
                        ])
                    </td>
                    <td>
                        @php($totalComments = $post->totalComments())
                        @if($totalComments > 0)
                        <a href="{{ route('admin.posts.comments.manage', ['post_id' => $post->getKey(), 'is_approved' => 1]) }}">
                            <span class="label label-light-success">{{ $totalComments }}</span>
                        </a>
                        @else
                        --
                        @endif
                        @php($totalPendingComments = $post->totalPendingComments())
                        @if($totalPendingComments > 0)
                        <a href="{{ route('admin.posts.comments.manage', ['post_id' => $post->getKey(), 'is_approved' => 0]) }}">
                            <span class="label label-light-info">{{ $totalPendingComments }}</span>
                        </a>
                        @else
                        --
                        @endif
                    </td>
                    <td>{{ $post->slug ?? '--' }}</td>
                    <td>@include('Admin::common.account_status', ['isActive' => $post->isActive()])</td>
                    <td>{{ $post->post_at ?? '--' }}</td>
                    <td>
                        @component('Admin::common.table.dropdown_actions', [
                        'optionActions' => [
                        'edit_' . $post->getKey() => __('Update'),
                        'update_status_' . $post->getKey() => $post->isActive() ? __('Disable') : __('Activate'),
                        'delete_' . $post->getKey() => __('Delete'),
                        'preview_' . $post->getKey() => __('Preview'),
                        'clone_' . $post->getKey() => __('Clone'),
                        ]
                        ])
                        @include('Admin::common.table.actions.update', ['href' => route('admin.post.update', ['id' => $post->getKey()]), 'btnId' => 'edit_' . $post->getKey()])
                        @include('Admin::common.table.actions.update_status', [
                        'route' => 'admin.post.update_status',
                        'id' => $post->getKey(),
                        'isActive' => $post->isActive(),
                        'btnId' => 'update_status_' . $post->getKey(),
                        ])
                        @include('Admin::common.table.actions.delete', ['to' => route('admin.post.delete'), 'id' => $post->getKey(), 'btnId' => 'delete_' . $post->getKey()])
                        <a id="preview_{{ $post->getKey() }}" href="{{ url($post->slug) }}?lang_code={{ $langCode }}" class="btn btn-secondary btn-xs" target="_blank"><i class="mdi mdi-eye"></i></a>
                        <a id="clone_{{ $post->getKey() }}" href="{{ route('admin.post.clone', ['id' => $post->getKey()]) }}" class="btn btn-secondary"> <i class="mdi mdi-content-copy"></i></a>
                        @endcomponent
                    </td>
                </tr>
                @empty
                @include('Admin::common.table.no_results', ['colspan' => 8])
                @endforelse
                @endslot
                @endcomponent
            </form>
            {{ $posts->links() }}
        </div>
    </div>
</div>
@endsection