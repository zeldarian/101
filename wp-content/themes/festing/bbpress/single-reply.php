<?php

/**
 * Single Reply
 *
 * @package bbPress
 * @subpackage Theme
 */

get_header(); ?>
	<section class="col-md-12">
	<div class="row">
	<?php do_action( 'bbp_before_main_content' ); ?>

	<?php do_action( 'bbp_template_notices' ); ?>

	<?php if ( bbp_user_can_view_forum( array( 'forum_id' => bbp_get_reply_forum_id() ) ) ) : ?>

		<?php while ( have_posts() ) : the_post(); ?>

	<div id="bbp-reply-wrapper-<?php bbp_reply_id(); ?>" class="bbp-reply-wrapper<?php if ( is_active_sidebar('sidebar_forum') ): echo ' col-md-9'; else: echo ' col-md-12'; endif; ?>">
	<section class="new-content">
	<div class="box-post">
		<div class="inner-box">
		<h1 class="entry-title page-title clearfix"><span><?php bbp_reply_title(); ?></span></h1>
				<div class="entry-content">

					<?php bbp_get_template_part( 'content', 'single-reply' ); ?>

				</div><!-- .entry-content -->
		</div>
	</div>
	</section>
	</div><!-- #topic-front -->

		<?php endwhile; ?>

	<?php elseif ( bbp_is_forum_private( bbp_get_reply_forum_id(), false ) ) : ?>

		<?php bbp_get_template_part( 'feedback', 'no-access' ); ?>

	<?php endif; ?>

	<?php do_action( 'bbp_after_main_content' ); ?>

	<?php get_sidebar('forum'); ?>
	</div>
	</section>
<?php get_footer(); ?>
