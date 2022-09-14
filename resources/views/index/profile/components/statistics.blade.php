<!-- statistics -->
<div class="col-xs-20 col-md-5 panel-statistics prof-statistics">
    
        <div class="panel panel-primary"> 
            <div class="panel-heading widget_header widget_accordian_title"> 
                <a class="btn-minimize"><i class="fa fa-window-minimize"></i></a>
                <h3 class="panel-title">Statistics</h3> 
            </div>
            <div class="panel-body widget_accordian_content">
                <div class="widget_accordian_content" style="display: block;">
                    <ul>                  
                        <li><span class="col-xs-10">Updated </span>{{ $user->last_update ?? '' }}</li>
                        <li><span class="col-xs-10">Views </span> {{ $totalViews ?? '0' }}</li>
                        <li><span class="col-xs-10">Rating </span>{{ $ratingAverage ?? 0 }} / 5</li>
                        <li><span class="col-xs-10">Followers </span>5/36</li>
                        <li><span class="col-xs-10">Rank </span>{{ $user->rank->rank ?? '--'}}</li>
                        <li><span class="col-xs-10">Agency </span>{{ $user->agency->name ?? '' }}</li> 
                        <li><span class="col-xs-10">Validation: </span>{{ $membership ?? '' }}</li>
                    </ul>
                </div>
            </div> 
        </div>
</div>
