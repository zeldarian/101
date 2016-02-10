	</div> <!-- .container on head -->
	</div>
	</div>
	
	<?php
	/*
	* Header setting
	*/
	global $post;
	if (isset($post->ID)) {
		$meta_values = get_post_custom($post->ID);
	}
	if(	isset($meta_values['ktz_footbg_squeeze'] ) && $meta_values['ktz_footbg_squeeze'][0] != '' ) {
		$ktz_footbg = $meta_values['ktz_footbg_squeeze'][0];
		echo '<div class="ktz-footbg-squeeze">';
		echo '<img src="' . $ktz_footbg . '" title="Header ' . get_the_title() . '" alt="Header ' . get_the_title() . '" />'; 
		echo '</div>';
	}
	?>
	<?php
	/*
	* Menu setting
	*/
	global $post;
	if (isset($post->ID)) {
		$meta_values = get_post_custom($post->ID);
	}
	if(	isset($meta_values['ktz_menu_squeeze'] ) && $meta_values['ktz_menu_squeeze'][0] == 'yes' ) {
		echo '<nav class="ktz-footermenu-squeeze">';
			echo '<div class="container">';
			hook_ktz_menu_squeeze();
			echo '</div>';
		echo '</nav>';
	}
	?>
	<?php
	/*
	* Copyright setting
	*/
	global $post;
	if (isset($post->ID)) {
		$meta_values = get_post_custom($post->ID);
	}
	if(	isset($meta_values['ktz_copyright_squeeze'] ) && $meta_values['ktz_copyright_squeeze'][0] == 'yes' ) {
		echo '<footer class="footer-squeeze">';
		echo '<div class="container">';
		echo '<div class="copyright">';
				hook_ktz_after_footer_squeeze();
		echo '</div>';
		echo '</div>';
		echo '</footer>';
	}
	?>
	
	
	<?php wp_footer();echo ot_get_option("ktz_footer")  . "\n"; ?>
	<?php echo ktz_exitsplash_squeezepage_js(); ?>
</body>
</html>