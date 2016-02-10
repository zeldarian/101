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
* Add extra user field in admin panel
* add_action( 'show_user_profile', 'my_show_extra_profile_fields' ); in init.php
* add_action( 'edit_user_profile', 'my_show_extra_profile_fields' ); in init.php
* add_action( 'personal_options_update', 'my_save_extra_profile_fields' ); in init.php
* add_action( 'edit_user_profile_update', 'my_save_extra_profile_fields' ); in init.php
*/
function ktz_show_extra_profile_fields( $user ) {
	echo '<h3>Social network:</h3>';
	echo '<table class="form-table"><tr><th><label for="twitter">' . __('Twitter', ktz_theme_textdomain) . '</label></th>';
	echo '<td><input type="text" name="twitter" id="twitter" value="';
	echo esc_attr( get_the_author_meta( 'twitter', $user->ID ) ); 
	echo '" class="regular-text" /><br /><span class="description">' . __('Please enter your Twitter username without the @.', ktz_theme_textdomain) . '</span>';
	echo '</td></tr></table><table class="form-table"><tr>';
	echo '<th><label for="facebook">' . __('Facebook', ktz_theme_textdomain) . '</label></th>';
	echo '<td><input type="text" name="facebook" id="facebook" value="';
	echo esc_attr( get_the_author_meta( 'facebook', $user->ID ) );
	echo '" class="regular-text" /><br /><span class="description">' . __('Please enter your facebook full url example http://www.facebook.com/kentoozdotcom.', ktz_theme_textdomain) . '</span>';
	echo '</td></tr></table><table class="form-table"><tr><th><label for="googleplus">' . __('Google plus', ktz_theme_textdomain) . '</label></th>';
	echo '<td><input type="text" name="googleplus" id="googleplus" value="';
	echo esc_attr( get_the_author_meta( 'googleplus', $user->ID ) );
	echo '" class="regular-text" /><br /><span class="description">' . __('Please enter your google plus full url example http://plus.google.com/100237202599723142598.', ktz_theme_textdomain) . '</span>';
	echo '</td></tr></table>';
}
function ktz_save_extra_profile_fields( $user_id ) {
	if ( !current_user_can( 'edit_user', $user_id ) )
		return false;
	update_user_meta( $user_id, 'twitter', $_POST['twitter'] );
	update_user_meta( $user_id, 'facebook', $_POST['facebook'] );
	update_user_meta( $user_id, 'googleplus', $_POST['googleplus'] );
}

/* 
* Add author box in single page
* Add add_action( 'do_ktz_singlecontent', 'ktz_author_box' ); in init.php 
*/
if ( !function_exists('ktz_author_box') ) {
function ktz_author_box() { 
	if ( ot_get_option('ktz_active_autbox') == 'yes' ) :
	if (is_single()) {
		echo '<div class="ktz-authorbox"><div class="panel panel-default">';
		echo '<div class="panel-heading clearfix">';
		echo '<div class="pull-left">' . __( 'Author:',ktz_theme_textdomain) . '&nbsp;';
		echo the_author_posts_link();
		echo '</div>';
		echo '<ul class="ktz-socialicon pull-right">';
		if (get_the_author_meta('twitter') != '' || get_the_author_meta('facebook') != '' || get_the_author_meta('googleplus') != '' || get_the_author_meta('url') != '' ) {
		if (get_the_author_meta('twitter') != '' ) {
			echo '<li class="twitter"><a target="_blank" href="http://twitter.com/';
			echo the_author_meta('twitter');
			echo '" title="' . __( 'Follow',ktz_theme_textdomain) . ' ';
			echo the_author_meta( 'display_name' );
			echo ' ' . __( 'on Twitter',ktz_theme_textdomain) . '"><span class="fontawesome ktzfo-twitter"></span></a></li>';
			} if (get_the_author_meta('facebook') != '' ) {
			echo '<li class="facebook"><a target="_blank" href="';
			echo the_author_meta('facebook');
			echo '" title="' . __( 'Add',ktz_theme_textdomain) . ' ';
			echo the_author_meta( 'display_name' );
			echo ' ' . __( 'on facebook',ktz_theme_textdomain) . '"><span class="fontawesome ktzfo-facebook"></span></a></li>';
			} if (get_the_author_meta('googleplus') != '' ) {
			echo '<li class="gplus"><a target="_blank" href="';
			echo the_author_meta('googleplus');
			echo '" title="' . __( 'Cycle',ktz_theme_textdomain) . ' ';
			echo the_author_meta( 'display_name' );
			echo ' ' . __( 'on googleplus',ktz_theme_textdomain) . '"><span class="fontawesome ktzfo-google-plus"></span></a></li>';
			} if (get_the_author_meta('url') != '' ) {
			echo '<li class="rss"><a target="_blank" href="';
			echo the_author_meta('url');
			echo '" title="';
			echo the_author_meta( 'display_name' );
			echo ' ' . __( 'site',ktz_theme_textdomain) . '"><span class="fontawesome ktzfo-rss"></span></a></li>';
			} 
		}
		echo '</ul>';
		echo '</div>';
		echo '<div class="panel-body clearfix">';
		echo '<div class="ktz-author-thumb pull-left">';
		echo get_avatar( get_the_author_meta( 'user_email' ), $size='52', '', $alt='author' );
		echo '</div>';
		echo '<div class="ktz-author-desc">';
		echo the_author_meta( 'description' );
		echo '</div>';		
		echo '</div>';
		echo '</div></div>';
		}
	endif;
	} 	
}

/* 
* Add author box in single page
* Add add_action( 'do_ktz_singlecontent', 'ktz_author_box' ); in init.php 
*/
if ( !function_exists('ktz_author_box_autpage') ) {
function ktz_author_box_autpage() { 
global $wp_query;
$curauth = $wp_query->get_queried_object();
			$twitter_ads = get_the_author_meta( 'twitter', $curauth->ID );
			$facebook_ads = get_the_author_meta( 'facebook', $curauth->ID );
			$gplus_ads = get_the_author_meta( 'googleplus', $curauth->ID );	
			$web_ads = get_the_author_meta( 'user_url', $curauth->ID );	
			$description	= $curauth->description ;
			$display_name	= $curauth->display_name;
		echo '<div class="ktz-authorbox"><div class="panel panel-default">';
		echo '<div class="panel-heading clearfix">';
		echo '<ul class="ktz-socialicon pull-right">';
		if ($twitter_ads != '' || $facebook_ads != '' || $gplus_ads != '' || $web_ads != '' ) {
		if ($twitter_ads != '' ) {
			echo '<li class="twitter"><a target="_blank" href="http://twitter.com/';
			echo $twitter_ads;
			echo '" title="' . __( 'Follow',ktz_theme_textdomain) . ' ';
			echo $display_name;
			echo ' ' . __( 'on Twitter',ktz_theme_textdomain) . '"><span class="fontawesome ktzfo-twitter"></span></a></li>';
			} if ($facebook_ads != '' ) {
			echo '<li class="facebook"><a target="_blank" href="';
			echo $facebook_ads;
			echo '" title="' . __( 'Add',ktz_theme_textdomain) . ' ';
			echo $display_name;
			echo ' ' . __( 'on facebook',ktz_theme_textdomain) . '"><span class="fontawesome ktzfo-facebook"></span></a></li>';
			} if ($gplus_ads != '' ) {
			echo '<li class="gplus"><a target="_blank" href="';
			echo $gplus_ads;
			echo '" title="' . __( 'Cycle',ktz_theme_textdomain) . ' ';
			echo $display_name;
			echo ' ' . __( 'on googleplus',ktz_theme_textdomain) . '"><span class="fontawesome ktzfo-google-plus"></span></a></li>';
			} if ($web_ads != '' ) {
			echo '<li class="rss"><a target="_blank" href="';
			echo $web_ads;
			echo '" title="';
			echo $display_name;
			echo ' ' . __( 'site',ktz_theme_textdomain) . '"><span class="fontawesome ktzfo-rss"></span></a></li>';
			} 
		}
		echo '</ul>';		
		echo '</div>';
		echo '<div class="panel-body clearfix">';
		echo '<div class="ktz-author-thumb pull-left">';
		echo get_avatar( get_the_author_meta( 'user_email' ), $size='52', '', $alt='author' );
		echo '</div>';
		echo '<div class="ktz-author-desc">';
		echo $description;
		echo '</div>';		
		echo '</div>';
		echo '</div></div>';
	} 	
}

?>