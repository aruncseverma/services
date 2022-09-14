<div class="col-md-6">
    <div class="card">
        <div class="card-header" data-toggle="collapse" data-target="#rates">
            <div class="card-actions">
                <a class="btn-minimize"><i class="mdi mdi-window-minimize"></i></a>
            </div>
            <span>@lang('My Rates')</span>
            <div class="pull-right currency-drop">
                <select class="selectpicker" data-style="btn-info" id="currency_selector">
                    @foreach ($currencies as $currency)
                        <option value="{{ $currency->getKey() }}" @if ($currentCurrency->getKey() === $currency->getKey()) selected="" @endif>{{ $currency->name }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="card-header-sub">
            @lang('Manage your rates/fees')
        </div>
        <div class="card-body collapse show" id="rates">
            @if (old('notify') === 'rates')
                @include('EscortAdmin::common.notifications')
            @endif

            <form method="POST" action="{{ route('escort_admin.rates_services.update_rates') }}" class="es es-validation">

                <input type="hidden" name="currency_id" value="{{ $currentCurrency->getKey() }}">
                {{ csrf_field() }}

                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>@lang('Duration')</th>
                                <th>@lang('Incall')</th>
                                <th>@lang('Outcall')</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($durations as $duration)
                                <tr>
                                    <td>{{ $duration->getDescription(app()->getLocale())->content }}</td>
                                    <td>
                                        <label for="rate_incall_{{ $duration->getKey() }}" class="es-numeric" style="display:none">{{ __('Incall') }}</label>
                                        <input type="text" class="form-control text-right" id="rate_incall_{{ $duration->getKey() }}" name="rates[{{ $duration->getKey() }}][incall]" placeholder="999.99" value="{{ $escort->getRate($duration->getKey(), $currentCurrency)->incall ?? old("rates.{$duration->getKey()}.incall") }}">
                                        @include('EscortAdmin::common.form.error', ['key' => "rates.{$duration->getKey()}.incall"])
                                    </td>
                                    <td>
                                        <label for="rate_outcall_{{ $duration->getKey() }}" class="es-numeric" style="display:none">{{ __('Outcall') }}</label>
                                        <input type="text" class="form-control text-right" id="rate_outcall_{{ $duration->getKey() }}" name="rates[{{ $duration->getKey() }}][outcall]" placeholder="999.99" value="{{ $escort->getRate($duration->getKey(), $currentCurrency)->outcall ?? old("rates.{$duration->getKey()}.outcall") }}">
                                        @include('EscortAdmin::common.form.error', ['key' => "rates.{$duration->getKey()}.outcall"])
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <button type="submit" class="btn btn-outline-danger waves-effect waves-light button-save text-uppercase">@lang('Save')</button>
            </form>
        </div>
    </div>
</div>

@pushAssets('scripts.post')
    <script type="text/javascript">
        $(function() {
            $('#currency_selector').on('change', function () {
                $('input[name="currency_id"]').val(this.value);
                fnAjax({
                    url: '{{ route("escort_admin.rates_services.get_rates") }}',
                    data: {
                        currency_id: this.value
                    },
                    success: function(data) {
                        if (data.status == 1) {
                            if (Object.keys(data.data).length) {
                                for(var i in data.data) {
                                    var incall = $('#rate_incall_'+data.data[i].rate_duration_id);
                                    if (incall.length) {
                                        incall.val(data.data[i].incall);
                                    }
                                    var outcall = $('#rate_outcall_'+data.data[i].rate_duration_id);
                                    if (outcall.length) {
                                        outcall.val(data.data[i].outcall);
                                    }
                                }
                            }
                        }
                    }
                });
            });
        });
    </script>
@endPushAssets
