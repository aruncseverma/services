<div class="form-group @if ($errors->has($key)) has-danger @endif">
    {{-- label content --}}
    @isset ($label)     <label class="col-3 control-label {{ $labelClasses ?? '' }}" for="{{ $labelId ?? $key }}" {{ $labelAttrs ?? '' }}>{{ $label }}</label> @endisset
    {{-- end label content --}}

    <div class="">

        {{-- input --}}
            {{ $input }}
        {{-- end input --}}

        @include('Admin::common.form.error', ['key' => $key])
    </div>
</div>
