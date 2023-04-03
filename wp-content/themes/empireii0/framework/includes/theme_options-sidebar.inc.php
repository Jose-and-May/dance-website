<?php

// THEME OPTIONS

// layout settings
	
	
	//save settings
	if(!empty($_POST) && !empty($_GET['page']) && $_GET['page'] == 'tp_theme_sidebar'){		
	
		update_option('tp_sidebar_texture',$_POST['form-panel_texture']);
		update_option('tp_sidebar_content',stripslashes($_POST['form-sidebar_content']));		
		update_option('tp_sidebar_icons',stripslashes($_POST['form-sidebar_icons']));		
		update_option('tp_site_position',$_POST['form-site_position']);
		update_option('tp_animation_speed',$_POST['form-animation_speed']);
		update_option('tp_logo_anim',$_POST['form-logo_anim']);
		update_option('tp_site_anim',$_POST['form-site_anim']);
			
			
		
		header("Location: admin.php?page=tp_theme_sidebar&success=1");						
	}
		
		
	//display option layout	
	function tp_theme_sidebar(){
		global $framework_url;

		if(!empty($_GET['success']) && $_GET['success'] == '1'){
			print '<div id="message" class="updated"><p>'.__('Settings are successfully saved.','empire').'</p></div>';
		}
		
		$tp_sidebar_texture = get_option('tp_sidebar_texture');
		$tp_sidebar_content = get_option('tp_sidebar_content');
		$tp_sidebar_icons = get_option('tp_sidebar_icons');
		$tp_site_position = get_option('tp_site_position');
		$tp_animation_speed = get_option('tp_animation_speed');
		$tp_logo_anim = get_option('tp_logo_anim');
		$tp_site_anim = get_option('tp_site_anim');
		
				
		
		print '<div class="wrap">	
			<div class="icon32"><img src="'.$framework_url.'icon-big.png" class="h2_icon" /><br /></div><h2>'.__( 'Layout & Animation', 'empire' ).'</h2>	
		
			<form method="post" action="" enctype="multipart/form-data">		
			
			
			<table class="form-table">
							
				
				<tr>
				<th scope="row"><label>'.__('Site Position','empire').'</label></th>
				<td>
					<label><input type="radio" name="form-site_position" value=""'; if(empty($tp_site_position)){print ' checked="checked"';} print ' /> <span>'.__('Centered','empire').'</span></label><br />
					<label><input type="radio" name="form-site_position" value="left"'; if(!empty($tp_site_position) && $tp_site_position == 'left'){print ' checked="checked"';} print ' /> <span>'.__('Left','empire').'</span></label><br />
					<label><input type="radio" name="form-site_position" value="right"'; if(!empty($tp_site_position) && $tp_site_position == 'right'){print ' checked="checked"';} print ' /> <span>'.__('Right','empire').'</span></label>
				</td>
				</tr>
				<tr>
					<th scope="row"><label></label></th>
					<td></td>
				</tr>	
				
				
				
				
				<tr>
				<th scope="row"><label>'.__('Page Opening Animation','empire').'</label></th>
				<td>					
					<label><input type="radio" name="form-site_anim" value=""'; if(empty($tp_site_anim)){print ' checked="checked"';} print ' /> <span>'.__('Opening animation runs once per session','empire').' <span class="description">'.__('(Session lasts untill browser is closed)','empire').'</span></span></label><br />
					<label><input type="radio" name="form-site_anim" value="closed"'; if(!empty($tp_site_anim) && $tp_site_anim == 'closed'){print ' checked="checked"';} print ' /> <span>'.__('Site is closed on homepage, opens only when a menu is clicked','empire').' <span class="description">'.__('(Works best if AJAX is enabled)','empire').'</span></span></label><br />
					<label><input type="radio" name="form-site_anim" value="disabled"'; if(!empty($tp_site_anim) && $tp_site_anim == 'disabled'){print ' checked="checked"';} print ' /> <span>'.__('Disable opening animation, site is always opened','empire').'</span></label>
				</td>
				</tr>
				
				
				<tr>
				<th scope="row"><label>'.__('Page Opening Speed','empire').'</label></th>
				<td>
					<label><input type="text" class="small-text" name="form-animation_speed" value="'; if(!empty($tp_animation_speed)){print $tp_animation_speed;} print '" /> <span> '.__('miliseconds','empire').'</span> <span class="description">'.__('(1 second = 1000 miliseconds)','empire').'</span></label>
				</td>
				</tr>
				
				
				<tr>
				<th scope="row"><label>'.__('Logo Animation','empire').'</label></th>
				<td>
					<select name="form-logo_anim">
						<option value="">'.__('Enabled','empire').'</option>
						<option value="disabled"'; if(!empty($tp_logo_anim) && $tp_logo_anim == 'disabled'){ print ' selected="selected"'; } print '>'.__('Disabled','empire').'</option>
					</select>
					<span class="description"> '.__('(If enabled, it runs only once per session)','empire').'</span>
				</td>
				</tr>
				
				<tr>
					<th scope="row"><label></label></th>
					<td></td>
				</tr>	
				</table>
				
				
				<h3 class="title">'.__('Sidebar Settings','empire').'</h3>
				
				
				<table class="form-table">
				<tr><th scope="row"><label>'.__('Panel Backgrond Texture','empire').'</label></th>
				<td class="admin-texture">				
					<label>
						<div class="admin-texture-div"><img src="'.get_bloginfo('template_url').'/images/admin-texture-glassy.jpg" /></div>
						<span><input type="radio" name="form-panel_texture" value=""'; if($tp_sidebar_texture == ''){ print ' checked="checked"'; }  print ' /> '.__('Glassy','empire').'</span>
					</label>
					<label>
						<div class="admin-texture-div"><img src="'.get_bloginfo('template_url').'/images/admin-texture-leather-black.jpg" /></div>
						<span><input type="radio" name="form-panel_texture" value="dark_leather"'; if($tp_sidebar_texture == 'dark_leather'){ print ' checked="checked"'; }  print ' /> '.__('Dark Leather','empire').'</span>
					</label>
					<label>
						<div class="admin-texture-div"><img src="'.get_bloginfo('template_url').'/images/admin-texture-leather-brown.jpg" /></div>
						<span><input type="radio" name="form-panel_texture" value="brown_leather"'; if($tp_sidebar_texture == 'brown_leather'){ print ' checked="checked"'; }  print ' /> '.__('Brown Leather','empire').'</span>
					</label>
					<label>
						<div class="admin-texture-div"><img src="'.get_bloginfo('template_url').'/images/admin-texture-leather-red.jpg" /></div>
						<span><input type="radio" name="form-panel_texture" value="red_leather"'; if($tp_sidebar_texture == 'red_leather'){ print ' checked="checked"'; }  print ' /> '.__('Red Leather','empire').'</span>
					</label>
					<label class="clear">
						<div class="admin-texture-div"><img src="'.get_bloginfo('template_url').'/images/admin-texture-wood-black.jpg" /></div>
						<span><input type="radio" name="form-panel_texture" value="dark_wood"'; if($tp_sidebar_texture == 'dark_wood'){ print ' checked="checked"'; }  print ' /> '.__('Dark Wood','empire').'</span>
					</label>
					<label>
						<div class="admin-texture-div"><img src="'.get_bloginfo('template_url').'/images/admin-texture-wood-brown.jpg" /></div>
						<span><input type="radio" name="form-panel_texture" value="brown_wood"'; if($tp_sidebar_texture == 'brown_wood'){ print ' checked="checked"'; }  print ' /> '.__('Brown Wood','empire').'</span>
					</label>
					<label>
						<div class="admin-texture-div"><img src="'.get_bloginfo('template_url').'/images/admin-texture-wood-red.jpg" /></div>
						<span><input type="radio" name="form-panel_texture" value="red_wood"'; if($tp_sidebar_texture == 'red_wood'){ print ' checked="checked"'; }  print ' /> '.__('Red Wood','empire').'</span>
					</label>
					<label>
						<div class="admin-texture-div"><img src="'.get_bloginfo('template_url').'/images/admin-texture-carbon.jpg" /></div>
						<span><input type="radio" name="form-panel_texture" value="carbon"'; if($tp_sidebar_texture == 'carbon'){ print ' checked="checked"'; }  print ' /> '.__('Carbon','empire').'</span>
					</label>
				</td>
				</tr>			
				
				
				
				
				<tr>
					<th scope="row"><label></label></th>
					<td></td>
				</tr>	
				<tr><th scope="row"><label>'.__('Content Below Menu','empire').'<br /><span class="description">'.__('Text, HTML or Shortcode','empire').'</span></label></th>
				<td>	
					<textarea name="form-sidebar_content" class="code" rows="6" cols="60">'; if(!empty($tp_sidebar_content)){print htmlentities($tp_sidebar_content, ENT_QUOTES, 'UTF-8');} print '</textarea>
				</td>
				</tr>
				
				
				
				
				<tr>
					<th scope="row"><label></label></th>
					<td></td>
				</tr>	
				<tr><th scope="row"><label>'.__('Social Icons','empire').'<br /><span class="description">'.__('Use [icon] shortcode here: ','empire').'<br />[icon type="<b><abbr title="'.__('Possible types','empire').': blogger, deviantart, digg, dribbble, email, facebook, flickr, forrst, github, gplus, instagram, linkedin, picasa, pinterest, rss, skype, soundcloud, tumblr, twitter, vimeo, wordpress, youtube">'.__('type','empire').'</abbr></b>" name="<a href="http://fortawesome.github.io/Font-Awesome/icons/" target="_blank">'.__('FontAwesome names','empire').'</a>" image="image source" link="http://yoursite.com"]<br />
				</span></label></th>
				<td>					
					<textarea class="code" rows="6" cols="60"  name="form-sidebar_icons">'; if(!empty($tp_sidebar_icons)){print htmlentities($tp_sidebar_icons, ENT_QUOTES, 'UTF-8');} print '</textarea>										
				</td>
				</tr>
				
				
				
				
			</table>

			<p>&nbsp;</p>
			<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="'.__( 'Save Changes', 'empire' ).'"  /></p>	
		
			</form>		
		</div>';
	}




?>