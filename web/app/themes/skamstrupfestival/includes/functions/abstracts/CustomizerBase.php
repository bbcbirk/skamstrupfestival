<?php

namespace Skamstrupfestival\Theme\Abstracts;

use WP_Customize_Color_Control;
use WP_Customize_Control;
use WP_Customize_Image_Control;
use WP_Customize_Media_Control;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

/**
 * Baseclase to generete Customizer Controls
 */
class CustomizerBase {

	/**
	 * multidimentional array widt control settings
	 *
	 * @var array
	 */
	public $settings;

	/**
	 * $wp-customizer object from the init hook
	 *
	 * @var array
	 */
	public $wp_customize;

	/**
	 * Constructor
	 *
	 * @param object $wp_customize
	 * @param array $settings
	 */
	public function __construct( $wp_customize, $settings ) {
		$this->wp_customize = $wp_customize;
		$this->settings     = $settings;

		if ( $this->settings !== null ) {
			$this->build_customizer_settings();
		}
	}

	/**
	 * Make perefixed key
	 *
	 * @param string $key
	 * @return string
	 */
	public static function get_key( $key ) {
		return self::get_prefix() . '_' . $key;
	}

	/**
	 * return prefix
	 *
	 * @return sting
	 */
	public static function get_prefix() {
		return THEMEDOMAIN;
	}

	/**
	 * buld customizer settings sections
	 *
	 * @return void
	 */
	public function build_customizer_settings() {
		// loop over sections
		foreach ( $this->settings as $section ) {
			$this->wp_customize->add_section( $section['section_id'], $section['args'] );

			$this->build_costomizer_controls( $section['controls'], $section['section_id'] );
		}
	}

	/**
	 * build customizer settongs controls
	 *
	 * @param array $controls with controls
	 * @param string $section_id: the name of the section
	 * @return void
	 */
	public function build_costomizer_controls( $controls, $section_id ) {
		foreach ( $controls as $control ) {
			// add as setting
			$this->wp_customize->add_setting( $control['field_id'] );

			$args            = $control['control'] ?? [];
			$args['section'] = $section_id;
			$args['setting'] = $control['field_id'];
			$args['type']    = $control['type'];

			if ( isset( $control['handler_class'] ) ) {
				if ( class_exists( $control['handler_class'] ) ) {
					$this->wp_customize->add_control(
						new $control['handler_class']( $this->wp_customize, $control['field_id'], $args )
					);
				}
			} elseif ( $control['type'] == 'color' ) {
				$this->wp_customize->add_control(
					new WP_Customize_Color_Control( $this->wp_customize, $control['field_id'], $args )
				);
			} elseif ( $control['type'] == 'media' ) {
				$this->wp_customize->add_control(
					new WP_Customize_Media_Control( $this->wp_customize, $control['field_id'], $args )
				);
			} elseif ( $control['type'] == 'image' ) {
				$this->wp_customize->add_control(
					new WP_Customize_Image_Control( $this->wp_customize, $control['field_id'], $args )
				);
			} else {
				$this->wp_customize->add_control(
					new WP_Customize_Control( $this->wp_customize, $control['field_id'], $args )
				);
			}
		}
	}

}
