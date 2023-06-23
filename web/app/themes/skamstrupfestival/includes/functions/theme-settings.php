<?php

namespace Skamstrupfestival\Theme;

use WP_Customize_Color_Control;
use WP_Customize_Control;
use WP_Customize_Image_Control;
use WP_Customize_Media_Control;
use Skamstrupfestival\Theme\Abstracts\CustomizerBase;

if ( ! defined( 'ABSPATH' ) ) {
	exit; // Exit if accessed directly.
}

class ThemeSettings {

	public static $color_1_default = '#1a1a1a';
	public static $color_2_default = '#edeeef';
	public static $color_3_default = '#26262a';
	public static $color_4_default = '#ffffff';

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
		// add_action( 'wp_head', [ $this, 'customize_css' ] );
		// add_action( 'admin_head', [ $this, 'customize_css' ] );

		// Add global css variabels based on theme settings
		add_action( 'wp_enqueue_scripts', [ $this, 'customize_css' ], 0 );
		add_action( 'admin_enqueue_scripts', [ $this, 'customize_css' ], 0 );

		// Add globals script variables based on theme settings
		add_action( 'wp_enqueue_scripts', [ $this, 'add_global_js_vars' ], 5 );
		add_action( 'admin_enqueue_scripts', [ $this, 'add_global_js_vars' ], 5 );

		add_filter( THEMEDOMAIN . '_settings_colors', [ $this, 'init_default_colors' ] );
	}

	public static function get_key( $key ) {
		return CustomizerBase::get_prefix() . '_' . $key;
	}

	public static function get_prefix() {
		return THEMEDOMAIN;
	}

	/**
	 * Add any relevant custom css rules to the head.
	 */
	public function customize_css() {
		$colors    = $this->get_theme_colors();
		$is_local  = WP_ENV == 'development';
		$separator = $is_local ? "\n" : ''; // toggles between new lines and an empty string.
		$indent    = $is_local ? "\t" : ''; // toggles bewteen a tab character and an empty string.

		$css = ':root {';

		$css .= $separator;

		foreach ( $colors as $color_key => $color_value ) {
			if ( ++$color_key === count( $colors ) ) {
				$separator = ''; // prevents two new lines before closing curly braces `}`.
			}

			// build root-variables and value structure.
			$css .= sprintf(
				'%s%s: %s;%s',
				$indent,
				isset( $color_value['root-variable'] ) ? $color_value['root-variable'] : '',
				isset( $color_value['values']['hex'] ) ? $color_value['values']['hex'] : '',
				$separator
			);
		}

		$separator = $is_local ? "\n" : ''; // reset `$separator`.

		$css .= $separator;

		$css .= '}';

		$css = apply_filters( THEMEDOMAIN . '_css_theme_settings', $css );

		$handle = 'skamstrupfestival-css-theme-settings';
		\Skamstrupfestival\Theme\add_inline_css( $css, $handle );
	}

	public function get_theme_colors() {
		$colors = [
			[
				'name'          => esc_attr__( 'Primary Color', THEMEDOMAIN ),
				'slug'          => 'color-1',
				'values'        => [
					'hex'      => get_theme_mod( self::get_key( 'color_1' ), self::$color_1_default ),
					'variable' => 'var(--color-1)',
				],
				'root-variable' => '--color-1',
			],
			[
				'name'          => esc_attr__( 'Secondary Color', THEMEDOMAIN ),
				'slug'          => 'color-2',
				'values'        => [
					'hex'      => get_theme_mod( self::get_key( 'color_2' ), self::$color_2_default ),
					'variable' => 'var(--color-2)',
				],
				'root-variable' => '--color-2',
			],
			[
				'name'          => esc_attr__( 'Contrast Color 1', THEMEDOMAIN ),
				'slug'          => 'color-3',
				'values'        => [
					'hex'      => get_theme_mod( self::get_key( 'color_3' ), self::$color_3_default ),
					'variable' => 'var(--color-3)',
				],
				'root-variable' => '--color-3',
			],
			[
				'name'          => esc_attr__( 'Contrast Color 2', THEMEDOMAIN ),
				'slug'          => 'color-4',
				'values'        => [
					'hex'      => get_theme_mod( self::get_key( 'color_4' ), self::$color_4_default ),
					'variable' => 'var(--color-4)',
				],
				'root-variable' => '--color-4',
			],
		];

		return $colors;
	}

	/**
	 * Add default color variables for plugins.
	 *
	 * @return $icons string Array of colors to use with var().
	 */
	public function init_default_colors( $colors ) {
		$default_colors = $this->get_theme_colors() ? $this->get_theme_colors() : [];

		$new_colors = is_array( $default_colors ) && is_array( $colors ) ? array_merge( $default_colors, $colors ) : [];

		return $new_colors;
	}

	/**
	 * Add js vars for Theme Settings in the backend and frontend to use in for example Gutenberg blocks.
	 */
	public function add_global_js_vars() {
		$theme_settings = [
			'colors' => apply_filters( THEMEDOMAIN . '_settings_colors', [] ),
		];

		//we register the script with no file. That way, we can also use this handle to add dynamic inline scripts using wp_add_inline_script()
		wp_register_script( 'skamstrupfestival-js-theme-settings', false );
		wp_enqueue_script( 'skamstrupfestival-js-theme-settings' );
		wp_localize_script( 'skamstrupfestival-js-theme-settings', 'skamstrupfestivalSettings', apply_filters( THEMEDOMAIN . '_js_theme_settings', $theme_settings ) );
	}

}

$themesettings = ThemeSettings::instance();
