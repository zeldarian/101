<?php

/**
 * Single User
 *
 * @package bbPress
 * @subpackage Theme
 */

get_header(); ?>
	<section class="col-md-12">
	<div class="row">
	<?php do_action( 'bbp_before_main_content' ); ?>

	<div id="bbp-user-<?php bbp_current_user_id(); ?>" class="bbp-single-user<?php if ( is_active_sidebar('sidebar_forum') ): echo ' col-md-9'; else: echo ' col-md-12'; endif; ?>">
	<section class="new-content">
	<div class="box-post">
		<div class="inner-box">
		<div class="entry-content">

			<?php bbp_get_template_part( 'content', 'single-user' ); ?>

		</div><!-- .entry-content -->
		</div>
	</div>
	</section>
	</div><!-- #bbp-user-<?php bbp_current_user_id(); ?> -->

	<?php do_action( 'bbp_after_main_content' ); ?>

	<?php get_sidebar('forum'); ?>
	</div>
	</section>
<?php get_footer(); ?>
