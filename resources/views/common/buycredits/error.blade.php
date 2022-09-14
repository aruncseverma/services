<div class="card">
  <div class="card-header" data-toggle="collapse" data-target="#sorrymsg">
      <div class="card-actions">
          <a class="btn-minimize"><i class="mdi mdi-window-minimize"></i></a>
      </div>
      <span>Thank You Message</span>
  </div>
  <div class="card-header-sub">
      Payment successful!
  </div>
  <div class="card-body collapse show" id="sorrymsg">
      <div class="row">
          <div class="col-sm-4 left-image-holder">
              <img src="{{ asset('assets/theme/admin/default/images/bg-sorry.jpg') }}">
          </div>
          <div class="col-sm-8">
              <h2 class="text-danger">We are very sorry</h2>
              <blockquote>
                  <div><strong>Uh-oh! We were unable to process your payment.</strong></div>
                  <div>You may contact us for any concerns regarding your payment or you may try again</div>
              </blockquote>
          </div>
          
      </div>
      <button type="submit" class="btn btn-outline-danger waves-effect waves-light button-save" onclick="cancelPay()">TRY AGAIN</button>
  </div>
</div>