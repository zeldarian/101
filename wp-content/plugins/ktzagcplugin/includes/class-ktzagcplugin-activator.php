<?php

/**
 * Fired during plugin activation
 *
 * @link       http://kentooz.com
 * @since      1.0.0
 *
 * @package    ktzagcplugin
 * @subpackage ktzagcplugin/includes
 */

/**
 * Fired during plugin activation.
 *
 * This class defines all code necessary to run during the plugin's activation.
 *
 * @since      1.0.0
 * @package    ktzagcplugin
 * @subpackage ktzagcplugin/includes
 * @author     Gian MR <g14nblog@gmail.com>
 */
class Ktzagcplugin_Activator {

	/**
	 * Short Description. (use period)
	 *
	 * Long Description.
	 *
	 * @since    1.0.0
	 */
	public static function activate() {
		# flash rewrite rule
		ktzplg_flush_rewrite_rules();
		
		#add option to sql
		/*
		sangat berat dan akan terposting otomatis tanpa ada filter termasuk ping, cape deh... 
		Ane nonaktifkan saja, tolong jangan diaktifkan fitur ini lagi gaes.
		add_option('ktzplg_autopost_agccontent', '');
		add_option('ktzplg_autopost_category', '1');
		add_option('ktzplg_autopost_status', __('publish', 'ktzagcplugin' ) );
		*/
		add_option('ktzplg_badword', 'http:,cache:,site:,utm_source,sex,porn,gamble,xxx,nude,squirt,gay,abortion,attack,bomb,casino,cocaine,die,death,erection,gambling,heroin,marijuana,masturbation,pedophile,penis,poker,pussy,terrorist,anal,anus,anal,anus,group sex,guro,hand job,handjob,hard core,hardcore,motherfucker,nipples,orgasm,phone sex,rape,raping,xxx,zoophilia,memek,bugil,telanjang,porno,porns,pecun,pelacur,wts');
		add_option('ktzplg_rand_keyword', '' );
		add_option('ktzplg_agc_content', '[ktzagcplugin_image]<br />[ktzagcplugin_text number="4"]<br />[ktzagcplugin_video]<br />[ktzagcplugin_text source="ask" number="4"]<br />[ktzagcplugin_text source="bing" number="4" related="true"]');
		add_option('ktzplg_agc_searchresults', 'google');
		add_option('ktzplg_curl_proxy', '');
		add_option('ktzplg_curl_proxy_userpass', '');
	}

}