<div class="tab-pane active" id="basic_info">
    {{-- hidden --}}
    {{ csrf_field() }}
    <input type="hidden" name="id" value="{{ $transaction->getKey() }}">
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
              <td>{{ $transaction->getKey() }}</td>
            </tr>
            @if ($transaction->type == 'Payment') 
              <tr>
                <td>@lang('Payment Type')</td>
                <td>{{json_decode($transaction->note)->paymentType}}</td>
              </tr>
              <tr>
                <td>@lang('Amount Currency')</td>
                <td>{{json_decode($transaction->note)->currencySymbol}} {{ $transaction->from_amount }}</td>
              </tr>

              <tr>
                  <td>@lang('To')</td>
                  <td>{{ $transaction->to_user->name }}</td>
              </tr>
              <tr>
                <td>@lang('Amount Tokens')</td>
                <td>{{ $transaction->to_amount }}</td>
              </tr>
            @endif
              
            <tr>
                <td>@lang('Status')</td>
                <td>{{ $transaction->status }}</td>
            </tr>
            <tr>
              <td>@lang('Created')</td>
              <td>{{ $transaction->created_at }}</td>
          </tr>
          </tbody>
      </table>
    </form>
  </div>
  