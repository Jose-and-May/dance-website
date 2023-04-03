<?php

$tp_ajax_load = get_option('tp_ajax_load');

//AJAX IS ON
	if(empty($tp_ajax_load)){
		//REDIRECT IF HEADER IS NOT LOADED, E.G. CALLING PAGE DIRECTLY
			$frontpage = get_option('page_on_front');
			if(empty($_GET['ajaxload'])){
				//front page calling				
				
				get_header(); 

				get_footer(); 
				
							
			}else{
				//load requested page		
	
				print '<div class="hidden" id="page-title" data-id="">'.__('Search results','empire').'</div>
				<div class="hidden" id="page-bgslider-images">';
				
					$slides = $wpdb->get_row("SELECT * FROM tp_bgslider WHERE appears_pages LIKE '%all%' LIMIT 1", ARRAY_A);
					
					
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
				
								
				print '	
				<section id="content" class="search-results">
				';
				
					//title	
					print '<h1 class="tp-title">'.__('SEARCH RESULTS','empire').'</h1>				
					<div class="vspace2"></div>';
					
				
					//show search results
					$posts = query_posts($query_string . '&posts_per_page=-1');
					if(have_posts()){
						while(have_posts()){ 
							the_post();					
							
							//list posts
							get_template_part('content-results');		
						}
					}
					
					get_search_form();
					
					print '<hr class="hr" />';
					
					if(!empty($GLOBALS['results_posts'])){
						$res_count = count($GLOBALS['results_posts']);
					}else{
						$res_count = '0';
					}
					
					print '<h5>'.__('Search Results in Posts','empire').'</h5>
						<p class="results-info">'.sprintf(__('%s results for <i>%s</i>','empire'),$res_count,get_search_query()).'</p>';
					if(!empty($GLOBALS['results_posts'])){						
						foreach($GLOBALS['results_posts'] as $rp){
							print $rp;
						}
					}else{
						_e('Sorry, but nothing matched your search criteria in posts.','empire');
					}
					
					
					
					print '<hr class="hr" />';
					
					if(!empty($GLOBALS['results_pages'])){
						$res_count = count($GLOBALS['results_pages']);
					}else{
						$res_count = '0';
					}
					
					print '<h5>'.__('Search Results in Pages','empire').'</h5>
						<p class="results-info">'.sprintf(__('%s results for <i>%s</i>','empire'),$res_count,get_search_query()).'</p>';
					if(!empty($GLOBALS['results_pages'])){						
						foreach($GLOBALS['results_pages'] as $rp){
							print $rp;
						}
					}else{
						_e('Sorry, but nothing matched your search criteria in pages.','empire');
					}
					
				print '
				</section>
				';
				
				
			}
	}elseif($tp_ajax_load == 'off'){
//AJAX IS OFF
	
		get_header(); 
		
	
				print '	
				<section id="content" class="search-results">
				';
				
				
					//title	
					print '<h1 class="tp-title">'.__('SEARCH RESULTS','empire').'</h1>				
					<div class="vspace2"></div>';
				
					//show search results
					$posts = query_posts($query_string . '&posts_per_page=-1');
					if(have_posts()){
						while(have_posts()){ 
							the_post();					
							
							//list posts
							get_template_part('content-results');		
						}
					}
					
					get_search_form();
					
					print '<hr class="hr" />';
					
					if(!empty($GLOBALS['results_posts'])){
						$res_count = count($GLOBALS['results_posts']);
					}else{
						$res_count = '0';
					}
					
					print '<h5>'.__('Search Results in Posts','empire').'</h5>
						<p class="results-info">'.sprintf(__('%s results for <i>%s</i>','empire'),$res_count,get_search_query()).'</p>';
					if(!empty($GLOBALS['results_posts'])){						
						foreach($GLOBALS['results_posts'] as $rp){
							print $rp;
						}
					}else{
						_e('Sorry, but nothing matched your search criteria in posts.','empire');
					}
					
					
					
					print '<hr class="hr" />';
					
					if(!empty($GLOBALS['results_pages'])){
						$res_count = count($GLOBALS['results_pages']);
					}else{
						$res_count = '0';
					}
					
					print '<h5>'.__('Search Results in Pages','empire').'</h5>
						<p class="results-info">'.sprintf(__('%s results for <i>%s</i>','empire'),$res_count,get_search_query()).'</p>';
					if(!empty($GLOBALS['results_pages'])){						
						foreach($GLOBALS['results_pages'] as $rp){
							print $rp;
						}
					}else{
						_e('Sorry, but nothing matched your search criteria in pages.','empire');
					}
					
				print '
				</section>
				';
		
		
		get_footer(); 
	}

?>