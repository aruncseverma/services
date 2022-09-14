<div class="card col-lg-12">
    <div class="card-header" data-toggle="collapse" data-target="#site_news">
        <div class="card-actions">
            <a class="btn-minimize"><i class="mdi mdi-window-minimize"></i></a>
        </div>
        <span>@lang('Payment Methods')</span>
    </div>
    <div class="card-body collapse show" id="site_news">
        <div class="table-responsive">
            <table class="table table-bordered">
                <tbody>
                    <tr>
                    @forelse($billers as $biller)
                        <td class="radio text-center radio-danger">
                            <input type="radio" name="payment_id" id="radio{{$biller->id}}" value="{{$biller->id}}" class="m-b-20" data-value="{{ $biller->billnote }}">
                            <label for="radio{{$biller->id}}"></label>
                            <h4 class="text-center">{{$biller->name}}</h4>
                            <img src="{{ asset('assets/theme/admin/default/images/'.$biller->logo) }}" alt="{{$biller->name}}" width="144px" height="98px">
                        </td>
                    @empty
                        @include('EscortAdmin::common.table.no_results', ['colspan' => 2])
                    @endforelse
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
</div>

<div id="credit_card" class="card col-lg-12">
    <div class="card-header" data-toggle="collapse" data-target="#credit_card_payment">
        <div class="card-actions">
            <a class="btn-minimize"><i class="mdi mdi-window-minimize"></i></a>
        </div>
        <span>@lang('Payment Details')</span>
    </div>
    <div class="card-body collapse show" id="#credit_card_payment">

        {{-- Payment Details as stated in billers info --}}
        <div id="bank-instuction">
            <div class="col-sm-12">
              <h2>Amount to be paid: <span class="text-danger" id="price"></span></h2>
              <div>You may send the wire transfer to our bank</div>
              <div>Here are the informations you will be needing</div>
              <blockquote>
                <div id="payment-details"></div>
              </blockquote>
              <h6>Please send us a copy of the receipt via email</h6>
            </div>
        </div>
        <div id="western-union-instruction">
            <div class="col-sm-12">
              <h2>Amount to be paid: <span class="text-danger" id="wu-price"></span></h2>
              <div>You may pay us through the nearest Western Union office.</div>
              <div>Here are the informations you will be needing.</div>
              <blockquote>
                <div id="wu-payment-details"></div>
              </blockquote>
              <h6>Please send us a copy of the receipt via email.</h6>
          </div>
        </div>
        {{-- End Payment Details --}}

        {{-- Paypal form with credit card implementation --}}
        <center>
            <div id="paypal-button-container"></div>
        </center>
        <div id="payment-complete" class="jumbotron jumbotron-fluid">
            <div class="container">
                <h1 class="display-4">Payment Complete</h1>
                <p class="lead">Please click submit to complete your transaction.<br /> Your transaction id is: <b><span id="transaction"></span></b></p>
            </div>
        </div>
        {{-- End paypal form --}}
    </div>
</div>