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
	  gutter:0
	});
	$(window).load(function(){
		$('.grid').masonry({
		  itemSelector: '.grid-item',
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

{{-- assets --}}
@stackAssets('post.scripts')
{{-- end assets --}}

{{-- assets --}}
@stackAssets('scripts.post')
{{-- end assets --}}