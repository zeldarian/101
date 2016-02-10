<?php

/**
 * The file that defines the core plugin class
 *
 * A class definition that includes attributes and functions used across both the
 * public-facing side of the site and the dashboard.
 *
 * @link       http://kentooz.com
 * @since      1.0.0
 *
 * @package    ktzagcplugin
 * @subpackage ktzagcplugin/includes
 */

/**
 * The core plugin class.
 *
 * This is used to define internationalization, dashboard-specific hooks, and
 * public-facing site hooks.
 *
 * Also maintains the unique identifier of this plugin as well as the current
 * version of the plugin.
 *
 * @since      1.0.0
 * @package    ktzagcplugin
 * @subpackage ktzagcplugin/includes
 * @author     Gian MR <g14nblog@gmail.com>
 */
class Ktzagcplugin {

	/**
	 * The loader that's responsible for maintaining and registering all hooks that power
	 * the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      Ktzagcplugin_Loader    $loader    Maintains and registers all hooks for the plugin.
	 */
	protected $loader;

	/**
	 * The unique identifier of this plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $ktzagcplugin    The string used to uniquely identify this plugin.
	 */
	protected $ktzagcplugin;

	/**
	 * The current version of the plugin.
	 *
	 * @since    1.0.0
	 * @access   protected
	 * @var      string    $version    The current version of the plugin.
	 */
	protected $version;

	/**
	 * Define the core functionality of the plugin.
	 *
	 * Set the ktzagcplugin and the plugin version that can be used throughout the plugin.
	 * Load the dependencies, define the locale, and set the hooks for the Dashboard and
	 * the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function __construct() {

		$this->ktzagcplugin = 'ktzagcplugin';
		$this->version = '1.0.0';

		$this->load_dependencies();
		$this->set_locale();
		$this->define_admin_hooks();
		$this->define_public_hooks();

	}

	/**
	 * Load the required dependencies for this plugin.
	 *
	 * Include the following files that make up the plugin:
	 *
	 * - Ktzagcplugin_Loader. Orchestrates the hooks of the plugin.
	 * - Ktzagcplugin_i18n. Defines internationalization functionality.
	 * - Ktzagcplugin_Admin. Defines all hooks for the dashboard.
	 * - Ktzagcplugin_Public. Defines all hooks for the public side of the site.
	 *
	 * Create an instance of the loader which will be used to register the hooks
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function load_dependencies() {

		/**
		 * The class responsible for orchestrating the actions and filters of the
		 * core plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-ktzagcplugin-loader.php';

		/**
		 * The class responsible for defining internationalization functionality
		 * of the plugin.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-ktzagcplugin-i18n.php';

		/**
		 * The class responsible for defining all actions that occur in the Dashboard.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/class-ktzagcplugin-admin.php';

		/**
		 * The class responsible for defining all actions that occur in the public-facing
		 * side of the site.
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'public/class-ktzagcplugin-public.php';

		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'includes/class-ktzagcplugin-option.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/settings/class-ktzagcplugin-callback-helper.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/settings/class-ktzagcplugin-meta-box.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/settings/class-ktzagcplugin-sanitization-helper.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/settings/class-ktzagcplugin-settings-definition.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'admin/settings/class-ktzagcplugin-settings.php';
	
		/**
		 * The class responsible for external script
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'external/simple_html_dom.php';
		
		/**
		 * The Main Function Scrapping and module
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'modules/_fake-results.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'modules/_functions.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'modules/_shortcodes.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'modules/ktzagcplugin-module-article.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'modules/ktzagcplugin-module-image.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'modules/ktzagcplugin-module-google-trend.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'modules/ktzagcplugin-module-randterm.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'modules/ktzagcplugin-module-video.php';
		
		/**
		 * Widget
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'widget/random-term-widget.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'widget/google-trend-widget.php';
		
		/**
		 * Bulk Poster
		 */
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'bulk-poster/_schedule.php';
		require_once plugin_dir_path( dirname( __FILE__ ) ) . 'bulk-poster/class-ktzagcplugin-bulk-poster.php';

		$this->loader = new Ktzagcplugin_Loader();

	}

	/**
	 * Define the locale for this plugin for internationalization.
	 *
	 * Uses the Ktzagcplugin_i18n class in order to set the domain and to register the hook
	 * with WordPress.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function set_locale() {

		$plugin_i18n = new Ktzagcplugin_i18n();
		$plugin_i18n->set_domain( $this->get_ktzagcplugin() );

		$this->loader->add_action( 'plugins_loaded', $plugin_i18n, 'load_plugin_textdomain' );

	}

	/**
	 * Register all of the hooks related to the dashboard functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_admin_hooks() {

		$plugin_admin = new Ktzagcplugin_Admin( $this->get_ktzagcplugin(), $this->get_version() );

		// $this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_styles' );
		$this->loader->add_action( 'admin_enqueue_scripts', $plugin_admin, 'enqueue_scripts' );

		// Add the options page and menu item.
		$this->loader->add_action( 'admin_menu', $plugin_admin, 'add_plugin_admin_menu' );

		// Add an action link pointing to the options page.
		$plugin_basename = plugin_basename( plugin_dir_path( realpath( dirname( __FILE__ ) ) ) . $this->ktzagcplugin . '.php' );
		$this->loader->add_action( 'plugin_action_links_' . $plugin_basename, $plugin_admin, 'add_action_links' );

		// Built the option page
		$settings_callback = new Ktzagcplugin_Callback_Helper( $this->ktzagcplugin );
		$settings_sanitization = new Ktzagcplugin_Sanitization_Helper( $this->ktzagcplugin );
		$plugin_settings = new Ktzagcplugin_Settings( $this->get_ktzagcplugin(), $settings_callback, $settings_sanitization);
		$this->loader->add_action( 'admin_init' , $plugin_settings, 'register_settings' );

		$plugin_meta_box = new Ktzagcplugin_Meta_Box( $this->get_ktzagcplugin() );
		$this->loader->add_action( 'load-toplevel_page_' . $this->get_ktzagcplugin() , $plugin_meta_box, 'add_meta_boxes' );

	}

	/**
	 * Register all of the hooks related to the public-facing functionality
	 * of the plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 */
	private function define_public_hooks() {

		$plugin_public = new Ktzagcplugin_Public( $this->get_ktzagcplugin(), $this->get_version() );

		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_styles' );
		$this->loader->add_action( 'wp_enqueue_scripts', $plugin_public, 'enqueue_scripts' );

	}

	/**
	 * Run the loader to execute all of the hooks with WordPress.
	 *
	 * @since    1.0.0
	 */
	public function run() {
		$this->loader->run();
	}

	/**
	 * The name of the plugin used to uniquely identify it within the context of
	 * WordPress and to define internationalization functionality.
	 *
	 * @since     1.0.0
	 * @return    string    The name of the plugin.
	 */
	public function get_ktzagcplugin() {
		return $this->ktzagcplugin;
	}

	/**
	 * The reference to the class that orchestrates the hooks with the plugin.
	 *
	 * @since     1.0.0
	 * @return    Ktzagcplugin_Loader    Orchestrates the hooks of the plugin.
	 */
	public function get_loader() {
		return $this->loader;
	}

	/**
	 * Retrieve the version number of the plugin.
	 *
	 * @since     1.0.0
	 * @return    string    The version number of the plugin.
	 */
	public function get_version() {
		return $this->version;
	}

}