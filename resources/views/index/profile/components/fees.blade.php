<!-- fees -->
<div class="col-xs-20 col-sm-5 panel-statistics">
    
        <div class="panel panel-primary"> 
            <div class="panel-heading widget_header widget_accordian_title"> 
                <a class="btn-minimize"><i class="fa fa-window-minimize"></i></a>
                <h3 class="panel-title">Fees</h3> 
            </div>
            <div class="panel-body widget_accordian_content">
                <div class="widget_accordian_content" style="display: block;">
                    <ul class="outcall-incall">
                        <li><span></span><span>Incall</span><span>Outcall</span></li>
                        @forelse ($durations as $duration)
                            <li><span>{{ $duration->description->content ?? '' }}</span><span>{{ $duration->escortRate->incall ?? '--' }}</span><span>{{ $duration->escortRate->outcall ?? '--' }}</span></li>
                        @empty
                            <li>
                                <span>@lang('No data')</span>
                            </li>
                        @endforelse
                    </ul>
                </div>
            </div> 
        </div>
</div>
