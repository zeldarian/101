<?php 
/**
 * KENTOOZ AUTHOR TEMPLATE
**/
get_header(); ?>

	<section class="col-md-12">
	<div class="row">
	<?php if ( ot_get_option('ktz_sb_layout') == 'left' ) : get_sidebar(); endif; ?>
		<div role="main" class="main col-md-9">
		<section class="new-content">
		<div class="ktz-titlepage"><h1><?php printf( __( 'Author: %s', ktz_theme_textdomain ), '<span class="vcard"><a class="url fn n" href="' . esc_url( get_author_posts_url( get_the_author_meta( "ID" ) ) ) . '" title="' . esc_attr( get_the_author() ) . '" rel="me">' . get_the_author() . '</a></span>' ); ?></h1></div>
		<div class="authorpage">
		<?php echo ktz_author_box_autpage(); ?>
		</div>
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
	<?php 
	get_sidebar(); ?>
	</div>
	</section>
<?php get_footer(); ?>
