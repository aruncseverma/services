<div class="card col-lg-6">
    <div class="card-header" data-toggle="collapse" data-target="#visitors">
        <div class="card-actions">
            <a class="btn-minimize"><i class="mdi mdi-window-minimize"></i></a>
        </div>
        <span>@lang('Visitors')</span>
        <div class="pull-right currency-drop">
            <select class="selectpicker" data-style="btn-info" onchange="javascript:location.href = this.value;">
                @php($url = route('escort_admin.dashboard'))
                @php($period = app('request')->input('period', 'today'))
                <option  style="display:none">{{ $visitorGraphSelections[$period] ?? '' }}
                @foreach ($visitorGraphSelections as $value => $desc)
                    @if ($period != $value)
                    <option value="{{ $url }}?period={{ $value }}">{{ $desc }}</option>
                    @endif
                @endforeach
            </select>
        </div>
    </div>
    <div class="card-body collapse show" id="visitors">
        <div id="morris-area-chart" style="text-align:center;">
            @if(empty($visitorGraphData))
            <h3>@lang('No data yet to show.')</h3>
            @else
            <div id="morris-area-chart"></div>
            @endif
        </div>
    </div>
</div>

@if(!empty($visitorGraphData))
@pushAssets('styles.post')
<!-- Morris CSS -->
<link href="{{ asset('assets/theme/admin/default/plugins/morrisjs/morris.css') }}" rel="stylesheet">
@endPushAssets

@pushAssets('scripts.post')
<!--Morris JavaScript-->
<script src="{{ asset('assets/theme/admin/default/plugins/raphael/raphael-min.js') }}"></script>
<script src="{{ asset('assets/theme/admin/default/plugins/morrisjs/morris.min.js') }}"></script>

<script type="text/javascript">
    $(function() {
        "use strict";
        Morris.Area({
            element: 'morris-area-chart',
            data: {!! $visitorGraphData['data'] !!},
            xkey: "period",
            ykeys: {!! $visitorGraphData['keys'] !!},
            labels: {!! $visitorGraphData['keys'] !!},
            pointSize: 3,
            fillOpacity: 0,
            pointStrokeColors: ['#55ce63', '#009efb', '#2f3d4a'],
            behaveLikeLine: true,
            gridLineColor: '#e0e0e0',
            lineWidth: 3,
            hideHover: 'auto',
            lineColors: ['#55ce63', '#009efb', '#2f3d4a'],
            resize: true,
            parseTime: false,
            //xLabelAngle: 60, //<-- add this
            gridTextSize: 9,
        });
    });
</script>
@endPushAssets
@endif