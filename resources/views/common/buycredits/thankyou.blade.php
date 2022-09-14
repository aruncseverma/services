<div class="card">
  <div class="card-header" data-toggle="collapse" data-target="#thanksmsg">
      <div class="card-actions">
          <a class="btn-minimize"><i class="mdi mdi-window-minimize"></i></a>
      </div>
      <span>Thank You Message</span>
  </div>
  <div class="card-header-sub">
      Payment successful!
  </div>
  <div class="card-body collapse show" id="thanksmsg">
      <div class="row">
          <div class="col-sm-4 left-image-holder">
              <img src="{{ asset('assets/theme/admin/default/images/bg-thankyou.jpg') }}">
          </div>
          <div class="col-sm-8">
              <h2 class="text-danger">Thank you for your payment.</h2>
              <div>Lumia has received your payment</div>
              <div>Your payment details:</div>
              <blockquote>
                  <table class="table">
                      <thead>
                          <th>Order ID</th>
                          <th>Type</th>
                          <th>Date</th>
                          <th>Amount</th>
                      </thead>
                      <tr>
                          <td>{{ $transaction->id }}</td>
                          <td>{{ json_decode($transaction->note)->paymentType }}</td>
                          <td>{{ $transaction->updated_at }}</td>
                          <td>{{ json_decode($transaction->note)->currencySymbol }}{{ $transaction->from_amount }}</td>
                      </tr>
                  </table>
              </blockquote>
              <h6>Please send us a copy of the receipt via email</h6>
          </div>
      </div>
  </div>
</div>