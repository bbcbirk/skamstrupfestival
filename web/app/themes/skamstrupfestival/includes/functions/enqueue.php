<?php
/**
 * Enqueueings for the frontend
 *
 * @package Skamstrupfestival
 *
 *
 * @link https://developer.wordpress.org/reference/functions/wp_enqueue_script/
 * @link https://developer.wordpress.org/reference/functions/wp_enqueue_style/
 */

namespace Skamstrupfestival\Theme;

/**
 * Define inflix based on development environment.
 */
function get_inflix() {
	// default to using minified files.
	$inflix = '.min';

	if ( WP_ENV == 'development' ) {
		// default to using development (non-minified) files, if they exist and the environment is local.
		$inflix = ( file_exists( get_template_directory() . '/assets/dist/css/base.css' ) ? '' : '.min' );
	}

	return $inflix;
}

function get_theme_info() {
	// get theme information.
	$theme_info    = [];
	$theme_name    = wp_get_theme()->get_stylesheet();
	$theme         = wp_get_theme( $theme_name );
	$theme_version = $theme && $theme->get( 'Version' ) ? $theme->get( 'Version' ) : '1.0.0';

	$theme_info['name']    = $theme_name;
	$theme_info['theme']   = $theme;
	$theme_info['version'] = $theme_version;

	return $theme_info;
}

/**
 * Loads css in the head and js at the end of body.
 */
function enqueue() {
	// toggle inflix based on environment and file existence.
	$inflix = get_inflix();

	// get theme information.
	$theme_info = get_theme_info() ? get_theme_info() : [];

	// Load external css dependencies
	wp_register_style( 'normalize', 'https://cdnjs.cloudflare.com/ajax/libs/normalize/8.0.1/normalize.min.css', [], '8.0.1' );

	$base_css_deps = [
		'normalize',
		'wp-block-library',
	];

	$base_js_deps = [
		'jquery',
	];

	// Load theme styles
	wp_register_style( 'skamstrupfestival-css-base', get_template_directory_uri() . '/assets/dist/css/base' . $inflix . '.css', $base_css_deps, $theme_info['version'], 'all' );
	wp_enqueue_style( 'skamstrupfestival-css-base' );

	// Scripts file and settings in the footer
	wp_register_script( 'skamstrupfestival-js-base', get_template_directory_uri() . '/assets/dist/js/base' . $inflix . '.js', $base_js_deps, $theme_info['version'], true );
	wp_enqueue_script( 'skamstrupfestival-js-base' );

	// Inbuilt comment reply
	if ( is_singular() && comments_open() && get_option( 'thread_comments' ) == 1 ) {
		wp_enqueue_script( 'comment-reply' );
	}
}

add_action( 'wp_enqueue_scripts', __NAMESPACE__ . '\enqueue', 10 );

/**
 * Loads assets for the backend.
 */
function admin_enqueue() {
	// toggle inflix based on environment and file existence.
	$inflix = get_inflix();
	//
	// get theme information.
	$theme_info = get_theme_info() ? get_theme_info() : [];

	wp_enqueue_style( 'skamstrupfestival-css-base-admin', get_template_directory_uri() . '/assets/dist/css/base-admin' . $inflix . '.css', [], $theme_info['version'], 'all' );

	// Scripts file and settings in the footer
	wp_enqueue_script( 'skamstrupfestival-js-base-admin', get_template_directory_uri() . '/assets/dist/js/base-admin' . $inflix . '.js', [], $theme_info['version'], true );
}

add_action( 'admin_enqueue_scripts', __NAMESPACE__ . '\admin_enqueue' );

/**
 * Add styles for the login screen
 */
function login_enqueue() {
	// toggle inflix based on environment and file existence.
	$inflix = get_inflix();
	//
	// get theme information.
	$theme_info = get_theme_info() ? get_theme_info() : [];

	wp_register_style( 'skamstrupfestival-css-base-login', get_template_directory_uri() . '/assets/dist/css/base-login' . $inflix . '.css', [], $theme_info['version'], 'all' );

	wp_enqueue_style( 'skamstrupfestival-css-base-login' );
}

add_action( 'login_head', __NAMESPACE__ . '\login_enqueue' );
