<?php

$tp_ajax_load = get_option('tp_ajax_load');

//AJAX IS ON
	if(empty($tp_ajax_load)){
		//REDIRECT IF HEADER IS NOT LOADED, E.G. CALLING POST DIRECTLY	
			if(empty($tp_header) && $_GET['ajaxload'] != '1'){
				//if calling a post directly
				
				$redirect = home_url().'/#'.$_SERVER['REQUEST_URI'];
				header('Location: '.$redirect);	
			}else{
				//load requested post

				get_template_part('content','single');
				
			}
	}elseif($tp_ajax_load == 'off'){
//AJAX IS OFF			
			
		get_header(); 
			
			get_template_part('content','single');
	
		get_footer(); 
	}
?>