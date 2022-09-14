{{-- error messages --}}
@if ($errors->has($key))
    @foreach ($errors->get($key) as $message)
        <small class="text-danger" style="display: block;width: 100%;text-align: center;pointer-events: none;">{{ $message }}</small>
    @endforeach
@endif
{{-- end error messages --}}
