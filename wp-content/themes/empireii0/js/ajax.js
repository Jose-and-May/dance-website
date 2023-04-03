var browser = navigator.appName;		
var curl = top.location.toString();	
var sitestate = 'closed';
var siteUrl = "http://" + top.location.host.toString();




	//AJAX SETUP		
		jQuery(document).ready(function($) {		
			"use strict";		
			
					
			if(siteisclosed){				
				jQuery('#page-content').css('display','none');
			}
			
			
			$.ajaxSetup({ cache: false });
			
					
			//AJAX CONTENT LOADING									
				$(document).delegate("#menu-main a[href^='"+siteUrl+"'],#rsp-menu-nav a[href^='"+siteUrl+"'],footer a[href^='"+siteUrl+"'],#content a[href^='"+siteUrl+"']:not(.comment-edit-link,.logged-in-as a,a.external)", "click", function() {
					
					if(this.pathname.split('/').pop().indexOf('.') > -1 ){
						//link is a file, do nothing!
						window.open(this.pathname,'_blank');
					}else{
						location.hash = this.pathname+this.search;					
						
							
						//set active classes
						$('nav ul.menu li.current-menu-item').removeClass('current-menu-item');
						$(this).parent('li:first').addClass('current-menu-item');
						
						//if layout is responsive and sidebar is open
						if(isSidebarOpen){
							$('#sidebar').animate({
								left: '-322px'
							},500);
							
							isSidebarOpen = false;
						}
						
					}
					
										
					return false;
				});
				
		
			//CLICK ON A MENU TO LOAD
				$(window).bind('hashchange', function(){ 
					//console.log('HASHCHANGE!!'); 
					loadContent();
					
					if(!isResponsive){
						pageSetup();						
					}else if(isResponsive == 'tablet'){
						pageSetupTablet();
					}else if(isResponsive == 'mobile'){
						$('body,html').animate({
							scrollTop: '0'
						},100);
						
						pageSetupMobile();
					}
					
					
				});
				$(window).load(function(){
					$(window).trigger('hashchange');
				});
			
			
			//SEARCH FORM
				$(document).delegate('.search-form','submit', function() {					
					var searchval = $('#s').val();
					searchval = searchval.replace(' ','+');
					location.hash = window.location.pathname + '?s=' + searchval;
					
					return false;
				});
				

			//PWD FORM				
				$(document).on('submit','form.post-password-form',function(e){
					/*					
						1) memo original url
						2) submit pass without loading page
						3) reload original url					
					*/
					
					var thispage = window.location.hash.substring(1) + '?ajaxload=1 #content';
					var formtarget = $(this).attr('action');
					var dataString = $(this).serializeArray();
					
					//append loading
					jQuery('#page-content').fadeOut(200,function(){	
						jQuery('#page-content').html(' ');
						jQuery('#page').prepend('<img src="'+template_url+'/images/loading2.gif" alt="loading" class="loading" />');																			
						jQuery('.loading').fadeIn(300);	
					
						$.ajax({  
							type: 'POST',  
							url: formtarget,  
							data: dataString,  
							datatype: 'json',
							complete: function(data){  	
								//reload original URL
								
								loadContent();
								jQuery('#page-content').fadeIn(700);
								
								/*
								$('#page-content').html( data );							
							
								//remove loading
								jQuery('.loading').fadeOut(200,function(){
									jQuery(this).remove();								
								});
								
								//fade in content
								jQuery('#page-content').fadeIn(700);
								*/
								
							}
						});  
					});
										
					return false;
				});
			
					

			//HANDLE ALL FORM SUBMISSION				
				$(document).on('submit','form:not(.wpcf7-form,#commentform,.search-form,.post-password-form)',function(e){
					var formtarget = $(this).attr('action');
					if(!formtarget){
						formtarget = window.location.hash.substring(1) + '?ajaxload=1 #content';								
					}
					var dataString = $(this).serializeArray();
					
					//append loading
					jQuery('#page-content').fadeOut(200,function(){	
						jQuery('#page').prepend('<img src="'+template_url+'/images/loading2.gif" alt="loading" class="loading" />');																			
						jQuery('.loading').fadeIn(300);	
					
						$.ajax({  
							type: 'POST',  
							url: formtarget,  
							data: dataString,  
							datatype: 'json',
							success: function(data){  
								$('#page-content').html( data );
							
								//remove loading
								jQuery('.loading').fadeOut(200,function(){
									jQuery(this).remove();								
								});
								
								//fade in content
								jQuery('#page-content').fadeIn(700);
								
							},
							error:  function(data){
								$('#page-content').html( data );
							
								//remove loading
								jQuery('.loading').fadeOut(200,function(){
									jQuery(this).remove();								
								});
								
								//fade in content
								jQuery('#page-content').fadeIn(700);										
								
							}
						});  
					});
					
					return false;
				});
					
				
				
			//AJAX COMMENT FORM
				function validateEmail(email) 
				{
					var re = /\S+@\S+\.\S+/;
					return re.test(email);
				}
						
				$(document).on('submit','#commentform',function(e){
					e.preventDefault();
					var myForm = $(this);
													
					//validate inputs
						var err = false;
						
						$('#commentform input,#commentform textarea').removeClass('error');
						
						if($('#commentform input#author').length != 0){
							if($('#commentform input#author').val() == '' || $('#commentform input#author').val() == 'Your Name'){
								$('#commentform input#author').addClass('error');
								err = true;
							}
							
							if($('#commentform input#email').val() == ''){
								$('#commentform input#email').addClass('error');
								err = true;
							}
							
							if(!validateEmail($('#commentform input#email').val())){
								$('#commentform input#email').addClass('error');
								err = true;
							}
							
							if($('#commentform input#author').val() == ''){
								$('#commentform input#author').addClass('error');
								err = true;
							}
						}
						
						if($('#commentform textarea#comment').val() == ''){
							$('#commentform textarea#comment').addClass('error');
							err = true;
						}
						
					
					//if all inputs are OK, submit and print response
						if(!err){
							var posthere = $('#commentform').attr('action');
							var postdat = myForm.serialize();
							
							//append loading gif
							$('#commentform .form-submit').html('<img id="comment-loading" alt="loading" src="'+template_url+'/images/loading2.gif" />');
							
							//alert(posthere);
							
							$.ajax({
								dataType: 'json',               
								type: 'POST',
								url: posthere, 
								data: postdat,
								success: function(data){
																				
								},
								error: function(xhr, status, error){
									//alert('AJAX ERROR: '+xhr.responseText);
									
								},
								complete: function(){
									//hide form, show thanks								
									$('#commentform').fadeOut(700,function(){
										
										$(this).replaceWith('<p><strong>'+$('#comment-thanks').text()+'</strong></p>');
									});
								}							
							});     
							
						}
						
						  
				});
					
						
			//REPLY FOR A PARTICULAR COMMENT	
				$('#page-content').on('click','#cancel-comment-reply-link',function(e){
					e.preventDefault();
				});
				
				$('#page-content').on('click','.comment-reply-link',function(e){
					e.preventDefault();
					
					//change reply title
						$('#reply-title span').remove();
						$('#reply-title').append( '<span>(' + $(this).parent().parent().find('p.comment-author').text() + ')</span>' );
										
				});
							
	


	
			
			//SET STARTING SITE CSS PARAMETERS IF OPENING ANIMATION IS ENABLED
				if(!isResponsive){
				//DESKTOP VIEW
					if(siteposition == 'right'){
						$('#page').css({'background-image':'url('+template_url+'/images/page-bg2.png)','right':'-8px'});			
						$('#site').css({'overflow-x':'hidden'});								
					}
					
					var urlcheck = window.location.hash.substring(1);
					if(logoanim && firstvisit && !urlcheck){				
						jQuery('#logo').css({'display':'none','top':'33%'});
						jQuery('.menu > li').css({'display':'none'});
						jQuery('.menu li:last-child').css('background-image','none');
					}
					
					//menu is not highlighted on start				
					jQuery('#menu-main li').removeClass('current-menu-item');
					
					
					if(openinganim){
					//opening animation is enabled
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
					}else{
					//no opening anim			
					
						
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
								
									$('#site').css({'marginLeft':'0px','right':'0px','left':'auto'});				
									
									$('#sidebar').css({
										'margin-left':'8px'					
									});
									
									$('#page').css({					
										'right':'-8px'
									});		
								}
						
					}			
					
				}else if(isResponsive == 'tablet'){
				//TABLET
				
					if(logoanim && firstvisit){
						jQuery('#logo').css({'display':'none','top':'33%'});
						jQuery('.menu').css({'display':'none'});								
					}
				
				
					if((!sitealwaysopen && siteisclosed) || firstvisit){						
						var urlcheck = window.location.hash.substring(1);
						
						if(firstvisit && openinganim){
						//if it's 1st visit and opening anim is enabled, show sidebar only first
							$('#sidebar').css({
								'left':'-3px'
							});							
						
							$('#page').css({					
								'left':'-666px'
							});							
							
						}else if(!urlcheck && siteisclosed){						
							$('#sidebar').css({
								'left':'-3px'
							});
						
							$('#page').css({					
								'left':'-666px'
							});
							
							
						}
											
						isSidebarOpen = true;
						
					}
				}else if(isResponsive == 'mobile'){
				//MOBILE
						
				
				}
				
				
				
				
		});


	
	//FADE IN CONTENT
		function fadeContent(){
			//console.log('fade in content');			
			
			bind_pageopen = true;
			
			//sidebar content			
				if(!isResponsive){
					jQuery('#sidebar-content .below-menu').fadeIn(700);
					jQuery('#sidebar-content .social-icons').fadeIn(700);								
					jQuery('#sidebar-content .tp-audio-player').fadeIn(700);
				}else{
					if(!firstvisit){
						jQuery('#sidebar-content .below-menu').fadeIn(700);
						jQuery('#sidebar-content .social-icons').fadeIn(700);	
					}
				}
				
				
			//fade page content	
				//dont fade in content if it's mobile size and site is closed on home
					//find out if it's the home page or not
					var loca = top.location.toString();
					if(loca.indexOf('#') < 0){
						var is_realhome = true;
					}	
					
					if(tp_responsive != 'off' && is_realhome && siteisclosed && parseInt(jQuery(window).width()) < 733){
						jQuery('#rsp-lineshine').css({'bottom':'0px','height':'6px'});
						jQuery('#responsive-sidebar').css({'min-height':'100%','padding-bottom':'0px'});
					}else{		
						//reset css 
						if(tp_responsive != 'off' && parseInt(jQuery(window).width()) < 733){
							jQuery('#rsp-lineshine').css({'bottom':'-8px','height':'16px'});
							jQuery('#responsive-sidebar').css({'min-height':'170px','padding-bottom':'20px'});
						}
					
						//page content						
							jQuery('#page-content').delay(200).fadeIn(700,function(){			
								//force page height
								var nu_ph = parseInt(jQuery('#sidebar-content').height()) + 10;
								jQuery('#page').css('min-height',nu_ph+'px');
								
								jQuery(document).trigger('page_is_open', '1');
								
								
									//resize if gmap exists
										if(jQuery('#page-content .mapholder').length > 0){								
											if(typeof google === 'undefined'){					
												jQuery.getScript('http://maps.google.com/maps/api/js?sensor=false&callback=initMap');
											}else{					
												initMap();
											}
										}
							});
				
					}
			
				
				
		};
				
		
		
		
	//PAGE OPENING ANIMATION
		function siteOpen(delay, logoanim){
			
				sitestate = 'open';
				
				if(!delay){ 
					var delay = 100;
				}
				 
				if(logoanim){ 
					var menufadespeed = 'slow';
						if(browser.indexOf('Explorer') > 0){
							menufadespeed = 0;
						}
						
						jQuery('#logo').css({'display':'none','top':'33%'});
						jQuery('.menu > li').css({'display':'none'});
						jQuery('.menu li:last-child').css('background-image','none');

						var countmenuitems = jQuery('.menu > li').length;	
						
						jQuery('#logo').delay(500).fadeIn('slow',function(){
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
											jQuery('#sidebar-content .tp-audio-player').fadeIn(700);

											//open page
												
													if(siteposition == 'center'){	
													//center
																
														jQuery('#page').delay(delay).animate({
															width: '666px',
															right: '0px'
														},openingspeed,function(){
															//site is open, fade in page content
															
																fadeContent();
															});
														
														jQuery('#sidebar').delay(delay).animate({
															left: '0px',
															marginLeft: '0px'
														},openingspeed);
													}else if(siteposition == 'left'){
													//left				
														
														jQuery('#page').delay(delay).animate({					
															right: '8px'
														},openingspeed,function(){
															//site is open, fade in page content
															
																fadeContent();
															
														});
													}else if(siteposition == 'right'){
													//right
															
														jQuery('#page').delay(delay).animate({					
															right: '-8px'					
														},openingspeed,function(){
															//site is open, fade in page content				
																
																
																fadeContent();
															
														});
														
														jQuery('#sidebar').delay(delay).animate({
															marginLeft:'8px',
															left:'0px'					
														},openingspeed);
													}
												
										}
									});				
								});
								
								
							});
						});
				}else{
				
					//open page
						if(siteposition == 'center'){	
						//center
									
							jQuery('#page').delay(delay).animate({
								width: '666px',
								right: '0px'
							},openingspeed,function(){
								//site is open, fade in page content
									
									fadeContent();
								});
							
							jQuery('#sidebar').delay(delay).animate({
								left: '0px',
								marginLeft: '0px'
							},openingspeed);
						}else if(siteposition == 'left'){
						//left				
							
							jQuery('#page').delay(delay).animate({					
								right: '8px'
							},openingspeed,function(){
								//site is open, fade in page content
								
									fadeContent();
								
							});
						}else if(siteposition == 'right'){
						//right
								
							jQuery('#page').delay(delay).animate({					
								right: '-8px'					
							},openingspeed,function(){
								//site is open, fade in page content				
								
									fadeContent();
								
							});
							
							jQuery('#sidebar').delay(delay).animate({
								marginLeft:'8px',
								left:'0px'					
							},openingspeed);
						}
				}
				
			
		}
	
	
	
	//LOAD CONTENT TO PAGE
		function loadContent(){			
				
			url = window.location.hash.substring(1);				
				//add a custom parameter to url so our php loaders will know it's not a direct call
				if(url.indexOf('?') == -1){
					url = url + '?ajaxload=1';
				}else{
					url = url + '&ajaxload=1';						
				}
				
				url = url + " #content";
		
				if(browser.indexOf('Explorer') > 0){				
					//if url's first character is not /					
					if(url.charAt(0) != '/' && url != '?ajaxload=1 #content'){
						url = '/' + url;
					}
				}
				
				//console.log('loading content:'+url);				
				//fade out current content				
				
							
				jQuery('#page-content').fadeOut(200,function(){					
					jQuery('#page-content').html(' ');
					
					if(siteposition == 'right'){
						jQuery('#page-content').css('padding-right','0px');
					}		
					
					//place loading					
					jQuery('#page').prepend('<img src="'+template_url+'/images/loading2.gif" alt="loading" class="loading" />');																			
					jQuery('.loading').fadeIn(300);
										
												
					//load content
					//console.log('LOAD URL: '+url);
					
					jQuery('#page-content').load(url, function(response, status, xhr) { 								
						if(status == 'error'){
						//error
							jQuery('.loading').fadeOut(200,function(){
								jQuery(this).remove();								
							});
							
							if(xhr.status == '404'){
								jQuery('#page-content').html('<section id="content"><h1 class="tp-title">Error #404</h1><div class="vspace2"></div><article><p><strong>Sorry!</strong> The requested page doesn\'t exist!<br /><br /></p><div class="vspace"></div></article></section>');
							}else{
								jQuery('#page-content').html('Error!' + url +'<br />' + xhr.status + ' ' + xhr.statusText);
							}
						}else{
						//success
							jQuery('.loading').fadeOut(200,function(){
								jQuery(this).remove();								
							});
							
							
							jQuery('#page-content').html(response);
														
														
							// APPLY JQUERY FUNCTIONS AFTER CONTENT IS LOADED
								toolStarter();
							
							//if contact form 7 is in loaded content
								if(response.search('wpcf7-form') >= 0){
									jQuery('#page-content').append('<script src="http://'+window.location.hostname + window.location.pathname+'wp-content/plugins/contact-form-7/includes/js/scripts.js"></script>');							
								}

							//set title
								if(jQuery('#page-title').text() != site_title){
									document.title = site_title + ' – ' + jQuery('#page-title').text();
								}			
			
							//fade in content if site is always opened and it's the first visit
								if(firstvisit && sitealwaysopen && sitestate == 'open'){
									fadeContent();
								}
								
							
								
						}
						

						//SET BG SLIDER
							//console.log('set background slider');							
							//check if it's empty or not
							if(jQuery('#tp-bgslider').length != 0 && isResponsive != 'mobile'){												
								//stop current slider, keep .active image, fade in new slider's first image, start slider again
									if(tpInt != null){
										clearInterval(tpInt);
									}
										
									
										jQuery('.bgslider-img').not('.active').remove();
												
										jQuery('#tp-bgslider').prepend( jQuery('#page-bgslider-images').html() );													
										var tpbgs_fade = jQuery('#page-bgslider-datas').attr('data-fade');
										var tpbgs_pause = jQuery('#page-bgslider-datas').attr('data-pause');
										//console.log('BGS: '+tpbgs_fade+' / '+tpbgs_pause);
									
										jQuery('#tp-bgslider').bgSlider(true,tpbgs_fade,tpbgs_pause);													
										
										jQuery('.bgslider-img.active').last().fadeOut(500,function(){
											jQuery(this).remove();																									
											jQuery('.bgslider-img').last().addClass('active');
										});				
										
										if(jQuery('#tp-bgslider-holder').css('display') == 'none'){
											jQuery('#tp-bgslider-holder').fadeIn(700);
										}
									
								
							}else{
								//insert slider images
								if(isResponsive != 'mobile'){
									jQuery('#tp-bgslider-holder').append('<!-- BACKGROUND SLIDER --><div id="tp-bgslider">'+jQuery('#page-bgslider-images').html()+'</div>');				
									var tpbgs_fade = jQuery('#page-bgslider-datas').attr('data-fade');
									var tpbgs_pause = jQuery('#page-bgslider-datas').attr('data-pause');								
									//console.log('BGS: '+tpbgs_fade+' / '+tpbgs_pause);
									//jQuery('#tp-bgslider-holder img:first-child').load(function(){									
										jQuery('#tp-bgslider').bgSlider(false,tpbgs_fade,tpbgs_pause);
										jQuery('#tp-bgslider-holder').delay(200).fadeIn(700);
									//});				
								}
							}
							
					});
						
				});	
		}
	
	
		
	//SETUP, ANIMATE, LOAD CONTENT
		function pageSetup(){
			
			
			//OPENING ANIMATION IF NECESSARY AND IS ENABLED
				//console.log('run opening animation if necessary and enabled');
								
					if(siteisclosed){
					//site is closed on homepage
						//open it if requested page is not homepage and site is closed
						
						var cleanurl = window.location.hash.substring(1);
						if(cleanurl){						
							if(sitestate == 'closed'){
								siteOpen();
							}else{
								fadeContent();
							}
						}else{ 
							if(sitestate == 'open'){
								fadeContent();
							}else{
							//homepage is closed, site is closed, show logo anim if enabled
								if(logoanim){
									var menufadespeed = 'slow';
									if(browser.indexOf('Explorer') > 0){
										menufadespeed = 0;
									}
									
									var countmenuitems = jQuery('.menu > li').length;	
									jQuery('#logo').delay(500).fadeIn('slow',function(){
										//move logo
										jQuery('#logo').delay(200).animate({
											top: '0px'
										},900,function(){  
											//logo is in place, show menu	
								
											if(jQuery('.menu > li:last-child').css('display') == 'none'){
												jQuery('.menu > li').each(function(index){ 
													jQuery(this).delay(150*index).fadeIn(menufadespeed,function(){
														countmenuitems--;
														if(countmenuitems < 1){																			
															jQuery('#sidebar-content .below-menu').fadeIn(700);
															jQuery('#sidebar-content .social-icons').fadeIn(700);
															jQuery('#sidebar-content .tp-audio-player').fadeIn(700);
														}
													});
												});
											}else{
												//just fade in sidebar content, menu is already visible
												jQuery('#sidebar-content .below-menu').fadeIn(700);
												jQuery('#sidebar-content .social-icons').fadeIn(700);
												jQuery('#sidebar-content .tp-audio-player').fadeIn(700);
											}
										});
									});
								}else{
									//just fade in sidebar content
									jQuery('#sidebar-content .below-menu').fadeIn(700);
									jQuery('#sidebar-content .social-icons').fadeIn(700);
									jQuery('#sidebar-content .tp-audio-player').fadeIn(700);
								}
								
							}
						}	
					}else{							
						if(firstvisit){
							//FIRST VISIT					
							
							if(sitestate == 'closed'){					
								//if logo anim enabled, do it								
								if(logoanim){
									siteOpen(100,true);
								}else{
									//delay site opening animation
									siteOpen(1200);							
								}
							}else{
								fadeContent();
							}
						}else{
							fadeContent();
						}						
					}
				
		}

		
		
	//PAGE SETUP FOR TABLET
		function pageSetupTablet(){
			//if site is closed and we're not on HP, open it																					
			var urlcheck = window.location.hash.substring(1);						
			if((urlcheck && sitestate == 'closed')){			
				sitestate = 'open';
				
				jQuery('#page').animate({					
					left: '50px'
				},openingspeed,function(){
					//site is open, fade in page content					
						fadeContent();
				});			
				
			}else if(firstvisit && !urlcheck && sitestate == 'closed'){
			//if site is closed and we're on homepage, and it's first visit
				var menufadespeed = 'slow';
				if(browser.indexOf('Explorer') > 0){
					menufadespeed = 0;
				}
									
				jQuery('#logo').delay(500).fadeIn('slow',function(){
					//move logo
					jQuery('#logo').delay(200).animate({
						top: '0%'
					},900,function(){
						//logo is in place, show menu and icons								
							jQuery('#sidebar-content .below-menu').fadeIn(700);
							jQuery('#sidebar-content .social-icons').fadeIn(700);
							jQuery('.menu').fadeIn(700,function(){
								//if site is not closed on home, hide SB, show page
								if(!siteisclosed){
									jQuery('#sidebar').delay(200).animate({
										left: '-322px'
									},500);
									
									jQuery('#page').delay(200).animate({					
										left: '50px'
									},openingspeed,function(){
										//site is open, fade in page content					
											fadeContent();
									});	
								}							
							});							
					});
				});
			}else{
				fadeContent();
			}		
		
		}
		
		
		
	//PAGE SETUP FOR MOBILE
		function pageSetupMobile(){
			
			
			fadeContent();
		}	
	
	

//disable this function 
function addComment(){
	return false;
}	
addComment.moveForm = function(commentid,parent,postid){
	//update hidden value > comment parent		
		jQuery('#commentform #comment_parent').val(parent);	

	return false;
}	