<?php
/**
 * Functions and settings for themes admin menu
 *
 * @package Pesistulokset
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Actions
 */
add_action( 'admin_menu', 'pesistulokset_settings_menu_link' );
add_action( 'admin_init', 'pesistulokset_register_settings' );

/**
 * Create settings page menu item
 */
function pesistulokset_settings_menu_link() {
	add_submenu_page(
		'options-general.php',
		__( 'Pesistulokset', 'pesistulokset' ),
		__( 'Pesistulokset', 'pesistulokset' ),
		'manage_options',
		'pt-settings',
		'pesistulokset_settings_page',
		50
	);
}

function pesistulokset_settings_fields() {
	?>
	<input id="pesistulokset_api_key" name="pesistulokset_api_key" type="password" class="widefat" value="<?php echo esc_attr( get_option( 'pesistulokset_api_key' ) ); ?>" required="required" />
	<p class="description"><?php esc_html_e( 'Katso tarkempi rajapintakuvaus osoitteesta', 'pesistulokset' ); ?> <a href="https://ttk.pesistulokset.fi/api-docs">https://ttk.pesistulokset.fi/api-docs</a></p>
	<?php
}

/**
 * Show settings page fields
 */
function pesistulokset_register_settings() {
	add_settings_section( 'section', __( 'Pesistulos asetukset', 'pesistulokset' ), null, 'pesistulokset_plugin_options' );

	add_settings_field( 'pesistulokset_settings', __( 'API-avain *', 'pesistulokset' ), 'pesistulokset_settings_fields', 'pesistulokset_plugin_options', 'section' );

	register_setting( 'section', 'pesistulokset_api_key' );

}

/**
 * Settings page structure
 */
function pesistulokset_settings_page() {
	?>
	<div class="wrap">
		<form method="post" action="options.php">
		<?php
			settings_fields( 'section' );
			do_settings_sections( 'pesistulokset_plugin_options' );
			submit_button();
		?>
		</form>
	</div>
	<?php
}

/**
 * Adds items to the plugin's action links on the Plugins listing screen.
 *
 * @param array<string,string> $actions     Array of action links.
 * @param string               $plugin_file Path to the plugin file relative to the plugins directory.
 * @param mixed[]              $plugin_data An array of plugin data.
 * @param string               $context     The plugin context.
 * @return array<string,string> Array of action links.
 */
function pesistulokset_plugin_action_links( $actions, $plugin_file, $plugin_data, $context ) {
	$new = array(
		'pesistulokset-settings' => sprintf(
			'<a href="%s">%s</a>',
			esc_url( admin_url() . 'options-general.php?page=pt-settings' ),
			esc_html__( 'Asetukset', 'pesistulokset' )
		),
	);

	return array_merge( $new, $actions );
}
add_filter( 'plugin_action_links_' . PESISTULOKSET_PLUGIN_NAME, 'pesistulokset_plugin_action_links', 10, 4 );

function pesistulokset_plugin_notices( $plugin_file, $plugin_data, $status ) {
	?>
		<?php if ( empty( PESISTULOKSET_API_KEY ) ) : ?>
		<tr class="plugin-update-tr active">
			<td colspan="4" class="plugin-update colspanchange">
				<div class="notice inline notice-warning notice-alt">
					<p><?php esc_html_e( 'Varoitus! API-avainta ei ole syötetty. Sarjataulukoita ei voida näyttää ilman API-avainta.', 'pesistulokset' ); ?></p>
				</div>
			</td>
		</tr>
		<?php endif; ?>
	<?php
}
add_action( 'after_plugin_row_' . PESISTULOKSET_PLUGIN_NAME, 'pesistulokset_plugin_notices', 10, 3 );
