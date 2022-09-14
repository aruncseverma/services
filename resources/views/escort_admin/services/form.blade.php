@extends('EscortAdmin::layout')

@section('main.content.title')
    <i class="mdi mdi-cash"></i>&nbsp;{{ $title }}
@endsection

@section('main.content')
    <div class="col-lg-12">
        <div class="row">
            {{-- rates --}}
            @include('EscortAdmin::services.components.rates')
            {{-- end rates --}}

            {{-- schedules --}}
            @include('EscortAdmin::services.components.schedules')
            {{-- end schedules --}}
        </div>
    </div>

    {{-- services --}}
    <div class="col-lg-12">
        <div class="row">
            @include('EscortAdmin::services.components.services')
        </div>
    </div>
    {{-- end services --}}
@endsection
