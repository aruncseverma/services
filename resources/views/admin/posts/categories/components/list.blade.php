@php
$currentIds = !empty($current_id) ? explode(',', $current_id) : [];
$hideOption = $hide_option ?? false;
@endphp

@foreach($categories as $category)
@php($subTotal = $category->categories->count())
@php($name = $category->getDescription($langCode, true)->name ?? 'no text')
@php($isHide = ($hideOption || $category->getKey() == $except_id))
<li class="list-group-item d-flex justify-content-between align-items-center">
    @if(!$isHide)
    @if ($is_multiple)
    <input type="checkbox" class="category_ids" value="{{ $category->getKey() }}" data-text="{{ $name }}" @if(in_array($category->getKey(), $currentIds)) checked @endif>
    @else
    <input type="radio" class="category_ids" value="{{ $category->getKey() }}" data-text="{{ $name }}" @if(in_array($category->getKey(), $currentIds)) checked @endif>
    @endif
    @endif
    <div style="width: 100%;padding-left: 10px;">
        @if($subTotal)
        <a href="#" class="get-sub" style="cursor: pointer;" data-cat_id="{{ $category->getKey() }}" data-hide_option="{{ $isHide }}">
            {{ $name }}
            <span class="badge badge-primary badge-pill pull-right">{{ $subTotal }}</span>
        </a>
        @else
        {{ $name }}
        @endif
    </div>
</li>

@if($subTotal)
<div id="cat_id_{{ $category->getKey() }}" class="sub-category"></div>
@endif
@endforeach