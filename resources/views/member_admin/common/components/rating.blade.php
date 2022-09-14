@php
$totalStar = $totalStar ?? 0;
$maxStar = 5;
$totalFullStar = (int)$totalStar;
$totalRemainingStar = $maxStar-$totalFullStar;
$hasHalfStar = $totalStar > $totalFullStar;
if ($hasHalfStar) {
--$totalRemainingStar;
}
$ratingHtml = '';
@endphp

@for ($i = 0; $i < $totalFullStar; $i++)
@php($ratingHtml .= '<i class="mdi mdi-star"></i>')
@endfor

@if($hasHalfStar)
@php($ratingHtml .= '<i class="mdi mdi-star-half"></i>')
@endif

@for ($i = 0; $i < $totalRemainingStar; $i++)
@php($ratingHtml .= '<i class="mdi mdi-star-outline"></i>')
@endfor

{!! $ratingHtml !!}