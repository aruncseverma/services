@extends('MemberAdmin::layout')

@section('main.content.title')
<i class="mdi mdi-cash"></i>&nbsp;{{ $title }}
@endsection

@section('main.content')

<div class="col-lg-12 col-md-12">
    @include('MemberAdmin::common.notifications')
</div>

@if($favorites->count())
<div class="card-columns model-thumbs">
    @forelse($favorites as $favorite)
    <div class="card">
        <div class="card-body">
            <center>
                <div style="height:180px;width:180px;text-align:center;">
                    <img src="{{ $favorite->escort->profilePhotoUrl ?? $noImageUrl }}" class="es-image" />
                </div>
                <h4 class="card-title m-t-10">{{ $favorite->escort->name }}</h4>
                <h6 class="card-subtitle">
                    @if(!empty($favorite->escort->origin))
                    Escort in {{ $favorite->escort->origin }}
                    @else
                    &nbsp;
                    @endif
                </h6>
                <div class="row text-center justify-content-md-center">
                    <div class="col-6">
                        <a href="javascript:void(0)" class="link">
                            <i class="icon-film"></i>
                            <font class="font-medium">{{ $favorite->escort->totalVideos ?? 0 }}</font>
                        </a>
                    </div>
                    <div class="col-6">
                        <a href="javascript:void(0)" class="link">
                            <i class="icon-picture"></i>
                            <font class="font-medium">{{ $favorite->escort->totalPhotos ?? 0 }}</font>
                        </a>
                    </div>
                </div>
                <div class="m-t-20">
                    <button class="btn btn-circle btn-secondary es es-redirect" data-href="{{ route('member_admin.emails.compose', ['id' => $favorite->escort->username]) }}"><i class="fa fa-envelope-o"></i></button>
                    <button class="btn btn-circle btn-secondary"><i class="mdi mdi-format-quote"></i></button>
                    <button class="btn btn-circle btn-secondary es es-redirect es-confirm" data-href="{{ route('member_admin.favorite_escorts.remove_favorite', ['id'=> $favorite->escort->username]) }}"><i class="mdi mdi-delete-forever"></i></button>
                </div>
            </center>
        </div>
    </div>
    @empty

    @endforelse
</div>

<div class="col-lg-12 col-md-12">
    {{ $favorites->links('pagination::member_admin.pagination') }}
</div>
@else
@include('MemberAdmin::common.components.no_data')
@endif
@endsection