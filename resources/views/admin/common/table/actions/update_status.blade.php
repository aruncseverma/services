@php
$isActive = $isActive ?? false;
$route = $route ?? '';
$id = $id ?? 0;
$btnId = $btnId ?? 'update_status_' . $id;
@endphp
@if (!empty($route) && !empty($id))
<a id="{{ $btnId }}" href="{{ route($route, ['id' => $id]) }}" class="btn @if ($isActive) btn-danger @else btn-success @endif btn-xs" title="@if ($isActive) @lang('Disable') @else @lang('Activate') @endif">
    @if ($isActive)
    <i class="fa fa-circle"></i>
    @else
    <i class="fa fa-circle-o"></i>
    @endif
</a>
@endif