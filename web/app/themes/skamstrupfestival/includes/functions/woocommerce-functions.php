<?php
/**
 * Function hooks for WooCommerce
 *
 * @link https://docs.woocommerce.com/wc-apidocs/hook-docs.html
 *
 * @package Skamstrupfestival
 */

namespace Skamstrupfestival\Theme;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class SkamstrupfestivalWoocommerceFunctions {

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
		get_template_part( 'includes/functions/customizer/WooCommerceProductGallery' );
		get_template_part( 'includes/functions/customizer/WooCommerceProductListAsTable' );

		add_action( 'after_setup_theme', [ $this, 'add_woocommerce_support' ] );

	}

	// limit product pr row to 4. Note you can choose more than 4, but it has no effect.
	public function add_woocommerce_support() {
		add_theme_support(
			'woocommerce',
			[
				'product_grid' => [
					'max_columns' => 4,
				],
			]
		);
	}

}

$skamstrupfestival_woocommerce_functions = SkamstrupfestivalWoocommerceFunctions::instance();
