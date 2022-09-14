@extends('AgencyAdmin::layout')

@section('main.content.title')
    <i class="mdi mdi-contacts"></i>&nbsp;{{ $title }}
@endsection

@section('main.content')
    {{-- basic info --}}
    @include('AgencyAdmin::profile.components.basic_info')
    {{-- end basic info --}}

    {{-- about --}}
    @include('AgencyAdmin::profile.components.about')
    {{-- end about --}}

    {{-- contact information --}}
    @include('AgencyAdmin::profile.components.profile_photo')
    {{-- end contact information --}}

    {{-- contact information --}}
    @include('AgencyAdmin::profile.components.contact_info')
    {{-- end contact information --}}
@endsection
