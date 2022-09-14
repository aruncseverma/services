@extends('MemberAdmin::layout')

@section('main.content.title')
<i class="mdi mdi-comment"></i>&nbsp;{{ $title }}
@endsection

@section('main.content')

<div class="col-12">
    @include('MemberAdmin::common.notifications')
    <div class="card">
        <div class="card-header" data-toggle="collapse" data-target="#allcomments">
            <div class="card-actions">
                <a class="btn-minimize"><i class="mdi mdi-window-minimize"></i></a>
            </div>
            <span>@lang('Comments')</span>
        </div>
        <div class="card-header-sub">
            @lang('All your comments')
        </div>
        <div class="card-body collapse show" id="allcomments">
            @if ($comments->count())
            <div class="comment-widgets">
                @forelse($comments as $comment)
                <!-- Comment Row -->
                <div class="d-flex flex-row comment-row">
                    <div class="p-2"><span class="round"><img src="{{ $comment->escort->profilePhotoUrl ?? $noImageUrl }}" alt="user" width="50" height="50"></span></div>
                    <div class="comment-text w-100">
                        <h5>{{ $comment->escort->name }}</h5>
                        <p class="m-b-5">{{ $comment->content }}</p>
                        <div class="comment-footer">
                            <span class="text-muted pull-right">{{ Carbon\Carbon::parse($comment->created_at)->format('F d, Y') }}</span>
                            @if($comment->status == 'A')
                            <span class="label label-light-success">@lang('Approved')</span>
                            @elseif($comment->status == 'D')
                            <span class="label label-light-danger">@lang('Rejected')</span>
                            @else
                            <span class="label label-light-info">@lang('Pending')</span>
                            @endif
                            <span class="action-icons">
                                <a href="javascript:void(0)"><i class="ti-pencil-alt"></i></a>
                                {{--<a href="javascript:void(0)"><i class="ti-check"></i></a>--}}
                                <a href="{{ route('member_admin.comments.remove', ['id' => $comment->getKey()]) }}" class="es es-confirm"><i class="icon-close"></i></a>
                                @if(!$comment->isHearted())
                                <a href="{{ route('member_admin.comments.add_heart', ['id' => $comment->getKey()]) }}"><i class="ti-heart"></i></a>
                                @else
                                <a href="{{ route('member_admin.comments.remove_heart', ['id' => $comment->getKey()]) }}"><i class="ti-heart text-danger"></i></a>
                                @endif
                            </span>
                        </div>
                    </div>
                </div>
                @empty

                @endforelse
            </div>

            {{ $comments->links('pagination::member_admin.pagination') }}
            @else
                @include('MemberAdmin::common.components.no_data')
            @endif

        </div>
    </div>
</div>

@endsection