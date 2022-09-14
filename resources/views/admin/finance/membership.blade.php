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
                @component('Admin::common.search', ['action' => route('admin.finance.plans')])
                    <input type="hidden" name="limit" value="{{ $search['limit'] }}">

                    <div class="row p-t-20">
                        <div class="col-md-4">
                          <div class="form-group">
                            <label class="control-label" for="currency">@lang('Currency')</label>
                            @include(
                              'Admin::common.form.currency',
                              [
                                'name' => 'currency',
                                'all' => true,
                                'value' => $search['currency']
                              ]
                            )
                          </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label" for="is_active">@lang('Status')</label>
                                <div class="m-b-10">
                                    <label class="custom-control custom-radio">
                                        <input id="active" name="is_active" type="radio" class="custom-control-input" @if ($search['is_active'] == '1') checked="" @endif value="1">
                                        <span class="custom-control-label">@lang('Active')</span>
                                    </label>
                                    <label class="custom-control custom-radio">
                                        <input id="inactive" name="is_active" type="radio" class="custom-control-input" @if ($search['is_active'] == '0') checked="" @endif value="0">
                                        <span class="custom-control-label">@lang('Inactive')</span>
                                    </label>
                                    <label class="custom-control custom-radio">
                                        <input id="all" name="is_active" type="radio" class="custom-control-input" @if ($search['is_active'] == '*') checked="" @endif value="*">
                                        <span class="custom-control-label">@lang('All')</span>
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                @endcomponent
                {{-- end search --}}

                {{-- notification --}}
                @include('Admin::common.notifications')
                {{-- end notification --}}

                <div class="pull-right">
                  @include('Admin::common.table.actions.new', ['href' => route('admin.finance.newplan'), 'action' => route('admin.finance.saveplans')])
                </div>

                @component('Admin::common.table')
                    @slot('head')
                        <th>@lang('Currency')</th>
                        <th>@lang('Duration')</th>
                        <th>@lang('Discount')</th>
                        <th>@lang('Price')</th>
                        <th>@lang('Active')</th>
                        <th></th>
                    @endslot

                    @slot('body')
                        @forelse ($plans as $plan)
                            @php
                                if($plan->is_active) {
                                    $class = 'success';
                                    $status = 'Active';
                                } else {
                                    $class = 'danger';
                                    $status = 'Disabled';
                                }
                            @endphp
                            <tr>
                                <td>{{ $plan->currency->name }}</td>
                                <td>{{ $plan->months }} Months</td>
                                <td>{{ $plan->discount }}</td>
                                <td>{{ $plan->total_price }}</td>
                                <td><span class="badge badge-{{$class}}">{{ $status }}</span></td>
                                <td>@include('Admin::common.table.actions.edit_info', ['href' => route('admin.finance.editplan', ['id' => $plan->id]), 'action' => route('admin.finance.saveplans'), 'objectId' => $plan->id])</td>
                            </tr>
                        @empty
                            @include('Admin::common.table.no_results', ['colspan' => 6])
                        @endforelse
                    @endslot
                @endcomponent

                {{ $plans->links() }}
            </div>
        </div>
    </div>
@endsection
