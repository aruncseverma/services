<select class="{{ $classes ?? 'form-control' }}" name="{{ $name }}" @isset($isMultiple) multiple="" @endisset id="{{ $name }}" data-toggle="cities_update" @isset($target) data-target="{{ $target }}" @endisset data-value="{{ $value }}" {{ $attributes ?? '' }}>
    @foreach ($options as $option)
        <option value="{{ $option->getValue() }}" @if ($option->isSelected()) selected="" @endif>{{ $option->getText() }}</option>
    @endforeach
</select>

@pushAssets('scripts.post')
    {{-- states to cities select form --}}
    <script type="text/javascript">
        $(function () {
            $('[data-toggle="cities_update"]').on('change', function () {

                var target = $(this).data('target');
                var $target = (target !== undefined) ? $(target) :  $('#' + $(this).attr('id')).closest('div.row').find('select[name^="city"]');
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
                        url: "{{ route("api.locations.cities") }}",
                        cache: false,
                        dataType: 'json',
                        data: {
                            stateId: values.join(',')
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
                            $.each(data, function (k, city) {
                                var $option = $('<option></option>');
                                $option.attr('value', city.id);
                                $option.html(city.name);

                                if (targetValues.includes(city.id.toString())) {
                                    $option.attr('selected', true);
                                }

                                // append option to target
                                $target.append($option);
                            });
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

            $('[data-toggle="cities_update"]').trigger('change');
        });
    </script>
    {{-- end --}}
@endPushAssets
