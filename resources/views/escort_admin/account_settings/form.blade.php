@extends('EscortAdmin::layout')

@section('main.content.title')
    <i class="mdi mdi-settings"></i>&nbsp;{{ $title }}
@endsection

@section('main.content')
    {{-- email --}}
    @include('EscortAdmin::account_settings.components.change_email')
    {{-- end email --}}

    {{-- password --}}
    @include('EscortAdmin::account_settings.components.change_password')
    {{-- end password --}}

    {{-- switch_account --}}
    @include('EscortAdmin::account_settings.components.switch_account')
    {{-- end switch_account --}}

    {{-- ban_countries --}}
    @include('EscortAdmin::account_settings.components.ban_countries')
    {{-- end ban_countries --}}

    {{-- newsletter_subscription --}}
    @include('EscortAdmin::account_settings.components.newsletter_subscription')
    {{-- end newsletter_subscription --}}

    {{-- account_deletion --}}
    @include('EscortAdmin::account_settings.components.account_deletion')
    {{-- end account_deletion --}}
@endsection
