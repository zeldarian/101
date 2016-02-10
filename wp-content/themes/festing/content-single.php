<?php
/**
 * KENTOOZ SINGLE POST TEMPLATE
**/
global $post;
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('ktz-single'); ?>>
	<?php ktz_setPostViews(get_the_ID()); //get view for single post ?>
	<div class="ktz-single-box">
	<div class="entry-body">
		<?php //hook_ktz_singleheadban(); ?>
		<?php
			if (has_post_format('gallery')) {
				echo ktz_gallery_slide();
			} elseif ( has_post_format('video') ) {		
				$ktz_social_lock_mt = get_post_custom_values('ktz_activated_locker', $post->ID); 
				$ktz_lock_video = $ktz_social_lock_mt[0];
				if ( ( $ktz_lock_video == 'yes' && ot_get_option('ktz_active_videolocker') == 'no' ) || ot_get_option('ktz_active_videolocker') == 'yes' ) :
					echo '<div class="ktz-all-videowrapper">';
					echo do_shortcode('[viral_lock_button show_facebook="yes" show_twitter="yes" show_gplus="yes" text_locker="You must like first for see video!!"]'.ktz_video_wrapper().'[/viral_lock_button]');
					echo '</div>';
				else :
					echo ktz_video_wrapper();
				endif; 
			}		
		?>
		<h1 class="entry-title clearfix"><?php the_title(); ?></h1>
		<div class="metasingle-aftertitle">
			<div class="ktz-inner-metasingle">
				<?php hook_ktz_content_single_meta(); ?>
				<?php echo ktz_getPostViews($post->ID); ?>
				<?php echo ktz_ajaxstar_SEO_single(); ?>
				<?php edit_post_link( __( 'Edit', ktz_theme_textdomain ), '<span class="entry-edit">', '</span>' ); ?>
			</div>
		</div>
		<div class="entry-content ktz-wrap-content-single clearfix ktz-post">
		<?php //echo ktz_ban160_topsingle_right(); ?>	
		<?php if ( ot_get_option('ktz_ban160_single_activated') == 'yes' ) : ?>	
		<div class="ktz-content-single">
		<?php endif; ?>
		<?php //echo ktz_ban46860_singletit(); ?>
		<?php echo ktz_content_single_firstp(); ?>
		<?php 
			if( !has_post_format('video') && !has_post_format('gallery') ) :
			if ( ot_get_option('ktz_active_autocontent') == 'yes' ) {
				echo '<div class="ktz-featuredimg">';
				echo ktz_featured_just_img_width( 540 ); 
				echo '</div>';
				} 
			endif;	 
		?>
		<?php echo ktz_content_single(); ?>
		<?php $posttags = get_the_tags();  
		if ($posttags) {  
		echo '<p class="ktz-tagcontent">Tags: ';
		foreach($posttags as $tag) {  
			echo '<a href=" ' . get_tag_link($tag->term_id) . '" title="Tag '. $tag->name .'">#';
			echo $tag->name;   
			echo '</a> ';
			}  
		echo '</p>';
		} ?>
		<?php echo ktz_link_pages(); ?>
		<?php do_action( '//ktz_ban46860_singlefoot' );?>
		<?php if ( ot_get_option('ktz_active_download') == 'yes' ) {
			echo ktz_get_dl_image_single();
		} ?>
		<?php hook_ktz_single_agc(); ?>
		<?php hook_ktz_singlecontent(); ?>
		<?php if ( ot_get_option('ktz_ban160_single_activated') == 'yes' ) : ?>	
		</div>
		<?php endif; ?>
		</div>
	</div>
	</div>
	
</article><!-- #post-<?php the_ID(); ?> -->
