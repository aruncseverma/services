@extends('Index::layout')

@pushAssets('header.additional')
@endPushAssets

@section('main.content.title')
    {{ $title }}
@endsection

@section('main.content')

<div class="col-xs-20 col-lg-4 lefttabs" style="margin-bottom: 24px;">
    {{-- my images and vidoes --}}
    @include('Index::agency_profile.components.image')
    {{-- end my images and vidoes --}}
    
    {{-- contact details --}}
    @include('Index::agency_profile.components.contacts')
    {{-- end contact details --}}
</div>

<!-- mid -->
<div class="col-xs-20 col-lg-16">
    <div class="row">
        {{-- agency description --}}
        @include('Index::agency_profile.components.description')
        {{-- end agency description --}}

        <h3>Agency Escorts</h3>
        <hr />
        {{-- escort list --}}
        @include('Index::agency_profile.components.escort')
        {{-- end escort list --}}
    </div>
</div>

@endsection

@pushAssets('header.additional')
    {{-- header --}}
    @include('Index::agency_profile.components.header')
    {{-- end header --}}
@endPushAssets

