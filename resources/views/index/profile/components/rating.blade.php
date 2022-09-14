<style>
.rating {
    display: inline-block;
}
.rating i {
    font-size: 16px;
    cursor: pointer;
}
.rating.rating-1 i.rating-1,
.rating.rating-2 i.rating-1,
.rating.rating-2 i.rating-2,
.rating.rating-3 i.rating-1,
.rating.rating-3 i.rating-2,
.rating.rating-3 i.rating-3,
.rating.rating-4 i.rating-1,
.rating.rating-4 i.rating-2,
.rating.rating-4 i.rating-3,
.rating.rating-4 i.rating-4,
.rating.rating-5 i.rating-1,
.rating.rating-5 i.rating-2,
.rating.rating-5 i.rating-3,
.rating.rating-5 i.rating-4,
.rating.rating-5 i.rating-5 {
    color: #f0ce5b;
}
</style>

<div class="rating rating-{{ $rating_value ?? '' }} @if ($rating_name)active @endif" data-rating="{{ $rating_value ?? '' }}">
    <i class="fa fa-star rating-1" data-value="1"></i>
    <i class="fa fa-star rating-2" data-value="2"></i>
    <i class="fa fa-star rating-3" data-value="3"></i>
    <i class="fa fa-star rating-4" data-value="4"></i>
    <i class="fa fa-star rating-5" data-value="5"></i>
    @if ($rating_name)
        <input type="hidden" name="{{ $rating_name ?? '' }}" id="{{ $rating_id ?? '' }}">
    @endif
</div>

@if ($rating_name)
    @pushAssets('post.scripts')
        <script type="text/javascript">
            $(document).ready(function(){
                var $rating_items = $('.rating.active i');
                $rating_items.on('click', function(){
                    $elm = $(this);
                    $new_rating = $elm.attr('data-value');
                    $parent = $elm.closest('.rating');
                    if ($parent) {
                        $current_rating = $parent.attr('data-rating');
                        $parent.removeClass('rating-' + $current_rating);
                        $parent.addClass('rating-' + $new_rating);
                        $parent.attr('data-rating', $new_rating);
                        $parent.find('input[type="hidden"]').val($new_rating);
                    }
                });
            });
        </script>
    @endPushAssets
@endif
