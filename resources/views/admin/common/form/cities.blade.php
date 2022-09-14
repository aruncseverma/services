<select class="{{ $classes ?? 'form-control' }}" name="{{ $name }}" @isset($isMultiple) multiple="" @endisset id="{{ $name }}">
    @foreach ($options as $option)
        <option value="{{ $option->getValue() }}" @if ($option->isSelected()) selected="" @endif>{{ $option->getText() }}</option>
    @endforeach
</select>
