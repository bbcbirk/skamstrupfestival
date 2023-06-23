<?php

namespace Skamstrupfestival\Theme;

use Skamstrupfestival\Theme\Abstracts\CustomizerBase;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class WooCommerceProductGallery {

	public function __construct() {
		add_action( 'customize_register', [ $this, 'init' ] );

		add_filter( THEMEDOMAIN . '_woocommerce_gallery_type', [ $this, 'activate_product_gallery_settings' ], 10, 1 );
	}

	public function init( $wp_customize ) {
		$customizer = new CustomizerBase( $wp_customize, $this->settings() );
	}

	public function settings() {
		return [
			[
				'section_id' => CustomizerBase::get_key( 'woo_product_gallery' ),
				'args'       => [
					'capability' => 'edit_theme_options',
					'title'      => __( 'Product Gallery', THEMEDOMAIN ),
					'panel'      => 'woocommerce',
				],
				'controls'   => [
					[
						'field_id' => CustomizerBase::get_key( 'product_gallery_zoom' ),
						'type'     => 'checkbox',
						'control'  => [
							'label' => __( 'Zoom', THEMEDOMAIN ),
						],
					],
					[
						'field_id' => CustomizerBase::get_key( 'product_gallery_ligthbox' ),
						'type'     => 'checkbox',
						'control'  => [
							'label' => __( 'Ligthbox', THEMEDOMAIN ),
						],
					],
					[
						'field_id' => CustomizerBase::get_key( 'product_gallery_slider' ),
						'type'     => 'checkbox',
						'control'  => [
							'label' => __( 'Slider', THEMEDOMAIN ),
						],
					],
				],
			],
		];
	}

	public function activate_product_gallery_settings( $theme_support ) {

		$theme_support_new = [];
		if ( get_theme_mod( CustomizerBase::get_key( 'product_gallery_ligthbox' ) ) ) {
			$theme_support_new[] = 'wc-product-gallery-lightbox';
		}

		if ( get_theme_mod( CustomizerBase::get_key( 'product_gallery_slider' ) ) ) {
			$theme_support_new[] = 'wc-product-gallery-slider';
		}

		if ( get_theme_mod( CustomizerBase::get_key( 'product_gallery_zoom' ) ) ) {
			$theme_support_new[] = 'wc-product-gallery-zoom';
		}

		return $theme_support_new;

	}

}

new WooCommerceProductGallery();
