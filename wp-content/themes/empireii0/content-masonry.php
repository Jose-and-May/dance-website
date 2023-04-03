<?php

$real_page_id = get_the_ID();

global $wp_query, $paged;

$_SESSION['blogtype'] = 'masonry';

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
		$cat_id = get_query_var('cat');
		$cat_slug = get_category($cat_id)->slug; 		
		
		$tag_id = get_query_var('tag_id');
			
		if($_GET['m'] != ''){
			$archive_year = substr($_GET['m'],0,4);
			$archive_month = substr($_GET['m'],4,2);
		}else{
			$archive_year = get_query_var('year');
			$archive_month = get_query_var('monthnum');
		}
		
		
		if(!empty($cat_slug)){
		//category
			$args=array(
				'post_type' => 'post',
				'paged' => $paged,
				'category_name' => $cat_slug			
			);
		}elseif($tag_id != ''){
		//tag
			$args=array(
				'post_type' => 'post',
				'paged' => $paged,
				'tag_id' => $tag_id
			);	
		}elseif(!empty($archive_year)){
		//archive
			$args=array(
				'post_type' => 'post',
				'paged' => $paged,
				'year' => $archive_year,
				'monthnum' => $archive_month
			);		
		}else{		
			$args=array(
				'post_type' => 'post',
				'paged' => $paged			
			);
		}
		

		
	}
	
	
	
	
		// CHECK & FILTER CATEGORIES
						
			$output['left'] = '';
			$output['right'] = '';
			$lr = 'left';
			$wctr = 0;
			$wp_query = new WP_Query( $args );			
			while ( $wp_query->have_posts() ) {
				$wp_query->the_post();
				
				
				if($wctr % 2 == 0){
					$lr = 'left';
				}else{
					$lr = 'right';
				}
				
				//PRINT POSTS								
				//posts
					$postclass = get_post_class();
					if(has_post_thumbnail()){
						$postclass[] = 'has-thumb';
					}
					if(is_sticky()){
						$postclass[] = 'sticky';
					}
					
					$output[$lr] .= '
					<div class="brick '.implode(' ',$postclass).'">';
					
						//category
							$output[$lr] .= '<p class="categories">'.str_replace('rel="category"','',get_the_category_list( __( ', ', 'empire' ) )).'</p>';
							
						//title
							if(get_post_format() == 'link'){
								$output[$lr] .= '<h2><a href="'.get_post_meta($post->ID,'tp_postf_link',true).'" target="_blank">'.get_the_title().'</a></h2>';
							}else{
								$output[$lr] .= '<h2><a href="'.get_permalink().'">'.get_the_title().'</a></h2>';								
							}
						
						//info							
							$num_comments = get_comments_number();
							if ( comments_open() ) {
								if ( $num_comments == 0 ) {
									$comments = __('0 Comment','empire');
								} elseif ( $num_comments > 1 ) {
									$comments = $num_comments . __(' Comments','empire');
								} else {
									$comments = __('1 Comment','empire');
								}
								$comments = '<a href="' . get_comments_link() .'">'. $comments.'</a>';
							} else {
								$comments = '';
							}
							$output[$lr] .= '
							<div class="info">
								<img src="'.get_bloginfo('template_url').'/images/blog-date.png" alt="post date" />'.get_the_date().'&nbsp;&nbsp;&#8226;&nbsp;&nbsp;<img src="'.get_bloginfo('template_url').'/images/blog-comments.png" alt="post comments number" />'.$comments.'
							</div>';
						
						//excerpt						
							if(get_post_format() == 'quote'){
								if(strstr(get_the_content(),'<blockquote>')){
									$output[$lr] .= get_the_content();
								}else{
									$output[$lr] .= '<blockquote>'.get_the_content().'</blockquote>';
								}
								
							}else{
								$output[$lr] .= '<p class="excerpt">'.get_the_excerpt().'</p>';
							}
						
						//thumbnail
							if(get_post_format() == 'video'){
								if(has_post_thumbnail()){
									$output[$lr] .= '<a href="'.get_permalink().'" class="video-thumb">'.get_the_post_thumbnail( $post->ID, 'masonry-thumb').'<div class="play"></div></a>';																		
								}else{
									$pattern = '/(width)="[0-9]*"/i';
									$patternb = '/(height)="[0-9]*"/i';
									$cnt = preg_replace($pattern,'style="width:99%"',get_post_meta($post->ID,'tp_postf_video',true));			
									$cnt = preg_replace($patternb,'height="440"',$cnt);
									$output[$lr] .= $cnt;
								}
							}elseif(get_post_format() == 'link'){
								if(has_post_thumbnail()){
									$output[$lr] .= '<a href="'.get_post_meta($post->ID,'tp_postf_link',true).'" target="_blank">'.get_the_post_thumbnail( $post->ID, 'masonry-thumb').'</a>';																		
								}
							}elseif(get_post_format() == 'audio'){
								if(strstr(get_post_meta($post->ID,'tp_postf_audio',true), '.mp3')){
									if(has_post_thumbnail()){
										$output[$lr] .= '<a href="'.get_permalink().'">'.get_the_post_thumbnail( $post->ID, 'masonry-thumb').'</a>';																																			
									}
																		
									//audio player
									$output[$lr] .= '<audio class="mejs" src="'.get_post_meta($post->ID,'tp_postf_audio',true).'"  controls="controls"></audio>
									<script type="text/javascript">				
										jQuery(document).ready(function($) {		
											$("#content audio").mediaelementplayer({
												
												startVolume: 0.20,		
												loop: false,
												features: ["playpause","volume","progress"],
												audioHeight: 35,
												audioWidth: 273
											});		
											jQuery(".mejs-offscreen").text("");
										});
									</script>
									';
								}else{
									$output[$lr] .= get_post_meta($post->ID,'tp_postf_audio',true);								
								}
							}elseif(get_post_format() == 'gallery'){								
								if(has_post_thumbnail()){								
									$output[$lr] .= '<a href="'.get_permalink().'">'.get_the_post_thumbnail( $post->ID, 'masonry-thumb').'</a>';
								}
									
								$gallery = get_post_gallery_images($post->ID);
								if(!empty($gallery)){										
									$output[$lr] .= '<ul class="small-gal">';
									$gctr = 1;
									unset($gallery[0]);
									foreach($gallery as $img){
										if($gctr >= 4){ 
											$output[$lr] .= '<li class="nomg"><a href="'.get_permalink().'"><img src="'.$img.'" alt="gallery image" /></a></li>';
											break; 
										}else{
											$output[$lr] .= '<li><a href="'.get_permalink().'"><img src="'.$img.'" alt="gallery image" /></a></li>';
										}
										
										$gctr++;
									}
									$output[$lr] .= '</ul>';
								}
								
							}else{
								if(has_post_thumbnail()){
									$output[$lr] .= '<a href="'.get_permalink().'">'.get_the_post_thumbnail( $post->ID, 'masonry-thumb').'</a>';																		
								}
							}
						
					$output[$lr] .= '</div>';
				
				
				$wctr++;
			}
			
			
			print '
			<div id="masonry-holder-left">
			'.$output['left'].'			
			</div>
			
			<div id="masonry-holder-right">
			'.$output['right'].'
			</div>';
			
			
			
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
						
					}
				}			
			
			wp_reset_query();	
			wp_reset_postdata();
			
			
	
?>	