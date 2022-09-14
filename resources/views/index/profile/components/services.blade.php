<!-- services  -->
<div class="col-xs-20 col-sm-10 col-sm-pull-5 panel-services">
    
        <div class="panel panel-primary"> 
            <div class="panel-heading widget_header widget_accordian_title"> 
                <a class="btn-minimize"><i class="fa fa-window-minimize"></i></a>
                <h3 class="panel-title">Services</h3> 
            </div>
            <div class="panel-body widget_accordian_content">
                <span>STANDARD SERVICES</span>
                <ul>
                    @forelse ($services['standard'] as $service)
                        <li><i class="fa fa-check-square"></i>{{ $service ?? '' }}</li>
                    @empty
                        <li>@lang('No data')</li>
                    @endforelse
                </ul>

                <span>EXTRA SERVICES</span>
                <ul>
                    @forelse ($services['extra'] as $service)
                        <li><i class="fa fa-check-square"></i>{{ $service ?? '' }}</li>
                    @empty
                        <li>@lang('No data')</li>
                    @endforelse
                </ul>
            </div>
        </div>
</div>
