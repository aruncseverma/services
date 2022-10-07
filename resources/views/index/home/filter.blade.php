{{-- Basic Filter --}}
<div class="centerwrap clear popupfilter">
    <div class="searchDrop">
        <div id="searchFilter">
            <ul class="resp-tabs-list hor_1">
                <li>Basic</li>
                <li class="onlyMobile">Advanced</li>
                <li class="mobileN">Physical</li>
                <li class="mobileN">Extra</li>
                <li class="mobileN">Languages</li>
                <li>Services</li>
            </ul>
            <div class="resp-tabs-container hor_1 presearchtab">
                <span class="totalRecords">{{$totalRecords}} available records</span>                    
                @include('Index::common.filters.basic')
                @include('Index::common.filters.advance_search')
                @include('Index::common.filters.physical')
                @include('Index::common.filters.extra')
                @include('Index::common.filters.languages')
                @include('Index::common.filters.services')
            </div>
        </div>
    </div>
</div>
@pushAssets('post.scripts')
    <script>
    $(document).ready(function () {		
		$('#searchFilter').easyResponsiveTabs({
            type: 'default',
            width: 'auto',
            fit: true,
            tabidentify: 'hor_1', 
            activate: function(event) {
                var $tab = $(this);
                var $info = $('#nested-tabInfo');
                var $name = $('span', $info);
                $name.text($tab.text());
                $info.show();
            }
        });

        $('#advancedSearch').easyResponsiveTabs({
            type: 'default',
            width: 'auto',
            fit: true,
            tabidentify: 'hor_2',
            activetab_bg: '#fff',
            inactive_bg: '#F5F5F5',
            active_border_color: '#c1c1c1',
            active_content_border_color: '#5AB1D0'
        });
    });
    </script>    
@endPushAssets