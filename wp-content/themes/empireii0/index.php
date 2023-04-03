<?php
/*
	This page displays blog posts
*/

$tp_ajax_load = get_option('tp_ajax_load');

//AJAX IS ON
	if(empty($tp_ajax_load)){
		
		if(empty($_GET['ajaxload'])){
			get_header();
		}
		
		//SHOW BLOG POSTS
		
			$cssc = '';
			
			//if(get_option('show_on_front') == 'posts' || get_option('page_for_posts') == get_the_ID()){
			//if(get_option('show_on_front') == 'posts'){
			 $cssc = ' class="blog-classic"';
			//}
		
			print '	
				<section id="content"'.$cssc.'>						
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
							
						print '
						</div>
						<div class="hidden" id="page-bgslider-datas" data-pause="'.$slides['pause'].'" data-fade="'.$slides['fade'].'"></div>
				';
				
				get_template_part('content-classic');	
					
				print '	
				</section>	
		';
	
		if(empty($_GET['ajaxload'])){
			get_footer(); 
		}
	
	}elseif($tp_ajax_load == 'off'){
//AJAX IS OFF
		
		//SHOW BLOG POSTS
		get_header(); 
	
				print '	
				<section id="content" class="blog-classic">
				';
				
					//list posts
						get_template_part('content-classic');				
				
				print '
				</section>
				';
		
		get_footer(); 
		

	}

?>