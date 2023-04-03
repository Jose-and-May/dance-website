jQuery(document).ready(function(){
	jQuery('#tp-upload').click(function(){
		wp.media.editor.send.attachment = function(props, attachment){
			//check extension
			var iurl = attachment.url;
			var iext = attachment.url.split('.').pop();
			if(iext != 'jpg' && iext != 'jpeg' && iext != 'mp4'){
				iurl = templateDir+'/images/unsupported-file.jpg';
			}			
			if(iext == 'mp4'){
				iurl = templateDir+'/images/mp4-file.jpg';
			}			
			
			jQuery('#slide-images .holder').append('<div class="tp-bgslider-image" style="background-image:url('+iurl+');" data-src="'+attachment.url+'" title="'+attachment.url+'"><div class="remove" data-src="'+attachment.url+'"></div><input type="hidden" name="form-images[]" value="'+attachment.url+'" /></div>');			
			
		}
		
		wp.media.editor.open(this);
		
		return false;
	});
	
	
	jQuery('#slide-images .holder').sortable({ opacity: 0.5 });
	
	//remove thumb
	jQuery(document).on('click', '#slide-images .remove', function() {			
		//remove thumb
		jQuery(this).parent('.tp-bgslider-image').remove();
	});
});