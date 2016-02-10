<?php
/**
 * The file that defines all  necessery shortcode for scrapper
 *
 * @link       http://kentooz.com
 * @since      1.0.0
 *
 * @package    ktzagcplugin
 * @subpackage ktzagcplugin/modules
 */

function ktzagcplugin_random_term_shorcode( $atts ) {
	extract( shortcode_atts( array(
	 'number' => 10
	), $atts ) );
	$numbers = empty($number) ? 10 : $number;
	
	return ktzplg_get_random_term( $numbers );
}
add_shortcode( 'ktzagcplugin_random_term', 'ktzagcplugin_random_term_shorcode' );

function ktzagcplugin_google_trend_shorcode( $atts ) {
	extract( shortcode_atts( array(
	 'country_code' => 'p1',
	 'number' => 10
	), $atts ) );
	$numbers = empty($number) ? 10 : $number;
	$country_codes = empty($country_code) ? 10 : $country_code;
	
	return ktzplg_get_google_trend( $country_codes, $numbers );
}
add_shortcode( 'ktzagcplugin_google_trend', 'ktzagcplugin_google_trend_shorcode' );

/* 
 * AGC Text Shortcode 
 * @return do_action funct, keyword, numb_sentence
 * support source: google, bing and ask
 */
function ktzagcplugin_text_shortcode( $atts ) {
	extract( shortcode_atts( array(
      'keyword' => '', # keyword
      'source' => 'google', # source AGC
      'number' => '',  #number show agc
	  'related' => '' #use related by keyword - true/false
      ), $atts ) );	
	if ( $keyword != '' ) {
		$keywords = $keyword;
	} elseif ( is_single() || is_page() || is_search() ) {
		$keywords = get_the_title();
	} elseif ( is_category() ) {
		$keywords = single_cat_title( '', false );
	} elseif ( is_tag() ) {
		$keywords = single_tag_title( '', false );
	} elseif ( is_404() ) {
		$keywords = ktzplg_get_404_title(); 
	} else {
		$keywords = '';
	}
	$sources = empty($source) ? 'google' : $source;
	$numbers = empty($number) ? 4 : $number;
	$relateds = empty($related) ? false : $related;
	if ( $sources == 'ask' ) {
		return ktzplg_get_ask_article( $keywords, $numbers, $relateds );
	} elseif ( $sources == 'bing' ) {
		return ktzplg_get_bing_article( $keywords, $numbers, $relateds );
	} elseif ( $sources == 'bingrss' ) {
		return ktzplg_get_bingrss_article( $keywords, $numbers, $relateds );
	} else {
		return ktzplg_get_google_article( $keywords, $numbers, $relateds );
	}
}
add_shortcode('ktzagcplugin_text', 'ktzagcplugin_text_shortcode'); /* format [ktzagcplugin_text keyword="" source="" number=""] */

/* 
 * AGC Image Shortcode 
 * @return do_action funct, keyword, numb_image
 * support source: bing and ask
 * Google image grab is confused, it redirect via meta redirect
 */
function ktzagcplugin_image_shortcode( $atts ) {
	extract( shortcode_atts( array(
      'source' => 'bing', # source AGC
      'keyword' => '', # keyword
      'max_keyword' => '', # Maximal keyword
      'number' => '',  #number show agc
	  'related' => '', #use related by keyword - true/false
      'license' => '' # License
      ), $atts ) );	
	if ( $keyword != '') {
		$keywords = $keyword;
	} elseif ( is_single() || is_page() || is_search() ) {
		$keywords = get_the_title();
	} elseif ( is_category() ) {
		$keywords = single_cat_title( '', false );
	} elseif ( is_tag() ) {
		$keywords = single_tag_title( '', false );
	} elseif ( is_404() ) {
		$keywords = ktzplg_get_404_title(); 
	} else {
		$keywords = '';
	}
	$max_keywords = empty($max_keyword) ? '' : $max_keyword;
	$sources = empty($source) ? 'bing' : $source;
	$numbers = empty($number) ? 1 : $number;
	$relateds = empty($related) ? false : $related;
	$licenses = empty($license) ? '' : $license;
	if ( $sources == 'ask' ) {
		return ktzplg_get_ask_image( $keywords, $max_keywords, $numbers, $relateds );
	} else {
		return ktzplg_get_bing_image( $keywords, $max_keywords, $numbers, $relateds, $licenses );
	}
}
add_shortcode('ktzagcplugin_image', 'ktzagcplugin_image_shortcode'); /* format [ktzagcplugin_image keyword="" max_keyword="" source="" number="" license=""] */

/* 
 * AGC Video Shortcode 
 * @return do_action funct, keyword, numb_image
 * support source: bing and ask
 */
function ktzagcplugin_video_shortcode( $atts ) {
	extract( shortcode_atts( array(
      'source' => 'bing', # source AGC
      'keyword' => '', # keyword
      'number' => '' # number sentence
      ), $atts ) );
	$sources = empty($source) ? 'bing' : $source;
	if ( $keyword != '') {
		$keywords = $keyword;
	} elseif ( is_single() || is_page() || is_search() ) {
		$keywords = get_the_title();
	} elseif ( is_category() ) {
		$keywords = single_cat_title( '', false );
	} elseif ( is_tag() ) {
		$keywords = single_tag_title( '', false );
	} elseif ( is_404() ) {
		$keywords = ktzplg_get_404_title(); 
	} else {
		$keywords = '';
	}
	$numbers = empty($number) ? 1 : $number;
	if ( $sources == 'ask' ) {
		return ktzplg_get_ask_video( $keywords, $numbers );
	} else {
		return ktzplg_get_bingss_video( $keywords, $numbers );
	}
}
add_shortcode('ktzagcplugin_video', 'ktzagcplugin_video_shortcode'); /* format [ktzagcplugin_video keyword="" source="" number=""] */

/* 
 * Spintax functions
 * @return spin_text $text
 */
function ktzplg_replace_spintext($text) {
    $text = ktzplg_spin($text[1]);
    $parts = explode('|', $text);
    return $parts[array_rand($parts)];
}
function ktzplg_spin($text) {
    return preg_replace_callback(
        '/\{(((?>[^\{\}]+)|(?R))*)\}/x',
        'ktzplg_replace_spintext',
        $text
    );
}

/* 
 * Spin text Shortcode Setup
 * @return ktzplg_spin
 */
function ktzplg_render_shortcode( $atts ) {
	extract( shortcode_atts( array(
      'text' => '' # text
      ), $atts ) );
	$texts = empty($text) ? '' : $text;
	return ktzplg_spin( $texts );
}
add_shortcode( 'ktzagcplugin_spin', 'ktzplg_render_shortcode' ); /* format [ktzagcplugin_spin]{phrase 1|phrase 2|phrase 3}[/ktzagcplugin_spin] */