<?php

// THEME OPTIONS

// sidebar and footer settings
	
	
	//save settings
	if(!empty($_POST) && !empty($_GET['page']) && $_GET['page'] == 'tp_theme_sidebar_footer'){		
	
		//save
			
			
			//posts
				$ub_c_was = maybe_unserialize(get_option('ub_custom_widget_areas'));			
			
				
				if($_POST['form-tp_posts_new_widget_area_f1'] != ''){
					$nuarr['title'] = $_POST['form-tp_posts_new_widget_area_f1'];
					$nuarr['id'] = 'ub_wa_po_f1_'.time();
					$ub_c_was[] = $nuarr;
					update_option('ub_custom_widget_areas',maybe_serialize($ub_c_was));
					update_option('tp_posts_default_f1_widget_area',$nuarr['id']);
				}else{	update_option('tp_posts_default_f1_widget_area',$_POST['form-tp_posts_default_f1_widget_area']); }
				
				
				if($_POST['form-tp_posts_new_widget_area_f2'] != ''){
					$nuarr['title'] = $_POST['form-tp_posts_new_widget_area_f2'];
					$nuarr['id'] = 'ub_wa_po_f2_'.time();
					$ub_c_was[] = $nuarr;
					update_option('ub_custom_widget_areas',maybe_serialize($ub_c_was));
					update_option('tp_posts_default_f2_widget_area',$nuarr['id']);
				}else{	update_option('tp_posts_default_f2_widget_area',$_POST['form-tp_posts_default_f2_widget_area']); }

				
				if($_POST['form-tp_posts_new_widget_area_f3'] != ''){
					$nuarr['title'] = $_POST['form-tp_posts_new_widget_area_f3'];
					$nuarr['id'] = 'ub_wa_po_f3_'.time();
					$ub_c_was[] = $nuarr;
					update_option('ub_custom_widget_areas',maybe_serialize($ub_c_was));
					update_option('tp_posts_default_f3_widget_area',$nuarr['id']);
				}else{	update_option('tp_posts_default_f3_widget_area',$_POST['form-tp_posts_default_f3_widget_area']); }
				
				
			
			//pages
				
				if($_POST['form-tp_pages_new_widget_area_f1'] != ''){
					$nuarr['title'] = $_POST['form-tp_pages_new_widget_area_f1'];
					$nuarr['id'] = 'ub_wa_pa_f1_'.time();
					$ub_c_was[] = $nuarr;
					update_option('ub_custom_widget_areas',maybe_serialize($ub_c_was));
					update_option('tp_pages_default_f1_widget_area',$nuarr['id']);
				}else{	update_option('tp_pages_default_f1_widget_area',$_POST['form-tp_pages_default_f1_widget_area']); }
				
				
				if($_POST['form-tp_pages_new_widget_area_f2'] != ''){
					$nuarr['title'] = $_POST['form-tp_pages_new_widget_area_f2'];
					$nuarr['id'] = 'ub_wa_pa_f2_'.time();
					$ub_c_was[] = $nuarr;
					update_option('ub_custom_widget_areas',maybe_serialize($ub_c_was));
					update_option('tp_pages_default_f2_widget_area',$nuarr['id']);
				}else{	update_option('tp_pages_default_f2_widget_area',$_POST['form-tp_pages_default_f2_widget_area']); }

				
				if($_POST['form-tp_pages_new_widget_area_f3'] != ''){
					$nuarr['title'] = $_POST['form-tp_pages_new_widget_area_f3'];
					$nuarr['id'] = 'ub_wa_pa_f3_'.time();
					$ub_c_was[] = $nuarr;
					update_option('ub_custom_widget_areas',maybe_serialize($ub_c_was));
					update_option('tp_pages_default_f3_widget_area',$nuarr['id']);
				}else{	update_option('tp_pages_default_f3_widget_area',$_POST['form-tp_pages_default_f3_widget_area']); }
				
		
		header("Location: admin.php?page=tp_theme_sidebar_footer&success=1");						
	}
		
		
	//display option layout	
	function tp_theme_sidebar_footer(){
		global $framework_url;

		if(!empty($_GET['success']) && $_GET['success'] == '1'){
			print '<div id="message" class="updated"><p>'.__('Settings are successfully saved.','empire').'</p></div>';
		}
		
		
		//load default widget areas
		$custom_was = maybe_unserialize(get_option('ub_custom_widget_areas'));
		$tp_posts_default_f1_widget_area = get_option('tp_posts_default_f1_widget_area');
		$tp_posts_default_f2_widget_area = get_option('tp_posts_default_f2_widget_area');
		$tp_posts_default_f3_widget_area = get_option('tp_posts_default_f3_widget_area');
		
		
		$tp_pages_default_f1_widget_area = get_option('tp_pages_default_f1_widget_area');
		$tp_pages_default_f2_widget_area = get_option('tp_pages_default_f2_widget_area');
		$tp_pages_default_f3_widget_area = get_option('tp_pages_default_f3_widget_area');
		
		
		
		print '<div class="wrap">	
			<div class="icon32"><img src="'.$framework_url.'icon-big.png" class="h2_icon" /><br /></div><h2>'.__( 'Footer Widget Area Settings', 'empire' ).'</h2>	
		
			<form method="post" action="" enctype="multipart/form-data">		

			<table class="form-table">
							
			
				<tr>					
					<td colspan="2">
					<h3>'.__('Set Default Widget Areas for Posts','empire').'</h3>
					<p>'.__('Here you can set the default footer widget areas for posts. You can override these settings for each posts in their editor.','empire').'</p></td>
				</tr>
				
				
				
				
					<tr class="tp_pad">
						<th><h4>'.__('First Footer Widget Area','empire').'</h4></th>
						<td></td>
					</tr>
					<tr class="tp_pad">
						<th scope="row"><label>'.__('Select a widget area:','empire').'</label></th>
						<td><select name="form-tp_posts_default_f1_widget_area">
							<option value="">'.__('Default Widget Area','empire').'</option>
							<option value="no-widget-area">'.__('No Widget Area','empire').'</option>							
							<option value="first-footer-widget-area"'; if($tp_posts_default_f1_widget_area == 'first-footer-widget-area'){print ' selected="selected"';} print '>'.__('First Footer Widget Area','empire').'</option>
							<option value="second-footer-widget-area"'; if($tp_posts_default_f1_widget_area == 'second-footer-widget-area'){print ' selected="selected"';} print '>'.__('Second Footer Widget Area','empire').'</option>
							<option value="third-footer-widget-area"'; if($tp_posts_default_f1_widget_area == 'third-footer-widget-area'){print ' selected="selected"';} print '>'.__('Third Footer Widget Area','empire').'</option>											
							';
							//get the rest if exist							
							if($custom_was != ''){
								foreach($custom_was as $custom_wa){
									print '<option value="'.$custom_wa['id'].'"'; if($tp_posts_default_f1_widget_area == $custom_wa['id']){print ' selected="selected"';} print '>'.$custom_wa['title'].'</option>';
								}
							}		
														
							print '
							</select>
						</td>
					</tr>
					<tr class="tp_pad">
						<th scope="row"><label>'.__('or create a new area:','empire').'</label></th>
						<td><input type="text" name="form-tp_posts_new_widget_area_f1" /><span style="color: #aaa;"> ('.__('enter a title for it','empire').')</span></td>
					</tr>
					
					
					
					<tr class="tp_pad">
						<th><h4>'.__('Second Footer Widget Area','empire').'</h4></th>
						<td></td>
					</tr>
					<tr class="tp_pad">
						<th scope="row"><label>'.__('Select a widget area:','empire').'</label></th>
						<td><select name="form-tp_posts_default_f2_widget_area">
							<option value="">'.__('Default Widget Area','empire').'</option>
							<option value="no-widget-area">'.__('No Widget Area','empire').'</option>							
							<option value="first-footer-widget-area"'; if($tp_posts_default_f2_widget_area == 'first-footer-widget-area'){print ' selected="selected"';} print '>'.__('First Footer Widget Area','empire').'</option>
							<option value="second-footer-widget-area"'; if($tp_posts_default_f2_widget_area == 'second-footer-widget-area'){print ' selected="selected"';} print '>'.__('Second Footer Widget Area','empire').'</option>
							<option value="third-footer-widget-area"'; if($tp_posts_default_f2_widget_area == 'third-footer-widget-area'){print ' selected="selected"';} print '>'.__('Third Footer Widget Area','empire').'</option>				
							
							';
							//get the rest if exist							
							if($custom_was != ''){
								foreach($custom_was as $custom_wa){
									print '<option value="'.$custom_wa['id'].'"'; if($tp_posts_default_f2_widget_area == $custom_wa['id']){print ' selected="selected"';} print '>'.$custom_wa['title'].'</option>';
								}
							}		
														
							print '
							</select>
						</td>
					</tr>
					<tr class="tp_pad">
						<th scope="row"><label>'.__('or create a new area:','empire').'</label></th>
						<td><input type="text" name="form-tp_posts_new_widget_area_f2" /><span style="color: #aaa;"> ('.__('enter a title for it','empire').')</span></td>
					</tr>
					
					
					
					
					
					
					<tr class="tp_pad">
						<th><h4>'.__('Third Footer Widget Area','empire').'</h4></th>
						<td></td>
					</tr>
					<tr class="tp_pad">
						<th scope="row"><label>'.__('Select a widget area:','empire').'</label></th>
						<td><select name="form-tp_posts_default_f3_widget_area">
							<option value="">'.__('Default Widget Area','empire').'</option>
							<option value="no-widget-area">'.__('No Widget Area','empire').'</option>							
							<option value="first-footer-widget-area"'; if($tp_posts_default_f3_widget_area == 'first-footer-widget-area'){print ' selected="selected"';} print '>'.__('First Footer Widget Area','empire').'</option>
							<option value="second-footer-widget-area"'; if($tp_posts_default_f3_widget_area == 'second-footer-widget-area'){print ' selected="selected"';} print '>'.__('Second Footer Widget Area','empire').'</option>
							<option value="third-footer-widget-area"'; if($tp_posts_default_f3_widget_area == 'third-footer-widget-area'){print ' selected="selected"';} print '>'.__('Third Footer Widget Area','empire').'</option>				
							
							';
							//get the rest if exist							
							if($custom_was != ''){
								foreach($custom_was as $custom_wa){
									print '<option value="'.$custom_wa['id'].'"'; if($tp_posts_default_f3_widget_area == $custom_wa['id']){print ' selected="selected"';} print '>'.$custom_wa['title'].'</option>';
								}
							}		
														
							print '
							</select>
						</td>
					</tr>
					<tr class="tp_pad">
						<th scope="row"><label>'.__('or create a new area:','empire').'</label></th>
						<td><input type="text" name="form-tp_posts_new_widget_area_f3" /><span style="color: #aaa;"> ('.__('enter a title for it','empire').')</span></td>
					</tr>
					
					
					
					
					
				<tr>
					<td></td>
				</tr>	
				<tr>					
					<td colspan="2"><h3>'.__('Set Default Widget Areas for Pages','empire').'</h3>
					<p>'.__('Here you can set the default footer widget areas for pages. You can override these settings for each pages in their editor.','empire').'</p></td>
				</tr>
				
					
				
				
				
					<tr class="tp_pad">
						<th><h4>'.__('First Footer Widget Area','empire').'</h4></th>
						<td></td>
					</tr>
					<tr class="tp_pad">
						<th scope="row"><label>'.__('Select a widget area:','empire').'</label></th>
						<td><select name="form-tp_pages_default_f1_widget_area">
							<option value="">'.__('Default Widget Area','empire').'</option>
							<option value="no-widget-area">'.__('No Widget Area','empire').'</option>							
							<option value="first-footer-widget-area"'; if($tp_pages_default_f1_widget_area == 'first-footer-widget-area'){print ' selected="selected"';} print '>'.__('First Footer Widget Area','empire').'</option>
							<option value="second-footer-widget-area"'; if($tp_pages_default_f1_widget_area == 'second-footer-widget-area'){print ' selected="selected"';} print '>'.__('Second Footer Widget Area','empire').'</option>
							<option value="third-footer-widget-area"'; if($tp_pages_default_f1_widget_area == 'third-footer-widget-area'){print ' selected="selected"';} print '>'.__('Third Footer Widget Area','empire').'</option>				
							
							';
							//get the rest if exist							
							if($custom_was != ''){
								foreach($custom_was as $custom_wa){
									print '<option value="'.$custom_wa['id'].'"'; if($tp_pages_default_f1_widget_area == $custom_wa['id']){print ' selected="selected"';} print '>'.$custom_wa['title'].'</option>';
								}
							}		
														
							print '
							</select>
						</td>
					</tr>
					<tr class="tp_pad">
						<th scope="row"><label>'.__('or create a new area:','empire').'</label></th>
						<td><input type="text" name="form-tp_pages_new_widget_area_f1" /><span style="color: #aaa;"> ('.__('enter a title for it','empire').')</span></td>
					</tr>
					
					
					
					<tr class="tp_pad">
						<th><h4>'.__('Second Footer Widget Area','empire').'</h4></th>
						<td></td>
					</tr>
					<tr class="tp_pad">
						<th scope="row"><label>'.__('Select a widget area:','empire').'</label></th>
						<td><select name="form-tp_pages_default_f2_widget_area">
							<option value="">'.__('Default Widget Area','empire').'</option>
							<option value="no-widget-area">'.__('No Widget Area','empire').'</option>							
							<option value="first-footer-widget-area"'; if($tp_pages_default_f2_widget_area == 'first-footer-widget-area'){print ' selected="selected"';} print '>'.__('First Footer Widget Area','empire').'</option>
							<option value="second-footer-widget-area"'; if($tp_pages_default_f2_widget_area == 'second-footer-widget-area'){print ' selected="selected"';} print '>'.__('Second Footer Widget Area','empire').'</option>
							<option value="third-footer-widget-area"'; if($tp_pages_default_f2_widget_area == 'third-footer-widget-area'){print ' selected="selected"';} print '>'.__('Third Footer Widget Area','empire').'</option>				
							
							';
							//get the rest if exist							
							if($custom_was != ''){
								foreach($custom_was as $custom_wa){
									print '<option value="'.$custom_wa['id'].'"'; if($tp_pages_default_f2_widget_area == $custom_wa['id']){print ' selected="selected"';} print '>'.$custom_wa['title'].'</option>';
								}
							}		
														
							print '
							</select>
						</td>
					</tr>
					<tr class="tp_pad">
						<th scope="row"><label>'.__('or create a new area:','empire').'</label></th>
						<td><input type="text" name="form-tp_pages_new_widget_area_f2" /><span style="color: #aaa;"> ('.__('enter a title for it','empire').')</span></td>
					</tr>
					
					
					
					
					
					
					<tr class="tp_pad">
						<th><h4>'.__('Third Footer Widget Area','empire').'</h4></th>
						<td></td>
					</tr>
					<tr class="tp_pad">
						<th scope="row"><label>'.__('Select a widget area:','empire').'</label></th>
						<td><select name="form-tp_pages_default_f3_widget_area">
							<option value="">'.__('Default Widget Area','empire').'</option>
							<option value="no-widget-area">'.__('No Widget Area','empire').'</option>							
							<option value="first-footer-widget-area"'; if($tp_pages_default_f3_widget_area == 'first-footer-widget-area'){print ' selected="selected"';} print '>'.__('First Footer Widget Area','empire').'</option>
							<option value="second-footer-widget-area"'; if($tp_pages_default_f3_widget_area == 'second-footer-widget-area'){print ' selected="selected"';} print '>'.__('Second Footer Widget Area','empire').'</option>
							<option value="third-footer-widget-area"'; if($tp_pages_default_f3_widget_area == 'third-footer-widget-area'){print ' selected="selected"';} print '>'.__('Third Footer Widget Area','empire').'</option>				
							
							';
							//get the rest if exist							
							if($custom_was != ''){
								foreach($custom_was as $custom_wa){
									print '<option value="'.$custom_wa['id'].'"'; if($tp_pages_default_f3_widget_area == $custom_wa['id']){print ' selected="selected"';} print '>'.$custom_wa['title'].'</option>';
								}
							}		
														
							print '
							</select>
						</td>
					</tr>
					<tr class="tp_pad">
						<th scope="row"><label>'.__('or create a new area:','empire').'</label></th>
						<td><input type="text" name="form-tp_pages_new_widget_area_f3" /><span style="color: #aaa;"> ('.__('enter a title for it','empire').')</span></td>
					</tr>
					
					
					
				
				
				
				
				<tr>
					<th scope="row"><label></label></th>
					<td></td>
				</tr>	
				
			</table>

			<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="'.__( 'Save Changes', 'empire' ).'"  /></p>	
		
			</form>		
		</div>';
	}




?>