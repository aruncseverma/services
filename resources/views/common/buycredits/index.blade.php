@extends($baselayout)

  <!-- ============================================================== -->
  <!-- Bread crumb and right sidebar toggle -->
  <!-- ============================================================== -->
  @section('main.content.title')
    <!--<i class="mdi mdi-email"></i>&nbsp;{{ $title }}: {{ $title }}-->
    <h3 class="text-themecolor m-b-0 m-t-0"><i class="mdi mdi-coin"></i>{{ strtoupper(__('strings.BuyCredits')) }}</h3>
  @endsection

  @section('main.content')
    <!-- ============================================================== -->
    <!-- End Bread crumb and right sidebar toggle -->
    <!-- ============================================================== -->
    <!-- ============================================================== -->
    <!-- Start Page Content -->
    <!-- ============================================================== -->
    
    <div class="col-12 buystep1">
        <div class="card">
          <div class="card-header">
              <div class="card-actions">
                  <a class="btn-minimize" data-toggle="collapse" data-target="#billerSelect"><i class="mdi mdi-window-minimize"></i></a>
              </div>
              <span>Choose Payment</span>
          </div>
          <div class="card-header-sub">
              Your preferred payment option
          </div>
          <div class="card-body collapse show" id="billerSelect">
              <div class="row">
                  <div class="col-12">
                      <!--<div class="alert alert-danger row">
                          <div class="col-1" style="align-self: center; text-align: center">
                              <h1><i class="mdi mdi-cart-outline"></i></h1>
                          </div>
                          <div class="col-11">
                              <table class="table">
                                  <thead>
                                      <th>YOUR ORDER(S)</th>
                                      <th class="pull-right">AMOUNT</th>
                                  </thead>
                                  <tr>
                                      <td>500 CREDIT</td>
                                      <td class="pull-right"><span>€</SPAN>500</td>
                                  </tr>
                              </table>
                          </div>
                      </div>-->
                      <div class="table-responsive">
                          <table class="table table-bordered">
                              <tbody>
                                  <tr>
                                    @foreach($billers as $biller)
                                      <td class="radio text-center radio-danger">
                                          <input type="radio" name="radio" id="radio{{$biller->id}}" value="biller{{$biller->id}}" class="m-b-20" onchange="loadPackages(this.value,selectedCurrency);" @if ($biller->id === $active) checked @endif>
                                          <label for="radio{{$biller->id}}"></label>
                                          <h4 class="text-center">{{$biller->name}}</h4>
                                          <img src="{{ asset('assets/theme/admin/default/images/'.$biller->logo) }}" alt="{{$biller->name}}" width="144px" height="98px">
                                      </td>
                                    @endforeach
                                  </tr>
                              </tbody>
                          </table>
                      </div>
                  </div>
              </div>
                <!--<button type="submit" class="btn btn-outline-danger waves-effect waves-light button-save">PROCEED TO PAY</button>-->

          </div>
      </div>
    </div>

    <div class="col-12 buystep1">
            <div class="card">
            <div class="card-header">
                <div class="card-actions">
                    <a class="btn-minimize" data-toggle="collapse" data-target="#proceedpayment"><i class="mdi mdi-window-minimize"></i></a>
                </div>
                <span>Credit Packages</span>
                <div class="pull-right currency-drop">
                    <select class="selectpicker" data-style="btn-info" onchange="loadPackages($('input[name=radio]:checked').val(),this.value);">
                      @foreach ($currencies as $currency) 
                        <option value="{{$currency->id}}" @if ($activecurrency == $currency->id) selected @endif>{{$currency->name}}</option>
                      @endforeach
                    </select>
                </div>
            </div>
            <div class="card-header-sub">
                Top up your credits now
            </div>

            <div class="card-body collapse show" id="proceedpayment">
                @include('Common::buycredits.packages')
        </div>
    </div>

    <div class="col-12 paystep" style="display: none"></div>
    <div class="col-12 endstep" style="display: none"></div>

    <script type="text/javascript">
        var selectedCurrency = 2; // Euro by default.
        var selectedPackage = 0;

        function loadPackages(value, Currency) {

            /* value would be biller1 -> extract '1' */
            id = value.substr(6);

            $.ajax({
                url: window.location.href + '/packages'
                , data: "id=" + id + "&currency=" + Currency
                , success: function (data) {
                  selectedCurrency = Currency;

                  $('#proceedpayment').html(data);
                  $('#Packages tbody tr').click(function() {
                  $(this).addClass('bg-info').siblings().removeClass('bg-info');
                      selectedPackage = this.id;
                  });
                }
                , failure: function (data) {
                    console.log(data);
                }
            });  
        }

        function payNow(packageId) {
            $.ajax({
                url: window.location.href + '/paynow'
                , data: "id=" + packageId
                , success: function (data) {
                    $('.paystep').html(data);
                    $('.buystep1').hide();
                    $('.paystep').show();
                }
                , failure: function (data) {
                    console.log(data);
                }
            });  
            
        }

        function cancelPay(transactionId = null) {
            if (transactionId == null) {
                $('.endstep').hide();
                $('.buystep1').show();
            }
            $.ajax({
                url: window.location.href + '/confirm'
                , data: "confirmation=cancel&transactionid=" + transactionId
                , success: function (data) {
                    $('.paystep').hide();
                    $('.buystep1').show();
                }
                , failure: function (data) {
                    console.log(data);
                }
            });
        }

        function confirmPay(transactionId = null) {
            $.ajax({
                url: window.location.href + '/confirm'
                , data: "confirmation=success" + ((transactionId !== null) ? "&transactionid=" + transactionId : '')
                , success: function (data) {
                    $('.endstep').html(data);
                    $('.paystep').hide();
                    $('.endstep').show();
                }
                , failure: function (data) {
                    console.log(data);
                }
            });

            //$('.paystep').hide();
            //$('.endstep').show();
        }
    </script>
  @endsection
