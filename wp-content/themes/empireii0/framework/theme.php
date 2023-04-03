<?php

// start session if not started already
	if(!session_id()){
		session_start();
	}


// theme url
	$framework_url = get_template_directory_uri().'/framework/';
	$theme_text_domain = 'empire';	

	
	
// dashboard widget 
	function my_custom_dashboard_widgets_tp() {
		global $wp_meta_boxes;	
		add_meta_box( 'custom_help_widget', 'Welcome!', 'custom_dashboard_help', 'dashboard', 'normal', 'high' );	
	}

	function custom_dashboard_help() {	
		echo '<p id="themeprince"><a href="http://www.themeprince.com/" target="_blank"><img src="'.get_template_directory_uri().'/images/themeprince.jpg" style="float: left; margin-right: 15px;" /></a>
			<span class="themeprince_h4">Thank you for choosing Theme Prince!</span><br /><br />
			We appriciate that you decided to use one of our themes. Please read the included documentation carefully and in case something is not working properly, use
			our <a href="http://www.themeprince.com/">support forum</a> to receive help. All reported bugs will be fixed and updated.		
			Don\'t forget to <a href="http://www.themeprince.com/" target="_blank">visit our site</a> regularly because we release a new theme every month!
			<br /><br />
			Kind regards,<br />
			<a href="http://www.themeprince.com/" target="_blank">Theme Prince</a><br /><br />
		</p>';	
	}
	add_action('wp_dashboard_setup', 'my_custom_dashboard_widgets_tp');

	
	
// sets up the content width value based on the theme's design and stylesheet
	if ( ! isset( $content_width ) ){
		$content_width = 980;
	}
	
	
 
// set up theme defaults
	function tp_fw_setup() {
		
		// makes theme available for translation
		load_theme_textdomain( 'empire', get_template_directory() . '/languages' );
		
		// this theme styles the visual editor with editor-style.css to match the theme style
		if(is_admin()){
			require_once('includes/editor_styles.inc.php');	
		}
		add_editor_style();

		// adds rss feed links to <head> for posts and comments
		add_theme_support( 'automatic-feed-links' );

		// this theme supports a variety of post formats
		add_theme_support( 'post-formats', array( 'link', 'image', 'gallery', 'quote', 'audio', 'video' ) );	
				
		// this theme uses wp_nav_menu() in one location
		register_nav_menu( 'primary', __( 'Primary Menu', 'empire' ) );
				
		// support shortcodes in text widgets
		add_filter( 'widget_text', 'do_shortcode');
				
				
		// if excerpt is empty, show nothing
		//remove_filter('get_the_excerpt', 'wp_trim_excerpt'); 
		
		//remove gallery inline style
		add_filter( 'use_default_gallery_style', '__return_false' );
		
		

		//change default gravatar
		add_filter( 'avatar_defaults', 'newgravatar' );  		  
		function newgravatar ($avatar_defaults) {  
			$myavatar = get_template_directory_uri() . '/images/avatar.jpg';  
			$avatar_defaults[$myavatar] = "empire user";  
			return $avatar_defaults;  
		}  

		
		// this theme uses a custom image size for featured images, displayed on "standard" posts
		add_theme_support( 'post-thumbnails' );
		
		// set thumbnail sizes with wp, forget custom imagecrop scripts		
		set_post_thumbnail_size( 211, 140, true ); // width, height, crop = true		
		if ( function_exists( 'add_image_size' ) ) {
			add_image_size( 'masonry-thumb', 273, 9999 ); // name, width, height, crop = true						
			add_image_size( 'portfolio-thumb', 273, 204, true  ); // name, width, height, crop = true						
			add_image_size( 'full-thumb', 576, 170, true ); // name, width, height, crop = true						
			add_image_size( 'single-thumb', 659, 9999 ); // name, width, height, crop = true						
		}
		
	}
	add_action( 'after_setup_theme', 'tp_fw_setup' );
	
		
// after theme activation, check/create bg slider DB
	function tp_bgslider_install(){
		global $wpdb;
		
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
	}	
	add_action('after_switch_theme', 'tp_bgslider_install');	
	
	

// enqueues scripts and styles for backend
	function tp_fw_backend_scripts_styles(){
	
		$myStyleUrl = get_template_directory_uri() . '/css/admin.css';
		wp_register_style('myStyleSheets', $myStyleUrl);
        wp_enqueue_style('myStyleSheets');        		
		
		
		
		
		
		print '
		<script type="text/javascript">
		var templateDir = "'. get_template_directory_uri() .'";
		</script>
		';
		
		
		if(!empty($_GET['page']) && $_GET['page'] == 'tp_bgslider_admin'){		
			//background slider
			if(function_exists( 'wp_enqueue_media' )){
				wp_enqueue_media();
			}
			
			wp_enqueue_script( 'jquery-ui-core' );		
			wp_enqueue_script( 'jquery-ui-widget' );		
			wp_enqueue_script( 'jquery-ui-mouse' );		
			wp_enqueue_script( 'jquery-ui-sortable' );		
			wp_enqueue_script( 'jquery-ui-draggable' );					
			wp_enqueue_script( 'tp_bgslider_plugin_adminjs', get_template_directory_uri() . '/js/jquery.bgslider.admin.js',array('jquery') );
			wp_enqueue_style( 'tp_bgslider_plugin_admin_css', get_template_directory_uri() . '/css/tp_bgslider-admin.css', array(), '1.0', 'screen' );	
		}
		
		
		
		if(!empty($_GET['page']) && $_GET['page'] == 'tp_theme_layout'){					
			
			wp_deregister_script('farbtastic');
			wp_register_script( 'farbtastic', get_template_directory_uri() . '/js/farbtastic.js');
			wp_enqueue_script('farbtastic');
			
			
			wp_deregister_style('farbtastic');
			wp_register_style('farbtastic', get_template_directory_uri() . '/css/farbtastic.css');
			wp_enqueue_style( 'farbtastic' );			
			
			wp_register_script( 'tos', get_template_directory_uri() . '/js/tp_theme_layout.js');
			wp_enqueue_script( 'tos' );
			
			if(function_exists( 'wp_enqueue_media' )){
				wp_enqueue_media();
			}else{
				wp_enqueue_script('jquery');  
		  
				wp_enqueue_script('thickbox');  
				wp_enqueue_style('thickbox');  
		  
				wp_enqueue_script('media-upload');  
				wp_enqueue_script('wptuts-upload');  
			}
		
			wp_register_script( 'admin_mediaup', get_template_directory_uri() . '/js/admin_media_upload.js');
			wp_enqueue_script( 'admin_mediaup' );
		}
		
		if(!empty($_GET['post']) && $_GET['post'] != ''){
			if(function_exists( 'wp_enqueue_media' )){
				wp_enqueue_media();
			}else{
				wp_enqueue_script('jquery');  
		  
				wp_enqueue_script('thickbox');  
				wp_enqueue_style('thickbox');  
		  
				wp_enqueue_script('media-upload');  
				wp_enqueue_script('wptuts-upload');  
			}
		
			wp_register_script( 'admin_mediaup', get_template_directory_uri() . '/js/admin_media_upload.js');
			wp_enqueue_script( 'admin_mediaup' );
		}

		if(!empty($_GET['page']) && $_GET['page']=='tp_theme_typography'){			
			
			//enqueue font-face
			wp_register_style('admin_fontface_fonts', get_template_directory_uri() . '/css/admin_fontface_fonts.css');
            wp_enqueue_style( 'admin_fontface_fonts'); 			
			
			$tp_typography_custom_fonts = unserialize(get_option('tp_typography_custom_fonts'));
			if($tp_typography_custom_fonts != ''){
				$impf = implode(',',$tp_typography_custom_fonts);
				wp_register_style('load_admin_custom_fonts', get_template_directory_uri() . '/framework/includes/load_admin_custom_fonts.inc.php?fonts='.$impf);
				wp_enqueue_style( 'load_admin_custom_fonts' );
			}
			
			wp_deregister_script('farbtastic');
			wp_register_script( 'farbtastic', get_template_directory_uri() . '/js/farbtastic.js');
			wp_enqueue_script('farbtastic');
			
			
			wp_deregister_style('farbtastic');
			wp_register_style('farbtastic', get_template_directory_uri() . '/css/farbtastic.css');
			wp_enqueue_style( 'farbtastic' );			
			
			wp_register_script( 'tos', get_template_directory_uri() . '/js/tp_theme_typography.js');
			wp_enqueue_script( 'tos' );
		}			
		
		if(!empty($_GET['page']) && $_GET['page'] == 'tp_theme_general'){
			if(function_exists( 'wp_enqueue_media' )){
				wp_enqueue_media();
			}else{
				wp_enqueue_script('jquery');  
		  
				wp_enqueue_script('thickbox');  
				wp_enqueue_style('thickbox');  
		  
				wp_enqueue_script('media-upload');  
				wp_enqueue_script('wptuts-upload');  
			}
		
			wp_register_script( 'admin_mediaup', get_template_directory_uri() . '/js/admin_media_upload.js');
			wp_enqueue_script( 'admin_mediaup' );
		}
		
		if(strstr($_SERVER['SCRIPT_NAME'],'/post-new.php') OR strstr($_SERVER['SCRIPT_NAME'],'/post.php') OR strstr($_SERVER['SCRIPT_NAME'],'/widgets.php')){
			wp_register_script( 'admin_scg', get_template_directory_uri() . '/js/admin_scripts.js');
			wp_enqueue_script( 'admin_scg' );			
		}		
				
		if(strstr($_SERVER['SCRIPT_NAME'],'/post-new.php') OR strstr($_SERVER['SCRIPT_NAME'],'/post.php')){
			wp_register_script( 'admin_blogcats', get_template_directory_uri() . '/js/admin_blog_categories.js');
			wp_enqueue_script( 'admin_blogcats' );			
			
			wp_register_script( 'admin_mediaup', get_template_directory_uri() . '/js/admin_media_upload.js');
			wp_enqueue_script( 'admin_mediaup' );
		}				
				
		if(strstr($_SERVER['SCRIPT_NAME'],'/widgets.php')){			
			wp_register_script( 'widg', get_template_directory_uri() . '/js/widgets.js');
			wp_enqueue_script( 'widg' );			
		}		
		
		
		if(!empty($_GET['page']) && $_GET['page']=='tp_theme_mp3'){		
			wp_enqueue_script( 'jquery-core' );		
			wp_enqueue_script( 'jquery-migrate' );		
			wp_enqueue_script( 'jquery-ui-core' );		
			wp_enqueue_script( 'jquery-ui-widget' );		
			wp_enqueue_script( 'jquery-ui-mouse' );		
			wp_enqueue_script( 'jquery-ui-sortable' );		
			wp_enqueue_script( 'jquery-ui-draggable' );		
			
			if(function_exists( 'wp_enqueue_media' )){
				wp_enqueue_media();
			}
			
			wp_register_script( 'tos', get_template_directory_uri() . '/js/tp_theme_mp3.js');
			wp_enqueue_script( 'tos' );			
			
			
		}
	
	
	}
	add_action('admin_enqueue_scripts', 'tp_fw_backend_scripts_styles');

	
	

// correct image path issue in thickbox
	function load_tb_fix() {
		echo "\n" . '<script type="text/javascript">tb_pathToImage = "' . get_template_directory_uri() . '/images/loading.gif";</script>'. "\n";
	}
	add_action('wp_footer', 'load_tb_fix');
		
			
	

//frontend scipts and styles
	function tp_frontend_load(){
	
		wp_enqueue_script('jquery');
		wp_enqueue_script('jquery-ui-core');	
		wp_enqueue_script('jquery-ui-tabs');	
		
		
		//retina JS				
		if(get_option('tp_retina') != 'off'){
			wp_enqueue_script( 'retina_js', get_template_directory_uri() . '/js/retina.min.js', '', '', true );
		}
		
		//font awesome
		wp_enqueue_style('font-awesome', get_template_directory_uri().'/css/font-awesome.min.css',array(),null,'all');		
		
		//thickbox
		wp_enqueue_script('thickbox', true);
		wp_enqueue_style('thickbox');
		
		
		//mediaelement
		//wp_enqueue_script('wp-mediaelement');		
		wp_enqueue_script('tp-mediaelement',get_template_directory_uri().'/mediaelement/mediaelement-and-player.min.js');
						
		wp_enqueue_style('tp_me', get_template_directory_uri().'/css/mediaelementplayer.css', false);		
		
		wp_enqueue_style('tp_me_page', get_template_directory_uri().'/css/mediaelementplayer-page.css', false);
		
		
		
		//background slider
		wp_register_style('tp_bgs', get_template_directory_uri().'/css/tp_bgslider.css', false);
		wp_enqueue_style('tp_bgs');
		wp_enqueue_script('tp_bgsjs', get_template_directory_uri().'/js/jquery.bgslider.js',array('jquery'));
		
		
		if( is_singular() && comments_open() && get_option( 'thread_comments' ) &&  get_option('tp_ajax_load') == 'off'){
			wp_enqueue_script( 'comment-reply' );
		}
		
		//startup		
		wp_enqueue_script('startup', get_template_directory_uri().'/js/startup.js', array('jquery'));			
		
		//tooltip
		wp_enqueue_script('tipsy', get_template_directory_uri().'/js/jquery.tipsy.js', array('jquery'));
		wp_enqueue_style('tipsy-css',get_template_directory_uri().'/css/tipsy.css');
		
		
		if(get_option('tp_ajax_load') == 'off'){
			wp_enqueue_script('tp-ajax', get_template_directory_uri().'/js/ajaxoff.js', array('jquery'));			
		}else{			
			if(get_option('tp_enable_mp3') == '1'){
				
				wp_enqueue_script('mp3player', get_template_directory_uri().'/js/mp3player.js', false);				
			}
			
			wp_enqueue_script('tp-ajax', get_template_directory_uri().'/js/ajax.js', array('jquery'));			
		}
	
	
		//load stylesheets
		$tp_responsive = get_option('tp_responsive');
		if($tp_responsive == 'off'){		
			wp_enqueue_style('tp-default', get_stylesheet_uri(),array(),null,'all');
			wp_enqueue_style('norespo', get_template_directory_uri().'/css/norespo.css',array(),null,'all');
		}else{
			wp_enqueue_style('tp-default', get_stylesheet_uri(),array(),null,'all and (min-width: 1024px)');
			wp_enqueue_style('tablet',get_template_directory_uri().'/style-tablet-responsive.css',array(),null,'all and (min-width: 733px) and (max-width: 1023px)');
			wp_enqueue_style('mobile',get_template_directory_uri().'/style-mobile-responsive.css',array(),null,'all and (max-width: 732px)');
		}
		
		
		
				//if demo, load styler
				wp_register_style('tp-demo-styler', get_template_directory_uri(). '/css/styler.css',array(),null);
				wp_enqueue_style('tp-demo-styler');
				
				wp_register_script('tp-demo-styler', get_template_directory_uri(). '/js/styler.js',false);
				wp_enqueue_script('tp-demo-styler');
		
		
		//ie-only style sheets
		global $wp_styles;
		wp_register_style('tp-ltie9', get_template_directory_uri(). '/css/ie.css',array(),null);
		$wp_styles->add_data('tp-ltie9', 'conditional', 'lt IE 9');		
		wp_enqueue_style('tp-ltie9');
		
		wp_register_style('tp-ltie9-def', get_template_directory_uri(). '/style.css',array(),null);
		$wp_styles->add_data('tp-ltie9-def', 'conditional', 'lt IE 9');		
		wp_enqueue_style('tp-ltie9-def');
		
		wp_register_style('tp-ltie8', get_template_directory_uri(). '/css/stop_ie.css',array(),null);
		$wp_styles->add_data('tp-ltie8', 'conditional', 'lt IE 8');		
		wp_enqueue_style('tp-ltie8');
		
	
	}
	add_action( 'wp_enqueue_scripts', 'tp_frontend_load' );
	
	
	
//load user style settings in the end of head
	function tp_frontend_last(){
		print '
		<!-- load user style settings -->
		<style type="text/css">';
		
		
		// load all necessary fonts first
			$tp_fontface_font_family = get_option('tp_fontface_font_family');
			$tp_txt_body_font = get_option('tp_txt_body_font');
			$tp_txt_menu_font = get_option('tp_txt_menu_font');
			$tp_txt_link_font = get_option('tp_txt_link_font');			
			$tp_txt_h1_font = get_option('tp_txt_h1_font');
			$tp_txt_h2_font = get_option('tp_txt_h2_font');
			$tp_txt_h3_font = get_option('tp_txt_h3_font');
			$tp_txt_h4_font = get_option('tp_txt_h4_font');
			$tp_txt_h5_font = get_option('tp_txt_h5_font');
			$tp_txt_h6_font = get_option('tp_txt_h6_font');
						
			if($tp_fontface_font_family != ''){ print '
			@import url(http://fonts.googleapis.com/css?family='.$tp_fontface_font_family.');'; }
			if($tp_txt_body_font != ''){ print '
			@import url(http://fonts.googleapis.com/css?family='.$tp_txt_body_font.');'; }
			if($tp_txt_menu_font != ''){ print '
			@import url(http://fonts.googleapis.com/css?family='.$tp_txt_menu_font.');'; }
			if($tp_txt_link_font != ''){ print '
			@import url(http://fonts.googleapis.com/css?family='.$tp_txt_link_font.');'; }			
			if($tp_txt_h1_font != ''){ print '
			@import url(http://fonts.googleapis.com/css?family='.$tp_txt_h1_font.');'; }
			if($tp_txt_h2_font != ''){ print '
			@import url(http://fonts.googleapis.com/css?family='.$tp_txt_h2_font.');'; }
			if($tp_txt_h3_font != ''){ print '
			@import url(http://fonts.googleapis.com/css?family='.$tp_txt_h3_font.');'; }
			if($tp_txt_h4_font != ''){ print '
			@import url(http://fonts.googleapis.com/css?family='.$tp_txt_h4_font.');'; }
			if($tp_txt_h5_font != ''){ print '
			@import url(http://fonts.googleapis.com/css?family='.$tp_txt_h5_font.');'; }
			if($tp_txt_h6_font != ''){ print '
			@import url(http://fonts.googleapis.com/css?family='.$tp_txt_h6_font.');'; }
			
			$tp_typography_custom_fonts = get_option('tp_typography_custom_fonts');
			if($tp_typography_custom_fonts != ''){
				$tp_typography_custom_fonts = maybe_unserialize($tp_typography_custom_fonts);
				if(is_array($tp_typography_custom_fonts)){
				foreach($tp_typography_custom_fonts as $cf){
					print '					
			@import url(http://fonts.googleapis.com/css?family='.$cf.');'; 					
				}
				}
			}
			
			
		// set fonts
			//body
			$tp_txt_body_color = get_option('tp_txt_body_color');	
			$tp_txt_body_size = get_option('tp_txt_body_size');	
			$tp_txt_body_style = get_option('tp_txt_body_style');
			if($tp_txt_body_font != '' || $tp_txt_body_color != '' || $tp_txt_body_size != '' || $tp_txt_body_style != ''){
				print '
				
			body{';
								
				if($tp_fontface_font_family != '' && $tp_txt_body_font == ''){
					print ' font-family: \''.str_replace('+',' ',$tp_fontface_font_family).'\';';				
				}elseif($tp_txt_body_font != ''){
					print ' font-family: \''.str_replace('+',' ',$tp_txt_body_font).'\';';
				}
				
				if($tp_txt_body_color != '' && $tp_txt_body_color != '#'){
					print ' color: '.$tp_txt_body_color.';';
				}
				
				if($tp_txt_body_size != ''){
					print ' font-size: '.$tp_txt_body_size.';';
				}
				
				if($tp_txt_body_style == 'italic'){
					print ' font-style: '.$tp_txt_body_style.';';
				}elseif($tp_txt_body_style == 'bold'){
					print ' font-weight: '.$tp_txt_body_style.';';
				}
				
				print ' }';		
			}
			
			
			
			//link
			$tp_txt_link_color = get_option('tp_txt_link_color');	
			$tp_txt_link_hover_color = get_option('tp_txt_link_hover_color');	
			$tp_txt_link_size = get_option('tp_txt_link_size');	
			$tp_txt_link_style = get_option('tp_txt_link_style');
			if($tp_txt_link_font != '' || $tp_txt_link_color != '' || $tp_txt_link_hover_color != '' || $tp_txt_link_size != '' || $tp_txt_link_style != ''){
				print '
			#page-content a{';
				
				if($tp_txt_link_font != ''){
					print ' font-family: \''.str_replace('+',' ',$tp_txt_link_font).'\';';
				}
				
				if($tp_txt_link_color != '' && $tp_txt_link_color != '#'){
					print ' color: '.$tp_txt_link_color.';';
				}
				
				if($tp_txt_link_size != ''){
					print ' font-size: '.$tp_txt_link_size.';';
				}
				
				if($tp_txt_link_style == 'italic'){
					print ' font-style: '.$tp_txt_link_style.';';
				}elseif($tp_txt_link_style == 'bold'){
					print ' font-weight: '.$tp_txt_link_style.';';
				}
				
				print ' }';		
				
				if($tp_txt_link_hover_color != '' && $tp_txt_link_hover_color != '#'){
					print '
			#page-content a:hover{ color: '.$tp_txt_link_hover_color.'; }';
				}
			}		
			
			
			
			
			//menu
			$tp_txt_menu_color = get_option('tp_txt_menu_color');	$tp_txt_menu_hover_color = get_option('tp_txt_menu_hover_color');	$tp_txt_menu_size = get_option('tp_txt_menu_size');	$tp_txt_menu_style = get_option('tp_txt_menu_style');
			if($tp_txt_menu_font != '' || $tp_txt_menu_color != '' || $tp_txt_menu_hover_color != '' || $tp_txt_menu_size != '' || $tp_txt_menu_style != ''){
				print '
			#sidebar nav ul.menu li a {';
				
				if($tp_txt_menu_font != ''){
					print ' font-family: \''.str_replace('+',' ',$tp_txt_menu_font).'\';';
				}
				
				if($tp_txt_menu_color != '' && $tp_txt_menu_color != '#'){
					print ' color: '.$tp_txt_menu_color.';';
				}
				
				if($tp_txt_menu_size != ''){
					print ' font-size: '.$tp_txt_menu_size.';';
				}
				
				if($tp_txt_menu_style == 'italic'){
					print ' font-style: '.$tp_txt_menu_style.';';
				}elseif($tp_txt_menu_style == 'bold'){
					print ' font-weight: '.$tp_txt_menu_style.';';
				}
				
				print ' }';		
				
				if($tp_txt_menu_hover_color != '' && $tp_txt_menu_hover_color != '#'){
					print '
			#sidebar nav ul.menu li a:hover, header nav ul.menu .sub-menu a:hover, #sidebar .menu .current-menu-item > a{ color: '.$tp_txt_menu_hover_color.'; }';
				}
			}			
			
			

			//h1
			$tp_txt_h1_color = get_option('tp_txt_h1_color');	$tp_txt_h1_size = get_option('tp_txt_h1_size');	$tp_txt_h1_style = get_option('tp_txt_h1_style');
			if($tp_txt_h1_font != '' || $tp_txt_h1_color != '' || $tp_txt_h1_size != '' || $tp_txt_h1_style != ''){
				print '
			h1{';
				
				if($tp_txt_h1_font != ''){
					print '	font-family: \''.str_replace('+',' ',$tp_txt_h1_font).'\';';
				}
				
				if($tp_txt_h1_color != '' && $tp_txt_h1_color != '#'){
					print ' color: '.$tp_txt_h1_color.';';
				}
				
				if($tp_txt_h1_size != ''){
					print ' font-size: '.$tp_txt_h1_size.';';
				}
				
				if($tp_txt_h1_style == 'italic'){
					print ' font-style: '.$tp_txt_h1_style.';';
				}elseif($tp_txt_h1_style == 'bold'){
					print ' font-weight: '.$tp_txt_h1_style.';';
				}
				
				print ' }';		
			}		
			
			
			
			//h2
			$tp_txt_h2_color = get_option('tp_txt_h2_color');	$tp_txt_h2_size = get_option('tp_txt_h2_size');	$tp_txt_h2_style = get_option('tp_txt_h2_style');
			if($tp_txt_h2_font != '' || $tp_txt_h2_color != '' || $tp_txt_h2_size != '' || $tp_txt_h2_style != ''){
				print '
			h2{';
				
				if($tp_txt_h2_font != ''){
					print ' font-family: \''.str_replace('+',' ',$tp_txt_h2_font).'\';';
				}
				
				if($tp_txt_h2_color != '' && $tp_txt_h2_color != '#'){
					print ' color: '.$tp_txt_h2_color.';';
				}
				
				if($tp_txt_h2_size != ''){
					print ' font-size: '.$tp_txt_h2_size.';';
				}
				
				if($tp_txt_h2_style == 'italic'){
					print ' font-style: '.$tp_txt_h2_style.';';
				}elseif($tp_txt_h2_style == 'bold'){
					print ' font-weight: '.$tp_txt_h2_style.';';
				}
				
				print ' }';		
			}		
			
			
			
			//h3
			$tp_txt_h3_color = get_option('tp_txt_h3_color');	$tp_txt_h3_size = get_option('tp_txt_h3_size');	$tp_txt_h3_style = get_option('tp_txt_h3_style');
			if($tp_txt_h3_font != '' || $tp_txt_h3_color != '' || $tp_txt_h3_size != '' || $tp_txt_h3_style != ''){
				print '
			h3{';
				
				if($tp_txt_h3_font != ''){
					print ' font-family: \''.str_replace('+',' ',$tp_txt_h3_font).'\';';
				}
				
				if($tp_txt_h3_color != '' && $tp_txt_h3_color != '#'){
					print ' color: '.$tp_txt_h3_color.';';
				}
				
				if($tp_txt_h3_size != ''){
					print ' font-size: '.$tp_txt_h3_size.';';
				}
				
				if($tp_txt_h3_style == 'italic'){
					print ' font-style: '.$tp_txt_h3_style.';';
				}elseif($tp_txt_h3_style == 'bold'){
					print ' font-weight: '.$tp_txt_h3_style.';';
				}
				
				print ' }';		
			}		
			
			
			
			//h4
			$tp_txt_h4_color = get_option('tp_txt_h4_color');	$tp_txt_h4_size = get_option('tp_txt_h4_size');	$tp_txt_h4_style = get_option('tp_txt_h4_style');
			if($tp_txt_h4_font != '' || $tp_txt_h4_color != '' || $tp_txt_h4_size != '' || $tp_txt_h4_style != ''){
				print '
			h4{';
				
				if($tp_txt_h4_font != ''){
					print '	font-family: \''.str_replace('+',' ',$tp_txt_h4_font).'\';';
				}
				
				if($tp_txt_h4_color != '' && $tp_txt_h4_color != '#'){
					print ' color: '.$tp_txt_h4_color.';';
				}
				
				if($tp_txt_h4_size != ''){
					print ' font-size: '.$tp_txt_h4_size.';';
				}
				
				if($tp_txt_h4_style == 'italic'){
					print ' font-style: '.$tp_txt_h4_style.';';
				}elseif($tp_txt_h4_style == 'bold'){
					print ' font-weight: '.$tp_txt_h4_style.';';
				}
				
				print ' }';		
			}		
			
			
			
			//h5
			$tp_txt_h5_color = get_option('tp_txt_h5_color');	$tp_txt_h5_size = get_option('tp_txt_h5_size');	$tp_txt_h5_style = get_option('tp_txt_h5_style');
			if($tp_txt_h5_font != '' || $tp_txt_h5_color != '' || $tp_txt_h5_size != '' || $tp_txt_h5_style != ''){
				print '
			h5{';
				
				if($tp_txt_h5_font != ''){
					print '	font-family: \''.str_replace('+',' ',$tp_txt_h5_font).'\';';
				}
				
				if($tp_txt_h5_color != '' && $tp_txt_h5_color != '#'){
					print ' color: '.$tp_txt_h5_color.';';
				}
				
				if($tp_txt_h5_size != ''){
					print ' font-size: '.$tp_txt_h5_size.';';
				}
				
				if($tp_txt_h5_style == 'italic'){
					print ' font-style: '.$tp_txt_h5_style.';';
				}elseif($tp_txt_h5_style == 'bold'){
					print ' font-weight: '.$tp_txt_h5_style.';';
				}
				
				print ' }';		
			}		
			
			
			
			//h6
			$tp_txt_h6_color = get_option('tp_txt_h6_color');	$tp_txt_h6_size = get_option('tp_txt_h6_size');	$tp_txt_h6_style = get_option('tp_txt_h6_style');
			if($tp_txt_h6_font != '' || $tp_txt_h6_color != '' || $tp_txt_h6_size != '' || $tp_txt_h6_style != ''){
				print '
			h6{';
				
				if($tp_txt_h6_font != ''){
					print '	font-family: \''.str_replace('+',' ',$tp_txt_h6_font).'\';';
				}
				
				if($tp_txt_h6_color != '' && $tp_txt_h6_color != '#'){
					print ' color: '.$tp_txt_h6_color.';';
				}
				
				if($tp_txt_h6_size != ''){
					print ' font-size: '.$tp_txt_h6_size.';';
				}
				
				if($tp_txt_h6_style == 'italic'){
					print ' font-style: '.$tp_txt_h6_style.';';
				}elseif($tp_txt_h6_style == 'bold'){
					print ' font-weight: '.$tp_txt_h6_style.';';
				}
				
				print ' }';		
			}		
		
		
		// if no advanced setting is set, use selected
			if($tp_fontface_font_family != '' && $tp_txt_body_font == ''){
				print '
			body{ font-family: \''.str_replace('+',' ',$tp_fontface_font_family).'\'; }';
			}
		
		
		print '
		</style>
		';
	}
	add_action('wp_head','tp_frontend_last');
	
/******************************************************************************************/
// register widgetized areas, and load custom ones also!
	function tp_fw_widgets_init() {
	
		// area 1, located in the footer.
		register_sidebar( array(
			'name' => __( 'First Footer Widget Area', 'empire' ),
			'id' => 'first-footer-widget-area',
			'description' => __( 'The first footer widget area', 'empire' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h6 class="widget-title">',
			'after_title' => '</h6>',
		) );

		// area 2, located in the footer. 
		register_sidebar( array(
			'name' => __( 'Second Footer Widget Area', 'empire' ),
			'id' => 'second-footer-widget-area',
			'description' => __( 'The second footer widget area', 'empire' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h6 class="widget-title">',
			'after_title' => '</h6>',
		) );

		// area 3, located in the footer.
		register_sidebar( array(
			'name' => __( 'Third Footer Widget Area', 'empire' ),
			'id' => 'third-footer-widget-area',
			'description' => __( 'The third footer widget area', 'empire' ),
			'before_widget' => '<aside id="%1$s" class="widget %2$s">',
			'after_widget' => '</aside>',
			'before_title' => '<h6 class="widget-title">',
			'after_title' => '</h6>',
		) );

		
		
		
		$ub_custom_widget_areas = maybe_unserialize(get_option('ub_custom_widget_areas'));
		if(!empty($ub_custom_widget_areas)){
		foreach($ub_custom_widget_areas as $ub_c_w_a){
			//register them
					register_sidebar( array(
						'name' => $ub_c_w_a['title'],
						'id' => $ub_c_w_a['id'],
						'description' => __( 'A custom widget area', 'empire' ),
						'before_widget' => '<aside id="%1$s" class="widget %2$s">',
						'after_widget' => '</aside>',
						'before_title' => '<h6 class="widget-title">',
						'after_title' => '</h6>',
					) );
		}
		}
		
	}	
	add_action( 'widgets_init', 'tp_fw_widgets_init' );

/******************************************************************************************/
// remove custom widget area
	if ( is_admin() ) {		
		if(strstr($_SERVER['REQUEST_URI'],'/widgets.php?remove_w_a')){			
			$expurl = explode('widgets.php?remove_w_a=',$_SERVER['REQUEST_URI']);
			$ub_custom_widget_areas = maybe_unserialize(get_option('ub_custom_widget_areas'));	
			$nu_ub_wa_a = Array();
			foreach($ub_custom_widget_areas as $ubw_a){
				if($ubw_a['id'] != end($expurl)){
					$nu_ub_wa_a[] = $ubw_a;
				}
			}
			update_option('ub_custom_widget_areas',maybe_serialize($nu_ub_wa_a));
			header("Location: widgets.php");
		}
	}
	
/******************************************************************************************/	
// removes the default styles that are packaged with the Recent Comments widget
	function tp_fw_remove_recent_comments_style() {
		global $wp_widget_factory;
		remove_action( 'wp_head', array( $wp_widget_factory->widgets['WP_Widget_Recent_Comments'], 'recent_comments_style' ) );
	}
	add_action( 'widgets_init', 'tp_fw_remove_recent_comments_style' );
	
		

/******************************************************************************************/	
// load widgets
	require_once('widgets/recent_posts.php');
	require_once('widgets/popular_posts.php');		
	require_once('widgets/tags.php');			
	require_once('widgets/contact_info.php');	

	


/******************************************************************************************/
// widget area selector/creator	for PAGE only	
	if ( is_admin() ) {		
		require_once(TEMPLATEPATH . "/framework/includes/widget_areas.inc.php");
	}

	



	

	
/******************************************************************************************/		
// posts - enable tags, social sharing, author
	if ( is_admin() ) {
		$new_meta_boxes_post_bottom  = array(
			"sc_gen" => array(
			"name" => "tp_page_title",
			"std" => "",
			"title" => "Post Settings"
			)
		);
		
		function new_meta_boxes_post_bottom() {		
			global $post, $new_meta_boxes_post_bottom;
			
			$tp_post_bottom_social = get_post_meta($post->ID, 'tp_post_bottom_social', true);	
			$tp_post_bottom_social_fb = get_post_meta($post->ID, 'tp_post_bottom_social_fb', true);		
			$tp_post_bottom_social_twitter = get_post_meta($post->ID, 'tp_post_bottom_social_twitter', true);		
			$tp_post_bottom_social_gplus = get_post_meta($post->ID, 'tp_post_bottom_social_gplus', true);		
			$tp_post_bottom_social_linkedin = get_post_meta($post->ID, 'tp_post_bottom_social_linkedin', true);		
			$tp_post_bottom_social_pin = get_post_meta($post->ID, 'tp_post_bottom_social_pin', true);		
			$tp_post_bottom_social_email = get_post_meta($post->ID, 'tp_post_bottom_social_email', true);		
			$tp_post_bottom_social_reddit = get_post_meta($post->ID, 'tp_post_bottom_social_reddit', true);		
			$tp_post_bottom_social_digg = get_post_meta($post->ID, 'tp_post_bottom_social_digg', true);		
			$tp_post_bottom_social_delicious = get_post_meta($post->ID, 'tp_post_bottom_social_delicious', true);		
			
			$tp_post_bottom_social_stumble = get_post_meta($post->ID, 'tp_post_bottom_social_stumble', true);		
			$tp_post_bottom_social_tumblr = get_post_meta($post->ID, 'tp_post_bottom_social_tumblr', true);		
			
			$tp_post_bottom_author = get_post_meta($post->ID, 'tp_post_bottom_author', true);					
			
			$tp_post_bottom_related = get_post_meta($post->ID, 'tp_post_bottom_related', true);
			
			$tp_post_bottom_tags = get_post_meta($post->ID, 'tp_post_bottom_tags', true);
			
			
			
			print '
			<p><strong>'.__('Author','empire').'</strong></p>
			<p><input id="tp_post_bottom_author" name="tp_post_bottom_author" type="checkbox" value="1"'; if($tp_post_bottom_author == '1'){print ' checked="checked"';} print ' /> <label for="tp_post_bottom_author">'.__('Display author below post','empire').'</label></p>
			<div class="vspace"></div>		
			<p><strong>'.__('Related Posts','empire').'</strong></p>
			<p><input id="tp_post_bottom_related" name="tp_post_bottom_related" type="checkbox" value="1"'; if($tp_post_bottom_related == '1'){print ' checked="checked"';} print ' /> <label for="tp_post_bottom_related">'.__('Display related posts below post','empire').'</label></p>
			<div class="vspace"></div>		
			<p><strong>'.__('Social Sharing','empire').'</strong></p>
			<p><input id="tp_post_bottom_social" name="tp_post_bottom_social" type="checkbox" value="1"'; if($tp_post_bottom_social == '1'){print ' checked="checked"';} print ' /> <label for="tp_post_bottom_social">'.__('Display social icons below post','empire').'</label></p>
			<div class="vspace"></div>		
			<p><strong>'.__('Tags','empire').'</strong></p>
			<p><input id="tp_post_bottom_tags" name="tp_post_bottom_tags" type="checkbox" value="1"'; if($tp_post_bottom_tags == '1'){print ' checked="checked"';} print ' /> <label for="tp_post_bottom_tags">'.__('Display tags below post','empire').'</label></p>
			<p>&nbsp;</p>			
			<p class="colcb"><input id="tp_post_bottom_social_fb" name="tp_post_bottom_social_fb" type="checkbox" value="1"'; if($tp_post_bottom_social_fb == '1'){print ' checked="checked"';} print ' /> <label for="tp_post_bottom_social_fb">'.__('Facebook','empire').'</label></p>
			<p class="colcb"><input id="tp_post_bottom_social_twitter" name="tp_post_bottom_social_twitter" type="checkbox" value="1"'; if($tp_post_bottom_social_twitter == '1'){print ' checked="checked"';} print ' /> <label for="tp_post_bottom_social_twitter">'.__('Twitter','empire').'</label></p>
			<p class="colcb"><input id="tp_post_bottom_social_gplus" name="tp_post_bottom_social_gplus" type="checkbox" value="1"'; if($tp_post_bottom_social_gplus == '1'){print ' checked="checked"';} print ' /> <label for="tp_post_bottom_social_gplus">'.__('Google+','empire').'</label></p>
			<p class="colcb"><input id="tp_post_bottom_social_linkedin" name="tp_post_bottom_social_linkedin" type="checkbox" value="1"'; if($tp_post_bottom_social_linkedin == '1'){print ' checked="checked"';} print ' /> <label for="tp_post_bottom_social_linkedin">'.__('LinkedIn','empire').'</label></p>		
			<p class="colcb"><input id="tp_post_bottom_social_pin" name="tp_post_bottom_social_pin" type="checkbox" value="1"'; if($tp_post_bottom_social_pin == '1'){print ' checked="checked"';} print ' /> <label for="tp_post_bottom_social_pin">'.__('Pinterest','empire').'</label></p>		
			<p class="colcb"><input id="tp_post_bottom_social_email" name="tp_post_bottom_social_email" type="checkbox" value="1"'; if($tp_post_bottom_social_email == '1'){print ' checked="checked"';} print ' /> <label for="tp_post_bottom_social_email">'.__('Email','empire').'</label></p>		
			<p class="colcb"><input id="tp_post_bottom_social_reddit" name="tp_post_bottom_social_reddit" type="checkbox" value="1"'; if($tp_post_bottom_social_reddit == '1'){print ' checked="checked"';} print ' /> <label for="tp_post_bottom_social_reddit">'.__('Reddit','empire').'</label></p>		
			<p class="colcb"><input id="tp_post_bottom_social_digg" name="tp_post_bottom_social_digg" type="checkbox" value="1"'; if($tp_post_bottom_social_digg == '1'){print ' checked="checked"';} print ' /> <label for="tp_post_bottom_social_digg">'.__('Digg','empire').'</label></p>		
			<p class="colcb"><input id="tp_post_bottom_social_delicious" name="tp_post_bottom_social_delicious" type="checkbox" value="1"'; if($tp_post_bottom_social_delicious == '1'){print ' checked="checked"';} print ' /> <label for="tp_post_bottom_social_delicious">'.__('Delicious','empire').'</label></p>		
			
			<p class="colcb"><input id="tp_post_bottom_social_stumble" name="tp_post_bottom_social_stumble" type="checkbox" value="1"'; if($tp_post_bottom_social_stumble == '1'){print ' checked="checked"';} print ' /> <label for="tp_post_bottom_social_stumble">'.__('StumbleUpon','empire').'</label></p>		
			<p class="colcb"><input id="tp_post_bottom_social_tumblr" name="tp_post_bottom_social_tumblr" type="checkbox" value="1"'; if($tp_post_bottom_social_tumblr == '1'){print ' checked="checked"';} print ' /> <label for="tp_post_bottom_social_tumblr">'.__('Tumblr','empire').'</label></p>		
			<div class="vspace"></div>	
			';
			
		}
		
		function create_meta_box_post_bottom() {
			global $theme_name;
			if ( function_exists('add_meta_box') ) {
				add_meta_box( 'new-meta-boxes-post_bottom', 'Post Settings', 'new_meta_boxes_post_bottom', 'post', 'side', 'default' );		
			}
		}
		add_action('admin_menu', 'create_meta_box_post_bottom');

		//save meta box values 
			function save_postdata_post_bottom(){		
				global $post, $new_meta_boxes_post_bottom;
				
				if(empty($_GET['post_type'])){					
					if(!empty($_POST['tp_post_bottom_social'])){ update_post_meta($post->ID,'tp_post_bottom_social',$_POST['tp_post_bottom_social']);  }elseif(is_object($post)){ delete_post_meta($post->ID,'tp_post_bottom_social'); }
					
					if(!empty($_POST['tp_post_bottom_social_fb'])){ update_post_meta($post->ID,'tp_post_bottom_social_fb',$_POST['tp_post_bottom_social_fb']);  }elseif(is_object($post)){ delete_post_meta($post->ID,'tp_post_bottom_social_fb'); }
					if(!empty($_POST['tp_post_bottom_social_twitter'])){ update_post_meta($post->ID,'tp_post_bottom_social_twitter',$_POST['tp_post_bottom_social_twitter']);  }elseif(is_object($post)){ delete_post_meta($post->ID,'tp_post_bottom_social_twitter'); }
					if(!empty($_POST['tp_post_bottom_social_gplus'])){ update_post_meta($post->ID,'tp_post_bottom_social_gplus',$_POST['tp_post_bottom_social_gplus']);  }elseif(is_object($post)){ delete_post_meta($post->ID,'tp_post_bottom_social_gplus'); }
					if(!empty($_POST['tp_post_bottom_social_linkedin'])){ update_post_meta($post->ID,'tp_post_bottom_social_linkedin',$_POST['tp_post_bottom_social_linkedin']);  }elseif(is_object($post)){ delete_post_meta($post->ID,'tp_post_bottom_social_linkedin'); }
					if(!empty($_POST['tp_post_bottom_social_pin'])){ update_post_meta($post->ID,'tp_post_bottom_social_pin',$_POST['tp_post_bottom_social_pin']);  }elseif(is_object($post)){ delete_post_meta($post->ID,'tp_post_bottom_social_pin'); }
					if(!empty($_POST['tp_post_bottom_social_email'])){ update_post_meta($post->ID,'tp_post_bottom_social_email',$_POST['tp_post_bottom_social_email']);  }elseif(is_object($post)){ delete_post_meta($post->ID,'tp_post_bottom_social_email'); }
					if(!empty($_POST['tp_post_bottom_social_reddit'])){ update_post_meta($post->ID,'tp_post_bottom_social_reddit',$_POST['tp_post_bottom_social_reddit']);  }elseif(is_object($post)){ delete_post_meta($post->ID,'tp_post_bottom_social_reddit'); }
					if(!empty($_POST['tp_post_bottom_social_digg'])){ update_post_meta($post->ID,'tp_post_bottom_social_digg',$_POST['tp_post_bottom_social_digg']);  }elseif(is_object($post)){ delete_post_meta($post->ID,'tp_post_bottom_social_digg'); }
					if(!empty($_POST['tp_post_bottom_social_delicious'])){ update_post_meta($post->ID,'tp_post_bottom_social_delicious',$_POST['tp_post_bottom_social_delicious']);  }elseif(is_object($post)){ delete_post_meta($post->ID,'tp_post_bottom_social_delicious'); }
					
					if(!empty($_POST['tp_post_bottom_social_stumble'])){ update_post_meta($post->ID,'tp_post_bottom_social_stumble',$_POST['tp_post_bottom_social_stumble']);  }elseif(is_object($post)){ delete_post_meta($post->ID,'tp_post_bottom_social_stumble'); }
					if(!empty($_POST['tp_post_bottom_social_tumblr'])){ update_post_meta($post->ID,'tp_post_bottom_social_tumblr',$_POST['tp_post_bottom_social_tumblr']);  }elseif(is_object($post)){ delete_post_meta($post->ID,'tp_post_bottom_social_tumblr'); }
					
					if(!empty($_POST['tp_post_bottom_author'])){ update_post_meta($post->ID,'tp_post_bottom_author',$_POST['tp_post_bottom_author']);  }elseif(is_object($post)){ delete_post_meta($post->ID,'tp_post_bottom_author'); }

					if(!empty($_POST['tp_post_bottom_related'])){ update_post_meta($post->ID,'tp_post_bottom_related',$_POST['tp_post_bottom_related']);  }elseif(is_object($post)){ delete_post_meta($post->ID,'tp_post_bottom_related'); }
					
					if(!empty($_POST['tp_post_bottom_tags'])){ update_post_meta($post->ID,'tp_post_bottom_tags',$_POST['tp_post_bottom_tags']);  }elseif(is_object($post)){ delete_post_meta($post->ID,'tp_post_bottom_tags'); }
					
				}	
				
			}
			add_action('save_post', 'save_postdata_post_bottom');
	}	
	


	
	
/******************************************************************************************/	
// BLOG TEMPLATE - CATEGORY SELECTOR
	if ( is_admin() ) {		
		$new_meta_boxes_blogcats  = array(
			"sc_gen" => array(
			"name" => "tp_blog_cats",
			"std" => "",
			"title" => "Post Categories"
			)
		);

		function new_meta_boxes_blogcats() {
			global $post, $new_meta_boxes_pfcats;
			
			$tp_blog_cats = get_post_meta($post->ID, 'tp_blog_cats', true);		
			$tax_terms = get_terms('category');
			
			
			echo'<p>If you will use this page to display posts, select which categories you\'d like to display:</p>
				<p>
				<select name="tp_blog_cats[]" id="tp_blog_cats" multiple="multiple" style="height: 120px; width: 100%; float: left;">';
				if($tp_blog_cats == '' || empty($tp_blog_cats) || $tp_blog_cats[0] == ''){
					echo '<option value="" selected="selected">All categories</option>';
					
					if($tax_terms != ''){						
						foreach ($tax_terms as $tax_term) {
							if($tax_term->parent == '0'){
								echo '
								<option value="'. $tax_term->slug .'">' . $tax_term->name . '</option>
								';
							}
						}	
					}			
					
				}else{
					echo '<option value="">All categories</option>';
					
					
					if($tax_terms != ''){				
						foreach ($tax_terms as $tax_term) {
							$selected = '';
							foreach($tp_blog_cats as $pf_cat){
								if($pf_cat == $tax_term->slug){
									$selected = ' selected="selected"';
								}
							}
							
							if($tax_term->parent == '0'){
								echo '
								<option value="'. $tax_term->slug .'"'.$selected.'>' . $tax_term->name . '</option>
								';
							}
						}	
					}
				}
					
				
			echo '		
				</select>
				</p>
			';	
		}

		function create_meta_box_blogcats() {
			global $theme_name;
			if ( function_exists('add_meta_box') ) {
				add_meta_box( 'new-meta-boxes-blogcats', 'Post Categories', 'new_meta_boxes_blogcats', 'page', 'side', 'default' );		
			}
		}
		add_action('admin_menu', 'create_meta_box_blogcats');
		
		//save meta box values 
			function save_postdata_blogcats(){		
				global $post, $tp_blog_cats;
							
				//save blog cats
				if(!empty($_POST['tp_blog_cats'])){
					update_post_meta($post->ID,'tp_blog_cats',$_POST['tp_blog_cats']);
				}
			}
			add_action('save_post', 'save_postdata_blogcats');
		
	}	
	
	
/******************************************************************************************/	
// PAGE / POST BACKGROUND IMAGE
	if ( is_admin() ) {		
		$new_meta_boxes_tp_bgimg  = array(
			"sc_gen" => array(
			"name" => "tp_pagepost_bg",
			"std" => "",
			"title" => "Content Page Background"
			)
		);

		function new_meta_boxes_tp_bgimg() {
			global $post, $new_meta_boxes_tp_bgimg;
			
			$tp_bgimg_top = get_post_meta($post->ID, 'tp_bgimg_top', true);		
			$tp_bgimg_left = get_post_meta($post->ID, 'tp_bgimg_left', true);		
			$tp_bgimg_src = get_post_meta($post->ID, 'tp_bgimg_src', true);		
			
			print '<p class="btnlink">';
			if(!empty($tp_bgimg_src)){
				print '<img width="258" alt="heading" src="'.$tp_bgimg_src.'" />
				<a href="#" id="set-bg-image" class="hidden">'.__('Click here to select your image','empire').'</a>
				<a href="#" id="remove-bg-image">'.__('Click here to remove your image','empire').'</a>';
			}else{
				print '<a href="#" id="set-bg-image">'.__('Click here to select your image','empire').'</a>
				<a href="#" id="remove-bg-image" class="hidden">'.__('Click here to remove your image','empire').'</a>';
			}
			print '
			<input type="hidden" name="tp_bgimg_src" id="tp_pagepost_bg_image" value="'.$tp_bgimg_src.'" /></p>
			<p class="description">'.__('Transparent PNG or JPG format','empire').'</p>
			<p>'.__('Top padding','empire').': <input type="text" name="tp_bgimg_top" class="small-text" value="'.$tp_bgimg_top.'" /> px</p>
			<p>'.__('Left padding','empire').': <input type="text" name="tp_bgimg_left" class="small-text" value="'.$tp_bgimg_left.'" /> px</p>			
			';
			
		}

		function tp_create_meta_box_bgimg() {
			global $theme_name;
			if ( function_exists('add_meta_box') ) {
				add_meta_box( 'new-meta-boxes-pagepostbg', 'Content Page Background', 'new_meta_boxes_tp_bgimg', 'page', 'side', 'default' );		
				add_meta_box( 'new-meta-boxes-pagepostbg', 'Content Page Background', 'new_meta_boxes_tp_bgimg', 'post', 'side', 'default' );		
			}
		}
		add_action('admin_menu', 'tp_create_meta_box_bgimg');
		
		//save meta box values 
			function tp_save_postdata_bgimg(){		
				global $post;
					
				//save
				if(!empty($post)){
					if(!empty($_POST['tp_bgimg_top'])){
						update_post_meta($post->ID,'tp_bgimg_top',$_POST['tp_bgimg_top']);
					}else{
						delete_post_meta($post->ID,'tp_bgimg_top');
					}
					
					if(!empty($_POST['tp_bgimg_left'])){
						update_post_meta($post->ID,'tp_bgimg_left',$_POST['tp_bgimg_left']);
					}else{
						delete_post_meta($post->ID,'tp_bgimg_left');
					}
					
					if(!empty($_POST['tp_bgimg_src'])){
						update_post_meta($post->ID,'tp_bgimg_src',$_POST['tp_bgimg_src']);
					}else{
						delete_post_meta($post->ID,'tp_bgimg_src');
					}
				}
			}
			add_action('save_post', 'tp_save_postdata_bgimg');
		
	}	
	



/******************************************************************************************/	
// PORTFOLIO METABOX

	if ( is_admin() ) {		
		$new_meta_boxes_tp_portfolio  = array(
			"sc_gen" => array(
			"name" => "tp_portfolio_page",
			"std" => "",
			"title" => "Portfolio Settings"
			)
		);

		function new_meta_boxes_tp_portfolio() {
			global $post, $new_meta_boxes_tp_portfolio;
			
			$tp_pf_settings_categories = get_post_meta($post->ID, 'tp_pf_settings_categories', true);		
			$tp_pf_settings_title = get_post_meta($post->ID, 'tp_pf_settings_title', true);		
			$tp_pf_settings_excerpt = get_post_meta($post->ID, 'tp_pf_settings_excerpt', true);		
			$tp_pf_settings_align = get_post_meta($post->ID, 'tp_pf_settings_align', true);		
			$tp_pf_settings_cols = get_post_meta($post->ID, 'tp_pf_settings_cols', true);		
			
			
			print '<p><input id="tp_pf_settings_categories" name="tp_pf_settings_categories" type="checkbox" value="1"'; if($tp_pf_settings_categories == '1'){print ' checked="checked"';} print ' /> <label for="tp_pf_settings_categories">'.__('Show category selector','empire').'</label></p>
			<p><input id="tp_pf_settings_title" name="tp_pf_settings_title" type="checkbox" value="1"'; if($tp_pf_settings_title == '1'){print ' checked="checked"';} print ' /> <label for="tp_pf_settings_title">'.__('Show title','empire').'</label></p>
			<p><input id="tp_pf_settings_excerpt" name="tp_pf_settings_excerpt" type="checkbox" value="1"'; if($tp_pf_settings_excerpt == '1'){print ' checked="checked"';} print ' /> <label for="tp_pf_settings_excerpt">'.__('Show excerpt','empire').'</label></p>
			<p><label>Text alignment</label>&nbsp;&nbsp;&nbsp;<select name="tp_pf_settings_align">
				<option value="">Left</option>
				<option value="center"'; if($tp_pf_settings_align == 'center'){ print ' selected="selected"'; } print '>Center</option>
				<option value="right"'; if($tp_pf_settings_align == 'right'){ print ' selected="selected"'; } print '>Right</option>
			</select></p>
			<p><label>Columns</label>&nbsp;&nbsp;&nbsp;<select name="tp_pf_settings_cols">				
				<option value="2"'; if($tp_pf_settings_cols == '2'){ print ' selected="selected"'; } print '>2</option>
				<option value=""'; if(empty($tp_pf_settings_cols)){ print ' selected="selected"'; } print '>3</option>				
				<option value="4"'; if($tp_pf_settings_cols == '4'){ print ' selected="selected"'; } print '>4</option>
			</select></p>
			';
			
		}

		function tp_create_meta_box_portfolio() {
			global $theme_name;
			if ( function_exists('add_meta_box') ) {
				add_meta_box( 'new-meta-boxes-tp-portfolio', 'Portfolio Settings', 'new_meta_boxes_tp_portfolio', 'page', 'side', 'default' );						
			}
		}
		add_action('admin_menu', 'tp_create_meta_box_portfolio');
		
		//save meta box values 
			function tp_save_postdata_portfolio(){		
				global $post;
					
				//save
				
				if(!empty($post)){
					if(!empty($_POST['tp_pf_settings_categories'])){
						update_post_meta($post->ID,'tp_pf_settings_categories',$_POST['tp_pf_settings_categories']);
					}else{
						delete_post_meta($post->ID,'tp_pf_settings_categories');
					}					
					
					if(!empty($_POST['tp_pf_settings_title'])){
						update_post_meta($post->ID,'tp_pf_settings_title',$_POST['tp_pf_settings_title']);
					}else{
						delete_post_meta($post->ID,'tp_pf_settings_title');
					}					
					
					if(!empty($_POST['tp_pf_settings_excerpt'])){
						update_post_meta($post->ID,'tp_pf_settings_excerpt',$_POST['tp_pf_settings_excerpt']);
					}else{
						delete_post_meta($post->ID,'tp_pf_settings_excerpt');
					}			
					
					if(!empty($_POST['tp_pf_settings_align'])){
						update_post_meta($post->ID,'tp_pf_settings_align',$_POST['tp_pf_settings_align']);
					}else{
						delete_post_meta($post->ID,'tp_pf_settings_align');
					}	
					
					if(!empty($_POST['tp_pf_settings_cols'])){
						update_post_meta($post->ID,'tp_pf_settings_cols',$_POST['tp_pf_settings_cols']);
					}else{
						delete_post_meta($post->ID,'tp_pf_settings_cols');
					}					
				}
			}
			add_action('save_post', 'tp_save_postdata_portfolio');
		
	}	



	
/******************************************************************************************/	
// 	post format excerpt contents

		
	if ( is_admin() ) {				
		
			$new_meta_boxes_postf  = array(
				"sc_gen" => array(
				"name" => "tp_postf",
				"std" => "",
				"title" => "Post Format Content"
				)
			);

			function new_meta_boxes_postf() {
				global $post, $new_meta_boxes_postf;
				
				$tp_postf_link = get_post_meta($post->ID, 'tp_postf_link', true);		
				$tp_postf_audio = get_post_meta($post->ID, 'tp_postf_audio', true);		
				$tp_postf_video = get_post_meta($post->ID, 'tp_postf_video', true);		
				
				
				echo'
				<div id="postf-link" class="postf-contents">
					<p><strong>Link URL:</strong></p>
					<p><input type="text" class="widefat" name="tp_postf_link" value="'.$tp_postf_link.'" /></p>			
				</div>
				<div id="postf-audio" class="postf-contents">
					<p><strong>Audio</strong> - Link to MP3 File or Audio Player Embed Code (e.g.: SoundCloud):</p>
					<p><textarea class="widefat" name="tp_postf_audio" rows="2">'.$tp_postf_audio.'</textarea></p>			
				</div>
				<div id="postf-video" class="postf-contents">
					<p><strong>Video Embed Code:</strong></p>
					<p><textarea class="widefat" name="tp_postf_video" rows="2">'.$tp_postf_video.'</textarea></p>			
				</div>
				';	
			}

			function create_meta_boxes_postf() {
				global $theme_name;
				if ( function_exists('add_meta_box') ) {
					add_meta_box( 'new-meta-boxes-postf', 'Post Format Content', 'new_meta_boxes_postf', 'post', 'normal', 'high' );		
				}
			}
			add_action('admin_menu', 'create_meta_boxes_postf');
			
			//save meta box values 
				function save_postdata_postf(){		
					global $post;
								
					//save blog cats
					if(!empty($_POST['tp_postf_link'])){
						update_post_meta($post->ID,'tp_postf_link',$_POST['tp_postf_link']);
					}
					if(!empty($_POST['tp_postf_audio'])){
						update_post_meta($post->ID,'tp_postf_audio',$_POST['tp_postf_audio']);
					}
					if(!empty($_POST['tp_postf_video'])){
						update_post_meta($post->ID,'tp_postf_video',$_POST['tp_postf_video']);
					}
				}
				add_action('save_post', 'save_postdata_postf');	
		
	}	
	
	
/******************************************************************************************/
// comment functions
	function validate_gravatar($email) {
		// Craft a potential url and test its headers
		$hash = md5(strtolower(trim($email)));
		$uri = 'http://www.gravatar.com/avatar/' . $hash . '?d=404';
		$headers = @get_headers($uri);
		if (!preg_match("|200|", $headers[0])) {
			$has_valid_avatar = FALSE;
		} else {
			$has_valid_avatar = TRUE;
		}
		return $has_valid_avatar;
	}

	function tp_comments( $comment, $args, $depth ){		
		print '
		<li>';
		
		if(!validate_gravatar(get_comment_author_email())){
			//replace to theme avatar
			print '<img class="avatar avatar-60 photo" width="60" height="60" src="'.get_template_directory_uri().'/images/avatar.jpg" alt="">';
			
		}else{
			//default
			print get_avatar($comment,'60');
		}
		
		print '
			<div class="holder">
				<p class="comment-author">'.get_comment_author().'<br /></p>		
				<p class="comment-info">';
					printf( __( '%1$s., %2$s','empire'), get_comment_date(),  get_comment_time() ); 
					edit_comment_link( __( '(Edit)' ,'empire'), ' ' );					
					print '&nbsp;&nbsp;&#8226;&nbsp;&nbsp;';
					
					comment_reply_link( 
						array_merge( $args, array( 
							'depth' => $depth, 
							'max_depth' => $args['max_depth'], 
							'reply_text' => __('Reply','empire')
						) ) );
				print '</p>		
				<p class="comment">'.get_comment_text().'</p>
			</div>';
					
	}
	
	
	
/******************************************************************************************/	
// captcha random char generator
	function generateCode($characters='4') {
		  // list all possible characters, similar looking characters and vowels have been removed 
		  $possible = '987654321ZYXWVTSRQPNMLKJHGFDCB';
		  $code = '';
		  $i = 0;
		  while ($i < $characters) { 
			 $code .= substr($possible, mt_rand(0, strlen($possible)-1), 1);
			 $i++;
		  }
		  return $code;
	}

	
	

/******************************************************************************************/	
// get current url	
	function curPageURL() {
		 $pageURL = 'http';
		 if (!empty($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
		 $pageURL .= "://";
		 if ($_SERVER["SERVER_PORT"] != "80") {
		  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["REQUEST_URI"];
		 } else {
		  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
		 }
		 return $pageURL;
	}
	
	
/******************************************************************************************/	
// retina images	

	

		function tp_retina_support_create_images( $file, $width, $height, $crop = false ) {
			if ( $width || $height ) {
				$resized_file = wp_get_image_editor( $file );
				if ( ! is_wp_error( $resized_file ) ) {
					$filename = $resized_file->generate_filename( $width . 'x' . $height . '@2x' );
		 
					$resized_file->resize( $width * 2, $height * 2, $crop );
					$resized_file->save( $filename );
		 
					$info = $resized_file->get_size();
		 
					return array(
						'file' => wp_basename( $filename ),
						'width' => $info['width'],
						'height' => $info['height'],
					);
				}
			}
			return false;
		}

		function tp_delete_retina_support_images( $attachment_id ) {
			$meta = wp_get_attachment_metadata( $attachment_id );
			$upload_dir = wp_upload_dir();			
			if(isset( $meta['file'] )){
				$path = pathinfo( $meta['file'] );
			}
			if(is_array($meta) && isset($path)){
			foreach ( $meta as $key => $value ) {
				if ( 'sizes' === $key ) {
					foreach ( $value as $sizes => $size ) {
						$original_filename = $upload_dir['basedir'] . '/' . $path['dirname'] . '/' . $size['file'];
						$retina_filename = substr_replace( $original_filename, '@2x.', strrpos( $original_filename, '.' ), strlen( '.' ) );
						if ( file_exists( $retina_filename ) )
							unlink( $retina_filename );
					}
				}
			}
			}
		}
		

		function tp_retina_support_attachment_meta( $metadata, $attachment_id ) {
			foreach ( $metadata as $key => $value ) {
				if ( is_array( $value ) ) {
					foreach ( $value as $image => $attr ) {
						if ( is_array( $attr ) )
							tp_retina_support_create_images( get_attached_file( $attachment_id ), $attr['width'], $attr['height'], true );
					}
				}
			}
		 
			return $metadata;
		}	
		
		
	if(get_option('tp_retina') != 'off'){	
		add_filter( 'delete_attachment', 'tp_delete_retina_support_images' );
		add_filter( 'wp_generate_attachment_metadata', 'tp_retina_support_attachment_meta', 10, 2 );
	}
		
	
	
/******************************************************************************************/		
// background slider - function to echo the slider
	function tpBgSlider(){
		global $post;
		global $wpdb;
		
		print '					
		<!-- BACKGROUND SLIDER -->
		<div id="tp-bgslider">';								
			if(!is_single() && !is_front_page() && !empty($post)){					
			//page					
				$slides = $wpdb->get_row("SELECT * FROM tp_bgslider WHERE appears_pages LIKE '%;".$post->ID."%' OR appears_pages LIKE '%".$post->ID.";%' OR appears_pages='".$post->ID."' LIMIT 1", ARRAY_A);
				if($slides == null){
					$slides = $wpdb->get_row("SELECT * FROM tp_bgslider WHERE appears_pages LIKE '%all%' LIMIT 1", ARRAY_A);
				}
				
				if($slides != null){
					$slides_arr = explode(';',$slides['images']);
					if(!empty($slides_arr)){							
						foreach($slides_arr as $slide){				
							$sext = end(explode('.', $slide));			
							if($sext == 'mp4'){
								print '<video class="video_bg" preload="auto" loop="loop" muted="muted" volume="0"><source src="'.$slide.'" type="video/mp4"></video>';
							}elseif($sext == 'jpg' || $sext == 'jpeg' || $sext == 'png'){
								print '<img src="'.$slide.'" alt="slider image" />';								
							}
							
						}
					}
				}
			}elseif(!empty($post) && (is_single($post->ID) || is_single())){					
			//post
				
				$slides = $wpdb->get_row("SELECT * FROM tp_bgslider WHERE appears_posts LIKE '%;".$post->ID."%' OR appears_posts LIKE '%".$post->ID.";%' OR appears_posts='".$post->ID."' LIMIT 1", ARRAY_A);
				
				
				if($slides == null){
					$slides = $wpdb->get_row("SELECT * FROM tp_bgslider WHERE appears_posts LIKE '%all%' LIMIT 1", ARRAY_A);
				}
				
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
			}elseif(is_front_page()){
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
			}
			
			
			print '	
		</div>';
		if(!empty($slides)){
			print '
			<script type="text/javascript">	
				/* START BG SLIDER */
				//slider is hidden
				jQuery("#tp-bgslider").css("display","none");
				jQuery(window).load(function() {		
					if(jQuery("#tp-bgslider").length != 0){							
						//fade in slider
						jQuery("#tp-bgslider").fadeIn(700);
						jQuery("#tp-bgslider").bgSlider(false,'.$slides['fade'].','.$slides['pause'].');						
					}
				});
			</script>
			';
		}
	}

		
	
	
	
/******************************************************************************************/
// theme option pages
	if ( is_admin() ) {		
		// add pages to admin
		function ub_add_pages() {
			global $framework_url;		
						
			add_menu_page('Theme Options', 'Theme Options', 'manage_options', 'tp_theme_general', 'tp_theme_general', $framework_url.'icon.png' );	
				add_submenu_page('tp_theme_general', 'General', 'General', 'manage_options', 'tp_theme_general', 'tp_theme_general');				
				add_submenu_page('tp_theme_general', 'Background Slider', 'Background Slider', 'manage_options', 'tp_bgslider_admin', 'tp_bgslider_admin');				
				add_submenu_page('tp_theme_general', 'Layout & Animation', 'Layout & Animation', 'manage_options', 'tp_theme_sidebar', 'tp_theme_sidebar');								
				add_submenu_page('tp_theme_general', 'Typography', 'Typography', 'manage_options', 'tp_theme_typography', 'tp_theme_typography');						
				add_submenu_page('tp_theme_general', 'Mp3 Player', 'Mp3 Player', 'manage_options', 'tp_theme_mp3', 'tp_theme_mp3');
				add_submenu_page('tp_theme_general', 'Footer Widget Areas', 'Footer Widget Areas', 'manage_options', 'tp_theme_sidebar_footer', 'tp_theme_sidebar_footer');				
				add_submenu_page('tp_theme_general', 'Sample Content', 'Sample Content', 'manage_options', 'tp_theme_sample_content', 'tp_theme_sample_content');				
				
		}
		add_action('admin_menu', 'ub_add_pages');

		require_once(TEMPLATEPATH . "/framework/includes/theme_options-general.inc.php");				
		require_once(TEMPLATEPATH . "/framework/includes/theme_options-bgslider.inc.php");				
		require_once(TEMPLATEPATH . "/framework/includes/theme_options-sidebar.inc.php");
		require_once(TEMPLATEPATH . "/framework/includes/theme_options-widget_areas.inc.php");
		require_once(TEMPLATEPATH . "/framework/includes/theme_options-typography.inc.php");
		require_once(TEMPLATEPATH . "/framework/includes/theme_options-mp3.inc.php");
		require_once(TEMPLATEPATH . "/framework/includes/theme_options-sample_content.inc.php");
	}
	

/******************************************************************************************/
// request to install plugins / add plugin install page
	if ( is_admin() ) {
		require_once('includes/plugin-activation.php');

		add_action('tgmpa_register', 'tp_reg_plugins');
		function tp_reg_plugins() {
			global $theme_text_domain;
			
			$plugins = array(
				array(
					'name'     				=> 'Slider Revolution', // The plugin name
					'slug'     				=> 'revslider', // The plugin slug (typically the folder name)
					'source'   				=> get_template_directory_uri() . '/framework/plugins/revslider.zip', // The plugin source
					'required' 				=> true, // If false, the plugin is only 'recommended' instead of required
					'version' 				=> '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
					'force_activation' 		=> true, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
					'force_deactivation' 	=> true, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
					'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
				),
				array(
					'name'     				=> 'Contact Form 7', // The plugin name
					'slug'     				=> 'contact-form-7', // The plugin slug (typically the folder name)
					'source'   				=> get_template_directory_uri() . '/framework/plugins/contact-form-7.zip', // The plugin source
					'required' 				=> false, // If false, the plugin is only 'recommended' instead of required
					'version' 				=> '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
					'force_activation' 		=> false, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
					'force_deactivation' 	=> true, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
					'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
				),
				array(
					'name'     				=> 'ThemePrince Shortcodes', // The plugin name
					'slug'     				=> 'tp-shortcodes', // The plugin slug (typically the folder name)
					'source'   				=> get_template_directory_uri() . '/framework/plugins/tp-shortcodes.zip', // The plugin source
					'required' 				=> true, // If false, the plugin is only 'recommended' instead of required
					'version' 				=> '', // E.g. 1.0.0. If set, the active plugin must be this version or higher, otherwise a notice is presented
					'force_activation' 		=> true, // If true, plugin is activated upon theme activation and cannot be deactivated until theme switch
					'force_deactivation' 	=> true, // If true, plugin is deactivated upon theme switch, useful for theme-specific plugins
					'external_url' 			=> '', // If set, overrides default API URL and points to an external URL
				)
			);
			
			$config = array(
				'domain'       		=> 'empire',         	// Text domain - likely want to be the same as your theme.
				'default_path' 		=> '',                         	// Default absolute path to pre-packaged plugins
				'parent_menu_slug' 	=> 'themes.php', 				// Default parent menu slug
				'parent_url_slug' 	=> 'themes.php', 				// Default parent URL slug
				'menu'         		=> 'install-required-plugins', 	// Menu slug
				'has_notices'      	=> true,                       	// Show admin notices or not
				'is_automatic'    	=> true,					   	// Automatically activate plugins after installation or not
				'message' 			=> '',							// Message to output right before the plugins table
				'strings'      		=> array(
					'page_title'                       			=> __( 'Install Required Plugins', 'empire' ),
					'menu_title'                       			=> __( 'Install Plugins', 'empire' ),
					'installing'                       			=> __( 'Installing Plugin: %s', 'empire' ), // %1$s = plugin name
					'oops'                             			=> __( 'Something went wrong with the plugin API.', 'empire' ),
					'notice_can_install_required'     			=> _n_noop( 'This theme requires the following plugin: %1$s.', 'This theme requires the following plugins: %1$s.' ), // %1$s = plugin name(s)
					'notice_can_install_recommended'			=> _n_noop( 'This theme recommends the following plugin: %1$s.', 'This theme recommends the following plugins: %1$s.' ), // %1$s = plugin name(s)
					'notice_cannot_install'  					=> _n_noop( 'Sorry, but you do not have the correct permissions to install the %s plugin. Contact the administrator of this site for help on getting the plugin installed.', 'Sorry, but you do not have the correct permissions to install the %s plugins. Contact the administrator of this site for help on getting the plugins installed.' ), // %1$s = plugin name(s)
					'notice_can_activate_required'    			=> _n_noop( 'The following required plugin is currently inactive: %1$s.', 'The following required plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)
					'notice_can_activate_recommended'			=> _n_noop( 'The following recommended plugin is currently inactive: %1$s.', 'The following recommended plugins are currently inactive: %1$s.' ), // %1$s = plugin name(s)
					'notice_cannot_activate' 					=> _n_noop( 'Sorry, but you do not have the correct permissions to activate the %s plugin. Contact the administrator of this site for help on getting the plugin activated.', 'Sorry, but you do not have the correct permissions to activate the %s plugins. Contact the administrator of this site for help on getting the plugins activated.' ), // %1$s = plugin name(s)
					'notice_ask_to_update' 						=> _n_noop( 'The following plugin needs to be updated to its latest version to ensure maximum compatibility with this theme: %1$s.', 'The following plugins need to be updated to their latest version to ensure maximum compatibility with this theme: %1$s.' ), // %1$s = plugin name(s)
					'notice_cannot_update' 						=> _n_noop( 'Sorry, but you do not have the correct permissions to update the %s plugin. Contact the administrator of this site for help on getting the plugin updated.', 'Sorry, but you do not have the correct permissions to update the %s plugins. Contact the administrator of this site for help on getting the plugins updated.' ), // %1$s = plugin name(s)
					'install_link' 					  			=> _n_noop( 'Begin installing plugin', 'Begin installing plugins' ),
					'activate_link' 				  			=> _n_noop( 'Activate installed plugin', 'Activate installed plugins' ),
					'return'                           			=> __( 'Return to Required Plugins Installer', 'empire' ),
					'plugin_activated'                 			=> __( 'Plugin activated successfully.', 'empire' ),
					'complete' 									=> __( 'All plugins installed and activated successfully. %s', 'empire' ), // %1$s = dashboard link
					'nag_type'									=> 'updated' // Determines admin notice type - can only be 'updated' or 'error'
				)
			);
		
			tgmpa($plugins, $config);
		
		}
	}
	
	
	
?>