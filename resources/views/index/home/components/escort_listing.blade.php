
    <div class="grid-item">
        <ul class="escortFilterD">
            <li><a href="{{ route('index.home') }}" @if(Route::current()->getName() == 'index.home') class="active" @endif>ALL ESCORTS</a></li>
            <li><a href="{{ route('index.filter', ['today' => 1]) }}" @if(isset($param['today']) && $param['today']==1 ) class="active" @endif>TODAYS ESCORTS</a></li>
            <li><a href="{{ route('index.filter', ['new' => 1]) }}" @if(isset($param['new']) && $param['new']==1 ) class="active" @endif>NEW ESCORTS</a></li>
            <li><a href="#">TRAVELING ESCORTS</a></li>
            <li><a href="{{ route('index.filter', ['pornstar' => 'Y']) }}" @if(isset($param['pornstar']) && $param['pornstar']=='Y' ) class="active" @endif>PORNSTAR ESCORTS</a></li>
        </ul>
    </div>
    @forelse($escorts as $escort)
        @include('Index::home.components.escort_listing_item', ['escort' => $escort])
    @empty
        <div class="grid-item filter-items">
            <center>
                <h3>@lang('No Escort Found.')</h3>
            </center>
        </div>
    @endforelse
