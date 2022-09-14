@if (isset($rating) && !empty($rating))
    @php ($whole = (int)$rating)
    @php ($decimal = $rating-$whole)
    @php ($max = 5)
    @php ($extra = (int)($max-$rating))

    @for ($i = 0; $i < $whole; $i++)
        <i class="fa fa-star text-warning"></i>
    @endfor

    @if ($decimal > 0)
        <i class="fa fa-star-half-full text-warning"></i>
    @endif
    @if ($extra > 0)
        @for ($i = 0; $i < $extra; $i++)
            <i class="fa fa-star text-muted"></i>
        @endfor
    @endif
@endif
