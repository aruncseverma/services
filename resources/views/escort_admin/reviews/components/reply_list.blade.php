<form action="{{ route('escort_admin.review.seen_reply') }}" method="POST">
@forelse ($review->replies as $reply)
    @if($auth->getKey() != $reply->user_id && !$reply->isSeen())
    <input type="hidden" class="reply-ids" name="ids[]" value="{{ $reply->getKey() }}">
    @endif
    <div class="d-flex flex-row comment-row m-b-5" data-id="{{ $reply->getKey() }}">
        <div class="p-2">
            <span class="round">
                <img src="{{ $reply->user->profilePhotoUrl ?? $noImageUrl }}" alt="user" width="50" class="es-image">
            </span>
        </div>
        <div class="comment-text w-100">
            <h5>{{ $reply->user->name }}</h5>
            <p class="m-b-5">{{ $reply->content }}</p>
        </div>
    </div>
@empty
@endforelse
</form>