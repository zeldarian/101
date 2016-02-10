<?php

/**
 * Fired during plugin deactivation
 *
 * @link       http://kentooz.com
 * @since      1.0.0
 *
 * @package    ktzagcplugin
 * @subpackage ktzagcplugin/includes
 */

/**
 * Fired during plugin deactivation.
 *
 * This class defines all code necessary to run during the plugin's deactivation.
 *
 * @since      1.0.0
 * @package    ktzagcplugin
 * @subpackage ktzagcplugin/includes
 * @author     Gian MR <g14nblog@gmail.com>
 */
class Ktzagcplugin_Deactivator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function deactivate() {
		
		# delete option from sql
		delete_option('ktzplg_nofollow_head');
		delete_option('ktzplg_badword');
		delete_option('ktzplg_rand_keyword');
		delete_option('ktzplg_agc_content');
		delete_option('ktzplg_agc_searchresults');
		delete_option('ktzplg_curl_proxy');
		delete_option('ktzplg_curl_proxy_userpass');
		
		# Clear scheduled
		wp_clear_scheduled_hook('ktzplg_auto_post_hook');

	}

}
