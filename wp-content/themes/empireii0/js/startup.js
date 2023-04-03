
  
	
//CHECK IF WINDOW IS RESPONSIVE SIZE		
	var isSidebarOpen;
	var isResponsive = false;	
	
	

	
jQuery(document).ready(function($) {		
	"use strict";		
	
	
	if(tp_responsive != 'off'){
		if(parseInt(jQuery(window).width()) < 733 ){
			isResponsive = 'mobile';
		}else if(parseInt(jQuery(window).width()) < 1024){
			isResponsive = 'tablet';
			
		}
	}
	
	//PRELOADING
		if(!firstvisit){
			$('#preloader').remove();
		}
	
		$(window).load(function() {	
			//remove loading layer if this is the first visit
			if(firstvisit){
				$('#preloader').animate({'opacity':'0'},500,function(){
					$(this).remove();
				});
			}
			
			//stop BG slider
			if(isResponsive == 'mobile'){
				$('#tp-bgslider-holder,#tp-bgslider').remove();
				
				if(tpInt != null){
					clearInterval(tpInt);
				}
			}
			
			//force sidebar height
			if(tp_responsive == 'off'){
				if(!ajax_is_on){										
					var nuh = parseInt($(document).outerHeight());
					$('#sidebar').css('height',nuh+'px');
				}				
			}
			
			
		});

	
	
		
		
	//DROPDOWN MENU		
		if(parseInt(jQuery(window).width()) > 1024){
				$('.menu li').hover(
					function(){ 												
						$(this).has('ul').children('ul').stop(true,true).delay(200).slideDown('slow');
					},
					function(){
						$(this).has('ul').children('ul').stop(true,true).slideUp('slow');
					}				
				);
		}else{
			if(!ajax_is_on){
				//force page height
				$('.menu li').find('ul').delay(700).slideDown('slow').promise().always(function(){
					var nu_ph = parseInt(jQuery('#sidebar-content').height()) + 10;
					jQuery('#page').css('min-height',nu_ph+'px');
				});
			}else{
				$('.menu li').find('ul').delay(1200).slideDown('slow');
			}
				$('#sidebar-content').css({'position':'absolute','min-height':'100%'});
				$('#sidebar-content .social-icons').css({'position':'relative','margin-top':'40px','bottom':'auto'});
		}
	
	
	
	//WINDOW RESIZE FUNCTIONS		
		var resizeTimer;
		function refresh(){
			location.reload();
		}		
		
		var prevRev = isResponsive;
		$(window).resize(function() {
			if(tp_responsive != 'off'){
				if(parseInt(jQuery(window).width()) < 733 ){
					isResponsive = 'mobile';
				}else if(parseInt(jQuery(window).width()) < 1024){
					isResponsive = 'tablet';
				}
			
				if(prevRev != isResponsive){
					$('<div id="preloader"></div>').insertAfter('#ie_warning');			
					clearTimeout(resizeTimer);
					resizeTimer = setTimeout(refresh, 150);
					
					prevRev = isResponsive;
				}			
			}
			
		});
		
		
	
	
	//DISABLE AUDIO PLAYER IF LOW RESOLUTION
		if(parseInt($(window).width()) < 1240 || parseInt($(window).height()) < 690){			
			$('#sidebar #sidebar-content .tp-audio-player').remove();						
		}
		
		
		
	//UNIVERSAL FUNCTION TO MAKE EVERYTHING WORK WHEN AJAX IS ON AND OFF	
		if(!ajax_is_on){
			toolStarter();
		}
		
		
		
	//RESPONSIVE TABLET MENU FUNCTION	
		$(document).on('click','#rsp-menu',function(){
			$('body,html').animate({
				scrollTop: '0'
			},500);
		
			$('#sidebar').animate({
				left: '-3px'
			},500);
			
			isSidebarOpen = true;
				
		});



		
	//DONT LOAD CONTENT IF SITE IS CLOSED ON HOMEPAGE AND ITS HOMEPAGE
		if(!ajax_is_on){
			var is_realhome = is_front_page;	
		}else{
			//find out if it's the home page or not
			var loca = top.location.toString();
			if(loca.indexOf('#') < 0){
				var is_realhome = true;
			}	
		}

		if(tp_responsive != 'off' && is_realhome && siteisclosed && parseInt(jQuery(window).width()) < 733){
			//toggle - show menu
			$('#rsp-menu-nav').css('display','block');
				
			//change icon to close
			$('#rsp-menu-mobile').css('display','none');
			$('#rsp-menu-mobile-close').css('display','none');
			
			//hide content
			if(!ajax_is_on){				
				$('#page').css({'display':'none'});
				$('#rsp-lineshine').css({'bottom':'0px','height':'6px'});
				$('#responsive-sidebar').css({'min-height':'100%','padding-bottom':'0px'});
			}
		}


		
				
	//RESPONSIVE MOBILE MENU FUNCTION		
		$(document).on('click','#rsp-menu-mobile',function(){
			//toggle - show menu
			$('#rsp-menu-nav').slideDown(400,'linear');
			
			//change icon to close
			$('#rsp-menu-mobile').css('display','none');
			$('#rsp-menu-mobile-close').css('display','block');
						
		});
	
		$(document).on('click','#rsp-menu-mobile-close, #rsp-menu-nav a',function(){
			//fade/toggle out menu
			$('#rsp-menu-nav').css('display','none');
			
			//change icon to menu
			$('#rsp-menu-mobile').css('display','block');
			$('#rsp-menu-mobile-close').css('display','none');
		});
	
});



	//UNIVERSAL FUNCTION TO MAKE EVERYTHING WORK WHEN AJAX IS ON AND OFF	
		function toolStarter(){
		
			//ENABLE THICKBOX FOR GALLERY	
				jQuery('#content img.attachment-thumbnail').parent('a').addClass('thickbox').attr('rel', 'page');
				jQuery("body").keydown(function(e) {
					if(e.which == 37) { // left     
						jQuery('#TB_prev a').trigger('click');
					}
					else if(e.which == 39) { // right     
						jQuery('#TB_next a').trigger('click');
					}
				});
			
			
			//TOOLTIP
				 jQuery('.social-sharing .holder a').tipsy({
					trigger: 'hover',
					gravity: 's',
					fade: true
				});
			
			
			//TABS
				jQuery('.tabs').tabs({
					fx: [{opacity:'toggle', duration:'normal'},
					{opacity:'toggle', duration:'normal'}]
				})
				
			//LITE UP	
				if(ajax_is_on){
					if(typeof liteUp == 'function'){
						liteUp();
					}
				}
				
			
				
			
		}
