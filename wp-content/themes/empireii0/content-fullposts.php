<?php

$real_page_id = get_the_ID();

$_SESSION['blogtype'] = 'full';

//READ WHICH CATEGORIES TO DISPLAY
	if(!empty($real_page_id)){
		$bc = get_post_meta($real_page_id, 'tp_blog_cats', true);
		if(is_array($bc)){
			$categories_to_display = implode(',',$bc);
		}
	}

	$paged = get_query_var('paged');
	if($paged == ''){ $paged = get_query_var('page'); }
	
	if(!empty($categories_to_display)){		
		$args=array(
			'post_type' => 'post',
			'paged' => $paged,
			'category_name' => $categories_to_display
		);		
	}else{
		$args=array(
			'post_type' => 'post',
			'paged' => $paged
			
		);
	}
	
		// CHECK & FILTER CATEGORIES
			$wp_query = new WP_Query( $args );			
			while ( $wp_query->have_posts() ) {
				$wp_query->the_post();
				
				
				//PRINT POSTS		
				//posts
					$postclass = get_post_class();
					$postclass[] = 'single-post';
					
					if(has_post_thumbnail()){
						$postclass[] = 'has-thumb';
					}
					print '<article id="post-'.get_the_ID().'" class="'.implode(' ',$postclass).'">';
					
							//title
								if(get_post_format() == 'link'){
									print '<h1><a href="'.get_post_meta($post->ID,'tp_postf_link',true).'" target="_blank" title="'; the_title_attribute(); print '">'.get_the_title().'</a></h1>';
								}else{
									print '<h1><a href="'.get_permalink().'">'.get_the_title().'</a></h1>';									
								}
								$curtitle = get_the_title();
							
							
							//info line
								print '<div class="info">
									<img src="'.get_bloginfo('template_url').'/images/blog-date.png" alt="post date" />'.get_the_date().'&nbsp;&nbsp;&#8226;&nbsp;&nbsp;
									<img src="'.get_bloginfo('template_url').'/images/blog-categories.png" alt="post categories" />'.str_replace('rel="category"','',get_the_category_list( __( ', ', 'empire' ) ));
									
									if(comments_open()){
										print '&nbsp;&nbsp;&#8226;&nbsp;&nbsp;
										<img src="'.get_bloginfo('template_url').'/images/blog-comments.png" alt="post comments number" />'; comments_number( __('0 comment','empire'), __('1 comment','empire'), __('% comments','empire') ); 
									}
									
									print '
								</div>';
							
							
							//featured image
								if(get_post_format() == 'image' || get_post_format() == 'quote'){
									if(has_post_thumbnail()){
										$src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'single-thumb', false );
										print '<div class="featured-image" style="background-image:url('.$src[0].')"></div>';
									}
								}
								
								

							//content
								if(get_post_format() == 'quote'){
									print '<blockquote>'; the_content(); print '</blockquote>';
								}elseif(get_post_format() == 'audio'){
									if(strstr(get_post_meta($post->ID,'tp_postf_audio',true), '.mp3')){
									//audio player
										print '<audio class="mejs" src="'.get_post_meta($post->ID,'tp_postf_audio',true).'" controls="controls"></audio>
										<script type="text/javascript">				
											jQuery(document).ready(function($) {		
												$("#content audio").mediaelementplayer({
													
													startVolume: 0.20,		
													loop: false,
													features: ["playpause","volume","progress"],
													audioHeight: 35,
													audioWidth: 374
												});		
												jQuery(".mejs-offscreen").text("");
											});
										</script>
										';
									}else{
										$tp_postf_audio = get_post_meta($post->ID,'tp_postf_audio',true);
										if(!empty($tp_postf_audio)){
											print get_post_meta($post->ID,'tp_postf_audio',true);
										}
									}
								
									the_content();	
								}elseif(get_post_format() == 'video'){
									$tp_postf_video = get_post_meta($post->ID,'tp_postf_video',true);
									if(!empty($tp_postf_video)){
										$pattern = '/(width)="[0-9]*"/i';											
										$cnt = preg_replace($pattern,'style="width:99%"',get_post_meta($post->ID,'tp_postf_video',true));														
										print $cnt;
									}
									
									the_content();
								}else{
									the_content();					
								}
								
								wp_link_pages( array( 'before' => '<div class="page-links">' . __( '<strong>Pages:</strong>', 'empire' ), 'after' => '</div>' ) ); 								
								
						
					print '</article>';
				
					//post separator					
						print '<div class="post-sep"></div>';
					
				
			}
			
			
			

			//PAGINATION
				if(function_exists('wp_paginate')) {
					print '<hr>';
					wp_paginate();		
				} 
				else{
					//display default next/prev links
					
					if($wp_query->max_num_pages > 1 ){								
						
						print '						
						<div id="page_control">';
						
							print '<div id="left">'; previous_posts_link('<div id="page_control-newer">'.__('PREVIOUS PAGE ','empire').'</div>'); print '&nbsp;</div>';
						
							print '<div class="pageof">- ';
								$page_curr = (get_query_var('paged')) ? get_query_var('paged') : 1;								
								print sprintf(__('PAGE %d OF %d','empire'),$page_curr,$wp_query->max_num_pages);
							print ' -</div>';
							
							
							print '<div id="right">&nbsp;'; next_posts_link('<div id="page_control-older">'.__('NEXT PAGE','empire').'</div>'); print '</div>';
						print '
						</div>';
					

						//responsive
						print '						
						<div id="page_control-responsive">';
						
						
							print '<div class="pageof">- ';
								$page_curr = (get_query_var('paged')) ? get_query_var('paged') : 1;								
								print sprintf(__('PAGE %d OF %d','empire'),$page_curr,$wp_query->max_num_pages);
							print ' -</div>';
							
						
							print '
							<div id="leftr">'; previous_posts_link('<div id="page_control-newerr">'.__('PREVIOUS PAGE ','empire').'</div>'); print '&nbsp;</div>
							<div id="rightr">&nbsp;'; next_posts_link('<div id="page_control-olderr">'.__('NEXT PAGE','empire').'</div>'); print '</div>';
						print '
						</div>';
					
					}
				}			
			
			wp_reset_query();	
			wp_reset_postdata();
			
			
	
?>	