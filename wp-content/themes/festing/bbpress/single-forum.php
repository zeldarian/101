<?php

/**
 * Single Forum
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

		<?php if ( bbp_user_can_view_forum() ) : ?>

			<div id="forum-<?php bbp_forum_id(); ?>" class="bbp-forum-content<?php if ( is_active_sidebar('sidebar_forum') ): echo ' col-md-9'; else: echo ' col-md-12'; endif; ?>">
	<section class="new-content">
	<div class="box-post">
		<div class="inner-box">
		<h1 class="entry-title page-title clearfix"><span><?php bbp_forum_title(); ?></span></h1>
				<div class="entry-content">

					<?php bbp_get_template_part( 'content', 'single-forum' ); ?>

		</div>
		</div>
	</div>
	</section>
	</div><!-- #forum-front -->

		<?php else : // Forum exists, user no access ?>

			<?php bbp_get_template_part( 'feedback', 'no-access' ); ?>

		<?php endif; ?>

	<?php endwhile; ?>

	<?php do_action( 'bbp_after_main_content' ); ?>

<?php get_sidebar('forum'); ?>
	</div>
	</section>
<?php get_footer(); ?>
