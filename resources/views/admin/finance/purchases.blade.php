@extends('Admin::layout')

{{-- title --}}
@section('main.content.title')
    {{ $title }}
@endsection
{{-- end title --}}

@section('main.content')
    <div class="col-lg-12">
        <div class="card">
            <div class="card-body">
                {{-- search --}}
                @component('Admin::common.search', ['action' => route('admin.finance.transactions')])
                    <input type="hidden" name="limit" value="{{ $search['limit'] }}">

                    <div class="row p-t-20">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label" for="status">@lang('Status')</label>
                                @include(
                                    'Admin::common.form.status',
                                    [
                                        'name' => 'status',
                                        'all' => true,
                                        'value' => $search['status']
                                    ]
                                )
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label" for="user">@lang('User')</label>
                                <input type="text" id="user" class="form-control" name="user" value="{{ $search['user'] }}">
                            </div>
                        </div>
                    </div>
                @endcomponent
                {{-- end search --}}

                {{-- notification --}}
                @include('Admin::common.notifications')
                {{-- end notification --}}

                @component('Admin::common.table')
                    @slot('head')
                        <th>@lang('Order Number')</th>
                        <th>@lang('User')</th>
                        <th>@lang('Plan')</th>
                        <th>@lang('Price')</th>
                        <th>@lang('Payment Method')</th>
                        <th>@lang('Status')</th>
                        <th></th>
                    @endslot
                    @slot('body')
                        @forelse ($purchases as $purchase)
                            @php
                                $status = "Pending";
                                $style = "badge-primary";
                                if ($purchase->status == "C") {
                                    $status = "Completed";
                                    $style = "badge-success";
                                } else if ($purchase->status == "P") {
                                    $status = "Pending";
                                    $style = "badge-warning";
                                } else {
                                    $status = "Deleted";
                                    $style = "badge-danger";
                                }
                                
                                if ($purchase->status == 'C') {
                                    if ($purchase->vip_status == 'R') {
                                        $status = 'Revoked';
                                        $style = 'badge-danger';
                                    }
                                }
                            @endphp

                            <tr>
                                <td>{{ $purchase->order_id }}</td>
                                <td>{{ $purchase->user->username }}</td>
                                <td>{{ $purchase->membership->months }} months VIP</td>
                                <td>{{ $purchase->membership->currency->name }} {{ $purchase->membership->total_price }}</td>
                                <td>{{ $purchase->biller->name }}</td>
                                <td><center><span class="badge {{ $style }}">{{ $status }}</span></center></td>
                                <td>
                                    <center>
                                        @if ($purchase->vip_status != 'A' && $purchase->status == 'C')
                                            <a href="{{ route('admin.finance.vip.update', ['id' => $purchase->id, 'vip_status' => 'A']) }}" class="btn btn-sm btn-success es es-confirm" title="Activate VIP Status"><i class="fa fa-check"></i></a>
                                        @endif

                                        @if ($purchase->status == 'P')
                                            <a href="#"
                                                data-value="{{ $purchase->id }}"
                                                data-order="{{ $purchase->order_id }}"
                                                data-biller="{{ $purchase->biller->name }}"
                                                data-currency="{{ $purchase->membership->currency->name }}"
                                                data-total="{{ $purchase->membership->total_price }}"
                                                data-toggle="modal" 
                                                data-target="#counterPayment" 
                                                class="clicker btn btn-sm btn-success" 
                                                title="Mark as paid">
                                                    <i class="fa fa-money"></i>
                                            </a>
                                        @endif

                                        @if($purchase->status == 'C' && ($purchase->biller->id == 1 || $purchase->biller->id == 4))
                                        @php
                                            $image = $purchase->payment->attachment['image'];
                                            $mimeType = $purchase->payment->attachment['mime'];
                                        @endphp
                                        <a href="#"
                                                data-order="{{ $purchase->order_id }}"
                                                data-biller="{{ $purchase->biller->name }}"
                                                data-currency="{{ $purchase->membership->currency->name }}"
                                                data-total="{{ $purchase->membership->total_price }}"
                                                data-value="{{ $purchase->payment->reference_id }}"
                                                data-toggle="modal" 
                                                data-target="#showPayment" 
                                                data-image="{{ $image }}"
                                                data-mime="{{ $mimeType }}"
                                                data-approver="{{ $purchase->payment->admin->name }}"
                                                data-date="{{ $purchase->payment->created_at }}"
                                                class="viewer btn btn-sm btn-info" 
                                                title="View Payment Info">
                                                    <i class="fa fa-eye"></i>
                                            </a>
                                        @endif

                                        @if ($purchase->vip_status != 'R' && $purchase->status == 'C')
                                            <a href="#"
                                                data-id="{{ $purchase-> id }}"
                                                data-toggle="modal" 
                                                data-target="#revokeMembership" 
                                                class="revoke btn btn-sm btn-danger" 
                                                title="Revoke VIP">
                                                    <i class="fa fa-ban"></i>
                                            </a>
                                        @endif

                                        @if ($purchase->vip_status != 'D' && $purchase->status != 'C')
                                            <a href="{{ route('admin.finance.vip.update', ['id' => $purchase->id, 'vip_status' => 'D' ]) }}" class="btn btn-sm btn-danger es es-confirm" title="Remove Request"><i class="fa fa-trash"></i></a>
                                        @endif
                                    </center>
                                </td>
                            </tr>
                        @empty
                            @include('Admin::common.table.no_results', ['colspan' => 6])
                        @endforelse
                    @endslot
                @endcomponent

                {{ $purchases->links() }}
            </div>
        </div>
    </div>

    @include('admin.finance.components.payment_info')
    @include('admin.finance.components.show_payment')
    @include('admin.finance.components.revoke_vip')
@endsection

@pushAssets('scripts.post')
<script>
    $('.clicker').on('click', function(e) {
        e.preventDefault()

        var id = $(this).data('value')
        var invoiceId = $(this).data('order')
        var biller = $(this).data('biller')
        var currency = $(this).data('currency')
        var total = $(this).data('total')

        $('#transId').val(id)
        $('#orderID').html(invoiceId)
        $('#paymentMethod').html(biller)
        $('#totalPrice').html(currency + ' ' + total)
    })

    $('.viewer').on('click', function(e) {
        e.preventDefault()

        var invoiceId = $(this).data('order')
        var biller = $(this).data('biller')
        var currency = $(this).data('currency')
        var total = $(this).data('total')
        var reference = $(this).data('value')
        var image = $(this).data('image')
        var mime = $(this).data('mime')
        var approver = $(this).data('approver')
        var approvedDate = $(this).data('date')

        var img = generateImageData(image, mime)

        $('#showOrderID').html(invoiceId)
        $('#showPaymentMethod').html(biller)
        $('#showTotalPrice').html(currency + ' ' + total)
        $('#showReferenceId').html(reference)
        $('#showAttachment').attr('src', img)
        $('#showApprover').html(approver)
        $('#showApprovedDate').html(approvedDate)
    })

    $('.revoke').on('click', function(e) {
        e.preventDefault()

        var purchaseId = $(this).data('id')
        $('#order_id').val(purchaseId)
    })

    $('#revokeForm').on('submit', function(e) {
        e.preventDefault()

        var orderId = $('#order_id').val()
        var reason = $('#revokeReason').val()

        fnConfirm(
            {
                title: 'Confirm Revoke',
                text: 'Are you sure you want to revoke this membership?'
            },
            function() {
                var formData = new FormData()
                formData.append('transaction_id', orderId)
                formData.append('reason', reason)

                var route = "{{ route('admin.finance.vip.revoke') }}"
                var redirect = "{{ route('admin.finance.vip.update', ['id' => 'id', 'vip_status' => 'R']) }}"
                var redirectUrl = redirect.replace(/id/gi, orderId)

                $.ajax(route, {
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: 'JSON',
                    success: function (data) {
                        if (data.code == 1) {
                            swal({
                                type: 'success',
                                title: 'Success',
                                text: 'Transaction successfully revoked.',
                            }, function (isConfirm) {
                                window.location.href = redirectUrl
                            })
                        } else {
                            swal({
                                type: 'error',
                                title: 'Error',
                                text: error.message,
                            })
                        }
                    },
                    error: function(error) {
                        swal({
                            type: 'error',
                            title: 'Error',
                            text: error.message,
                        })
                    }
                })
            }
        )
    })

    $('#markAsPaid').on('submit', function(e) {
        e.preventDefault()

        var id = $('#transId').val()
        var orderId = $('#orderId').val()
        var referenceId = $('#reference_id').val()
        var attachment = $('input[type=file]')[0].files[0]

        fnConfirm(
            // options
            {
                title: 'Confirm Payment',
                text: 'Are you sure you want to submit this payment information?'
            },
            // Success
            function() {

                var formData = new FormData()
                formData.append('trans_id', id)
                formData.append('reference_id', referenceId)
                formData.append('attachment', attachment)

                var route = "{{ route('admin.finance.vip.paid') }}"
                var redirect = "{{ route('admin.finance.vip.update', ['id' => 'id', 'vip_status' => 'A']) }}"
                var redirectUrl = redirect.replace(/id/gi, id)

                $.ajax(route, {
                    method: 'POST',
                    data: formData,
                    processData: false,
                    contentType: false,
                    dataType: 'JSON',
                    success: function (data) {
                        console.log(data)
                        if (data.code == 1) {
                            swal({
                                type: 'success',
                                title: 'Success',
                                text: 'Transaction successfully marked as paid.',
                            }, function (isConfirm) {
                                window.location.href = redirectUrl
                            })
                        }
                    },
                    error: function (error) {
                        swal({
                            type: 'error',
                            title: 'Error',
                            text: error.message,
                        })
                    }
                })
            },
            // Error
            function() {
                alert('Something went wrong. Please try again later.')
            }
        )
    })

    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function generateImageData(image, mimeType) {
        return `data:${mimeType};base64,${image}`
    }
</script>
@endPushAssets