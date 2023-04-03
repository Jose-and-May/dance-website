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
				
							
			}else{
				//load requested page		
	
				print '<div class="hidden" id="page-title" data-id="'.get_the_ID().'">';
					if ( is_day() ){
						print __('Archives from','empire').' '.get_the_date();
						$tit = __('Archives from','empire').' '.get_the_date();
					}elseif ( is_month() ){
						print __('Archives from','empire').' '.get_the_date( _x( 'F Y', 'monthly archives date format', 'empire' ));
						$tit = __('Archives from','empire').' '.get_the_date( _x( 'F Y', 'monthly archives date format', 'empire' ));
					}elseif ( is_year() ){
						print __('Archives from','empire').' '.get_the_date( _x( 'Y', 'yearly archives date format', 'empire' ) );
						$tit = __('Archives from','empire').' '.get_the_date( _x( 'Y', 'yearly archives date format', 'empire' ) );
					}else{
						print __('Archives','empire');
						$tit = __('Archives','empire');
					}
				print '</div>
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
				
				
				if($_SESSION['blogtype'] == 'masonry'){
					$resultsclass = 'masonry';
				}else{
					$resultsclass = 'classic';
				}
				
				print '	
				<section id="content" class="blog-'.$resultsclass.'">';
				
					//title	
					print '<h1 class="tp-title">'.$tit.'</h1>				
					<div class="vspace2"></div>';
				
					//show page content
					if($_SESSION['blogtype'] == 'masonry'){
						get_template_part('content-masonry');		
					}else{
						if(have_posts()){
							while(have_posts()){ 
								the_post();		
								
								get_template_part('content-results');
								
							}
						}
					}
					
						
				print '	
				</section>
				';
				
				
				//FOOTER WIDGET AREAS
					get_template_part('content','footer');
				
				
			}
	}elseif($tp_ajax_load == 'off'){
//AJAX IS OFF
	
		get_header(); 
				
				
				if($_SESSION['blogtype'] == 'masonry'){
					$resultsclass = 'masonry';
				}else{
					$resultsclass = 'classic';
				}
		
				print '	
				<section id="content" class="blog-'.$resultsclass.'">
				';
				
					//title
					print '<h1 class="tp-title">';
					
						if ( is_day() ){
							print __('Archives from','empire').' '.get_the_date();						
						}elseif ( is_month() ){
							print __('Archives from','empire').' '.get_the_date( _x( 'F Y', 'monthly archives date format', 'empire' ));						
						}elseif ( is_year() ){
							print __('Archives from','empire').' '.get_the_date( _x( 'Y', 'yearly archives date format', 'empire' ) );						
						}else{
							print __('Archives','empire');						
						}
					
					print '</h1>				
					<div class="vspace2"></div>';
				
					//show page content
					if($_SESSION['blogtype'] == 'masonry'){
						get_template_part('content-masonry');		
					}else{
						if(have_posts()){
							while(have_posts()){ 
								the_post();		
								
								get_template_part('content-results');
								
							}
						}
					}
					
					
				print '
				</section>
				';
		
		
				//FOOTER WIDGET AREAS
					get_template_part('content','footer');
		
		
		get_footer(); 
	}

?>