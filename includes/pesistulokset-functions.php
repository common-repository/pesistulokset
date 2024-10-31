<?php
/**
 * The main functionality of the plugin.
 *
 * @link       https://miikasalo.com
 * @since      1.0.0
 *
 * @package    Pesistulokset
 */

// If this file is called directly, abort.
if ( ! defined( 'WPINC' ) ) {
	die;
}

/**
 * API call function.
 */
if ( ! function_exists( 'pesistulokset_get_matches' ) ) {
	/**
	 * Function to remotely getting standings data.
	 *
	 * @param array $args required arguments for the API endpoint.
	 * @return array response body
	 */
	function pesistulokset_get_results( $args = array() ) {

		$args = wp_parse_args(
			$args,
			PESISTULOKSET_API_DEFAULTS,
		);

		$response = wp_remote_get(
			PESISTULOKSET_API_URL,
			array(
				'body' => $args,
			)
		);

		$response_body = json_decode( wp_remote_retrieve_body( $response ), true );
		$response_code = wp_remote_retrieve_response_code( $response );

		if ( 200 === $response_code && $response_body ) {
			return $response_body['data']['resultBoard'];
		}

	}
}

if ( ! function_exists( 'pesistulokset_get_matches' ) ) {
	/**
	 * Function to remotely getting matches data.
	 *
	 * @param array $args required arguments for the API endpoint.
	 * @return array response body
	 */
	function pesistulokset_get_matches( $args = array() ) {

		$args = wp_parse_args(
			$args,
			PESISTULOKSET_MATCHES_API_DEFAULTS,
		);

		$response = wp_remote_get(
			add_query_arg( $args, PESISTULOKSET_MATCHES_API_URL )
		);

		$response_body = json_decode( wp_remote_retrieve_body( $response ), true );
		$response_code = wp_remote_retrieve_response_code( $response );

		if ( 200 === $response_code && $response_body ) {
			return $response_body['data'];
		}

	}
}

if ( ! function_exists( 'pesistulokset_get_stats' ) ) {
	/**
	 * Function to remotely getting player or team statistics data.
	 *
	 * @param array $args required arguments for the API endpoint.
	 * @return array response body
	 */
	function pesistulokset_get_stats( $args = array() ) {

		$args = wp_parse_args(
			$args,
			PESISTULOKSET_STATS_API_DEFAULTS,
		);

		$response = wp_remote_get(
			add_query_arg( $args, PESISTULOKSET_STATS_API_URL )
		);

		$response_body = json_decode( wp_remote_retrieve_body( $response ), true );
		$response_code = wp_remote_retrieve_response_code( $response );

		if ( 200 === $response_code && $response_body ) {
			return $response_body;
		}

	}
}
