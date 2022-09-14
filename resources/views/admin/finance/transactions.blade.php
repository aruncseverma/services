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
                        <th>@lang('Type')</th>
                        <th>@lang('Id')</th>
                        <th>@lang('From User')</th>
                        <th>@lang('From Amount')</th>
                        <th>@lang('To User')</th>
                        <th>@lang('To Amount')</th>
                        <th>@lang('Status')</th>
                        <th>@lang('Note')</th>
                        <th>@lang('Created')</th>
                        <th></th>
                    @endslot

                    @slot('body')
                        @forelse ($transactions as $transaction)
                            <tr>
                                <td>{{ $transaction->type }}</td>
                                <td>{{ $transaction->id }}</td>
                                <td>
                                  @if($transaction->from_user){{ $transaction->from_user->name }}
                                  @endif
                                </td>
                                <td>{{ $transaction->from_amount }}
                                  @if($transaction->type == 'Payment'){{ json_decode($transaction->note)->currencySymbol }}
                                  @else
                                  <td>{{ floor($transaction->from_amount) }} Tokens</td>
                                  @endif
                                </td>
                                <td>
                                    @if($transaction->to_user){{ $transaction->to_user->name }}
                                    @endif
                                </td>
                                <td>{{ floor($transaction->to_amount) }} Tokens</td>
                                <td>{{ $transaction->status }}</td>
                                @if($transaction->type == 'Payment')
                                <td>PaymentType: {{ json_decode($transaction->note)->paymentType }}</td>
                                @else
                                <td>{{ $transaction->note }}</td>
                                @endif
                                <td>{{ $transaction->created_at }}</td>
                                <td>
                                  @include('Admin::common.table.actions.view_info', ['href' => route('admin.finance.viewtransaction', ['id' => $transaction->id]), 'objectId' => $transaction->id])
                                  @if ($transaction->status == 'Confirmed')
                                    <a href="{{ route('admin.finance.refund', ['id' => $transaction->getKey()]) }}" class="btn btn-danger btn-xs" title="Refund"><i class="fa fa-undo"></i></a>
                                  @elseif ($transaction->status == 'Pending')
                                    <a href="{{ route('admin.finance.confirm', ['id' => $transaction->getKey()]) }}" class="btn btn-success btn-xs" title="Confirm"><i class="fa fa-check"></i></a>
                                    <a href="{{ route('admin.finance.cancel', ['id' => $transaction->getKey()]) }}" class="btn btn-danger btn-xs" title="Cancel"><i class="fa fa-times"></i></a>
                                  @endif
                                </td>
                            </tr>
                        @empty
                            @include('Admin::common.table.no_results', ['colspan' => 6])
                        @endforelse
                    @endslot
                @endcomponent

                {{ $transactions->links() }}
            </div>
        </div>
    </div>
@endsection
