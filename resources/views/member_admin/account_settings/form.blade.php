@extends('MemberAdmin::layout')

@section('main.content.title')
    <i class="mdi mdi-settings"></i>&nbsp;{{ $title }}
@endsection

@section('main.content')
    {{-- email --}}
    @include('MemberAdmin::account_settings.components.change_email')
    {{-- end email --}}

    {{-- password --}}
    @include('MemberAdmin::account_settings.components.change_password')
    {{-- end password --}}

    {{-- switch account --}}
    @include('MemberAdmin::account_settings.components.switch_account')
    {{-- end switch account --}}

    {{-- ban_countries --}}
    @include('MemberAdmin::account_settings.components.ban_countries')
    {{-- end ban_countries --}}
@endsection
