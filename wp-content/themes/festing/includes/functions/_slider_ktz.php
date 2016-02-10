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
* Gallery post type
*/
if ( !function_exists('ktz_gallery_slide') ) {
function ktz_gallery_slide() { 
	global $post;
	$meta_values = get_post_custom($post->ID);
	if(isset($meta_values['ktz_gallery_post_postformat'][0]) && has_post_format('gallery')){
		$title = get_the_title();
		$gallery = explode( ',', get_post_meta( get_the_ID(), 'ktz_gallery_post_postformat', true ) );
		echo '<div class="box_gallery box_gallery_single"><div id="inner_box_gallery">';
			$count = 0; 
			foreach ($gallery as $slide ) {
				$attachment_url = get_attachment_link( $slide );
				$img_url = wp_get_attachment_url( $slide ); 
				$desc_img = get_the_title( $slide );
				$params = array( 'width' => 539 );
				$image_ori = bfi_thumb( $img_url, $params ); //resize & crop the image
				if ( $count == 0 ) {
				echo '<a class="data-original-link" href="' . $attachment_url . '" data-title="Image for ' . $desc_img . '"><img class="data-original" src="'.$image_ori.'" height="auto" width="539" alt="' . $desc_img . '" title="' . $desc_img . '" /></a>';
				}
				$count++;
			}		
		echo '</div>';
		echo '<div class="widget_carousel ktz-slidesingle"><div class="list_carousel"><div class="ktzcarousel-little owl-carousel owl-theme owl-little">';
			foreach ($gallery as $slide ) {
				$attachment_url = get_attachment_link( $slide );
				$img_url = wp_get_attachment_url( $slide ); 
				$desc_img = get_the_title( $slide );
				$params_1 = array( 'width' => 177, 'height' => 130, 'crop' => true );
				$image = bfi_thumb( $img_url, $params_1 ); //resize & crop the image
				$params_2 = array( 'width' => 539 );
				$image_ori = bfi_thumb( $img_url, $params_2 ); //resize & crop the image
				echo '<div class="item ktz-widgetcolor"><img src="'.$image.'" data-ori="' . $attachment_url . '" data-crop="'.$image_ori.'" height="130" width="177" alt="' . $desc_img . '" data-title="' . $desc_img . '" /></div>';
				}
			echo '</div></div></div></div>';
		} else {
			echo '<div class="ktz-featuredimg">';
			echo ktz_featured_img_width( 540 );
			echo '</div>';
		}
	}
}

/*******************************************
# Add EDITOR PICK's Featured post on top 
*******************************************/
if ( !function_exists('ktz_mustread_content') ) :
function ktz_mustread_content() {	
	global $post;
	if ( ot_get_option('ktz_popup_activated') == 'yes' ) :
		$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
		$args = array(
			'post_type' => 'post',
			'orderby' => 'rand',
			'order' => 'desc',
			'showposts' => 3,
			'post_status' => 'publish',
			'ignore_sticky_posts' => 1
		);
		$ktz_topfeatquery = new WP_Query($args); 
		if ($ktz_topfeatquery -> have_posts()) : 
		echo '<div id="ktz_slidebox">';
		echo '<strong class="mustread_title">' . __('Must read', ktz_theme_textdomain) . '</strong><a href="#" class="close">&times;</a>';
		echo '<ul class="mustread_list">';
		while ($ktz_topfeatquery -> have_posts()) : $ktz_topfeatquery -> the_post();
		echo '<li class="mustread_li clearfix">';
		echo '<div class="pull-left">';
		echo ktz_featured_img(50, 50);
		echo '</div>';
		echo '<div class="title">';
		echo ktz_posted_title_a();
		echo '</div>';
		echo '</li>';
		endwhile; 
		echo '</ul>';
		echo '</div>';
		endif;
	wp_reset_query();
	endif;
	}
endif;

?>