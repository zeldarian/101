<?php
/*
Plugin Name: WP Freshstart v2
Plugin URI: http://wpfreshstart.com
Description: Quickly get rid of default wordpress settings, posts, pages, comments, create must-have pages and install plugins for your site with ONE CLICK. Make your site SEO friendly and prevent spam.
Version:2.0
Author: Ankur Shukla
Author URI: http://www.ankurshukla.com
*/
ob_start();
error_reporting(0);
register_activation_hook( __FILE__,'WS_db_create');
define ('HB_SU_PATH',plugin_dir_url( __FILE__ )); 
  /*******************/
  add_action( 'admin_enqueue_scripts', 'hsload_admin_things' );
function hsload_admin_things() {
     wp_enqueue_script('media-upload');
		wp_enqueue_script('thickbox');
		wp_enqueue_script('media');  
		wp_enqueue_script('wptuts-upload'); 
}
/*****************/
add_action('init','hs_enqueue_style');
function hs_enqueue_style()   
	{
   wp_enqueue_style('thickbox');
    }
/*******************add-menu*********************/ 
add_action('init','hs_include_files');
function hs_include_files()
{
require('hs_activation.php');
}
 /***************create-database*************************/	
  function WS_db_create()
  { 
  
  }
 /********************** Initialize class ***********************/
add_action('wp_ajax_hs_post_action','hs_post_action');
add_action('wp_ajax_nopriv_hs_post_action','hs_post_action');
function hs_post_action()
{ 
$hs_post=$_POST['hs_post'];
/***************************/
  	global $wpdb;
	if($hs_post=='checked')
	{ 
        //Delete Posts
		$args = array( 'posts_per_page' =>-1,'post_type'=> 'post');
		$posts = get_posts( $args );
		foreach($posts as $po)
		{ 
			wp_delete_post($po->ID,true);
		}
	echo "done1";	
	}
	die();
}
/********************** Initialize class ***********************/
add_action('wp_ajax_hs_all_page_action','hs_all_page_action');
add_action('wp_ajax_nopriv_hs_all_page_action','hs_all_page_action');
function hs_all_page_action()
{ 
     $hs_all_page=$_POST['hs_all_page'];
	 global $wpdb;
	 if($hs_all_page=='checked')
	{
	    //Delete Pages 
		$pages=get_pages();
		foreach($pages as $pa)
		{
			wp_delete_post($pa->ID,true);
		}
	echo "done2";
	}
	die();
}
/********************** Initialize class ***********************/
add_action('wp_ajax_hs_all_comment_action','hs_all_comment_action');
add_action('wp_ajax_nopriv_hs_all_comment_action','hs_all_comment_action');
function hs_all_comment_action()
{ 
      $hs_all_comment=$_POST['hs_all_comment'];
	   global $wpdb;
	  if($hs_all_comment=='checked')
	{
	    //Delete Comments
		//$defaults = array('status' => 'hold');
		$comments=get_comments();
		foreach($comments as $co)
		{
			wp_delete_comment($co->comment_ID,true);
			
		}
	echo "done3";	
	}
	die();
}
/********************** Initialize class ***********************/
add_action('wp_ajax_hs_create_abpages_action','hs_create_abpages_action');
add_action('wp_ajax_nopriv_hs_create_abpages_action','hs_create_abpages_action');
function hs_create_abpages_action()
{ 
global $post;
     /*************************/
    $hs_create_about=$_POST['hs_create_about'];
	$chkpage = get_page_by_title('About');
	/**********************/
	 if($hs_create_about=='checked')
	{
	   if(empty($chkpage))
	   {
	  global $user_ID;
	   if($_POST['create_field1']){
$content=file_get_contents(HB_SU_PATH.'pages/about1.txt');
}
else 
{
$content=file_get_contents(HB_SU_PATH.'pages/about.txt');
}
$content=str_replace('[site_name]',get_bloginfo('name'),$content);
$content=str_replace('[site_url]',get_bloginfo('wpurl'),$content);
$content=str_replace('[site_description]',get_bloginfo('description'),$content);
$content=str_replace('[admin_email]',get_bloginfo('admin_email'),$content);

// For the about page only, replace 2 fields;

			$content=str_replace('[field1]',$_POST['create_field1'],$content);
			$content=str_replace('[field2]',$_POST['create_field2'],$content);
        $page['post_type']    = 'page';
		$page['post_content'] = $content;
		$page['post_parent']  = 0;
		$page['post_author']  = $user_ID;
		$page['post_status']  = 'publish';
		$page['post_title']   = 'About';
		$page = apply_filters('yourplugin_add_new_page', $page, 'teams');
		$pageid = wp_insert_post ($page);
		if ($pageid == 0) { echo "Add About Page Failed"; }
	echo "done4";
	   }
	}
	die();
}
/********************** Initialize class ***********************/
add_action('wp_ajax_hs_create_prpages_action','hs_create_prpages_action');
add_action('wp_ajax_nopriv_hs_create_prpages_action','hs_create_prpages_action');
function hs_create_prpages_action()
{ global $post;
     /*************************/
   $hs_create_privacy=$_POST['hs_create_privacy'];
	/**********************/
	$chkpage = get_page_by_title('Privacy Policy');
	 if($hs_create_privacy=='checked')
	{   if(empty($chkpage))
	   {
	     global $user_ID;
		 $content=file_get_contents(HB_SU_PATH.'pages/privacy.txt');
		 $content=str_replace('[site_name]',get_bloginfo('name'),$content);
			$content=str_replace('[site_url]',get_bloginfo('wpurl'),$content);
			$content=str_replace('[site_description]',get_bloginfo('description'),$content);
			$content=str_replace('[admin_email]',get_bloginfo('admin_email'),$content);
        $page['post_type']    = 'page';
		$page['post_content'] = $content;
		$page['post_parent']  = 0;
		$page['post_author']  = $user_ID;
		$page['post_status']  = 'publish';
		$page['post_title']   = 'Privacy Policy';
		$page = apply_filters('yourplugin_add_new_page', $page, 'teams');
		$pageid = wp_insert_post ($page);
		if ($pageid == 0) { echo "Add Privacy Policy Failed"; }
	echo "done5";
	   }
	}
	die();
}
/********************** Initialize class ***********************/
add_action('wp_ajax_hs_create_erpages_action','hs_create_erpages_action');
add_action('wp_ajax_nopriv_hs_create_erpages_action','hs_create_erpages_action');
function hs_create_erpages_action()
{ global $post;
     /*************************/
   $hs_create_earnings=$_POST['hs_create_earnings'];
	/**********************/
	$chkpage = get_page_by_title('Earnings Disclaimer');
	if($hs_create_earnings=='checked')
	{    
	    if(empty($chkpage))
	   {
	     global $user_ID;
		 $content=file_get_contents(HB_SU_PATH.'pages/earnings.txt');
		 $content=str_replace('[site_name]',get_bloginfo('name'),$content);
			$content=str_replace('[site_url]',get_bloginfo('wpurl'),$content);
			$content=str_replace('[site_description]',get_bloginfo('description'),$content);
			$content=str_replace('[admin_email]',get_bloginfo('admin_email'),$content);
        $page['post_type']    = 'page';
		$page['post_content'] = $content;
		$page['post_parent']  = 0;
		$page['post_author']  = $user_ID;
		$page['post_status']  = 'publish';
		$page['post_title']   = 'Earnings Disclaimer';
		$page = apply_filters('yourplugin_add_new_page', $page, 'teams');
		$pageid = wp_insert_post ($page);
		if ($pageid == 0) { echo "Add Earnings Disclaimer Failed"; }
	echo "done6";
	    }
	}
    die();
}
/********************** Initialize class ***********************/
add_action('wp_ajax_hs_create_cupages_action','hs_create_cupages_action');
add_action('wp_ajax_nopriv_hs_create_cupages_action','hs_create_cupages_action');
function hs_create_cupages_action()
{ global $post;
     /*************************/
    $hs_create_contactus=$_POST['hs_create_contactus'];
	/**********************/
	$chkpage = get_page_by_title('Contact US');
	if($hs_create_contactus=='checked')
	{   
	     if(empty($chkpage))
	   {
	     global $user_ID;
		 $content=file_get_contents(HB_SU_PATH.'pages/contact.txt');
		 $content=str_replace('[site_name]',get_bloginfo('name'),$content);
			$content=str_replace('[site_url]',get_bloginfo('wpurl'),$content);
			$content=str_replace('[site_description]',get_bloginfo('description'),$content);
			$content=str_replace('[admin_email]',get_bloginfo('admin_email'),$content);
        $page['post_type']    = 'page';
		$page['post_content'] = $content;
		$page['post_parent']  = 0;
		$page['post_author']  = $user_ID;
		$page['post_status']  = 'publish';
		$page['post_title']   = 'Contact US';
		$page = apply_filters('yourplugin_add_new_page', $page, 'teams');
		$pageid = wp_insert_post ($page);
		if ($pageid == 0) { echo "Add Contact US Failed"; }
	echo "done7";
	    }
	}
	die();
}	
/********************** terms page ***********************/
add_action('wp_ajax_hs_create_terms_action','hs_create_terms_action');
add_action('wp_ajax_nopriv_hs_create_terms_action','hs_create_terms_action');
function hs_create_terms_action()
{ global $post;
     /*************************/
    $hs_create_termsofuse=$_POST['hs_create_termsofuse'];
	/**********************/
	$chkpage = get_page_by_title('Terms of Use');
	if($hs_create_termsofuse=='checked')
	{   
	     if(empty($chkpage))
	   {
	     global $user_ID;
		 $content=file_get_contents(HB_SU_PATH.'pages/termspage.txt');
		 $content=str_replace('[site_name]',get_bloginfo('name'),$content);
			$content=str_replace('[site_url]',get_bloginfo('wpurl'),$content);
			$content=str_replace('[site_description]',get_bloginfo('description'),$content);
			$content=str_replace('[admin_email]',get_bloginfo('admin_email'),$content);
        $page['post_type']    = 'page';
		$page['post_content'] = $content;
		$page['post_parent']  = 0;
		$page['post_author']  = $user_ID;
		$page['post_status']  = 'publish';
		$page['post_title']   = 'Terms of Use';
		$page = apply_filters('yourplugin_add_new_page', $page, 'teams');
		$pageid = wp_insert_post ($page);
		if ($pageid == 0) { echo "Add Terms of Use Failed"; }
	echo "done11";
	    }
	}
	die();
}	
/********************** Initialize class ***********************/
add_action('wp_ajax_hs_action_cleanup','hs_action_cleanup');
add_action('wp_ajax_nopriv_hs_action_cleanup','hs_action_cleanup');
function hs_action_cleanup()
{   
   $hs_set_newalert=$_POST['hs_set_newalert'];
   $hs_set_moderatealert=$_POST['hs_set_moderatealert'];
   $hs_set_permalinks=$_POST['hs_set_permalinks'];
    if($hs_set_permalinks==1)
	{  
	    if(get_option('permalink_structure')!='/%postname%/')
		{
		global $wp_rewrite;
			
			$prefix = $blog_prefix = '';
			if ( ! got_mod_rewrite() && ! $iis7_permalinks )
				$prefix = '/index.php';
			if ( is_multisite() && !is_subdomain_install() && is_main_site() )
				$blog_prefix = '/blog';

			if ( isset($_POST['hs_set_permalinks']) ) {
				$permalink_structure = '/%postname%/';

					if ( ! empty( $permalink_structure ) ) {
						$permalink_structure = preg_replace( '#/+#', '/', '/' . str_replace( '#', '', $permalink_structure ) );
						if ( $prefix && $blog_prefix )
							$permalink_structure = $prefix . preg_replace( '#^/?index\.php#', '', $permalink_structure );
						else
							$permalink_structure = $blog_prefix . $permalink_structure;
					}
					$wp_rewrite->set_permalink_structure( $permalink_structure );
					flush_rewrite_rules();
			}
	    echo "done8";
		}
	}
	if($_POST['hs_set_newalert']==0)
	{   
	    if(get_option('comments_notify')!=$hs_set_newalert)
		{
		update_option('comments_notify',$hs_set_newalert);
		echo "done9";
		}
		
	}
	if($_POST['hs_set_moderatealert']==0)
	{
	   if(get_option('moderation_notify')!=$hs_set_moderatealert)
	   {
     	update_option('moderation_notify',$hs_set_moderatealert);
	    echo "done10";
	   }	
	}
	
	
die();
}
 /****************************************/
 
 /********* create category *********/
function wp_occ_s4catadd()
{
	if($_POST['catcheck']=='checked')
	{
	$cat=$_POST['cat'];
	$newcat = explode(',',$cat);
	for($i=0;$i<count($newcat);$i++){
		if(0==get_cat_ID('Uncategorized'))
			wp_create_category($newcat[$i]);
		else
		{
			$arr=array('cat_ID'=>get_cat_ID('Uncategorized'), 'cat_name'=>$newcat[$i]);
			wp_insert_category($arr);
		}
	}
	echo "done12";
	}
	die();
}
add_action('wp_ajax_s4catadd','wp_occ_s4catadd');
 /********* category *********/
 
  /********* create page *********/
function wp_occ_s4pageadd()
{
if($_POST['pagecheck']=='checked')
	{
		$page=$_POST['page'];
		$sf = array();
		$post = array();
		$newpage = explode(',',$page);
		for($i=0;$i<count($newpage);$i++){
			if(!get_page_by_title($newpage[$i])){
				$post['author']=1;
				$post['post_type']    = 'page';
				$post['name']=sanitize_title($newpage[$i]);
				$post['post_title']=$newpage[$i];
				$post['post_status']='publish';
				$post['post_content']='';
				$post['post_parent']  = 0;
				$sf[] = wp_insert_post($post); 
			}
		}
echo "done13";		
	}
die();
}
add_action('wp_ajax_s4pageadd','wp_occ_s4pageadd');
  /*********plugin create*********/
  /***********install-plugin****************/
function install_plugin($url)
{
	if(strstr($url,'.zip')!=FALSE)
	{
		$download_link=$url;
	}
	else
	{

		$slug=explode('/',$url);
		$slug=$slug[count($slug)-2];
		$api=plugins_api('plugin_information', array('slug'=>$slug, 'fields'=> array('sections'=>'false')));
		$download_link=$api->download_link;
	}


   $upgrader=new Plugin_Upgrader();
   if(!$upgrader->install($download_link))
		return 0;
   
   //This will also activate the plugin after installation

   $plugin_to_activate=$upgrader->plugin_info();
   $activate=activate_plugin($plugin_to_activate);
   wp_cache_flush();

   return 1;
}
add_action('wp_ajax_hs_s2installurl','hs_s2installurl');
add_action('wp_ajax_nopriv_hs_s2installurl','hs_s2installurl');
function hs_s2installurl()
{
	if($_POST['wpfresh_installplugin']=='checked')
	{
	$url=$_POST['s2_url'];
	$newurls = explode(',',$url);
	//echo ABSPATH.'wp-admin/includes/class-wp-upgrader.php'; 
	/** Load WordPress Bootstrap 
	require_once( dirname( dirname( __FILE__ ) ) . '/wp-load.php' );*/
	require_once(ABSPATH.'wp-admin/includes/class-wp-upgrader.php');
	require_once(ABSPATH.'wp-admin/includes/plugin-install.php');
	/*require_once( ABSPATH . 'wp-includes/wp-db.php' );*/
	for($i=0;$i<count($newurls);$i++){
	install_plugin($newurls[$i]);
	}
	echo "done14";
	}
	die();
}   

/*******************/
/*function my_admin_freshscripts() {
echo 'rrrrrrrrrrrr';
	wp_enqueue_script('media-upload');
	wp_enqueue_script('thickbox');
	/*wp_register_script('my-upload', plugin_dir_url(__FILE__).'js/upload_images.js', array('jquery','media-upload','thickbox'));
	wp_enqueue_style('thickbox');
}
add_action('init', 'my_admin_freshscripts');*/