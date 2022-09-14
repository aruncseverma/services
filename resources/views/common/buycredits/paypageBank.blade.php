<div class="card">
  <div class="card-header">
      <div class="card-actions">
          <a class="btn-minimize" data-toggle="collapse" data-target="#bank-wire"><i class="mdi mdi-window-minimize"></i></a>
      </div>
      <span>Bank Wire</span>
  </div>
  <div class="card-header-sub">
      Instructions on how to proceed with your order via Bank Wire
  </div>
  <div class="card-body collapse show" id="bank-wire">
      <div class="row">
          <div class="col-sm-4 left-image-holder">
              <img src="{{ asset('assets/theme/admin/default/images/' . $biller->logo) }}" alt="payment-direct">
          </div>
          <div class="col-sm-8">
              <h2>Amount to be paid: <span class="text-danger">{{ json_decode($transaction->note)->currencySymbol }}{{$package->price}}</span></h2>
              <div>You may send the wire transfer to our bank</div>
              <div>Here are the informations you will be needing</div>
              <blockquote>
                  {!! $billnote !!}
              </blockquote>
              <h6>Please send us a copy of the receipt via email</h6>
          </div>
      </div>
      <button type="submit" class="btn btn-outline-success waves-effect waves-light" style="float:right; margin: 5px;" onclick="confirmPay({{$transaction->id}});">CONFIRM</button>
      <button type="submit" class="btn btn-outline-danger waves-effect waves-light" style="float:right; margin: 5px;" onclick="cancelPay({{$transaction->id}});">CANCEL</button>
  </div>
</div>