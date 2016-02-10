<div class="sbar col-md-3 widget-area wrapwidget" role="complementary">
<?php 	
	if ( is_page() || is_single() ) {
	$ktz_meta_values = get_post_custom($post->ID);
		if(!isset($ktz_meta_values['ktz_meta_sidebar'][0])){
			$ktz_meta_values['ktz_meta_sidebar'][0] = 'default';
		}
				   		
		if ($ktz_meta_values['ktz_meta_sidebar'][0] == "default") {
			if ( is_active_sidebar('sidebar_default')) : dynamic_sidebar('sidebar_default'); endif;
		} else {
			dynamic_sidebar($ktz_meta_values['ktz_meta_sidebar'][0]);
		}
	} else {
		if ( is_active_sidebar('sidebar_default')) : dynamic_sidebar('sidebar_default'); endif;
	}
?>
</div>
