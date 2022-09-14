<select class="{{ $classes ?? 'form-control' }}" name="{{ $name }}@isset($isMultiple)[]@endisset" @isset($isMultiple) multiple="" @endisset id="{{ $id ?? $name }}" data-toggle="countries_update" @isset($target) data-target="{{ $target }}" @endisset data-value="{{ $value }}" {{ $attributes ?? '' }}>
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
                var values = $(this).children('option:selected').map(function (k, el) {
                    if (el.value != '*') {
                        return el.value;
                    }
                }).get();
                var targetValues = $target.children('option:selected').map(function (k, el) {
                    if (el.value != '*') {
                        return el.value;
                    }
                }).get();

                if (targetValues.length == 0) {
                    var attrValues = $target.attr('data-value');

                    if (attrValues != undefined) {
                        targetValues = $target.attr('data-value').split(',');
                    }
                }

                 // get values from select2
                if ($(this).attr('multiple')) {
                    values = $(this).select2('val');
                }

                if ($target.attr('multiple')) {
                    targetValues = $target.select2('val');
                }

                // only proceed when target is acquired
                if ($target.length > 0 && this.value !== '*' && values.length > 0) {
                    $.ajax({
                        url: "{{ route("api.locations.countries") }}",
                        cache: false,
                        dataType: 'json',
                        data: {
                            continentId: values.join(',')
                        },
                        beforeSend: function() {
                            fnShowLoader();
                        },
                        success: function (data) {
                            fnHideLoader();
                            var $allOption = $target.find('option[value="*"]');
                            var $placeHolder = $target.find('option[value=""]');
                            // clear target html
                            $target.html('');
                            $target.append($allOption);
                            $target.append($placeHolder);

                            // loop data if any
                            $.each(data, function (k, country) {
                                var $option = $('<option></option>');
                                $option.attr('value', country.id);
                                $option.html(country.name);

                                if (targetValues.includes(country.id.toString())) {
                                    $option.attr('selected', true);
                                }

                                // append option to target
                                $target.append($option);
                            });

                            // trigger target change
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
