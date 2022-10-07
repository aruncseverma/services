@php $i=0; @endphp
@forelse ($raviewdata as $review)
    @php $i++; @endphp
    <div class="reviewBlock">
        <div class="reviewTitle">
            <h4>{{ucfirst($review->username)}}</h4>
            <div class="reviewDate">{{ $review->date ?? '' }}</div>
            {{-- rating --}}
                @include('Index::profile.components.rating', ['rating_name' => '', 'rating_value' => (int)$review->rating])
            {{-- end rating --}}
            
        </div>
        <div class="reviewText">{{ $review->content ?? '' }}</div>
        <div class="reviewReply">Hi John, thanks for dropping by and thank you<br>for the 3 stars! xoxo</div>
    </div>
@empty                            
<div class="reviewBlock">
    <div class="reviewText">@lang('No data')</div>                            
</div>
@endforelse
