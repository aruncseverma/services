@extends('Index::layout')

@pushAssets('header.additional')
@include('Index::common.location')
@endPushAssets

@section('main.content.title')
    {{ $title }}
@endsection

@section('main.content')
<div class="col-xs-20">
    <div class="row">
        {{-- Sidebar Filter --}}
        <div class="col-xs-12 col-md-5 col-lg-4">
            <ul class="indexnav" style="overflow: auto">
                <li><a href="{{ route('index.home') }}"  @if(Route::current()->getName() == 'index.home') class="active" @endif>All Agency</a></li>
                <li><a href="#">Todays Agency</a></li>
                <li><a href="#">New Agency</a></li>
            </ul>
        </div>
        {{-- End Sidebar Filter --}}

        {{-- Escort Display --}}
        @forelse($agencies as $agency)
            <a href="{{ route('agency.profile', ['username' => $agency->username]) }}">
                <div class="panel col-xs-15">
                    <div class="panel-body">
                        <div class="row">
                            <div class="col-xs-3">
                                <div style="width:100px;height:100px;margin:0 auto;">
                                    <img src="{{ $agency->profilePhotoUrl ?? $noImageUrl }}" alt="user" class="es-image" />
                                </div>
                            </div>
                            <div class="col-xs-17">
                                <div class="caption">
                                    <h3>
                                        {{ $agency->name }} <br />
                                        <small>
                                            <b>Escorts:</b> {{ $agency->getTotalEscorts() }}
                                        </small><br />
                                        @if(!empty($agency->mainLocation->country->name))
                                        <small class="text-danger">
                                            {{ $agency->mainLocation->country->name }} / {{ $agency->mainLocation->city->name }}
                                        </small>
                                        @else
                                        <small class="text-danger">N/A</small>
                                        @endif
                                    </h3>
                                    <br />
                                    <p>{!! ($agency->description != null) ? substr($agency->description->content,0,200) . '...' : 'No description' !!}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </a>
        @empty
            <div class="col-xs-12 masonryme">
                <center>
                    <h3>@lang('No Escort Found.')</h3>
                </center>
            </div>
        @endforelse
        {{-- End escort display --}}
    </div>
</div>
@endsection