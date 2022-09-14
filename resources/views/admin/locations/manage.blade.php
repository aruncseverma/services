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
                @component('Admin::common.search', ['action' => route('admin.locations.manage')])
                    <input type="hidden" name="limit" value="{{ $search['limit'] }}">

                    <div class="row p-t-20">
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label" for="continent_id">@lang('Continent')</label>
                                @include(
                                    'Admin::common.form.continent',
                                    [
                                        'name' => 'continent_id',
                                        'all' => true,
                                        'value' => $search['continent_id'],
                                        'classes' => 'form-control select2', 
                                        'attributes' => 'data-live-search=true style=width:100%',
                                    ]
                                )
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label" for="continent_id">@lang('Country')</label>
                                @include(
                                    'Admin::common.form.country',
                                    [
                                        'name' => 'country_id',
                                        'disable_preloaded' => true,
                                        'all' => true,
                                        'value' => $search['country_id'],
                                        'classes' => 'form-control select2', 
                                        'attributes' => 'data-live-search=true style=width:100%',
                                    ]
                                )
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label" for="continent_id">@lang('States/Region')</label>
                                @include(
                                    'Admin::common.form.states',
                                    [
                                        'name' => 'state_id',
                                        'disable_preloaded' => true,
                                        'all' => true,
                                        'value' => $search['state_id'],
                                        'classes' => 'form-control select2', 
                                        'attributes' => 'data-live-search=true style=width:100%',
                                    ]
                                )
                            </div>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="control-label" for="name">@lang('City')</label>
                                <input type="text" id="name" class="form-control" name="name" value="{{ $search['name'] }}">
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

                @component('Admin::common.table')
                    @slot('head')
                        <th>@lang('Continent')</th>
                        <th>@lang('Country')</th>
                        <th>@lang('States/Region')</th>
                        <th>@lang('City')</th>
                        <th>@lang('Status')</th>
                        <th>@lang('Actions')</th>
                    @endslot

                    @slot('body')
                        @forelse ($locations as $location)
                            <tr>
                                <td>{{ $location->continent->name }}</td>
                                <td>{{ $location->country->name }}</td>
                                <td>{{ $location->state->name }}</td>
                                <td>{{ $location->name }}</td>
                                <td>@include('Admin::common.account_status', ['isActive' => $location->isActive()])</td>
                                <td>
                                    <a href="{{ route('admin.location.update_status', ['id' => $location->getKey()]) }}" class="btn @if ($location->isActive()) btn-danger @else btn-success @endif btn-xs" title="@if ($location->isActive()) @lang('Disable') @else @lang('Activate') @endif">
                                        @if ($location->isActive())
                                            <i class="fa fa-circle"></i>
                                        @else
                                            <i class="fa fa-circle-o"></i>
                                        @endif
                                    </a>
                                </td>
                            </tr>
                        @empty
                            @include('Admin::common.table.no_results', ['colspan' => 6])
                        @endforelse
                    @endslot
                @endcomponent

                {{ $locations->links() }}
            </div>
        </div>
    </div>
@endsection
