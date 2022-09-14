@extends('EscortAdmin::layout')

@section('main.content.title')
    <i class="mdi mdi-account"></i>&nbsp;{{ $title }}
@endsection


@section('main.content')
    <div class="col-lg-12">
        <div class="row">
            @if ($membership == 'silver' || $membership == 'basic')
                {{-- silver --}}
                @include('EscortAdmin::profile_validation.components.silver')
                {{-- end silver --}}
            @endif

            {{-- gold --}}
            @include('EscortAdmin::profile_validation.components.gold')
            {{-- end gold --}}
        </div>
    </div>
@endsection

@pushAssets('scripts.post')
    <script src="{{ asset('assets/theme/admin/default/js/jasny-bootstrap.js') }}"></script>
@endPushAssets
