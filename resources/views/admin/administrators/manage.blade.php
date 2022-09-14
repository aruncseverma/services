@extends('Admin::users.manage', ['searchAction' => route('admin.administrators.manage')])

@section('manage.table.content')
    @component('Admin::common.table')
        @slot('head')
            <th>@lang('Name')</th>
            <th>@lang('Email Address')</th>
            <th>@lang('Account Status')</th>
            <th>@lang('Action')</th>
        @endslot

        @slot('body')
            @forelse ($users as $user)
                <tr>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>@include('Admin::common.account_status', ['isActive' => $user->isActive()])</td>
                    <td>
                        @if($isSuperAdmin || (!$isSuperAdmin && $user->getKey() != config('app.super_admin_user_id')))
                        @php
                        $optionActions = [
                            'edit_' . $user->getKey() => __('Update'),
                            [
                                'id' => 'delete_' . $user->getKey(),
                                'text' => __('Delete'),
                                'show' => ($user->getKey() !== 1)
                            ],
                            'update_status_' . $user->getKey() => $user->isActive() ? __('Disable') : __('Activate'),
                        ];
                        if ($isSuperAdmin && $user->getKey() != 1) {
                            $optionActions['act_as_' . $user->getKey()] = __('Act as behalf');
                        }
                        @endphp
                        @component('Admin::common.table.dropdown_actions', [
                            'optionActions' => $optionActions
                        ])
                            @include('Admin::common.table.actions.update', ['href' => route('admin.administrator.update', ['id' => $user->getKey()]), 'btnId' => 'edit_' . $user->getKey()])

                            @if ($user->getKey() != 1)
                                @include('Admin::common.table.actions.delete', ['id' => $user->getKey(), 'to' => route('admin.administrator.delete'), 'btnId' => 'delete_' . $user->getKey()])
                            @endif
                            
                            @include('Admin::common.table.actions.update_status', [
                                'route' => 'admin.administrator.update_status',
                                'id' => $user->getKey(),
                                'isActive' => $user->isActive(),
                                'btnId' => 'update_status_' . $user->getKey(),
                            ])
                            @if($isSuperAdmin && $user->getKey() != 1)
                                @include('Admin::common.table.actions.act_as', ['id' => $user->getKey(), 'route' => route('admin.administrator.act_as'), 'btnId' => 'act_as_' . $user->getKey()])
                            @endif
                        @endcomponent
                        @endif
                    </td>
                </tr>
            @empty
                @include('Admin::common.table.no_results', ['colspan' => 4])
            @endforelse
        @endslot
    @endcomponent

    {{ $users->links() }}
@endsection
