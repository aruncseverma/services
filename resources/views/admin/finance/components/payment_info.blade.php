<form id="markAsPaid" method="POST">
{{-- hidden --}}
<input type="hidden" id="transId" />
{{-- end hidden --}}
<div class="modal" tabindex="-1" role="dialog" id="counterPayment" aria-labelledby="counterPayment" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title">Payment Information</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        <h4>@lang('Purchased Membership Plan')</h4>
        <table class="table table-bordered">
          <tbody>
            <tr>
              <td class="bg-secondary" width="40%">
                <b style="color: white;">@lang('Order ID')</b>
              </td>
              <td>
                <b><span id="orderID"></span></b>
              </td>
            </tr>
            <tr>
              <td class="bg-secondary" width="40%">
                <b style="color: white;">@lang('Payment Method')</b>
              </td>
              <td>
                <span id="paymentMethod"></span>
              </td>
            </tr>
            <tr>
              <td class="bg-secondary" width="40%">
                <b style="color: white;">@lang('Total Price')</b>
              </td>
              <td>
                <span id="totalPrice" class="text-danger"></span>
              </td>
            </tr>
          </tbody>
        </table>
        <br />
        <h4>@lang('Member Payment Information')</h4>
        <span class="text-danger">@lang('Note: Escort\'s Payment should always have at least a screenshot of receipt or pdf of digital invoice for their payment method of choice.')</span>
        <br /><br />
        <table class="table table-bordered">
          <thead>
            <tr>
              <td>@lang('Field')</td>
              <td>@lang('Value')</td>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>@lang('Reference ID:')</td>
              <td><input type="text" id="reference_id" required="true" class="form-control" name="reference_id" placeholder="{{ __('Reference Id') }}"></td>
            </tr>
            <tr>
              <td>@lang('Attachment:')</td>
              <td><input type="file" id="attachment" required="true" class="form-control" name="attachment" accept=".pdf,.jpg,.jpeg,.png,.gif,.bmp"></td>
            </tr>
          </tbody>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
        <button type="submit" class="btn btn-primary es-confirm">Confirm Payment</button>
      </div>
    </div>
  </div>
</div>
</form>