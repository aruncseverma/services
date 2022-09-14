<div class="card">
  <div class="card-header">
      <div class="card-actions">
          <a class="btn-minimize" data-toggle="collapse" data-target="#bank-wire"><i class="mdi mdi-window-minimize"></i></a>
      </div>
      <span>Dummy</span>
  </div>
  <div class="card-header-sub">
      This is just a dummy biller
  </div>
  <div class="card-body collapse show" id="bank-wire">
      <div class="row">
          <div class="col-sm-4 left-image-holder">
              <img src="{{ asset('assets/theme/admin/default/images/' . $biller->logo) }}" alt="payment-direct" width="144px" height="98px">
          </div>
          <div class="col-sm-8">
              <h2>This dummy biller will add <span class="text-danger">{{$package->credits}}</span> credits to your account</h2>
              <div>Just press confirm to add</div>
          </div>
      </div>
      <button type="submit" class="btn btn-outline-success waves-effect waves-light" style="float:right; margin: 5px;" onclick="confirmPay({{$transaction->id}});">CONFIRM</button>
      <button type="submit" class="btn btn-outline-danger waves-effect waves-light" style="float:right; margin: 5px;" onclick="cancelPay({{$transaction->id}});">CANCEL</button>
  </div>
</div>