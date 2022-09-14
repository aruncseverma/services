<select name="{{ $name }}" @isset($isMultiple) multiple="" @endisset class="form-control @isset($isMultiple) select2 @endisset" id="{{ $name }}">
    @foreach ($options as $option)
        <option value="{{ $option->getValue() }}" @if ($option->isSelected()) selected="" @endif>{{ $option->getText() }}</option>
    @endforeach
</select>