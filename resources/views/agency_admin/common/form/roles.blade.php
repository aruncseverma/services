<select name="{{ $name }}" @isset($isMultiple) multiple="" @endisset class="form-control" id="{{ $name }}">
    @isset($showNewOption)
        <option value="new" @isset($baseRedirectRoute) data-href="{{ route($baseRedirectRoute) }}" @endisset>@lang('New Role')</option>
    @endisset

    @isset($showNullOption)
        <option value="" disabled="" selected="">@lang('Select a Role')</option>
    @endisset

    @foreach ($options as $option)
        <option value="{{ $option->getValue() }}" @isset($baseRedirectRoute) data-href="{{ route($baseRedirectRoute, ['id' => $option->getValue()]) }}" @endisset @if ($option->isSelected()) selected="" @endif>{{ $option->getText() }}</option>
    @endforeach
</select>
