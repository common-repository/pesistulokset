<?php
/**
 * Enqueue styles and scripts
 * @package Pesistulokset
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Register the JavaScript and styles for the public-facing side of the site.
 *
 * @since    1.0.0
 */
function pesistulokset_enqueue_scripts() {
	wp_enqueue_style( 'pt-styles', PESISTULOKSET_BASE_URL . 'public/css/styles.css', array(), PESISTULOKSET_VERSION );
}
add_action( 'wp_enqueue_scripts', 'pesistulokset_enqueue_scripts' );
add_action( 'admin_enqueue_scripts', 'pesistulokset_enqueue_scripts' );
