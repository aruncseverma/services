<select class="{{ $classes ?? 'select2 form-control' }}" name="{{ $name }}@isset($isMultiple)[]@endisset" @isset($isMultiple) multiple="" @endisset id="{{ $id ?? $name }}" data-toggle="states_update" @isset($target) data-target="{{ $target }}" @endisset data-value="{{ $value }}" {{ $attributes ?? '' }}>
    @foreach ($options as $option)
        <option value="{{ $option->getValue() }}" @if ($option->isSelected()) selected="" @endif>{{ $option->getText() }}</option>
    @endforeach
</select>

@pushAssets('scripts.post')
    {{-- countries to states select form --}}
    <script type="text/javascript">
        $(function () {
            $('[data-toggle="states_update"]').on('change', function () {

                var target = $(this).data('target');
                var $target = (target !== undefined) ? $(target) :  $('#' + $(this).attr('id')).closest('div.row').find('select[name^="state"]');
                var val = $target.data('value');

                // only proceed when target is acquired
                if ($target.length > 0 && this.value !== '*' && this.value !== undefined) {
                    $.ajax({
                        url: '{{ route("common.locations.states") }}',
                        cache: false,
                        dataType: 'json',
                        data: {
                            countryId: this.value
                        },
                        success: function (data) {
                            var $allOption = $target.find('option[value="*"]');
                            // clear target html
                            $target.html('');
                            $target.append($allOption);

                            // loop data if any
                            $.each(data, function (k, state) {
                                var $option = $('<option></option>');
                                $option.attr('value', state.id);
                                $option.html(state.name);

                                if (val == state.id) {
                                    $option.attr('selected', true);
                                }

                                // append option to target
                                $target.append($option);
                                if ($target.hasClass('selectpicker')) {
                                    $target.selectpicker('refresh');
                                } else if ($target.parent().hasClass('selectric-hide-select')) {
                                    $target.selectric('refresh');
                                }
                            });

                            $target.trigger('change');
                        },
                        error: function (xhr) {
                            swal({
                                title: '@lang("Error!")',
                                text: '@lang("Unable to process request. Please try again later")',
                                type: "warning",
                            });
                        },
                    });
                }
            });

            $('[data-toggle="states_update"]').trigger('change');
        });
    </script>
    {{-- end --}}
@endPushAssets
