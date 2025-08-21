 $(document).ready(function() {
	$('nav').clone().appendTo('.side_bar');
		$('#nav-icon').click(function(e) {
		   $('body').toggleClass('open');
		});
	$('.side_bar ul li a').click(function(e) {
	   $('body').removeClass('open');
	   if ($(window).width() < 768) {
		  $(this).parent().find('.drop_down').slideToggle();
		  $(this).parent().siblings().find('.drop_down').slideUp();
		  $(this).parent().toggleClass("active");
		  $(this).parent().siblings().removeClass("active");
	   }
	});
	$('[data-fancybox]').fancybox({});
	$('[master-plan]').fancybox({});
	
	//  Sticky Header
	$(window).scroll(function(e) {
		 enableVideos();
		   if ($(window).scrollTop() > 0) {
			  $('body').addClass('sticky');
			 
		   } else {
			  $('body').removeClass('sticky');
		   }		   
	});
	
	function enableVideos(){
		$('#location').css({"display": "block"});
		$('#popup2').css({"display": "block"})
	}
	
	 setTimeout(()=>{
		$('.slider3').slick({
			   dots: false,
			   arrows: true,
			   slidesToShow: 1,
			   slidesToScroll: 1,
			   autoplay: true,
			   autoplaySpeed: 4000,
			});
			
			$('.slider4').slick({
			   dots: true,
			   arrows: false,
			   slidesToShow: 1,
			   slidesToScroll: 1,
			   autoplay: true,
			   autoplaySpeed: 4000
			}); 
		 
	 }, 0);
	
			
            //  Sticky Header
	$(window).scroll(function(e) {
	   if ($(window).scrollTop() > 0) {
		  $('body').addClass('sticky');
	   } else {
		  $('body').removeClass('sticky');
	   }
	});
	
	// tab block
	
	var TabBlock = {
               s: {
                  animLen: 200
               },
         
               init: function() {
                  TabBlock.bindUIActions();
                  TabBlock.hideInactive();
               },
         
               bindUIActions: function() {
                  $('.tabBlock-tabs').on('click', '.tabBlock-tab', function() {
                     TabBlock.switchTab($(this));
                  });
               },
         
               hideInactive: function() {
                  var $tabBlocks = $('.tabBlock');
         
                  $tabBlocks.each(function(i) {
                     var
                        $tabBlock = $($tabBlocks[i]),
                        $panes = $tabBlock.find('.tabBlock-pane'),
                        $activeTab = $tabBlock.find('.tabBlock-tab.is-active');
         
                     $panes.hide();
                     $($panes[$activeTab.index()]).show();
                  });
               },
         
               switchTab: function($tab) {
                  var $context = $tab.closest('.tabBlock');
         
                  if (!$tab.hasClass('is-active')) {
                     $tab.siblings().removeClass('is-active');
                     $tab.addClass('is-active');
         
                     TabBlock.showPane($tab.index(), $context);
                  }
               },
         
               showPane: function(i, $context) {
                  var $panes = $context.find('.tabBlock-pane');
         
                  // Normally I'd frown at using jQuery over CSS animations, but we can't transition between unspecified variable heights, right? If you know a better way, I'd love a read it in the comments or on Twitter @johndjameson
                  $panes.slideUp(TabBlock.s.animLen);
                  $($panes[i]).slideDown(TabBlock.s.animLen);
               }
            };
         
	$(function() {
	   TabBlock.init();
	});
	
	// nav click
	
	$('nav ul li').on('click', function() {
               $(this).parent().find('li.active').removeClass('active');
               $(this).addClass('active');
            });
	//wow animation
	wow = new WOW({
	   animateClass: 'animated',
	   offset: 100,
	   mobile: true
	});
	wow.init();
	
	// popup
	
	 $(document).ready(function(){
         setTimeout(function(){
			 $('#popupModal').modal('show');
			 }, 400);
    });
});

 $('.project-progress-slick').slick({
		dots: true,
		infinite: true,
		speed: 300,
		slidesToShow: 3,
		slidesToScroll: 1,
		responsive: [{
		   breakpoint: 767,
		   settings: {
	 
			  slidesToShow: 1
		   }
		}]
 });
