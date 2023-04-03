<?php
/*
	Template to display search, category, tag, author, archive results.
*/

				
			//PRINT POSTS				
				if(is_search()){
				//SEARCH RESULTS
					if(get_post_type() == 'post'){
						$GLOBALS['results_posts'][] = '<h6 class="results-title"><a href="'.get_permalink().'">'.get_the_title().'</a></h6>
						<p class="results-date">'.get_the_date().'</p>';
					}else{
						$GLOBALS['results_pages'][] = '<h6 class="results-title"><a href="'.get_permalink().'">'.get_the_title().'</a></h6>
						<p></p>';
					}
				
				}else{
				//POSTS
					$postclass = get_post_class();
					if(has_post_thumbnail()){
						$postclass[] = 'has-thumb';
					}
					print '<article class="'.implode(' ',$postclass).'">';
					
									
						//info line
							print '
							<div class="info">
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
									print '<a href="'.get_post_meta($post->ID,'tp_postf_link',true).'" target="_blank">'.get_the_post_thumbnail( $post->ID, array(211,140)).'</a>';																		
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
									print '<a href="'.get_permalink().'">'.get_the_post_thumbnail( $post->ID, array(211,140)).'</a>';																		
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
									print '<a href="'.get_permalink().'">'.get_the_post_thumbnail( $post->ID, array(211,140)).'</a>';																		
								}
								
								print '<h5><a href="'.get_permalink().'" title="'; the_title_attribute(); print '">'.get_the_title().'</a></h5>';
								print '<blockquote>'; the_content(); print '</blockquote>';
							
							print '
							</div>';
							
						}elseif(get_post_format() == 'audio'){
							print '
							<div class="text">';
							
							//thumbnail, title, excerpt
																
								//if content is mp3, show custom player
								if(strstr(get_post_meta($post->ID,'tp_postf_audio',true), '.mp3')){
									if(has_post_thumbnail()){
										print '<a href="'.get_permalink().'">'.get_the_post_thumbnail( $post->ID, array(211,140)).'</a>';																		
									}
									
									print '<h5><a href="'.get_permalink().'" title="'; the_title_attribute(); print '">'.get_the_title().'</a></h5>';
									
									//audio player
									print '<audio class="mejs" src="'.get_post_meta($post->ID,'tp_postf_audio',true).'" type="audio/mp3" controls="controls"></audio>
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
									print '<a href="'.get_permalink().'">'.get_the_post_thumbnail( $post->ID, array(211,140)).'<div class="play"></div></a>';																		
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
									print '<a href="'.get_permalink().'">'.get_the_post_thumbnail( $post->ID, array(211,140)).'</a>';																		
								}
								
								print '<h5><a href="'.get_permalink().'" title="'; the_title_attribute(); print '">'.get_the_title().'</a></h5>';
								the_excerpt();
							
							print '
							</div>';
								
						}
									
								
						
						
					print '</article>';
				}
				
?>	