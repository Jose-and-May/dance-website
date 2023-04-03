<?php
	
	$postclass = get_post_class();
	$postclass[] = 'single-post';
	
	//content background
		$tp_bgimg_src = get_post_meta(get_the_ID(), 'tp_bgimg_src', true);		
		$tp_bgimg_top = get_post_meta(get_the_ID(), 'tp_bgimg_top', true);		
		$tp_bgimg_left = get_post_meta(get_the_ID(), 'tp_bgimg_left', true);		
	
		$cntstyle = '';
		if(!empty($tp_bgimg_src)){
			$cntstyle = ' style="background-image:url('.$tp_bgimg_src.');';
			if(!empty($tp_bgimg_left)){ $bgp_l = $tp_bgimg_left.'px'; }else{ $bgp_l = '0px'; }
			if(!empty($tp_bgimg_top)){ $bgp_t = $tp_bgimg_top.'px'; }else{ $bgp_t = '0px'; }
			$cntstyle .= ' background-position: '.$bgp_l.' '.$bgp_t.'"';
		}
		
			print '	
				<section id="content"'.$cntstyle.'>
					<article id="post-'.get_the_ID().'" class="'.implode(' ',$postclass).'">';
							
					if (have_posts()) :
						while ( have_posts() ) : the_post();
							$postid = get_the_ID();
						
							print '<div class="hidden" id="page-title" data-id="'.get_the_ID().'">'.get_the_title().'</div>							
							<div class="hidden" id="page-bgslider-images">';
							
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
							
							print '</div>
							<div class="hidden" id="page-bgslider-datas" data-pause="'.$slides['pause'].'" data-fade="'.$slides['fade'].'"></div>';
							
							
							//title
								if(get_post_format() == 'link'){
									print '<h1><a href="'.get_post_meta($post->ID,'tp_postf_link',true).'" target="_blank" title="'; the_title_attribute(); print '">'.get_the_title().'</a></h1>';
								}else{
									print '<h1>'.get_the_title().'</h1>';									
								}
								$curtitle = get_the_title();
							
							
							//info line
								print '<div class="info">
									<img src="'.get_bloginfo('template_url').'/images/blog-date.png" alt="post date" />'.get_the_date().'&nbsp;&nbsp;&#8226;&nbsp;&nbsp;
									<img src="'.get_bloginfo('template_url').'/images/blog-categories.png" alt="post categories" />'.str_replace('rel="category"','',get_the_category_list( __( ', ', 'empire' ) ));
									
									if(comments_open()){
										print '&nbsp;&nbsp;&#8226;&nbsp;&nbsp;
										<img src="'.get_bloginfo('template_url').'/images/blog-comments.png" alt="post comments number" />'; comments_number( __('0 comment','empire'), __('1 comment','empire'), __('% comments','empire') ); 
									}
									
									print '
								</div>';
							
							
							//featured image
								if(get_post_format() == 'image' || get_post_format() == 'quote'){
									if(has_post_thumbnail()){
										$src = wp_get_attachment_image_src( get_post_thumbnail_id($post->ID), 'single-thumb', false );
										print '<div class="featured-image" style="background-image:url('.$src[0].')"></div>';
									}
								}
							
							
							//content
								if(get_post_format() == 'quote'){
									print '<blockquote>'; the_content(); print '</blockquote>';
								}elseif(get_post_format() == 'audio'){
									if(strstr(get_post_meta($post->ID,'tp_postf_audio',true), '.mp3')){
									//audio player
										print '<audio class="mejs" src="'.get_post_meta($post->ID,'tp_postf_audio',true).'" controls="controls"></audio>
										<script type="text/javascript">				
											jQuery(document).ready(function($) {		
												$("#content audio").mediaelementplayer({
													
													startVolume: 0.20,		
													loop: false,
													features: ["playpause","volume","progress"],
													audioHeight: 35,
													audioWidth: 424
												});		
											});
											jQuery(".mejs-offscreen").text("");
										</script>
										';
									}else{
										$tp_postf_audio = get_post_meta($post->ID,'tp_postf_audio',true);
										if(!empty($tp_postf_audio)){
											print get_post_meta($post->ID,'tp_postf_audio',true);
										}
									}
								
									the_content();	
								}elseif(get_post_format() == 'video'){
									$tp_postf_video = get_post_meta($post->ID,'tp_postf_video',true);
									if(!empty($tp_postf_video)){
										$pattern = '/(width)="[0-9]*"/i';											
										$cnt = preg_replace($pattern,'style="width:99%"',get_post_meta($post->ID,'tp_postf_video',true));														
										print $cnt;
									}
									
									the_content();
								}else{
									the_content();					
								}
								
								wp_link_pages( array( 'before' => '<div class="page-links">' . __( '<strong>Pages:</strong>', 'empire' ), 'after' => '</div>' ) ); 
						endwhile;
					endif;
					
				print '
					</article>
					';
					
					
					
					$tp_post_bottom_social = get_post_meta($post->ID,'tp_post_bottom_social');	
					$tp_post_bottom_author = get_post_meta($post->ID,'tp_post_bottom_author');	
					$tp_post_bottom_related = get_post_meta($post->ID,'tp_post_bottom_related');	
					$tp_post_bottom_tags = get_post_meta($post->ID,'tp_post_bottom_tags');	
					
					
					//TAGS						
						if(!empty($tp_post_bottom_tags) && $tp_post_bottom_tags[0] == '1'){			
							print '<p>&nbsp;</p>							
							<p class="widget_tag_cloud"><span>'.__('Tags: ','empire').'</span>';
							
							$posttags = get_the_tags( $post->ID );
							if ($posttags) {
							  foreach($posttags as $tag) {
								$opt[] = '<a href="'.get_tag_link($tag->term_id).'">'.$tag->name.'</a>'; 
							  }
							  print implode(', ',$opt);
							}
							
							print '</p>';
						}
					
					
					if(!empty($tp_post_bottom_social) || !empty($tp_post_bottom_author) || !empty($tp_post_bottom_related) || comments_open()){
						print '<p>&nbsp;</p><hr class="hr" />';
					}
					
					//SOCIAL ICONS						
						if(!empty($tp_post_bottom_social) && $tp_post_bottom_social[0] == '1'){	
							print '<section class="social-sharing">
							
							<p>'.__('SHARE THIS ARTICLE','empire').'</p>
							
								<div class="holder">
							';							
							
							$uri_parts = explode('?', $_SERVER['REQUEST_URI']);
							
							$tp_post_bottom_social_fb = get_post_meta($post->ID, 'tp_post_bottom_social_fb', true);		
							if(!empty($tp_post_bottom_social_fb)){
								print '<a href="https://www.facebook.com/sharer/sharer.php?u='.urlencode('http://'.$_SERVER['HTTP_HOST']).urlencode($uri_parts[0]).'&amp;t='.urlencode($curtitle).'" target="_blank" title="Facebook"><img alt="facebook" src="'.get_bloginfo('template_url').'/images/sharing/facebook.png" /></a>';
							}
							
							$tp_post_bottom_social_twitter = get_post_meta($post->ID, 'tp_post_bottom_social_twitter', true);		
							if(!empty($tp_post_bottom_social_twitter)){
								print '<a href="http://twitter.com/home?status='.urlencode($curtitle).'%20'.urlencode('http://'.$_SERVER['HTTP_HOST']).urlencode($uri_parts[0]).'" target="_blank" title="Twitter"><img alt="twitter" src="'.get_bloginfo('template_url').'/images/sharing/twitter.png" /></a>';
							}
							
							$tp_post_bottom_social_gplus = get_post_meta($post->ID, 'tp_post_bottom_social_gplus', true);	
							if(!empty($tp_post_bottom_social_gplus)){
								print '<a href="https://plus.google.com/share?url='.urlencode('http://'.$_SERVER['HTTP_HOST']).urlencode($uri_parts[0]).'" target="_blank" title="Google+"><img alt="google plus" src="'.get_bloginfo('template_url').'/images/sharing/gplus.png" /></a>';
							}
							
							$tp_post_bottom_social_linkedin = get_post_meta($post->ID, 'tp_post_bottom_social_linkedin', true);
							if(!empty($tp_post_bottom_social_linkedin)){
								print '<a href="http://linkedin.com/shareArticle?mini=true&amp;url='.urlencode('http://'.$_SERVER['HTTP_HOST']).urlencode($uri_parts[0]).'&amp;title='.urlencode($curtitle).'" target="_blank" title="LinkedIn"><img alt="linkedin" src="'.get_bloginfo('template_url').'/images/sharing/linkedin.png" /></a>';
							}
							
							$tp_post_bottom_social_pin = get_post_meta($post->ID, 'tp_post_bottom_social_pin', true);		
							if(!empty($tp_post_bottom_social_pin)){
								print '<a href="http://pinterest.com/pin/create/button/?url='.urlencode('http://'.$_SERVER['HTTP_HOST']).urlencode($uri_parts[0]).'&amp;description='.urlencode($curtitle);
								if(!empty($src[0])){
									print '&amp;media='.urlencode($src[0]);
								}
								print '" target="_blank" title="Pinterest"><img alt="pinterest" src="'.get_bloginfo('template_url').'/images/sharing/pinterest.png" /></a>';
							}
							
							$tp_post_bottom_social_email = get_post_meta($post->ID, 'tp_post_bottom_social_email', true);	
							if(!empty($tp_post_bottom_social_email)){
								print '<a href="mailto:?subject='.urlencode($curtitle).'&amp;body='.urlencode('http://'.$_SERVER['HTTP_HOST']).urlencode($uri_parts[0]).'" target="_blank" title="Email"><img alt="email" src="'.get_bloginfo('template_url').'/images/sharing/email.png" /></a>';
							}
							
							$tp_post_bottom_social_reddit = get_post_meta($post->ID, 'tp_post_bottom_social_reddit', true);		
							if(!empty($tp_post_bottom_social_reddit)){
								print '<a href="http://reddit.com/submit?url='.urlencode('http://'.$_SERVER['HTTP_HOST']).urlencode($uri_parts[0]).'&amp;title='.$curtitle.'" target="_blank" title="Reddit"><img alt="reddit" src="'.get_bloginfo('template_url').'/images/sharing/reddit.png" /></a>';
							}
							
							$tp_post_bottom_social_digg = get_post_meta($post->ID, 'tp_post_bottom_social_digg', true);		
							if(!empty($tp_post_bottom_social_digg)){
								print '<a href="http://digg.com/submit?phase=2&amp;url='.urlencode('http://'.$_SERVER['HTTP_HOST']).urlencode($uri_parts[0]).'&amp;title='.$curtitle.'" target="_blank" title="Digg"><img alt="digg" src="'.get_bloginfo('template_url').'/images/sharing/digg.png" /></a>';
							}
							
							$tp_post_bottom_social_delicious = get_post_meta($post->ID, 'tp_post_bottom_social_delicious', true);
							if(!empty($tp_post_bottom_social_delicious)){
								print '<a href="http://www.delicious.com/post?v=2&amp;url='.urlencode('http://'.$_SERVER['HTTP_HOST']).urlencode($uri_parts[0]).'&amp;notes=&amp;tags=&amp;title='.urlencode($curtitle).'" target="_blank" title="Delicious"><img alt="delicious" src="'.get_bloginfo('template_url').'/images/sharing/delicious.png" /></a>';
							}							
							
							$tp_post_bottom_social_stumble = get_post_meta($post->ID, 'tp_post_bottom_social_stumble', true);		
							if(!empty($tp_post_bottom_social_stumble)){
								print '<a href="http://www.stumbleupon.com/submit?url='.urlencode('http://'.$_SERVER['HTTP_HOST']).urlencode($uri_parts[0]).'&amp;title='.urlencode($curtitle).'" target="_blank" title="Stumble Upon"><img alt="stumble upon" src="'.get_bloginfo('template_url').'/images/sharing/stumbleupon.png" /></a>';							
							}
							
							$tp_post_bottom_social_tumblr = get_post_meta($post->ID, 'tp_post_bottom_social_tumblr', true);		
							if(!empty($tp_post_bottom_social_tumblr)){
								print '<a href="http://www.tumblr.com/share/link?url='.urlencode('http://'.$_SERVER['HTTP_HOST']).urlencode($uri_parts[0]).'&amp;name='.urlencode($curtitle).'" target="_blank" title="Tumblr"><img alt="tumblr" src="'.get_bloginfo('template_url').'/images/sharing/tumblr.png" /></a>';							
							}
							
							print '
								</div>
							</section>
							
							<hr class="hr" />';
						}
					
					
					//AUTHOR						
						if(!empty($tp_post_bottom_author) && $tp_post_bottom_author[0] == '1'){	
							$author_url = get_the_author_meta('user_url');
							print '			
							<section class="author">
							';
								if(!empty($author_url)){
									print '<a href="'.$author_url.'" rel="author" target="_blank">'.get_avatar(get_the_author_meta( 'ID' ), 128).'</a>';
								}else{
									print get_avatar(get_the_author_meta( 'ID' ), 128);
								}
								print '
									
								<h3>'.__('Author:','empire').' '. get_the_author() . '</h3>
										
								<p>'.get_the_author_meta('description').'</p>
										
							</section>
									
							<hr class="hr" />			
							';
						}
					
					
					//RELATED POSTS						
						$tags = wp_get_post_tags($post->ID);
						if(!empty($tp_post_bottom_related) && $tp_post_bottom_related[0] == '1' && !empty($tags)){							
							foreach($tags as $tag){
								$tag_ids[] = $tag->term_id;
							}							
							$args=array(
								'tag__in' => $tag_ids,
								'post__not_in' => array($post->ID),
								'posts_per_page'=>3
							);
							
							$my_query = new WP_Query($args);
							if($my_query->have_posts()) {
								print '
								<section class="related-posts">
									<h5>'.__('RELATED POSTS','empire').'</h5>
									
									<ul>';
								
								$whctr = '0';
								while($my_query->have_posts()){ $my_query->the_post();
									$whctr++;
									
									if($whctr == '3'){									
										$whctr = '0';
										print '
										<li class="last">';
									}else{
										print '
										<li>';
									}
									
									if(has_post_thumbnail()){
										print '<a href="'.get_permalink().'">'.get_the_post_thumbnail( $post->ID, 'post-thumbnail').'</a>';
									}
									
									print '<a href="'.get_permalink().'" class="post-title">'.get_the_title().'</a><br /><span class="date">'.get_the_date().'</span>';
									
									
									print '</li>';
								}
								
								print '
									</ul>
								</section>
								
								<hr class="hr" />';
							}
							wp_reset_query();															
						}
						
						
					//SHOW VSPACE IF NO EXTRA INFO IS SHOWN
						if(empty($tp_post_bottom_related) && empty($tags) && empty($tp_post_bottom_author) && empty($tp_post_bottom_social)){
						
							print '<div class="vspace"></div>';						
						}
					
					
					//COMMENTS (IF COMMENTS ARE ENABLED ONLY!!)
					comments_template( '', true );	
					
				print '	
				</section>
				';
				
	
		//FOOTER WIDGET AREAS
			get_template_part('content','footer');
	
?>