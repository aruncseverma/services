@extends('AgencyAdmin::layout')

@section('main.content.title')
    <i class="mdi mdi-account-multiple"></i>&nbsp;{{ $title }}
@endsection

@section('main.content')
    <div class="col-12">
        @include('AgencyAdmin::common.notifications')
    </div>

    <div class="card-columns model-thumbs">
        {{-- new --}}
        @include('AgencyAdmin::escorts.components.add_escort')
        {{-- end list --}}

        {{-- list --}}
        @foreach ($escorts as $escort)
            @include('AgencyAdmin::escorts.components.escort')
        @endforeach
        {{-- end list --}}
    </div>
@endsection
