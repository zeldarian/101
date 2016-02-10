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
* Add related post in single page
* add_action( 'do_ktz_singlecontent', 'ktz_relpost' ); in init.php
*/
if ( !function_exists('ktz_relpost') ) {
function ktz_relpost() {
	if ( ot_get_option('ktz_active_related') == 'yes' ) :
	global $post;
	$orig_post = $post;
	if (ot_get_option('ktz_taxonomy_relpost') == 'tags')
	{
		$tags = wp_get_post_tags($post->ID);
		if ($tags) {
			$tag_ids = array();
			foreach($tags as $individual_tag) $tag_ids[] = $individual_tag->term_id;
			$args=array(
				'tag__in' => $tag_ids,
				'post__not_in' => array($post->ID),
				'posts_per_page'=> 4,
				'ignore_sticky_posts'=>1
			);
		}
	} 
	else
	{
		$categories = get_the_category($post->ID);
		if ($categories) {
			$category_ids = array();
			foreach($categories as $individual_category) $category_ids[] = $individual_category->term_id;
			$args=array(
			'category__in' => $category_ids,
			'post__not_in' => array($post->ID),
			'posts_per_page'=> 3,
			'ignore_sticky_posts'=>1
			);
		} 
	} 
	if (!isset($args)) $args = '';
	$ktz_query = new WP_Query($args);
	if( $ktz_query->have_posts() ) { 
		echo '<h2 class="related-title"><span>' . __( 'Related Post',ktz_theme_textdomain) . ' "' . get_the_title() . '"</span></h2>';
		echo '<div class="ktz-related-post row">';
		while ( $ktz_query->have_posts() ) : $ktz_query->the_post();
		global $post;
		echo '<div class="col-md-4">';
		echo ktz_featured_just_img(250,150);
		echo '<div class="ktz-wrap-relpost">';
		echo '<div class="ktz_title_related">';
		echo ktz_posted_title_a();
		echo '</div>';
		echo '</div>';
		echo '</div>';
		endwhile;
		echo '</div>';
	} else {
		echo '<div class="no-post">No related post!</div>';
	}
	$post = $orig_post; 
	wp_reset_query();
	endif;
	}
}

?>