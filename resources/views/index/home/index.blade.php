@extends('Index::layout')

@section('main.content')
{{-- Attributes Filter --}}
@include('Index::home.filter')
{{-- End Attributes Filter--}}

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