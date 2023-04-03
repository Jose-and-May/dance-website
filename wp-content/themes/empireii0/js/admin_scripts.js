jQuery(document).ready(function() {
	
	
	//PORTFOLIO SETTINGS
		if(jQuery('#page_template option:selected').val() != 'page-portfolio.php'){
			jQuery('#new-meta-boxes-tp-portfolio').css('display','none');
		}
		
		jQuery('#page_template').change(function(){
			if(jQuery('option:selected',this).val() == 'page-portfolio.php'){
				jQuery('#new-meta-boxes-tp-portfolio').css('display','block');
			}else{
				jQuery('#new-meta-boxes-tp-portfolio').css('display','none');
			}
		});
	
	
	//CONTENT BACKGROUND IMAGE
		jQuery('#set-bg-image').click(function(){
			wp.media.editor.send.attachment = function(props, attachment){
				jQuery('#tp_pagepost_bg_image').val(attachment.url);
				jQuery('p.btnlink').prepend('<img width="258" alt="heading" src="'+attachment.url+'" />');				
				jQuery('a#set-bg-image').addClass('hidden');
				jQuery('a#remove-bg-image').removeClass();
			}

			wp.media.editor.open(this);

			return false;
		});		
		
		jQuery('a#remove-bg-image').click(function(){
			jQuery('#tp_pagepost_bg_image').val('');
			jQuery('p.btnlink img').remove();
			jQuery('a#set-bg-image').removeClass();
			jQuery('a#remove-bg-image').addClass('hidden');
		});
	
	
	
	//POST FORMATS
		if(jQuery('#new-meta-boxes-postf').length != 0){
			jQuery('#new-meta-boxes-postf').insertAfter('#titlediv');
		}
		
		jQuery('#new-meta-boxes-postf, .postf-contents').css('display','none');
		var $postf = jQuery('input.post-format:checked');
		if($postf.val() == 'link'){		
			jQuery('#new-meta-boxes-postf,#postf-link').css('display','block');
		}
		else if($postf.val() == 'audio'){		
			jQuery('#new-meta-boxes-postf,#postf-audio').css('display','block');
		}
		else if($postf.val() == 'video'){		
			jQuery('#new-meta-boxes-postf,#postf-video').css('display','block');
		}
		jQuery('input.post-format').change(function(){
			$postf = jQuery('input.post-format:checked');
			jQuery('#new-meta-boxes-postf,.postf-contents').css('display','none');		
			if($postf.val() == 'link'){
				jQuery('#new-meta-boxes-postf,#postf-link').css('display','block');
			}
			else if($postf.val() == 'audio'){
				jQuery('#new-meta-boxes-postf,#postf-audio').css('display','block');
			}
			else if($postf.val() == 'video'){
				jQuery('#new-meta-boxes-postf,#postf-video').css('display','block');
			}
		});
		

	
	
	
	
});

	
	