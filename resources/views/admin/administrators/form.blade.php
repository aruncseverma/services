@extends('Admin::users.form', ['action' => route('admin.administrator.save'), 'cancelHref' => route('admin.administrators.manage')])

@section('form.inputs.post')
    @if ($user->getKey())
        @component('Admin::common.form.group', ['key' => 'role_id'])
            @slot('label')
                @lang('Role')
            @endslot

            @slot('input')
                @include('Admin::common.form.roles', ['name' => 'role_id', 'value' => $user->role->getKey(), 'showNullOption' => true])
            @endslot
        @endcomponent
    @endif
@endsection
