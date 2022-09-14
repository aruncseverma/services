$(function() {
  $('select').selectric();
  maxHeight: 300
});
 
$(window).on('load', function() {
     $(".wrapper").css('opacity', '1');
 });

//Responsive Menu

$('.gender-fem').on('click', function(e) {
  $("#open_gender").removeClass();
  $("#open_gender").addClass('gen-active-fem');
  $('.gender-area').toggleClass("opened");


  $('.gender-fem').addClass("active");
  $('.gender-male').removeClass("active");
  $('.gender-couple').removeClass("active");
  $('.gender-trans').removeClass("active");


});
$('.gender-male').on('click', function(e) {
  $("#open_gender").removeClass();
  $("#open_gender").addClass('gen-active-male');
  $('.gender-area').toggleClass("opened");

  $('.gender-fem').removeClass("active");
  $('.gender-male').addClass("active");
  $('.gender-couple').removeClass("active");
  $('.gender-trans').removeClass("active");
});
$('.gender-couple').on('click', function(e) {
  $("#open_gender").removeClass();
  $("#open_gender").addClass('gen-active-couple');
  $('.gender-area').toggleClass("opened");
  
  $('.gender-fem').removeClass("active");
  $('.gender-male').removeClass("active");
  $('.gender-couple').addClass("active");
  $('.gender-trans').removeClass("active");

});
$('.gender-trans').on('click', function(e) {
  $("#open_gender").removeClass();
  $("#open_gender").addClass('gen-active-trans');
  $('.gender-area').toggleClass("opened");
  
  $('.gender-fem').removeClass("active");
  $('.gender-male').removeClass("active");
  $('.gender-couple').removeClass("active");
  $('.gender-trans').addClass("active");
});



 $('#open_nav').on('click', function(e) {
      $(this).toggleClass("opened_icon");
      $('.navigation').toggleClass("opened");
      $('#open_profile').toggleClass("hidden");
      $('#open_gender').toggleClass("hidden");
      $('nav-drop').removeClass("opened");//you can list several class names 
      $('.filter-area').removeClass("opened");//you can list several class names 
      $('.gender-area').removeClass("opened");//you can list several class names 
      e.preventDefault();
    });

$('#open_profile').on('click', function(e) {
     $(this).toggleClass("opened_icon");
      $('.nav-drop').toggleClass("opened");
      $('#open_search').toggleClass("hidden");
      $('#open_nav').toggleClass("hidden");
      $('.navigation').removeClass("opened");//you can list several class names 
      $('.filter-area').removeClass("opened");//you can list several class names 
      $('.gender-area').removeClass("opened");//you can list several class names 
      e.preventDefault();
    });
$('#open_search').on('click', function(e) {
     $(this).toggleClass("opened_icon");
      $('.filter-area').toggleClass("opened");

      $('#open_profile').toggleClass("hidden");
      $('#open_gender').toggleClass("hidden");
      $('.navigation').removeClass("opened");//you can list several class names 
      $('.nav-drop').removeClass("opened");//you can list several class names 
      $('.gender-area').removeClass("opened");//you can list several class names 
      e.preventDefault();
    });
$('#open_gender').on('click', function(e) {
     $(this).toggleClass("opened_icon");
      $('.gender-area').toggleClass("opened");
      $('#open_search').toggleClass("hidden");
      $('#open_nav').toggleClass("hidden");
      $('.navigation').removeClass("opened");//you can list several class names 
      $('.nav-drop').removeClass("opened");//you can list several class names 
      $('.filter-area').removeClass("opened");//you can list several class names 
      e.preventDefault();
    });



 //Js for the Equal Height................................
 equalheight = function(container){

var currentTallest = 0,
     currentRowStart = 0,
     rowDivs = new Array(),
     $el,
     topPosition = 0;
 $(container).each(function() {

   $el = $(this);
   $($el).height('auto')
   topPostion = $el.position().top;

   if (currentRowStart != topPostion) {
     for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
       rowDivs[currentDiv].height(currentTallest);
     }
     rowDivs.length = 0; // empty the array
     currentRowStart = topPostion;
     currentTallest = $el.height();
     rowDivs.push($el);
   } else {
     rowDivs.push($el);
     currentTallest = (currentTallest < $el.height()) ? ($el.height()) : (currentTallest);
  }
   for (currentDiv = 0 ; currentDiv < rowDivs.length ; currentDiv++) {
     rowDivs[currentDiv].height(currentTallest);
   }
 });
 }

$(window).on('load',function() {
  equalheight('.dashboard_top_detail .widget_box');
});


$(window).resize(function(){
  equalheight('.dashboard_top_detail .widget_box');
});



   $('.widget_accordian_title').click(function(){
    $(this).toggleClass("active");
    $(this).closest(".panel").find(".widget_accordian_content").slideToggle();
    $(this).closest(".panel").find(".panel-subtitle").toggleClass("active");
    $(this).find('.fa').toggleClass('fa-window-minimize fa-window-maximize');

});

if($(window).width() < 767)
{

  $('.dashboard_top_detail .widget_box .widget_header').click(function(){
       $(this).toggleClass("active");
    $(this).next().slideToggle();
});
}


 // tabbed content
    // http://www.entheosweb.com/tutorials/css/tabs.asp
    $(".tab_content").hide();
    $(".tab_content:first").show();

  /* if in tab mode */
    $("ul.tabs li").click(function() {
		
      $(".tab_content").hide();
      var activeTab = $(this).attr("rel"); 
      $("#"+activeTab).fadeIn();		
		
      $("ul.tabs li").removeClass("active");
      $(this).addClass("active");

	  $(".tab_drawer_heading").removeClass("d_active");
	  $(".tab_drawer_heading[rel^='"+activeTab+"']").addClass("d_active");
	  
    });
	/* if in drawer mode */
	$(".tab_drawer_heading").click(function() {
      
      $(".tab_content").hide();
      var d_activeTab = $(this).attr("rel"); 
      $("#"+d_activeTab).fadeIn();
	  
	  $(".tab_drawer_heading").removeClass("d_active");
      $(this).addClass("d_active");
	  
	  $("ul.tabs li").removeClass("active");
	  $("ul.tabs li[rel^='"+d_activeTab+"']").addClass("active");
    });
	
	
	/* Extra class "tab_last" 
	   to add border to right side
	   of last tab */
	$('ul.tabs li').last().addClass("tab_last");
	
