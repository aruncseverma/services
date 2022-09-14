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
                @component('Admin::common.search', ['action' => route('admin.finance.packages')])
                    <input type="hidden" name="limit" value="{{ $search['limit'] }}">

                    <div class="row p-t-20">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label" for="biller">@lang('Biller')</label>
                                @include(
                                    'Admin::common.form.biller',
                                    [
                                        'name' => 'biller',
                                        'all' => true,
                                        'value' => $search['biller']
                                    ]
                                )
                            </div>
                        </div>
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
                  @include('Admin::common.table.actions.new', ['href' => route('admin.finance.newpackage')])
                </div>

                @component('Admin::common.table')
                    @slot('head')
                        <th>@lang('Biller')</th>
                        <th>@lang('Currency')</th>
                        <th>@lang('Credits')</th>
                        <th>@lang('Discount')</th>
                        <th>@lang('Price')</th>
                        <th>@lang('Active')</th>
                        <th></th>
                    @endslot

                    @slot('body')
                        @forelse ($packages as $package)
                            <tr>
                                <td>{{ $package->biller->name }}</td>
                                <td>{{ $package->currency->name }}</td>
                                <td>{{ $package->credits }}</td>
                                <td>{{ $package->discount }}</td>
                                <td>{{ $package->price }}</td>
                                <td>{{ $package->is_active }}</td>
                                <td>@include('Admin::common.table.actions.edit_info', ['href' => route('admin.finance.editpackage', ['id' => $package->id]), 'objectId' => $package->id])</td>
                            </tr>
                        @empty
                            @include('Admin::common.table.no_results', ['colspan' => 6])
                        @endforelse
                    @endslot
                @endcomponent

                {{ $packages->links() }}
            </div>
        </div>
    </div>
@endsection
