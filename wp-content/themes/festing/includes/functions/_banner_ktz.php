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
* All banner function here and call it via add_action
*/
/* 
* Add banner in header after top menu
* Add action add_action( 'do_ktz_attachment_banner', 'ktz_attachment_banner' ); in init.php 
*/
if ( !function_exists('ktz_attachment_banner') ) {
function ktz_attachment_banner() { 
	if ( ot_get_option('ktz_attachment728_activated') == 'yes' ) :
	if ( !is_search() ) {
		echo '<div class="ktz-attachmentbanner">';
		echo do_shortcode( stripslashes(ot_get_option('ktz_attachment728')));
		echo '</div>';
	}
	endif;
  }
}
/* 
* Add banner in header after top menu
* Add action add_action( 'do_ktz_sideslide_banner', 'ktz_sideslide_banner' ); in init.php 
*/
if ( !function_exists('ktz_sideslide_banner') ) {
function ktz_sideslide_banner() { 
	if ( ot_get_option('ktz_336280_sideslider_activated') == 'yes' ) :
	if ( !is_search() ) {
		echo '<div class="ktz-sideslider">';
		echo do_shortcode( stripslashes(ot_get_option('ktz_336280_sideslider')));
		echo '</div>';
	}
	endif;
  }
}
/* 
* Add banner in header all page
* Add action add_action( 'do_ktz_headbanner', 'ktz_headbanner' ); in init.php 
*/
if ( !function_exists('ktz_headbanner') ) {
function ktz_headbanner() { 
	if ( ot_get_option('ktz_ban72890_top_activated') == 'yes' ) :
	if ( !is_search() ) {
	echo do_shortcode( stripslashes(ot_get_option('ktz_ban72890_top')));
	}
	endif;
  }
}
/* 
* Add banner in header after top menu
* Add action add_action( 'do_ktz_aftermenubanner', 'ktz_aftermenubanner' ); in init.php 
*/
if ( !function_exists('ktz_aftermenubanner') ) {
function ktz_aftermenubanner() { 
	if ( ot_get_option('ktz_ban72890_aftermenu_activated') == 'yes' ) :
	if ( !is_search() ) {
	echo '<div class="ktz-aftermenubanner">';
	echo do_shortcode( stripslashes(ot_get_option('ktz_ban72890_aftermenu')));
	echo '</div>';
	}
	endif;
  }
}
/* 
* Add banner in archive page after first post
* Add action add_action( 'do_ktz_footerbanner', 'ktz_footerbanner' ); in init.php 
*/
if ( !function_exists('ktz_footerbanner') ) {
function ktz_footerbanner() { 
	if ( ot_get_option('ktz_ban72890_footer_activated') == 'yes' ) :
	if ( !is_search() ) {
	echo '<div class="ktz-footerbanner">';
	echo do_shortcode( stripslashes(ot_get_option('ktz_ban72890_footer')));
	echo '</div>';
	}
	endif;
  }
}
/* 
* Add banner before title in single page
* Add add_action( 'do_ktz_singleheadban', 'ktz_ban46860_singlehead' ); in init.php 
*/
if ( !function_exists('ktz_ban46860_singlehead') ) {
function ktz_ban46860_singlehead() { 
	if ( ot_get_option('ktz_ban46860_shead_activated') == 'yes' ) :
	if ( !is_search() ) {
	echo '<div class="bannersinglehead">';
		echo do_shortcode( stripslashes(ot_get_option('ktz_ban46860_shead')));
	echo '</div>';
	}
	endif;
  }
}
/* 
* Add banner after title in single page
* Add add_action( 'do_ktz_singlecontent', 'ktz_ban46860_singletit' ); in init.php 
*/
if ( !function_exists('ktz_ban46860_singletit') ) {
function ktz_ban46860_singletit() { 
	if ( ot_get_option('ktz_ban46860_stit_activated') == 'yes' ) :
	if ( !is_search() ) {
	echo '<div class="ktz-bannersingletop">';
		echo do_shortcode( stripslashes(ot_get_option('ktz_ban46860_stit')));
	echo '</div>';
	}
	endif;
  }
}
/* 
* Add banner after content in single page
* Add add_action( 'do_ktz_singlecontent', 'ktz_ban46860_singlefoot' ); in init.php 
*/
if ( !function_exists('ktz_ban46860_singlefoot') ) {
function ktz_ban46860_singlefoot() { 
	if ( ot_get_option('ktz_ban46860_sfot_activated') == 'yes' ) :
	if ( !is_search() ) {
	echo '<div class="bannersinglefot">';
		echo do_shortcode( stripslashes(ot_get_option('ktz_ban46860_sfot')));
	echo '</div>';
	}
	endif;
  }
}

/* 
* Add banner right content in single page
*/
if ( !function_exists('ktz_ban160_topsingle_right') ) {
function ktz_ban160_topsingle_right() { 
	if ( ot_get_option('ktz_ban160_single_activated') == 'yes' ) :
	if ( !is_search() ) {
		echo '<div class="ktzsingle-bannerright pull-right">';
		echo ot_get_option('ktz_ban160_single');
		echo '</div>';
	}
	endif;
  }
}

?>