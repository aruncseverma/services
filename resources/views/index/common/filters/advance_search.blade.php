{{-- Advance Search --}}
<div class="advancedSearch">
    <div id="advancedSearch">
        <ul class="resp-tabs-list hor_2">
            <li>Physical</li>
            <li>Extra</li>
            <li>Languages</li>
        </ul>
        <div class="resp-tabs-container hor_2">
            @include('Index::common.filters.physical_mobile')
            @include('Index::common.filters.extra_mobile')
            @include('Index::common.filters.language_mobile')         
        </div>
    </div>
</div>

{{-- End Advance Search --}}