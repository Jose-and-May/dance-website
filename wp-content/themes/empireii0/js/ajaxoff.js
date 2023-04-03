var browser = navigator.appName;	

jQuery(document).ready(function($) {		
	"use strict";		
	
	
	
		
	//POSITION SITE
		if(!isResponsive){
			//position site if site is not centered
				if(siteposition == 'left'){
				//left				
					$('#site').css({'marginLeft':'0px','left':'0px'});				
						
					$('#sidebar').css({
						'margin-left':'-8px',
						'left':'0px'
					});
						
					$('#page').css({					
						'right':'8px'
					});		
				}else if(siteposition == 'right'){
				//right
					$('#page').css('background-image','url('+template_url+'/images/page-bg2.png)');			
				
					$('#site').css({'marginLeft':'0px','right':'0px','left':'auto','overflow-x':'hidden'});				
					
					$('#sidebar').css({
						'margin-left':'8px'					
					});
					
					$('#page').css({					
						'right':'-10px'					
					})
				}
		}
		
	
	
	//OPENING ANIM RUNS ONLY ONCE PER VISIT	
		if(firstvisit && openinganim && !siteisclosed){
			//set site CSS position to closed, logo hidden
			//console.log('FIRST VISIT, SITE IS CLOSED, PLAY OPENING ANIM! AND LOGOANIM IF ENABLED');
			
			
			//set site CSS position to closed
			if(!isResponsive){
				if(siteposition == 'center'){
				//center
						
					$('#sidebar').css({
						'margin-left':'-153px',
						'left':'50%'
					});
						
					$('#page').css({
						'width':'0px',
						'right':'350px'
					});
				}else if(siteposition == 'left'){
				//left
					
					$('#site').css({'marginLeft':'0px','left':'0px'});				
					
					$('#sidebar').css({
						'margin-left':'-8px',
						'left':'0px'
					});				
					
					$('#page').css({					
						'right':'666px'
					});		
				}else if(siteposition == 'right'){
				//right
				
					$('#site').css({'marginLeft':'0px','right':'0px','left':'auto'});				
					
					$('#sidebar').css({
						'margin-left':'auto',
						'left':'666px'
					});
					
					$('#page').css({					
						'right':'-360px'
						
					});		
				}
			}else if(isResponsive == 'tablet'){
				$('#sidebar').css({
					'left':'-3px'
				});							
			
				$('#page').css({					
					'left':'-666px'
				});		
			}
				
				
		
			//hide content
				$('#page-content').css('display','none');
			
			
			$(window).load(function(){
			//start logoanim if enabled and open the site
				if(logoanim){
					var menufadespeed = 'slow';
					if(browser.indexOf('Explorer') > 0){
						menufadespeed = 0;
					}
					
					jQuery('#logo').css({'display':'none','top':'33%'});
					jQuery('.menu > li').css({'display':'none'});
					jQuery('.menu li:last-child').css('background-image','none');

					var countmenuitems = jQuery('.menu > li').length;	
					jQuery('#logo').delay(1000).fadeIn('slow',function(){
						//move logo
						jQuery('#logo').delay(200).animate({
							top: '0px'
						},900,function(){
							//logo is in place, show menu
							jQuery('.menu > li').each(function(index){
								jQuery(this).delay(150*index).fadeIn(menufadespeed,function(){
									countmenuitems--;
									if(countmenuitems < 1){										
										jQuery('#sidebar-content .below-menu').fadeIn(700);
										jQuery('#sidebar-content .social-icons').fadeIn(700);										
	
										
										
										//open page
										if(!isResponsive){
											if(siteposition == 'center'){	
											//center
														
												jQuery('#page').animate({
													width: '666px',
													right: '0px'
												},openingspeed,function(){
													//site is open, fade in page content
														
														$('#page-content').fadeIn(700);
														
													});
												
												jQuery('#sidebar').animate({
													left: '0px',
													marginLeft: '0px'
												},openingspeed);
											}else if(siteposition == 'left'){
											//left				
												
												jQuery('#page').animate({					
													right: '8px'
												},openingspeed,function(){
													//site is open, fade in page content
													
														$('#page-content').fadeIn(700);
													
												});
											}else if(siteposition == 'right'){
											//right
													
												jQuery('#page').animate({					
													right: '0px'					
												},openingspeed,function(){
													//site is open, fade in page content				
													
														$('#page-content').fadeIn(700);
													
												});
												
												jQuery('#sidebar').animate({
													marginLeft:'8px',
													left:'0px'					
												},openingspeed);
											}
										}else if(isResponsive == 'tablet'){
											jQuery('#sidebar').delay(200).animate({
												left: '-322px'
											},500);
											
											jQuery('#page').delay(200).animate({					
												left: '50px'
											},openingspeed,function(){
												//site is open, fade in page content					
													$('#page-content').fadeIn(700);
											});	
										}else{
											$('#page-content').fadeIn(700);
										}
									}
								});				
							});
							
							
						});
					});
				
				}else{
				//if logoanim not enabled, just open the site
					
					var menufadespeed = 'slow';
					if(browser.indexOf('Explorer') > 0){
						menufadespeed = 0;
					}
										
					jQuery('.menu > li').css({'display':'none'});
					jQuery('.menu li:last-child').css('background-image','none');

					var countmenuitems = jQuery('.menu > li').length;						
					//logo is in place, show menu
					jQuery('.menu > li').delay(1000).each(function(index){
						jQuery(this).delay(150*index).fadeIn(menufadespeed,function(){
							countmenuitems--;
							if(countmenuitems < 1){										
								jQuery('#sidebar-content .below-menu').fadeIn(700);
								jQuery('#sidebar-content .social-icons').fadeIn(700);										

								//open page
								if(!isResponsive){
									if(siteposition == 'center'){	
									//center
														
										jQuery('#page').delay(1000).animate({
											width: '666px',
											right: '0px'
										},openingspeed,function(){
											//site is open, fade in page content
												
												$('#page-content').fadeIn(700);
												
											});
										
										jQuery('#sidebar').delay(1000).animate({
											left: '0px',
											marginLeft: '0px'
										},openingspeed);
									}else if(siteposition == 'left'){
									//left				
										
										jQuery('#page').delay(1000).animate({					
											right: '8px'
										},openingspeed,function(){
											//site is open, fade in page content
											
												$('#page-content').fadeIn(700);
											
										});
									}else if(siteposition == 'right'){
									//right
											
										jQuery('#page').delay(1000).animate({					
											right: '0px'					
										},openingspeed,function(){
											//site is open, fade in page content				
											
												$('#page-content').fadeIn(700);
											
										});
										
										jQuery('#sidebar').delay(1000).animate({
											marginLeft:'8px',
											left:'0px'					
										},openingspeed);
									}
								}else if(isResponsive == 'tablet'){
									jQuery('#sidebar').delay(200).animate({
										left: '-322px'
									},500);
									
									jQuery('#page').delay(200).animate({					
										left: '50px'
									},openingspeed,function(){
										//site is open, fade in page content					
											$('#page-content').fadeIn(700);
									});	
								}else{
									$('#page-content').fadeIn(700);
								}
							}
						});				
					});
				}
			});
		
		}else if(siteisclosed){
			
			jQuery('#sidebar-content .below-menu').css('display','none');
			jQuery('#sidebar-content .social-icons').css('display','none');
			
		//SITE IS CLOSED ON HOME, ON OTHER PAGES IT'S OPENED
			//if it's frontpage, keep site closed
			if(is_front_page){
				//hide content
				$('#page-content').css('display','none');
				
				if(!isResponsive){
				//set site CSS position to closed
					if(siteposition == 'center'){
					//center
						
						$('#sidebar').css({
							'margin-left':'-153px',
							'left':'50%'
						});
						
						$('#page').css({
							'width':'0px',
							'right':'350px'
						});
					}else if(siteposition == 'left'){
					//left
					
						$('#site').css({'marginLeft':'0px','left':'0px'});				
						
						$('#sidebar').css({
							'margin-left':'-8px',
							'left':'0px'
						});				
						
						$('#page').css({					
							'right':'666px'
						});		
					}else if(siteposition == 'right'){
					//right
					
						$('#site').css({'marginLeft':'0px','right':'0px','left':'auto'});				
						
						$('#sidebar').css({
							'margin-left':'auto',
							'left':'666px'
						});
						
						$('#page').css({					
							'right':'-360px'
							
						});		
					}
				}else if(isResponsive == 'tablet'){
					$('#sidebar').css({
						'left':'-3px'
					});							
				
					$('#page').css({					
						'left':'-666px'
					});		
				}else{
					$('#page-content').css('display','block');
				}
				
				
				jQuery('#sidebar-content .below-menu').fadeIn(700);
				jQuery('#sidebar-content .social-icons').fadeIn(700);		
			}else{
				jQuery('#sidebar-content .below-menu').fadeIn(700);
				jQuery('#sidebar-content .social-icons').fadeIn(700);		
			}
	
			//console.log('SITE IS CLOSED, IF WE ARE ON HOMEPAGE ');
		}else if(!firstvisit){
			jQuery('#sidebar-content .below-menu').fadeIn(700);
			jQuery('#sidebar-content .social-icons').fadeIn(700);
		}
		
		
	
	//LOGO AND MENU ANIM IF IT'S FIRST VISIT AND IT'S ENABLED AND OPENING ANIM IS DISABLED
		if((siteisclosed && logoanim && firstvisit) || (!siteisclosed && logoanim && firstvisit && !openinganim)){
			$(window).load(function(){
					var menufadespeed = 'slow';
					if(browser.indexOf('Explorer') > 0){
						menufadespeed = 0;
					}
					
					jQuery('#logo').css({'display':'none','top':'33%'});
					jQuery('.menu > li').css({'display':'none'});
					jQuery('.menu li:last-child').css('background-image','none');
					
					jQuery('#sidebar-content .below-menu').css('display','none');
					jQuery('#sidebar-content .social-icons').css('display','none');

					var countmenuitems = jQuery('.menu > li').length;	
					jQuery('#logo').delay(1000).fadeIn('slow',function(){
						//move logo
						jQuery('#logo').delay(200).animate({
							top: '0px'
						},900,function(){
							//logo is in place, show menu
							jQuery('.menu > li').each(function(index){
								jQuery(this).delay(150*index).fadeIn(menufadespeed,function(){
									countmenuitems--;
									if(countmenuitems < 1){										
										jQuery('#sidebar-content .below-menu').fadeIn(700);
										jQuery('#sidebar-content .social-icons').fadeIn(700);
																			
									}
								});				
							});
							
							
						});
					});
					
			});
		}
	
		
});