<label class="label @if ($isActive) label-success @else label-danger @endif">
    @if ($isActive)
        @lang('Active')
    @else
        @lang('Inactive')
    @endif
</label>
