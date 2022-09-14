<div class="table-responsive">
    <table class="table table-striped">
        <thead>
            <tr>
                <th class="text-uppercase th-small">@lang('Date')</th>
                <th class="text-uppercase th-small">@lang('Time')</th>
                <th class="text-uppercase th-small">@lang('User')</th>
                <th class="text-uppercase th-medium">@lang('Rating')</th>
                <th class="text-uppercase">@lang('Review')</th>
            </tr>
        </thead>

        <tbody>
            @forelse ($reviews as $review)
                <tr>
                    <td>{{ $review->date }}</td>
                    <td>{{ $review->time }}</td>
                    <td>{{ $review->user->name }}</td>
                    <td>
                        @for ($rate = $review->rating; $rate > 0; --$rate)
                            <i class="fa @if ($rate < 1) fa-star-half-full @else fa-star @endif text-warning"></i>
                        @endfor
                    </td>
                    <td>
                        {{ $review->content }}
                        @if ($review->replies->count())
                            <div id="elm_review_replies-{{ $review->getKey() }}" class="collapse reply-list">
                                <form action="{{ route('agency_admin.review.seen_reply') }}" method="POST">
                                @foreach ($review->replies as $reply)
                                    @if($auth->getKey() != $reply->user_id && !$reply->isSeen())
                                    <input type="hidden" class="reply-ids" name="ids[]" value="{{ $reply->getKey() }}">
                                    @endif
                                    <blockquote class="mt-2">
                                        <div class="d-flex flex-row">
                                            <div class="p-2">
                                                <span class="round">
                                                    <img src="{{ $reply->user->profilePhotoUrl ?? $noImageUrl }}" alt="user" width="50">
                                                </span>
                                            </div>
                                            <div class="comment-text w-100">
                                                <h5>{{ $reply->user->name }}</h5>
                                                <p class="m-b-5">{{ $reply->content }}</p>
                                            </div>
                                        </div>
                                    </blockquote>
                                @endforeach
                                </form>
                            </div>
                        @endif
                        <div id="elm_review_reply-{{ $review->getKey() }}" class="collapse">
                            <form method="POST" action="{{ route('agency_admin.review.reply', ['review' => $review->getKey()]) }}" class="es es-validation">
                                @csrf
                                <input type="hidden" name="notify" value="{{ $notify }}">
                                <label for="reply_content_{{ $review->getKey() }}" class="es-required" style="display:none;">Reply Content</label>
                                <textarea class="form-control" name="content" rows="3" id="reply_content_{{ $review->getKey() }}"></textarea>
                                <button type="submit" class="btn btn-outline-danger waves-effect waves-light button-save text-uppercase">@lang('Submit')</button>
                                <button data-toggle="collapse" data-target="#elm_review_reply-{{ $review->getKey() }}" type="button" class="btn btn-outline-secondary waves-effect waves-light button-save-two m-r-10 text-uppercase">@lang('Cancel')</button>
                            </form>
                        </div>
                    </td>
                    <td class="td-icons">
                        <i class="mdi mdi-magnify" data-toggle="collapse" data-target="#elm_review_replies-{{ $review->getKey() }}"></i>
                    </td>
                    <td class="td-icons">
                        <i class="mdi mdi-reply es es-focus" data-toggle="collapse" data-target="#elm_review_reply-{{ $review->getKey() }}" data-focus-id="reply_content_{{ $review->getKey() }}"></i>
                    </td>
                </tr>
            @empty
                @include('AgencyAdmin::common.table.no_results', ['colspan' => 5])
            @endforelse
        </tbody>
    </table>

    {{ $reviews->links('pagination::agency_admin.pagination') }}
</div>
