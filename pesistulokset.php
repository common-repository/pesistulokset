<?php
/**
 * @since 1.0.0
 * @package Pesistulokset
 *
 * Plugin name: Pesistulokset
 * Plugin URI: https://bitbucket.org/koutamiika/pesistulokset/
 * Description: Näytä pesistulokset sivustollasi.
 * Author:      Miika Salo
 * Version:     1.8.6
 * Requires at least: 6.2
 * Author URI:  https://miikasalo.com
 * License:     GPL-2.0+
 * License URI: http://www.gnu.org/licenses/gpl-2.0.txt
 * Text Domain: pesistulokset
 * Domain Path: /languages
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Current plugin version.
 */
define( 'PESISTULOKSET_VERSION', '1.8.6' );

define( 'PESISTULOKSET_API_URL', 'https://www.pesistulokset.fi/api/v1/public/result-board' );
define( 'PESISTULOKSET_MATCHES_API_URL', 'https://www.pesistulokset.fi/api/v1/public/matches' );
define( 'PESISTULOKSET_STATS_API_URL', 'https://www.pesistulokset.fi/api/v1/public/stats' );

define( 'PESISTULOKSET_API_KEY', get_option( 'pesistulokset_api_key' ) );
define( 'PESISTULOKSET_API_DEFAULTS', array(
	'season' => '2023',
	'level'  => 'Superpesis',
	'region' => '',
	'series' => 'Miehet',
	'phase'  => 'Runkosarja',
	'group'  => 'Runkosarja',
	'apikey' => PESISTULOKSET_API_KEY,
) );

define( 'PESISTULOKSET_MATCHES_API_DEFAULTS', array(
	'season' => '2023',
	'level'  => 'Superpesis',
	'region' => '',
	'series' => 'Miehet',
	'phase'  => 'Runkosarja',
	'group'  => 'Runkosarja',
	'team'   => '',
	'team2'  => '',
	'apikey' => PESISTULOKSET_API_KEY,
) );

define( 'PESISTULOKSET_STATS_API_DEFAULTS', array(
	'season' => '2023',
	'level'  => 'Superpesis',
	'region' => '',
	'series' => 'Miehet',
	'phase'  => 'Runkosarja',
	'group'  => 'Runkosarja',
	'type'   => 'pelaajat',
	'stat'   => 'lyodyt',
	'team'   => '',
	'apikey' => PESISTULOKSET_API_KEY,
) );

define( 'PESISTULOKSET_PLUGIN_NAME', plugin_basename( __FILE__ ) );

/**
 * Plugin base dir path.
 * used to locate plugin resources primarily code files
 */
define( 'PESISTULOKSET_BASE_DIR', plugin_dir_path( __FILE__ ) );

/**
 * Plugin base dir url.
 */
define( 'PESISTULOKSET_BASE_URL', plugin_dir_url( __FILE__ ) );

/**
 * Load plugin text domain.
 */
function pesistulokset_load_plugin_textdomain() {
	load_plugin_textdomain( 'pesistulokset', false, basename( __DIR__ ) . '/languages' );
}
add_action( 'plugins_loaded', 'pesistulokset_load_plugin_textdomain' );

/**
 * Require plugin files.
 */
require_once PESISTULOKSET_BASE_DIR . 'admin/admin-settings.php';
require_once PESISTULOKSET_BASE_DIR . 'includes/enqueues.php';
require_once PESISTULOKSET_BASE_DIR . 'includes/pesistulokset-functions.php';
require_once PESISTULOKSET_BASE_DIR . 'includes/pesistulokset-shortcodes.php';
require_once PESISTULOKSET_BASE_DIR . 'includes/class-pt-results-widget.php';
require_once PESISTULOKSET_BASE_DIR . 'includes/pesistulokset-widgets.php';

/**
 * Fires when plugin is uninstalled.
 */
function pesistulokset_uninstall() {
	delete_option( 'pesistulokset_api_key' ); // Delete api key option.
}
register_uninstall_hook( __FILE__, 'pesistulokset_uninstall' );

/**
 * Registers the block using the metadata loaded from the `block.json` file.
 * Behind the scenes, it registers also all assets so they can be enqueued
 * through the block editor in the corresponding context.
 *
 * @see https://developer.wordpress.org/reference/functions/register_block_type/
 */
function pesistulokset_register_custom_blocks() {
	register_block_type(
		__DIR__ . '/build/pesistulokset'
	);
	register_block_type(
		__DIR__ . '/build/ottelut'
	);
	register_block_type(
		__DIR__ . '/build/tilastot'
	);
}
add_action( 'init', 'pesistulokset_register_custom_blocks' );

register_block_style(
    'pesistulokset/pesistulokset-block',
    array(
        'name'         => 'striped',
        'label'        => __( 'Raidat', 'pesistulokset' ),
        'inline_style' => '.wp-block-pesistulokset-pesistulokset-block.is-style-striped tr:nth-child(even):not(.team-highlighted) td {background-color: #fafafa}',
    )
);
