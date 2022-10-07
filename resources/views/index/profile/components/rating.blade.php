<div class="reviewRating rating-{{ $rating_value ?? '' }} @if ($rating_name)active @endif" data-rating="{{ $rating_value ?? '' }}">
    <i class="fas fa-star rating-1" data-value="1"></i>
    <i class="fas fa-star rating-2" data-value="2"></i>
    <i class="fas fa-star rating-3" data-value="3"></i>
    <i class="fas fa-star rating-4" data-value="4"></i>
    <i class="fas fa-star rating-5" data-value="5"></i>
    @if ($rating_name)
        <input type="hidden" name="{{ $rating_name ?? '' }}" id="{{ $rating_id ?? '' }}">
    @endif
</div>


