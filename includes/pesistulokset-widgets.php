<?php

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * Register custom widgets
 */
function pesistulokset_load_widget() {
    register_widget( 'Pesistulokset_Results_Widget' );
}
add_action( 'widgets_init', 'pesistulokset_load_widget' );
