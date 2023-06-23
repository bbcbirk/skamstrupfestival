<?php
/**
 * Theme hooks for WooCommerce
 *
 * @link https://docs.woocommerce.com/wc-apidocs/hook-docs.html
 *
 * @package Skamstrupfestival
 */

namespace Skamstrupfestival\Theme;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class SkamstrupfestivalWoocommerceTheming {

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
		self::woo_setup();
		add_action( 'wp', [ __CLASS__, 'reorder_layout' ], 15 );

		add_filter( THEMEDOMAIN . '_setup_post_classes', [ __CLASS__, 'add_setup_post_classes' ], 10, 2 );
	}

	public static function woo_setup() {
		add_theme_support( 'woocommerce' );
		// Other options 'wc-product-gallery-slider', 'wc-product-gallery-zoom'
		$woo_gallery_settings = apply_filters( THEMEDOMAIN . '_woocommerce_gallery_type', [ 'wc-product-gallery-lightbox' ] );

		foreach ( $woo_gallery_settings as $gallery_setting ) {
			add_theme_support( $gallery_setting );
		}
	}

	/* Restructure html to fit Skamstrupfestival structure and layout */
	public static function reorder_layout() {
		remove_action( 'woocommerce_before_main_content', 'woocommerce_output_content_wrapper', 10 );
		remove_action( 'woocommerce_after_main_content', 'woocommerce_output_content_wrapper_end', 10 );

		/**
		* Change the wrappers (start & end) to fit WooCommerce into theme.
		* Hook path: /plugins/woocommerce/templates/single-product.php
		*/
		add_action( 'woocommerce_before_main_content', [ __CLASS__, 'skamstrupfestival_woo_wrapper_start' ], 10 );
		add_action( 'woocommerce_after_main_content', [ __CLASS__, 'skamstrupfestival_woo_wrapper_end' ], 10 );
		add_action( 'woocommerce_sidebar', [ __CLASS__, 'skamstrupfestival_woo_content_main_wrapper_end' ], 10 );

		// Remove post-header content on WooCommerce single 'product'.
		if ( is_product() ) {
			// TODO Hooks has been changed
			// remove_action( THEMEDOMAIN . '_before_main_content', __NAMESPACE__ . '\get_post_featured_caption', 10 );
			// remove_action( THEMEDOMAIN . '_before_main_content', __NAMESPACE__ . '\get_post_title', 10 );
			// remove_action( THEMEDOMAIN . '_before_main_content', __NAMESPACE__ . '\get_post_excerpt', 15 );
			// remove_action( THEMEDOMAIN . '_before_main_content', __NAMESPACE__ . '\get_post_metadata', 20 );

			if ( ! isset( $page_options['disable_featured_image'] ) ) {
				remove_action( THEMEDOMAIN . '_before_main_content', __NAMESPACE__ . '\get_featured_image', 25 );
			}
		}

		// remove second title and description - them displayed under breadcrumb
		add_filter( 'woocommerce_show_page_title', '__return_false' );
		remove_action( 'woocommerce_archive_description', 'woocommerce_taxonomy_archive_description', 10 );

	}

	public static function skamstrupfestival_woo_wrapper_start() {
		echo '<div class="content-main"><main>';
	}

	public static function skamstrupfestival_woo_wrapper_end() {
		echo '</main>';
	}

	public static function skamstrupfestival_woo_content_main_wrapper_end() {
		echo '</div>';
	}

	public static function add_setup_post_classes( $post_classes, $layout ) {

		if ( is_shop() || is_product_category() || is_product_tag() ) {
			unset( $post_classes[ array_search( 'aside-right', $post_classes ) ] );
			unset( $post_classes[ array_search( 'fullwidth', $post_classes ) ] );
			$post_classes[] = 'aside-left';
		}

		if ( is_product() ) {
			unset( $post_classes[ array_search( 'aside-left', $post_classes ) ] );
			unset( $post_classes[ array_search( 'fullwidth', $post_classes ) ] );
			$post_classes[] = 'aside-right';
		}

		return $post_classes;
	}

}

$skamstrupfestival_woocommerce_theming = SkamstrupfestivalWoocommerceTheming::instance();
