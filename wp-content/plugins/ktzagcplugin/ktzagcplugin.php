<?php

/**
 * The plugin bootstrap file
 *
 * This file is read by WordPress to generate the plugin information in the plugin
 * admin area. This file also includes all of the dependencies used by the plugin,
 * registers the activation and deactivation functions, and defines a function
 * that starts the plugin.
 * Ktzagcplugin use starter plugin
 * https://github.com/DevinVinson/WordPress-Plugin-Boilerplate
 *
 * @link              http://kentooz.com
 * @since             1.0.0
 * @package           Ktzagcplugin
 *
 * @wordpress-plugin
 * Plugin Name:       Ktzagcplugin
 * Plugin URI:        http://kentooz.com
 * Description:       Kentooz automatic generate content for boost traffic and get more index in search engine
 * Version:           1.1.3
 * Author:            Gian Mr
 * Author URI:        http://gianmr.com
 * License:           GPL-2.0+
 * License URI:       http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain:       ktzagcplugin
 * Domain Path:       /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

// Define default options
define('KTZPLG_BADWORDS','http:,cache:,site:,utm_source,sex,porn,gamble,xxx,nude,squirt,gay,abortion,attack,bomb,casino,cocaine,die,death,erection,gambling,heroin,marijuana,masturbation,pedophile,penis,poker,pussy,terrorist,
		anal,anus,anal,anus,group sex,guro,hand job,handjob,hard core,hardcore,motherfucker,nipples,orgasm,phone sex,rape,raping,xxx,zoophilia,memek,bugil,telanjang,porno,porns,pecun,pelacur,wts');

/**
 * The code that runs during plugin activation.
 * This action is documented in includes/class-ktzagcplugin-activator.php
 */
function activate_ktzagcplugin() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-ktzagcplugin-activator.php';
	Ktzagcplugin_Activator::activate();
}

/**
 * The code that runs during plugin deactivation.
 * This action is documented in includes/class-ktzagcplugin-deactivator.php
 */
function deactivate_ktzagcplugin() {
	require_once plugin_dir_path( __FILE__ ) . 'includes/class-ktzagcplugin-deactivator.php';
	Ktzagcplugin_Deactivator::deactivate();
}

register_activation_hook( __FILE__, 'activate_ktzagcplugin' );
register_deactivation_hook( __FILE__, 'deactivate_ktzagcplugin' );

/**
 * The core plugin class that is used to define internationalization,
 * admin-specific hooks, and public-facing site hooks.
 */
require plugin_dir_path( __FILE__ ) . 'includes/class-ktzagcplugin.php';

/**
 * Automatic Update With Self Hosting
 * http://w-shadow.com/blog/2010/09/02/automatic-updates-for-any-plugin/
 */
require plugin_dir_path( __FILE__ ) . 'update/plugin-update-checker.php';
$MyUpdateChecker = PucFactory::buildUpdateChecker(
    'http://www.kentooz.com/files/ktzagcplugin/ktzagcplgnautomaticly.json',
    __FILE__,
    'ktzagcplugin'
);

/**
 * Begins execution of the plugin.
 *
 * Since everything within the plugin is registered via hooks,
 * then kicking off the plugin from this point in the file does
 * not affect the page life cycle.
 *
 * @since    1.0.0
 */
function run_ktzagcplugin() {

	$plugin = new Ktzagcplugin();
	$plugin->run();

}
run_ktzagcplugin();