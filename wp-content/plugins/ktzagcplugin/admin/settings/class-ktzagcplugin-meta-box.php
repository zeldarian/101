<?php

/**
 *
 * @package    ktzagcplugin
 * @subpackage ktzagcplugin/admin/settings
 * @author     Gian MR <g14nblog@gmail.com>
 */

class Ktzagcplugin_Meta_Box {

	/**
	 * The ID of this plugin.
	 *
	 * @since    1.0.0
	 * @access   private
	 * @var      string    $ktzagcplugin    The ID of this plugin.
	 */
	private $ktzagcplugin;

	/**
	 * The araay of settings tabs
	 *
	 * @since 	1.0.0
	 * @access  private
	 * @var   	array 		$options_tabs 	The araay of settings tabs
	 */
	private $options_tabs;

	/**
	 * Initialize the class and set its properties.
	 *
	 * @since    1.0.0
	 * @var      string    $ktzagcplugin       The name of this plugin.
	 */
	public function __construct( $ktzagcplugin ) {

		$this->ktzagcplugin = $ktzagcplugin;
		$this->options_tabs = Ktzagcplugin_Settings_Definition::get_tabs();
	}

	/**
	 * Register the meta boxes on settings page.
	 *
	 * @since    1.0.0
	 */
	public function add_meta_boxes() {

		foreach ( $this->options_tabs as $tab_id => $tab_name ) {

			add_meta_box(
					$tab_id,							// Meta box ID
					$tab_name,							// Meta box Title
					array( $this, 'render_meta_box' ),	// Callback defining the plugin's innards
					'ktzagcplugin_settings_' . $tab_id, // Screen to which to add the meta box
					'normal'							// Context
					);

			} // end foreach
	}

	/**
	 * Print the meta box on settings page.
	 *
	 * @since     1.0.0
	 */
	public function render_meta_box( $active_tab ) {

		require_once( plugin_dir_path( dirname( __FILE__ ) ) . 'partials/' . $this->ktzagcplugin . '-meta-box-display.php' );
	}
}
