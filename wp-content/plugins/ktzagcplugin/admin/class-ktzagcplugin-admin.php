<?php
/**
 * The dashboard-specific functionality of the plugin.
 *
 * @link       http://kentooz.com
 * @since      1.0.0
 *
 * @package    ktzagcplugin
 * @subpackage ktzagcplugin/admin
 */
/**
 * The dashboard-specific functionality of the plugin.
 *
 * Defines the plugin name, version, and two examples hooks for how to
 * enqueue the dashboard-specific stylesheet and JavaScript.
 *
 * @package    ktzagcplugin
 * @subpackage ktzagcplugin/admin
 * @author     Your Name <g14nblog@gmail.com>
 */

class Ktzagcplugin_Admin {

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
	 * @var      string    $ktzagcplugin       The name of this plugin.
	 * @var      string    $version    The version of this plugin.
	 */
	public function __construct( $ktzagcplugin, $version ) {

		$this->ktzagcplugin = $ktzagcplugin;
		$this->version = $version;

	}

	/**
	 * Register the JavaScript for the dashboard.
	 *
	 * @since    1.0.0
	 */
	public function enqueue_scripts() {

		wp_enqueue_script( 'postbox' );
		wp_enqueue_style( $this->ktzagcplugin, plugin_dir_url( __FILE__ ) . 'css/ktzagcplugin-admin.css', array(), $this->version, 'all' );

	}

	/**
	 * Register the administration menu for this plugin into the WordPress Dashboard menu.
	 *
	 * @since    1.0.0
	 */
	public function add_plugin_admin_menu() {

		add_menu_page(
			__( 'Ktzagcplugin Settings', $this->ktzagcplugin ),
			__( 'Ktzagcplugin', $this->ktzagcplugin ),
			'manage_options',
			$this->ktzagcplugin,
			array( $this, 'display_plugin_admin_page' )
			);

		$tabs = Ktzagcplugin_Settings_Definition::get_tabs();

		foreach ( $tabs as $tab_slug => $tab_title ) {

			add_submenu_page(
				$this->ktzagcplugin,
				$tab_title,
				$tab_title,
				'manage_options',
				$this->ktzagcplugin . '&tab=' . $tab_slug,
				array( $this, 'display_plugin_admin_page' )
				);
		}
		
		// Keywords menu item
		$Ktzagcplugin_camp_cpt = get_post_type_object( 'camp_bulkposter' );
		add_submenu_page(
			$this->ktzagcplugin,
			$Ktzagcplugin_camp_cpt->labels->name,
			$Ktzagcplugin_camp_cpt->labels->all_items,
			$Ktzagcplugin_camp_cpt->cap->edit_posts,
			"edit.php?post_type=camp_bulkposter"
		);
		
		remove_submenu_page( $this->ktzagcplugin, $this->ktzagcplugin );
	}

	/**
	 * Add settings action link to the plugins page.
	 *
	 * @since    1.0.0
	 * @return   array 			Action links
	 */
	public function add_action_links( $links ) {

		return array_merge(
			array(
				'settings' => '<a href="' . admin_url( 'admin.php?page=' . $this->ktzagcplugin ) . '">' . __( 'Settings', $this->ktzagcplugin ) . '</a>'
				),
			$links
			);

	}

	/**
	 * Render the settings page for this plugin.
	 *
	 * @since    1.0.0
	 */
	public function display_plugin_admin_page() {

		$tabs = Ktzagcplugin_Settings_Definition::get_tabs();

		$default_tab = Ktzagcplugin_Settings_Definition::get_default_tab_slug();

		$active_tab = isset( $_GET[ 'tab' ] ) && array_key_exists( $_GET['tab'], $tabs ) ? $_GET[ 'tab' ] : $default_tab;

		include_once( 'partials/' . $this->ktzagcplugin . '-admin-display.php' );

	}
}