<?php

/**
 * The idea is good enough but the customizer API is yet to fully support this behavior.
 * The main problem is, that the post id is getting send through any of the methods, which
 * means that we have no reliable way of knowing what page we're on and therefor where to
 * save the post meta.
 *
 * For now we'll keep this around and see if we can find a solution
 */

namespace Skamstrupfestival\Theme;

use WP_Customize_Media_Control;
use WP_Customize_Image_Control;

class PageSettings {

	public function __construct() {
		add_action( 'customize_register', [ $this, 'init' ] );
		add_action( 'customize_update_post_meta', [ $this, 'customize_update_post_meta' ], 10, 2 );
	}

	public static function get_key( $key ) {
		return self::get_prefix() . '_' . $key;
	}

	public static function get_prefix() {
		return THEMEDOMAIN;
	}

	public function settings() {
		return [
			'page_layout'       => [
				'setting_type' => 'post_meta',
				'label'        => __( 'Page Layout', THEMEDOMAIN ),
				'input_type'   => 'radio',
				'default'      => 'normal',
				'choices'      => [
					'normal' => __( 'Normal page', THEMEDOMAIN ),
					'widget' => __( 'Widget page', THEMEDOMAIN ),
				],
			],
			'show_process_menu' => [
				'setting_type' => 'post_meta',
				'label'        => __( 'Show process menu', THEMEDOMAIN ),
				'input_type'   => 'checkbox',
				'default'      => '',
			],
		];
	}

	public function init( $wp_customize ) {

		$wp_customize->add_section(
			'page_options',
			[
				'title'    => __( 'Page Options', THEMEDOMAIN ),
				'priority' => 130,
			]
		);

		foreach ( $this->settings() as $key => $setting ) {
			$wp_customize->add_setting(
				$key,
				[
					'type'    => $setting['setting_type'],
					'default' => $setting['default'],
				]
			);

			$control_arg = [
				'section' => 'page_options',
				'label'   => $setting['label'],
				'type'    => $setting['input_type'],
			];

			if ( isset( $setting['description'] ) ) {
				$control_arg['description'] = $setting['description'];
			}

			if ( isset( $setting['choices'] ) ) {
				$control_arg['choices'] = $setting['choices'];
			}

			$wp_customize->add_control( $key, $control_arg );
		}
	}

	public function customize_update_post_meta( $value, $setting ) {
		update_post_meta( 11, $setting->id, $value );
	}

}

new PageSettings();
