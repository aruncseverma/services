{{-- Escort Display --}}
@forelse($agency->escorts as $escort)
    <a href="{{ route('index.profile', $escort->username) }}">
    <div class="col-xs-10 col-md-5 col-lg-4 masonryme">
        <div class="col-xs-20 escort-thumb">

            {{-- VIP Checking --}}
            @if($escort->isVip($escort->getKey()))
            <div class="box">
                <div class="ribbon ribbon--red">VIP</div>
            </div>
            @endif
            @if($escort->user_group_id != null)
                @php
                    if ($escort->user_group_id == 1) {
                        $level = "icon_right_01.png";
                        $tag = "Verified Model";
                    } else if ($escort->user_group_id == 2) {
                        $level = "icon_right_02.png";
                        $tag = "Valid Silver Model";
                    } else {
                        $level = "icon_right.png";
                        $tag = "Valid Gold Model";
                    }
                @endphp
                <img src='{!! asset("assets/theme/index/default/images/index/{$level}") !!}' style="position: absolute; right: 10px; top: 17px; z-index: 2" title="{{ $tag }}">
            @endif
            {{-- End VIP Checking --}}

            <div class="row">
                <div class="col-xs-20">
                    <img src="@if($escort->profilePicture != null) {{ $escort->getProfileImage() }} @else https://via.placeholder.com/243x334?text=No%20Image @endif" alt="User Image">
                </div>
                <div class="col-xs-20">
                    <div>
                        <span>{{ $escort->name }}</span>
                    </div>
                    <img src='{{ asset("assets/theme/index/default/images/countries/{$escort->getOriginCodeAttribute()}") }}' alt="Flag">
                </div>
                @php
                    $minPrice = 0;
                    
                    if ($escort->rate != null) {
                        if ($escort->rate->outcall > $escort->rate->incall) {
                            if ($escort->rate->incall == 0) {
                                $minPrice = 'N/A';
                            } else {
                                $minPrice = $escort->rate->incall;
                            }
                        } else {
                            if ($escort->rate->outcall == 0) {
                                $minPRice = 'N/A';
                            } else {
                                $minPrice = $escort->rate->outcall;
                            }
                        }
                    }
                @endphp
                <div class="col-xs-20 thumb-details">
                    <div class="row" style="text-align: left">
                        <span class="col-xs-10">Age: {{ $escort->age == null ? 'N/A' : $escort->age }}</span>
                        <span class="col-xs-10">{{ empty($escort->ethnicity) ? 'No Data' : $escort->ethnicity }}</span>
                        <span class="col-xs-10">{{ empty($escort->mainlocation) ? $escort->origin : $escort->mainlocation->city->name }}</span>
                        <span class="col-xs-10">Min Price: {{ $minPrice }}</span>
                        <span class="col-xs-10">{{ $escort->origin }}</span>
                        <span class="col-xs-10">{{ $escort->serviceType == 'I' ? 'Incall' : ($escort->serviceType == 'O' ? 'Outcall' : 'N/A') }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    </a>
@empty
    <div class="col-xs-12 masonryme">
        <center>
            <h3>@lang('No Escort Found.')</h3>
        </center>
    </div>
@endforelse
{{-- End escort display --}}