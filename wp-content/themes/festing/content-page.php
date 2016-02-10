<?php
/**
 * KENTOOZ PAGE LOOP TEMPLATE
**/
?>
<article id="post-<?php the_ID(); ?>" <?php post_class('ktz-page'); ?>>
		<div class="inner-box">
		<div class="entry-body">
		<div class="ktz-titlepage"><h1 class="entry-title"><span class="ktz-blocktitle"><?php the_title(); ?></span></h1></div>
		<?php echo '<div style="display:none;">';
			echo ktz_posted_on();
			echo ktz_author_by();
			echo '</div>';
		?>
			<?php the_content(); ?>
			<?php wp_link_pages( array( 'before' => '<div class="page-link"><span>' . __( 'Pages:', ktz_theme_textdomain ) . '</span>', 'after' => '</div>' ) ); ?>
		</div>
		</div>
</article><!-- #post-<?php the_ID(); ?> -->
