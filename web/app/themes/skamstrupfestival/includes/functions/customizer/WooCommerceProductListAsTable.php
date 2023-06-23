<?php

namespace Skamstrupfestival\Theme;

use Skamstrupfestival\Theme\Abstracts\CustomizerBase;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class WooCommerceProductListAsTable {

	public static $counter = 0;
	public static $column  = 0;

	public function __construct() {
		add_action( 'customize_register', [ $this, 'init' ] );

		// add_action( 'init', [__CLASS__, 'reorder_layout'] );
		add_action( 'wp', [ __CLASS__, 'reorder_layout' ] );
		// add_action( 'customize_preview_init', [ __CLASS__, 'reorder_layout' ] );
	}

	public function init( $wp_customize ) {
		$customizer = new CustomizerBase( $wp_customize, $this->settings() );
	}

	public function settings() {
		return [
			[
				'section_id' => CustomizerBase::get_key( 'woo_product_list_as_table' ),
				'args'       => [
					'capability' => 'edit_theme_options',
					'title'      => __( 'WooCommerce Product list as table', THEMEDOMAIN ),
				],
				'controls'   => [
					[
						'field_id' => CustomizerBase::get_key( 'product_list_as_table_active' ),
						'type'     => 'checkbox',
						'control'  => [
							'label'     => __( 'Display product list as table', THEMEDOMAIN ),
							'transport' => 'refresh',

						],
					],
					[
						'field_id' => CustomizerBase::get_key( 'product_list_as_table_layout' ),
						'type'     => 'radio',
						'control'  => [
							'label'     => __( 'Display product lists as table', THEMEDOMAIN ),
							'choices'   => [
								''     => 'default',
								'test' => 'Just remove all hooks (experimental)',
							],
							'transport' => 'refresh',
						],
					],
				],
			],
		];
	}

	public static function is_active() {
		$active = get_theme_mod( CustomizerBase::get_key( 'product_list_as_table_active' ), false );

		$active = apply_filters( 'skamstrupfestival_woocommerce_product_list_as_table__active', $active );
		return $active;
	}

	public static function reorder_layout() {

		//dont run if settings not is active, or we are in backend
		if ( ! self::is_active() || is_admin() ) {
			return;
		}

		/**
		 * @Note there is an issue with Woo gutenberg blocks, if we change the columns - the blocks will be invalid.
		 * @Note skip support for Woo gutenberg blocks for now
		 */

		add_filter(
			'loop_shop_columns',
			function( $columns ) {
				return 1;
			}
		);
		add_filter(
			'woocommerce_related_products_columns',
			function( $columns ) {
				return 1;
			}
		);
		add_filter(
			'woocommerce_upsells_columns',
			function( $columns ) {
				return 1;
			}
		);

		/*
		Remove all hooks first
		*/
		remove_action( 'woocommerce_before_shop_loop_item', 'woocommerce_template_loop_product_link_open', 10 );
		remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_product_link_close', 5 );
		remove_action( 'woocommerce_after_shop_loop_item', 'woocommerce_template_loop_add_to_cart', 10 );
		remove_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', 10 );
		remove_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', 10 );

		remove_action( 'woocommerce_before_subcategory', 'woocommerce_template_loop_category_link_open', 10 );
		remove_action( 'woocommerce_shop_loop_subcategory_title', 'woocommerce_template_loop_category_title', 10 );
		remove_action( 'woocommerce_after_subcategory', 'woocommerce_template_loop_category_link_close', 10 );

		remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', 10 );
		remove_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_rating', 5 );

		self::layout_switch();

		self::add_quantity_script();
	}

	public static function layout_switch() {
		$layout = get_theme_mod( CustomizerBase::get_key( 'product_list_as_table_layout' ), false );
		$layout = apply_filters( 'skamstrupfestival_woocommerce_product_list_as_table__layout', $layout );
		switch ( $layout ) {
			case 'test':
				# code...
				break;
			case 'default':
			default:
				if ( ! has_action( 'skamstrupfestival_woocommerce_product_list_as_table__custom_layout' ) ) {
					self::layout_default();
				}
				break;
		}

		do_action( 'skamstrupfestival_woocommerce_product_list_as_table__custom_layout', $layout );
	}

	public static function layout_default() {

		// Image
		$col                                      = 1;
		$col_counter                              = $col * 100; // @NOTE we uses col_counter in hundreds, to explicity tell the column number. 100 = col-1, 200 = col-2
		$settings['columns'][ $col ]['label']     = 'Image';
		$settings['columns'][ $col ]['classes'][] = 'image';
		$settings['columns'][ $col ]['classes'][] = 'col-' . $col;
		self::add_div_open( 'woocommerce_before_shop_loop_item_title', $col_counter++, $settings['columns'][ $col ] );
		add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_link_open', $col_counter++ );
		add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_thumbnail', $col_counter++ );
		add_action( 'woocommerce_before_shop_loop_item_title', 'woocommerce_template_loop_product_link_close', $col_counter++ );
		self::add_div_close( 'woocommerce_before_shop_loop_item_title', $col_counter++ );

		// Title and excerpt
		$col                                      = 2;
		$col_counter                              = $col * 100; // @NOTE we uses col_counter in hundreds, to explicity tell the column number. 100 = col-1, 200 = col-2
		$settings['columns'][ $col ]['label']     = 'Products';
		$settings['columns'][ $col ]['classes'][] = 'test';
		$settings['columns'][ $col ]['classes'][] = 'col-' . $col;
		self::add_div_open( 'woocommerce_shop_loop_item_title', $col_counter++, $settings['columns'][ $col ] );
		add_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_link_open', $col_counter++ );
		add_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_title', $col_counter++ );
		add_action( 'woocommerce_shop_loop_item_title', 'woocommerce_template_loop_product_link_close', $col_counter++ );
		add_action( 'woocommerce_shop_loop_item_title', [ __CLASS__, 'the_excerpt' ], $col_counter++ );
		self::add_div_close( 'woocommerce_shop_loop_item_title', $col_counter++ );

		// Price
		$col                                      = 3;
		$col_counter                              = $col * 100; // @NOTE we uses col_counter in hundreds, to explicity tell the column number. 100 = col-1, 200 = col-2
		$settings['columns'][ $col ]['label']     = 'Price';
		$settings['columns'][ $col ]['classes'][] = 'test';
		$settings['columns'][ $col ]['classes'][] = 'col-' . $col;
		self::add_div_open( 'woocommerce_after_shop_loop_item_title', $col_counter++, $settings['columns'][ $col ] );
		add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_price', $col_counter++ );
		self::add_div_close( 'woocommerce_after_shop_loop_item_title', $col_counter++ );

		// Quantity
		$col                                      = 4;
		$col_counter                              = $col * 100; // @NOTE we uses col_counter in hundreds, to explicity tell the column number. 100 = col-1, 200 = col-2
		$settings['columns'][ $col ]['label']     = 'Buy';
		$settings['columns'][ $col ]['classes'][] = 'test';
		$settings['columns'][ $col ]['classes'][] = 'col-' . $col;
		self::add_div_open( 'woocommerce_after_shop_loop_item_title', $col_counter++, $settings['columns'][ $col ] );
		add_action( 'woocommerce_after_shop_loop_item_title', [ __CLASS__, 'quantity_field' ], $col_counter++ );
		self::add_div_close( 'woocommerce_after_shop_loop_item_title', $col_counter++ );

		//Add to cart
		$col                                      = 5;
		$col_counter                              = $col * 100; // @NOTE we uses col_counter in hundreds, to explicity tell the column number. 100 = col-1, 200 = col-2
		$settings['columns'][ $col ]['label']     = '';
		$settings['columns'][ $col ]['classes'][] = 'test';
		$settings['columns'][ $col ]['classes'][] = 'col-' . $col;
		self::add_div_open( 'woocommerce_after_shop_loop_item_title', $col_counter++, $settings['columns'][ $col ] );
		add_action( 'woocommerce_after_shop_loop_item_title', 'woocommerce_template_loop_add_to_cart', $col_counter++ );
		self::add_div_close( 'woocommerce_after_shop_loop_item_title', $col_counter++ );

		//total colomns
		$settings['columns_total'] = count( $settings['columns'] );

		//list class
		self::change_list_classes( $settings );

		//head row
		self::add_columns_headers( $settings );
	}

	public static function layout_test() {

	}

	public static function change_list_classes( $settings = [] ) {
		add_filter(
			'woocommerce_product_loop_start',
			function( $html = '' ) use ( $settings ) {
				$classes          = [
					'key'  => 'product-list-as-table__wrapper',
					'cols' => 'product-list-as-table__cols-' . $settings['columns_total'],
				];
				$new_class_string = '<ul class="products ' . implode( ' ', array_map( 'sanitize_html_class', $classes ) ) . ' ';
				$new_html         = str_replace( '<ul class="products ', $new_class_string, $html );
				return $new_html;
			},
			10
		);
	}

	public static function add_columns_headers( $settings ) {
		add_filter(
			'woocommerce_product_loop_start',
			function( $html = '' ) use ( $settings ) {
				$columns = $settings['columns'] ?? [];
				$classes = [
					'key' => 'product-list-as-table__wrapper ',
					'product-list-as-table__headers',
					'product-list-as-table__cols-' . $settings['columns_total'],
				];

				ob_start();
				self::div_open( [ 'classes' => $classes ] );
				foreach ( $columns as $column_key => $column ) {
					self::div_open( $column );
					echo $column['label'] ?? '';
					self::div_close();
				}
				self::div_close();
				$headers_string = ob_get_clean();

				$new_html = $headers_string . $html;

				return $new_html;
			},
			5
		);
	}

	public static function add_div_open( $hook, $priority, $atts = [] ) {
		add_action(
			$hook,
			function() use ( $atts ) {
				return self::div_open( $atts );
			},
			$priority
		);
	}

	public static function add_div_close( $hook, $priority ) {
		add_action( $hook, [ __CLASS__, 'div_close' ], $priority );
	}

	public static function div_open( $atts = [] ) {

		$classes = [];

		// $classes['current_action'] = current_action();
		$classes = array_merge( $classes, (array) $atts['classes'] );
		$output  = '<div class="' . implode( ' ', array_map( 'sanitize_html_class', $classes ) ) . '">';
		echo $output;
	}

	public static function div_close() {
		echo '</div>';
	}

	public static function the_excerpt( $atts = [] ) {
		$atts['the_excerpt'] = 'the_excerpt';
		self::div_open( $atts );
		the_excerpt();
		self::div_close();

	}

	public static function quantity_field( $atts ) {
		$product = wc_get_product( get_the_ID() );

		if ( ! $product->is_sold_individually() && 'variable' != $product->product_type && $product->is_purchasable() ) {
			woocommerce_quantity_input(
				[
					'min_value' => 1,
					'max_value' => $product->backorders_allowed() ? '' : $product->get_stock_quantity(),
				]
			);
		}
	}

	public static function add_quantity_script() {
		wc_enqueue_js(
			'
		jQuery( "ul.products" ).on( "change input", ".quantity .qty", function() {
			var add_to_cart_button = jQuery( this ).parents( ".product" ).find( ".add_to_cart_button" );
			// For AJAX add-to-cart actions
			add_to_cart_button.data( "quantity", jQuery( this ).val() );
			// For non-AJAX add-to-cart actions
			add_to_cart_button.attr( "href", "?add-to-cart=" + add_to_cart_button.attr( "data-product_id" ) + "&quantity=" + jQuery( this ).val() );
		});
	'
		);
	}

}

new WooCommerceProductListAsTable();
