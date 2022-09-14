@php($hasGrid = $has_grid ?? true)
<div class="form-group @if ($errors->has($key)) has-danger @endif @if($hasGrid) row @endif">
    {{-- label content --}}
    <label class="@if($hasGrid) col-3 @endif control-label {{ $labelClasses ?? '' }} {!! (isset($lbl_classess)) ? $lbl_classes ?? '' : '' !!}" for="@if(!empty($lbl_for)){{$lbl_for}}@else{{ $labelId ?? $key }}@endif" {{ (isset($labelAttrs)) ? $labelAttrs ?? '' : '' }}>{{ $label }}</label>
    {{-- end label content --}}

    <div class="@if($hasGrid) col-9 @endif">

        {{-- input --}}
            {{ $input }}
        {{-- end input --}}

        @include('Admin::common.form.error', ['key' => $key])
    </div>
</div>
