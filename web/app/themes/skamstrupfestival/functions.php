<?php
/**
 * The main functions file for WordPress Theme Features
 *
 * @link http://codex.wordpress.org/Theme_Features
 * @link http://codex.wordpress.org/Functions_File_Explained
 *
 * @package Skamstrupfestival
 */

namespace Skamstrupfestival\Theme;

// Theme domain for translations
if ( ! defined( 'THEMEDOMAIN' ) ) {
	define( 'THEMEDOMAIN', 'skamstrupfestival' );
}

/**
 * Backwards Compatibility
 */
include_once( 'includes/functions/backwards-compatibility.php' );

/**
 * Theme setup
 */

includes(); // Include files

function theme_setup() {
	load_theme_textdomain( THEMEDOMAIN, get_template_directory() . '/languages' ); // Loads theme languages
	theme_support();  // Theme support
	image_sizes();    // Image sizes
	navigation();     // Navigation
	setup_sidebars(); // Sidebars
	load_woocommerce_elements();

	new AdminMenu();
	new BemMarkup();
	new PictureSrcset();
	new HeroVideo();
	new Template();   // Heart of the theme templating
}

add_action( 'after_setup_theme', __NAMESPACE__ . '\theme_setup' );

function includes() {
	// Include class files
	get_template_part( 'includes/classes/admin-menu' );
	get_template_part( 'includes/classes/breadcrumb' );
	get_template_part( 'includes/classes/hero' );
	get_template_part( 'includes/classes/global-elements' );
	get_template_part( 'includes/classes/sidebar' );
	get_template_part( 'includes/classes/template' );
	get_template_part( 'includes/classes/bem-markup' );
	get_template_part( 'includes/classes/picture-srcset' );
	get_template_part( 'includes/classes/hero-video' );

	// Include function files
	get_template_part( 'includes/functions/admin' );
	get_template_part( 'includes/functions/enqueue' );
	get_template_part( 'includes/functions/helpers' );
	get_template_part( 'includes/functions/hooks' );
	get_template_part( 'includes/functions/menus' );
	// get_template_part( 'includes/functions/page-settings' );
	get_template_part( 'includes/functions/partials' );
	get_template_part( 'includes/functions/search' );
	get_template_part( 'includes/functions/setup-sidebars' );
	get_template_part( 'includes/functions/theme-settings' );
	get_template_part( 'includes/functions/gravity-forms' );
	get_template_part( 'includes/functions/carbon-fields' );

	get_template_part( 'includes/functions/abstracts/CustomizerBase' );
	// get_template_part( 'includes/functions/customizer/VisualSettings' );
	get_template_part( 'includes/functions/customizer/404Settings' );

	// Theme structure files
	get_template_part( 'includes/markup/markup-body-top' );
	get_template_part( 'includes/markup/markup-footer' );
	get_template_part( 'includes/markup/markup-header' );
	get_template_part( 'includes/markup/markup-primary' );

	// @NOTE Just an idea for now. Not even sure if I think it should be here.
	if ( is_multisite() ) {
		get_template_part( 'includes/functions/multisite' );
	}
}

function theme_support() {
	$theme_settings        = ThemeSettings::instance();
	$default_color_palette = [];

	foreach ( $theme_settings->get_theme_colors() as $color ) {
		$default_color_palette[] = [
			'name'  => isset( $color['name'] ) ? $color['name'] : '',
			'slug'  => isset( $color['slug'] ) ? $color['slug'] : '',
			'color' => isset( $color['values']['hex'] ) ? $color['values']['hex'] : '',
		];
	}

	add_theme_support( 'align-wide' );
	add_theme_support( 'automatic_feed_links' );
	add_theme_support( 'custom-logo' );
	add_theme_support( 'html5', [ 'search-form', 'comment-list', 'comment-form', 'gallery', 'caption' ] );
	add_theme_support( 'menus' );
	add_theme_support( 'post-thumbnails' );
	add_theme_support( 'title-tag' );
	add_theme_support( 'woocommerce' );
	add_theme_support(
		'editor-color-palette',
		$default_color_palette
	);
}

function navigation() {
	// @TODO possibly move this to includes/functions/menus.php
	register_nav_menus(
		[
			'main-nav'   => __( 'Main Menu', THEMEDOMAIN ),
			'mobile-nav' => __( 'Mobile Menu', THEMEDOMAIN ),
		]
	);
}

function image_sizes() {
	set_post_thumbnail_size( 125, 125, true );                    // default thumb size
	add_image_size( 'skamstrupfestival-small', 300, 169, true );             // 16/9 small
	add_image_size( 'skamstrupfestival-medium', 575, 324, true );            // 16/9 medium
	add_image_size( 'skamstrupfestival-large', 800, 450, true );             // 16/9 large
	add_image_size( 'skamstrupfestival-xlarge', 1190, 669, true );           // 16/9 xlarge
	add_image_size( 'skamstrupfestival-post-archive', 360, 360, true );      // Post archive
	add_image_size( 'skamstrupfestival-hero-s', 400, 314, true );            // Hero <picture>
	add_image_size( 'skamstrupfestival-hero-m', 720, 314, true );            // Hero <picture>
	add_image_size( 'skamstrupfestival-hero-l', 1040, 314, true );           // Hero <picture>
	add_image_size( 'skamstrupfestival-hero-xl', 1440, 314, true );          // Hero <picture>
	add_image_size( 'skamstrupfestival-post-featured-s', 400, 205, true );   // Post featured <picture>
	add_image_size( 'skamstrupfestival-post-featured-m', 720, 400, true );   // Post featured <picture>
	add_image_size( 'skamstrupfestival-post-featured-l', 1040, 570, true );  // Post featured <picture>
	add_image_size( 'skamstrupfestival-post-featured-xl', 1190, 650, true ); // Post featured <picture>
}

/* Run WooCommerce specific hooks */
function load_woocommerce_elements() {
	include_once( ABSPATH . 'wp-admin/includes/plugin.php' );

	if ( is_plugin_active( 'woocommerce/woocommerce.php' ) ) {
		get_template_part( 'includes/functions/woocommerce-functions' ); // File currently not in use
		get_template_part( 'includes/functions/woocommerce-theming' );
	}
}
