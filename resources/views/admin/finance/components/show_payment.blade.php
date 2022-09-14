<div class="modal" tabindex="-1" role="dialog" id="showPayment" aria-labelledby="showPayment" aria-hidden="true">
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
                <b><span id="showOrderID"></span></b>
              </td>
            </tr>
            <tr>
              <td class="bg-secondary" width="40%">
                <b style="color: white;">@lang('Payment Method')</b>
              </td>
              <td>
                <span id="showPaymentMethod"></span>
              </td>
            </tr>
            <tr>
              <td class="bg-secondary" width="40%">
                <b style="color: white;">@lang('Total Price')</b>
              </td>
              <td>
                <span id="showTotalPrice" class="text-danger"></span>
              </td>
            </tr>
          </tbody>
        </table>
        <br />
        <h4>@lang('Member Payment Information')</h4>
        <br />
        <table class="table table-bordered">
          <tbody>
            <tr>
              <td>@lang('Reference ID:')</td>
              <td><span id="showReferenceId"></span></td>
            </tr>
            <tr>
              <td>@lang('Attachment:')</td>
              <td><img id="showAttachment" width="100%"/></td>
            </tr>
          </tbody>
        </table>
        <br />
        <h4>@lang('Approver Details')</h4>
        <br />
        <table class="table table-bordered">
          <tr>
            <th class="bg-success text-white">@lang('Approved by')</th>
            <td><span id="showApprover"></span></td>
          </tr>
          <tr>
            <th class="bg-success text-white">@lang('Date Approved')</th>
            <td><span id="showApprovedDate"></span></td>
          </tr>
        </table>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
      </div>
    </div>
  </div>
</div>