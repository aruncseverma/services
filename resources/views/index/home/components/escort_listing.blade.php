
    
    @forelse($escorts as $escort)
        @include('Index::home.components.escort_listing_item', ['escort' => $escort])
    @empty
        <div class="grid-item filter-item">
            <center>
                <h3>@lang('No Escort Found.')</h3>
            </center>
        </div>
    @endforelse
