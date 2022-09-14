@extends('Admin::layout')

{{-- title --}}
@section('main.content.title')
@php($editRoute = $post->isPostType() ? 'admin.post.update' : 'admin.page.update')
<a href="{{ route($editRoute, ['id' => $post->getKey()]) }}">
    {{ $title }}
</a>
@endsection
{{-- end title --}}

@section('main.content.title.right')
<div class="col-md-6 col-8 align-self-center text-right">
    @if($comments->count())
    <button type="button" class="btn btn-danger es es-submit es-confirm es-need-selected-items" data-need-selected-items-selector=".ids" data-form-id="manage_form" data-form-action="{{ route('admin.posts.comments.m_delete') }}">@lang('Delete')</button>
    @endif
</div>
@endsection

@section('main.content')
<div class="col-lg-12">
    <div class="row">
        <!-- Column -->
        <div class="col-md-6 col-lg-3 col-xlg-3">
            <div class="card card-inverse card-info">
                <a href="{{ route('admin.posts.comments.manage', ['post_id' => $post->getKey()]) }}">
                    <div class="box bg-info text-center">
                        <h1 class="font-light text-white">{{ $post->totalComments() }}</h1>
                        <h6 class="text-white">@lang('Total')</h6>
                    </div>
                </a>
            </div>
        </div>
        <!-- Column -->
        <div class="col-md-6 col-lg-3 col-xlg-3">
            <div class="card card-primary card-inverse">
                <a href="{{ route('admin.posts.comments.manage', ['post_id' => $post->getKey(), 'is_approved' => 0]) }}">
                    <div class="box text-center">
                        <h1 class="font-light text-white">{{ $post->totalPendingComments() }}</h1>
                        <h6 class="text-white">@lang('Approval Pending')</h6>
                    </div>
                </a>
            </div>
        </div>
        <!-- Column -->
        <div class="col-md-6 col-lg-3 col-xlg-3">
            <div class="card card-inverse card-success">
                <a href="{{ route('admin.posts.comments.manage', ['post_id' => $post->getKey(), 'is_approved' => 1]) }}">
                    <div class="box text-center">
                        <h1 class="font-light text-white">{{ $post->totalApprovedComments() }}</h1>
                        <h6 class="text-white">@lang('Approved')</h6>
                    </div>
                </a>
            </div>
        </div>
        <!-- Column -->
        <div class="col-md-6 col-lg-3 col-xlg-3">
            <div class="card card-inverse card-warning">
                <a href="{{ route('admin.posts.comments.manage', ['post_id' => $post->getKey(), 'get_mine' => 1]) }}">
                    <div class="box text-center">
                        <h1 class="font-light text-white">{{ $post->totalAuthorComments() }}</h1>
                        <h6 class="text-white">@lang('Mine')</h6>
                    </div>
                </a>
            </div>
        </div>
    </div>
    <div class="card">
        <div class="card-body">
            {{-- search --}}
            @component('Admin::common.search', ['action' => route('admin.posts.comments.manage', ['post_id'=> $post->getKey()])])
            <input type="hidden" name="limit" value="{{ $search['limit'] }}">
            <input type="hidden" name="post_id" value="{{ $post->getKey() }}">

            <div class="row p-t-20">
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label" for="content">@lang('Content')</label>
                        <input type="text" id="content" class="form-control" name="content" value="{{ $search['content'] }}">
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-group">
                        <label class="control-label" for="is_approved">@lang('Status')</label>
                        <div class="m-b-10">
                            <label class="custom-control custom-radio">
                                <input id="approved" name="is_approved" type="radio" class="custom-control-input" @if ($search['is_approved']=='1' ) checked="" @endif value="1">
                                <span class="custom-control-label">@lang('Approved')</span>
                            </label>
                            <label class="custom-control custom-radio">
                                <input id="pending" name="is_approved" type="radio" class="custom-control-input" @if ($search['is_approved']=='0' ) checked="" @endif value="0">
                                <span class="custom-control-label">@lang('Pending')</span>
                            </label>
                            <label class="custom-control custom-radio">
                                <input id="all" name="is_approved" type="radio" class="custom-control-input" @if ($search['is_approved']=='*' ) checked="" @endif value="*">
                                <span class="custom-control-label">@lang('All')</span>
                            </label>
                        </div>
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
                <th>@lang('Author')</th>
                <th>@lang('Comment')</th>
                <th style="width:12%;">@lang('Date')</th>
                <th>@lang('Status')</th>
                <th style="width:15%;">@lang('Actions')</th>
                @endslot

                @slot('body')
                @forelse ($comments as $comment)
                <tr>
                    <td style="width:40px">
                        <div class="checkbox">
                            <input type="checkbox" name="ids[]" class="ids" id="checkbox{{ $comment->getKey() }}" value="{{ $comment->getKey() }}">
                            <label for="checkbox{{ $comment->getKey() }}"></label>
                        </div>
                    </td>
                    <td>{{ $comment->name }}</td>
                    <td>{{ $comment->content }}</td>
                    <td>{{ $comment->created_at }}</td>
                    <td>
                        @if ($comment->isApproved())
                        <label class="label label-success">@lang('Approved')</label>
                        @else
                        <label class="label label-warning">@lang('Pending Approval')</label>
                        @endif
                    </td>
                    <td>
                        @component('Admin::common.table.dropdown_actions', [
                        'optionActions' => [
                        'update_approve_' . $comment->getKey() => $comment->isApproved() ? __('Unapprove') : __('Approve'),
                        'delete_' . $comment->getKey() => __('Delete'),
                        ]
                        ])
                        <a id="update_approve_{{ $comment->getKey() }}" href="{{ route('admin.posts.comments.update_status', ['id' => $comment->getKey()]) }}" class="btn @if ($comment->isApproved()) btn-danger @else btn-success @endif btn-xs" title="@if ($comment->isApproved()) @lang('Unapprove') @else @lang('Approve') @endif">
                            @if ($comment->isApproved())
                            <i class="fa fa-times"></i>
                            @else
                            <i class="fa fa-check"></i>
                            @endif
                        </a>
                        @include('Admin::common.table.actions.delete', ['to' => route('admin.posts.comments.delete'), 'id' => $comment->getKey(), 'btnId' => 'delete_' . $comment->getKey()])
                        @endcomponent

                    </td>
                </tr>
                @empty
                @include('Admin::common.table.no_results', ['colspan' => 5])
                @endforelse
                @endslot
                @endcomponent
            </form>

            {{ $comments->links() }}
        </div>
    </div>
</div>
@endsection