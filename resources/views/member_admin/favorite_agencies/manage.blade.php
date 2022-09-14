@extends('MemberAdmin::layout')

@section('main.content.title')
<i class="mdi mdi-cash"></i>&nbsp;{{ $title }}
@endsection

@section('main.content')

<div class="col-lg-12 col-md-12">
    @include('MemberAdmin::common.notifications')
</div>

@forelse($favorites as $favorite)
<div class="col-lg-4 col-md-12">
    <div class="card">
        <div class="card-body">
            <div class="d-flex flex-row">
                <div class=""><img src="{{ $favorite->agency->profilePhotoUrl ?? $noImageUrl }}" alt="agencylogo" class="img-circle" width="100" height="100"></div>
                <div class="p-l-20">
                    <h3 class="font-medium">{{ $favorite->agency->name }}</h3>
                    <h6>{!! $favorite->agency->origin ?? '&nbsp;' !!}</h6>
                    @if($favorite->agency->follower_id)
                    <button class="btn btn-success es es-redirect" data-href="{{ route('member_admin.favorite_agencies.unfollow', ['id'=> $favorite->agency->follower_id]) }}"><i class="ti-minus"></i> Unfollow</button>
                    @else
                    <button class="btn btn-success es es-redirect" data-href="{{ route('member_admin.favorite_agencies.follow', ['id'=> $favorite->agency->username]) }}"><i class="ti-plus"></i> Follow</button>
                    @endif

                </div>
            </div>
            <div class="row m-t-40">
                <div class="col b-r">
                    <h6>Models</h6>
                    <h2 class="font-light">{{ $favorite->agency->totalEscorts ?? 0 }}</h2>
                </div>
                <div class="col b-r">
                    <h6>Reviews</h6>
                    <h2 class="font-light">{{ $favorite->agency->totalReviews ?? 0 }}</h2>
                </div>
                <div class="col">
                    <h6>Rating</h6>
                    <h2 class="font-light">
                        @include('MemberAdmin::common.components.rating', ['totalStar' => $favorite->agency->rating])
                    </h2>
                </div>
            </div>
        </div>

        <div class="card-body">
            <p class="text-center aboutscroll">{{ $favorite->agency->description->content ?? '' }}</p>
        </div>
    </div>
</div>

<div class="col-lg-12 col-md-12">
    {{ $favorites->links('pagination::member_admin.pagination') }}
</div>
@empty
@include('MemberAdmin::common.components.no_data')
@endforelse

@endsection