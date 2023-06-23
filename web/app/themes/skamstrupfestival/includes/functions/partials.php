<?php

namespace Skamstrupfestival\Theme;

/**
 * Template parts
 *
 */
function get_breadcrumb() {
	return get_template_part( 'partials/breadcrumb' );
}

function get_post_title() {
	return get_template_part( 'partials/post', 'title' );
}

function get_hero() {
	return get_template_part( 'partials/page', 'hero' );
}

function get_post_excerpt() {
	return get_template_part( 'partials/post', 'excerpt' );
}

function get_post_featured_caption() {
	return get_template_part( 'partials/post', 'featured-caption' );
}

function get_post_metadata() {
	return get_template_part( 'partials/post', 'metadata' );
}

function get_post_terms() {
	return get_template_part( 'partials/post', 'terms' );
}

function get_featured_image() {
	return get_template_part( 'partials/post', 'featured' );
}

function get_archive_header() {
	return get_template_part( 'partials/archive', 'header' );
}

function get_archive_hero() {
	return get_template_part( 'partials/archive', 'hero' );
}

function get_archive_footer() {
	return get_template_part( 'partials/archive', 'footer' );
}

function get_post_pagination() {
	return get_template_part( 'partials/post', 'pagination' );
}

function get_search_form() {
	\get_search_form();
}

/**
 * Load template partials on defined hooks
 *
 * @return void
 */
function load_template_partials() {

	/**
	 * Actions
	 */

	// On archive pages
	if ( is_archive() || is_search() || is_home() ) {
		add_action( THEMEDOMAIN . '_primary_content_top', __NAMESPACE__ . '\get_archive_header' );
		add_action( THEMEDOMAIN . '_primary_content_top', __NAMESPACE__ . '\get_archive_hero' );
		add_action( THEMEDOMAIN . '_primary_content_bottom', __NAMESPACE__ . '\get_archive_footer', 5 );
		add_action( THEMEDOMAIN . '_archive_footer', __NAMESPACE__ . '\get_post_pagination', 10 );
	}

	// On search page
	if ( is_search() ) {
		add_action( THEMEDOMAIN . '_primary_content_top', __NAMESPACE__ . '\get_search_form', 10 );
	}

	// On all singular views except pages, where we use hero.
	if ( is_singular() && ! is_front_page() && ! is_page() ) {
		add_action( THEMEDOMAIN . '_primary_content_top', __NAMESPACE__ . '\get_post_title', 10 );
		add_action( THEMEDOMAIN . '_primary_content_top', __NAMESPACE__ . '\get_post_excerpt', 15 );
		add_action( THEMEDOMAIN . '_primary_content_top', __NAMESPACE__ . '\get_post_metadata', 20 );
		add_action( THEMEDOMAIN . '_primary_content_top', __NAMESPACE__ . '\get_featured_image', 25 );
		add_action( THEMEDOMAIN . '_primary_content_top', __NAMESPACE__ . '\get_post_featured_caption', 30 );
	}

	// On pages.
	if ( is_page() ) {
		add_action( THEMEDOMAIN . '_primary_content_top', __NAMESPACE__ . '\get_hero', 10 );
	}

}

add_action( 'wp', __NAMESPACE__ . '\load_template_partials', 10 );
