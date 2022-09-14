<!-- Review -->
<div class="col-xs-20 panel-review">
    
        <div class="panel panel-primary"> 
            <div class="panel-heading widget_header widget_accordian_title"> 
                <a class="btn-minimize"><i class="fa fa-window-minimize"></i></a>
                <h3 class="panel-title" style="float: left;"">Review</h3> 
                <div class="widget_header-right col-sm-5 col-xs-5"> 
                    <a data-toggle="collapse" href="#review_collapse" role="button" aria-expanded="false" aria-controls="review_collapse" class="bookmelink defualt_btn" >ADD REVIEW</a>
                </div>
            </div>
            <div class="panel-body widget_accordian_content">
                <div class="widget_latestreview-content">
                    <table style="width:100%">                  
                    <thead>                    
                        <tr>                      
                            <th>DATE</th>                      
                            <th>TIME</th>                      
                            <th>USER</th>                      
                            <th>RATING</th>                      
                            <th colspan="2">REVIEW</th>                    
                        </tr>                  
                    </thead>                  
                    <tbody>
                    @forelse ($user->reviews as $review)
                        <tr class="">                      
                            <td data-title="DATE" data-type="text">{{ $review->date ?? '' }}</td>                      
                            <td data-title="TIME" data-type="text">{{ $review->time ?? '' }}</td>                      
                            <td data-title="USER" data-type="text">Ronald</td>                      
                            <td data-title="RATING" data-type="text">
                                {{-- rating --}}
                                    @include('Index::profile.components.rating', ['rating_name' => '', 'rating_value' => (int)$review->rating])
                                {{-- end rating --}}
                            </td>
                            <td data-title="REVIEW" data-type="text"><a href="#">{{ $review->content ?? '' }}</a></td>
                        </tr>
                    @empty
                        <tr>
                            <td colspan="5" align="center">@lang('No data')</td>
                        </tr>
                    @endforelse
                    </tbody>
                </table> 
                </div>
            </div>
        </div> 
</div>
