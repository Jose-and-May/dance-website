<?php

$tp_ajax_load = get_option('tp_ajax_load');

//AJAX IS ON
	if(empty($tp_ajax_load)){
		//REDIRECT IF HEADER IS NOT LOADED, E.G. CALLING PAGE DIRECTLY
			$frontpage = get_option('page_on_front');
			if($frontpage == get_the_ID() && empty($_GET['ajaxload'])){
				//front page calling				
				
				get_header(); 

				get_footer(); 
				
			}elseif(empty($tp_header) && empty($_GET['ajaxload'])){
				//if calling a page directly
				
				$redirect = home_url().'/#'.$_SERVER['REQUEST_URI'];
				header('Location: '.$redirect);	
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
					
				print '
					</article>
				</section>
				';
		
			
			//FOOTER WIDGET AREAS
				get_template_part('content','footer');
		
		get_footer(); 
	}
?>