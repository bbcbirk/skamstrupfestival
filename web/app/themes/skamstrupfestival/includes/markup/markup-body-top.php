<?php
/**
 * Function hooks for index
 *
 * @link https://docs.woocommerce.com/wc-apidocs/hook-docs.html
 *
 * @package Skamstrupfestival
 */

namespace Skamstrupfestival\Theme;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class SkamstrupfestivalBodyTopFunctions {

	/**
	 * @var object Instance of this class.
	 */
	protected static $instance = null;

	/**
	 * Returns the instance of this class.
	 */
	public static function instance() {

		if ( is_null( self::$instance ) ) {
			self::$instance = new self();
		}

		return self::$instance;
	}

	public function __construct() {

		add_action( THEMEDOMAIN . '_body_top', [ __CLASS__, 'wp_body_open' ], 50 );
		add_action( THEMEDOMAIN . '_body_top', [ __CLASS__, 'body_overlay' ], 50 );
		add_action( THEMEDOMAIN . '_body_top', [ __CLASS__, 'skip_link' ], 50 );

	}

	public static function wp_body_open() {
		?>

		<?php wp_body_open(); ?>

		<?php
	}

	/**
	 * Function to get body overlay - Used as background when opening search or burger menu
	 */
	public static function body_overlay() {
		?>

		<div class="body-overlay"></div>

		<?php
	}

	/**
	 * Function to get skip-to-content button
	 */
	public static function skip_link() {
		?>

		<a class="skip-link" href="#content"><?php _e( 'Skip to content', THEMEDOMAIN ); ?></a>

		<?php
	}

}

SkamstrupfestivalBodyTopFunctions::instance();
