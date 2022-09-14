@php
$btnId = $btnId ?? '';
@endphp
<a id="{{ $btnId }}" href="{{ $href }}" class="btn btn-info btn-xs" title="{{ __('Update Information') }}">
    <i class="mdi mdi-pencil"></i>
</a>
