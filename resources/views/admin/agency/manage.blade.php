@extends('Admin::layout')

{{-- title --}}
@section('main.content.title')
    {{ $title }}
@endsection
{{-- end title --}}

@section('main.content')
    <div class="col-lg-12">
        {{-- stats --}}
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
        {{-- end stats --}}

        <div class="card">
            <div class="card-body">

                {{-- search --}}
                @component('Admin::common.search', ['action' => ''])
                    <input type="hidden" name="limit" value="{{ $search['limit'] }}">

                    <div class="row">
                        @section('search.form')
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label" for="name">@lang('Agency Name')</label>
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
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="control-label" for="slug">@lang('Created At')</label>
                                    <div class="m-b-10">
                                        @include('Admin::common.form.date_range', [
                                        'id' => 'created_at',
                                        'name_start' => 'created_at_start',
                                        'value_start' => $search['created_at_start'] ?? '',
                                        'name_end' => 'created_at_end',
                                        'value_end' => $search['created_at_end'] ?? '',
                                        ])
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

                @component('Admin::common.table')
                    @slot('head')
                        <th>@lang('Image')</th>
                        <th>@lang('Agency Name')</th>
                        <th>@lang('Total Escorts')</th>
                        <th>@lang('Status')</th>
                        <th>@lang('Created At')</th>
                        <th>@lang('Action')</th>
                    @endslot

                    @slot('body')
                        @forelse ($users as $user)
                        @php
                            $key = isset($pending[$user->email]) ? $pending[$user->email] : '';
                        @endphp
                            <tr>
                                <td>
                                    <div style="width:80px;height:80px;margin:0 auto;">
                                        <img src="{{ $user->profilePhotoUrl ?? $noImageUrl }}" alt="user" class="es-image" />
                                    </div>
                                </td>
                                <td>{{ $user->name }}</td>
                                <td><label class="label label-success">{{ $user->getTotalEscorts() }}</label></td>
                                <td>
                                    @if ($user->isApproved())
                                        <label class="label label-success">@lang('Approved')</label>
                                    @else
                                        <label class="label label-warning">@lang('Pending Approval')</label>
                                    @endif
                                    <br/>
                                    @if ($user->isVerified())
                                        <label class="label label-success">@lang('Verified')</label>
                                    @else
                                        <label class="label label-danger">@lang('Email Not Yet Verified')</label>
                                    @endif
                                </td>
                                <td>{{ $user->getAttribute($user->getCreatedAtColumn()) }}</td>
                                <td>
                                    @component('Admin::common.table.dropdown_actions', [
                                        'optionActions' => [
                                            'edit_' . $user->getKey() => __('Update'),
                                            'delete_' . $user->getKey() => __('Delete'),
                                            'block_account_' . $user->getKey() => $user->isBlocked() ? __('Unblock Account') : __('Block Account'),
                                            'update_approval_' . $user->getKey() => $user->isApproved() ? __('Unapprove') : __('Approve'),
                                            'verify_email_' . $user->getKey() => $user->isVerified() ? __('Unverify Email') : __('Verify Email'),
                                            'add_note_' . $user->getKey() => __('Add Note'),
                                            'act_as_' . $user->getKey() => __('Act as behalf'),
                                        ]
                                    ])
                                        @include('Admin::common.table.actions.update', ['href' => route('admin.agency.update', ['id' => $user->getKey()]), 'btnId' => 'edit_' . $user->getKey()])
                                        @include('Admin::common.table.actions.delete', ['to' => route('admin.agency.delete'), 'id' => $user->getKey(), 'btnId' => 'delete_' . $user->getKey()])
                                        @include('Admin::common.table.actions.account_blocked', ['isBlocked' => $user->isBlocked(), 'id' => $user->getKey(), 'to' => route('admin.agency.account_block'), 'btnId' => 'block_account_' . $user->getKey()])

                                        @if ($user->isApproved())
                                            <a id="update_approval_{{ $user->getKey() }}" href="{{ route('admin.agency.update_approval', ['is_approved' => false, 'id' => $user->getKey()]) }}" class="btn btn-danger btn-xs" title="{{ __('Unapprove')}}">
                                                <i class="fa fa-times"></i>
                                            </a>
                                        @else
                                            <a id="update_approval_{{ $user->getKey() }}" href="{{ route('admin.agency.update_approval', ['is_approved' => true, 'id' => $user->getKey(), 'key' => $key]) }}" class="btn btn-success btn-xs" title="{{ __('Approve')}}">
                                                <i class="fa fa-check"></i>
                                            </a>
                                        @endif

                                        @if ($user->isVerified())
                                            <a id="verify_email_{{ $user->getKey() }}" href="{{ route('admin.agency.update_email_verification', ['is_verified' => false, 'id' => $user->getKey()]) }}" class="btn btn-danger btn-xs" title="{{ __('Unverify Email')}}">
                                                <i class="fa fa-user-times"></i>
                                            </a>
                                        @else
                                            <a id="verify_email_{{ $user->getKey() }}" href="{{ route('admin.agency.update_email_verification', ['is_verified' => true, 'id' => $user->getKey()]) }}" class="btn btn-success btn-xs" title="{{ __('Verify Email')}}">
                                                <i class="fa fa-check-square-o"></i>
                                            </a>
                                        @endif

                                        @include('Admin::common.table.actions.add_notes', ['objectId' => $user->getKey(), 'btnId' => 'add_note_' . $user->getKey()])
                                        @include('Admin::common.table.actions.act_as', ['id' => $user->getKey(), 'route' => route('admin.agency.act_as'), 'btnId' => 'act_as_' . $user->getKey()])
                                    @endcomponent
                                </td>
                            </tr>
                        @empty
                            @include('Admin::common.table.no_results', ['colspan' => 6])
                        @endforelse
                    @endslot
                @endcomponent

                {{ $users->links() }}
            </div>
        </div>
    </div>
@endsection
