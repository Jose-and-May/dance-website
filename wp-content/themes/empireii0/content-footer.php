<?php			
	//FOOTER WIDGET AREAS
		
		
	//current page/post setting
	if(!is_404() && !is_search()){
		$current_widget_area_f1 = get_post_meta(get_the_ID(),'ub_widget_area_f1',true);		
		$current_widget_area_f2 = get_post_meta(get_the_ID(),'ub_widget_area_f2',true);
		$current_widget_area_f3 = get_post_meta(get_the_ID(),'ub_widget_area_f3',true);
	}
	
	
	//global setting
		if(is_page()){
			$tp_default_f1_widget_area = get_option('tp_pages_default_f1_widget_area');
			$tp_default_f2_widget_area = get_option('tp_pages_default_f2_widget_area');
			$tp_default_f3_widget_area = get_option('tp_pages_default_f3_widget_area');
		}elseif(is_single()){		
			$tp_default_f1_widget_area = get_option('tp_posts_default_f1_widget_area');
			$tp_default_f2_widget_area = get_option('tp_posts_default_f2_widget_area');
			$tp_default_f3_widget_area = get_option('tp_posts_default_f3_widget_area');
		}
		
		if(!empty($current_widget_area_f1) && $current_widget_area_f1 != 'no-widget-area'){
			$ub_widget_area_f1 = $current_widget_area_f1;
		}else{			
			if(!empty($tp_default_f1_widget_area) && $tp_default_f1_widget_area != 'no-widget-area' && $current_widget_area_f1 != 'no-widget-area'){
				$ub_widget_area_f1 = $tp_default_f1_widget_area;
			}
		}
		
		if(!empty($current_widget_area_f2) && $current_widget_area_f2 != 'no-widget-area'){
			$ub_widget_area_f2 = $current_widget_area_f2;
		}else{
			if(!empty($tp_default_f2_widget_area) && $tp_default_f2_widget_area != 'no-widget-area' && $current_widget_area_f2 != 'no-widget-area'){
				$ub_widget_area_f2 = $tp_default_f2_widget_area;
			}
		}
		
		if(!empty($current_widget_area_f3) && $current_widget_area_f3 != 'no-widget-area'){
			$ub_widget_area_f3 = $current_widget_area_f3;
		}else{			
			if(!empty($tp_default_f3_widget_area) && $tp_default_f3_widget_area != 'no-widget-area' && $current_widget_area_f3 != 'no-widget-area'){
				$ub_widget_area_f3 = $tp_default_f3_widget_area;
			}
		}
	
		
		
		
		//1 active widget area
			if(!empty($ub_widget_area_f1) && is_active_sidebar( $ub_widget_area_f1 ) && !is_active_sidebar( $ub_widget_area_f2 ) && !is_active_sidebar( $ub_widget_area_f3 )){
				print '
				<!-- footer -->
				<footer>';
			
				if ( is_active_sidebar( $ub_widget_area_f1 ) ) {
			
					print '					
						<div class="column">';
							dynamic_sidebar( $ub_widget_area_f1 );
						print 
						'</div>
					';
				}
				
				print '
				</footer>';
			}
		
		
		//2 active widget areas
			if(!empty($ub_widget_area_f1) && is_active_sidebar( $ub_widget_area_f1 ) && is_active_sidebar( $ub_widget_area_f2 ) && !is_active_sidebar( $ub_widget_area_f3 )){
				print '
				<!-- footer -->
				<footer>';
			
				if ( is_active_sidebar( $ub_widget_area_f1 ) ) {
					print '
					<div class="one_half">';
						dynamic_sidebar( $ub_widget_area_f1 );
					print 
					'</div>
					';
				}
				if ( is_active_sidebar( $ub_widget_area_f2 ) ) {
					print '
					<div class="one_half last">';
						dynamic_sidebar( $ub_widget_area_f2 );
					print 
					'</div>
					';
				}
				
				print '
				</footer>';
			}
		
		
		//3 active widget areas
			if(!empty($ub_widget_area_f1) && is_active_sidebar( $ub_widget_area_f1 ) && is_active_sidebar( $ub_widget_area_f2 ) && is_active_sidebar( $ub_widget_area_f3 )){
				print '
				<!-- footer -->
				<footer>';
				
				if ( is_active_sidebar( $ub_widget_area_f1 ) ) {
					print '
					<div class="one_third">';
						dynamic_sidebar( $ub_widget_area_f1 );
					print 
					'</div>
					';
				}
				if ( is_active_sidebar( $ub_widget_area_f2 ) ) {
					print '
					<div class="one_third">';
						dynamic_sidebar( $ub_widget_area_f2 );
					print 
					'</div>
					';
				}
				if ( is_active_sidebar( $ub_widget_area_f3 ) ) {
					print '
					<div class="one_third last">';
						dynamic_sidebar( $ub_widget_area_f3 );
					print 
					'</div>
					';
				}
				
				print '
				</footer>';
			}
		
?>