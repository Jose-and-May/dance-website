<?php

		if(is_admin() && !empty($_GET['page']) && $_GET['page'] == 'tp_bgslider_admin'){
			
			global $wpdb;
				
				//saving				
					if(!empty($_POST)){				
						$images = '';					
						if(!empty($_POST['form-images'])){
							$images = implode(';',$_POST['form-images']);
						}
						
						$pause = '5000';					
						if(!empty($_POST['form-pause'])){
							$pause = $_POST['form-pause'];
						}
						
						$fade = '600';					
						if(!empty($_POST['form-fade'])){
							$fade = $_POST['form-fade'];
						}
						
						$appears_pages = '';
						if(!empty($_POST['form-appears-pages'])){
							$appears_pages = implode(';',$_POST['form-appears-pages']);
						}
						
						$appears_posts = '';
						if(!empty($_POST['form-appears-posts'])){
							$appears_posts = implode(';',$_POST['form-appears-posts']);
						}
					
					
						//saving new slider
						if(!empty($_GET['act']) && $_GET['act'] == 'new'){
						
							//check for our table in DB		
							if($wpdb->get_var("SHOW TABLES LIKE 'tp_bgslider'") != 'tp_bgslider') {
								//create our table			
								$wpdb->query("CREATE TABLE tp_bgslider(
								id int(10) unsigned NOT NULL AUTO_INCREMENT,
								title varchar(255) NOT NULL DEFAULT 'Untitled',
								images text,
								appears_pages text,
								appears_posts text,
								pause int(5),
								fade int(5),
								PRIMARY KEY  (id)
								)");
							}
						
							if($wpdb->insert('tp_bgslider',
								array(
									'title'			=>	$_POST['form-title'],
									'images'		=>	$images,							
									'appears_pages'	=>	$appears_pages,							
									'appears_posts'	=>	$appears_posts,
									'pause'			=> 	$pause,
									'fade'			=> 	$fade
								),
								array(
									'%s',
									'%s',
									'%s',
									'%s',
									'%d',
									'%d'
								)
							)){							
								//success
								header('Location: admin.php?page=tp_bgslider_admin&msg=1&edit='.$wpdb->insert_id);
							}else{
								$msg = '-1';
							}
						}elseif(!empty($_GET['edit'])){
						//saving existing slider
							//update
							
							if($wpdb->update('tp_bgslider',
								array(
									'title'			=>	$_POST['form-title'],
									'images'		=>	$images,							
									'appears_pages'	=>	$appears_pages,							
									'appears_posts'	=>	$appears_posts,
									'pause'			=> 	$pause,
									'fade'			=> 	$fade
								),
								array( 'id' => intval($_GET['edit']) ),
								array(
									'%s',
									'%s',
									'%s',
									'%s',
									'%d',
									'%d'
								),
								array( '%d' )
							)){							
								//success
								header('Location: admin.php?page=tp_bgslider_admin&msg=1&edit='.$_GET['edit']);
							}else{
								$msg = '-1';
							}
						}
					}
					
					
				//delete
					if(!empty($_GET['del'])){
						if($wpdb->delete( 'tp_bgslider', array( 'ID' => intval($_GET['del']) ), array( '%d' ) )){
							//success
							header('Location: admin.php?page=tp_bgslider_admin&msg=1');
						}else{
							$msg = '-1';
						}
					}
					
					
		
			function tp_bgslider_admin(){				
				global $wpdb;
				
				if((!empty($_GET['act']) && $_GET['act'] == 'new') || !empty($_GET['edit'])){
				
				//success or error
					if(!empty($_GET['msg']) && $_GET['msg'] == '1'){
						print '<div id="message" class="updated"><p>'.__('Settings are successfully saved.','tp_bgslider').'</p></div>';
					}elseif(!empty($msg) && $msg == '-1'){
						print '<div id="message" class="error"><p>'.__('Something went wrong!','tp_bgslider').'</p></div>';
					}
				
				
				//load selected slide data					
					if(!empty($_GET['edit'])){	
						$loaded = $wpdb->get_row('SELECT * FROM tp_bgslider WHERE id = '.intval($_GET['edit']), ARRAY_A);
					}
				
		
				
				//add new slide
					print '
					<div class="wrap">	
						<div class="icon32"><img src="'.get_template_directory_uri().'/images/icon-big.png" class="h2_icon" /><br /></div><h2>';
						if(!empty($_GET['edit'])){	
							print __( 'Edit Slider', 'tp_bgslider' ) . ': ' . $loaded['title'];
						}else{
							print __( 'Add New Background Slider', 'tp_bgslider' );
						}
						
						print '<br /><br /></h2>	
						
						<form method="post" action="" enctype="multipart/form-data">		

						<table class="tp-bgslider form-table">
							
							<tr>
								<th scope="row"><label>'.__( 'Slider title', 'tp_bgslider' ).'</label></th>
								<td><input type="text" name="form-title" class="regular-text" value="'; if(!empty($loaded['title'])){ print $loaded['title']; } print '" /></td>
							</tr>
							
							<tr>
								<th scope="row"><label>'.__( 'Pause between two slides', 'tp_bgslider' ).'</label></th>
								<td><input type="text" name="form-pause" class="small-text" value="'; if(!empty($loaded['pause'])){ print $loaded['pause']; } print '" /> ms
								<br /><span class="description">'.__( 'In miliseconds! 1 sec = 1000 ms', 'tp_bgslider' ).'</span></td>
							</tr>
														
							<tr>
								<th scope="row"><label>'.__( 'Fade speed', 'tp_bgslider' ).'</label></th>
								<td><input type="text" name="form-fade" class="small-text" value="'; if(!empty($loaded['fade'])){ print $loaded['fade']; } print '" /> ms
								<br /><span class="description">'.__( 'Transition speed between two slides.', 'tp_bgslider' ).'</span></td>
							</tr>				
														
							<tr>
								<th scope="row"><label>'.__( 'Select where it should appear', 'tp_bgslider' ).'</label></th>
								<td>
									<select multiple="multiple" name="form-appears-pages[]">
										<optgroup label="Pages">
											<option value=""'; if(empty($loaded['appears_pages'])){ print ' selected="selected"'; } print '>-</option>
											<option value="all"'; if(!empty($loaded['appears_pages']) && $loaded['appears_pages'] == 'all'){ print ' selected="selected"'; } print '>'.__('* All pages','tp_bgslider').'</option>
											';
												if(!empty($loaded['appears_pages'])){
													$loaded_appears_pages = explode(';',$loaded['appears_pages']);
												}
												
												//list pages
												$args = array(
													'sort_column' => 'post_title'
												);
												$allpages = get_pages( $args );
												if(!empty($allpages)){
													foreach($allpages as $apage){
														if(!empty($loaded_appears_pages)){
															foreach($loaded_appears_pages as $loaded_pages){
																$found = '0';
																if($loaded_pages == $apage->ID){
																	$found = '1';
																	break;
																}
															}
															
															if($found == '1'){
																print '<option value="'.$apage->ID.'" selected="selected">- '.$apage->post_title.'</option>';
															}else{ 
																print '<option value="'.$apage->ID.'">- '.$apage->post_title.'</option>';
															}
														}else{
															print '<option value="'.$apage->ID.'">- '.$apage->post_title.'</option>';
														}
													}
												}											
											print '
										</optgroup>	
									</select>
									<select multiple="multiple" name="form-appears-posts[]">
										<optgroup label="Posts">
											<option value=""'; if(empty($loaded['appears_posts'])){ print ' selected="selected"'; } print '>-</option>
											<option value="all"'; if(!empty($loaded['appears_posts']) && $loaded['appears_posts'] == 'all'){ print ' selected="selected"'; } print '>'.__('* All posts','tp_bgslider').'</option>
											';
												if(!empty($loaded['appears_posts'])){
													$loaded_appears_posts = explode(';',$loaded['appears_posts']);
												}
											
												//list posts
												$args = array(
													'orderby' => 'post_title',
													'posts_per_page' => -1
												);
												$allposts = get_posts( $args );
												if(!empty($allposts)){
													foreach($allposts as $apost){
														if(!empty($loaded_appears_posts)){
															foreach($loaded_appears_posts as $loaded_posts){
																$found = '0';
																if($loaded_posts == $apost->ID){
																	$found = '1';
																	break;
																}
															}
															
															if($found == '1'){
																print '<option value="'.$apost->ID.'" selected="selected">- '.$apost->post_title.'</option>';
															}else{ 
																print '<option value="'.$apost->ID.'">- '.$apost->post_title.'</option>';
															}
														}else{
															print '<option value="'.$apost->ID.'">- '.$apost->post_title.'</option>';
														}
													}
												}											
											print '
										</optgroup>	
									</select>
									<br /><span class="description">'.__( 'Use CTRL+Click to select more.', 'tp_bgslider' ).'</span>
								</td>
							</tr>							
													
							<tr>
								<th scope="row"><label>'.__( 'Slider items', 'tp_bgslider' ).'</label><br /><span class="description">'.__( 'Drag to order them', 'tp_bgslider' ).'</span></th>
								<td id="slide-images">';									 
									if(function_exists( 'wp_enqueue_media' )){
										print '<input type="button" id="tp-upload" class="button" value="'.__( 'Upload images', 'tp_bgslider' ).'" />';
									}else{
										print __('<strong><i>Please update your WordPress to the latest version!</i></strong>','tp_bgslider');
									}									
									
									print '<br /><span class="description">'.__( 'JPG for images', 'tp_bgslider' ).'</span>';
									
									//hidden vals
									if(!empty($loaded['images'])){
										$loaded_images = explode(';',$loaded['images']);										
									}
									
									print '						
									<div class="holder">';
									if(!empty($loaded_images)){
										foreach($loaded_images as $image){
											//check extension
											$imgext = end(explode('.', $image));
											$ifile = $image;
											if($imgext != 'jpg' && $imgext != 'jpeg' && $imgext != 'mp4'){
												$image = get_template_directory_uri().'/images/unsupported-file.jpg';
											}
											
											if($imgext == 'mp4'){
												$image = get_template_directory_uri().'/images/mp4-file.jpg';
											}
											
										
											print '<div class="tp-bgslider-image" style="background-image:url('.$image.');" data-src="'.$ifile.'" title="'.$ifile.'"><div class="remove" data-src="'.$ifile.'"></div><input type="hidden" name="form-images[]" value="'.$ifile.'" /></div>';
										}
									}
									
									print '</div>									
								</td>
							</tr>
							
							
							
						</table>	
						
						<p class="submit"><input type="submit" name="submit" id="submit" class="button button-primary" value="'.__( 'Save Changes', 'tp_bgslider' ).'"  /></p>	
						
						</form>
						
					</div>
					';
								
				}else{
				//table of slides
					
					//success or error
					if(!empty($_GET['msg']) && $_GET['msg'] == '1'){
						print '<div id="message" class="updated"><p>'.__('Settings are successfully saved.','tp_bgslider').'</p></div>';
					}elseif(!empty($msg) && $msg == '-1'){
						print '<div id="message" class="error"><p>'.__('Something went wrong!','tp_bgslider').'</p></div>';
					}
							
					
					print '
					<div class="wrap">	
						<div class="icon32"><img src="'.get_template_directory_uri().'/images/icon-big.png" class="h2_icon" /><br /></div><h2>'.__( 'Background Slider', 'tp_bgslider' ).'
						<a class="add-new-h2" href="admin.php?page=tp_bgslider_admin&act=new">'.__('Add New','tp_bgslider').'</a>
						<br /><br /></h2>	

						
											
						<table class="wp-list-table widefat tp-bgslider-table" cellspacing="0">
							<thead>
								<tr>								
									<th scope="col" class="manage-column"  style="">'.__('Title','tp_bgslider').'</th>
									<th scope="col" class="manage-column"  style="">'.__('Slider Items','tp_bgslider').'</th>
									<th scope="col" class="manage-column"  style="">'.__('Appears On Page','tp_bgslider').'</th>
									<th scope="col" class="manage-column"  style="">'.__('Appears On Post','tp_bgslider').'</th>
									<th scope="col" class="manage-column"  style=""></th>
								</tr>
							</thead>

							<tfoot>
								<tr>								
									<th scope="col" class="manage-column"  style="">'.__('Title','tp_bgslider').'</th>
									<th scope="col" class="manage-column"  style="">'.__('Slider Items','tp_bgslider').'</th>
									<th scope="col" class="manage-column"  style="">'.__('Appears On Page','tp_bgslider').'</th>
									<th scope="col" class="manage-column"  style="">'.__('Appears On Post','tp_bgslider').'</th>
									<th scope="col" class="manage-column"  style=""></th>
								</tr>
							</tfoot>

							<tbody id="the-list">
							';
							//query all slides
							$dbslides = $wpdb->get_results('SELECT * FROM tp_bgslider');
							if(!empty($dbslides)){
								foreach($dbslides as $dbslide){									
									print '
									<tr>		
										<td class="column-title"><strong><a href="admin.php?page=tp_bgslider_admin&edit='.$dbslide->id.'" class="row-title">'.$dbslide->title.'</a></td>
										<td class="column-thumbs">';
										//thumbs
										if(!empty($dbslide->images)){
											$imgs = explode(';',$dbslide->images);
											$ctr = 0;
											foreach($imgs as $img){		
												//check extension
												$expim = explode('.', $img);
												$imgext = end($expim);												
												if($imgext != 'jpg' && $imgext != 'jpeg' && $imgext != 'mp4'){
													$img = get_template_directory_uri().'/images/unsupported-file.jpg';
												}
												
												if($imgext == 'mp4'){
													$img = get_template_directory_uri().'/images/mp4-file.jpg';
												}
												
												print '<div style="background-image:url('.$img.');" class="tp-bgslider-thumb"></div>';												
												$ctr++;
												if($ctr == 3){ break; }																				
											}
											print ' <span class="description">('.sprintf( _n( '1 item', '%s items', count($imgs), 'empire' ), count($imgs) ).')</span>';
										}else{
											print '<i>'.__('There isn\'t any slider image yet!','tp_bgslider').'</i>';
										}
										print '</td>
										<td class="column-appears-pages">';
										//pages where it appears
										if(!empty($dbslide->appears_pages)){
											if($dbslide->appears_pages == 'all'){
												print __('All pages','tp_bgslider');
											}else{
												$pags = explode(';',$dbslide->appears_pages);
												$pagout = '';
												foreach($pags as $pag){
													$pagout[] = get_the_title($pag);
												}
												print implode(", ", $pagout);
											}											
										}else{
											print '-';
										}
										
										
										print '</td>		
										<td class="column-appears-posts">';
										//posts where it appears
										if(!empty($dbslide->appears_posts)){
											if($dbslide->appears_posts == 'all'){
												print __('All posts','tp_bgslider');
											}else{
												$psts = explode(';',$dbslide->appears_posts);
												$posout = '';
												foreach($psts as $pos){
													$posout[] = get_the_title($pos);
												}
												print implode(", ", $posout);
											}											
										}else{
											print '-';
										}
										
										print '</td>		
										<td class="column-del"><a href="admin.php?page=tp_bgslider_admin&del='.$dbslide->id.'"><img src="'.get_template_directory_uri().'/images/remove.png" alt="remove" /></a></td>
									</tr>
									';
								}
							}else{
								print '
								<tr>		
									<td class="column-title"><strong>'.__('There isn\'t any slider yet!','tp_bgslider').'</td>
									<td class="column-thumbs"></td>
									<td class="column-appears-pages"></td>		
									<td class="column-appears-posts"></td>		
									<td class="column-del"></td>
								</tr>
								';
							}
							
							
							print '
							</tbody>
						</table>
						
					
					</div>
					';
					
				}
			}	
		}
		
		
?>