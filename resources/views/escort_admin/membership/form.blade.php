@extends('EscortAdmin::layout')

@section('main.content.title')
    <i class="mdi mdi-crown"></i>&nbsp;{{ $title }}
@endsection

@section('main.content')
    <form method="post" class="row">
      @include('EscortAdmin::membership.components.plans')
      @include('EscortAdmin::membership.components.payment')

      <div id="submit_button" class="card col-lg-12">
        <div class="card-body">
          <button type="submit" class="btn btn-success pull-right" id="btnPurchase">Submit</button>
        </div>
      </div>
    </form>
@endsection

@pushAssets('scripts.post')
<script src="https://www.paypal.com/sdk/js?client-id={{ env('PAYPAL_CLIENT_ID', '') }}"></script>
<script type="text/javascript">
    // hide payment details as long as no payment selected
    $('#credit_card').hide()
    $('#submit_button').hide()
    $('#paypal-button-container').hide()
    $('#bank-instuction').hide()
    $('#payment-complete').hide()
    $('#western-union-instruction').hide()

    var planId = $('input[name="plan_id"]:checked').val()
    var paymentId = $('input[name="payment_id"]:checked').val()

    var selectedPrice = ''
    var selectedCurrency = ''
    var selectedDuration = ''
    var paymentDetails = ''
    var status = 'P'

    $('input[name="plan_id"]').on('change', function() {
      planId = $('input[name="plan_id"]:checked').val()
      selectedPrice = $('input[name="plan_id"]:checked').data('price')
      selectedCurrency = $('input[name="plan_id"]:checked').data('currency')
      selectedDuration = $('input[name="plan_id"]:checked').data('duration')

      validate()
    })

    $('input[name="payment_id"]').on('change', function() {
      paymentId = $('input[name="payment_id"]:checked').val()
      console.log(paymentId)
      validate()

      // Credit card & Paypal option
      if (paymentId == 2 || paymentId == 3) {
        $('#paypal-button-container').show()
        $('#bank-instruction').hide()
        $('#western-union-instruction').hide()

      // Normal Bank Transfer
      } else if (paymentId == 1) {
        $('#paypal-button-container').hide()
        $('#western-union-instruction').hide()
        $('#bank-instuction').show()

        var details = $('input[name="payment_id"]:checked').data('value')
        $('#price').text(`${selectedCurrency} ${selectedPrice}`)
        $('#payment-details').html(details)
        $('#submit_button').show()

      // Western Union Transfer
      } else if (paymentId == 4) {
        $('#bank-instuction').hide()
        $('#paypal-button-container').hide()
        $('#western-union-instruction').show()

        var details = $('input[name="payment_id"]:checked').data('value')
        $('#wu-price').text(`${selectedCurrency} ${selectedPrice}`)
        $('#wu-payment-details').html(details)
        $('#submit_button').show()
      }
    })

    function validate() {
      if (planId !== undefined && paymentId !== undefined) {
        $('#credit_card').show()
      }
    }

    // paypal controls
    paypal.Buttons({
      createOrder: function(data, actions) {
        return actions.order.create({
          purchase_units: [{
            amount: {
              value: selectedPrice
            },
            currency: {
              value: selectedCurrency
            }
          }]
        })
      },
      onApprove: function(data, actions) {
        return actions.order.capture().then(function(details) {
          paymentDetails = details.order_id
          status = 'C'
          console.log(details)
          $('#transaction').text = paymentDetails
          $('#payment-complete').show()
          $('#submit_button').show()

          $('#btnPurchase').click();
        })
      }
    }).render('#paypal-button-container')

    $('#btnPurchase').on('click', function(e) {
      e.preventDefault()
      this.disable

      var url = "{{ route('escort_admin.vip.purchase') }}"

      var formData = new FormData()
      formData.append('plan_id', planId)
      formData.append('duration', selectedDuration)
      formData.append('biller_id', paymentId)
      formData.append('payment_details', paymentDetails)
      formData.append('status', status)
      formData.append('_token', "{{ csrf_token() }}")

      var message = "Success"
      var redirectUrl = "{{ route('escort_admin.dashboard') }}"

      if (paymentId == 2 || paymentId == 3) {
        message = "VIP Membership successfuly purchased. Please wait up to 24 hours to process your transaction."
      } else {
        message = "VIP Membership successfuly requested. Please follow the instructions that has been sent to your email for payment and other process."
      }

      $.ajax(url, {
        method: 'POST',
        data: formData,
        processData: false,
        contentType: false,
        success: function(data) {
          swal({
            title: 'Success',
            text: message,
          }, function (isConfirm) {
            window.location.href = redirectUrl
          })
        },
        error: function(error) {
          console.log(error)
        }
      })
    })
</script>
@endPushAssets
