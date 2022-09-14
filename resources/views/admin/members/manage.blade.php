@extends('Admin::users.manage', ['searchAction' => route('admin.members.manage')])

@section('manage.table.content')
    @component('Admin::common.table')
        @slot('head')
            <th>@lang('Image')</th>
            <th>@lang('Name')</th>
            <th>@lang('Email Address')</th>
            <th>@lang('Account Status')</th>
            <th>@lang('Action')</th>
        @endslot

        @slot('body')
            @forelse ($users as $user)
                <tr>
                    <td>
                        <div style="width:80px;height:80px;margin:0 auto;">
                            <img src="{{ $user->profilePhotoUrl ?? $noImageUrl }}" alt="user" class="es-image" />
                        </div>
                    </td>
                    <td>{{ $user->name }}</td>
                    <td>{{ $user->email }}</td>
                    <td>@include('Admin::common.account_status', ['isActive' => $user->isActive()])</td>
                    <td>
                        @component('Admin::common.table.dropdown_actions', [
                            'optionActions' => [
                                'edit_' . $user->getKey() => __('Update'),
                                'delete_' . $user->getKey() => __('Delete'),
                                'update_status_' . $user->getKey() => $user->isActive() ? __('Disable') : __('Activate'),
                                'add_note_' . $user->getKey() => __('Add Note'),
                                'act_as_' . $user->getKey() => __('Act as behalf'),
                            ]
                        ])
                            @include('Admin::common.table.actions.update', ['href' => route('admin.member.update', ['id' => $user->getKey()]), 'btnId' => 'edit_' . $user->getKey()])
                            @include('Admin::common.table.actions.delete', ['id' => $user->getKey(), 'to' => route('admin.member.delete'), 'btnId' => 'delete_' . $user->getKey()])

                            @include('Admin::common.table.actions.update_status', [
                                'route' => 'admin.member.update_status',
                                'id' => $user->getKey(),
                                'isActive' => $user->isActive(),
                                'btnId' => 'update_status_' . $user->getKey(),
                            ])

                            @include('Admin::common.table.actions.add_notes', ['objectId' => $user->getKey(), 'btnId' => 'add_note_' . $user->getKey()])
                            @include('Admin::common.table.actions.act_as', ['id' => $user->getKey(), 'route' => route('admin.member.act_as'), 'btnId' => 'act_as_' . $user->getKey()])
                        @endcomponent
                    </td>
                </tr>
            @empty
                @include('Admin::common.table.no_results', ['colspan' => 4])
            @endforelse
        @endslot
    @endcomponent

    {{ $users->links() }}
@endsection
