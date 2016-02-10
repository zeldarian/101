<?php
/**
 * KENTOOZ DEFAULD POST TEMPLATE
**/
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('box-post ktz-archive'); ?>>
	<div class="entry-body media">
		<?php 	
			echo ktz_featured_img( 80, 80 ); // New kentooz image croping just call ktz_featured_img( width, height )
		?>
	
	<div class="media-body ktz-post">
	<?php ktz_posted_title_h('h2','entry-title ktz-titlemini'); ?>
		<div style="display:none;"><?php hook_ktz_content_meta(); ?></div>
		<div class="media-body ktz-post">
			<?php hook_ktz_content(); ?>
		</div>
	
	</div>
	</div>

</article><!-- #post-<?php the_ID(); ?> -->