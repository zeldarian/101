<?php 
/**
 * KENTOOZ PAGE TEMPLATE
**/
get_header(); ?>
	<section class="col-md-12">
	<div class="row">
	<?php 
		$ktz_meta_values = get_post_custom($post->ID);
		if ( ot_get_option('ktz_sb_layout') == 'left' ) : 
		get_sidebar(); 
		else :
			if(!isset($ktz_meta_values['ktz_meta_layout'][0])){
			 	$ktz_meta_values['ktz_meta_layout'][0] = 'right';
			}
			if ( $ktz_meta_values['ktz_meta_layout'][0] == 'left' ) { 
				get_sidebar(); 
			} else {
				echo '';
			}
		endif; ?>
		<div role="main" class="main col-md-9">
		<section class="new-content">
		<?php while ( have_posts() ) : the_post(); 
		get_template_part( 'content', 'page' ); 
		endwhile; ?>
		</section>
		</div>
	<?php if ( ot_get_option('ktz_sb_layout') == 'right' ) : 
		get_sidebar(); 
		else :
			$ktz_meta_values = get_post_custom($post->ID);
			if ($ktz_meta_values['ktz_meta_layout'][0] == 'right') { 
				get_sidebar(); 
			} else {
				echo '';
			}
		endif; ?>
	</div>
	</section>
<?php get_footer(); ?>
