@extends('MemberAdmin::layout')

@section('main.content.title')
<i class="mdi mdi-format-quote"></i>&nbsp;{{ $title }}
@endsection

@section('main.content')

<div class="col-12">
    @include('MemberAdmin::common.notifications')
    <div class="card">
        <div class="card-header" data-toggle="collapse" data-target="#allreviews">
            <div class="card-actions">
                <a class="btn-minimize"><i class="mdi mdi-window-minimize"></i></a>
            </div>
            <span>@lang('Reviews')</span>

        </div>
        <div class="card-header-sub">
            @lang('All your reviews status')
        </div>
        <div class="card-body collapse show" id="allreviews">
            @if ($reviews->count())
            <div class="comment-widgets">
                @forelse($reviews as $review)
                <!-- Comment Row -->
                <div class="d-flex flex-row comment-row">
                    <div class="p-2"><span class="round"><img src="{{ $review->object->profilePhotoUrl ?? $noImageUrl }}" alt="user" width="50" height="50"></span></div>
                    <div class="comment-text w-100">
                        <h5>{{ $review->object->name }}</h5>
                        <p class="m-b-5">{{ $review->content ?? '' }}</p>
                        <div class="comment-footer">
                            <span class="text-muted pull-right">{{ Carbon\Carbon::parse($review->date)->format('F d, Y') }}</span>
                            <span class="label label-light-info">{{ $review->status ?? '' }}</span>
                            <span class="action-icons">
                                <a href="javascript:void(0)"><i class="ti-pencil-alt"></i></a>
                                <a href="{{ route('member_admin.reviews.remove', ['id' => $review->getKey()]) }}" class="es es-confirm"><i class="icon-close"></i></a>
                            </span>
                        </div>
                    </div>
                </div>
                @empty
                @lang('No Data Found')
                @endforelse
            </div>

            {{ $reviews->links('pagination::member_admin.pagination') }}
            @else
                @include('MemberAdmin::common.components.no_data')
            @endif
        </div>
    </div>
</div>

@endsection