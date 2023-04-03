<?php

// widget area selector/creator
	$new_meta_boxes_w_area  = array(
		"sc_gen" => array(
		"name" => "ub_widget_area",
		"std" => "",
		"title" => __("Widget Area Settings","empire")
		)
	);

	function new_meta_boxes_w_area() {
		global $post, $new_meta_boxes_w_area;
		 
		foreach($new_meta_boxes_w_area as $meta_box) {			
			$meta_box_value2 = get_post_meta($post->ID, 'ub_widget_area_f1', true);
			$meta_box_value3 = get_post_meta($post->ID, 'ub_widget_area_f2', true);
			$meta_box_value4 = get_post_meta($post->ID, 'ub_widget_area_f3', true);			
			
			$custom_was = maybe_unserialize(get_option('ub_custom_widget_areas'));
			
			echo'
			<div class="ub_input_field"><b>'.__('First Footer Widget Area','empire').'</b></div>		
			<div class="ub_input_field"><label>'.__('Select a widget area to display:','empire').'</label>
			<select id="" name="ub_widget_area_f1" id="ub_widget_area_f1" style="width: 200px; float: left;">
			<option value="">'.__('Default Widget Area','empire').'</option>
			<option value="no-widget-area"'; if($meta_box_value2 == 'no-widget-area'){print ' selected="selected"';} print '>'.__('No Widget Area','empire').'</option>			
			<option value="first-footer-widget-area"'; if($meta_box_value2 == 'first-footer-widget-area'){print ' selected="selected"';} print '>'.__('First Footer Widget Area','empire').'</option>
			<option value="second-footer-widget-area"'; if($meta_box_value2 == 'second-footer-widget-area'){print ' selected="selected"';} print '>'.__('Second Footer Widget Area','empire').'</option>
			<option value="third-footer-widget-area"'; if($meta_box_value2 == 'third-footer-widget-area'){print ' selected="selected"';} print '>'.__('Third Footer Widget Area','empire').'</option>							
			';
			//get the rest if exist
			if($custom_was != ''){
				foreach($custom_was as $custom_wa){
					print '<option value="'.$custom_wa['id'].'"'; if($meta_box_value2 == $custom_wa['id']){print ' selected="selected"';} print '>'.$custom_wa['title'].'</option>';
				}
			}		
			print '
			</select></div>
			
			<div class="ub_input_field"><label>'.__('or create a new area:','empire').'</label>
			<input type="text" name="ub_new_widget_area_f1" /><span style="color: #aaa;"> ('.__('enter a title for it','empire').')</span>
			</div>
			
			
			
			<div class="ub_input_field"><hr /></div>					
			<div class="ub_input_field"><b>'.__('Second Footer Widget Area','empire').'</b></div>		
			<div class="ub_input_field"><label>'.__('Select a widget area to display:','empire').'</label>
			<select id="" name="ub_widget_area_f2" id="ub_widget_area_f2" style="width: 200px; float: left;">
			<option value="">'.__('Default Widget Area','empire').'</option>
			<option value="no-widget-area"'; if($meta_box_value3 == 'no-widget-area'){print ' selected="selected"';} print '>'.__('No Widget Area','empire').'</option>			
			<option value="first-footer-widget-area"'; if($meta_box_value3 == 'first-footer-widget-area'){print ' selected="selected"';} print '>'.__('First Footer Widget Area','empire').'</option>
			<option value="second-footer-widget-area"'; if($meta_box_value3 == 'second-footer-widget-area'){print ' selected="selected"';} print '>'.__('Second Footer Widget Area','empire').'</option>
			<option value="third-footer-widget-area"'; if($meta_box_value3 == 'third-footer-widget-area'){print ' selected="selected"';} print '>'.__('Third Footer Widget Area','empire').'</option>							
			';
			//get the rest if exist
			if($custom_was != ''){
				foreach($custom_was as $custom_wa){
					print '<option value="'.$custom_wa['id'].'"'; if($meta_box_value3 == $custom_wa['id']){print ' selected="selected"';} print '>'.$custom_wa['title'].'</option>';
				}
			}		
			print '
			</select></div>
			
			<div class="ub_input_field"><label>'.__('or create a new area:','empire').'</label>
			<input type="text" name="ub_new_widget_area_f2" /><span style="color: #aaa;"> ('.__('enter a title for it','empire').')</span>
			</div>		
			
			
			<div class="ub_input_field"><hr /></div>					
			<div class="ub_input_field"><b>'.__('Third Footer Widget Area','empire').'</b></div>		
			<div class="ub_input_field"><label>'.__('Select a widget area to display:','empire').'</label>
			<select id="" name="ub_widget_area_f3" id="ub_widget_area_f3" style="width: 200px; float: left;">
			<option value="">'.__('Default Widget Area','empire').'</option>
			<option value="no-widget-area"'; if($meta_box_value4 == 'no-widget-area'){print ' selected="selected"';} print '>'.__('No Widget Area','empire').'</option>			
			<option value="first-footer-widget-area"'; if($meta_box_value4 == 'first-footer-widget-area'){print ' selected="selected"';} print '>'.__('First Footer Widget Area','empire').'</option>
			<option value="second-footer-widget-area"'; if($meta_box_value4 == 'second-footer-widget-area'){print ' selected="selected"';} print '>'.__('Second Footer Widget Area','empire').'</option>
			<option value="third-footer-widget-area"'; if($meta_box_value4 == 'third-footer-widget-area'){print ' selected="selected"';} print '>'.__('Third Footer Widget Area','empire').'</option>							
			';
			//get the rest if exist
			if($custom_was != ''){
				foreach($custom_was as $custom_wa){
					print '<option value="'.$custom_wa['id'].'"'; if($meta_box_value4 == $custom_wa['id']){print ' selected="selected"';} print '>'.$custom_wa['title'].'</option>';
				}
			}		
			print '
			</select></div>
			
			<div class="ub_input_field"><label>'.__('or create a new area:','empire').'</label>
			<input type="text" name="ub_new_widget_area_f3" /><span style="color: #aaa;"> ('.__('enter a title for it','empire').')</span>
			</div>			
			';			
			
		}
	}

	function create_meta_w_area() {
		global $theme_name;
		if ( function_exists('add_meta_box') ) {
			add_meta_box( 'new-meta-boxes_w_area', 'Widget Area Settings', 'new_meta_boxes_w_area', 'post', 'normal', 'high' );
			add_meta_box( 'new-meta-boxes_w_area', 'Widget Area Settings', 'new_meta_boxes_w_area', 'page', 'normal', 'high' );			
		}
	}

	function save_postdata_w_area( $post_id ) {
		global $post, $new_meta_boxes_w_area;
		 
		if ( defined('DOING_AUTOSAVE') && DOING_AUTOSAVE ) {
			return $post_id;
		}else{	
						
			//footer w area 1
			if(!empty($_POST['ub_new_widget_area_f1'])){			
				//add new widget area		
				$ub_c_was = maybe_unserialize(get_option('ub_custom_widget_areas'));
				
				
				//check dupes
				if(!empty($ub_c_was) && is_array($ub_c_was)){
				foreach($ub_c_was as $ub_c_wa){
					if($ub_c_wa['id'] == ('ub_wa_f1'.time())){
						$found_ub_c_wa = '1';
					}
				}
				}
				
				if($found_ub_c_wa != '1'){
					$nuarr['title'] = $_POST['ub_new_widget_area_f1'];
					$nuarr['id'] = 'ub_wa_f1'.time();
					$ub_c_was[] = $nuarr;
					
					update_option('ub_custom_widget_areas',$ub_c_was);
					
					
					
					
					//and save it as selected
					update_post_meta($post_id,'ub_widget_area_f1',$nuarr['id']);	

					$tp_wa_f1_id = $nuarr['id'];
				}
			}else{
				//save selected
				if(!empty($_POST['ub_widget_area_f1'])){
					update_post_meta($post_id,'ub_widget_area_f1',$_POST['ub_widget_area_f1']);
					$tp_wa_f1_id = $_POST['ub_widget_area_f1'];
				}else{
					delete_post_meta($post_id,'ub_widget_area_f1');
				}
			}
			
			
			
			
			if(!empty($_POST['ub_new_widget_area_f2'])){			
				//add new widget area		
				$ub_c_was = maybe_unserialize(get_option('ub_custom_widget_areas'));
				
				//check dupes
				if(!empty($ub_c_was) && is_array($ub_c_was)){
				foreach($ub_c_was as $ub_c_wa){
					if($ub_c_wa['id'] == ('ub_wa_f2'.time())){
						$found_ub_c_wa = '1';
					}
				}
				}
				
				if($found_ub_c_wa != '1'){
					$nuarr['title'] = $_POST['ub_new_widget_area_f2'];
					$nuarr['id'] = 'ub_wa_f2'.time();
					$ub_c_was[] = $nuarr;
					
					update_option('ub_custom_widget_areas',$ub_c_was);
					
					
					
					
					//and save it as selected
					update_post_meta($post_id,'ub_widget_area_f2',$nuarr['id']);		
				}
			}else{
				//save selected
				if(!empty($_POST['ub_widget_area_f2'])){
					update_post_meta($post_id,'ub_widget_area_f2',$_POST['ub_widget_area_f2']);
				}else{
					delete_post_meta($post_id,'ub_widget_area_f2');
				}
			}
			
			
			
			
			if(!empty($_POST['ub_new_widget_area_f3'])){			
				//add new widget area		
				$ub_c_was = maybe_unserialize(get_option('ub_custom_widget_areas'));
				
				//check dupes
				if(!empty($ub_c_was) && is_array($ub_c_was)){
				foreach($ub_c_was as $ub_c_wa){
					if($ub_c_wa['id'] == ('ub_wa_f3'.time())){
						$found_ub_c_wa = '1';
					}
				}
				}
				
				if(empty($found_ub_c_wa) && is_array($ub_c_was)){
					$nuarr['title'] = $_POST['ub_new_widget_area_f3'];
					$nuarr['id'] = 'ub_wa_f3'.time();
					$ub_c_was[] = $nuarr;
					
					update_option('ub_custom_widget_areas',$ub_c_was);
					
					
					
					
					//and save it as selected
					update_post_meta($post_id,'ub_widget_area_f3',$nuarr['id']);		
				}
			}else{
				//save selected
				if(!empty($_POST['ub_widget_area_f3'])){
					update_post_meta($post_id,'ub_widget_area_f3',$_POST['ub_widget_area_f3']);
				}else{
					delete_post_meta($post_id,'ub_widget_area_f3');
				}
			}
			
			
		}
	}
	add_action('admin_menu', 'create_meta_w_area');
	add_action('save_post', 'save_postdata_w_area');
	
?>