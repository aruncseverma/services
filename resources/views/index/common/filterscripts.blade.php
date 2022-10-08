<script type="text/javascript">
$(document).ready(function () {
    
    var $filterUrl = '{{route("index.filter")}}';
    var $locationDataUrl = '{{route("index.locationdata")}}';
    var $physicalfilterUrl = '{{route("index.filterphysicaloption")}}';
    var $basicFilterUrl = '{{route("index.filterbasicoption")}}';
    var $extraFilterUrl = '{{route("index.filterextraoption")}}';
    var $languageFilterUrl = '{{route("index.filterextraoption")}}';
    var $serviceFilterUrl = '{{route("index.filterserviceoption")}}';
    
    var $filterPhysicalMobile = '{{route("index.filtermobilephysicaloption")}}';
    var $filterExtraMobile = '{{route("index.filtermobileextraoption")}}';
    var $filterLanguageMobile = '{{route("index.filtermobilelanguageoption")}}';

    var $filterParams = {};
    var $activeTab = '';
    var $lastclickeditem = '';
    window.location.search
        .replace(/[?&]+([^=&]+)=([^&]*)/gi, function(str, key, value) {
            $filterParams[key] = value;
        });

    var $filterContainer = $('.grid');
    var $filterNav = $('#filter-nav');
    var $links = $('.filter-ajax');

    var $grid = $('.masonrow');
    // minus 4px to escort photo because container has padding
    $minusWidth = 4;

    function fnFilterEscorts(isAll) {
        isAll = typeof isAll !== 'undefined' && isAll != '' ? isAll : false;
        if (isAll) {
            $filterParams = {}; // reset
        }  

        fnAjax({
            url: $filterUrl,
            data: $filterParams,
            success: function(data) {
                if (isAll) {
                    var $filterFullUrl = $('#all_escort').attr('href');
                    $('#all_escort').addClass('active');
                } else {
                    var $filterFullUrl = $filterUrl + '?' + $.param($filterParams);
                    $filterFullUrl = decodeURIComponent($filterFullUrl);
                    $('#all_escort').removeClass('active');
                }
                window.history.pushState("", "", $filterFullUrl);
                if (typeof data.status !== 'undefined') {
                    if (data.status == 1) {
                        var $content = $(data.html);
                        var $images = $content.find('img');
                        $('.totalRecords').html(data.total+' available records');
                        if($filterParams['gender']=='M'){
                            $('.escortG span').text('');                            
                            $('.gm').text(data.total);
                        }

                        if($filterParams['gender']=='F'){  
                            $('.escortG span').text('');                   
                            $('.gf').text(data.total);
                        }

                        if($filterParams['gender']=='B'){  
                            $('.escortG span').text('');                               
                            $('.gb').text(data.total);
                        }
                        
                        if($filterParams['gender']=='C'){  
                            $('.escortG span').text('');                               
                            $('.gh').text(data.total);
                        }

                        // remove all items
                        $filterContainer.find('.filter-item').remove();
                        
                        // append new items
                        $('.grid').append($content).masonry('appended', $content);
                        
                        // find first item container
                        // to calculate max width of image
                        $firstItemContainer = $filterContainer.find('.grid .grid-item:first');
                        $('.grid').masonry('layout');
                    }
                }
            }
        });

        // Load the filter HTML
        if($activeTab == 'physical') {
            fnAjax({
                url: $physicalfilterUrl,
                data: $filterParams,
                success: function(data) {
                    $('#filter_physical').html('');
                    $('#filter_physical').append($(data.html)); 
                    var lis = $("ul.resp-tabs-list > li");
                    lis.removeClass("resp-tab-active");
                    $('.hor_1').removeClass('resp-tab-content-active');
                    $('.hor_1').removeAttr('style');
                    $("ul.resp-tabs-list > li:nth-child(3)").addClass("resp-tab-active"); 
                    $('#filter_physical').addClass('resp-tab-content-active');                  
                }
            });
        }

        if($activeTab == 'physicalM') {
            fnAjax({
                url: $filterPhysicalMobile,
                data: $filterParams,
                success: function(data) {
                    console.log('phyoisacalm');
                    $('#physicalfiltermobile').html('');
                    $('#physicalfiltermobile').append($(data.html));
                    var lis = $("ul.resp-tabs-list > li");
                    lis.removeClass("resp-tab-active");
                    $('.hor_2').removeClass('resp-tab-content-active');
                    $('.hor_2').removeAttr('style');
                    $("ul.resp-tabs-list > li:nth-child(2)").addClass("resp-tab-active"); 
                    $('#extrafiltermobile').addClass('resp-tab-content-active');                 
                }
            });
        }

        if($activeTab == 'basic') {
            fnAjax({
                url: $basicFilterUrl,
                data: $filterParams,
                success: function(data) {
                    $('#basic_search').html('');
                    $('#basic_search').append($(data.html));   
                    var lis = $("ul.resp-tabs-list > li");
                    lis.removeClass("resp-tab-active");
                    $('.hor_1').removeClass('resp-tab-content-active');
                    $('.hor_1').removeAttr('style');
                    $("ul.resp-tabs-list > li:nth-child(1)").addClass("resp-tab-active"); 
                    $('#basic_search').addClass('resp-tab-content-active');              
                }
            });
        }

        if($activeTab == 'extra') {
            fnAjax({
                url: $extraFilterUrl,
                data: $filterParams,
                success: function(data) {
                    $('#filter_extra').html('');
                    $('#filter_extra').append($(data.html));   
                    var lis = $("ul.resp-tabs-list > li");
                    lis.removeClass("resp-tab-active");
                    $('.hor_1').removeClass('resp-tab-content-active');
                    $('.hor_1').removeAttr('style');
                    $("ul.resp-tabs-list > li:nth-child(4)").addClass("resp-tab-active"); 
                    $('#filter_extra').addClass('resp-tab-content-active');                 
                }
            });
        }

        if($activeTab == 'extraM') {
            fnAjax({
                url: $filterExtraMobile,
                data: $filterParams,
                success: function(data) {
                    $('#extrafiltermobile').html('');
                    $('#extrafiltermobile').append($(data.html));  
                    var lis = $("ul.resp-tabs-list > li");
                    lis.removeClass("resp-tab-active");
                    $('.hor_2').removeClass('resp-tab-content-active');
                    $('.hor_2').removeAttr('style');
                    $("ul.resp-tabs-list > li:nth-child(2)").addClass("resp-tab-active"); 
                    $('#extrafiltermobile').addClass('resp-tab-content-active');                  
                }
            });
        }

        if($activeTab == 'language') {
            fnAjax({
                url: $languageFilterUrl,
                data: $filterParams,
                success: function(data) {
                    $('#langfilter').html('');
                    $('#langfilter').append($(data.html));   
                    var lis = $("ul.resp-tabs-list > li");
                    lis.removeClass("resp-tab-active");
                    $('.hor_1').removeClass('resp-tab-content-active');
                    $('.hor_1').removeAttr('style');
                    $("ul.resp-tabs-list > li:nth-child(5)").addClass("resp-tab-active"); 
                    $('#langfilter').addClass('resp-tab-content-active');                 
                }
            });
        }

        if($activeTab == 'languageM') {
            fnAjax({
                url: $filterLanguageMobile,
                data: $filterParams,
                success: function(data) {
                    $('#languageFilterMobile').html('');
                    $('#languageFilterMobile').append($(data.html));   
                    var lis = $("ul.resp-tabs-list > li");
                    lis.removeClass("resp-tab-active");
                    $('.hor_2').removeClass('resp-tab-content-active');
                    $('.hor_2').removeAttr('style');
                    $("ul.resp-tabs-list > li:nth-child(2)").addClass("resp-tab-active"); 
                    $('#extrafiltermobile').addClass('resp-tab-content-active');                 
                }
            });
        }

        if($activeTab == 'service') {
            fnAjax({
                url: $serviceFilterUrl,
                data: $filterParams,
                success: function(data) {
                    $('#langfilter').html('');
                    $('#langfilter').append($(data.html));   
                    var lis = $("ul.resp-tabs-list > li");
                    lis.removeClass("resp-tab-active");
                    $('.hor_1').removeClass('resp-tab-content-active');
                    $('.hor_1').removeAttr('style');
                    $("ul.resp-tabs-list > li:nth-child(5)").addClass("resp-tab-active"); 
                    $('#langfilter').addClass('resp-tab-content-active');                 
                }
            });
        }
        return true;
    }
    
    /*$('#searchFilter').easyResponsiveTabs({
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
    });*/

    $(".escortG input[id^='escortG']").on('click', function(){
        $(".escortG label").removeClass("active");
        $('.'+$(this).attr('id')).addClass("active");
    });

    $(".clientG input[id^='clientG']").on('click', function(){
        $(".clientG label").removeClass("active");
        $('.'+$(this).attr('id')).addClass("active");
    });

    $('.selectBox select').selectric({
        disableOnMobile: false,
        nativeOnMobile: false
    });

    $('.addLangL select, .changeBox select').selectric({
        disableOnMobile: false,
        nativeOnMobile: false
    });

    $(".dropdownBox").click(function() {
        $(".dropdown ul").slideToggle();
        $(this).toggleClass("active");
    });

    $(".dropdown ul li").click(function() {
        var text = $(this).html();
        $(".dropdownBox").html(text);
        $(".dropdownBox").removeClass("active");
        $(".dropdown ul").hide();
    });

    //Price search filter
    $("#priceRange").ionRangeSlider({
        min: 100,
        max: 2000,
        from: 200,
        to: 1500,
        type: "double",
        step: 10,
        prefix: "$",
        onChange: function(obj){
            //console.log(obj);
        },
        onFinish: function(obj){
            //console.log(obj);
            var priceval = obj.from+'-'+obj.to;
            $('#priceRange').val(priceval);
            var $elm = $('#priceRange');
            var $filterName = $elm.attr('name');
            console.log($filterName);
            if (typeof $filterName !== 'undefined' &&
                $filterName != ''
            ) {
                $filterParams[$filterName] = $elm.val();
                $lastclickeditem = 'price';
                $activeTab = 'basic';
                fnFilterEscorts();
            }
        }
    });

    //Age search filter
    $("#ageRange").ionRangeSlider({
        min: 18,
        max: 40,
        from: 20,
        to: 36,
        type: "double",
        step: 1,
        postfix: " yrs old",
        onChange: function(obj){
            //console.log(obj);
        },
        onFinish: function(obj){
            //console.log(obj);
            var ageval = obj.from+'-'+obj.to;
            $('#ageRange').val(ageval);
            var $elm = $('#ageRange');
            var $filterName = $elm.attr('name');
            console.log($filterName);
            if (typeof $filterName !== 'undefined' &&
                $filterName != ''
            ) {
                $filterParams[$filterName] = $elm.val();
                $lastclickeditem = 'age';
                $activeTab = 'basic';
                fnFilterEscorts();
            }
        }
    });

    // Height range slider

    $("#heightRangeE").ionRangeSlider({
        min: 150,
        max: 220,
        from: 160,
        to: 200,
        postfix: " cm",
        type: "double",
        onChange: function(obj){
            //console.log(obj);
        },
        onFinish: function(obj){
            var ageval = obj.from+'-'+obj.to;
            $('#heightRangeE').val(ageval);
            var $elm = $('#heightRangeE');
            var $filterName = $elm.attr('name');
            //console.log($filterName);
            if (typeof $filterName !== 'undefined' &&
                $filterName != ''
            ) {
                $lastclickeditem = $filterName;
                $filterParams[$filterName] = $elm.val();
                $activeTab = 'physical';
                fnFilterEscorts();
            }
        }
    });

    // Height filter mobile
    $("#heightRangeEM").ionRangeSlider({
        min: 150,
        max: 220,
        from: 160,
        to: 200,
        postfix: " cm",
        type: "double",
        onChange: function(obj){
            //console.log(obj);
        },
        onFinish: function(obj){
            var ageval = obj.from+'-'+obj.to;
            $('#heightRangeE').val(ageval);
            var $elm = $('#heightRangeE');
            var $filterName = $elm.attr('name');
            //console.log($filterName);
            if (typeof $filterName !== 'undefined' &&
                $filterName != ''
            ) {
                $lastclickeditem = $filterName;
                $filterParams[$filterName] = $elm.val();
                $activeTab = 'physicalM';
                fnFilterEscorts();
            }
        }
    });

    $('.searchDrop .closeBtn').on('click', function(){
        $('.searchDrop').hide();
        $('body').removeClass("bodyBg");
    });

    // search box
    var $filterSearchText = $('#filter-search-text');
    var $filterSearchBtn = $('#filter-search-btn');
    $filterSearchBtn.click(function() {
        event.preventDefault();
        $filterParams['search'] = $filterSearchText.val();
        fnFilterEscorts();
    });

    $('#basic_search div.escortG').on('click', 'input', function() {
        var $elm = $(this);
        var $filterName = $elm.attr('name');
        
        if (typeof $filterName !== 'undefined' &&
            $filterName != ''
        ) {
            $filterParams[$filterName] = $elm.val();
            $lastclickeditem = $filterName;
            $activeTab = 'basic';
            fnFilterEscorts();
        }
    });

    //Basic filter
    $('#basicRightSearch').on('change', 'select', function() {
        var $elm = $(this);
        var $filterName = $elm.attr('name');
        
        if (typeof $filterName !== 'undefined' &&
            $filterName != ''
        ) {
            $lastclickeditem = $filterName;
            $filterParams[$filterName] = $elm.val();
            $activeTab = 'basic';
            fnFilterEscorts();
        }
    });

    // Physical filter
    $('#filter_physical').on('change', 'select', function() {
        var $elm = $(this);
        var $filterName = $elm.attr('name');
        console.log($filterName);
        console.log($elm.val());
        if (typeof $filterName !== 'undefined' &&
            $filterName != ''
        ) {
            $lastclickeditem = $filterName;
            $filterParams[$filterName] = $elm.val();
            $activeTab = 'physical';
            fnFilterEscorts();
        }
    });

    // Physical filter Mobile
    $('#physicalfiltermobile').on('change', 'select', function() {
        var $elm = $(this);
        var $filterName = $elm.attr('name');
        console.log($filterName);
        console.log($elm.val());
        if (typeof $filterName !== 'undefined' &&
            $filterName != ''
        ) {
            $lastclickeditem = $filterName;
            $filterParams[$filterName] = $elm.val();
            $activeTab = 'physicalM';
            fnFilterEscorts();
        }
    });

    // Extra filter
    $('#filter_extra').on('change', 'select', function() {
        var $elm = $(this);
        var $filterName = $elm.attr('name');
        if (typeof $filterName !== 'undefined' &&
            $filterName != ''
        ) {
            $lastclickeditem = $filterName;
            $filterParams[$filterName] = $elm.val();
            $activeTab = 'extra';
            fnFilterEscorts();
        }
    });
    // Extra filter Mobile
    $('#extrafiltermobile').on('change', 'select', function() {
        var $elm = $(this);
        var $filterName = $elm.attr('name');
        if (typeof $filterName !== 'undefined' &&
            $filterName != ''
        ) {
            $lastclickeditem = $filterName;
            $filterParams[$filterName] = $elm.val();
            $activeTab = 'extraM';
            fnFilterEscorts();
        }
    });

    $('#addlanguagenutton').on('click', function(){
        var selectedlang = $("#filter_languages option:selected").text();
        $('.langclear').append('<li><a href="#">'+selectedlang+'<span>X</span></a></li>');
    });

    // Languages filter     
    $('#filter_languages').on('change',function() {            
        var $filterName = 'lang_ids';
        var $langSelected = [];
        $("#filter_languages option:selected").each(function() {
            $langSelected.push($(this).val());
        });
        $lastclickeditem = $filterName;
        $filterParams[$filterName] = $langSelected.join(',');
        $activeTab = 'language';
        fnFilterEscorts();
    });        

    //Languages mobile filter
    $('#languageFilterMobile').on('change',function() {            
        var $filterName = 'lang_ids';
        var $langSelected = [];
        $("#languageFilterMobile option:selected").each(function() {
            $langSelected.push($(this).val());
        });
        $lastclickeditem = $filterName;
        $filterParams[$filterName] = $langSelected.join(',');
        $activeTab == 'languageM'
        fnFilterEscorts();
    });

    // Escort Services filter
    $('#filter_escort_services').on('change', function() {            
        var $filterName = 'escort_service_ids';
        var $optSelected = [];
        $("#filter_escort_services option:selected").each(function() {
            $optSelected.push($(this).val());
        });
        $lastclickeditem = $filterName;
        $filterParams[$filterName] = $optSelected.join(',');
        $activeTab = 'service';
        fnFilterEscorts();
    });

    $('#addescortservice').on('click', function(){
        var selectedlang = $("#filter_escort_services option:selected").text();
        $('.escortservicellist').append('<li><a href="#">'+selectedlang+'<span>X</span></a></li>');
    });

    // Erotic Services filter
    $('#filter_erotic_services').on('change', function() {            
        var $filterName = 'erotic_service_ids';
        var $optSelected = [];
        $("#filter_erotic_services option:selected").each(function() {
            $optSelected.push($(this).val());
        });
        $lastclickeditem = $filterName;
        $filterParams[$filterName] = $optSelected.join(',');
        $activeTab = 'service';
        fnFilterEscorts();
    });

    $('#addEroticServiceBtn').on('click', function(){
        var selectedlang = $("#filter_erotic_services option:selected").text();
        $('.eroticservicellist').append('<li><a href="#">'+selectedlang+'<span>X</span></a></li>');
    });

    // Extra Services filter
    $('#filter_extra_services').on('change', function() {
        var $filterName = 'extra_service_ids';
        var $optSelected = [];
        $("#filter_extra_services option:selected").each(function() {
            $optSelected.push($(this).val());
        });
        $lastclickeditem = $filterName;
        $filterParams[$filterName] = $optSelected.join(',');
        $activeTab = 'service';
        fnFilterEscorts();
    });

    $('#addExtraServiceBtn').on('click', function(){
        var selectedlang = $("#filter_extra_services option:selected").text();
        $('.extraservicelist').append('<li><a href="#">'+selectedlang+'<span>X</span></a></li>');
    });

    // Fetish Services filter
    $('#filter_fetish_services').on('change', function() {            
        var $filterName = 'fetish_service_ids';
        var $optSelected = [];
        $("#filter_fetish_services option:selected").each(function() {
            $optSelected.push($(this).val());
        });
        $lastclickeditem = $filterName;
        $filterParams[$filterName] = $optSelected.join(',');
        $activeTab = 'service';
        fnFilterEscorts();
    });

    $('#addFetishServiceBtn').on('click', function(){
        var selectedlang = $("#filter_fetish_services option:selected").text();
        $('.fetishservicellist').append('<li><a href="#">'+selectedlang+'<span>X</span></a></li>');
    });

    // main filter - set active design
    $('#filtermain .dropdown ul').on('click', 'li', function() {
        var $elm = $(this);
        console.log($elm);
        $elm.closest('ul').find('li').removeClass('active');
        $elm.addClass('active');
    });

    //services filter reset
    $('#serviceresetbtn').on('click', function(){
        $('#filter_escort_services').val('').selectric('refresh');
        $('#filter_erotic_services').val('').selectric('refresh');
        $('#filter_fetish_services').val('').selectric('refresh');
        $('#filter_extra_services').val('').selectric('refresh');
        
        $('#servfilterlist span.fNumber').html('');
        $('ul.clear').empty();

        $lastclickeditem = '';
        $filterParams = {};
        fnFilterEscorts();
    });

    //physical filter reset
    $('#physicalresetbtn').on('click', function(){
        $('#hair_color').val('').selectric('refresh');
        $('#cup_size').val('').selectric('refresh');
        $('#body_type').val('').selectric('refresh');
        $('#hair_length').val('').selectric('refresh');
        $('#eye_color').val('').selectric('refresh');
        $('#public_hair').val('').selectric('refresh');
        $('#filter_physical span.fNumber').html('');
        $lastclickeditem = '';
        $filterParams = {};
        fnFilterEscorts();
    });

    //basic filter reset
    $('#basicresetbtn').on('click', function(){
        $('#filter-search-text').val('');            
        $('.escortG label').removeClass('active');            
        $('.clientG label').removeClass('active');            
        $('#ethnicity').val('').selectric('refresh');            
        $('#service_type').val('').selectric('refresh');            
        $('#verification').val('').selectric('refresh'); 
        $('#basic_search span.fNumber').html(''); 
        $('#basic_search span.Onumber').html(''); 
        $lastclickeditem = '';          
        $filterParams = {};
        fnFilterEscorts();
    });

    //extra filter reset
    $('#extraresetbtn').on('click', function(){
        $('#escort_type').val('').selectric('refresh');            
        $('#origin').val('').selectric('refresh');            
        $('#travel').val('').selectric('refresh');            
        $('#smoke').val('').selectric('refresh');            
        $('#drink').val('').selectric('refresh');            
        $('#with_video').val('').selectric('refresh');           
        $('#has_reviews').val('').selectric('refresh');
        $('#filter_extra span.fNumber').html('');
        $lastclickeditem = '';        
        $filterParams = {};
        fnFilterEscorts();
    });

    //language filter reset
    $('#resetLanguageFilter').on('click', function(){
        $('#filter_languages').val('').selectric('refresh'); 
        $('#langfilter span.fNumber').html('');
        $('ul.langclear').empty();
        $lastclickeditem = '';        
        $filterParams = {};
        fnFilterEscorts();
    });

    //location filter reset
    $('#locationresetbtn').on('click', function(){
        //reset continent
        $('#filter_continent').val('').selectric('refresh');            

        //reset country
        $countryHtml = '<option value="">Country</option>';
        $('#filter_country').prop('disabled', true);
        $('#filter_country').html($countryHtml).selectric('refresh');            

        //reset state
        $stateHtml = '<option value="">State</option>';
        $('#filter_state').prop('disabled', true);
        $('#filter_state').html($stateHtml).selectric('refresh');            

        //reset city
        $cityHtml = '<option value="">City</option>';
        $('#filter_city').prop('disabled', true);
        $('#filter_city').html($cityHtml).selectric('refresh');  
        $lastclickeditem = '';
        $filterParams = {};
        $('.escortArea span').html('Amsterdam, NL');
        fnFilterEscorts();
    });
});
</script>