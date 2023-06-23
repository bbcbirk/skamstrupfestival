<?php

namespace Skamstrupfestival\Theme;

use Skamstrupfestival\Theme\Abstracts\CustomizerBase;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class VisualSettings {

	public function __construct() {
		add_action( 'customize_register', [ $this, 'init' ] );
	}

	public function init( $wp_customize ) {
		$customizer = new CustomizerBase( $wp_customize, $this->settings() );
	}

	public function settings() {
		return [
			[
				'section_id' => CustomizerBase::get_key( 'visual_settings' ),
				'args'       => [
					'capability' => 'edit_theme_options',
					'title'      => __( 'Visual Settings', THEMEDOMAIN ),
				],
				'controls'   => [
					[
						'field_id' => CustomizerBase::get_key( 'color_1' ),
						'type'     => 'color',
						'args'     => [
							'default' => ThemeSettings::$color_1_default,
						],
						'control'  => [
							'label' => __( 'Color 1', THEMEDOMAIN ),
						],
					],
					[
						'field_id' => CustomizerBase::get_key( 'color_2' ),
						'type'     => 'color',
						'args'     => [
							'default' => ThemeSettings::$color_2_default,
						],
						'control'  => [
							'label' => __( 'Color 2', THEMEDOMAIN ),
						],
					],
					[
						'field_id' => CustomizerBase::get_key( 'color_3' ),
						'type'     => 'color',
						'args'     => [
							'default' => ThemeSettings::$color_3_default,
						],
						'control'  => [
							'label' => __( 'Color 3', THEMEDOMAIN ),
						],
					],
					[
						'field_id' => CustomizerBase::get_key( 'color_4' ),
						'type'     => 'color',
						'args'     => [
							'default' => ThemeSettings::$color_4_default,
						],
						'control'  => [
							'label' => __( 'Color 4', THEMEDOMAIN ),
						],
					],
					[
						'field_id' => CustomizerBase::get_key( 'color_5' ),
						'type'     => 'color',
						'args'     => [
							'default' => ThemeSettings::$color_5_default,
						],
						'control'  => [
							'label' => __( 'Color 5', THEMEDOMAIN ),
						],
					],
					[
						'field_id' => CustomizerBase::get_key( 'font_1' ),
						'type'     => 'text',
						'control'  => [
							'description' => __( 'Add a link href value from the Embed dialog on Google Fonts. Example: https://fonts.googleapis.com/css?family=IBM+Plex+Sans+Condensed', THEMEDOMAIN ),
							'label'       => __( 'Header font path', THEMEDOMAIN ),
						],
					],
					[
						'field_id' => CustomizerBase::get_key( 'font_1_stack' ),
						'type'     => 'text',
						'control'  => [
							'description' => __( 'Add a CSS rule value from the Embed dialog on Google Fonts. Example: \'IBM Plex Sans Condensed\', sans-serif', THEMEDOMAIN ),
							'label'       => __( 'Header font CSS stack', THEMEDOMAIN ),
						],
					],
					[
						'field_id' => CustomizerBase::get_key( 'font_2' ),
						'type'     => 'text',
						'control'  => [
							'description' => __( 'Add a link href value from the Embed dialog on Google Fonts. Example: https://fonts.googleapis.com/css?family=IBM+Plex+Sans+Condensed', THEMEDOMAIN ),
							'label'       => __( 'Text font path', THEMEDOMAIN ),
						],
					],
					[
						'field_id' => CustomizerBase::get_key( 'font_2_stack' ),
						'type'     => 'text',
						'control'  => [
							'description' => __( 'Add a CSS rule value from the Embed dialog on Google Fonts. Example: \'IBM Plex Sans Condensed\', sans-serif', THEMEDOMAIN ),
							'label'       => __( 'Text font CSS stack', THEMEDOMAIN ),
						],
					],
					[
						'field_id' => CustomizerBase::get_key( 'hide_author' ),
						'type'     => 'checkbox',
						'control'  => [
							'label' => __( 'Hide author on posts', THEMEDOMAIN ),
						],
					],
					[
						'field_id' => CustomizerBase::get_key( 'hide_date' ),
						'type'     => 'checkbox',
						'control'  => [
							'label' => __( 'Hide date on posts', THEMEDOMAIN ),
						],
					],
					[
						'field_id' => CustomizerBase::get_key( 'hide_search' ),
						'type'     => 'checkbox',
						'control'  => [
							'label' => __( 'Hide search', THEMEDOMAIN ),
						],
					],
				],
			],
		];
	}

}

new VisualSettings();
