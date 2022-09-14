@extends('EscortAdmin::layout')

@section('main.content.title')
    <i class="mdi mdi-airplane-landing"></i>&nbsp;{{ $title }}
@endsection

@section('main.content')
    <div class="col-12">
        @include('EscortAdmin::common.notifications')
    </div>

    {{-- add tour --}}
    @include('EscortAdmin::tour_plans.components.add_tour')
    {{-- end add tour --}}

    {{-- my tours --}}
    @include('EscortAdmin::tour_plans.components.my_tours')
    {{-- end my tours --}}

    {{-- edit tour --}}
    @include('EscortAdmin::tour_plans.components.edit_tour')
    {{-- end edit tour --}}

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

    <script type="text/javascript">
        $(document).ready(function(){
            $('#date_start, #date_end, #edit_date_start, #edit_date_end').datepicker({
                autoclose: true,
                todayHighlight: true
            });
        });
    </script>
@endPushAssets
