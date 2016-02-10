<?php

/**
 * Merge topic page
 *
 * @package bbPress
 * @subpackage Theme
 */

get_header(); ?>
	<section class="col-md-12">
	<div class="row">
	<?php do_action( 'bbp_before_main_content' ); ?>

	<?php do_action( 'bbp_template_notices' ); ?>

	<?php while ( have_posts() ) : the_post(); ?>

	<div id="bbp-edit-page" class="bbp-edit-page<?php if ( is_active_sidebar('sidebar_forum') ): echo ' col-md-9'; else: echo ' col-md-12'; endif; ?>">
	<section class="new-content">
	<div class="box-post">
		<div class="inner-box">
		<h1 class="entry-title page-title clearfix"><span><?php the_title(); ?></span></h1>
			<div class="entry-content">

				<?php bbp_get_template_part( 'form', 'topic-merge' ); ?>

			</div>
		</div>
	</div>
	</section>
	</div><!-- #topic-front -->

	<?php endwhile; ?>

	<?php do_action( 'bbp_after_main_content' ); ?>

	<?php get_sidebar('forum'); ?>
	</div>
	</section>
<?php get_footer(); ?>