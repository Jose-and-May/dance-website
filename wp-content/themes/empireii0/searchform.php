<!-- SEARCH FORM -->
<div class="search">
	<form action="<?php print site_url(); ?>/" method="get" accept-charset="utf-8" class="search-form">
		<input type="text" class="input-text" id="s" name="s" value="<?php if(!empty($_GET['s'])){ print $_GET['s']; }else{ _e('Search...', 'empire'); } ?>" onfocus="if(this.value=='<?php _e('Search...', 'empire'); ?>'){this.value=''};" onblur="if(this.value==''){this.value='<?php _e('Search...', 'empire'); ?>'}" />
		<input type="image" src="<?php print get_template_directory_uri(); ?>/images/search-button.png" class="input-button" alt="search" />
	</form>
</div>