<div class="form-group @if ($errors->has($key)) has-danger @endif row">
    {{-- label content --}}
    <label class="col-3 control-label" for="{{ $key }}">{{ $label }}</label>
    {{-- end label content --}}

    <div class="col-9">

        {{-- input --}}
            {{ $input }}
        {{-- end input --}}

        @include('Index::common.form.error', ['key' => $key])
    </div>
</div>
