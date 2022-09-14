@extends('Admin::users.manage', ['searchAction' => route('admin.escorts.manage')])

@section('search.form')
@parent

<div class="col-md-3">
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
@endsection

@section('manage.content.pre')
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
@endsection

@section('manage.table.content')
@component('Admin::common.table')
@slot('head')
<th>@lang('Image')</th>
<th>@lang('Name')</th>
<th>@lang('Profile Information')</th>
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
    <td>
        <span>
            <strong>@lang('Gender'):</strong>
            @if ($user->gender == 'M')
            @lang('Male')
            @elseif ($user->gender == 'F')
            @lang('Female')
            @else
            @lang('Not Specified')
            @endif
        </span>
        <br />
        <span>
            <strong>@lang('Type'):</strong>
            @if ($user->getAttribute('agency_id'))
            @lang('Agency Escort')
            @else
            @lang('Independent')
            @endif
        </span>
    </td>
    <td>
        @if ($user->isApproved())
        <label class="label label-success">@lang('Approved')</label>
        @else
        <label class="label label-warning">@lang('Pending Approval')</label>
        @endif
        <br />
        @if ($user->isVerified())
        <label class="label label-success">@lang('Verified')</label>
        @else
        <label class="label label-danger">@lang('Email Not Yet Verified')</label>
        @endif

        @if ($user->isBlocked())
        <br />
        <label class="label label-warning">@lang('Blocked')</label>
        @endif
    </td>
    <td>{{ $user->getAttribute($user->getCreatedAtColumn()) }}</td>
    <td>

        @component('Admin::common.table.dropdown_actions', [
        'optionActions' => [
        'view_info_' . $user->getKey() => __('View'),
        'edit_' . $user->getKey() => __('Update'),
        'delete_' . $user->getKey() => __('Delete'),
        'block_account_' . $user->getKey() => $user->isBlocked() ? __('Unblock Account') : __('Block Account'),
        'update_approval_' . $user->getKey() => $user->isApproved() ? __('Unapprove') : __('Approve'),
        'verify_email_' . $user->getKey() => $user->isVerified() ? __('Unverify Email') : __('Verify Email'),
        'add_note_' . $user->getKey() => __('Add Note'),
        'act_as_' . $user->getKey() => __('Act as behalf'),
        ]
        ])
        {{--
            @slot('options')
                <option value="view_info_{{ $user->getKey() }}">{{ __('View Information') }}</option>
        <option value="edit_{{ $user->getKey() }}">{{ __('Update Information') }}</option>
        <option value="delete_{{ $user->getKey() }}">{{ __('Delete') }}</option>
        <option value="block_account_{{ $user->getKey() }}">{{ $user->isBlocked() ? __('Unblock Account') : __('Block Account') }}</option>
        <option value="update_approval_{{ $user->getKey() }}">{{ $user->isApproved() ? __('Unapprove') : __('Approve') }}</option>
        <option value="verify_email_{{ $user->getKey() }}">{{ $user->isVerified() ? __('Unverify Email') : __('Verify Email') }}</option>
        <option value="add_note_{{ $user->getKey() }}">{{ __('Add Note') }}</option>
        <option value="act_as_{{ $user->getKey() }}">{{ __('Act as behalf') }}</option>
        @endslot
        --}}

        @include('Admin::common.table.actions.view_info', ['href' => route('admin.escort.view_info', ['id' => $user->getKey()]), 'objectId' => $user->getKey(), 'btnId' => 'view_info_' . $user->getKey()])
        @include('Admin::common.table.actions.update', ['href' => route('admin.escort.update', ['id' => $user->getKey()]), 'btnId' => 'edit_' . $user->getKey()])
        @include('Admin::common.table.actions.delete', ['to' => route('admin.escort.delete'), 'id' => $user->getKey(), 'btnId' => 'delete_' . $user->getKey()])
        @include('Admin::common.table.actions.account_blocked', ['isBlocked' => $user->isBlocked(), 'id' => $user->getKey(), 'to' => route('admin.escort.account_block'), 'btnId' => 'block_account_' . $user->getKey()])
        @if ($user->isApproved())
        <a id="update_approval_{{ $user->getKey() }}" href="{{ route('admin.escort.update_approval', ['is_approved' => false, 'id' => $user->getKey()]) }}" class="btn btn-danger btn-xs" title="{{ __('Unapprove')}}">
            <i class="fa fa-times"></i>
        </a>
        @else
        <a id="update_approval_{{ $user->getKey() }}" href="{{ route('admin.escort.update_approval', ['is_approved' => true, 'id' => $user->getKey(), 'key' => $key]) }}" class="btn btn-success btn-xs" title="{{ __('Approve')}}">
            <i class="fa fa-check"></i>
        </a>
        @endif
        @if ($user->isVerified())
        <a id="verify_email_{{ $user->getKey() }}" href="{{ route('admin.escort.update_email_verification', ['is_verified' => false, 'id' => $user->getKey()]) }}" class="btn btn-danger btn-xs" title="{{ __('Unverify Email')}}">
            <i class="fa fa-user-times"></i>
        </a>
        @else
        <a id="verify_email_{{ $user->getKey() }}" href="{{ route('admin.escort.update_email_verification', ['is_verified' => true, 'id' => $user->getKey(), 'key' => $key]) }}" class="btn btn-success btn-xs" title="{{ __('Verify Email')}}">
            <i class="fa fa-check-square-o"></i>
        </a>
        @endif
        @include('Admin::common.table.actions.add_notes', ['objectId' => $user->getKey(), 'btnId' => 'add_note_' . $user->getKey()])
        @include('Admin::common.table.actions.act_as', ['id' => $user->getKey(), 'route' => route('admin.escort.act_as'), 'btnId' => 'act_as_' . $user->getKey()])

        @endcomponent
    </td>
</tr>
@empty
@include('Admin::common.table.no_results', ['colspan' => 6])
@endforelse
@endslot
@endcomponent

{{ $users->links() }}
@endsection