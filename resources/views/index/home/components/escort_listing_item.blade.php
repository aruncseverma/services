
    <div class="grid-item">
        <div class="modelPic">
            <div class="topNVip">
                <div class="new">NEW</div>
                {{-- VIP Checking --}}
                @if($escort->isVip($escort->getKey()))
                <div class="vip">VIP</div>
                @endif
                @php
                $tag = '';
                $level = '';
                @endphp
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
                @endif

                <a href="javaScript:void(0)" class="likeModel"><i class="far fa-heart"></i></a>
            </div>            
            <a href="{{ route('index.profile', $escort->username) }}"><img src="@if($escort->profilePicture != null) {{ $escort->profilePicture }} @else https://via.placeholder.com/243x334?text=No%20Image @endif" /></a>
        </div>
        <div class="modelInfo">
            <div class="modelName"><a href="{{ route('index.profile', $escort->username) }}">{{ $escort->name }}</a></div>
            <div class="modelAge">Age: {{ $escort->age == null ? 'N/A' : $escort->age }}</div>
            <div class="modelCheck @if($tag=='Valid Gold Model') goldCheck @endif"><i class="far fa-check-square"></i></div>
        </div>
    </div>
