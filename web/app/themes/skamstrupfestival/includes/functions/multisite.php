<?php
/**
 * Hooks for multisites
 *
 * @package Skamstrupfestival
 *
 *
 * @link http://codex.wordpress.org/Plugin_API/Filter_Reference
 * @link http://codex.wordpress.org/Plugin_API/Action_Reference
 */

namespace Skamstrupfestival\Theme;

function multisite_body_classes( $classes ) {
	$id        = get_current_blog_id();
	$slug      = strtolower( str_replace( ' ', '-', sanitize_title( get_bloginfo( 'name' ) ) ) );
	$classes[] = $slug;
	$classes[] = 'site-id-' . $id;
	return $classes;
}

add_filter( 'body_class', __NAMESPACE__ . '\multisite_body_classes' );
