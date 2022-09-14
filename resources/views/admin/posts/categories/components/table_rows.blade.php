@php
$prefixTitle = $prefixTitle ?? '';
@endphp

@forelse ($categories as $category)
<tr>
    <td style="width:40px">
        <div class="checkbox">
            <input type="checkbox" name="ids[]" class="ids" id="checkbox{{ $category->getKey() }}" value="{{ $category->getKey() }}">
            <label for="checkbox{{ $category->getKey() }}"></label>
        </div>
    </td>
    <td>{{ $prefixTitle }}{{ $category->getDescription($langCode)->name }}</td>
    <td>@if($category->parent) <a href="{{ route('admin.posts.categories.manage', ['parent_id'=>$category->parent_id]) }}">{{ $category->parent->getDescription($langCode)->name }}</a>@else -- @endif</td>
    <td>{{ $category->slug ?? '--' }}</td>
    <td><a href="{{ route('admin.posts.manage', ['category_id'=> $category->getKey()]) }}">{{ $category->getTotalPosts() }}</a></td>
    <td>@include('Admin::common.account_status', ['isActive' => $category->isActive()])</td>
    <td>
        @component('Admin::common.table.dropdown_actions', [
            'optionActions' => [
                'edit_' . $category->getKey() => __('Update'),
                'update_status_' . $category->getKey() => $category->isActive() ? __('Disable') : __('Activate'),
                'delete_' . $category->getKey() => __('Delete'),
                'preview_' . $category->getKey() => __('Preview'),
            ]
        ])
            @include('Admin::common.table.actions.update', ['href' => route('admin.posts.categories.update', ['id' => $category->getKey()]), 'btnId' => 'edit_' . $category->getKey()])
            @include('Admin::common.table.actions.update_status', [
                'route' => 'admin.posts.categories.update_status',
                'id' => $category->getKey(),
                'isActive' => $category->isActive(),
                'btnId' => 'update_status_' . $category->getKey(),
            ])
            @include('Admin::common.table.actions.delete', ['to' => route('admin.posts.categories.delete'), 'id' => $category->getKey(), 'btnId' => 'delete_' . $category->getKey()])
            <a id="preview_{{ $category->getKey() }}" href="{{ route('admin.posts.categories.preview',['id'=>$category->getKey(), 'lang_code' => $langCode]) }}" class="btn btn-secondary btn-xs" target="_blank"><i class="mdi mdi-eye"></i></a>
        @endcomponent
    </td>
</tr>

@if($isParentToChild)
@php
$subSearch = $search;
$subSearch['parent_id'] = $category->getKey();
$subCategories = $catRepo->search(0, $subSearch, false);
$subPrefixTitle = $prefixTitle . '— ';
@endphp
@if($subCategories)
@include('Admin::posts.categories.components.table_rows', ['categories' => $subCategories, 'prefixTitle' => $subPrefixTitle])
@endif
@endif

@empty

@if(!$isParentToChild)
@include('Admin::common.table.no_results', ['colspan' => 6])
@endif

@endforelse