<?php

$real_page_id = get_the_ID();

global $wp_query, $paged;

$_SESSION['blogtype'] = 'classic';


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
				if(is_search()){
				//search results
				
				
				
				}else{
				//posts
					$postclass = get_post_class();
					if(has_post_thumbnail()){
						$postclass[] = 'has-thumb';
					}
					print '<article class="'.implode(' ',$postclass).'">';
					
									
						//info line
							print '
							<div class="info">';
							
							if(is_sticky()){
								print '<img src="'.get_bloginfo('template_url').'/images/sticky.png" alt="sticky post" />&nbsp;&nbsp;|&nbsp;&nbsp;';
							}
							
							print '
								<img src="'.get_bloginfo('template_url').'/images/blog-date.png" alt="post date" />'.get_the_date().'&nbsp;&nbsp;|&nbsp;&nbsp;
								<img src="'.get_bloginfo('template_url').'/images/blog-categories.png" alt="post categories" />'.str_replace('rel="category"','',get_the_category_list( __( ', ', 'empire' ) )).'&nbsp;&nbsp;|&nbsp;&nbsp;
								<img src="'.get_bloginfo('template_url').'/images/blog-comments.png" alt="post comments number" />'; comments_number( __('0 comment','empire'), __('1 comment','empire'), __('% comments','empire') ); print '
								
								<a class="moretag" href="'. get_permalink($post->ID) . '">'.__('Read more &nbsp;&gt;','empire').'</a>
							</div>';
								
								
						if(get_post_format() == 'link'){						
							print '
							<div class="text">';
							
							//thumbnail, title, excerpt
								if(has_post_thumbnail()){
									print '<a href="'.get_post_meta($post->ID,'tp_postf_link',true).'" target="_blank" class="thumb">'.get_the_post_thumbnail( $post->ID, array(211,140)).'</a>';																		
								}
								
								print '<h5><a href="'.get_post_meta($post->ID,'tp_postf_link',true).'" target="_blank">'.get_the_title().'</a></h5>';
								
								the_excerpt();
							
							print '
							</div>';
							
						}elseif(get_post_format() == 'image' || get_post_format() == 'gallery'){
							print '
							<div class="text">';
							
							//thumbnail, title, excerpt
								if(has_post_thumbnail()){
									print '<a href="'.get_permalink().'" class="thumb">'.get_the_post_thumbnail( $post->ID, array(211,140)).'</a>';																		
								}
								
								print '<h5><a href="'.get_permalink().'" title="'; the_title_attribute(); print '">'.get_the_title().'</a></h5>';
								the_excerpt();
							
							print '
							</div>';
							
						}elseif(get_post_format() == 'quote'){
							print '
							<div class="text quote">';
							
							//thumbnail, title, excerpt
								if(has_post_thumbnail()){
									print '<a href="'.get_permalink().'" class="thumb">'.get_the_post_thumbnail( $post->ID, array(211,140)).'</a>';																		
								}
								
								print '<h5><a href="'.get_permalink().'" title="'; the_title_attribute(); print '">'.get_the_title().'</a></h5>';
								
								if(strstr(get_the_content(),'<blockquote>')){
									the_content();
								}else{
									print '<blockquote>'; the_content(); print '</blockquote>';
								}
							
							print '
							</div>';
							
						}elseif(get_post_format() == 'audio'){
							print '
							<div class="text">';
							
							//thumbnail, title, excerpt
																
								//if content is mp3, show custom player
								if(strstr(get_post_meta($post->ID,'tp_postf_audio',true), '.mp3')){
									if(has_post_thumbnail()){
										print '<a href="'.get_permalink().'" class="thumb">'.get_the_post_thumbnail( $post->ID, array(211,140)).'</a>';																		
									}
									
									print '<h5><a href="'.get_permalink().'" title="'; the_title_attribute(); print '">'.get_the_title().'</a></h5>';
									
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
									if(!has_post_thumbnail()){
										print '<div class="clear"></div>';									
									}

								}else{
									print '<h5><a href="'.get_permalink().'" title="'; the_title_attribute(); print '">'.get_the_title().'</a></h5>';
									
									print get_post_meta($post->ID,'tp_postf_audio',true);
								}
								
								the_excerpt();
							
							print '
							</div>';
							
						}elseif(get_post_format() == 'video'){
							print '
							<div class="text">';
							
							//thumbnail, title, excerpt
								if(has_post_thumbnail()){
									print '<a href="'.get_permalink().'" class="thumb">'.get_the_post_thumbnail( $post->ID, array(211,140)).'<div class="play"></div></a>';																		
								}
								
								print '<h5><a href="'.get_permalink().'" title="'; the_title_attribute(); print '">'.get_the_title().'</a></h5>';
								the_excerpt();
							
							print '
							</div>';
							
						}else{				
							print '
							<div class="text">';
							
							//thumbnail, title, excerpt
								if(has_post_thumbnail()){
									print '<a href="'.get_permalink().'" class="thumb">'.get_the_post_thumbnail( $post->ID, array(211,140)).'</a>';																		
								}
								
								print '<h5><a href="'.get_permalink().'" title="'; the_title_attribute(); print '">'.get_the_title().'</a></h5>';
								the_excerpt();
							
							print '
							</div>';
								
						}
									
								
						
						
					print '</article>';
				}
				
				
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
						<hr>
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