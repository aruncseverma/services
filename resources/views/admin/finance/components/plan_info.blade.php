<div class="tab-pane active" id="basic_info">
  {{-- hidden --}}
  {{ csrf_field() }}
  <input type="hidden" name="id" value="{{ $plan->getKey() }}">
  {{-- end hidden --}}
    
    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>@lang('Field')</th>
                <th>@lang('Value')</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>@lang('ID')</td>
                <td>{{ $plan->getKey() }}</td>
            </tr>
            <tr>
                <td>@lang('Currency') *</td>
                <td>
                  @include(
                    'Admin::common.form.currency',
                    [
                      'name' => 'currency',
                      'value' => isset($plan->currency_id) ? $plan->currency_id : 0
                    ]
                  )
                  </td>
            </tr>
            <tr>
                <td>@lang('Duration (in months)') *</td>
                <td><input type="text" id="months" class="form-control" name="months" placeholder="{{ __('Duration') }}" value="{{ $plan->months }}"></td>
            </tr>

            <tr>
                <td>@lang('Total Price') *</td>
                <td><input type="text" id="total_price" class="form-control" name="total_price" placeholder="{{ __('Total Price') }}" value="{{ $plan->total_price }}"></td>
            </tr>
            
            <tr>
                <td>@lang('Discount') *</td>
                <td><input type="text" id="discount" class="form-control" name="discount" placeholder="{{ __('Discount') }}" value="{{ $plan->discount }}"></td>
            </tr>

            <tr>
                <td>@lang('Price per Month') *</td>
                <td><input type="text" id="price_per_month" class="form-control" name="price_per_month" placeholder="{{ __('Price') }}" value="{{ $plan->price_per_month }}"></td>
            </tr>

            <tr>
                <td>@lang('Active Status')</td>
                <td>
                  <select class="form-control" name="is_active" id="is_active">
                    <option value="1" @if ($plan->is_active) selected @endif>Active</option>
                    <option value="0" @if (!$plan->is_active) selected @endif>Not Active</option>
                  </select>
                </td>
            </tr>
        </tbody>
    </table>
  </form>
</div>
