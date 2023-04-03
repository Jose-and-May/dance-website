<?php

// THEME OPTIONS

// mp3 player settings
	
	
	//save settings
	if(!empty($_POST) && !empty($_GET['page']) && $_GET['page'] == 'tp_theme_mp3'){		
	
		if(!empty($_POST['form-enable_mp3'])){
			//save
			update_option('tp_enable_mp3','1');
		}else{
			delete_option('tp_enable_mp3');
		}
				
		if(!empty($_POST['form-autoplay_mp3'])){
			//save
			update_option('tp_autoplay_mp3','1');
		}else{
			delete_option('tp_autoplay_mp3');
		}
			
			
		//save mp3 tracks
		if(!empty($_POST['form-mp3']) && is_array($_POST['form-mp3'])){			
			$acnt = 0;
			foreach($_POST['form-mp3'] as $formmp3){
				$mp3tracks[$acnt]['url'] = $formmp3['url'];
				$mp3tracks[$acnt]['artist'] = $formmp3['artist'];
				$mp3tracks[$acnt]['title'] = $formmp3['title'];
				$acnt++;
			}
			
			update_option('tp_mp3_tracks',serialize($mp3tracks));
		}else{
			delete_option('tp_mp3_tracks');
		}
		
		
		header("Location: admin.php?page=tp_theme_mp3&success=1");						
	}
		
		
	//display option layout	
	function tp_theme_mp3(){
		global $framework_url;

		if(!empty($_GET['success']) && $_GET['success'] == '1'){
			print '<div id="message" class="updated"><p>'.__('Settings are successfully saved.','empire').'</p></div>';
		}
		
		$tp_enable_mp3 = get_option('tp_enable_mp3');
		$tp_autoplay_mp3 = get_option('tp_autoplay_mp3');
				
		
		print '<div class="wrap">	
			<div class="icon32"><img src="'.$framework_url.'icon-big.png" class="h2_icon" /><br /></div><h2>'.__( 'MP3 Player', 'empire' ).'</h2>	
		
			<form method="post" action="" enctype="multipart/form-data">		

			<table class="form-table">								
				<tr>					
					<td><h3 class="title">'.__('Important notes!','empire').'</h3>
					<p>'.__('The player will not appear if AJAX is disabled, because music would stop on every page change.','empire').'</p>
					<p>'.__('Due to general user experience the player is disabled if the screen size is smaller than 1240px width or 690px height!','empire').'</p>
					</td>
				</tr>	
				
				
				<tr>
					<th scope="row"><label></label></th>
					<td></td>
				</tr>	
				
				<tr>
					<td><input name="form-enable_mp3" id="enable_mp3" type="checkbox" value="1"'; if($tp_enable_mp3 == '1'){ print ' checked="checked"'; } 	print ' /> <label for="enable_mp3">&nbsp;'.__('Enable Mp3 Player on Sidebar','empire').'</label></td>
				</tr>	
				
				<tr>
					<td><input name="form-autoplay_mp3" id="autoplay_mp3" type="checkbox" value="1"'; if($tp_autoplay_mp3 == '1'){ print ' checked="checked"'; } 	print '  /> <label for="autoplay_mp3">&nbsp;'.__('Autoplay first track on start','empire').'</label></td>
				</tr>	
				
				
				<tr>
					<td width="100%">
						<h3>'.__( 'Add your mp3 files', 'empire' ).'</h3>						
					
						<p>'.__('Upload your mp3 files and drag them to modify playing order.','empire').'</p>
					</td>
				</tr>	
				
			</table>
			
			<div id="mp3_files">';
			
			$mp3trax = maybe_unserialize(get_option('tp_mp3_tracks'));
			if(!empty($mp3trax)){
				$mp3cnt = 0;
				foreach($mp3trax as $mp3){					
					print '
					<div>
						<p><label>File URL</label> <input type="text" name="form-mp3['.$mp3cnt.'][url]" value="'.$mp3['url'].'" /></p>
						<p class="margin"><label>Artist</label> <input type="text" class="smaller"  name="form-mp3['.$mp3cnt.'][artist]" value="'.$mp3['artist'].'" /></p>
						<p><label>Track Title</label> <input type="text" class="smaller"  name="form-mp3['.$mp3cnt.'][title]" value="'.$mp3['title'].'" /></p>
						<p class="removep"><a class="item-delete submitdelete deletion" href="#">Remove</a></p>
					</div>';
					$mp3cnt++;
				}
			}
			
			print '
			</div>
			
			<p><a class="button" id="add_new_mp3" href="#">'.__('Upload a New Mp3','empire').'</a></p>
			

			<p>&nbsp;</p>
			<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="'.__( 'Save Changes', 'empire' ).'"  /></p>	
		
			</form>		
		</div>';
	}




?>