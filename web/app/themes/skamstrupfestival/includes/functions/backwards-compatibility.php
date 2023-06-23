<?php
/**
 * Everything that modifies the administration screens
 *
 * @package Skamstrupfestival
 *
 */

// @note we leave out namespace on purpose.

/**
 * Backwards Compatibility for the new wp_body_open introduced in wp 5.2
 */
if ( ! function_exists( 'wp_body_open' ) ) {

	function wp_body_open() {
		do_action( 'wp_body_open' );
		// phpcs:ignore
	}

}
