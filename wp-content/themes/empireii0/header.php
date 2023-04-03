<?php
if(!is_404() && !is_search()){
	$real_page_id = get_the_ID();
}



?><!DOCTYPE html>
<!--[if !(IE 7) | !(IE 8)  ]><!-->
<html <?php language_attributes(); ?>>
<!--<![endif]-->
<head>
	<meta charset="<?php bloginfo( 'charset' ); ?>" />	
	<?php
	$tp_responsive = get_option('tp_responsive');
	if($tp_responsive == 'off'){
	print '<meta name="viewport" content="width=1024" />';
	}else{
	print '<meta name="viewport" content="width=device-width, initial-scale=1" />
	';
	}
	
	if( is_home() ) {
	print '';
	}
	?>

	<title><?php	
	$title = wp_title( '|', false, 'right' ); 
	print $title;
	bloginfo('name');
	?></title>

	<?php
	$tp_favicon = get_option('tp_favicon');
	if(!empty($tp_favicon)){print '<link rel="shortcut icon" href="'.$tp_favicon.'" />
';} 
	?>
	<link rel="profile" href="http://gmpg.org/xfn/11" />
	<link rel="pingback" href="<?php bloginfo( 'pingback_url' ); ?>" />
	
	<!--[if lt IE 9]>
	<script src="<?php print get_template_directory_uri(); ?>/js/html5.js" type="text/javascript"></script>
	<script src="js/ie-fix-png.js" type="text/javascript"></script>	
	<![endif]-->
		
	<script type="text/javascript">	
	<?php
	if($tp_responsive == 'off'){
	print 'var tp_responsive = \'off\';';
	}else{
	print 'var tp_responsive;';
	}
	?>
	
	var template_url = '<?php print get_template_directory_uri(); ?>';	
	var site_title = '<?php print get_bloginfo('name'); ?>';	
	var is_front_page = <?php print (is_front_page() ? 'true' : 'false'); ?>;
	var ajax_is_on = <?php print (get_option('tp_ajax_load') == 'off' ? 'false' : 'true'); ?>;	
	var bind_pageopen = false;
	
	<?php 
	//VARIABLES FOR OPENING ANIMATION		
		$tp_site_position = get_option('tp_site_position');
			if(empty($tp_site_position)){ $tp_site_position = 'center'; }
			
		$tp_animation_speed = get_option('tp_animation_speed');
			if(empty($tp_animation_speed)){ $tp_animation_speed = 700; }
		
		$tp_logo_anim = get_option('tp_logo_anim');
		
		$openinganimonce = '';
		$tp_siteisclosed = 'false'; 
		$tp_openinganim = 'true';
		$tp_site_anim = get_option('tp_site_anim');		//empty = first_visit, closed, disabled
			if(empty($tp_site_anim)){ 
			// Opening animation runs once per session
				$openinganimonce = 'yes';				
				print '
	var sitealwaysopen = false;
				';
			}elseif($tp_site_anim == 'closed'){ 
			// Site is closed on start, opens only when a menu is clicked
				$tp_siteisclosed = 'true'; 
				print '
	var sitealwaysopen = false;
				';
			}elseif($tp_site_anim == 'disabled'){ 
			// Disable opening animation, site is always opened
				$tp_openinganim = 'false';		
				print '
	var sitealwaysopen = true;
				';
			}
		
	
		print '
	var openingspeed = '.$tp_animation_speed.';
	var siteisclosed = '.$tp_siteisclosed.';
		';
		
		if(empty($_SESSION['sitepos'])){
			print '
	var siteposition = \''.$tp_site_position.'\';
			';
		}else{
			//DEMO
			print '
	var siteposition = \''.$_SESSION['sitepos'].'\';
			';
		}
	
		if(empty($_SESSION['first_visit'])){
			print '
	var firstvisit = true;';
		}else{
			print '
	var firstvisit = false;';
		}
	
	
		
		
		if($openinganimonce == 'yes'){
		//SHOW OPENING ANIMATION ON FIRST VISIT ONLY
			if(empty($_SESSION['first_visit'])){
				print '
	var openinganim = '.$tp_openinganim.';';
				
				if($tp_logo_anim == 'disabled'){
					print '
	var logoanim = false;';
				}else{
					print '
	var logoanim = true;';
				}
			}else{ 
				print '
	var openinganim = false;
	var logoanim = false;
				';
			} 
		}else{
			print '			
	var openinganim = '.$tp_openinganim.';
			';
			
			if($tp_logo_anim == 'disabled'){
				print '
	var logoanim = false;';
			}else{
				print '
	var logoanim = true;';
			}				
		}
		
		
		if(empty($_SESSION['first_visit'])){
			$_SESSION['first_visit'] = 'no';				
		}
	?>
	
	
	</script>
	
	<?php $tp_tracking_code = get_option('tp_tracking_code');
	print stripslashes($tp_tracking_code).'
	
	'; 	
	
	$tp_header = 1;
	
	
	wp_head(); 
?>
</head>
<body <?php body_class(); ?>>
	

	
	<!-- DISPLAY MESSAGE IF JAVA IS TURNED OFF -->	
	<noscript>		
		<div id="notification"><strong>This website requires JavaScript!</strong><br />Please enable JavaScript in your browser and reload the page!</div>	
	</noscript>

	<!-- OLD IE BROWSER WARNING -->
	<div id="ie_warning"><?php print '<img src="'.get_template_directory_uri().'/images/warning.png" alt="warning icon" /><br /><strong>YOUR BROWSER IS OUT OF DATE!</strong><br /><br />This website uses the latest web technologies so it requires an up-to-date, fast browser!<br />Please try <a href="http://www.mozilla.org/en-US/firefox/new/?from=getfirefox">Firefox</a> or <a href="https://www.google.com/chrome">Chrome</a>!'; ?></div>
	
	
	<!-- PRELOADER -->
	<div id="preloader"></div>
	
	
	<?php
		//BACKGROUND SLIDER
		$tp_ajax_load = get_option('tp_ajax_load');
		if($tp_ajax_load == 'off'){
			if(function_exists('tpBgSlider')){
				tpBgSlider();
			}
		}else{
			if(function_exists('tpBgSlider')){
				print '<div id="tp-bgslider-holder"></div>';
			}
		}
	?>
	
	
	<div id="site">
	
		
		<!-- RESPONSIVE SIDEBAR -->
		<section id="responsive-sidebar" class="tp-responsive">
			<div id="rsp-texture" class="<?php		
			$tp_sidebar_texture = get_option('tp_sidebar_texture');			
			if($tp_sidebar_texture == 'dark_leather'){ print 'texture-leather-black'; 
			}elseif($tp_sidebar_texture == 'brown_leather'){ print 'texture-leather-brown'; 
			}elseif($tp_sidebar_texture == 'red_leather'){ print 'texture-leather-red'; 
			}elseif($tp_sidebar_texture == 'dark_wood'){ print 'texture-wood-black'; 
			}elseif($tp_sidebar_texture == 'brown_wood'){ print 'texture-wood-brown'; 
			}elseif($tp_sidebar_texture == 'red_wood'){ print 'texture-wood-red'; 
			}elseif($tp_sidebar_texture == 'carbon'){ print 'texture-carbon'; 
			}else{ print 'texture-glossy'; }			
			?>"></div>
			<div id="rsp-lines"></div>
			<div id="rsp-lineshine"></div>
			
			<div id="rsp-logo"><a href="<?php print home_url(); ?>">
				<?php
					if(get_option('tp_logo') != ''){
						print '<img src="'.get_option('tp_logo').'" alt="logo" />';				
					}else{
						print '<img src="'. get_template_directory_uri() .'/images/logo.png" alt="logo" />';
					}
				?>
			</a></div>
			
			<div id="rsp-menu" title="menu"></div>
			
			<div id="rsp-menu-mobile" title="menu"></div>
			<div id="rsp-menu-mobile-close"></div>
			
			<div id="rsp-menu-nav" title="menu">
				<!-- MENU -->
				<nav>
				<?php
					if( function_exists( 'has_nav_menu' ) && has_nav_menu( 'primary' ) ) {									
						$def = array('container' => 'ul',
						'theme_location' => 'primary',
						'menu_class' => 'menu-rsp',
						'menu_id' => 'menu-rsp');
						wp_nav_menu($def);									
					}
				?>
				</nav>
			</div>
			
			
		</section>
	
		
		<!-- SIDEBAR -->
		<section id="sidebar">
			<div id="sidebar-content">
				<div id="logo"><a href="<?php print home_url(); ?>">
				<?php
					if(get_option('tp_logo') != ''){
						print '<img src="'.get_option('tp_logo').'" alt="logo" />';				
					}else{
						print '<img src="'. get_template_directory_uri() .'/images/logo.png" alt="logo" />';
					}
				?>
				</a></div>
			
				<!-- MENU -->
				<nav>
				<?php
					if( function_exists( 'has_nav_menu' ) && has_nav_menu( 'primary' ) ) {									
						$def = array('container' => 'ul',
						'theme_location' => 'primary',
						'menu_id' => 'menu-main');
						wp_nav_menu($def);									
					}
				?>
				</nav>
				
				
						
				<?php 
					$tp_sidebar_content = get_option('tp_sidebar_content'); 
					if(!empty($tp_sidebar_content)){
						print '
						<!-- CONTENT BELOW MENU -->		
						<article class="below-menu">
						'.do_shortcode($tp_sidebar_content).
						'</article>';
					}
				?>
				
				
				
				<?php
					$tp_enable_mp3 = get_option('tp_enable_mp3');
					$tp_ajax_load = get_option('tp_ajax_load');
					if($tp_enable_mp3 == '1' && $tp_ajax_load != 'off'){
						$tp_mp3_tracks = get_option('tp_mp3_tracks');
						if(!is_array($tp_mp3_tracks)){
							$tp_mp3_tracks = unserialize($tp_mp3_tracks);
						}
					
						print '<!-- MP3 PLAYER -->
						<div class="tp-audio-player">
							<ul class="mejs-list">
							';
							if(!empty($tp_mp3_tracks)){
								$fctr = 0;
								foreach($tp_mp3_tracks as $trax){									
									$classcurr = '';
									if($fctr == 0){
										$classcurr = ' class="current"';
									}
									
									print '
									<li data-src="'.$trax['url'].'"'.$classcurr.'>'.$trax['artist'].'<br /><span>'.$trax['title'].'</span></li>																						
									';
									$fctr++;
								}
							}else{
								print '
									<li data-src="http://themeprince.com/themes/empireii/timo.mp3" class="current">You Can Disable Autoplay<br /><span>Or the player from Admin</span></li>																						
								';
							}
						print '
							</ul>
							';
							
							$autoplay = '';
							if(!empty($tp_mp3_tracks)){
								if(get_option('tp_autoplay_mp3') == '1'){
									$autoplay = ' autoplay="true"';
								}
																
								print '<audio id="mejs" src="'.$tp_mp3_tracks[0]['url'].'" type="audio/mp3" controls="controls"'.$autoplay.'></audio>';
							}else{
								if(get_option('tp_autoplay_mp3') == '1'){
									$autoplay = ' autoplay="true"';
								}
								
								print '<audio id="mejs" src="http://themeprince.com/themes/empireii/timo.mp3" type="audio/mp3" controls="controls"'.$autoplay.'></audio>';
							}
							
						print '	
							<button class="audio-prev" title="'.__('Previous track','empire').'"></button><button class="audio-next" title="'.__('Next track','empire').'"></button>
						</div>
						';
					}
				?>					
				
				<!-- SOCIAL ICONS (IF EXISTS) -->				
				<?php 
					$tp_sidebar_icons = get_option('tp_sidebar_icons'); 
					if(!empty($tp_sidebar_icons)){
						print '<section class="social-icons">
						'.do_shortcode($tp_sidebar_icons).
						'</section>';
					}
				?>
			</div>
			
			<div id="line-shine"></div>			
			<div id="lines"></div>						
			<div id="texture" class="<?php			
			if($tp_sidebar_texture == 'dark_leather'){ print 'texture-leather-black'; 
			}elseif($tp_sidebar_texture == 'brown_leather'){ print 'texture-leather-brown'; 
			}elseif($tp_sidebar_texture == 'red_leather'){ print 'texture-leather-red'; 
			}elseif($tp_sidebar_texture == 'dark_wood'){ print 'texture-wood-black'; 
			}elseif($tp_sidebar_texture == 'brown_wood'){ print 'texture-wood-brown'; 
			}elseif($tp_sidebar_texture == 'red_wood'){ print 'texture-wood-red'; 
			}elseif($tp_sidebar_texture == 'carbon'){ print 'texture-carbon'; 
			}else{ print 'texture-glossy'; }			
			?>"></div>			
		</section>
		
		
		
		<!-- MAIN PAGE FOR CONTENT-->
		<section id="page">
			<div id="page-content">
			
