<?php
/*
/*-----------------------------------------------*/
/* KENTOOZ THEMES INIT
/* Website    : http://www.kentooz.com
/* The Author : Gian Mokhammad Ramadhan (http://www.gianmr.com)
/* Twitter    : http://www.twitter.com/g14nnakal 
/* Facebook   : http://www.facebook.com/gianmr
/*-----------------------------------------------*/

/*
* Add other script
*/
require_once(TEMPLATEPATH . '/includes/functions/BFI_Thumb.php');
// Change the upload subdirectory to wp-content/uploads/other_dir
@define( BFITHUMB_UPLOAD_DIR, 'ktz' ); 
 
class KENTOOZ {
	/* 
	* LOAD ALL function in kentooz framework
	* This loader function call in functions.php in root theme.
	*/
	public static function init() {
		self::ktz_definitions();
		self::ktz_functions();
		self::ktz_add_actions();
		self::ktz_filters();
		self::ktz_locale();
	}

	/* 
	* Define URL
	*/
	public static function ktz_definitions() {
		/* 
		* Get slug for kentooz framework look @ define( 'ktz_theme_textdomain', ktz_theme_slug );
		*/
		define( 'ktz_theme_slug', get_template() );
		/* 
		* Retrieves the absolute path to the directory of the current theme, without the trailing slash.
		* ktz or kentooz use directory /includes for all function
		*/	
		define( 'ktz_dir', get_template_directory() . '/' );
		define( 'ktz_inc', get_template_directory() . '/includes/' );
		/* 
		* Retrieve template directory URI for the current theme. Checks for SSL.
		* Note: Does not return a trailing slash following the directory address. 
		* This can use path for JS, stylesheet, or image
		* ktz or kentooz use directory /includes for all function
		*/	
		define( 'ktz_url', get_template_directory_uri() . '/' );
		define( 'ktz_styleinc', get_template_directory_uri() . '/includes/' );
		/* 
		* Get locale or translating for kentooz framework
		*/
		define( 'ktz_theme_textdomain', ktz_theme_slug );
	}
		
	/* 
	* Require once php file in kentooz framework
	*/
	public static function ktz_functions() {
		/**
		* Required: include OptionTree kentooz setting admin and meta boxes.
		*/
		require_once(ktz_inc . 'admin/theme-options.php');
		require_once(ktz_inc . 'admin/meta-boxes.php');
		/**
		* Required: include OptionTree kentooz google font.
		* Require Google API Key
		*/
		require_once(ktz_inc . 'admin/googlefont/functions.php');
		require_once(ktz_inc . 'admin/googlefont/ot-google-fonts.php');
		/**
		* Required: include OptionTree kentooz select functions.
		*/
		require_once(ktz_inc . 'admin/select/googlefont.php');
		require_once(ktz_inc . 'admin/select/optionselect.php');
		/**
		* Required: include widget function for kentooz framework
		*/
		require_once(ktz_inc . 'widget/widget.php');
		/**
		* Required: include shortcode function for kentooz framework
		*/
		require_once(ktz_inc . 'shortcodes/shortcode.php');
		/**
		* Required: include all function themes for kentooz framework
		*/
		require_once(ktz_inc . 'functions/_agc_ktz.php');
		require_once(ktz_inc . 'functions/_authorbox_ktz.php');
		require_once(ktz_inc . 'functions/_banner_ktz.php');
		require_once(ktz_inc . 'functions/_comment_ktz.php');
		require_once(ktz_inc . 'functions/_content_ktz.php');
		require_once(ktz_inc . 'functions/_core_ktz.php');
		require_once(ktz_inc . 'functions/_css_ktz.php');
		require_once(ktz_inc . 'functions/_footer_ktz.php');
		require_once(ktz_inc . 'functions/_head_ktz.php');
		require_once(ktz_inc . 'functions/_js_ktz.php');
		require_once(ktz_inc . 'functions/_logo_ktz.php');
		require_once(ktz_inc . 'functions/_loop_ktz.php');
		require_once(ktz_inc . 'functions/_navigation_ktz.php');
		require_once(ktz_inc . 'functions/_rating_ktz.php');
		require_once(ktz_inc . 'functions/_related_ktz.php');
		require_once(ktz_inc . 'functions/_social_ktz.php');
		require_once(ktz_inc . 'functions/_sidebar_ktz.php');
		require_once(ktz_inc . 'functions/_slider_ktz.php');
		require_once(ktz_inc . 'functions/_thumbnail_ktz.php');
		require_once(ktz_inc . 'functions/_video_ktz.php');
		require_once(ktz_inc . 'functions/wp_bootstrap_navwalker.php');
		/**
		* Required: HOOK function kentooz
		*/
		require_once(ktz_inc . 'functions/hook.php');
		/**
		* Required: Update kentooz notification
		*/
		require_once(ktz_inc . 'functions/update_notifier.php');
		
	}	
	
	/* 
	* add actions for kentooz hook
	*/
	public static function ktz_add_actions() {
		/**
		* add action ajax for set cookie for content locker and ajax rate
		*/
		add_action('wp_ajax_ktz_stars_rating','ktz_handle_vote');
		add_action('wp_ajax_nopriv_ktz_stars_rating','ktz_handle_vote');
		add_action('wp_ajax_ktz_setcookie', 'ktz_setcookie');
		add_action('wp_ajax_nopriv_ktz_setcookie', 'ktz_setcookie');
		/**
		* after setup menu, kentooz will create table for ajax rate
		*/
		add_action( 'after_switch_theme', 'ktzcreate_table' );
		/**
		* add action for modified user profile
		*/
		add_action( 'show_user_profile', 'ktz_show_extra_profile_fields' );
		add_action( 'edit_user_profile', 'ktz_show_extra_profile_fields' );
		add_action( 'personal_options_update', 'ktz_save_extra_profile_fields' );
		add_action( 'edit_user_profile_update', 'ktz_save_extra_profile_fields' );
		/**
		* After setup themes use this action
		* Functions @ includes/function/_core_ktz.php
		*/
		add_action(	'after_setup_theme', 'ktz_setup' );
		/**
		* After meta and other elemant in <head></head>
		* Functions @ includes/function/_head_ktz.php
		*/
		add_action( 'wp_head', 'ktz_google_font_link' );
		add_action( 'wp_head', 'ktz_headelement' );
		add_action( 'wp_head', 'ktz_headscript' );
		/**
		* After css in <head></head>
		* Functions @ includes/function/_css_ktz.php
		*/
		add_action( 'wp_head', 'ktz_headcss' );		
		/**
		* Add js in footer
		* Functions @ includes/functions/_js_ktz.php
		*/	
		add_action( 'wp_footer', 'ktz_require_videojs' );
		add_action( 'wp_footer', 'ktz_mustread_js' );
		add_action( 'wp_footer', 'ktz_parseFBML' );
		
		/**
		* Register JS and path js
		* Functions @ includes/functions/_js_ktz.php
		*/	
		add_action( 'init', 'ktz_register_jascripts' );
		add_action( 'wp_enqueue_scripts','ktz_jsscripts' );
		
		add_action( 'init', 'ktz_register_css');
		add_action( 'wp_enqueue_scripts', 'ktz_enqueue_css' );  
		add_action( 'widgets_init', 'sidebar_widget_init' );
		add_action( 'widgets_init', 'ktz_widget_init' );
		/**
		* Add default comment form wordpress
		* Functions @ includes/function/_content_ktz.php
		*/
		add_action( 'do_ktz_comment_template', 'ktz_comments_template' );
		/**
		* Add facebook comment form wordpress
		* Functions @ includes/function/_content_ktz.php
		*/
		add_action( 'do_ktz_comment_facebook', 'ktz_comments_facebook' );
		// HEADER hook action
		add_action( 'do_ktz_topheader', 'ktz_topheader' );
		add_action( 'do_ktz_logo', 'ktz_headlogo' );
		add_action( 'do_ktz_logo_squeeze', 'ktz_headlogo_squeeze' );
		add_action( 'do_ktz_menu_squeeze', 'ktz_thirdmenu' );
		// FOOTER hook action
		add_action( 'do_ktz_mainfooter', 'ktz_mainfooter' );
		add_action( 'do_ktz_subfooter', 'ktz_subfooter' );
		add_action( 'do_ktz_subfooter', 'ktz_mustread_content' );
		add_action( 'do_ktz_subfooter_squeeze', 'ktz_subfooter_squeeze' );
		/**
		* Add banner in archive page after first post
		* Functions @ includes/function/_content_ktz.php
		*/
		add_action( 'do_ktz_footerbanner', 'ktz_footerbanner' );
		/**
		* Add banner in header all page
		* Functions @ includes/function/_content_ktz.php
		*/
		add_action( 'do_ktz_headbanner', 'ktz_headbanner' );
		/**
		* Add banner in header after menu all page
		* Functions @ includes/function/_content_ktz.php
		*/
		add_action( 'do_ktz_aftermenubanner', 'ktz_aftermenubanner' );
		add_action( 'do_ktz_sideslide_banner', 'ktz_sideslide_banner' );
		// OTHER hook action
		add_action( 'do_ktz_topsearch', 'ktz_topsearch' );
		add_action( 'do_ktz_topticker_feat', 'ktz_topticker_feat' );
		add_action( 'do_ktz_header_sn', 'ktz_sn' );
		add_action( 'do_ktz_secondmenu_header', 'ktz_secondmenu' );
		add_action( 'do_ktz_topmenu', 'ktz_topmenu' );
		add_action( 'do_ktz_footermenu', 'ktz_fourthmenu' );
		add_action( 'do_ktz_nivo', 'ktz_feat_nivoslider' );
		add_action( 'do_ktz_after_header', 'ktz_crumbs' );
		add_action( 'do_ktz_content_title', 'ktz_posted_title' );
		add_action( 'do_ktz_content_title_h2', 'ktz_posted_title_h2' );
		add_action( 'do_ktz_content_meta_cat', 'ktz_categories' );
		add_action( 'do_ktz_content_meta', 'ktz_author_by' );		
		add_action( 'do_ktz_content_meta', 'ktz_posted_on' );	
		add_action( 'do_ktz_content_single_meta', 'ktz_author_by' );
		add_action( 'do_ktz_content_single_meta', 'ktz_posted_on' );
		add_action( 'do_ktz_content', 'ktz_content' );	
		add_action( 'do_ktz_content', 'ktz_link_pages' );
		/**
		* Add banner before title in single page
		* Functions @ includes/function/_content_ktz.php
		*/
		add_action( 'do_ktz_singleheadban', 'ktz_ban46860_singlehead' );
		/**
		* Add banner after content in single page
		* Functions @ includes/function/_content_ktz.php
		*/
		add_action( 'ktz_ban46860_singlefoot', 'ktz_ban46860_singlefoot' );
		/**
		* Add share post in single page
		* Functions @ includes/function/_content_ktz.php
		*/
		add_action( 'do_ktz_singlecontent', 'ktz_share_single' );
		/**
		* Add author box in single page
		* Functions @ includes/function/_content_ktz.php
		*/
		add_action( 'do_ktz_singlecontent_after', 'ktz_author_box' );	
		/**
		* Display AGC in single page you can see related search
		* Functions @ includes/function/_core_ktz.php
		*/
		add_action( 'do_ktz_single_agc', 'ktz_get_AGC_single' );
		/**
		* Add Action for all single product
		*/
		add_action( 'do_ktz_singleproduct', 'ktz_content' );	
		add_action( 'do_ktz_singleproduct', 'ktz_link_pages' );
		/**
		* Add number related post in single page
		* Functions @ includes/function/_content_ktz.php
		*/
		add_action( 'do_ktz_single_relpost', 'ktz_relpost' );
		/**
		* Add number navigation or default navigation
		* Functions @ includes/function/_content_ktz.php
		*/
		add_action( 'do_ktz_navigation', 'ktz_navigation' );
		add_action( 'do_ktz_before_content', 'ktz_feature_140' );
		add_action( 'do_ktz_before_firstcontent', 'ktz_feature_220' );
		add_action( 'do_ktz_before_bigcontent', 'ktz_feature_620' );
		add_action( 'do_ktz_thumbfull', 'ktz_thumbfull' );
		/**
		* Pretty permalink for search page if permalink active
		* Functions @ includes/function/_core_ktz.php
		*/
		add_action( 'template_redirect', 'ktz_search_pretty_permalinks' );
		/**
		* Filter add new custom field in menus
		* Functions @ includes/function/_core_ktz.php
		*/
		add_action( 'wp_update_nav_menu_item', 'ktz_update_custom_nav_fields', 10, 3 );
		add_filter('bbp_before_get_breadcrumb_parse_args', 'ktz_custom_bbp_breadcrumb' );
	}
	public static function ktz_filters() {	
		/**
		* Filter get_avatar and change avatar class
		* Functions @ includes/function/_core_ktz.php
		*/
		add_filter( 'get_avatar', 'ktz_avatar_css' );
		add_filter( 'comment_form_default_fields','ktz_com_fields' );
		add_filter( 'comment_form_field_comment','ktz_com_fields_textarea' );
		
		/**
		* Filter tag and change style inline in default tag
		* Functions @ includes/function/_core_ktz.php
		*/
		add_filter( 'widget_tag_cloud_args', 'ktz_tag_cloud' );
		/**
		* Filter widget_text and Disabling auto format and can add shortcode in text widget
		* Functions @ includes/function/_core_ktz.php
		*/
		add_filter( 'widget_text', 'do_shortcode' );
		/**
		* Filter language_attributes
		* Functions @ includes/function/_head_ktz.php
		*/
		add_filter( 'language_attributes', 'ktz_opengraph_doctype' );
		/**
		* Optional: set 'ot_show_pages' filter to false.
		* This will hide the settings & documentation pages.
		*/
		add_filter( 'ot_show_options_ui', '__return_false' );
		add_filter( 'ot_show_docs', '__return_false' );
		add_filter( 'ot_show_pages', '__return_false' );	
		
		/**
		* Filter comment_form_defaults
		* Functions @ includes/function/_core_ktz.php
		*/
		add_filter('comment_form_defaults','ktz_comment_text');

		/**
		* Optional: set 'ot_show_new_layout' filter to false.
		* This will hide the "New Layout" section on the Theme Options page.
		*/
		add_filter( 'ot_show_new_layout', '__return_false' );

		/**
		* Required: set 'ot_theme_mode' filter to true.
		*/
		if (!class_exists('OT_Loader')) {
		add_filter('ot_theme_mode', '__return_true');
		/**
		* Required: include OptionTree.
		* http://wordpress.org/extend/plugins/option-tree/
		*/
		require_once(ktz_inc . 'admin/ot-loader.php');
		}
		/**
		* Filter add new custom field in menus
		* Functions @ includes/function/_core_ktz.php
		*/
		add_filter( 'wp_setup_nav_menu_item', 'ktz_add_custom_nav_fields' );
		add_filter( 'wp_edit_nav_menu_walker', 'ktz_edit_walker', 10, 2 );
		/**
		* Filter script for better cache performance
		* Functions @ includes/function/_core_ktz.php
		*/
		add_filter( 'script_loader_src', 'ktz_remove_script_version', 15, 1 );
		add_filter( 'style_loader_src', 'ktz_remove_script_version', 15, 1 );
		/**
		* Filter css with name category. Yeahhh!!!
		* Function in includes/functions/function_head.php
		* Must have 10, 2 or function item error items.. ;)
		*/
		add_filter( 'nav_menu_css_class', 'ktz_catnav_class', 10, 2 );
		/**
		* Remove Filter default format the_content
		*/
		remove_filter( 'the_content', 'wptexturize' );
		add_filter( 'wp_title', 'ktz_dynamic_title', 10, 2 );
	}
	public static function ktz_locale() {
		/** 
		* Get locale languange
		*/
		$locale = get_locale();
		load_theme_textdomain( ktz_theme_textdomain, ktz_dir . 'languages' );
		$locale_file = ktz_dir . "languages/$locale.php";
		if ( is_readable( $locale_file ) )
			require_once( $locale_file );
	}
}

?>