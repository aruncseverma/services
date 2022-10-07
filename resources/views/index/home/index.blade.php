@extends('Index::layout')

@section('main.content')
{{-- Attributes Filter --}}
@include('Index::home.filter')
{{-- End Attributes Filter--}}
<div class="topMFilter autoScroll">
    <div class="topMFilterM">
        <ul class="clear">
            <li><a href="{{ route('index.home') }}" @if(Route::current()->getName() == 'index.home') class="active" @endif>ALL ESCORTS</a></li>
            <li><a href="{{ route('index.filter', ['today' => 1]) }}" @if(isset($param['today']) && $param['today']==1 ) class="active" @endif>TODAYS ESCORTS</a></li>
            <li><a href="{{ route('index.filter', ['new' => 1]) }}" @if(isset($param['new']) && $param['new']==1 ) class="active" @endif>NEW ESCORTS</a></li>
            <li><a href="#">TRAVELING ESCORTS</a></li>
            <li><a href="{{ route('index.filter', ['pornstar' => 'Y']) }}" @if(isset($param['pornstar']) && $param['pornstar']=='Y' ) class="active" @endif>PORNSTAR ESCORTS</a></li>
        </ul>
    </div>
</div>
<div class="centerwrap clear">
    <div class="filterLo">
        <div class="genderFilter">
            <button class="femaleG @if(isset($param['gender']) && $param['gender'] == 'F') active @endif"></button>
            <button class="maleG @if(isset($param['gender']) && $param['gender'] == 'M') active @endif"></button>
            <button class="intersexG @if(isset($param['gender']) && $param['gender'] == 'B') active @endif"></button>
            <button class="heteroG @if(isset($param['gender']) && $param['gender'] == 'C') active @endif"></button>
        </div>
        {{-- Escort Location Filter --}}
        @include('Index::common.location_escort')
        {{-- End Escort Location Filter --}}
    </div>
    
    <div class="grid">
        <div class="grid-item stamp2 stamp-nav" style="position:absolute;">
            <ul class="escortFilterD">
                <li><a href="{{ route('index.home') }}" id="all_escort" @if(Route::current()->getName() == 'index.home') class="active" @endif>ALL ESCORTS</a></li>
                <li><a href="{{ route('index.filter', ['today' => 1]) }}" @if(isset($param['today']) && $param['today']==1 ) class="active" @endif>TODAYS ESCORTS</a></li>
                <li><a href="{{ route('index.filter', ['new' => 1]) }}" @if(isset($param['new']) && $param['new']==1 ) class="active" @endif>NEW ESCORTS</a></li>
                <li><a href="#">TRAVELING ESCORTS</a></li>
                <li><a href="{{ route('index.filter', ['pornstar' => 'Y']) }}" @if(isset($param['pornstar']) && $param['pornstar']=='Y' ) class="active" @endif>PORNSTAR ESCORTS</a></li>
            </ul>
        </div>
        {{-- Escort Display --}}
                @include('Index::home.components.escort_listing', ['escorts' => $escorts])
        {{-- End escort display --}}
    </div>
    
</div>


@endsection

@pushAssets('post.scripts')
<script type="text/javascript">
    $(document).ready(function() {

        // $('#country').selectric({
        //     onChange: function() {
        //         var country = $(this).val()
        //         var generatedUrl = '{{ route("index.country", ["country" => "xx"]) }}'
        //         var redirectUrl = generatedUrl.replace(/xx/gi, country)

        //         window.location.href = redirectUrl
        //     }
        // })

        // $('#state').selectric({
        //     onChange: function() {
        //         var country = "{{ isset($param['country']) ? $param['country'] : '' }}"
        //         var state = $(this).val()
        //         var generatedUrl = '{{ route("index.state", ["country" => "xx", "state" => "yy"]) }}'
        //         var redirectUrl = generatedUrl.replace(/xx/gi, country)
        //         redirectUrl = redirectUrl.replace(/yy/gi, state)

        //         window.location.href = redirectUrl
        //     }
        // })

        // $('#city').selectric({
        //     onChange: function() {
        //         var country = "{{ isset($param['country']) ? $param['country'] : '' }}"
        //         var state = "{{ isset($param['state']) ? $param['state'] : '' }}"
        //         var city = $(this).val()
        //         var generateUrl = '{{ route("index.city", ["country" => "xx", "state" => "yy", "city" => "zz"]) }}'
        //         var redirectUrl = generateUrl.replace(/xx/gi, country)
        //         redirectUrl = redirectUrl.replace(/yy/gi, state)
        //         redirectUrl = redirectUrl.replace(/zz/gi, city)

        //         window.location.href = redirectUrl
        //     }
        // })
    })

    // attach token
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    })
</script>
@endPushAssets