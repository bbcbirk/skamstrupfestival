<?php

namespace Skamstrupfestival\Theme;

use Skamstrupfestival\Theme\Abstracts\CustomizerBase;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class Settings404 {

	public function __construct() {
		add_action( 'customize_register', [ $this, 'init' ] );

		// set robots header to noindex,follow when accessing the original page
		add_filter( 'wpseo_robots', [ $this, 'yoast_seo_robots_overwrite' ] );
	}

	public function init( $wp_customize ) {
		$customizer = new CustomizerBase( $wp_customize, $this->settings() );
	}

	public function settings() {
		return [
			[
				'section_id' => CustomizerBase::get_key( 'settings_404' ),
				'args'       => [
					'capability' => 'edit_theme_options',
					'title'      => __( '404 Settings', THEMEDOMAIN ),
				],
				'controls'   => [
					[
						'field_id' => CustomizerBase::get_key( 'title_404' ),
						'type'     => 'text',
						'control'  => [
							'label' => __( 'Title', THEMEDOMAIN ),
						],
					],
					[
						'field_id' => CustomizerBase::get_key( 'text_404' ),
						'type'     => 'textarea',
						'control'  => [
							'label' => __( 'Text', THEMEDOMAIN ),
						],
					],
					[
						'field_id' => CustomizerBase::get_key( 'custom_404_page' ),
						'type'     => 'dropdown-pages',
						'control'  => [
							'label' => __( 'Chose custom page to show as 404 page', THEMEDOMAIN ),
						],
					],
				],
			],
		];
	}

	// set robots header to noindex,follow when accessing the original page
	public function yoast_seo_robots_overwrite( $robots ) {
		$custom_404_page_custom = apply_filters( THEMEDOMAIN . '_custom_404_page', get_theme_mod( THEMEDOMAIN . '_custom_404_page', false ) );
		if ( ! empty( $custom_404_page_custom ) && is_page( intval( $custom_404_page_custom ) ) ) {
			return 'noindex,follow';
		} else {
			return $robots;
		}
	}

}

new Settings404();
