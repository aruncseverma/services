<!-- schedule -->
<div class="col-xs-20 col-sm-5 col-sm-push-10 panel-schedule">
    <div class="panel panel-primary"> 
        <div class="panel-heading widget_header widget_accordian_title">
        <a class="btn-minimize"><i class="fa fa-window-minimize"></i></a> 
            <h3 class="panel-title">Schedule</h3> 
        </div>
        <div class="panel-body widget_accordian_content">
            <div class="widget_accordian_content" style="display: block;">
                <ul class="outcall-incall">   
                    <li><span></span><span>From</span><span>Till</span></li>
                    <li><span>Monday</span><span>{{ $schedules['M']->from ?? '00:00' }}</span><span>{{ $schedules['M']->till ?? '00:00' }}</span></li>
                    <li><span>Tuesday</span><span>{{ $schedules['T']->from ?? '00:00' }}</span><span>{{ $schedules['T']->till ?? '00:00' }}</span></li>
                    <li><span>Wednesday</span><span>{{ $schedules['W']->from ?? '00:00' }}</span><span>{{ $schedules['W']->till ?? '00:00' }}</span></li>
                    <li><span>Thursday</span><span>{{ $schedules['TH']->from ?? '00:00' }}</span><span>{{ $schedules['TH']->till ?? '00:00' }}</span></li>
                    <li><span>Friday</span><span>{{ $schedules['F']->from ?? '00:00' }}</span><span>{{ $schedules['F']->till ?? '00:00' }}</span></li>
                    <li><span>Saturday</span><span>{{ $schedules['ST']->from ?? '00:00' }}</span><span>{{ $schedules['ST']->till ?? '00:00' }}</span></li>
                    <li><span>Sunday</span><span>{{ $schedules['SN']->from ?? '00:00' }}</span><span>{{ $schedules['SN']->till ?? '00:00' }}</span></li>
                </ul>
            </div>
        </div>
    </div>
</div>
