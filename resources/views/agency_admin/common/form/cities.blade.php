<select name="{{ $name }}" @isset($isMultiple) multiple="" @endisset class="select2 form-control" id="{{ $id ?? $name }}" data-value="{{ $value }}">
    @foreach ($options as $option)
        <option value="{{ $option->getValue() }}" @if ($option->isSelected()) selected="" @endif>{{ $option->getText() }}</option>
    @endforeach
</select>
