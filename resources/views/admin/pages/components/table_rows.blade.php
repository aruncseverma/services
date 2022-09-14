@php
$prefixTitle = $prefixTitle ?? '';
@endphp

@forelse ($pages as $page)
@php
$pageDesc = $page->getDescription($langCode);
$hasAttr = $pageDesc->getAttributes();
@endphp
<tr @if(!$hasAttr) class="table-danger" @endif>
    <td style="width:40px">
        <div class="checkbox">
            <input type="checkbox" name="ids[]" class="page-ids" id="checkbox{{ $page->getKey() }}" value="{{ $page->getKey() }}">
            <label for="checkbox{{ $page->getKey() }}"></label>
        </div>
    </td>
    <td>{{ $prefixTitle }}@if(!$hasAttr) @lang('[No description]') @else {{ $pageDesc->title }} @endif</td>
    <td>@if($page->parent) <a href="{{ route('admin.pages.manage', ['parent_id'=>$page->parent_id]) }}">{{ $page->parent->getDescription($langCode)->title }}</a>@else -- @endif</td>
    <td>{{ $page->author->name }}</td>
    <td>
        @php
        $totalComments = $page->totalComments()
        @endphp
        @if($totalComments > 0)
        <a href="{{ route('admin.posts.comments.manage', ['post_id' => $page->getKey(), 'is_approved' => 1]) }}">
            <span class="label label-light-success">{{ $totalComments }}</span>
        </a>
        @else
        --
        @endif

        @php
        $totalPendingComments = $page->totalPendingComments()
        @endphp
        @if($totalPendingComments > 0)
        <a href="{{ route('admin.posts.comments.manage', ['post_id' => $page->getKey(), 'is_approved' => 0]) }}">
            <span class="label label-light-info">{{ $totalPendingComments }}</span>
        </a>
        @else
        --
        @endif
    </td>
    <td>{{ $page->slug ?? '--' }}</td>
    <td>@include('Admin::common.account_status', ['isActive' => $page->isActive()])</td>
    <td>{{ $page->post_at ?? '--' }}</td>
    <td>
        @component('Admin::common.table.dropdown_actions', [
        'optionActions' => [
        'edit_' . $page->getKey() => __('Update'),
        'update_status_' . $page->getKey() => $page->isActive() ? __('Disable') : __('Activate'),
        'delete_' . $page->getKey() => __('Delete'),
        'preview_' . $page->getKey() => __('Preview'),
        'clone_' . $page->getKey() => __('Clone'),
        ]
        ])
        @include('Admin::common.table.actions.update', ['href' => route('admin.page.update', ['id' => $page->getKey()]), 'btnId' => 'edit_' . $page->getKey()])
        @include('Admin::common.table.actions.update_status', [
        'route' => 'admin.page.update_status',
        'id' => $page->getKey(),
        'isActive' => $page->isActive(),
        'btnId' => 'update_status_' . $page->getKey(),
        ])
        @include('Admin::common.table.actions.delete', ['to' => route('admin.page.delete'), 'id' => $page->getKey(), 'btnId' => 'delete_' . $page->getKey()])
        <a id="preview_{{ $page->getKey() }}" href="{{ $page->getPostUrl() }}?lang_code={{ $langCode }}" class="btn btn-secondary btn-xs" target="_blank"><i class="mdi mdi-eye"></i></a>
        <a id="clone_{{ $page->getKey() }}" href="{{ route('admin.page.clone', ['id' => $page->getKey()]) }}" class="btn btn-secondary"> <i class="mdi mdi-content-copy"></i></a>
        @endcomponent
    </td>
</tr>

@if($isParentToChild)
@php
$subSearch = $search;
$subSearch['parent_id'] = $page->getKey();
$subPages = $postRepo->search(0, $subSearch, false);
$subPrefixTitle = $prefixTitle . '— ';
@endphp
@if($subPages)
@include('Admin::pages.components.table_rows', ['pages' => $subPages, 'prefixTitle' => $subPrefixTitle])
@endif
@endif

@empty

@if(!$isParentToChild)
@include('Admin::common.table.no_results', ['colspan' => 9])
@endif

@endforelse