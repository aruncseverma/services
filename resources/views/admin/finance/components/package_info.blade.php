<div class="tab-pane active" id="basic_info">
  {{-- hidden --}}
  {{ csrf_field() }}
  <input type="hidden" name="id" value="{{ $package->getKey() }}">
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
                <td>{{ $package->getKey() }}</td>
            </tr>
            <tr>
                <td>@lang('Biller') *</td>
                <td>
                @include(
                  'Admin::common.form.biller',
                  [
                    'name' => 'biller',
                    'value' => isset($package->biller->id) ? $package->biller->id : 0
                  ]
                )
                </td>
            </tr>
            <tr>
                <td>@lang('Currency') *</td>
                <td>
                  @include(
                    'Admin::common.form.currency',
                    [
                      'name' => 'currency',
                      'value' => isset($package->currency->id) ? $package->currency->id : 0
                    ]
                  )
                  </td>
            </tr>

            <tr>
                <td>@lang('Credits') *</td>
                <td><input type="text" id="credits" class="form-control" name="credits" placeholder="{{ __('Credits') }}" value="{{ $package->credits }}"></td>
            </tr>

            <tr>
                <td>@lang('Discount') *</td>
                <td><input type="text" id="discount" class="form-control" name="discount" placeholder="{{ __('Discount') }}" value="{{ $package->discount }}"></td>
            </tr>

            <tr>
                <td>@lang('Price') *</td>
                <td><input type="text" id="price" class="form-control" name="price" placeholder="{{ __('Price') }}" value="{{ $package->price }}"></td>
            </tr>
            
    
            <tr>
                <td>@lang('Active Status')</td>
                <td>
                  <select class="form-control" name="is_active" id="is_active">
                    <option value="1" @if ($package->is_active) selected @endif>Active</option>
                    <option value="0" @if (!$package->is_active) selected @endif>Not Active</option>
                  </select>
                </td>
            </tr>
        </tbody>
    </table>
  </form>
</div>
