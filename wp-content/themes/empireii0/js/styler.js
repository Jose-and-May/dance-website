jQuery(document).ready(function($) {		
	"use strict";		
	

	$('.openclose').click(function(){
		if(parseInt(jQuery('#styler').css('left')) != '0'){
			jQuery('#styler').animate({
				left: '0'
			},500);
		}else{
			jQuery('#styler').animate({
				left: '-200'
			},500);
		}
		
		return false;
	});
	
	
	$('#styler .texture li a').click(function(){		
		$('#sidebar #texture').removeClass();		
		$('#sidebar #texture').addClass('texture-'+$(this).attr('data-id'));
	
		return false;
	});
	
	
});