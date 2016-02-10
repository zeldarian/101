<?php
/*
/*-----------------------------------------------*/
/* KENTOOZ THEMES FUNCTION
/* Website    : http://www.kentooz.com
/* The Author : Gian Mokhammad Ramadhan (http://www.gianmr.com)
/* Twitter    : http://www.twitter.com/g14nnakal 
/* Facebook   : http://www.facebook.com/gianmr
/*-----------------------------------------------*/

/* 
* Error page layout
* Just call ktz_error_page(); in 404.php 
*/
function ktz_error_page() { 	
	global $post;
	?>
	<hr class="single" />
	<h3 class="error-title"><span class="glyphicon glyphicon-ban-circle"></span> <?php _e( 'The page you are looking for doesn\'t seem to exist.', ktz_theme_textdomain ); ?></h3>
	<hr class="double" />
	<h4 class="error-title"><?php _e( 'It looks like this was the result of either:', ktz_theme_textdomain ); ?></h4>
	<hr class="double" />
	<?php $ktzrandom = new WP_Query(array( // Use query_post for add pagination in post page
			'orderby' => 'rand',
			'order' => 'desc',
			'posts_per_page' => 4,
			'ignore_sticky_posts' => 1
	)); ?>
	<section class="new-content">
		<?php if ( $ktzrandom->have_posts() ) : while ( $ktzrandom->have_posts() ) : $ktzrandom->the_post();
			get_template_part( 'content', get_post_format() );
		endwhile; ?>
	<?php else : echo 'No post'; endif; ?>
	</section>
	<?php 
}

/* 
* If page/post does not exist then this function call
*/
if ( ! function_exists( 'ktz_post_notfound' ) ) :
function ktz_post_notfound() { ?>
	<article id="post-0" class="post no-results not-found">
		<header class="entry-header">
			<h3><?php _e( 'Nothing Found', ktz_theme_textdomain ); ?></h3>
		</header>
			<div class="entry-content">
			<p><?php _e( 'Apologies, but no results were found for the requested archive. Perhaps searching will help find a related post.', ktz_theme_textdomain ); ?></p>
			<?php get_search_form(); ?>
			</div>
	</article>
	<?php } 	
endif;

?>