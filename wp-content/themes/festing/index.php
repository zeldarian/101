<?php 
/**
 * KENTOOZ INDEX TEMPLATE
**/
get_header(); ?>

	<section class="col-md-12">
	<div class="row">
	<?php if ( ot_get_option('ktz_sb_layout') == 'left' ) : get_sidebar(); endif; ?>
		<div role="main" class="main col-md-9">
		<section class="new-content">
		<?php if ( have_posts() ) : 
		while ( have_posts() ) : the_post();
			if ( ot_get_option('ktz_content_layout') == 'layout_blog' ) :
			get_template_part( 'content', 'mini' );
			else :
			get_template_part( 'content', get_post_format() );
			endif;
		endwhile; ?>
		<nav id="nav-index">
			<?php ktz_navigation(); ?>
		</nav>
		<?php else : ktz_post_notfound(); endif; ?>
		</section>
		</div>
	<?php get_sidebar(); ?>
	</div>
	</section>
<?php get_footer(); ?>
