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
* Register CSS on hook system
* add_action( 'init', 'ktz_register_css'); in init.php
*/
function ktz_register_css() {
	if( !is_admin() ) {
		wp_register_style( 'ktz-bootstrap-min',ktz_url . 'includes/bootstrap/css/bootstrap.min.css', array(), '1.0', 'screen, projection' );
		wp_register_style( 'ktz-video-min',ktz_url . 'includes/assets/video-js/video-js.min.css', array(), '1.0', 'all' );
		wp_register_style( 'ktz-main-css',ktz_url . 'style.css',array(), '1.0', 'all' );
		if( ot_get_option( 'ktz_styledefault' ) != '' ) { 
			$styledefault = '';
			if( ot_get_option('ktz_styledefault') ){
			$styledefault = ot_get_option('ktz_styledefault');
			}
		wp_register_style( 'ktz-default-css',ktz_url . 'includes/assets/css/' . $styledefault,array(), '1.0', 'screen' ); 
		}
	}
}

/*
* Enqueue CSS on hook system
* add_action( 'wp_enqueue_scripts', 'ktz_enqueue_css' ); in init.php
*/
function ktz_enqueue_css()  { 
	global $post;
	if( !is_admin() ) { 
		if( is_object($post) ) :
		$meta_values = get_post_custom($post->ID);
		endif;
        wp_enqueue_style( 'ktz-bootstrap-min' ); 
		if ( is_single() && has_post_format('video') ) :		
		wp_enqueue_style( 'ktz-video-min' );
		endif;
        wp_enqueue_style( 'ktz-main-css' );  	
        wp_enqueue_style( 'ktz-default-css' );  
	}
}  

/*
* Add stylish option in header and call via WP_HEAD
* add_action( 'wp_head', 'ktz_headcss' ); in init.php	
*/
if ( !function_exists('ktz_headcss') ) {
function ktz_headcss() { 
	global $post;
	/*
	* Background setting
	*/
	 if (isset($post->ID)) {
	 	$meta_values = get_post_custom($post->ID);
	 }
	 if( isset($meta_values['ktz_dynamicbg']) ){
			$ktz_mainbg = unserialize($meta_values['ktz_dynamicbg'][0]);
	 	if($ktz_mainbg['background-image'] =="" && $ktz_mainbg['background-color'] =="" ){
	 		$ktz_mainbg = ot_get_option( 'ktz_bodybg' );
	 	}
	 } else {
	 	$ktz_mainbg = ot_get_option( 'ktz_bodybg' );
	 }
	
	if ( !isset($ktz_mainbg['background-image']) || $ktz_mainbg['background-image'] == "" ){
	 	$ktz_mainbg_url = "";
	} else {
	 	$ktz_mainbg_url = "url('". $ktz_mainbg['background-image'] . "')";
	}
	 
	if ( !isset($ktz_mainbg['background-color']) || $ktz_mainbg['background-color'] == "" ){
	 	$ktz_mainbg['background-color'] = "#eee";
	}
	 
	if ( !isset($ktz_mainbg['background-attachment']) || $ktz_mainbg['background-attachment'] == "" ){
	 	$ktz_mainbg['background-attachment'] = "";
	}
	 
	if ( !isset($ktz_mainbg['background-position']) || $ktz_mainbg['background-position'] == "" ){
	 	$ktz_mainbg['background-position'] = "";
	}
	 
	if ( !isset($ktz_mainbg['background-repeat']) || $ktz_mainbg['background-repeat'] == "" ){
	 	$ktz_mainbg['background-repeat'] = "";
	}
	/*
	* Header setting
	*/
	$ktz_headerbg = ot_get_option( 'ktz_headerbg' );
	if ( !isset($ktz_headerbg['background-image']) || $ktz_headerbg['background-image'] == "" ){
	 	$ktz_headerbg_url = "";
	} else {
	 	$ktz_headerbg_url = "url('". $ktz_headerbg['background-image'] . "')";
	}
	 
	if ( !isset($ktz_headerbg['background-color']) || $ktz_headerbg['background-color'] == "" ){
	 	$ktz_headerbg['background-color'] = "#fff";
	}
	 
	if ( !isset($ktz_headerbg['background-attachment']) || $ktz_headerbg['background-attachment'] == "" ){
	 	$ktz_headerbg['background-attachment'] = "";
	}
	 
	if ( !isset($ktz_headerbg['background-position']) || $ktz_headerbg['background-position'] == "" ){
	 	$ktz_headerbg['background-position'] = "";
	}
	 
	if ( !isset($ktz_headerbg['background-repeat']) || $ktz_headerbg['background-repeat'] == "" ){
	 	$ktz_headerbg['background-repeat'] = "";
	}
	/*
	* Header squeeze setting
	*/
	$ktz_headerbg_squeeze = ot_get_option( 'ktz_headerbg_squeeze' );
	if ( !isset($ktz_headerbg_squeeze['background-image']) || $ktz_headerbg_squeeze['background-image'] == "" ){
	 	$ktz_headerbg_squeeze_url = "";
	} else {
	 	$ktz_headerbg_squeeze_url = "url('". $ktz_headerbg_squeeze['background-image'] . "')";
	}
	 
	if ( !isset($ktz_headerbg_squeeze['background-color']) || $ktz_headerbg_squeeze['background-color'] == "" ){
	 	$ktz_headerbg_squeeze['background-color'] = "#fff";
	}
	 
	if ( !isset($ktz_headerbg_squeeze['background-attachment']) || $ktz_headerbg_squeeze['background-attachment'] == "" ){
	 	$ktz_headerbg_squeeze['background-attachment'] = "";
	}
	 
	if ( !isset($ktz_headerbg_squeeze['background-position']) || $ktz_headerbg_squeeze['background-position'] == "" ){
	 	$ktz_headerbg_squeeze['background-position'] = "";
	}
	 
	if ( !isset($ktz_headerbg_squeeze['background-repeat']) || $ktz_headerbg_squeeze['background-repeat'] == "" ){
	 	$ktz_headerbg_squeeze['background-repeat'] = "";
	}
	/*
	* Body Font setting
	*/
	$ktz_mainfont = ot_get_option( 'ktz_body_font' );
	if ( !isset($ktz_mainfont['font-family']) || $ktz_mainfont['font-family'] == "" ){
	 	$ktz_mainfont['font-family'] = "Open Sans:light,lightitalic,regular,regularitalic,600,600italic,bold,bolditalic,800,800italic";
	}
	 
	if ( !isset($ktz_mainfont['font-color']) || $ktz_mainfont['font-color'] == "" ){
	 	$ktz_mainfont['font-color'] = "#222";
	}
	 
	if ( !isset($ktz_mainfont['font-size']) || $ktz_mainfont['font-size'] == "" ){
	 	$ktz_mainfont['font-size'] = "14px";
	}
	 
	if ( !isset($ktz_mainfont['font-style']) || $ktz_mainfont['font-style'] == "" ){
	 	$ktz_mainfont['font-style'] = "normal";
	}
	/*
	* Heading Font setting
	*/
	$ktz_headingfont = ot_get_option( 'ktz_heading_font' );
	if ( !isset($ktz_headingfont['font-family']) || $ktz_headingfont['font-family'] == "" ){
	 	$ktz_headingfont['font-family'] = "Open Sans:light,lightitalic,regular,regularitalic,600,600italic,bold,bolditalic,800,800italic";
	}
	 
	if ( !isset($ktz_headingfont['font-color']) || $ktz_headingfont['font-color'] == "" ){
	 	$ktz_headingfont['font-color'] = "#2b2b2b";
	}
	 
	if ( !isset($ktz_headingfont['font-style']) || $ktz_headingfont['font-style'] == "" ){
	 	$ktz_headingfont['font-style'] = "normal";
	}
	$getheadinggfont = '';
	$getbodygfont = '';
	if (! empty ( $ktz_headingfont['font-family'] ) ) { 
	$getheadinggfont = preg_split( '/:/',  $ktz_headingfont['font-family'] );
	$getheadinggfont = '"' . $getheadinggfont[0] . '",';
	}
	if( ! empty ( $ktz_mainfont['font-family'] ) ){
	$getbodygfont = preg_split( '/:/',  $ktz_mainfont['font-family'] );
	$getbodygfont = '"' . $getbodygfont[0] . '",';
	}
	echo '<style type="text/css" media="screen">';
	// body
	echo 'body{';
		echo 'background:' . $ktz_mainbg['background-color'] . ' ' . $ktz_mainbg_url . ' ' . $ktz_mainbg['background-repeat'] . ' ' .  $ktz_mainbg['background-position'] . ' ' .  $ktz_mainbg['background-attachment'] . ';'; 
		echo 'font-family:' . $getbodygfont . 'sans-serif;';
		echo 'font-size:' . $ktz_mainfont['font-size'] . ';';
		echo 'font-style:' . $ktz_mainfont['font-style'] . ';';
		echo 'color:' . $ktz_mainfont['font-color'] . ';';
	echo '}';
	// Header
	echo '.ktz-mainheader{';
		echo 'background:' . $ktz_headerbg['background-color'] . ' ' . $ktz_headerbg_url . ' ' . $ktz_headerbg['background-repeat'] . ' ' .  $ktz_headerbg['background-position'] . ' ' .  $ktz_headerbg['background-attachment'] . ';'; 
	echo '}';
	if ( ot_get_option('ktz_gen_layout') == 'box' ) : 
	// Allwrap
	echo '.ktz-allwrap{margin:20px auto 40px auto;width:100%;max-width:760px;}';
	echo '@media only screen and (max-width: 992px) {';
	echo '.ktz-allwrap {';
			echo 'width:90%;';
	echo '}';
	echo '}';
	endif;
	// Logo color
	echo '.ktz-logo h1.homeblogtit a,';
	echo '.ktz-logo h1.homeblogtit a:visited,';
	echo '.ktz-logo h1.homeblogtit a:hover,';
	echo '.ktz-logo .singleblogtit a,';
	echo '.ktz-logo .singleblogtit a:hover,';
	echo '.ktz-logo .singleblogtit a:active,';
	echo '.ktz-logo .singleblogtit a:focus,';
	echo '.ktz-logo .singleblogtit a:visited {';
		echo 'color:' . ot_get_option('ktz_colorlogo');
	echo '}';
	echo '.ktz-logo .desc {';
		echo 'color:' . ot_get_option('ktz_colorlogodesc');
	echo '}';
	// Heading font family, style and color
	echo 'h1,h2,h3,h4,h5,h6,.ktz-logo div.singleblogtit{';
		echo 'font-family:' . $getheadinggfont . ' helvetica;';
		echo 'font-style:' . $ktz_headingfont['font-style'] . ';';
		echo 'color:' . $ktz_headingfont['font-color'] . ';';
	echo '}';
	// color
	echo 'a:hover,';
	echo 'a:focus,';
	echo 'a:active,';
	echo '#breadcrumbs-wrap a:hover,';
	echo '#breadcrumbs-wrap a:focus,';
	echo 'a#cancel-comment-reply-link:hover{';
		echo 'color:' . ot_get_option('ktz_colorscheme') . ';';
	echo '}';
	// Background
	echo '.entry-content input[type=submit],';
	echo '.page-link a,';
	echo 'input#comment-submit,';
	echo '.wpcf7 input.wpcf7-submit[type="submit"],';
	echo '.bbp_widget_login .bbp-login-form button,';
	echo '#wp-calendar tbody td:hover,';
	echo '#wp-calendar tbody td:hover a,';
	echo '.ktz-bbpsearch button,';
	echo 'a.readmore-buysingle,';
	echo 'input#comment-submit,';
	echo '.widget_feedburner,';
	echo '.ktz-readmore,';
	echo '.ktz-prevnext a{';
		echo 'background:' .  ot_get_option('ktz_colorscheme') . ';';
	echo '}';
	// Background default
	echo '.page-link a:hover{';
		echo 'background:#4c4c4c;color:#ffffff;';
	echo '}';
	//Border color
	echo '.ktz-allwrap.wrap-squeeze,';
	echo '.tab-comment-wrap .nav-tabs>li.active>a,';
	echo '.tab-comment-wrap .nav-tabs>li.active>a:focus,';
	echo '.tab-comment-wrap .nav-tabs>li.active>a:hover,';
	echo '.tab-comment-wrap .nav-tabs>li>a:hover{';
		echo 'border-color:' . ot_get_option('ktz_colorscheme') . ';';
	echo '}';
	// Background-color
	echo '.ktz_thumbnail a.link_thumbnail,';
	echo '.owl-theme .owl-controls .owl-buttons .owl-prev span,';
	echo '.owl-theme .owl-controls .owl-buttons .owl-next span,';
	echo '.pagination > .active > a,';
	echo '.pagination > .active > span,';
	echo '.pagination > .active > a:hover,';
	echo '.pagination > .active > span:hover,';
	echo '.pagination > .active > a:focus,';
	echo '.pagination > .active > span:focus {';
		echo 'background-color:' .  ot_get_option('ktz_colorscheme') . ';';
	echo '}';
	// Border color
	echo '.pagination > .active > a,';
	echo '.pagination > .active > span,';
	echo '.pagination > .active > a:hover,';
	echo '.pagination > .active > span:hover,';
	echo '.pagination > .active > a:focus,';
	echo '.pagination > .active > span:focus{';
		echo 'border-color:' .  ot_get_option('ktz_colorscheme') . ' ' . ot_get_option('ktz_colorscheme') . ' ' . ot_get_option('ktz_colorscheme') . ' transparent;';
	echo '}';
	echo '.ktz_thumbnail.ktz_thumbnail_gallery a.link_thumbnail {';
		echo 'background-color: transparent;';
	echo '}';
	$categories_get = ot_get_option( 'ktz_categories', array() );
	if ($categories_get){
	foreach ($categories_get as $category) { 
		$cat_array = get_category($category['category']);
		if ( !isset($category['background']['background-image']) || $category['background']['background-image'] == "" ){
			$bg_url = "";
		} else {
			$bg_url = "url('". $category['background']['background-image'] . "') ";
		}
		if ( !isset($category['background']['background-color']) || $category['background']['background-color'] == "" ){
			$bg_col = "";
		} else {
			$bg_col = $category['background']['background-color'] . " ";
		}
		if ( !isset($category['background']['background-repeat']) || $category['background']['background-repeat'] == "" ){
			$bg_rep = "";
		} else {
			$bg_rep = $category['background']['background-repeat'] . " ";
		}
		if ( !isset($category['background']['background-position']) || $category['background']['background-position'] == "" ){
			$bg_pos = "";
		} else {
			$bg_pos = $category['background']['background-position'] . " ";
		}
		if ( !isset($category['background']['background-attachment']) || $category['background']['background-attachment'] == "" ){
			$bg_att = "";
		} else {
			$bg_att = $category['background']['background-attachment'] . " ";
		}
		update_option('category_icon_' . $category['category'] , $category['icon']);

	if ( ! is_wp_error( $cat_array ) ) :
	if ( is_category( $cat_array->slug ) ) :
	echo '.category-' . $cat_array->slug . ' .page-link a{';
		echo 'background:' . $category['color'] . ';';
	echo '}';
	echo '.category-' . $cat_array->slug . ' .page-link a:hover	{';
		echo 'background:#4c4c4c;color:#ffffff;';
	echo '}';
	echo '.category-' . $cat_array->slug . ' .ktz-readmore,';
	echo '.category-' . $cat_array->slug . ' .ktz_thumbnail a.link_thumbnail,';
	echo '.category-' . $cat_array->slug . ' #ktz-carousel .btn-primary,';
	echo '.category-' . $cat_array->slug . ' .pagination > .active > a,';
	echo '.category-' . $cat_array->slug . ' .pagination > .active > span,';
	echo '.category-' . $cat_array->slug . ' .pagination > .active > a:hover,';
	echo '.category-' . $cat_array->slug . ' .pagination > .active > span:hover,';
	echo '.category-' . $cat_array->slug . ' .pagination > .active > a:focus,';
	echo '.category-' . $cat_array->slug . ' .pagination > .active > span:focus,';
	echo '.category-' . $cat_array->slug . ' .widget_feedburner,';
	echo '.category-' . $cat_array->slug . ' .owl-theme .owl-controls .owl-buttons .owl-prev span,';
	echo '.category-' . $cat_array->slug . ' .owl-theme .owl-controls .owl-buttons .owl-next span{';
		echo 'background-color:' .  $category['color'] . ';';
	echo '}';
	echo '.category-' . $cat_array->slug . ' .pagination > .active > a,';
	echo '.category-' . $cat_array->slug . ' .pagination > .active > span,';
	echo '.category-' . $cat_array->slug . ' .pagination > .active > a:hover,';
	echo '.category-' . $cat_array->slug . ' .pagination > .active > span:hover,';
	echo '.category-' . $cat_array->slug . ' .pagination > .active > a:focus,';
	echo '.category-' . $cat_array->slug . ' .pagination > .active > span:focus{';
		echo 'border-color:' .  $category['color'] . ';';
	echo '}';
	echo '.category-' . $cat_array->slug . ' a:hover,';
	echo '.category-' . $cat_array->slug . ' a:focus,'; 
	echo '.category-' . $cat_array->slug . ' a:active {';
		echo 'color:' .  $category['color'] . ';'; 
	echo '}';
	echo 'body.category-' .  $cat_array->slug . '{';
	    echo 'background:' .  $bg_col . ''.$bg_url.'' . $bg_rep . '' .  $bg_pos . '' .  $bg_att . ';';
	echo '}';
	else :
		echo '';
	endif;
	endif; 		
		}
	}
	echo '</style>';
	}
}

/**
 * Get Google Font stylesheets
 * Includes the Google Font stylesheets into the head section of the current page
 */		
function ktz_google_font_link(){
	/*
	 * default_theme_fonts from includes/admin/googlefont/functions.php
	 */
	global $default_theme_fonts;
	if (!is_admin()) {
		$getheadinggfont = ot_get_option( 'ktz_heading_font' );	
		$getbodygfont = ot_get_option( 'ktz_body_font' );		
		
		$getheadinggfont_arr = '';
		if( isset($getheadinggfont['font-family']) ){
			$getheadinggfont_arr = $getheadinggfont['font-family'];
			$getheadinggfont_arr = str_replace(' ', '+', $getheadinggfont_arr);
		}
		$getbodygfont_arr = '';
		if( isset($getbodygfont['font-family'])  ){
			$getbodygfont_arr = $getbodygfont['font-family'];
			$getbodygfont_arr = str_replace(' ', '+', $getbodygfont_arr);
		}
		
		if (! empty ( $getheadinggfont['font-family'] ) && ! empty ( $getbodygfont['font-family'] ) ) {
			echo "<link href='http://fonts.googleapis.com/css?family=" . $getheadinggfont_arr . "|" . $getbodygfont_arr . "' rel='stylesheet' type='text/css'>";
		} elseif (! empty ( $getheadinggfont['font-family'] ) ) {
			echo "<link href='http://fonts.googleapis.com/css?family=" . $getheadinggfont_arr . "|Open+Sans:light,lightitalic,regular,regularitalic,600,600italic,bold,bolditalic,800,800italic' rel='stylesheet' type='text/css'>";
		} elseif (! empty ( $getbodygfont['font-family'] ) ) {
			echo "<link href='http://fonts.googleapis.com/css?family=Open+Sans:light,lightitalic,regular,regularitalic,600,600italic,bold,bolditalic,800,800italic|" . $getbodygfont_arr . "' rel='stylesheet' type='text/css'>";
		} else {
			echo "<link href='http://fonts.googleapis.com/css?family=Open+Sans:light,lightitalic,regular,regularitalic,600,600italic,bold,bolditalic,800,800italic' rel='stylesheet' type='text/css'>";
		}
	}				
}

?>