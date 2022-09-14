<div class="card col-lg-8">
    <div class="card-header" data-toggle="collapse" data-target="#latestmedia">
        <div class="card-actions">
            <a class="btn-minimize"><i class="mdi mdi-window-minimize"></i></a>
        </div>
        <span>@lang('Latest Media From My Favorite Escorts')</span>
    </div>
    <div class="card-body collapse show" id="latestmedia">
        @if ($latestEscortPhotos->count())
        <div id="carouselExampleIndicators" class="carousel slide" data-ride="carousel">
            <div class="carousel-inner" role="listbox">

                @foreach($latestEscortPhotos as $img)
                <div class="carousel-item @if($loop->first) active @endif" style="max-height:360px;text-align: center;background: #cccccc;">
                    <img style="max-height:360px;width:auto;margin:0 auto;" class="img-responsive" src="{{ $img }}" alt="{{ $loop->index }} slide">
                </div>
                @endforeach

            </div>
            <a class="carousel-control-prev" href="#carouselExampleIndicators" role="button" data-slide="prev"> <span class="carousel-control-prev-icon" aria-hidden="true"></span> <span class="sr-only">Previous</span> </a>
            <a class="carousel-control-next" href="#carouselExampleIndicators" role="button" data-slide="next"> <span class="carousel-control-next-icon" aria-hidden="true"></span> <span class="sr-only">Next</span> </a>
        </div>
        @else
        <h3 class="text-center">@lang('No latest data found.')</h3>
        @endif
    </div>
</div>