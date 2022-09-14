{{-- error messages --}}
@if ($errors->has($key))
    @foreach ($errors->get($key) as $message)
        <small class="form-control-feedback text-danger">{{ $message }}</small>
    @endforeach
@endif
{{-- end error messages --}}
