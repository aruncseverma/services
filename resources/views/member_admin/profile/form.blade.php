@extends('MemberAdmin::layout')

@section('main.content.title')
    <i class="mdi mdi-contacts"></i>&nbsp;{{ $title }}
@endsection

@section('main.content')
    {{-- basic info --}}
    @include('MemberAdmin::profile.components.basic_info')
    {{-- end basic info --}}

    {{-- about --}}
    @include('MemberAdmin::profile.components.about')
    {{-- end about --}}

    {{-- contact information --}}
    @include('MemberAdmin::profile.components.profile_photo')
    {{-- end contact information --}}

    {{-- contact information --}}
    @include('MemberAdmin::profile.components.contact_info')
    {{-- end contact information --}}
@endsection
