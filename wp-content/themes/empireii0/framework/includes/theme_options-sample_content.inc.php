<?php

// THEME OPTIONS

// sample content
						


						
						
		
	//start import
	if(!empty($_POST) && !empty($_POST['tp_sc_step']) && $_POST['tp_sc_step'] == 'import' && !empty($_GET['page']) && $_GET['page'] == 'tp_theme_sample_content'){
			
		//self check first		
			$headerprefix = '';

		
			//test PHP ini setting for file read						
			if(ini_get('allow_url_fopen') != '1'){
				$headerprefix = '&error=ini';
			}			
			
			//test theme folder position
			$themedir = get_template_directory_uri();
			$themedir = explode('wp-content/themes/',$themedir);
			if(strstr($themedir[1],'/')){
				$headerprefix = '&error=1';
			}			
			
					
			//test mkdir
			$uploads_dir = '../wp-content/uploads';
			if(!is_dir($uploads_dir)){
				if(!mkdir($uploads_dir)){
					$headerprefix = '&error=2';					
				}
			}
			
			
			//test copy					
			$themepath = '../wp-content/themes/'.$themedir[1];
			@mkdir($uploads_dir.'/revslider/homepage', 0777, true);
			if(!copy($themepath.'/sample_content/media/pixabay-music.jpeg', '../wp-content/uploads/pixabay-music.jpeg')){
				$headerprefix = '&error=3';				
			}
			
						
			//test read data.imp file						
			if(!@file(get_template_directory_uri().'/sample_content/data.imp')){
				$headerprefix = '&error=5';					
			}
				
			

			
			
			//if no error, begin import
			if(empty($headerprefix)){
								
				//copy all media files
					$alldemofiles = $themepath.'/sample_content/media';
					$files = glob($alldemofiles.'/*.*');
					foreach($files as $file){
						$file_to_go = str_replace($alldemofiles,'../wp-content/uploads',$file);
						if(!copy($file, $file_to_go)){
							$headerprefix = '&error=4';	
						}
					}
					
					$alldemofiles = $themepath.'/sample_content/media/revslider/homepage';
					$files = glob($alldemofiles.'/*.*');
					foreach($files as $file){
						$file_to_go = str_replace($alldemofiles,'../wp-content/uploads/revslider/homepage',$file);
						if(!copy($file, $file_to_go)){
							$headerprefix = '&error=4';	
						}
					}
					
					
				//import data to db
					global $wpdb;								
					
					
				
					//posts, pages, media library
						//read SQL file and query the lines one by one with correct table prefix
						//if table prefix is not the default one, replace tables in each query
					
						$tdir = get_template_directory_uri();
						
						global $wpdb;								
						
						$getimp = file_get_contents($tdir.'/sample_content/data.imp');
						$implines = explode('<empire_sep>',$getimp);
						
						
						
							//clear tables							
							$wpdb->query('TRUNCATE TABLE '.$wpdb->prefix.'comments');
							$wpdb->query('TRUNCATE TABLE '.$wpdb->prefix.'postmeta');
							$wpdb->query('TRUNCATE TABLE '.$wpdb->prefix.'posts');
							$wpdb->query('TRUNCATE TABLE '.$wpdb->prefix.'term_relationships');
							$wpdb->query('TRUNCATE TABLE '.$wpdb->prefix.'term_taxonomy');
							$wpdb->query('TRUNCATE TABLE '.$wpdb->prefix.'terms');
						
							//check-clear revslider tables
								if(!$wpdb->get_var("SHOW TABLES LIKE '%revslider_sliders'")) {
									//create table
									$charset_collate = '';

									if ( ! empty( $wpdb->charset ) ) {
									  $charset_collate = 'DEFAULT CHARACTER SET '.$wpdb->charset;
									}

									if ( ! empty( $wpdb->collate ) ) {
									  $charset_collate .= ' COLLATE '.$wpdb->collate;
									}
									
									$sql = "CREATE TABLE ".$wpdb->prefix."revslider_sliders (
									id int(9) NOT NULL AUTO_INCREMENT,
									title tinytext NOT NULL,
									alias tinytext,
									params text NOT NULL,
									PRIMARY KEY (id)
									) ".$charset_collate.";";
									
									require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
									dbDelta( $sql );
									
									
								}else{
									//clear table if exist
									$wpdb->query('TRUNCATE TABLE '.$wpdb->prefix.'revslider_sliders');
								}
								
								if(!$wpdb->get_var("SHOW TABLES LIKE '%revslider_slides'")) {
									//create table
									$charset_collate = '';

									if ( ! empty( $wpdb->charset ) ) {
									  $charset_collate = 'DEFAULT CHARACTER SET '.$wpdb->charset;
									}

									if ( ! empty( $wpdb->collate ) ) {
									  $charset_collate .= ' COLLATE '.$wpdb->collate;
									}
									
									$sql = "CREATE TABLE ".$wpdb->prefix."revslider_slides (
									id int(9) NOT NULL AUTO_INCREMENT,
									slider_id int(9) NOT NULL,
									slide_order int(11) NOT NULL,
									params text NOT NULL,
									layers text NOT NULL,
									PRIMARY KEY (id)
									) ".$charset_collate.";";
									
									require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
									dbDelta( $sql );
									
								}else{
									//clear table if exist
									$wpdb->query('TRUNCATE TABLE '.$wpdb->prefix.'revslider_slides');
								}
							
						
								if(!$wpdb->get_var("SHOW TABLES LIKE 'tp_bgslider'")) {
									//create table
									$charset_collate = '';

									if ( ! empty( $wpdb->charset ) ) {
									  $charset_collate = 'DEFAULT CHARACTER SET '.$wpdb->charset;
									}

									if ( ! empty( $wpdb->collate ) ) {
									  $charset_collate .= ' COLLATE '.$wpdb->collate;
									}
									
									$sql = "CREATE TABLE tp_bgslider (
									id int(9) NOT NULL AUTO_INCREMENT,
									title varchar(255) NOT NULL,
									images text NULL,
									appears_pages text NULL,
									appears_posts text NULL,
									pause int(5) NULL,
									fade int(5) NULL,
									PRIMARY KEY (id)
									) ".$charset_collate.";";
									
									require_once( ABSPATH . 'wp-admin/includes/upgrade.php' );
									dbDelta( $sql );
									
								}else{
									//clear table if exist
									$wpdb->query('TRUNCATE TABLE tp_bgslider');
								}
						
						
						
							//run each query
							foreach($implines as $line){
								if(!empty($line)){									
									//prefix check, replace										
									
										if(strstr($line,'wp_comments') && $wpdb->prefix != 'wp_'){
											$line = str_replace('wp_comments',$wpdb->prefix.'comments',$line);																				
										}
										
										if(strstr($line,'wp_postmeta')){
											if($wpdb->prefix != 'wp_'){
												$line = str_replace('wp_postmeta',$wpdb->prefix.'postmeta',$line);		
											}																				
											
											//also replace my path to user path
											$currsiteurl = get_site_url();
											$line = str_replace('http://localhost/empireii',$currsiteurl,$line);
										}
										
										if(strstr($line,'wp_posts')){
											if($wpdb->prefix != 'wp_'){
												$line = str_replace('wp_posts',$wpdb->prefix.'posts',$line);
											}
											
											//also replace my path to user path
											$currsiteurl = get_site_url();
											$line = str_replace('http://localhost/empireii',$currsiteurl,$line);
										}
										
										if(strstr($line,'wp_term_relationships') && $wpdb->prefix != 'wp_'){
											$line = str_replace('wp_term_relationships',$wpdb->prefix.'term_relationships',$line);
										}
										
										if(strstr($line,'wp_term_taxonomy') && $wpdb->prefix != 'wp_'){
											$line = str_replace('wp_term_taxonomy',$wpdb->prefix.'term_taxonomy',$line);
										}
										
										if(strstr($line,'wp_terms') && $wpdb->prefix != 'wp_'){
											$line = str_replace('wp_terms',$wpdb->prefix.'terms',$line);
										}
										
										
										//bgslider
										if(strstr($line,'tp_bgslider')){
											$currsiteurl = get_site_url();
											$line = str_replace('http://localhost/empireii',$currsiteurl,$line);
										}
										
										
										//revslider
										if(strstr($line,'wp_revslider_sliders')){
											if($wpdb->prefix != 'wp_'){
												$line = str_replace('wp_revslider_sliders',$wpdb->prefix.'revslider_sliders',$line);
											}																						
										}
										
										if(strstr($line,'wp_revslider_slides')){
											if($wpdb->prefix != 'wp_'){
												$line = str_replace('wp_revslider_slides',$wpdb->prefix.'revslider_slides',$line);
											}											
										}
										
										
										
										
										
										
									//process the line	
										if(!$wpdb->query($line)){
											$headerprefix = '&error=6';
										}

								}
							}
							
							
							//fix revslider paths
								$csurl = get_site_url();
								$csurl = str_replace('/','\\\/',$csurl);
								$wpdb->query("UPDATE ".$wpdb->prefix."revslider_slides SET params = REPLACE(params, 'replacethistp', '".$csurl."')");
								$wpdb->query("UPDATE ".$wpdb->prefix."revslider_slides SET layers = REPLACE(layers, 'replacethistp', '".$csurl."')");
								$wpdb->query("UPDATE ".$wpdb->prefix."revslider_sliders SET params = REPLACE(params, 'replacethistp', '".$csurl."')");
							
						
						
						
				
					
				
					//settings, options, widgets	
						if(empty($headerprefix)){					
							update_option('category_children',unserialize('a:1:{i:6;a:4:{i:0;i:9;i:1;i:10;i:2;i:11;i:3;i:12;}}'));
							update_option('page_on_front','620');
							update_option('permalink_structure','');
							update_option('posts_per_page','4');
							update_option('show_on_front','page');
							update_option('sidebars_widgets',unserialize('a:5:{s:19:"wp_inactive_widgets";a:0:{}s:24:"first-footer-widget-area";a:1:{i:0;s:10:"archives-2";}s:25:"second-footer-widget-area";a:1:{i:0;s:24:"tp_widget_recent_posts-2";}s:24:"third-footer-widget-area";a:1:{i:0;s:6:"text-2";}s:13:"array_version";i:3;}'));
							update_option('theme_mods_empireii',unserialize('a:2:{i:0;b:0;s:18:"nav_menu_locations";a:1:{s:7:"primary";i:20;}}'));	
							update_option('tp_enable_mp3','1');	
							$tpmp3 = unserialize('a:1:{i:0;a:3:{s:3:"url";s:55:"http://localhost/empireii/wp-content/uploads/jazzy2.mp3";s:6:"artist";s:16:"Nameless Dancers";s:5:"title";s:14:"Hot Funky Body";}}');
							$currsiteurl = get_site_url();
							$tpmp3[0]['url'] = str_replace('http://localhost/empireii',$currsiteurl,$tpmp3[0]['url']);											
							update_option('tp_mp3_tracks',$tpmp3);	
							update_option('tp_sidebar_icons','[icon type="facebook" link="#"][icon type="twitter" link="#"][icon type="gplus" link="#"][icon type="rss" link="#"] ');	
							update_option('tp_site_anim','closed');	
							update_option('widget_archives',unserialize('a:2:{i:2;a:3:{s:5:"title";s:8:"ARCHIVES";s:5:"count";i:0;s:8:"dropdown";i:0;}s:12:"_multiwidget";i:1;}'));	
							update_option('widget_text',unserialize('a:2:{i:2;a:3:{s:5:"title";s:12:"TWITTER FEED";s:4:"text";s:200:"Please download my Recent Tweets plugin to show twitter feed here: <a href="https://wordpress.org/plugins/recent-tweets-widget/" target="_blank">https://wordpress.org/plugins/recent-tweets-widget/</a>";s:6:"filter";b:0;}s:12:"_multiwidget";i:1;}'));	
							update_option('widget_tp_widget_recent_posts',unserialize('a:2:{i:2;a:4:{s:23:"tp_w_recent_posts_title";s:12:"RECENT POSTS";s:25:"tp_w_recent_posts_display";s:4:"time";s:23:"tp_w_recent_posts_count";s:1:"3";s:30:"tp_w_recent_posts_display_cats";N;}s:12:"_multiwidget";i:1;}'));
							
							
							
							
							
						}
				
				
				
				
				//if all went fine			
					if(empty($headerprefix)){
						$headerprefix = '&success=1';					
					}
			}
		
			
		header('Location: admin.php?page=tp_theme_sample_content'.$headerprefix);						
		
	}
	
	
		
	//display option layout	
	function tp_theme_sample_content(){
		global $framework_url;

		if(!empty($_GET['success']) && $_GET['success'] == '1'){
			print '<div id="message" class="updated"><p>'.__('Demo content has been imported successfully!','empire').'</p></div>';
		}
				
		
		
		print '<div class="wrap">	
			<h2>'.__( 'Sample Content Import', 'empire' ).'</h2>	
		
			<form method="post" action="" enctype="multipart/form-data">		
			';
			
			if(!empty($_GET['error'])){
				if($_GET['error'] == '1'){
					print '<p>'.__( '<strong>Error!</strong> Theme folder is not installed into the correct folder structure!<br /><br /><strong>Correct:</strong> yoursite.com/wp-content/themes/empire/<br /><strong>Wrong:</strong> yoursite.com/wp-content/themes/empire/empire/', 'empire' ).'</p>
					';
				}elseif($_GET['error'] == '2'){
					print '<p>'.__( '<strong>Error!</strong> Couldn\'t create/access <strong>wp-content/upload</strong> directory! Permission problem?','empire').'</p>
					';
				}elseif($_GET['error'] == '3'){
					print '<p>'.__( '<strong>Error!</strong> Couldn\'t copy a file into <strong>wp-content/upload</strong> directory! Permission problem?','empire').'</p>
					';
				}elseif($_GET['error'] == '4'){
					print '<p>'.__( '<strong>Error!</strong> Couldn\'t copy one or more files!','empire').'</p>
					';
				}elseif($_GET['error'] == '5'){
					print '<p>'.__( '<strong>Error!</strong> Couldn\'t read sample content data file!','empire').'</p>
					';
				}elseif($_GET['error'] == '6'){
					print '<p>'.__( '<strong>Error!</strong> One or more database query failed!','empire').'</p>
					';
				}elseif($_GET['error'] == 'ini'){
					print '<p>'.__( '<strong>Error!</strong> The PHP <b>allow_url_fopen</b> setting is disabled on your server! Please enable it (at least temporary)!','empire').'</p>
					';
				}
				
			}elseif(!empty($_POST) && $_POST['tp_sc_step'] == 'confirm'){
				
				print '<table class="form-table">			
					<tr valign="top">					
						<td><p>'.__('<strong>Warning! The importing process will remove your existing posts, pages and media library!<br />Are you sure you want to proceed?</strong>','empire').'<br />							
						</p></td>
					</tr>
				</table>
				
				<p class="submit">
					<input type="hidden" name="tp_sc_step" value="import" />
					<input type="submit" name="submit" id="submit" class="button button-primary" value="'.__( 'Yes! Import sample content!', 'empire' ).'"  />
				</p>';
			}elseif(!empty($_GET['success']) && $_GET['success'] == '1'){
				
				print '<table class="form-table">			
					<tr valign="top">					
						<td><p>'.__('<strong>Success!</strong> Please <a href="themes.php?page=install-required-plugins">install required plugins</a> in case you haven\'t already done so!','empire').'<br />							
						</p></td>
					</tr>
				</table>
				';
			}else{
				
				print '
				<table class="form-table">			
					<tr valign="top">					
						<td><p>'.__('Here you\'re able to import the contents of live preview with a single click. However you have to manually import the WooCommerce demo content in case you need it.
						<br /><strong>Please note:</strong> due to licenses all images and videos will be blurred!','empire').'<br /><br /><br />
						<strong>Warning! The importing process will remove your existing posts, pages and media library! It\'s recommended to use a fresh, clean WordPress install! </strong><br />							
						</p></td>
					</tr>
				</table>
				
				<p class="submit">
					<input type="hidden" name="tp_sc_step" value="confirm" />
					<input type="submit" name="submit" id="submit" class="button button-primary" value="'.__( 'Import sample content', 'empire' ).'"  />
				</p>	
				';
				
			}
			
			
		print '					
			</form>		
		</div>';
	}




?>