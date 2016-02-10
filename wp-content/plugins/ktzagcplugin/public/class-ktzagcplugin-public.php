<?php

/**
 * The public-facing functionality of the plugin.
 *
 * @link       http://kentooz.com
 * @since      1.0.0
 *
 * @package    ktzagcplugin
 * @subpackage ktzagcplugin/public
 */

/**
 * The public-facing functionality of the plugin.
 *
 * Defines the ktzagcplugin, version, and two examples hooks for how to
 * enqueue the admin-specific stylesheet and JavaScript.
 *
 * @package    ktzagcplugin
 * @subpackage ktzagcplugin/public
 * @author     Gian MR <g14nblog@gmail.com>
 */
class Ktzagcplugin_Public {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $ktzagcplugin    The ID of this plugin.
	 */
	private $ktzagcplugin;

	/**
	 * The version of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $version    The current version of this plugin.
	 */
	private $version;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @param      string    $ktzagcplugin       The name of the plugin.
	 * @param      string    $version    The version of this plugin.
	 */
	public function __construct( $ktzagcplugin, $version ) {

		$this->ktzagcplugin = $ktzagcplugin;
		$this->version = $version;

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_styles() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Ktzagcplugin_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ktzagcplugin_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_style( $this->ktzagcplugin, plugin_dir_url( __FILE__ ) . 'css/ktzagcplugin-public.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the stylesheets for the public-facing side of the site.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		/**
		 * This function is provided for demonstration purposes only.
		 *
		 * An instance of this class should be passed to the run() function
		 * defined in Ktzagcplugin_Loader as all of the hooks are defined
		 * in that particular class.
		 *
		 * The Ktzagcplugin_Loader will then create the relationship
		 * between the defined hooks and the functions defined in this
		 * class.
		 */

		wp_enqueue_script( $this->ktzagcplugin, plugin_dir_url( __FILE__ ) . 'js/ktzagcplugin-public.js', array( 'jquery' ), $this->version, false );

	}

}
