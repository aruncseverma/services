<!-- Tour -->
<div class="col-xs-20 panel-tour prof-tour">
    <div class="panel panel-primary"> 
        <div class="panel-heading widget_header widget_accordian_title"> 
            <a class="btn-minimize"><i class="fa fa-window-minimize"></i></a>
            <h3 class="panel-title">Tour</h3> 
        </div>
        <div class="panel-body widget_accordian_content">
            <div class="widget_latestreview-content tourplan-content"> 
                <table style="width:100%">                  
                    <thead>                    
                        <tr>                      
                            <th>START</th>                      
                            <th>END</th>                      
                            <th>COUNTRY</th>                      
                            <th>STATE</th>                      
                            <th>CITY</th>     
                            <th>PHONE</th>               
                        </tr>                  
                    </thead>                  
                    <tbody>
                        @forelse ($user->tourPlans as $tourPlan)
                            <tr class="">                      
                                <td data-title="DATE" data-type="text">{{ $tourPlan->date_start ?? '' }}</td>                      
                                <td data-title="TIME" data-type="text">{{ $tourPlan->date_end ?? '' }}</td>
                                <td data-title="USER" data-type="text">{{ $tourPlan->country->name ?? '' }}</td>
                                <td data-title="RATING" data-type="text">{{ $tourPlan->state->name ?? '' }}</td>
                                <td data-title="REVIEW" data-type="text">{{ $tourPlan->city->name ?? '' }}</td>
                                <td data-title="REVIEW" data-type="text">{{ $tourPlan->telephone ?? '' }}</td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="6" align="center">@lang('No data')</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table> 
            </div>
        </div>
    </div> 
</div>
