/*

Background Slider Plugin v1.1

Copyright (C) ThemePrince.com - All rights reserved!

*/

var tpInt;

jQuery.fn.bgSlider = function(noActive,fade_speed,pause,delay) {	
	'use strict';

	var i = 0; //curr index
	var actr = 0;
	
	if(!fade_speed){fade_speed = 800;}else{fade_speed = parseInt(fade_speed);} 
	if(!pause){pause = 5000;}
	if(!delay){delay = 0;}
	
		
	var this_div = jQuery(this);
	
	//detect ie8 or lover
	var ieversion;
	if (/MSIE (\d+\.\d+);/.test(navigator.userAgent)){
		ieversion=new Number(RegExp.$1);
	}
	
		
	
	
	
	//get images
	var tp_bgs_imgs = new Array();	
		//remove video elements to save memory
		jQuery('video',this).each(function(){	
			jQuery(this).remove();
		});
	
		jQuery('img',this).each(function(){		
			tp_bgs_imgs[actr] = jQuery(this).attr('src');		
			
			jQuery(this).remove();
			this_div.prepend('<div id="bg_slider-'+actr+'" class="bgslider-img"></div>');
					
			
			jQuery('#bg_slider-'+actr).css({'background-image':'url('+tp_bgs_imgs[actr]+')'});
			
			//IE8 fix
				if(ieversion <= 8){			
					jQuery('#bg_slider-'+actr).css('filter','progid:DXImageTransform.Microsoft.AlphaImageLoader(src="'+tp_bgs_imgs[actr]+'",sizingMethod="scale");');
					jQuery('#bg_slider-'+actr).css('-ms-filter','"progid:DXImageTransform.Microsoft.AlphaImageLoader(src=\''+tp_bgs_imgs[actr]+'\',sizingMethod=\'scale\')";');
				}
				
					
			actr++;
		});
	
	
	
	if(!noActive){
		jQuery('.bgslider-img').last().addClass('active');
	}
	
	
	
	//ROTATING FUNCTION
		var change = function(){				
				var j = i + 1;
				
				
				
				if(tp_bgs_imgs.length == j){
					j = 0;
					//on last item fade in the 1st
					
					jQuery('#bg_slider-'+j).animate({'opacity':'1'},{ queue: false, duration: fade_speed, complete: function(){
							jQuery('#tp-bgslider .active').removeClass('active');
							jQuery(this).addClass('active');
							jQuery('.bgslider-img').css('opacity','1');
							
						}
					});
					
					
				}
				else{
					//fade out current slide
					var k = i+1;			
					
					
					jQuery('#bg_slider-'+i).animate({'opacity':'0'},{ queue: false, duration: fade_speed, complete: function(){
					
					
							jQuery('#tp-bgslider .active').removeClass('active');
							jQuery('#bg_slider-'+k).addClass('active');
						}
					});		
				}	
			
				//change current index
				i = j;				
				
		};
	
	
	//DELAY
		if(delay > 0){
			if(tp_bgs_imgs.length > 1){	//start only if we have more than 1 image
				var tpTimeout = setTimeout(function(){
					tpInt = setInterval(change, pause);		//start the loop
				},delay);	
			}
		}else{
			if(tp_bgs_imgs.length > 1){	//start only if we have more than 1 image
				tpInt = setInterval(change, pause);		//start the loop
			}
		}
		
};


	
	
	