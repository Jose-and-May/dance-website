<?php
/*
	Template for displaying Comments.
*/

// if the current post is protected by a password and the visitor has not yet entered the password we will return early without loading the comments. */
	if ( post_password_required() ){
		return;
	}

	
if ( have_comments() ){

	print '	
	<h5>'.__('COMMENTS','empire').' <span>('.get_comments_number().')</span></h5>';

	print '
	<ul class="commentlist">
	'; 
	
	//list comments
		wp_list_comments( array( 'callback' => 'tp_comments' ) ); 
			
	print '
	</ul>	
	';
	
	//comment nav
	if ( get_comment_pages_count() > 1 && get_option( 'page_comments' ) ) {
		print '<nav id="comment-nav-below" class="navigation" role="navigation">			
			<div class="nav-previous">'; previous_comments_link( __( 'PREVIOUS', 'empire' ) ); print '</div>
			<div class="nav-next">'; next_comments_link( __( 'NEXT', 'empire' ) ); print '</div>
		</nav>';
	}	
		
}

	
	//for translation
	print '<p class="hidden" id="comment-thanks">'.__('Thank you for submitting your comment!','empire').'</p>';
	
	
	
if(comments_open()){	
	comment_form( array( 
		'title_reply' => __('LEAVE A REPLY ','empire'),
		'comment_field' => '<p class="comment-form-comment"><textarea id="comment" name="comment" cols="45" rows="4" aria-required="true"></textarea></p>',
		'comment_notes_after' => '',
		'comment_notes_before' => '',
		'label_submit' => __('SUBMIT','empire'),
		'fields' => array(
			'author' => '<p class="comment-form-author"><input id="author" name="author" type="text" value="' . __('Your Name', 'empire') . '" size="30" onfocus="if(this.value==\'Your Name\'){this.value=\'\'};" onblur="if(this.value==\'\'){this.value=\'Your Name\'}" /></p>',
			'email' => '<p class="comment-form-email"><input id="email" name="email" type="text" value="' . __('Email Address', 'empire') . '" size="30" onfocus="if(this.value==\'Email Address\'){this.value=\'\'};" onblur="if(this.value==\'\'){this.value=\'Email Address\'}" /></p>',
			'url' => '<p class="comment-form-url"><input id="url" name="url" type="text" value="' . __('Your Website', 'empire') . '" size="30" onfocus="if(this.value==\'Your Website\'){this.value=\'\'};" onblur="if(this.value==\'\'){this.value=\'Your Website\'}" /></p>'
			)
	) );
}
	
?>
