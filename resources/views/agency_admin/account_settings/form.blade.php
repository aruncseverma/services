@extends('AgencyAdmin::layout')

@section('main.content.title')
    <i class="mdi mdi-settings"></i>&nbsp;{{ $title }}
@endsection

@section('main.content')
    {{-- email --}}
    @include('AgencyAdmin::account_settings.components.change_email')
    {{-- end email --}}

    {{-- password --}}
    @include('AgencyAdmin::account_settings.components.change_password')
    {{-- end password --}}

    {{-- newsletter_subscription --}}
    @include('AgencyAdmin::account_settings.components.newsletter_subscription')
    {{-- end newsletter_subscription --}}
@endsection
