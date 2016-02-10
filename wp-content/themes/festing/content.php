<?php
/**
 * KENTOOZ DEFAULD POST TEMPLATE
**/
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('box-post ktz-archive'); ?>>
	<?php ktz_posted_title_h('h2','entry-title'); ?>
	<div class="meta-post">
		<?php hook_ktz_content_meta(); ?>
	</div>
	<div class="entry-body media">
	
	<div class="clearfix">
		<?php 	
		if (has_post_format('gallery')) {
			echo ktz_gallery_slide();
		} else {
			echo '<div class="ktz-featuredimg">';
			echo ktz_featured_img_width( 540 ); // New kentooz image croping just call ktz_featured_img( width, height )
			echo '</div>';
		}
		?>
	</div>
	
	<div class="media-body ktz-post">
		<?php hook_ktz_content(); ?>
	</div>
	
	</div>
	
	<?php echo ktz_share_cat(); ?>

</article><!-- #post-<?php the_ID(); ?> -->