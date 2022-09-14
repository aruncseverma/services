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
                @component('Admin::common.search', ['action' => route('admin.finance.billers')])
                    <input type="hidden" name="limit" value="{{ $search['limit'] }}">

                    <div class="row p-t-20">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="control-label" for="name">@lang('Name')</label>
                                <input type="text" id="name" class="form-control" name="name" value="{{ $search['name'] }}">
                            </div>
                        </div>
                        <div class="col-md-6">
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
                  @include('Admin::common.table.actions.new', ['href' => route('admin.finance.newbiller')])
                </div>

                @component('Admin::common.table')
                    @slot('head')
                        <th>@lang('Name')</th>
                        <th></th>
                    @endslot

                    @slot('body')
                        @forelse ($billers as $biller)
                            <tr>
                                <td>{{ $biller->name }}</td>
                                
                                <td>
                                  @include('Admin::common.table.actions.edit_info', ['href' => route('admin.finance.editbiller', ['id' => $biller->id]), 'objectId' => $biller->id])
                                </td>
                            </tr>
                        @empty
                            @include('Admin::common.table.no_results', ['colspan' => 6])
                        @endforelse
                    @endslot
                @endcomponent

                {{ $billers->links() }}
            </div>
        </div>
    </div>
@endsection
