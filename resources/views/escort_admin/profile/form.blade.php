@extends('EscortAdmin::layout')

@section('main.content.title')
    <i class="mdi mdi-account-multiple"></i>&nbsp;{{ $title }}
@endsection

@section('main.content')
    <div class="col-12">
        @include('EscortAdmin::common.notifications')
    </div>

    {{-- basic info --}}
    @include('EscortAdmin::profile.components.basic_information')
    {{-- end basic info --}}

    {{-- about me --}}
    @include('EscortAdmin::profile.components.about_me')
    {{-- end about me --}}

    {{-- location --}}
    @include('EscortAdmin::profile.components.location')
    {{-- end location --}}

    {{-- language proficiency --}}
    @include('EscortAdmin::profile.components.language_proficiency')
    {{-- end language proficiency --}}

    {{-- contact info --}}
    @include('EscortAdmin::profile.components.contact_information')
    {{-- end contact info --}}

    {{-- physical info --}}
    @include('EscortAdmin::profile.components.physical_information')
    {{-- end physical info --}}

    {{-- locality --}}
    @include('EscortAdmin::profile.components.locality')
    {{-- end locality --}}

</div>
@endsection

@pushAssets('scripts.post')
    <!-- Date picker plugins css -->
    <link href="{{ asset('assets/theme/admin/default/plugins/bootstrap-datepicker/bootstrap-datepicker.min.css') }}" rel="stylesheet" type="text/css" />
@endPushAssets

@pushAssets('scripts.post')
    <script src="{{ asset('assets/theme/admin/default/plugins/bootstrap-select/bootstrap-select.min.js') }}"></script>
    <!-- Date Picker Plugin JavaScript -->
    <script src="{{ asset('assets/theme/admin/default/plugins/bootstrap-datepicker/bootstrap-datepicker.min.js') }}">
    </script>
    <!-- google maps api -->
    <script src="http://maps.google.com/maps/api/js?sensor=true"></script>
    <script src="{{ asset('assets/theme/admin/default/plugins/gmaps/gmaps.min.js') }}"></script>

    <script type="text/javascript">
        $(document).ready(function(){
            $('#birthdate').datepicker({
                autoclose: true,
                todayHighlight: true,
                yearRange: '-99:-18'
            });

            var $geo_location_lat = $('#geo_location_lat');
            var $geo_location_long = $('#geo_location_long');

            // default latitude and longtitude
            var $geolat = -12.043333;
            var $geolng = -77.028333;

            if ($geo_location_lat.val() != '') {
                $geolat = $geo_location_lat.val();
            }

            if ($geo_location_long.val() != '') {
                $geolng = $geo_location_long.val();
            }

            var map = new GMaps({
                el: '#geo_location',
                lat: $geolat,
                lng: $geolng,
                  click: function(e) {
                    var lat = e.latLng.lat();
                    var lng = e.latLng.lng();

                    $geo_location_lat.val(lat);
                    $geo_location_long.val(lng);

                    map.removeMarkers();
                    map.setCenter(lat, lng);

                    map.addMarker({
                        lat: lat,
                        lng: lng,
                        title: 'Lima',
                        click: function(e) {
                            //
                        }
                    });
                    },
                    dragend: function(e) {
                        //alert('dragend');
                    }
            });

            if ($geolat != '' && $geolng != '') {
                map.addMarker({
                    lat: $geolat,
                    lng: $geolng,
                    title: 'Lima',
                    click: function(e) {
                        //
                    }
                });
                map.setCenter($geolat, $geolng);
            }
            // map.drawOverlay({
            //     lat: map.getCenter().lat(),
            //     lng: map.getCenter().lng(),
            //     layer: 'overlayLayer',
            //     content: '<div class="gmaps-overlay">Your Location<div class="gmaps-overlay_arrow above"></div></div>',
            //     verticalAlign: 'top',
            //     horizontalAlign: 'center'
            // });
        });
    </script>
@endPushAssets
