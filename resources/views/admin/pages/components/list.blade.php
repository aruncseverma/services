@php
$currentId = $current_id ?? 0;
$hideOption = $hide_option ?? false;
@endphp

@foreach($pages as $page)
@php($subTotal = $page->pages->count())
@php($name = $page->getDescription($langCode, true)->title ?? 'no text')
@php($isHide = ($hideOption || $page->getKey() == $except_id))
<li class="list-group-item d-flex justify-content-between align-items-center">
    @if(!$isHide)
    <input type="radio" class="page_ids" name="page_id" value="{{ $page->getKey() }}" data-text="{{ $name }}" @if($page->getKey() == $currentId) checked @endif>
    @endif
    <div style="width: 100%;padding-left: 10px;">
        @if($subTotal)
        <a href="#" class="get-sub" style="cursor: pointer;" data-page_id="{{ $page->getKey() }}" data-hide_option="{{ $isHide }}">
            {{ $name }}
            <span class="badge badge-primary badge-pill pull-right">{{ $subTotal }}</span>
        </a>
        @else
        {{ $name }}
        @endif
    </div>
</li>

@if($subTotal)
<div id="page_id_{{ $page->getKey() }}" class="sub-page"></div>
@endif
@endforeach