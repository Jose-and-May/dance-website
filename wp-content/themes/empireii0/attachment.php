<?php  
get_header(); 

$type = get_post_mime_type( $post->ID );
	
	print '<div id="content">';

	switch ( $type ) {  	
		case 'image/jpeg':  
			
			print '
			<img src="'.wp_get_attachment_url( $post->ID ).'" alt="image attachment" class="image" />';
			
			break;  
		default:  
			//show link to file
		
			print '<p><strong>'.__('Link to the file:','empire').'</strong> <a class="colorizer" href="'.wp_get_attachment_url( $post->ID ).'">'.wp_get_attachment_url( $post->ID ).'</a></p>';
		
			break;  
	}

	print '</div>';

//FOOTER	
get_footer();

?>  