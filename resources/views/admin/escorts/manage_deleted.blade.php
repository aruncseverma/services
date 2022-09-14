@extends('Admin::layout')

{{-- title --}}
@section('main.content.title')
    {{ $title }}
@endsection
{{-- end title --}}


@section('main.content')
    <div class="col-lg-12">
        <div class="row">
            <!-- Column -->
            <div class="col-md-6 col-lg-3 col-xlg-3">
                <div class="card card-inverse card-info">
                    <div class="box bg-info text-center">
                        <h1 class="font-light text-white">{{ number_format($count['total']) }}</h1>
                        <h6 class="text-white">@lang('Total')</h6>
                    </div>
                </div>
            </div>
            <!-- Column -->
            <div class="col-md-6 col-lg-3 col-xlg-3">
                <div class="card card-primary card-inverse">
                    <div class="box text-center">
                        <h1 class="font-light text-white">{{ number_format($count['pending']) }}</h1>
                        <h6 class="text-white">@lang('Approval Pending')</h6>
                    </div>
                </div>
            </div>
            <!-- Column -->
            <div class="col-md-6 col-lg-3 col-xlg-3">
                <div class="card card-inverse card-success">
                    <div class="box text-center">
                        <h1 class="font-light text-white">{{ number_format($count['approved']) }}</h1>
                        <h6 class="text-white">@lang('Approved')</h6>
                    </div>
                </div>
            </div>
            <!-- Column -->
            <div class="col-md-6 col-lg-3 col-xlg-3">
                <div class="card card-inverse card-warning">
                    <div class="box text-center">
                        <h1 class="font-light text-white">{{ number_format($count['blocked']) }}</h1>
                        <h6 class="text-white">@lang('Blocked')</h6>
                    </div>
                </div>
            </div>
        </div>

        {{-- card --}}
        <div class="card">
            <div class="card-body">
                {{-- search --}}
                @component('Admin::common.search', ['action' => route('admin.escorts.accounts_deleted')])
                    <input type="hidden" name="limit" value="{{ $search['limit'] }}">

                    <div class="row p-t-20">
                        @section('search.form')
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label" for="name">@lang('Name')</label>
                                    <input type="text" id="name" class="form-control" name="name" value="{{ $search['name'] }}">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label" for="is_active">@lang('Account Status')</label>
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
                        @show
                    </div>
                @endcomponent
                {{-- end search --}}

                {{-- notification --}}
                @include('Admin::common.notifications')
                {{-- end notification --}}

                {{-- table --}}
                @component('Admin::common.table')
                    @slot('head')
                        <th>@lang('Image')</th>
                        <th>@lang('Name')</th>
                        <th>@lang('Profile Information')</th>
                        <th>@lang('Status')</th>
                        <th>@lang('Created At')</th>
                        <th>@lang('Deleted At')</th>
                        <th>@lang('Action')</th>
                    @endslot

                    @slot('body')
                        @forelse ($requests as $request)
                            <tr>
                                <td></td>
                                <td>{{ $request->user->name }}</td>
                                <td>
                                    <span>
                                        <strong>@lang('Gender'):</strong>
                                        @if ($request->user->gender == 'M')
                                            @lang('Male')
                                        @elseif ($request->user->gender == 'F')
                                            @lang('Female')
                                        @else
                                            @lang('Not Specified')
                                        @endif
                                    </span>
                                    <br/>
                                    <span>
                                        <strong>@lang('Type'):</strong>
                                        @if ($request->user->getAttribute('agency_id'))
                                            @lang('Agency Escort')
                                        @else
                                            @lang('Independent')
                                        @endif
                                    </span>
                                </td>
                                <td>
                                    @if ($request->user->isApproved())
                                        <label class="label label-success">@lang('Approved')</label>
                                    @else
                                        <label class="label label-warning">@lang('Pending Approval')</label>
                                    @endif
                                    <br/>
                                    @if ($request->user->isVerified())
                                        <label class="label label-success">@lang('Verified')</label>
                                    @else
                                        <label class="label label-danger">@lang('Email Not Yet Verified')</label>
                                    @endif

                                    @if ($request->user->isBlocked())
                                        <br/>
                                        <label class="label label-warning">@lang('Blocked')</label>
                                    @endif
                                </td>
                                <td>{{ $request->user->getAttribute($request->user->getCreatedAtColumn()) }}</td>
                                <td>{{ $request->user->getAttribute($request->user->getDeletedAtColumn()) }}</td>
                                <td>
                                    @include('Admin::common.table.actions.view_info', ['href' => route('admin.escort.view_info', ['id' => $request->user->getKey()]), 'objectId' => $request->user->getKey()])

                                    <a href="{{ route('admin.escorts.restore_account', ['id' => $request->user->getKey()]) }}" class="btn btn-xs btn-primary" title="{{ __('Restore Account') }}">
                                        <i class="mdi mdi-restore"></i>
                                    </a>
                                </td>
                            </tr>
                        @empty
                            @include('Admin::common.table.no_results', ['colspan' => 7])
                        @endforelse
                    @endslot
                @endcomponent
                {{-- end table --}}
            </div>
        </div>
        {{-- end card --}}
    </div>
@endsection
