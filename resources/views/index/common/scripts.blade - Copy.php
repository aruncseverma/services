<script src="{{ asset('assets/theme/index/default/js/index/jquery.min.js') }}"></script>
<script src="{{ asset('assets/theme/index/default/js/index/modernizr.custom.js') }}"></script>
<script src="{{ asset('assets/theme/index/default/js/index/masonry.pkgd.min.js') }}"></script>
<script src="{{ asset('assets/theme/index/default/js/index/general.js') }}"></script>
<script src="{{ asset('assets/theme/index/default/js/index/easyResponsiveTabs.js') }}"></script>
<script src="{{ asset('assets/theme/index/default/js/index/jquery.jscrollpane.min.js') }}"></script>
<script src="{{ asset('assets/theme/index/default/js/index/ion.rangeSlider.min.js') }}"></script>
<script src="{{ asset('assets/theme/index/default/js/index/jquery.selectric.min.js') }}"></script>
<script src="{{ asset('assets/theme/index/default/js/helper.js') }}"></script>
<script src="{{ asset('assets/theme/index/default/js/index/jquery.vEllipsis.min.js') }}"></script>
<script src="{{ asset('assets/theme/index/default/js/index/jquery.fancybox.min.js') }}"></script>
<script>
$(document).ready(function(){
	$('.grid').masonry({
        itemSelector: '.grid-item',
        stamp : '.stamp2',
        gutter:0
    });


	$(window).load(function(){
		$('.grid').masonry({
		  itemSelector: '.grid-item',
          stamp : '.stamp2',
		  gutter:0
		});
	})
	
	$('.resNavB').on('click', function(){
		$(this).toggleClass('active');
		$('.mobileMenu').toggle();
		$('body').toggleClass('ovHide');
		$('body').removeClass("bodyBg");
		$('body').removeClass("bodychangeBg");
		$('.searchDrop').hide();
		$('.changeLocation').hide();
	})
	
	//Auto Scroll JS
	$(function()
	{$('.autoScroll').each(function()
	{$(this).jScrollPane({showArrows:$(this).is('.arrow')});var api=$(this).data('jsp');var throttleTimeout;$(window).bind('resize',function()
	{if(!throttleTimeout){throttleTimeout=setTimeout(function()
	{api.reinitialise();throttleTimeout=null},50)}})})})
	
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
	
	$('.loginPopup').on('click', function(){
		$('.loginArea').toggle();
		$('body').toggleClass("bodyloginBg");
		$('body').removeClass("bodychangeBg");
		$('body').removeClass('bodyBg');
		$('.searchDrop').hide();
		$('.changeLocation').hide();
	});
	
	$('.changeLo').on('click', function(){
		$('.changeLocation').show();
		$('body').addClass("bodychangeBg");
		$('body').removeClass('bodyloginBg');
		$('body').removeClass('bodyBg');
	});
	$('.changeLocation .closeBtn').on('click', function(){
		$('.changeLocation').hide();
		$('body').removeClass("bodychangeBg");
	});
	
	$('.searchID').on('click', function(){
		$('.searchDrop').toggle();
		$('.loginArea').hide();
		$('.changeLocation').hide();
		$('body').toggleClass("bodyBg");
		$('body').removeClass('ovHide');
		$('body').removeClass('bodyloginBg');
		$('body').removeClass("bodychangeBg");
		$('.mobileMenu').hide();
		$('.resNavB').removeClass("active");
	});
	$('.searchDrop .closeBtn').on('click', function(){
		$('.searchDrop').hide();
		$('body').removeClass("bodyBg");
	});
	
	$('.forgotPassword').on('click', function(){
		$('.accRecovery').show();
		$('.loginSection').hide();
	});
	$('.recoverPass').on('click', function(){
		$('.emailsent').show();
		$('.accRecovery').hide();
	});
	$('.login').on('click', function(){
		$('.emailsent').hide();
		$('.loginSection').show();
	});
	
	$('.forgot').on('click', function(){
		$('.arM').show();
		$('.loginAreaM').hide();
	});
	$('.recoverMPBtn').on('click', function(){
		$('.thanku').show();
		$('.recoverMPass').hide();
	})
	$('.loginMPBtn').on('click', function(){
		$('.loginAreaM').show();
		$('.arM').hide();
	});
	$('.submitM').on('click', function(){
		$('.loginAreaM').hide();
		$('.welcomeMBox').show();
		$('.notMember').hide();
	});
	
	$('.likeModel i').on('click', function(e) {
		e.stopPropagation();
		$(this).toggleClass('fas');
	});
	$('.eFilters li a').on('click', function(e) {
		e.stopPropagation();
		$(this).parent().hide();
	});

	/* Profile Page Scripts */

	$(".agencyContact input[id^='option']").on('click', function(){
		$(".agencyContact label").removeClass("active");
		$('.'+$(this).attr('id')).addClass("active");
	});
	$(".followUs input[id^='follow']").on('click', function(){
		$(".followUs label").removeClass("active");
		$('.'+$(this).attr('id')).addClass("active");
	});
	$('.contactAgency').on('click', function(){
		$('.caInfo').show();
		$(this).addClass("active");
		$('body').addClass("bodybookBg");
	});
	$('.closeContact').on('click', function(){
		$('.caInfo').hide();
		$('.contactAgency').removeClass("active");
		$('body').removeClass("bodybookBg");
	});
	
	$().vEllipsis({
		'lines':3, 
		'responsive': true,
		'expandLink': true,
		'collapseLink': true,
		'animationTime': '500', 
	
	});
	
	$('.pPrices .pTitle i').on('click', function(){
		$('.pPrices').toggleClass('togglebox');
	});
	$('.allServicesArea .pTitle i').on('click', function(){
		$('.allServicesArea').toggleClass('togglebox');
	});
	$('.availability .pTitle i').on('click', function(){
		$('.availability').toggleClass('togglebox');
	});
	$('.perInfo .pTitle i').on('click', function(){
		$('.perInfo').toggleClass('togglebox');
	});
	$('.reviews .pTitle i').on('click', function(){
		$('.reviews').toggleClass('togglebox');
	});
	$('.addReview').on('click', function(){
		$('.reviewPopup').show();
		$('body').addClass("reviewBg");
	});
	$('.reviewClose').on('click', function(){
		$('.reviewPopup').hide();
		$('body').removeClass("reviewBg");
	});
	
	$('.reviewPopup select').selectric({
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

	//Jquery Cookie:
	!function(a){var b=!1;if("function"==typeof define&&define.amd&&(define(a),b=!0),"object"==typeof exports&&(module.exports=a(),b=!0),!b){var c=window.Cookies,d=window.Cookies=a();d.noConflict=function(){return window.Cookies=c,d}}}(function(){function a(){for(var a=0,b={};a<arguments.length;a++){var c=arguments[a];for(var d in c)b[d]=c[d]}return b}function b(c){function d(b,e,f){var g;if("undefined"!=typeof document){if(arguments.length>1){if(f=a({path:"/"},d.defaults,f),"number"==typeof f.expires){var h=new Date;h.setMilliseconds(h.getMilliseconds()+864e5*f.expires),f.expires=h}try{g=JSON.stringify(e),/^[\{\[]/.test(g)&&(e=g)}catch(a){}return e=c.write?c.write(e,b):encodeURIComponent(String(e)).replace(/%(23|24|26|2B|3A|3C|3E|3D|2F|3F|40|5B|5D|5E|60|7B|7D|7C)/g,decodeURIComponent),b=encodeURIComponent(String(b)),b=b.replace(/%(23|24|26|2B|5E|60|7C)/g,decodeURIComponent),b=b.replace(/[\(\)]/g,escape),document.cookie=[b,"=",e,f.expires?"; expires="+f.expires.toUTCString():"",f.path?"; path="+f.path:"",f.domain?"; domain="+f.domain:"",f.secure?"; secure":""].join("")}b||(g={});for(var i=document.cookie?document.cookie.split("; "):[],j=/(%[0-9A-Z]{2})+/g,k=0;k<i.length;k++){var l=i[k].split("="),m=l.slice(1).join("=");'"'===m.charAt(0)&&(m=m.slice(1,-1));try{var n=l[0].replace(j,decodeURIComponent);if(m=c.read?c.read(m,n):c(m,n)||m.replace(j,decodeURIComponent),this.json)try{m=JSON.parse(m)}catch(a){}if(b===n){g=m;break}b||(g[n]=m)}catch(a){}}return g}}return d.set=d,d.get=function(a){return d.call(d,a)},d.getJSON=function(){return d.apply({json:!0},[].slice.call(arguments))},d.defaults={},d.remove=function(b,c){d(b,"",a(c,{expires:-1}))},d.withConverter=b,d}return b(function(){})});

	jQuery(function($) {
		var warningpopup_cookie = 'warningpopup_2052018';
		var check_cookie_value = Cookies.get(warningpopup_cookie);

		$(document).on('click', 'a.enter', function (e) {
			e.preventDefault();
			$('#warningpopup').fadeOut(500, function() { $('#warningpopup').remove();$("body").removeClass('warningOpen'); } );
			
			
			Cookies.set(warningpopup_cookie, 'true', { expires: 30, path: '/', domain: '' });
		});
		if (check_cookie_value === undefined || check_cookie_value === null) {
			$('#warningpopup').show();
			$("body").addClass('warningOpen');
		} else {
			$('#warningpopup').remove();
			$("body").removeClass('warningOpen');
		}
	});

	$('#profilePV').easyResponsiveTabs({
            type: 'default', //Types: default, vertical, accordion
            width: 'auto', //auto or any width like 600px
            fit: true, // 100% fit in a container
            closed: 'accordion', // Start closed if in accordion view
            tabidentify: 'mypv', // The tab groups identifier
        });
		
		$('#inOutCall').easyResponsiveTabs({
            type: 'default', //Types: default, vertical, accordion
            width: 'auto', //auto or any width like 600px
            fit: true, // 100% fit in a container
            closed: 'accordion', // Start closed if in accordion view
            tabidentify: 'ioCall', // The tab groups identifier
        });
		
		$('#allServices').easyResponsiveTabs({
            type: 'default', //Types: default, vertical, accordion
            width: 'auto', //auto or any width like 600px
            fit: true, // 100% fit in a container
            closed: 'accordion', // Start closed if in accordion view
            tabidentify: 'efServices', // The tab groups identifier
        });
		$('#allServicesM').easyResponsiveTabs({
            type: 'default', //Types: default, vertical, accordion
            width: 'auto', //auto or any width like 600px
            fit: true, // 100% fit in a container
            closed: 'accordion', // Start closed if in accordion view
            tabidentify: 'efServicesM', // The tab groups identifier
        });
		
		$('#pInfo').easyResponsiveTabs({
            type: 'default', //Types: default, vertical, accordion
            width: 'auto', //auto or any width like 600px
            fit: true, // 100% fit in a container
            closed: 'accordion', // Start closed if in accordion view
            tabidentify: 'personalI', // The tab groups identifier
        });

})    
</script>
<script src="{{ asset('assets/theme/index/default/plugins/waitForImages-master/dist/jquery.waitforimages.min.js') }}"></script>

<script type="text/javascript">
    $(document).on({
        ajaxStart: function(){
            $("#overlay").show(); 
        },
        ajaxStop: function(){ 
            setTimeout(function(){
                $("#overlay").fadeOut(300);
            },500); 
        }    
    });
    $(document).ready(function() {
        var $filterUrl = '{{route("index.filter")}}';
        var $locationDataUrl = '{{route("index.locationdata")}}';
        var $filterParams = {};
        var $lastclickeditem = '';
        window.location.search
            .replace(/[?&]+([^=&]+)=([^&]*)/gi, function(str, key, value) {
                $filterParams[key] = value;
            });

        var $filterContainer = $('.grid');
        var $filterNav = $('#filter-nav');
        var $links = $('.filter-ajax');
        
        function fnResetFilter() {

            // reset search box
            $('#filter-search-text').val('');
            // remove active in gender area
            $('.gender-area a').removeClass('active');
            // remove active in sidebar
            $('#filter-nav a').removeClass('active');

            // Basic
            $('#filter_basic').find('select').val('').selectric('refresh');
            // Physical
            $('#filter_physical').find('select').val('').selectric('refresh');
            // Languages
            $('#filter_languages').find(':checkbox').prop('checked', false);
            // Escort Services
            $('#filter_escort_services').find(':checkbox').prop('checked', false);
            // Erotic Services
            $('#filter_erotic_services').find(':checkbox').prop('checked', false);
            // Extra Services
            $('#filter_extra_services').find(':checkbox').prop('checked', false);
            // Fetish Services
            $('#filter_fetish_services').find(':checkbox').prop('checked', false);
        }

        function fnAutoSetValue() {
            // gender
            if (typeof $filterParams['gender'] != 'undefined' && $filterParams['gender'] != '') {

                // basic > gender
                $basicGender = $('#filter_basic').find('#gender');
                if ($basicGender.val() != $filterParams['gender']) {
                    console.log('basic > gender > value : ' + $filterParams['gender']);
                    $basicGender.val($filterParams['gender']).selectric('refresh');
                }

                // gender area
                if ($('.gender-area a.active').data('filter-data') != 'gender=' + $filterParams['gender']) {
                    console.log('gender area > value : ' + $filterParams['gender']);
                    $('.gender-area a').removeClass('active');
                    $('.gender-area a[data-filter-data="gender=' + $filterParams['gender'] + '"]').addClass('active');
                }
            }

            // age
            if (typeof $filterParams['age'] != 'undefined' &&  $filterParams['age'] != '') {

                // basic > gender
                $basicAge = $('#filter_basic').find('#age');
                if ($basicAge.val() != $filterParams['age']) {
                    console.log('basic > age > value : ' + $filterParams['age']);
                    $basicAge.val($filterParams['age']).selectric('refresh');
                }

                // main filter > age
                if ($('#filtermain_age li.active a').data('filter-data') != 'age=' + $filterParams['age']) {
                    console.log('main filter > age : ' + $filterParams['age']);
                    $('#filtermain_age li').removeClass('active');
                    $('#filtermain_age li a[data-filter-data="age=' + $filterParams['age'] + '"]').closest('li').addClass('active');
                }
            }

            // ethnicity
            if (typeof $filterParams['age'] != 'undefined' &&  $filterParams['age'] != '') {

                // basic > ethnicity
                $basicEthnicity = $('#filter_basic').find('#ethnicity');
                if ($basicEthnicity.val() != $filterParams['ethnicity']) {
                    console.log('basic > ethnicity > value : ' + $filterParams['ethnicity']);
                    $basicEthnicity.val($filterParams['ethnicity']).selectric('refresh');
                }

                // main filter > ethnicity
                if ($('#filtermain_ethnicity li.active a').data('filter-data') != 'ethnicity=' + $filterParams['ethnicity']) {
                    console.log('main filter > ethnicity : ' + $filterParams['ethnicity']);
                    $('#filtermain_ethnicity li').removeClass('active');
                    $('#filtermain_ethnicity li a[data-filter-data="ethnicity=' + $filterParams['ethnicity'] + '"]').closest('li').addClass('active');
                }
            }

            // video
            if (typeof $filterParams['with_video'] != 'undefined' && $filterParams['with_video'] != '') {

                // basic > with_video
                $basicVideo = $('#filter_basic').find('#with_video');
                if ($basicVideo.val() != $filterParams['with_video']) {
                    console.log('basic > with_video > value : ' + $filterParams['with_video']);
                    $basicVideo.val($filterParams['with_video']).selectric('refresh');
                }

                // main filter > with_video
                if ($('#filtermain_video li.active a').data('filter-data') != 'with_video=' + $filterParams['with_video']) {
                    console.log('main filter > with_video : ' + $filterParams['with_video']);
                    $('#filtermain_video li').removeClass('active');
                    $('#filtermain_video li a[data-filter-data="with_video=' + $filterParams['with_video'] + '"]').closest('li').addClass('active');
                }
            }

            // height
            if (typeof $filterParams['height'] != 'undefined' && $filterParams['height'] != '') {

                // basic > height
                $basicVideo = $('#filter_physical').find('#height');
                if ($basicVideo.val() != $filterParams['height']) {
                    console.log('basic > height > value : ' + $filterParams['height']);
                    $basicVideo.val($filterParams['height']).selectric('refresh');
                }

                // main filter > height
                if ($('#filtermain_height li.active a').data('filter-data') != 'height=' + $filterParams['height']) {
                    console.log('main filter > height : ' + $filterParams['height']);
                    $('#filtermain_height li').removeClass('active');
                    $('#filtermain_height li a[data-filter-data="height=' + $filterParams['height'] + '"]').closest('li').addClass('active');
                }
            }

        }

        var $grid = $('.masonrow');
        // minus 4px to escort photo because container has padding
        $minusWidth = 4;

        function fnFilterEscorts(isAll) {
            isAll = typeof isAll !== 'undefined' && isAll != '' ? isAll : false;
            if (isAll) {
                $filterParams = {}; // reset
            }

            fnAjax({
                url: $locationDataUrl,
                data: $filterParams,
                success: function(data) {
                    $('.escortArea span').html('');
                    $('.escortArea span').html(data);
                }
            });            

            fnAjax({
                url: $filterUrl,
                data: $filterParams,
                success: function(data) {
                    if (isAll) {
                        var $filterFullUrl = $('#all_escort').attr('href');
                        fnResetFilter();
                        $('#all_escort').addClass('active');
                    } else {
                        var $filterFullUrl = $filterUrl + '?' + $.param($filterParams);
                        $filterFullUrl = decodeURIComponent($filterFullUrl);
                        $('#all_escort').removeClass('active');
                        fnAutoSetValue();
                    }
                    window.history.pushState("", "", $filterFullUrl);
                    //console.log(data);
                    if (typeof data.status !== 'undefined') {
                        if (data.status == 1) {
                            var $content = $(data.html);
                            var $images = $content.find('img');

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

                            if($lastclickeditem == 'price' && $filterParams[$lastclickeditem] !='' && $filterParams[$lastclickeditem] !== 'undefined'){                                
                                $('.pr_range').text(data.total);                                
                            }

                            if($lastclickeditem == 'age' && $filterParams[$lastclickeditem] !='' && $filterParams[$lastclickeditem] !== 'undefined'){                               
                                $('.ag_range').text(data.total);                               
                            }

                            if($lastclickeditem=='ethnicity' && $filterParams[$lastclickeditem] !='' && $filterParams[$lastclickeditem] !== 'undefined'){
                                $('.ethi_total').text(data.total);
                            }

                            if($lastclickeditem=='service_type' && $filterParams[$lastclickeditem] !='' && $filterParams[$lastclickeditem] !== 'undefined'){
                                $('.service_total').text(data.total);
                            }

                            if($lastclickeditem=='verification' && $filterParams[$lastclickeditem] !='' && $filterParams[$lastclickeditem] !== 'undefined'){
                                $('.verification_total').text(data.total);
                            }

                            if($lastclickeditem == 'height' && $filterParams[$lastclickeditem] !='' && $filterParams[$lastclickeditem] !== 'undefined'){                                
                                $('.heightTotal').text(data.total);                                
                            }

                            if($lastclickeditem == 'hair_color_id' && $filterParams[$lastclickeditem] !='' && $filterParams[$lastclickeditem] !== 'undefined'){                                
                                $('.hairColorTotal').text(data.total);                                
                            }

                            if($lastclickeditem == 'cup_size' && $filterParams[$lastclickeditem] !='' && $filterParams[$lastclickeditem] !== 'undefined'){                                
                                $('.cupSizeTotal').text(data.total);                                
                            }

                            if($lastclickeditem == 'body_type' && $filterParams[$lastclickeditem] !='' && $filterParams[$lastclickeditem] !== 'undefined'){                                
                                $('.buildTotal').text(data.total);                                
                            }

                            if($lastclickeditem == 'hair_length' && $filterParams[$lastclickeditem] !='' && $filterParams[$lastclickeditem] !== 'undefined'){                                
                                $('.hairLengthTotal').text(data.total);                                
                            }

                            if($lastclickeditem == 'eye_color_id' && $filterParams[$lastclickeditem] !='' && $filterParams[$lastclickeditem] !== 'undefined'){                                
                                $('.eyeColorTotal').text(data.total);                                
                            }

                            if($lastclickeditem == 'public_hair' && $filterParams[$lastclickeditem] !='' && $filterParams[$lastclickeditem] !== 'undefined'){                                
                                $('.publicHairTotal').text(data.total);                                
                            }
                            console.log($lastclickeditem);
                            if($lastclickeditem == 'escort_type' && $filterParams[$lastclickeditem] !='' && $filterParams[$lastclickeditem] !== 'undefined'){                                
                                $('.escortTypeTotal').text(data.total);                                
                            }

                            if($lastclickeditem == 'origin' && $filterParams[$lastclickeditem] !='' && $filterParams[$lastclickeditem] !== 'undefined'){                                
                                $('.originTotal').text(data.total);                                
                            }

                            if($lastclickeditem == 'travel' && $filterParams[$lastclickeditem] !='' && $filterParams[$lastclickeditem] !== 'undefined'){                                
                                $('.travelTotal').text(data.total);                                
                            }

                            if($lastclickeditem == 'smoke' && $filterParams[$lastclickeditem] !='' && $filterParams[$lastclickeditem] !== 'undefined'){                                
                                $('.smokeTotal').text(data.total);                                
                            }

                            if($lastclickeditem == 'drink' && $filterParams[$lastclickeditem] !='' && $filterParams[$lastclickeditem] !== 'undefined'){                                
                                $('.drinkTotal').text(data.total);                                
                            }

                            if($lastclickeditem == 'with_video' && $filterParams[$lastclickeditem] !='' && $filterParams[$lastclickeditem] !== 'undefined'){                                
                                $('.videoTotal').text(data.total);                                
                            }

                            if($lastclickeditem == 'with_review' && $filterParams[$lastclickeditem] !='' && $filterParams[$lastclickeditem] !== 'undefined'){                                
                                $('.reviewTotal').text(data.total);                                
                            }
                            
                            if($lastclickeditem == 'lang_ids' && $filterParams[$lastclickeditem] !='' && $filterParams[$lastclickeditem] !== 'undefined'){                                
                                $('.languageTotal').text(data.total);                                
                            }

                            if($lastclickeditem == 'escort_service_ids' && $filterParams[$lastclickeditem] !='' && $filterParams[$lastclickeditem] !== 'undefined'){                                
                                $('.escortServiceTotal').text(data.total);                                
                            }

                            if($lastclickeditem == 'erotic_service_ids' && $filterParams[$lastclickeditem] !='' && $filterParams[$lastclickeditem] !== 'undefined'){                                
                                $('.eroticServiceTotal').text(data.total);                                
                            }

                            if($lastclickeditem == 'extra_service_ids' && $filterParams[$lastclickeditem] !='' && $filterParams[$lastclickeditem] !== 'undefined'){                                
                                $('.extraServiceTotal').text(data.total);                                
                            }

                            if($lastclickeditem == 'fetish_service_ids' && $filterParams[$lastclickeditem] !='' && $filterParams[$lastclickeditem] !== 'undefined'){                                
                                $('.fetishTotal').text(data.total);                                
                            }

                            // remove all items
                            $filterContainer.find('.filter-item').remove();
                            
                            // append new items
                            $('.grid').append($content).masonry('appended', $content);
							
                            // find first item container
                            // to calculate max width of image
                            $firstItemContainer = $filterContainer.find('.grid .grid-item:first');
                            $('.grid').masonry('layout');
                            
                            // replace country option
                            if (typeof data.countries !== 'undefined') {
                                $countryHtml = '<option value="">Country</option>';
                                //console.log(data.countries);
                                if (data.countries.length) {
                                    for (var i in data.countries) {
                                        $countryHtml += '<option value="' + data.countries[i].country_id + '">' + data.countries[i]['country']['name'] + ' (' + data.countries[i].total + ')</option>';
                                    }
                                    $('#filter_country').html($countryHtml);
                                    $('#filter_country').prop("disabled", false);
                                    $('#filter_country').selectric('refresh');
                                } else {
                                    $('#filter_country').html($countryHtml);
                                    $('#filter_country').prop("disabled", true);
                                    $('#filter_country').selectric('refresh');
                                }

                                // reset city
                                $stateHtml = '<option value="">State</option>';
                                $('#filter_state').prop('disabled', true);
                                $('#filter_state').html($stateHtml).selectric('refresh');
                            }


                            // replace state option
                            if (typeof data.states !== 'undefined') {
                                $stateHtml = '<option value="">State</option>';
                                if (data.states.length) {
                                    for (var i in data.states) {
                                        $stateHtml += '<option value="' + data.states[i].state_id + '">' + data.states[i]['state']['name'] + ' (' + data.states[i].total + ')</option>';
                                    }
                                    $('#filter_state').html($stateHtml);
                                    $('#filter_state').prop("disabled", false);
                                    $('#filter_state').selectric('refresh');
                                } else {
                                    $('#filter_state').html($stateHtml);
                                    $('#filter_state').prop("disabled", true);
                                    $('#filter_state').selectric('refresh');
                                }

                                // reset city
                                $cityHtml = '<option value="">City</option>';
                                $('#filter_city').prop('disabled', true);
                                $('#filter_city').html($cityHtml).selectric('refresh');
                            }
                            // replace city option
                            else if (typeof data.cities !== 'undefined') {
                                $cityHtml = '<option value="">City</option>';
                                if (data.cities.length) {
                                    for (var i in data.cities) {
                                        $cityHtml += '<option value="' + data.cities[i].city_id + '">' + data.cities[i]['city']['name'] + ' (' + data.cities[i].total + ')</option>';
                                    }
                                    $('#filter_city').prop('disabled', false);
                                    $('#filter_city').html($cityHtml).selectric('refresh');
                                } else {
                                    $('#filter_city').prop('disabled', true);
                                    $('#filter_city').html($cityHtml).selectric('refresh');
                                }
                            }

                        }
                    }
                }
            });
            return true;
        }

        $links.on('click', function() {
            event.preventDefault();

            //$('#all_escort').removeClass('active');

            $elm = $(this);
            var $data = $elm.attr('data-filter-data');

            var $splitData = $data.split('=');

            if ($splitData[0] == 'gender') {
                // gender area filter - active/inactive state or toggle effects
                if ($splitData[0] in $filterParams &&
                    $filterParams[$splitData[0]] == $splitData[1]
                ) {
                    $elm.removeClass('active');
                    delete $filterParams[$splitData[0]];
                } else {
                    $filterParams[$splitData[0]] = $splitData[1];
                }
            } else {
                $filterParams[$splitData[0]] = $splitData[1];
            }

            fnFilterEscorts();
        });

        // search box
        var $filterSearchText = $('#filter-search-text');
        var $filterSearchBtn = $('#filter-search-btn');
        $filterSearchBtn.click(function() {
            event.preventDefault();
            $filterParams['search'] = $filterSearchText.val();
            fnFilterEscorts();
        });

        // location
        $('#filter_continent').selectric({
            onChange: function() {
                $filterParams['continent_id'] = $(this).val();
                $filterParams['country_id'] = ''; // reset
                $filterParams['state_id'] = ''; // reset
                $filterParams['city_id'] = ''; // reset                
                fnFilterEscorts();
            }
        });
        if ($('#filter_country').find('option').length == 1) {
            $('#filter_country').prop('disabled', true);
        }
        
        $('#filter_country').selectric({
            onChange: function() {
                $filterParams['country_id'] = $(this).val();
                $filterParams['state_id'] = ''; // reset
                $filterParams['city_id'] = ''; // reset                
                fnFilterEscorts();
            }
        })

        if ($('#filter_state').find('option').length == 1) {
            $('#filter_state').prop('disabled', true);
        }
        $('#filter_state').selectric({
            onChange: function() {
                $filterParams['state_id'] = $(this).val();
                $filterParams['city_id'] = ''; // reset
                fnFilterEscorts();
            }
        })

        if ($('#filter_city').find('option').length == 1) {
            $('#filter_city').prop('disabled', true);
        }
        $('#filter_city').selectric({
            onChange: function() {
                $filterParams['city_id'] = $(this).val();
                fnFilterEscorts();
            }
        })

        // sidebar filter
        $('#all_escort').click(function() {
            event.preventDefault();
            fnFilterEscorts(true);
        });
        $('#filter_pornstar').click(function() {
            event.preventDefault();
            // remove active in sidebar
            $('#filter-nav a').removeClass('active');
            // set active/inactive
            if ('pornstar' in $filterParams) { // to inactive
                delete $filterParams['pornstar'];
            } else { // to active
                $('#filter_pornstar').addClass('active');
                $filterParams['pornstar'] = 'Y';
            }

            if (typeof $filterParams['today'] !== 'undefined' &&
                $filterParams['today'] == 1
            ) {
                // set active
                $('#today_escort').addClass('active');
            }
            if (typeof $filterParams['new'] !== 'undefined' &&
                $filterParams['new'] == 'Y'
            ) {
                // set active
                $('#new_escort').addClass('active');
            }
            fnFilterEscorts();
        });

        $('#today_escort').click(function() {
            event.preventDefault();
            // remove active in sidebar
            $('#filter-nav a').removeClass('active');
            // set active/inactive
            if ('today' in $filterParams) { // to inactive
                delete $filterParams['today'];
            } else { // to active
                $('#today_escort').addClass('active');
                $filterParams['today'] = 1;
            }

            delete $filterParams['new'];
            if (typeof $filterParams['pornstar'] !== 'undefined' &&
                $filterParams['pornstar'] == 'Y'
            ) {
                // set active
                $('#filter_pornstar').addClass('active');
            }
            fnFilterEscorts();
        });

        $('#new_escort').click(function() {
            event.preventDefault();
            // remove active in sidebar
            $('#filter-nav a').removeClass('active');
            // set active/inactive
            if ('new' in $filterParams) { // to inactive
                delete $filterParams['new'];
            } else { // to active
                $('#new_escort').addClass('active');
                $filterParams['new'] = 'Y';
            }

            delete $filterParams['today'];
            if (typeof $filterParams['pornstar'] !== 'undefined' &&
                $filterParams['pornstar'] == 'Y'
            ) {
                // set active
                $('#filter_pornstar').addClass('active');
            }
            fnFilterEscorts();
        });

        // Basic

        $('#basic_search div.escortG').on('click', 'input', function() {
            var $elm = $(this);
            var $filterName = $elm.attr('name');
            
            if (typeof $filterName !== 'undefined' &&
                $filterName != ''
            ) {
                $filterParams[$filterName] = $elm.val();
                $lastclickeditem = $filterName;
                fnFilterEscorts();
            }
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
                    fnFilterEscorts();
                }
            }
        });

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
                    fnFilterEscorts();
                }
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
{{-- assets --}}
@stackAssets('post.scripts')
{{-- end assets --}}

{{-- assets --}}
@stackAssets('scripts.post')
{{-- end assets --}}