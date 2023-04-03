jQuery(document).ready(function($) {	

	//make list sortable, draggable
	$('#mp3_files').sortable({
		connectWith: '#mp3_files',
		cursor: 'pointer'
	});

	
	$('#mp3_files .item-delete').click(function(event){
		event.preventDefault();
		
		$(this).closest('div').remove();
		
	});
	
	
	
	$('#add_new_mp3').click(function(){
			wp.media.editor.send.attachment = function(props, attachment){				
				
				var mp3id = new Date().getTime();
				
				$('#mp3_files').append('<div>'+
					'<p><label>File URL</label> <input type="text" name="form-mp3['+mp3id+'][url]" value="'+attachment.url+'" /></p>'+
					'<p class="margin"><label>Artist</label> <input type="text" class="smaller"  name="form-mp3['+mp3id+'][artist]" value="" /></p>'+
					'<p><label>Track Title</label> <input type="text" class="smaller"  name="form-mp3['+mp3id+'][title]" value="" /></p>'+
					'<p class="removep"><a class="item-delete submitdelete deletion" href="#">Remove</a></p>'+
				'</div>');
				
			}

			wp.media.editor.open(this);

			return false;
	});
	
});