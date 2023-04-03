<?php
/*
Template Name: Portfolio
*/



$tp_ajax_load = get_option('tp_ajax_load');

//AJAX IS ON
	if(empty($tp_ajax_load)){
		//REDIRECT IF HEADER IS NOT LOADED, E.G. CALLING PAGE DIRECTLY
			$frontpage = get_option('page_on_front');
			if($frontpage == get_the_ID() && empty($_GET['ajaxload'])){
				//front page calling				
				
				get_header(); 

				get_footer(); 
				
							
			}else{
				//load requested page		

				//content background
					$tp_bgimg_src = get_post_meta(get_the_ID(), 'tp_bgimg_src', true);		
					$tp_bgimg_top = get_post_meta(get_the_ID(), 'tp_bgimg_top', true);		
					$tp_bgimg_left = get_post_meta(get_the_ID(), 'tp_bgimg_left', true);		
				
					$cntstyle = '';
					if(!empty($tp_bgimg_src)){
						$cntstyle = ' style="background-image:url('.$tp_bgimg_src.');';
						if(!empty($tp_bgimg_left)){ $bgp_l = $tp_bgimg_left.'px'; }else{ $bgp_l = '0px'; }
						if(!empty($tp_bgimg_top)){ $bgp_t = $tp_bgimg_top.'px'; }else{ $bgp_t = '0px'; }
						$cntstyle .= ' background-position: '.$bgp_l.' '.$bgp_t.'"';
					}
		
				print '	
				<section id="content"'.$cntstyle.'>
					<article id="post-'.get_the_ID().'">';
							
					if (have_posts()) :
						while ( have_posts() ) : the_post();
							print '<div class="hidden" id="page-title" data-id="'.get_the_ID().'">'.get_the_title().'</div>
							<div class="hidden" id="page-bgslider-images">';
							
								$slides = $wpdb->get_row("SELECT * FROM tp_bgslider WHERE appears_pages LIKE '%;".$post->ID."%' OR appears_pages LIKE '%".$post->ID.";%' OR appears_pages='".$post->ID."' LIMIT 1", ARRAY_A);
								if($slides == null){
									$slides = $wpdb->get_row("SELECT * FROM tp_bgslider WHERE appears_pages LIKE '%all%' LIMIT 1", ARRAY_A);
								}
								
								if($slides != null){
									$slides_arr = explode(';',$slides['images']);
									if(!empty($slides_arr)){
										foreach($slides_arr as $slide){
											$sext = end(explode('.', $slide));			
											if($sext == 'mp4'){
												print '<video class="video_bg" preload="auto" autoplay="false" loop="loop" muted="muted" volume="0"><source src="'.$slide.'" type="video/mp4"></video>';
											}elseif($sext == 'jpg' || $sext == 'jpeg' || $sext == 'png'){
												print '<img src="'.$slide.'" alt="slider image" />';								
											}

										}
									}
								}
							
							print '</div>
							<div class="hidden" id="page-bgslider-datas" data-pause="'.$slides['pause'].'" data-fade="'.$slides['fade'].'"></div>';
							
							the_content();									
								
							wp_link_pages( array( 'before' => '<div class="page-links">' . __( '<strong>Pages:</strong>', 'empire' ), 'after' => '</div>' ) ); 
						endwhile;
					endif;
					
					

							
							// PORTFOLIO POSTS
								
								$tp_pf_settings_align = get_post_meta($post->ID, 'tp_pf_settings_align', true);
								
								
								//categories to show
									$bc = get_post_meta(get_the_ID(), 'tp_blog_cats', true);
									if(is_array($bc)){
										$categories_to_display = implode(',',$bc);
									}
									
								//category selector
								$tp_pf_settings_categories = get_post_meta(get_the_ID(), 'tp_pf_settings_categories', true);
								if($tp_pf_settings_categories == '1'){
									print '
									<div id="pf-category-selector" class="'.$tp_pf_settings_align.'">
										';
										
										$currpurl = get_permalink();		
										$cats[] = '<a href="'.$currpurl.'">'.__('SHOW ALL','empire').'</a>';
																				
										
										//show all child cats of current parent cat			

										//foreach array
										if(is_array($bc)){
											foreach($bc as $pfcat){
												$allcats = get_categories(array(
													'type' => 'post',
													'child_of' => get_cat_id($pfcat)
												));
												
												if(!empty($allcats)){
													foreach($allcats as $ccats){
														//create category url
														if(strstr($currpurl,'?')){ 
															$caturl = $currpurl.'&amp;cat='.$ccats->slug;
														}else{
															$caturl = $currpurl.'?cat='.$ccats->slug;
														}
														
														$cats[] = '<a href="'.$caturl.'">'.$ccats->name.'</a>';
													}
												}												
											}
										}
										
										
										if(!empty($cats)){
											$cats = array_unique($cats);
											print implode('&nbsp;&nbsp;&nbsp;&#8226;&nbsp;&nbsp;&nbsp;',$cats);
										}
										
									print '		
										
									</div>';
								}
								
								
								//posts
									print '<div class="tp-portfolio">';
									
									$tp_pf_settings_title = get_post_meta(get_the_ID(), 'tp_pf_settings_title', true);
									$tp_pf_settings_excerpt = get_post_meta(get_the_ID(), 'tp_pf_settings_excerpt', true);											
									$tp_pf_settings_cols = get_post_meta($post->ID, 'tp_pf_settings_cols', true);		
									
									if(empty($tp_pf_settings_cols)){
										$colcss = 'one_third';
										$tp_pf_settings_cols = '3';
									}elseif($tp_pf_settings_cols == '4'){
										$colcss = 'one_fourth';
									}elseif($tp_pf_settings_cols == '2'){
										$colcss = 'one_half';
									}elseif($tp_pf_settings_cols == '1'){
										$colcss = '';
									}
									
									
									if(!empty($_GET['cat'])){
										$categories_to_display = sanitize_key($_GET['cat']);
									}
									
									
									if(!empty($categories_to_display)){
										$the_query = new WP_Query( array(				
											'post_type' => 'post',
											'category_name' => $categories_to_display,
											'posts_per_page' => '-1'										
										) );
									
										$wctr = 0;
										while($the_query->have_posts()){
											$the_query->the_post();
											
											$wctr++;
											if($wctr == $tp_pf_settings_cols){
												$wctr = 0;
												$last = ' last';
											}elseif($wctr == '1'){
												$last = 'clear';
											}else{
												$last = '';
											}
										
											print '<div class="col '.$colcss.' '.$last.' '.$tp_pf_settings_align.'">';
										
											//thumb
												if(has_post_thumbnail()){				
													if(get_post_format() == 'video' || get_post_format() == 'audio'){
														$icon = '<div class="tpicon-play"></div>';
													}else{
														$icon = '<div class="tpicon-visit"></div>';
													}
												
													if($tp_pf_settings_cols == '2' || $tp_pf_settings_cols == '1'){
														print '<a href="'.get_permalink().'" class="thumb">'.get_the_post_thumbnail( get_the_ID(), 'portfolio-thumb').'<div class="hover">'.$icon.'</div></a>';
													}else{
														print '<a href="'.get_permalink().'" class="thumb">'.get_the_post_thumbnail( get_the_ID(), 'post-thumbnail').'<div class="hover">'.$icon.'</div></a>';
													}
												}
											
											
											//title												
												if($tp_pf_settings_title == '1'){
													print '<p class="title"><a href="'.get_permalink().'">'.get_the_title().'</a></p>';
												}
												
											//intro												
												if($tp_pf_settings_excerpt == '1'){
													print '<p class="excerpt">'.get_the_excerpt().'</p>';
												}
										
										
											print '</div>';
										
										}
										wp_reset_query();
									}
									
									print '</div>';					
					
					
					
				print '
					</article>
				</section>
				';
				
				
				//FOOTER WIDGET AREAS
					get_template_part('content','footer');
				
				
			}
	}elseif($tp_ajax_load == 'off'){
//AJAX IS OFF
	
		get_header(); 
	
				//content background
					$tp_bgimg_src = get_post_meta(get_the_ID(), 'tp_bgimg_src', true);		
					$tp_bgimg_top = get_post_meta(get_the_ID(), 'tp_bgimg_top', true);		
					$tp_bgimg_left = get_post_meta(get_the_ID(), 'tp_bgimg_left', true);		
				
					$cntstyle = '';
					if(!empty($tp_bgimg_src)){
						$cntstyle = ' style="background-image:url('.$tp_bgimg_src.');';
						if(!empty($tp_bgimg_left)){ $bgp_l = $tp_bgimg_left.'px'; }else{ $bgp_l = '0px'; }
						if(!empty($tp_bgimg_top)){ $bgp_t = $tp_bgimg_top.'px'; }else{ $bgp_t = '0px'; }
						$cntstyle .= ' background-position: '.$bgp_l.' '.$bgp_t.'"';
					}
	
				print '	
				<section id="content"'.$cntstyle.'>
					<article id="post-'.get_the_ID().'">';
							
					if (have_posts()) :
						while ( have_posts() ) : the_post();							
							
							
							the_content();
														
							wp_link_pages( array( 'before' => '<div class="page-links">' . __( '<strong>Pages:</strong>', 'empire' ), 'after' => '</div>' ) ); 
						endwhile;
					endif;
					

							
							// PORTFOLIO POSTS
							
								//categories to show
									$bc = get_post_meta(get_the_ID(), 'tp_blog_cats', true);
									if(is_array($bc)){
										$categories_to_display = implode(',',$bc);
									}
									
								//category selector
								$tp_pf_settings_categories = get_post_meta(get_the_ID(), 'tp_pf_settings_categories', true);
								if($tp_pf_settings_categories == '1'){
									print '
									<div id="pf-category-selector">
										';
										
										$currpurl = get_permalink();		
										$cats[] = '<a href="'.$currpurl.'">'.__('SHOW ALL','empire').'</a>';
																				
										
										//show all child cats of current parent cat			

										//foreach array
										if(is_array($bc)){
											foreach($bc as $pfcat){
												$allcats = get_categories(array(
													'type' => 'post',
													'child_of' => get_cat_id($pfcat)
												));
												
												if(!empty($allcats)){
													foreach($allcats as $ccats){
														//create category url
														if(strstr($currpurl,'?')){ 
															$caturl = $currpurl.'&amp;cat='.$ccats->slug;
														}else{
															$caturl = $currpurl.'?cat='.$ccats->slug;
														}
														
														$cats[] = '<a href="'.$caturl.'">'.$ccats->name.'</a>';
													}
												}												
											}
										}
										
										
										if(!empty($cats)){
											$cats = array_unique($cats);
											print implode('&nbsp;&nbsp;&nbsp;&#8226;&nbsp;&nbsp;&nbsp;',$cats);
										}
										
									print '		
										
									</div>';
								}
								
								
								//posts
									print '<div class="tp-portfolio">';
									
									$tp_pf_settings_title = get_post_meta(get_the_ID(), 'tp_pf_settings_title', true);
									$tp_pf_settings_excerpt = get_post_meta(get_the_ID(), 'tp_pf_settings_excerpt', true);
									$tp_pf_settings_align = get_post_meta($post->ID, 'tp_pf_settings_align', true);		
									$tp_pf_settings_cols = get_post_meta($post->ID, 'tp_pf_settings_cols', true);		
									
									if(empty($tp_pf_settings_cols)){
										$colcss = 'one_third';
										$tp_pf_settings_cols = '3';
									}elseif($tp_pf_settings_cols == '4'){
										$colcss = 'one_fourth';
									}elseif($tp_pf_settings_cols == '2'){
										$colcss = 'one_half';
									}elseif($tp_pf_settings_cols == '1'){
										$colcss = '';
									}
									
									
									if(!empty($_GET['cat'])){
										$categories_to_display = sanitize_key($_GET['cat']);
									}
									
									
									if(!empty($categories_to_display)){
										$the_query = new WP_Query( array(				
											'post_type' => 'post',
											'category_name' => $categories_to_display,
											'posts_per_page' => '-1'										
										) );
									
										$wctr = 0;
										while($the_query->have_posts()){
											$the_query->the_post();
											
											$wctr++;
											if($wctr == $tp_pf_settings_cols){
												$wctr = 0;
												$last = ' last';
											}elseif($wctr == '1'){
												$last = 'clear';
											}else{
												$last = '';
											}
										
											print '<div class="col '.$colcss.' '.$last.' '.$tp_pf_settings_align.'">';
										
											//thumb
												if(has_post_thumbnail()){				
													if(get_post_format() == 'video' || get_post_format() == 'audio'){
														$icon = '<div class="tpicon-play"></div>';
													}else{
														$icon = '<div class="tpicon-visit"></div>';
													}
												
													if($tp_pf_settings_cols == '2' || $tp_pf_settings_cols == '1'){
														print '<a href="'.get_permalink().'" class="thumb">'.get_the_post_thumbnail( get_the_ID(), 'portfolio-thumb').'<div class="hover">'.$icon.'</div></a>';
													}else{
														print '<a href="'.get_permalink().'" class="thumb">'.get_the_post_thumbnail( get_the_ID(), 'post-thumbnail').'<div class="hover">'.$icon.'</div></a>';
													}
												}
											
											
											//title												
												if($tp_pf_settings_title == '1'){
													print '<p class="title"><a href="'.get_permalink().'">'.get_the_title().'</a></p>';
												}
												
											//intro												
												if($tp_pf_settings_excerpt == '1'){
													print '<p class="excerpt">'.get_the_excerpt().'</p>';
												}
										
										
											print '</div>';
										
										}
										wp_reset_query();
									}
									
									print '</div>';				
					
					
				print '
					</article>
				</section>
				';
		
				//FOOTER WIDGET AREAS
					get_template_part('content','footer');
		
		
		get_footer(); 
	}

?>