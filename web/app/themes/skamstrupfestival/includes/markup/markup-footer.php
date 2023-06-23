<?php
/**
 * Function hooks for footer
 *
 * @link https://docs.woocommerce.com/wc-apidocs/hook-docs.html
 *
 * @package Skamstrupfestival
 */

namespace Skamstrupfestival\Theme;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class SkamstrupfestivalFooterFunctions {

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

		add_action( THEMEDOMAIN . '_site_footer', [ __CLASS__, 'footer_markup' ], 50 );
		add_action( THEMEDOMAIN . '_footer_content', [ __CLASS__, 'footer_markup_inner_open' ], 30 );
		add_action( THEMEDOMAIN . '_footer_content', [ __CLASS__, 'footer_markup_inner_close' ], 70 );

	}

	/**
	 * Function to get site footer wrapper
	 */
	public static function footer_markup() {
		?>

		<footer id="footer" class="site-footer" role="contentinfo">

			<?php do_action( THEMEDOMAIN . '_footer_content' ); ?>

		</footer>

		<?php
	}

	/**
	 * Function to get site footer inner opening markup
	 */
	public static function footer_markup_inner_open() {
		?>

		<div class="site-footer__inner">

			<?php dynamic_sidebar( 'footer' ); ?>

		<?php
	}

	/**
	 * Function to get site footer inner closing markup
	 */
	public static function footer_markup_inner_close() {
		?>

		</div>

		<?php
	}

}

SkamstrupfestivalFooterFunctions::instance();
