<div class="card col-lg-4">
    <div class="card-header" data-toggle="collapse" data-target="#latest_notification">
        <div class="card-actions">
            <a class="btn-minimize"><i class="mdi mdi-window-minimize"></i></a>
        </div>
        <span>@lang('Latest Notification')</span>
    </div>
    <div class="card-body collapse show" id="latest_notification">
        <div class="message-box">
            <div class="message-widget">
                @if ($latestEmails)
                <a href="{{ route('member_admin.emails.manage') }}">
                    <div class="user-img"><span class="round bg-primary"><i class="mdi mdi-email"></i></span></div>
                    <div class="mail-contnet">
                        <h5>{{ __('You have :total new messages', ['total' => $latestEmails->count()]) }}</h5>
                        <span class="mail-desc">
                            @foreach($latestEmails as $email)
                                @if($loop->first)
                                    @php($time=$email->time)
                                @endif
                            {{ $email->sender->name ?? '' }} @if(!$loop->last),@endif
                            @endforeach
                        </span>
                        @if(isset($time))
                        <span class="time">{{ $time ?? '' }}</span>
                        @endif
                    </div>
                </a>
                @endif
                <!-- Message -->
                <a href="#" class="es es-alert" data-alert-text="No function yet.">
                    <div class="user-img"><span class="round"><i class="mdi mdi-comment-check-outline"></i></span></div>
                    <div class="mail-contnet">
                        <h5>15 New comments</h5> <span class="mail-desc">Jhonny : Hey this stuff is awesome and how can i ..</span> <span class="time">9:02 AM</span>
                    </div>
                </a>
                @if ($latestReviewReplies)
                <a href="{{ route('member_admin.reviews') }}">
                    <div class="user-img"><span class="round bg-danger"><i class="mdi mdi-format-quote"></i></span></div>
                    <div class="mail-contnet">
                        <h5>{{ __(':total New review reply', ['total' => $latestReviewReplies->count()]) }}</h5>
                        
                            @foreach($latestReviewReplies as $review)
                                @if($loop->first)
                                    <span class="mail-desc">
                                    {{ $review->object->name ?? '' }}:
                                    @foreach($review->replies as $reply)
                                        @if($loop->first)
                                            {{ $reply->content ?? '' }}
                                            </span>
                                            <span class="time">{{ $reply->time ?? '' }}</span>
                                        @endif
                                    @endforeach
                                @endif
                            @endforeach
                    </div>
                </a>
                @endif
            </div>
        </div>
    </div>
</div>