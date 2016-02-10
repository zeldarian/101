<?php
/**
 * Provide a meta box view for the settings page
 *
 * @link       http://kentooz.com
 * @since      1.0.0
 *
 * @package    ktzagcplugin
 * @subpackage ktzagcplugin/admin/partials
 */

/**
 * Meta Box
 *
 * Renders a single meta box.
 *
 * @since       1.0.0
*/
?>

<form action="options.php" method="POST">
	<?php settings_fields( 'ktzagcplugin_settings' ); ?>
	<?php do_settings_sections( 'ktzagcplugin_settings_' . $active_tab ); ?>
	<?php submit_button(); ?>
</form>
<br class="clear" />
