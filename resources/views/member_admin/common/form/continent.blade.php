<select name="{{ $name }}@isset($isMultiple)[]@endisset" @isset($isMultiple) multiple="" @endisset class="{{ $classes ?? 'select2 form-control' }}" id="{{ $id ?? $name }}" data-toggle="countries_update" @isset($target) data-target="{{ $target }}" @endisset data-value="{{ $value }}" {{ $attributes ?? '' }}>
    @foreach ($options as $option)
        <option value="{{ $option->getValue() }}" @if ($option->isSelected()) selected="" @endif>{{ $option->getText() }}</option>
    @endforeach
</select>

@pushAssets('scripts.post')
    {{-- continents to countries select form --}}
    <script type="text/javascript">
        $(function () {
            $('[data-toggle="countries_update"]').on('change', function () {

                var target = $(this).data('target');
                var $target = (target !== undefined) ? $(target) :  $('#' + $(this).attr('id')).closest('div.row').find('select[name^="country"]');
                var val = $target.data('value');

                // only proceed when target is acquired
                if ($target.length > 0 && this.value !== '*' && this.value !== undefined) {
                    $.ajax({
                        url: "{{ route("common.locations.countries") }}",
                        cache: false,
                        dataType: 'json',
                        data: {
                            continentId: this.value
                        },
                        beforeSend: function () {
                            fnShowLoader();
                        },
                        success: function (data) {
                            fnHideLoader();
                            var $allOption = $target.find('option[value="*"]');
                            // clear target html
                            $target.html('');
                            $target.append($allOption);

                            // loop data if any
                            $.each(data, function (k, country) {
                                var $option = $('<option></option>');
                                $option.attr('value', country.id);
                                $option.html(country.name);

                                if (val == country.id) {
                                    $option.attr('selected', true);
                                }

                                // append option to target
                                $target.append($option);
                            });

                            // trigger target change
                            $target.trigger('change');
                            if ($target.hasClass('selectpicker')) {
                                $target.selectpicker('refresh');
                            }

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

            $('[data-toggle="countries_update"]').trigger('change');
        });
    </script>
    {{-- end --}}
@endPushAssets
