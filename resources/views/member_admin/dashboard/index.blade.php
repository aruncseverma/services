@extends('MemberAdmin::layout')

@section('main.content.title')
    <i class="mdi mdi-gauge"></i>&nbsp;{{ $title }}
@endsection

@section('main.content')
    {{-- notification --}}
    @include('MemberAdmin::common.notifications')
    {{-- end notification --}}

    {{-- latest notifications --}}
    @include('MemberAdmin::dashboard.components.latest_notification')
    {{-- end latest notifications --}}

    {{-- latest media --}}
    @include('MemberAdmin::dashboard.components.latest_media')
    {{-- end latest media --}}


    {{-- latest favorite escorts --}}
    @include('MemberAdmin::dashboard.components.favorite_escort_latest')
    {{-- end latest favorite escorts --}}

    {{-- latest favorite agencies --}}
    @include('MemberAdmin::dashboard.components.favorite_agency_latest')
    {{-- end latest favorite agencies --}}
@endsection
